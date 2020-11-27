<?php

/**
 * Whois server list.
 */
include_once( 'class-whoisservers.php' );

/**
 * Class for performing whois queries.
 */
class Domaincheck {

	/**
	 * Query a whois server.
	 * 
	 * @param string $domain 
	 * @param string $tld 
	 * @param string $whoisserver 
	 * @return string Whois entry.
	 */
	private static function whois( $domain, $tld, $whoisserver ) {
		try {
			// use own error handler to handle also warnings in fsockopen
			set_error_handler( function ( $severity, $message, $file, $line ) {
				throw new ErrorException( $message, 0, $severity, $file, $line );
			});
	 		$fp = fsockopen( $whoisserver, 43, $errno, $errstr, 30 );
	 		// reset error handler function
			restore_error_handler();
			if ( ! $fp )
				return 'whois_query_error' . $errstr .' (' . $errno . ')';
			else {
				if ( 'de' != $tld && ! preg_match( '/^[a-zA-Z0-9-]*$/', $domain ) ) {
					// use idna class to encode idn domain
					require_once( 'class-idna-convert.php' );
					$idn = new idna_convert();
					$domain = $idn->encode( $domain );
				}
				if ( ! preg_match( '/^[a-zA-Z0-9\.]*$/', $tld ) ) {
					// use idna class to encode idn tld
					require_once( 'class-idna-convert.php' );
					$idn = new idna_convert();
					$tld = $idn->encode( $tld );
				}
				$flag = '';
				if ( 'de' == $tld )
					$flag = '-T dn ';
				fwrite( $fp, $flag . $domain . '.' . $tld . "\r\n" );
				$string = '';
				while( ! feof( $fp ) )
					$string .= fread( $fp, 128 );
				fclose( $fp );

				return trim( $string );
			}
 		} catch ( Exception $e ) {
			return 'whois_query_error' . $e->getMessage();
		} finally {
			// reset error handler function
			restore_error_handler();
		}
	}

	/**
	 * Query a rdap server.
	 * 
	 * @param string $domain 
	 * @param string $tld 
	 * @param string $rdapserver 
	 * @return array Whois entry.
	 */
	private static function rdap( $domain, $tld, $rdapserver ) {
		$array_result = array();

		$request_url = 'https://' . $rdapserver . '/domain/' . $domain . '.' . $tld;

		// get response and http status code
		if ( ini_get('allow_url_fopen') ) {
			$response = @file_get_contents( $request_url );
			if ( false === $response ) {
				// url not found or error
				if ( isset( $http_response_header[0] ) )
					$http_status_code = intval( substr( $http_response_header[0], 9, 3) );
				else {
					$headers = get_headers( $request_url );
					$http_status_code = intval( substr( $headers[0], 9, 3) );
				}
			}
		}
		else {
			// if allow_url_fopen=0 use curl
			$curl = curl_init();
			curl_setopt( $curl, CURLOPT_URL, $request_url );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			$response = curl_exec( $curl );
			$http_status_code = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
			if ( 200 != $http_status_code )
				$response = false;
			curl_close( $curl );
		}

		if ( false === $response ) {
			// request failed
			if ( 400 == $http_status_code ) {
				// bad request
				$array_result['status'] = 'invalid';
			}
			else if ( 404 == $http_status_code ) {
				// not found
				$array_result['status'] = 'available';
			}
			else {
				$array_result['status'] = 'error';
				$array_result['text'] = 'Error ' . $http_status_code;
			}
		}
		else {
			$json = json_decode( $response );

			// extract the whois data
			$string = 'Domain: ' . $json->ldhName . PHP_EOL;
			$string .= 'Status: ' . $json->status[0] . PHP_EOL;
			foreach ( $json->nameservers as $s )
				$string .= ucfirst( $s->objectClassName ) . ': ' . $s->ldhName . PHP_EOL;
			foreach ( $json->events as $s )
				$string .= ucfirst( $s->eventAction ) . ': ' . $s->eventDate . PHP_EOL;

			$array_result['status'] = 'registered';
			$array_result['text'] = $string;
		}

		return $array_result;
	}

	/**
	 * Evaluate whois query result.
	 * 
	 * @param string $domain 
	 * @param string $tld 
	 * @return array Registration status.
	 */
	public static function get_whois_result( $domain, $tld ) {
		$json_result = array();
		$json_result['domain'] = $domain;
		$json_result['tld'] = $tld;

		if ( ! preg_match( '/^[^_\.\/]{1,}$/', $domain ) )
			$json_result['status'] = 'invalid';
		else {
			$whoisserver = WP24_Domain_Check_Whoisservers::get_whoisserver( $tld );
			if ( ! $whoisserver )
				$json_result['status'] = 'whoisserver';
			else
			{
				if ( isset( $whoisserver['rdap'] ) ) {
					// use rdap (registration data access protocol)
					$rdap_result = self::rdap( $domain, $tld, $whoisserver['rdap'] );
					$json_result = array_merge( $json_result, $rdap_result );
				}
				else {
					// use whois (port 43)
					$string = self::whois( $domain, $tld, $whoisserver['host'] );
					if ( preg_match( '/whois_query_error/', $string ) ) {
						$json_result['status'] = 'error';
						$json_result['text'] = str_replace( 'whois_query_error', '', $string );
					}
					else {
						if ( preg_match( '/' . $whoisserver['free'] . '/i', preg_replace( '/\s\s+|\t/', ' ', $string ) ) )
							$json_result['status'] = 'available';
						else if ( preg_match( '/' . WP24_Domain_Check_Whoisservers::get_pattern_invalid() . '/i', preg_replace( '/\s\s+|\t/', ' ', $string ) ) )
							$json_result['status'] = 'invalid';
						else if ( preg_match( '/' . WP24_Domain_Check_Whoisservers::get_pattern_limit() . '/i', $string ) )
							$json_result['status'] = 'limit';
						else {
							$json_result['status'] = 'registered';
							$json_result['text'] = $string;
						}
					}
				}
			}
		}
		return $json_result;
	}

}
