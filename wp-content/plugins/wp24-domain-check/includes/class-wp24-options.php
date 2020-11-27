<?php

/**
 * Class with (default) settings.
 */
class WP24_Domain_Check_Options {

	/**
	 * @var object Options instance.
	 */
	private static $instance = null;
	/**
	 * @var array Default options.
	 */
	private $options_default;

	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	private function __construct() {
		// init default options
		$this->options_default = array(
			'fieldLabel'			=> 'www.',
			'fieldPlaceholder'		=> __( 'desired-domain', 'wp24-domaincheck' ),
			'fieldWidth'			=> 250,
			'fieldUnit'				=> 'px',
			'selectionType'			=> 'dropdown',
			'tlds'					=> 'com, net, org, info, eu, tk, de, uk, nl, ru, br, fr, it, ca, pl',
			'checkAll'				=> true,
			'checkAllLabel'			=> __( 'all', 'wp24-domaincheck' ),
			'textButton'			=> __( 'check', 'wp24-domaincheck' ),
			'showWhois'				=> false,
			'textWhois'				=> __( 'whois', 'wp24-domaincheck' ),
			'textAvailable'			=> __( 'is available', 'wp24-domaincheck' ),
			'colorAvailable'		=> '#008b00',
			'textRegistered'		=> __( 'is registered', 'wp24-domaincheck' ),
			'colorRegistered'		=> '',
			'textError'				=> __( 'error', 'wp24-domaincheck' ),
			'colorError'			=> '#8c0000',
			'textInvalid'			=> __( 'is invalid', 'wp24-domaincheck' ),
			'colorInvalid'			=> '#8c0000',
			'textLimit'				=> __( 'query limit reached', 'wp24-domaincheck' ),
			'colorLimit'			=> '#ff8c00',
			'textWhoisserver'		=> __( 'whois server unknown', 'wp24-domaincheck' ),
			'colorWhoisserver'		=> '#8c0000',
			'textUnsupported'		=> __( '.[tld] is not supported', 'wp24-domaincheck' ),
			'colorUnsupported'		=> '#ff8c00',
			'textTldMissing'		=> __( 'Please enter a domain extension', 'wp24-domaincheck' ),
			'colorTldMissing'		=> '',
			'textEmptyField'		=> '',
			'colorEmptyField'		=> '',
			'priceEnabled'			=> false,
			'priceDefault'			=> '',
			'linkEnabled'			=> false,
			'linkDefault'			=> '',
			'textPurchase'			=> __( '[link]buy now[/link] for [price]', 'wp24-domaincheck' ),
			'multipleUse'			=> false,
			'removeWhoisComments'	=> false,
			'hooksEnabled'			=> false,
		);

		// recaptcha options
		$this->options_default['recaptcha'] = array(
			'type'		=> 'none',
			'siteKey'	=> '',
			'secretKey'	=> '',
			'theme'		=> 'light',
			'size'		=> 'normal',
			'position'	=> 'bottomright',
			'score'		=> 0.5,
			'text'		=> __( 'reCAPTCHA check failed', 'wp24-domaincheck' ),
			'color'		=> '#8c0000',
		);

		// query limit options
		$this->options_default['query_limits'] = array(
			'centralnic'	=> 60,
		);
	}

	private function __clone() {}
	private function __wakeup() {}

	/**
	 * Get options instance.
	 * 
	 * @return object Options instance.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new WP24_Domain_Check_Options();
		}
		return self::$instance;
	}

	/**
	 * Get Options.
	 * 
	 * @return array Options.
	 */
	public function get_options() {
		$options = get_option( 'wp24_domaincheck' );
		if ( '' === $options || ! is_array( $options ) )
			return $this->options_default;

		// merge options with defaults if single options missing
		return array_merge( $this->options_default, $options );
	}

}
