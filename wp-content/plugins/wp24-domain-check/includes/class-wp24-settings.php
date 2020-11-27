<?php

/**
 * Class for changing settings (admin interface).
 */
class WP24_Domain_Check_Settings {

	/**
	 * @var array Options.
	 */
	private $options;

	/**
	 * @var array Selected TLDs.
	 */
	private $selected_tlds;

	/**
	 * @var array Limited TLDs.
	 */
	private $limited_tlds;

	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		$instance = WP24_Domain_Check_Options::get_instance();
		$this->options = $instance->get_options();

		// get selected tlds
		$this->selected_tlds = explode( ',', str_replace( ' ', '', $this->options['tlds'] ) );
		require_once( dirname( __DIR__ ) . '/assets/inc/class-whoisservers.php' );
		// get limited tlds
		$this->limited_tlds = array();
		foreach ( $this->selected_tlds as $tld ) {
			$whoisserver = WP24_Domain_Check_Whoisservers::get_whoisserver( $tld );
			if ( $whoisserver && isset( $whoisserver['limit_group'] ) )
				$this->limited_tlds[ $whoisserver['limit_group'] ][] = $tld;
		}
	}

	/**
	 * Init admin scripts, settings and menu.
	 * 
	 * @return void
	 */
	public function init() {
		add_action( 'plugins_loaded', array( $this, 'update_database' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'plugin_action_links_' . dirname( plugin_basename( __DIR__ ) ) . '/wp24-domain-check.php', array( $this, 'action_links' ) );
		add_action( 'admin_init', array( $this, 'init_settings' ) );
		add_action( 'admin_menu', array( $this, 'init_menu' ) );
	}

	/**
	 * Check database version and update if necessary.
	 * 
	 * @return void
	 */
	public function update_database() {
	    if ( ! isset( $this->options['database_version'] ) || 
	    	version_compare( $this->options['database_version'], WP24_DOMAIN_CHECK_DATABASE_VERSION ) == -1 ) {
	    	global $wpdb;

			$charset_collate = $wpdb->get_charset_collate();
			
			$table_name = $wpdb->prefix . 'wp24_whois_queries';
			$sql[] = "CREATE TABLE $table_name (
				id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				limit_group varchar(25) NOT NULL,
				query_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
				query_count smallint(5) DEFAULT 1 NOT NULL,
				PRIMARY KEY  (id)
			) $charset_collate;";

			$table_name = $wpdb->prefix . 'wp24_tld_prices_links';
			$sql[] = "CREATE TABLE $table_name (
				tld varchar(25) NOT NULL,
				price varchar(25),
				link text,
				PRIMARY KEY  (tld)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
        	
        	$this->options['database_version'] = WP24_DOMAIN_CHECK_DATABASE_VERSION;
        	update_option( 'wp24_domaincheck', $this->options );
    	}
	}

	/**
	 * Enqueue scripts and styles.
	 * 
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		wp_enqueue_script(
			'admin',
			plugins_url( 'assets/js/admin.js', dirname( __FILE__ ) ),
			array( 'jquery' ),
			WP24_DOMAIN_CHECK_VERSION,
			true
		);
	}

	/**
	 * Add plugin links.
	 * 
	 * @param array $links 
	 * @return array New link array.
	 */
	public function action_links( $links ) {
		$links[] = '<a href="'. esc_url( get_admin_url( NULL, 'options-general.php?page=wp24_domaincheck_settings' ) ) .'">' . __( 'Settings', 'wp24-domaincheck' ) . '</a>';
	
		return $links;
	}

	/**
	 * Init settings.
	 * 
	 * @return void
	 */
	public function init_settings() {
		// register setting and validate function
		register_setting( 'wp24_domaincheck', 'wp24_domaincheck', array( $this, 'validate' ) );

		/*
		 * general settings
		 */
		// field
		add_settings_section( 'section_general_field', __( 'Domain Name Field', 'wp24-domaincheck' ), '', 'settings_general' );
		// fieldLabel
		add_settings_field(
			'fieldLabel',
			__( 'Label', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_field',
			array(
				'name' => 'fieldLabel',
				'type' => 'textfield',
			)
		);
		// fieldPlaceholder
		add_settings_field(
			'fieldPlaceholder',
			__( 'Placeholder', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_field',
			array(
				'name' => 'fieldPlaceholder',
				'type' => 'textfield',
			)
		);
		// textfieldWidth / textfieldUnit
		add_settings_field(
			'fieldWidth_fieldUnit',
			__( 'Width', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_general',
			'section_general_field',
			array(
				array( 'name' => 'fieldWidth', 'type' => 'numberfield' ),
				array(
					'name' => 'fieldUnit',
					'type' => 'combobox',
					'vals' => array(
						'px'	=> __( 'Pixel' , 'wp24-domaincheck' ),
						'%'		=> __( 'Percent' , 'wp24-domaincheck' ),
					),
				)
			)
		);

		// tld
		add_settings_section( 'section_general_tld', __( 'Top-Level Domain (TLD) Input', 'wp24-domaincheck' ), '', 'settings_general' );
		// selection type
		add_settings_field(
			'selectionType',
			__( 'Selection Type', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_tld',
			array(
				'name' => 'selectionType',
				'type' => 'radiobuttons',
				'vals' => array(
					'dropdown'	=> __( 'Drop-Down List' , 'wp24-domaincheck' ) .
						' <span class="description">(' . __( 'Select the TLD from predefinded list, only TLDs listed below allowed' , 'wp24-domaincheck' ) . ')</span>',
					'freetext'	=> __( 'Free Text Limited' , 'wp24-domaincheck' ) .
						' <span class="description">(' . __( 'Type the TLD into domain name field, only TLDs listed below allowed' , 'wp24-domaincheck' ) . ')</span>',
					'unlimited'	=> __( 'Free Text Unlimited' , 'wp24-domaincheck' ) .
						' <span class="description">(' . __( 'Type the TLD into domain name field, all available TLDs allowed' , 'wp24-domaincheck' ) . ')</span>',
				),
			)
		);
		// tlds
		add_settings_field(
			'tlds',
			__( 'TLDs', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_tld',
			array(
				'name' => 'tlds',
				'type' => 'textarea',
				'desc' => __( 'Comma separated list of testable TLDs without leading point.', 'wp24-domaincheck' ),
			)
		);
		// checkAll
		add_settings_field(
			'checkAll',
			__( 'Check All', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_tld',
			array(
				'name'	=> 'checkAll',
				'type'	=> 'checkbox',
				'label'	=> __( 'Allow to check all testable TLDs simultaneously.', 'wp24-domaincheck' ),
			)
		);
		// checkAllLabel
		add_settings_field(
			'checkAllLabel',
			__( 'Check All Label', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_tld',
			array(
				'name' => 'checkAllLabel',
				'type' => 'textfield',
				'desc' => __( 'Label of option in drop-down list.', 'wp24-domaincheck' ),
			)
		);
		// button
		add_settings_section( 'section_general_button', __( 'Check Button', 'wp24-domaincheck' ), '', 'settings_general' );
		// textButton
		add_settings_field(
			'textButton',
			__( 'Label', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_button',
			array(
				'name' => 'textButton',
				'type' => 'textfield',
			)
		);

		// result
		add_settings_section( 'section_general_result', __( 'Result Settings', 'wp24-domaincheck' ), '', 'settings_general' );
		// showWhois
		add_settings_field(
			'showWhois',
			__( 'Whois Link', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_result',
			array(
				'name'	=> 'showWhois',
				'type'	=> 'checkbox',
				'label'	=> __( 'Show a link to open detailed whois information if the domain is registered.', 'wp24-domaincheck' ),
				'desc'	=> count( $this->limited_tlds ) > 0 ? __( 'Deactivation is recommended when using TLDs with query limit.', 'wp24-domaincheck' ) : '',
			)
		);
		// textWhois
		add_settings_field(
			'textWhois',
			__( 'Whois Link Label', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_result',
			array(
				'name' => 'textWhois',
				'type' => 'textfield',
			)
		);

		if ( count( $this->limited_tlds ) > 0 ) {
			// query limits
			add_settings_section( 'section_general_query_limits', __( 'Query limits', 'wp24-domaincheck' ), '', 'settings_general' );
			
			if ( isset( $this->limited_tlds['centralnic'] ) ) {
				// centralnic settings
				add_settings_field(
					'query_limits_centralnic',
					'CentralNic',
					array( $this, 'inputfield' ),
					'settings_general',
					'section_general_query_limits',
					array(
						'name'		=> 'query_limits',
						'subname'	=> 'centralnic',
						'type'		=> 'combobox',
						'vals' => array(
							60		=> __( '60 queries per hour (untrusted source)' , 'wp24-domaincheck' ),
							7200	=> __( '7,200 queries per hour (trusted source)' , 'wp24-domaincheck' ),
						),
						'desc'		=> __( 'Due to technical conditions, this plugin cannot guarantee to 100% that the query limit will not be exceeded.', 'wp24-domaincheck' ) . '<br>' . 
							__( 'See', 'wp24-domaincheck' ) . ': <a href="https://registrar-console.centralnic.com/pub/whois_guidance">' . 
							'https://registrar-console.centralnic.com/pub/whois_guidance</a><br>' . 
							__( 'Affected TLDs', 'wp24-domaincheck' ) . ' (' . count( $this->limited_tlds['centralnic'] ) . '): ' . 
							implode( ', ', $this->limited_tlds['centralnic'] ),
					)
				);
			}
		}

		// developer
		add_settings_section( 'section_general_developer', __( 'Developer Settings', 'wp24-domaincheck' ), '', 'settings_general' );
		// multipleUse
		add_settings_field(
			'multipleUse',
			__( 'Multiple use', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_developer',
			array(
				'name'	=> 'multipleUse',
				'type'	=> 'checkbox',
				'desc'	=> __( 'Activate when using multiple shortcodes on one page.<br>(Could cause problems when using caching or compression.)', 'wp24-domaincheck' ),
			)
		);
		// removeWhoisComments
		add_settings_field(
			'removeWhoisComments',
			__( 'Whois Comments', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_developer',
			array(
				'name'	=> 'removeWhoisComments',
				'type'	=> 'checkbox',
				'label'	=> __( 'Remove comments (starting with %) from whois information.', 'wp24-domaincheck' ),
			)
		);
		// hooksEnabled
		add_settings_field(
			'hooksEnabled',
			__( 'Enable Hooks', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_general',
			'section_general_developer',
			array(
				'name'	=> 'hooksEnabled',
				'type'	=> 'checkbox',
				'desc'	=> __( 'See', 'wp24-domaincheck' ) . ': <a href="https://wp24.org/plugins/domain-check/hooks.html">' . 
					'https://wp24.org/plugins/domain-check/hooks.html</a>',
			)
		);

		/*
		 * text and color settings
		 */
		add_settings_section( 'section_texts_colors', '', '', 'settings_texts_colors' );
		// textAvailable / colorAvailable
		add_settings_field(
			'textAvailable_colorAvailable',
			__( 'Available', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_texts_colors',
			'section_texts_colors',
			array(
				array( 'name' => 'textAvailable', 'type' => 'textfield' ),
				array( 'name' => 'colorAvailable', 'type' => 'colorfield' ),
			)
		);
		// textRegistered / colorRegistered
		add_settings_field(
			'textRegistered_colorRegistered',
			__( 'Registered', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_texts_colors',
			'section_texts_colors',
			array(
				array( 'name' => 'textRegistered', 'type' => 'textfield' ),
				array( 'name' => 'colorRegistered', 'type' => 'colorfield' ),
			)
		);
		// textError / colorError
		add_settings_field(
			'textError_colorError',
			__( 'Error', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_texts_colors',
			'section_texts_colors',
			array(
				array( 'name' => 'textError', 'type' => 'textfield' ),
				array( 'name' => 'colorError', 'type' => 'colorfield' ),
			)
		);
		// textInvalid / colorInvalid
		add_settings_field(
			'textInvalid_colorInvalid',
			__( 'Invalid', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_texts_colors',
			'section_texts_colors',
			array(
				array( 'name' => 'textInvalid', 'type' => 'textfield' ),
				array( 'name' => 'colorInvalid', 'type' => 'colorfield' ),
			)
		);
		// textLimit / colorLimit
		add_settings_field(
			'textLimit_colorLimit',
			__( 'Limit', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_texts_colors',
			'section_texts_colors',
			array(
				array( 'name' => 'textLimit', 'type' => 'textfield' ),
				array(
					'name' => 'colorLimit',
					'type' => 'colorfield',
					'desc' => __( 'Some whois servers have an access control limit to prevent excessive use,<br>so the number of queries per network and time interval is limited.', 'wp24-domaincheck' ),
				),
			)
		);
		// textUnsupported / colorUnsupported
		add_settings_field(
			'textUnsupported_colorUnsupported',
			__( 'Unsupported', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_texts_colors',
			'section_texts_colors',
			array(
				array( 'name' => 'textUnsupported', 'type' => 'textfield' ),
				array(
					'name' => 'colorUnsupported',
					'type' => 'colorfield',
					'desc' => __( 'Only needed if selection type is free text input.<br>Use <strong>[tld]</strong> as placeholder for the TLD.', 'wp24-domaincheck' ),
				),
			)
		);
		// textTldMissing / colorTldMissing
		add_settings_field(
			'textTldMissing_colorTldMissing',
			__( 'TLD Missing', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_texts_colors',
			'section_texts_colors',
			array(
				array( 'name' => 'textTldMissing', 'type' => 'textfield' ),
				array(
					'name' => 'colorTldMissing',
					'type' => 'colorfield',
					'desc' => __( 'Only needed if selection type is free text input and check all is disabled.', 'wp24-domaincheck' ),
				),
			)
		);
		// textWhoisserver / colorWhoisserver
		add_settings_field(
			'textWhoisserver_colorWhoisserver',
			__( 'Whois Server Unknown', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_texts_colors',
			'section_texts_colors',
			array(
				array( 'name' => 'textWhoisserver', 'type' => 'textfield' ),
				array( 'name' => 'colorWhoisserver', 'type' => 'colorfield' ),
			)
		);
		// textEmptyField / colorEmptyField
		add_settings_field(
			'textEmptyField_colorEmptyField',
			__( 'No Input', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_texts_colors',
			'section_texts_colors',
			array(
				array( 'name' => 'textEmptyField', 'type' => 'textfield' ),
				array(
					'name' => 'colorEmptyField',
					'type' => 'colorfield',
					'desc' => __( 'Leave empty to use browser specific "Please fill out this field" message.', 'wp24-domaincheck' ),
				),
			)
		);

		/*
		 * prices and links settings
		 */
		add_settings_section( 'section_prices_links', '', '', 'settings_prices_links' );
		// priceEnabled
		add_settings_field(
			'priceEnabled',
			__( 'Enable Prices', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_prices_links',
			'section_prices_links',
			array(
				'name'	=> 'priceEnabled',
				'type'	=> 'checkbox',
			)
		);
		// default price
		add_settings_field(
			'priceDefault',
			__( 'Default Price', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_prices_links',
			'section_prices_links',
			array(
				'name' => 'priceDefault',
				'type' => 'textfield',
			)
		);
		// linkEnabled
		add_settings_field(
			'linkEnabled',
			__( 'Enable Purchase Links', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_prices_links',
			'section_prices_links',
			array(
				'name'	=> 'linkEnabled',
				'type'	=> 'checkbox',
			)
		);
		// default link
		add_settings_field(
			'linkDefault',
			__( 'Default Purchase Link', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_prices_links',
			'section_prices_links',
			array(
				'name' => 'linkDefault',
				'type' => 'textfield',
				'desc' => __( 'Use <strong>[domain]</strong> as placeholder for the domain name and <strong>[tld]</strong> as placeholder for the TLD.', 'wp24-domaincheck' ),
			)
		);
		// purchase text
		add_settings_field(
			'textPurchase',
			__( 'Purchase Text', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_prices_links',
			'section_prices_links',
			array(
				'name' => 'textPurchase',
				'type' => 'textfield',
				'desc' => __( 'Use <strong>[price]</strong> as placeholder for the price and <strong>[link]</strong>linktext<strong>[/link]</strong> as placeholder for the link.', 'wp24-domaincheck' ),
			)
		);

		/*
		 * recaptcha settings
		 */
		add_settings_section( 'section_recaptcha', '', '', 'settings_recaptcha' );
		// type
		add_settings_field(
			'recaptcha_type',
			__( 'Type', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_recaptcha',
			'section_recaptcha',
			array(
				'name'		=> 'recaptcha',
				'subname'	=> 'type',
				'type'		=> 'radiobuttons',
				'desc'		=> __( 'See', 'wp24-domaincheck' ) . ': <a href="https://developers.google.com/recaptcha/docs/versions">https://developers.google.com/recaptcha/docs/versions</a>',
				'vals'		=> array(
					'none'		=> __( 'None' , 'wp24-domaincheck' ),
					'v2_check'	=> __( 'Version 2 ("I\'m not a robot" Checkbox)' , 'wp24-domaincheck' ),
					'v2_badge'	=> __( 'Version 2 (Invisible badge)' , 'wp24-domaincheck' ),
					'v3'		=> __( 'Version 3' , 'wp24-domaincheck' ),
				),
			)
		);
		// site key
		add_settings_field(
			'recaptcha_siteKey',
			__( 'Site Key', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_recaptcha',
			'section_recaptcha',
			array(
				'name'		=> 'recaptcha',
				'subname'	=> 'siteKey',
				'type'		=> 'textfield',
			)
		);
		// secret key
		add_settings_field(
			'recaptcha_secretKey',
			__( 'Secret Key', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_recaptcha',
			'section_recaptcha',
			array(
				'name'		=> 'recaptcha',
				'subname'	=> 'secretKey',
				'type'		=> 'textfield',
			)
		);
		// theme
		add_settings_field(
			'recaptcha_theme',
			__( 'Theme', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_recaptcha',
			'section_recaptcha',
			array(
				'name'		=> 'recaptcha',
				'subname'	=> 'theme',
				'type'		=> 'radiobuttons',
				'vals'		=> array(
					'light'	=> __( 'Light', 'wp24-domaincheck' ),
					'dark'	=> __( 'Dark', 'wp24-domaincheck' ),
				),
			)
		);
		// size
		add_settings_field(
			'recaptcha_size',
			__( 'Size', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_recaptcha',
			'section_recaptcha',
			array(
				'name'		=> 'recaptcha',
				'subname'	=> 'size',
				'type'		=> 'radiobuttons',
				'vals'		=> array(
					'normal'	=> __( 'Normal', 'wp24-domaincheck' ),
					'compact'	=> __( 'Compact', 'wp24-domaincheck' ),
				),
			)
		);
		// position
		add_settings_field(
			'recaptcha_position',
			__( 'Position', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_recaptcha',
			'section_recaptcha',
			array(
				'name'		=> 'recaptcha',
				'subname'	=> 'position',
				'type'		=> 'radiobuttons',
				'vals'		=> array(
					'bottomright'	=> __( 'Bottom right', 'wp24-domaincheck' ),
					'bottomleft'	=> __( 'Bottom left', 'wp24-domaincheck' ),
				),
			)
		);
		// score
		add_settings_field(
			'recaptcha_score',
			__( 'Score', 'wp24-domaincheck' ),
			array( $this, 'inputfield' ),
			'settings_recaptcha',
			'section_recaptcha',
			array(
				'name'		=> 'recaptcha',
				'subname'	=> 'score',
				'type'		=> 'numberfield',
				'max'		=> 1,
				'step'		=> 0.1,
				'desc'		=> __( 'Cancel request if score is lower than this value.<br>(1.0 is very likely a good interaction, 0.0 is very likely a bot.)', 'wp24-domaincheck' ),
			)
		);
		// textRecaptcha / colorRecaptcha
		add_settings_field(
			'recaptcha_text_recaptcha_color',
			__( 'Text / Color', 'wp24-domaincheck' ),
			array( $this, 'compositefield' ),
			'settings_recaptcha',
			'section_recaptcha',
			array(
				array(
					'name'		=> 'recaptcha',
					'subname'	=> 'text',
					'type'		=> 'textfield'
				),
				array(
					'name'		=> 'recaptcha',
					'subname'	=> 'color',
					'type'		=> 'colorfield',
					'desc'		=> __( 'Text and color for message in case of failed check.', 'wp24-domaincheck' ),
				),
			)
		);
	}

	/**
	 * Init settings menu.
	 * 
	 * @return void
	 */
	public function init_menu() {
		add_options_page(
			'WP24 Domain Check ' . __( 'Settings', 'wp24-domaincheck' ),
			'WP24 Domain Check',
			'manage_options',
			'wp24_domaincheck_settings',
			array( $this, 'get_html' )
		);
	}

	/**
	 * Generate html for setting pages.
	 * 
	 * @return void
	 */
	public function get_html() {
		if ( ! current_user_can( 'manage_options' ) )
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'wp24-domaincheck' ) );

		// organize settings in tabs
		$tabs = array();
		$tabs['general'] = __( 'General', 'wp24-domaincheck' );
		$tabs['texts_colors'] = __( 'Texts &amp; Colors', 'wp24-domaincheck' );
		$tabs['prices_links'] = __( 'Prices &amp; Purchase Links', 'wp24-domaincheck' );
		$tabs['whoisservers'] = __( 'Whois Servers', 'wp24-domaincheck' );
		$tabs['recaptcha'] = __( 'reCAPTCHA', 'wp24-domaincheck' );
		$tabs['about'] = __( 'About', 'wp24-domaincheck' );
		$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';

		echo '<div class="wrap">';
		echo '<h1>' . esc_html( get_admin_page_title() ) . '</h1>';

		if ( isset( $_GET['settings-updated'] ) && 'general' == $active_tab && isset( $this->limited_tlds['centralnic'] ) ) {
			// info about query limited domains
			echo '<div class="notice notice-info is-dismissible"><p>';
			printf(
				__( '%1$s TLDs have a query limit: %2$s.', 'wp24-domaincheck' ),
				count( $this->limited_tlds['centralnic'] ),
				implode( ', ', $this->limited_tlds['centralnic'] )
			);
			echo '<br>';
			printf(
				__( 'Only %1$s queries per hour overall are possible for those domains.', 'wp24-domaincheck' ),
				$this->options['query_limits']['centralnic']
			);
			echo '<br>' . __( 'See', 'wp24-domaincheck' );
			echo ': <a href="https://registrar-console.centralnic.com/pub/whois_guidance">https://registrar-console.centralnic.com/pub/whois_guidance</a>';
			echo '</p></div>';

			// warning for trusted sources
			if ( $this->options['query_limits']['centralnic'] == 7200 ) {
				echo '<div class="notice notice-warning is-dismissible"><p>';
				printf(
					__( 'CentralNic %1$strusted sources%2$s are those that are present on the access list of a registrar!', 'wp24-domaincheck' ),
					'<strong>',
					'</strong>'
				);
				echo '</p></div>';
			}
		}

		// tab navigation
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $tabs as $tab => $label ) {
			$url = admin_url( 'options-general.php?page=wp24_domaincheck_settings&tab=' . $tab );
			$active = $tab == $active_tab ? ' nav-tab-active' : '';
			echo '<a href="' . $url . '" class="nav-tab' . $active . '">' . $label . '</a>';
		}
		echo '</h2>';
		// tab pages
		switch ( $active_tab ) {
			case 'general':
				echo '<h2>Shortcode</h2>';
				echo '<p>';
				echo __( 'Simply insert this shortcode <code>[wp24_domaincheck]</code> into any post or page to display the domain check.', 'wp24-domaincheck' );
				echo '<br>';
				echo __( 'Use <code>[wp24_domaincheck mode="whois"]</code> to directly show the whois data.', 'wp24-domaincheck' );
				echo '</p>';
				echo '<form action="options.php" method="post">';
				settings_fields( 'wp24_domaincheck' );
				do_settings_sections( 'settings_general' );
				submit_button();
				echo '</form>';
				break;
			case 'texts_colors':
				echo '<p>' . __( 'Text and colors for the different statuses returned by domain checks.', 'wp24-domaincheck' ) . '</p>';
				echo '<form action="options.php" method="post">';
				settings_fields( 'wp24_domaincheck' );
				do_settings_sections( 'settings_texts_colors' );
				submit_button();
				echo '</form>';
				break;
			case 'prices_links':
				$this->prices_links();
				break;
			case 'whoisservers':
				$this->whoisservers();
				break;
			case 'recaptcha':
				echo '<form action="options.php" method="post">';
				settings_fields( 'wp24_domaincheck' );
				do_settings_sections( 'settings_recaptcha' );
				submit_button();
				echo '</form>';
				break;
			case 'about':
				$this->about();
				break;
		}
		echo '</div>';
	}

	/**
	 * Generate html for input fields.
	 * 
	 * @param array $args 
	 * @return void
	 */
	public function inputfield( $args ) {
		// get inputfield properties
		$name = $args['name'];
		$subname = isset( $args['subname'] ) ? $args['subname'] : '';
		$type = $args['type'];
		$desc = isset( $args['desc'] ) ? $args['desc'] : '';
		if ( '' !== $subname ) {
			$value = isset( $this->options[ $name ][ $subname ] ) ? $this->options[ $name ][ $subname ] : NULL;
			$subname = '[' . $subname . ']';
		}
		else
			$value = isset( $this->options[ $name ] ) ? $this->options[ $name ] : $this->options_default[ $name ];
		$fieldname = 'wp24_domaincheck[' . $name . ']' . $subname;

		switch ( $type ) {
			case 'textfield':
				echo '<input type="text" name="' . $fieldname . '" value="' . $value . '" class="regular-text">';
				break;
			case 'textarea':
				echo '<textarea name="' . $fieldname . '" rows="3" cols="50">' . $value . '</textarea>';
				break;
			case 'checkbox':
				$label = isset( $args['label'] ) ? $args['label'] : '';

				echo '<label for="wp24_domaincheck[' . $name . ']">';
				echo '<input type="checkbox" name="' . $fieldname . '" id="wp24_domaincheck[' . $name . ']" value="1" ' . checked( $value, 1, false ) . '>';
				echo '' != $label ? ' ' . $label : '';
				echo '</label>';
				break;
			case 'radiobuttons':
				$vals = isset( $args['vals'] ) ? $args['vals'] : '';
				foreach ( $vals as $val => $label ) {
					echo '<p>';
					echo '<input type="radio" name="' . $fieldname . '" id="' . $name . '_' . $val . '" value="' . $val . '" ' . checked( $value, $val, false ) . '>';
					echo '<label for="' . $name . '_' . $val . '">' . $label . '</label>';
					echo '</p>';
				}
				break;
			case 'combobox':
				$vals = isset( $args['vals'] ) ? $args['vals'] : '';
				echo '<select name="' . $fieldname . '" style="vertical-align: baseline">';
				foreach ( $vals as $val => $label ) {
					echo '<option value="' . $val . '"' . selected( $value, $val, false ) . '>' . $label . '</option>';
				}
				echo '</select>';
				break;
			case 'numberfield':
				$max = isset( $args['max'] ) ? ' max="' . $args['max'] . '"' : '';
				$step = isset( $args['step'] ) ? ' step="' . $args['step'] . '"' : '';

				echo '<input type="number" name="' . $fieldname . '" value="' . $value . '" min="0"' . $max . $step . ' class="small-text">';
				break;
			case 'colorfield':
				echo '<p><input type="text" name="' . $fieldname . '" value="' . $value . '" class="colorPicker"></p>';
				break;
		}

		// description text below the field
		if ( ! empty( $desc ) )
			echo '<p class="description">' . $desc . '</p>';
	}

	/**
	 * Combination of two input fields.
	 * 
	 * @param array $args 
	 * @return void
	 */
	public function compositefield( $args ) {
		foreach ( $args as $inputfield ) {
			$this->inputfield( $inputfield );
		}
	}

	/**
	 * Validate settings before saving.
	 * 
	 * @param array $input 
	 * @return array New Options.
	 */
	public function validate( $input ) {
		require_once( dirname( __DIR__ ) . '/assets/inc/class-whoisservers.php' );

		if ( ! isset( $input ) )
			$input = array();

		// iterate options input
		foreach ( $input as $key => $val ) {
			if ( in_array( $key, array( 'checkAll', 'showWhois', 'multipleUse', 'removeWhoisComments', 'hooksEnabled', 'priceEnabled', 'linkEnabled' ) ) )
				continue;

			if ( 'tlds' == $key ) {
				$unsupported_tlds = array();
				// clean up input string
				$val = strtolower( trim( $this->sanitize_string( $val ), ',' ) );
				// remove leading points
				$val = implode( ', ', array_map( function( $s ) { return trim( $s, '.' ); }, explode( ',', str_replace( ' ', '', $val ) ) ) );
				// check if a whois server exists for every tld
				$tlds = explode( ',', str_replace( ' ', '', $val ) );
				foreach ( $tlds as $tld ) {
					$whoisserver = WP24_Domain_Check_Whoisservers::get_whoisserver( $tld );
					if ( ! $whoisserver )
						$unsupported_tlds[] = $tld;
				}
				if ( empty( trim( $val ) ) )
					add_settings_error( 'tlds', esc_attr( 'settings_error' ), __( 'no TLDs set', 'wp24-domaincheck' ) );
				else if ( ! empty( $unsupported_tlds ) )
					add_settings_error( 'tlds', esc_attr( 'settings_error' ), implode( ', ', $unsupported_tlds ) . ' ' . __( 'not supported', 'wp24-domaincheck' ) );

				$this->options[ $key ] = $val;
				continue;
			}

			if ( is_array( $val ) ) {
				// options contains subname (multidimensional array)
				foreach ( $val as $key_sub => $val_sub ) {
					$this->options[ $key ][ $key_sub ] = ( isset( $input[ $key ][ $key_sub ] ) ) ? $this->sanitize_string( $val_sub ) : '';
				}
			}
			else {
				$val = ( isset( $input[ $key ] ) ) ? $val : '';
				if ( 'color' == substr( $key, 0, 5 ) )
					$val = sanitize_hex_color( $val );
				else
					$val = $this->sanitize_string( $val );
				$this->options[ $key ] = $val;
			}
		}

		// submit the checkbox fields always
		if ( isset( $input['selectionType'] ) ) {
			$this->options['checkAll'] = isset( $input['checkAll'] );
			$this->options['showWhois'] = isset( $input['showWhois'] );
			$this->options['multipleUse'] = isset( $input['multipleUse'] );
			$this->options['removeWhoisComments'] = isset( $input['removeWhoisComments'] );
			$this->options['hooksEnabled'] = isset( $input['hooksEnabled'] );
		}
		else if ( isset( $_POST['update_prices_links'] ) ) {
			$this->options['priceEnabled'] = isset( $input['priceEnabled'] );
			$this->options['linkEnabled'] = isset( $input['linkEnabled'] );
		}

		return $this->options;
	}

	/**
	 * Replace illegal chars from string.
	 * 
	 * @param string $string 
	 * @return string Clean string.
	 */
	private function sanitize_string( $string ) {
		return preg_replace( "/[\']/", '', sanitize_text_field( $string ) );
	}

	/**
	 * Prices and links page.
	 * 
	 * @return void
	 */
	private function prices_links() {
		global $wpdb;

		// settings
		echo '<h2 class="title">' . __( 'Settings', 'wp24-domaincheck' ) . '</h2>';
		echo '<form action="options.php" method="post">';
		// flag for validate function
		echo '<input type="hidden" name="update_prices_links" value="1">';
		settings_fields( 'wp24_domaincheck' );
		do_settings_sections( 'settings_prices_links' );
		submit_button();
		echo '</form>';

		if ( ! $this->options['priceEnabled'] && ! $this->options['linkEnabled'] )
			return;

		// save tld
		if ( isset( $_POST['tld'] ) && '' != $_POST['tld'] ) {
			if ( '' != trim( $_POST['price'] ) || '' != trim( $_POST['link'] ) ) {
				$wpdb->replace( $wpdb->prefix . 'wp24_tld_prices_links', array(
					'tld' => strtolower( $_POST['tld'] ),
					'price' => isset( $_POST['price'] ) ? $_POST['price'] : '',
					'link' => isset( $_POST['link'] ) ? $_POST['link'] : '',
				) );
			}
			else
				$wpdb->delete( $wpdb->prefix . 'wp24_tld_prices_links', array( 'tld' => $_POST['tld'] ) );
		}

		echo '<h2 class="title">' . __( 'TLDs', 'wp24-domaincheck' ) . '</h2>';
		echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">';
		echo '<table class="wp-list-table widefat striped">';
		echo '<thead><tr>';
		echo '<th>' . __( 'TLD', 'wp24-domaincheck' ) . '</th>';
		if ( $this->options['priceEnabled'] )
			echo '<th>' . __( 'Price', 'wp24-domaincheck' ) . '</th>';
		if ( $this->options['linkEnabled'] )
			echo '<th>' . __( 'Purchase Link', 'wp24-domaincheck' ) . '</th>';
		echo '<th>&nbsp;</th>';
		echo '</tr></thead>';

		// edit tld
		echo '<tr>';
		echo '<td><input type="text" required name="tld" readonly></td>';
		if ( $this->options['priceEnabled'] ) {
			echo '<td>';
			echo '<input type="text" name="price" maxlength="25">';
			echo '<p class="description">' . __( 'Leave empty to use default price.', 'wp24-domaincheck' ) . '</p>';
			echo '</td>';
		}
		if ( $this->options['linkEnabled'] ) {
			echo '<td>';
			echo '<input type="text" class="regular-text" name="link">';
			echo '<p class="description">' . __( 'Leave empty to use default purchase link.', 'wp24-domaincheck' ) . '<br>' . __( 'Use <strong>[domain]</strong> as placeholder for the domain name.', 'wp24-domaincheck' ) . '</p>';
			echo '</td>';
		}
		echo '<td><input type="submit" class="button button-primary" value="' . __( 'Save', 'wp24-domaincheck' ) . '"></td>';
		echo '</tr>';

		// list tlds
		$rows = $wpdb->get_results( "SELECT tld, price, link FROM {$wpdb->prefix}wp24_tld_prices_links", OBJECT_K );
		foreach ( $this->selected_tlds as $tld ) {
			$row = isset( $rows[ $tld ] ) ? $rows[ $tld ] : (object) array( 'price' => '', 'link' => '' );
			$price = empty( $row->price ) ? $this->options['priceDefault'] : $row->price;
			$link = empty( $row->link ) ? $this->options['linkDefault'] : $row->link;
			$link = str_replace( '[tld]', $tld, $link );

			echo '<tr>';
			echo '<td><strong>' . $tld . '</strong></td>';
			if ( $this->options['priceEnabled'] )
				echo '<td>' . ( empty( $price ) ? '<span class="dashicons dashicons-warning"></span>' : $price ) . '</td>';
			if ( $this->options['linkEnabled'] )
				echo '<td>' . ( empty( $link ) ? '<span class="dashicons dashicons-warning"></span>' : $link ) . '</td>';
			echo '<td><a href="javascript: void(0);" onclick="editTldPriceLink(\'' . $tld . '\', \'' . $price . '\', \'' . $link . '\'); return false;">' . __( 'Edit', 'wp24-domaincheck' ) . '</a></td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '</form>';
	}

	/**
	 * Whois server page.
	 * 
	 * @return void
	 */
	private function whoisservers() {
		require_once( dirname( __DIR__ ) . '/assets/inc/class-whoisservers.php' );
		$whoisservers = WP24_Domain_Check_Whoisservers::get_whoisservers();

		echo '<table class="form-table">';
		echo '<tr><th>' . __( 'Number Of Servers / TLDs', 'wp24-domaincheck' ) . '</th><td>' . count( $whoisservers ) . '</td></tr>';
		echo '</table>';

		// tld search
		$tld_search = isset( $_POST['tld_search'] ) ? strtolower( $_POST['tld_search'] ) : '';
		echo '<h2 class="title">' . __( 'Find', 'wp24-domaincheck' ) . '</h2>';
		echo '<p>' . __( 'Enter the desired TLD and check if there is an appropriate server.', 'wp24-domaincheck' ) . '</p>';
		echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">';
		echo '<table class="form-table">';
		echo '<tr>';
		echo '<th>' . __( 'TLD', 'wp24-domaincheck' ) . '</th>';
		echo '<td>';
		echo '<input type="text" placeholder="com" required pattern="([a-zA-Z0-9-]{2,})(\.[a-zA-Z0-9]{2,})?$" name="tld_search" value="' . $tld_search . '">';
		echo '&nbsp;';
		echo '<input type="submit" class="button button-primary" value="' . __( 'Search', 'wp24-domaincheck' ) . '">';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '</form>';
		if ( ! empty( $tld_search ) ) {
			// search results
			echo '<p>' . __( 'Results with', 'wp24-domaincheck') . ' <strong>' . $tld_search . '</strong>:</p>';
			$matches = '';
			$match_count = 0;
			foreach ( $whoisservers as $tld => $whoisserver) {
				if ( $tld_search == $tld ) {
					$matches .= '<span style="color: #0a0; font-weight: bold">' . $tld . ' (' . $whoisserver['host'] . ')</span><br>';
					$match_count++;
				}
				else if ( preg_match( '/.*' . $tld_search . '.*/', $tld ) ) {
					$matches .= $tld . ' (' . $whoisserver['host'] . ')<br>';
					$match_count++;
				}
			}
			echo '<p>' . $match_count . ' ' . __( 'TLDs', 'wp24-domaincheck' ) . '</p>';
			echo $matches;
		}
		echo '<p><em>' . __( 'If a TLD is missing or the query returns erroneous results, feel free to contact us.', 'wp24-domaincheck' ) . '</em></p>';
	}

	/**
	 * About page.
	 * 
	 * @return void
	 */
	private function about() {
		// versions informations
		echo '<table class="form-table">';
		echo '<tr><th>WP24 Domain Check</th><td>' . WP24_DOMAIN_CHECK_VERSION . '</td></tr>';
		echo '<tr><th>' . __( 'Database', 'wp24-domaincheck' ) . '</th><td>' . WP24_DOMAIN_CHECK_DATABASE_VERSION . '</td></tr>';
		echo '</table>';
		echo '<h2 class="title">' . __( 'System', 'wp24-domaincheck' ) . '</h2>';
		echo '<table class="form-table">';
		echo '<tr><th>WordPress</th><td>' . $GLOBALS['wp_version'] . '</td></tr>';
		echo '<tr><th>PHP</th><td>' . phpversion() . '</td></tr>';
		echo '</table>';

		// support
		echo '<h2 class="title">' . __( 'Support', 'wp24-domaincheck' ) . '</h2>';
		echo '<table class="form-table">';
		echo '<tr><th>' . __( 'Forum', 'wp24-domaincheck' ) . '</th><td><a href="https://wordpress.org/support/plugin/wp24-domain-check">https://wordpress.org/support/plugin/wp24-domain-check</a></td></tr>';
		echo '</table>';
		
		// server requirements for whois queries
		echo '<h2 class="title">' . __( 'Requirements for whois queries', 'wp24-domaincheck' ) . '</h2>';
		echo '<table class="form-table">';
		if ( function_exists( 'fsockopen' ) )
			echo '<tr><th>fsockopen</th><td><span style="color: #0a0">' . __( 'Enabled', 'wp24-domaincheck' ) . '</span></td></tr>';
		else
			echo '<tr><th>fsockopen</th><td><span style="color: #a00">' . __( 'Disabled', 'wp24-domaincheck' ) . '</span><p class="description">' . __( 'PHP function "fsockopen" must be enabled by your hosting provider.', 'wp24-domaincheck' ) . '</p></td></tr>';
		if ( @fsockopen( 'whois.denic.de', 43, $errno, $errstr, 5 ) )
			echo '<tr><th>Port 43</th><td><span style="color: #0a0">' . __( 'Open', 'wp24-domaincheck' ) . '</span></td></tr>';
		else
			echo '<tr><th>Port 43</th><td><span style="color: #a00">' . __( 'Locked', 'wp24-domaincheck' ) . '</span><p class="description">' . __( 'Port 43 must be unlocked by your hosting provider.', 'wp24-domaincheck' ) . '</p></td></tr>';
		echo '</table>';

		// server requirements for rdap queries
		echo '<h2 class="title">' . __( 'Requirements for RDAP queries', 'wp24-domaincheck' ) . '</h2>';
		echo '<table class="form-table">';
		if ( ini_get('allow_url_fopen') )
			echo '<tr><th>allow_url_fopen</th><td><span style="color: #0a0">' . __( 'Enabled', 'wp24-domaincheck' ) . '</span></td></tr>';
		else if ( function_exists('curl_init') )
			echo '<tr><th>allow_url_fopen</th><td><span style="color: #fa0">' . __( 'Disabled', 'wp24-domaincheck' ) . '</span><p class="description">' . __( 'Using cURL as fallback.', 'wp24-domaincheck' ) . '</p></td></tr>';
		else
			echo '<tr><th>allow_url_fopen</th><td><span style="color: #a00">' . __( 'Disabled', 'wp24-domaincheck' ) . '</span></td></tr>';
		if ( function_exists('curl_init') )
			echo '<tr><th>cURL</th><td><span style="color: #0a0">' . __( 'Enabled', 'wp24-domaincheck' ) . '</span></td></tr>';
		else if ( ini_get('allow_url_fopen') )
			echo '<tr><th>cURL</th><td><span style="color: #fa0">' . __( 'Disabled', 'wp24-domaincheck' ) . '</span><p class="description">' . __( 'allow_url_fopen is enabled.', 'wp24-domaincheck' ) . '</p></td></tr>';
		else
			echo '<tr><th>cURL</th><td><span style="color: #a00">' . __( 'Disabled', 'wp24-domaincheck' ) . '</span></td></tr>';
		echo '</table>';
		
		// server requirements for recaptcha
		echo '<h2 class="title">' . __( 'Requirements for reCAPTCHA', 'wp24-domaincheck' ) . '</h2>';
		echo '<table class="form-table">';
		if ( ini_get('allow_url_fopen') )
			echo '<tr><th>allow_url_fopen</th><td><span style="color: #0a0">' . __( 'Enabled', 'wp24-domaincheck' ) . '</span></td></tr>';
		else if ( function_exists('curl_init') )
			echo '<tr><th>allow_url_fopen</th><td><span style="color: #fa0">' . __( 'Disabled', 'wp24-domaincheck' ) . '</span><p class="description">' . __( 'Using cURL as fallback.', 'wp24-domaincheck' ) . '</p></td></tr>';
		else
			echo '<tr><th>allow_url_fopen</th><td><span style="color: #a00">' . __( 'Disabled', 'wp24-domaincheck' ) . '</span></td></tr>';
		if ( function_exists('curl_init') )
			echo '<tr><th>cURL</th><td><span style="color: #0a0">' . __( 'Enabled', 'wp24-domaincheck' ) . '</span></td></tr>';
		else if ( ini_get('allow_url_fopen') )
			echo '<tr><th>cURL</th><td><span style="color: #fa0">' . __( 'Disabled', 'wp24-domaincheck' ) . '</span><p class="description">' . __( 'allow_url_fopen is enabled.', 'wp24-domaincheck' ) . '</p></td></tr>';
		else
			echo '<tr><th>cURL</th><td><span style="color: #a00">' . __( 'Disabled', 'wp24-domaincheck' ) . '</span></td></tr>';
		echo '</table>';
	}

	/**
	 * Uninstall plugin.
	 * 
	 * @return void
	 */
	public function uninstall() {
		global $wpdb;

		// drop tables
		$table_name = $wpdb->prefix . 'wp24_whois_queries';
	    $sql = "DROP TABLE IF EXISTS $table_name";
	    $wpdb->query( $sql );
	    $table_name = $wpdb->prefix . 'wp24_tld_prices_links';
	    $sql = "DROP TABLE IF EXISTS $table_name";
	    $wpdb->query( $sql );		
		
		// delete all settings
		delete_option( 'wp24_domaincheck' );
	}

}
