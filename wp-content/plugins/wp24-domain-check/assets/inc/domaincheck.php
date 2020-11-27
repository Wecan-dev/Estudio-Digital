<?php

/**
 * Include class Domaincheck to perform whois query.
 */
include_once( 'class-domaincheck.php' );
include_once( 'class-whoisservers.php' );

header( 'Content-Type: application/json' );

$post_domain = strip_tags( trim( $_POST['domain'] ) );
$post_tld = strip_tags( trim( $_POST['tld'] ) );
$hooks_enabled = isset( $_POST['hooks'] ) && boolval( $_POST['hooks'] );

// load minimum of wordpress
if ( ! $hooks_enabled )
	define( 'SHORTINIT', true );
// require wp-load.php to get options
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
// get options
$options = get_option( 'wp24_domaincheck' );
// get database object
global $wpdb;

/*
 * recaptcha
 */
if ( '' === $options || ! is_array( $options ) || ! isset( $options['recaptcha'] ) ) {
	// if no (recaptcha) options available set type to none
	$options = array(
		'recaptcha' => array(
			'type' => 'none',
		)
	);
}

if ( 'none' != $options['recaptcha']['type'] ) {
	$recaptcha = strip_tags( trim( $_POST['recaptcha'] ) );
	$recaptcha_error = false;
	if ( ! isset( $recaptcha ) || empty( $recaptcha ) )
		$recaptcha_error = true;
	else
	{
		if ( ini_get('allow_url_fopen') ) {
			$response = file_get_contents( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $options['recaptcha']['secretKey'] . '&response=' . $recaptcha );
		}
		else
		{
			// if allow_url_fopen=0 use curl
			$data = [
				'secret'	=> $options['recaptcha']['secretKey'],
				'response'	=> $recaptcha,
			];

			$curl = curl_init();

			curl_setopt( $curl, CURLOPT_POST, true );
			curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify' );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( $data ) );

			$response = curl_exec( $curl );

			curl_close( $curl );
		}
		$response_json = json_decode( $response, true );

		if ( ! $response_json['success'] )
			$recaptcha_error = true;

		if (
			'v3' == $options['recaptcha']['type'] &&
			(
				empty( $response_json['action'] ) ||
				'wp24_domaincheck' != $response_json['action'] ||
				$response_json['score'] < $options['recaptcha']['score']
			)
		)
			$recaptcha_error = true;

		// allow timeout-or-duplicate error on check all
		if (
			$options['checkAll'] && ! empty( $response_json['error-codes'] ) &&
			in_array( 'timeout-or-duplicate', $response_json['error-codes'] )
		)
			$recaptcha_error = false;
	}

	if ( $recaptcha_error ) {
		echo json_encode( array(
			'domain'	=> $post_domain,
			'tld'		=> $post_tld,
			'status'	=> 'recaptcha',
		) );
		exit();
	}
}

/*
 * rate limited whois services
 */
$whoisserver = WP24_Domain_Check_Whoisservers::get_whoisserver( $post_tld );
if ( isset( $whoisserver['limit_group'] ) ) {
	// if no whois information should be shown, do a quick check
	if ( ! $options['showWhois'] && gethostbyname( $post_domain . '.' . $post_tld . '.' ) != $post_domain . '.' . $post_tld . '.' ) {
		// there is a IPv4 address corresponding to the host name
		$json_result = array();
		$json_result['domain'] = $post_domain;
		$json_result['tld'] = $post_tld;
		$json_result['status'] = 'registered';
		
		echo json_encode( $json_result );
		exit();
	}

	if ( '' === $options || ! is_array( $options ) || ! isset( $options['query_limits'] ) ) {
		// if query limits option is missing add it
		$options = array(
			'query_limits' => array(
				'centralnic' => 60,
			)
		);
	}

	// set default query limit to 60 queries per hour
	if ( ! isset( $options['query_limits'][ $whoisserver['limit_group'] ] ) )
		$options['query_limits'][ $whoisserver['limit_group'] ] = 60;

	// delete expired entries and get query count
	$wpdb->query( "DELETE FROM {$wpdb->prefix}wp24_whois_queries WHERE query_time < (CURRENT_TIMESTAMP - INTERVAL 60 MINUTE)" );
	$query_count = $wpdb->get_var( "SELECT COALESCE(SUM(query_count), 0) FROM {$wpdb->prefix}wp24_whois_queries" );

	if ( $query_count >= $options['query_limits'][ $whoisserver['limit_group'] ] ) {
		// query limit reached
		$json_result = array();
		$json_result['domain'] = $post_domain;
		$json_result['tld'] = $post_tld;
		$json_result['status'] = 'limit';

		echo json_encode( $json_result );
		exit();
	}
}

$json_data = Domaincheck::get_whois_result( $post_domain, $post_tld );

if ( isset( $whoisserver['limit_group'] ) ) {
	if ( 'limit' == $json_data['status'] ) {
		// query limit exceeded, increment query count to maximum
		$wpdb->insert( $wpdb->prefix . 'wp24_whois_queries', array(
			'limit_group' => $whoisserver['limit_group'],
			'query_count' => $options['query_limits'][ $whoisserver['limit_group'] ] - $query_count
		) );
	}
	else {
		// increment query count by one
		$wpdb->insert( $wpdb->prefix . 'wp24_whois_queries', array( 'limit_group' => $whoisserver['limit_group'] ) );
	}
}

if ( $options['priceEnabled'] || $options['linkEnabled'] ) {
	$row = $wpdb->get_row( "SELECT price, link FROM {$wpdb->prefix}wp24_tld_prices_links WHERE tld = '" . $json_data['tld'] . '\'' );
	$json_data['price'] = empty( $row->price ) ? $options['priceDefault'] : $row->price;
	$json_data['link'] = empty( $row->link ) ? $options['linkDefault'] : $row->link;

	if ( $hooks_enabled )
	    $json_data = apply_filters( 'wp24_domaincheck_whois_result', $json_data );
}

if ( $options['removeWhoisComments'] && isset( $json_data['text'] ) )
	$json_data['text'] = preg_replace( '/%.*\n*/', '', $json_data['text'] );

echo json_encode( $json_data, JSON_INVALID_UTF8_IGNORE );
