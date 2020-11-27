jQuery( function( $ ) {

	// initialize color pickers
	$( 'input.colorPicker' ).wpColorPicker();

	// selectionType: enable/disable tlds, checkAll, checkAllLabel
	if ( 'unlimited' == $( 'input[name="wp24_domaincheck[selectionType]"]:checked' ).val() ) {
		$( 'textarea[name="wp24_domaincheck[tlds]"]' ).prop( 'disabled', true );
		$( 'input[name="wp24_domaincheck[checkAll]"]' ).prop( 'disabled', true );
	}
	$( 'input[name="wp24_domaincheck[selectionType]"]' ).change( function() {
		var flag;
		flag = 'unlimited' == $( 'input[name="wp24_domaincheck[selectionType]"]:checked' ).val();
		$( 'textarea[name="wp24_domaincheck[tlds]"]' ).prop( 'disabled', flag );
		$( 'input[name="wp24_domaincheck[checkAll]"]' ).prop( 'disabled', flag );
		flag = 'freetext' == $( 'input[name="wp24_domaincheck[selectionType]"]:checked' ).val() ||
			'unlimited' == $( 'input[name="wp24_domaincheck[selectionType]"]:checked' ).val();
		$( 'input[name="wp24_domaincheck[checkAllLabel]"]' ).prop( 'disabled', flag );
	} );
	// checkAll: enable/disable checkAllLabel
	$( 'input[name="wp24_domaincheck[checkAll]"]' ).change( function() {
		if ( 'freetext' != $( 'input[name="wp24_domaincheck[selectionType]"]:checked' ).val() )
			$( 'input[name="wp24_domaincheck[checkAllLabel]"]' ).prop( 'disabled', ! this.checked );
	} );
	if ( ! $('input[name="wp24_domaincheck[checkAll]"]').prop('checked') ||
		'freetext' == $( 'input[name="wp24_domaincheck[selectionType]"]:checked' ).val() ||
		'unlimited' == $( 'input[name="wp24_domaincheck[selectionType]"]:checked' ).val() )
		$( 'input[name="wp24_domaincheck[checkAllLabel]"]' ).prop( 'disabled', true );
	// showWhois: enable/disable textWhois
	if ( ! $('input[name="wp24_domaincheck[showWhois]"]').prop('checked') )
		$( 'input[name="wp24_domaincheck[textWhois]"]' ).prop( 'disabled', true );
	$( 'input[name="wp24_domaincheck[showWhois]"]' ).change( function() {
		$( 'input[name="wp24_domaincheck[textWhois]"]' ).prop( 'disabled', ! this.checked );
	} );

	// priceEnabled: enable/disable priceDefault
	if ( ! $('input[name="wp24_domaincheck[priceEnabled]"]').prop('checked') )
		$( 'input[name="wp24_domaincheck[priceDefault]"]' ).prop( 'disabled', true );
	$( 'input[name="wp24_domaincheck[priceEnabled]"]' ).change( function() {
		$( 'input[name="wp24_domaincheck[priceDefault]"]' ).prop( 'disabled', ! this.checked );
	} );
	// linkEnabled: enable/disable linkDefault
	if ( ! $('input[name="wp24_domaincheck[linkEnabled]"]').prop('checked') )
		$( 'input[name="wp24_domaincheck[linkDefault]"]' ).prop( 'disabled', true );
	$( 'input[name="wp24_domaincheck[linkEnabled]"]' ).change( function() {
		$( 'input[name="wp24_domaincheck[linkDefault]"]' ).prop( 'disabled', ! this.checked );
	} );

	window.editTldPriceLink = function( tld, price, link ) {
		$('input[name="tld"]').val( tld );
		$('input[name="price"]').val( price );
		$('input[name="link"]').val( link );
	}

	// recaptcha: disable/enable options depending on type
	if ( 'none' == $( 'input[name="wp24_domaincheck[recaptcha][type]"]:checked' ).val() ) {
		$( 'input[name^="wp24_domaincheck[recaptcha]"]' ).prop( 'disabled', true );
		$( 'input[name="wp24_domaincheck[recaptcha][type]"]' ).prop( 'disabled', false );
	}
	if ( -1 !== ['v2_badge', 'v3'].indexOf( $( 'input[name="wp24_domaincheck[recaptcha][type]"]:checked' ).val() ) ) {
		// no size with recaptcha v2_badge/v3
		$( 'input[name="wp24_domaincheck[recaptcha][size]"]' ).prop( 'disabled', true );
	}
	if ( 'v2_check' == $( 'input[name="wp24_domaincheck[recaptcha][type]"]:checked' ).val() ) {
		// no position with recaptcha v2_check
		$( 'input[name="wp24_domaincheck[recaptcha][position]"]' ).prop( 'disabled', true );
	}
	if ( -1 !== ['v2_check', 'v2_badge'].indexOf( $( 'input[name="wp24_domaincheck[recaptcha][type]"]:checked' ).val() ) ) {
		// no score with recaptcha v2
		$( 'input[name="wp24_domaincheck[recaptcha][score]"]' ).prop( 'disabled', true );
	}
	$( 'input[name="wp24_domaincheck[recaptcha][type]"]' ).change( function() {
		var val = $( 'input[name="wp24_domaincheck[recaptcha][type]"]:checked' ).val();
		var flag = 'none' == val;
		
		$( 'input[name^="wp24_domaincheck[recaptcha]"]' ).prop( 'disabled', flag );
		$( 'input[name="wp24_domaincheck[recaptcha][type]"]' ).prop( 'disabled', false );

		if ( -1 !== ['v2_badge', 'v3'].indexOf( val ) ) {
			// no size with recaptcha v2_badge/v3
			$( 'input[name="wp24_domaincheck[recaptcha][size]"]' ).prop( 'disabled', true );
		}
		if ( 'v2_check' == val ) {
			// no position with recaptcha v2_check
			$( 'input[name="wp24_domaincheck[recaptcha][position]"]' ).prop( 'disabled', true );
		}
		if ( -1 !== ['v2_check', 'v2_badge'].indexOf( val ) ) {
			// no score with recaptcha v2
			$( 'input[name="wp24_domaincheck[recaptcha][score]"]' ).prop( 'disabled', true );
		}
	} );

} );