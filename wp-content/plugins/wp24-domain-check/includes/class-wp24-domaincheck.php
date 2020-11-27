<?php

/**
 * Class to output js, css and html.
 */
class WP24_Domain_Check {

	/**
	 * @var array Domain Check Settings.
	 */
	private $options;

	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		$instance = WP24_Domain_Check_Options::get_instance();
		$this->options = $instance->get_options();
	}

	/**
	 * Init shortcode and js script
	 * @return void
	 */
	public function init() {
		add_shortcode( 'wp24_domaincheck', array( $this, 'shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Register js script.
	 * 
	 * @return void
	 */
	public function enqueue_scripts() {
		// default js file path
		$js_file_path = plugins_url( 'assets/js/domaincheck.js', dirname( __FILE__ ) );

		// check for js file override in theme
		if ( file_exists( get_stylesheet_directory() . '/wp24-domain-check/assets/js/domaincheck.js' ) )
			$js_file_path = get_stylesheet_directory_uri() . '/wp24-domain-check/assets/js/domaincheck.js';

		// just register the scripts, enqueue in shortcode
		wp_register_script(
			'domaincheck',
			$js_file_path,
			array( 'jquery' ),
			WP24_DOMAIN_CHECK_VERSION,
			true
		);
	}

	/**
	 * Shortcode execution.
	 * 
	 * @param array $atts 
	 * @param string $content 
	 * @param string $tag 
	 * @return string html code (div).
	 */
	public function shortcode( $atts = [], $content = NULL, $tag = '' ) {
		// normalize attribute keys, lowercase
		$atts = array_change_key_case( (array)$atts, CASE_LOWER );
		// override default attributes with user attributes
		$atts = shortcode_atts( [
			'id'	=> $this->options['multipleUse'] ? uniqid() : '1',
			'mode'	=> 'check',
			'addjs'	=> 1,
		], $atts, $tag );
		// id to use shortcode multiple times (accept only alphanumeric characters)
		$id = preg_replace( '/[^a-z0-9]/i', '', $atts['id'] );

		// recaptcha
		if ( in_array( $this->options['recaptcha']['type'], array( 'v2_check', 'v2_badge' ) ) ) {
			// add "async defer" to recaptcha script tag
			add_filter(
				'script_loader_tag',
				function( $tag, $handle ) {
					if ( 'recaptcha' !== $handle )
						return $tag;
					return str_replace( '></', ' async defer></', $tag );
				},
				10,
				2
			);
			wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js', '', NULL );
		}
		if ( 'v3' == $this->options['recaptcha']['type'] ) {
			wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js?render=explicit', '', NULL );
		}

		// enqueue scripts only when shortcode is used
		wp_enqueue_script( 'domaincheck' );
		$js = 
			"jQuery( function( $ ) {\n".
			"  $( '#wp24-dc-" . $id . "' ).wp24_domain_check( {\n";
		$js .=
			"    id: '" . $id . "',\n".
			"    mode: '" . $atts['mode'] . "',\n".
			"    path: '" . plugins_url( '/', dirname( __FILE__ ) ) . "',\n".
			"    fieldLabel: '" . $this->options['fieldLabel'] . "',\n".
			"    fieldPlaceholder: '" . $this->options['fieldPlaceholder'] . "',\n".
			"    fieldWidth: '" . intval( $this->options['fieldWidth'] ) . $this->options['fieldUnit'] . "',\n".
			"    selectionType: '" . $this->options['selectionType'] . "',\n".
			"    tlds: '" . $this->options['tlds'] . "',\n".
			"    checkAll: " . ( $this->options['checkAll'] ? "true" : "false" ) . ",\n".
			"    checkAllLabel: '" . $this->options['checkAllLabel'] . "',\n".
			"    textButton: '" . $this->options['textButton'] . "',\n".
			"    showWhois: " . ( $this->options['showWhois'] ? "true" : "false" ) . ",\n".
			"    textWhois: '" . $this->options['textWhois'] . "',\n".
			"    textAvailable: '" . $this->options['textAvailable'] . "',\n".
			"    colorAvailable: '" . $this->options['colorAvailable'] . "',\n".
			"    textRegistered: '" . $this->options['textRegistered'] . "',\n".
			"    colorRegistered: '" . $this->options['colorRegistered'] . "',\n".
			"    textError: '" . $this->options['textError'] . "',\n".
			"    colorError: '" . $this->options['colorError'] . "',\n".
			"    textInvalid: '" . $this->options['textInvalid'] . "',\n".
			"    colorInvalid: '" . $this->options['colorInvalid'] . "',\n".
			"    textLimit: '" . $this->options['textLimit'] . "',\n".
			"    colorLimit: '" . $this->options['colorLimit'] . "',\n".
			"    textWhoisserver: '" . $this->options['textWhoisserver'] . "',\n".
			"    colorWhoisserver: '" . $this->options['colorWhoisserver'] . "',\n".
			"    textUnsupported: '" . $this->options['textUnsupported'] . "',\n".
			"    colorUnsupported: '" . $this->options['colorUnsupported'] . "',\n".
			"    textTldMissing: '" . $this->options['textTldMissing'] . "',\n".
			"    colorTldMissing: '" . $this->options['colorTldMissing'] . "',\n".
			"    textEmptyField: '" . $this->options['textEmptyField'] . "',\n".
			"    colorEmptyField: '" . $this->options['colorEmptyField'] . "',\n".
			"    priceEnabled: " . ( $this->options['priceEnabled'] ? "true" : "false" ) . ",\n".
			"    linkEnabled: " . ( $this->options['linkEnabled'] ? "true" : "false" ) . ",\n".
			"    textPurchase: '" . $this->options['textPurchase'] . "',\n".
			"    hooksEnabled: " . ( $this->options['hooksEnabled'] ? "true" : "false" ) . ",\n";
		if ( 'none' != $this->options['recaptcha']['type'] ) {
			$js .=
				"    recaptcha: {\n".
				"      type: '" . $this->options['recaptcha']['type'] . "',\n".
				"      siteKey: '" . $this->options['recaptcha']['siteKey'] . "',\n".
				"      theme: '" . $this->options['recaptcha']['theme'] . "',\n".
				"      size: '" . $this->options['recaptcha']['size'] . "',\n".
				"      position: '" . $this->options['recaptcha']['position'] . "',\n".
				"      text: '" . $this->options['recaptcha']['text'] . "',\n".
				"      color: '" . $this->options['recaptcha']['color'] . "',\n".
				"    }\n";
		}
		else {
			$js .=
				"    recaptcha: {\n".
				"      type: '" . $this->options['recaptcha']['type'] . "',\n".
				"    }\n";
		}

		$js .=
			"  } );\n".
			"} );";
		// compress js code a little bit
		$js = preg_replace( '/\s\s+|\n|\t/', '', $js );
		if ( boolval( $atts['addjs'] ) )
			wp_add_inline_script( 'domaincheck', $js );

		// add style
		wp_enqueue_style(
			'domaincheck',
			plugins_url( 'assets/css/domaincheck.css', dirname( __FILE__ ) ),
			'',
			WP24_DOMAIN_CHECK_VERSION
		);

		// enqueue script and style for modal window
		if ( $this->options['showWhois'] ) {
			wp_enqueue_script(
				'jquery-modal',
				plugins_url( 'assets/js/jquery-modal.min.js', dirname( __FILE__ ) ),
				'',
				'0.9.2'
			);
			wp_enqueue_style(
				'jquery-modal',
				plugins_url( 'assets/css/jquery-modal.min.css', dirname( __FILE__ ) ),
				'',
				'0.9.2'
			);
		}

		return '<div id="wp24-dc-' . $id . '" class="wp24-dc"></div>';
	}

}
