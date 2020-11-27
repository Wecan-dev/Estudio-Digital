jQuery( function( $ ) {

	var whoisTexts = new Array();
 
 	/**
 	 * Class to init client side javascript and html.
 	 */
	$.fn.wp24_domain_check = function( settings ) {
		// append id to use domaincheck multiple times
		var id = settings.id;
		var recaptchaId;
		
		// show modal window with whois information
		window.showWhoisInfo = function( id, tld ) {
			$( '#whois-info' ).remove();
			var whoisInfo = $(
				'<div id="whois-info" class="whois-info">' +
				'<pre>' + whoisTexts[ id ][ tld ] + '</pre>' +
				'</div>'
			);
			whoisInfo.appendTo(document.body);
			$( '#whois-info' ).modal();
		}

		// disable check all and whois link in whois mode
		if ( 'whois' == settings.mode ) {
			settings.checkAll = false;
			settings.showWhois = false;
		}

		// html form
		var htmlForm = '';
		htmlForm += '<form action="#" method="post" id="dc-form-' + id + '">';
		htmlForm += '<div>';
		if ( '' !== settings.fieldLabel )
			htmlForm += '<span>' + settings.fieldLabel + '&nbsp;</span>';
		switch ( settings.selectionType ) {
			case 'dropdown':
				// textfield for domain and select for tld
				htmlForm += '<input type="text" placeholder="' + settings.fieldPlaceholder + '" style="width: ' + settings.fieldWidth + '"' +
					( '' == settings.textEmptyField.trim() ? ' required' : '' ) + ' pattern="^[^_\.\/\<\>]{1,}$" id="dc-domain-' + id + '">';
				htmlForm += '<span class="dot">.</span>';
				htmlForm += '<select id="dc-tld-' + id + '">';		
				$.each ( settings.tlds.split( ',' ), function( index, item ) {
					htmlForm += '<option value="' + $.trim( item ) + '"' + 
						( 0 == index ? ' selected' : '' ) + '>' + $.trim( item ) + '</option>';
				});
				if ( settings.checkAll ) {
					htmlForm += '<option disabled>-----</option>';
					htmlForm += '<option value="all">' + settings.checkAllLabel + '</option>';
				}
				htmlForm += '</select>';
				break;
			case 'freetext':
			case 'unlimited':
				// textfield for domain and tld
				htmlForm += '<input type="text" placeholder="' + settings.fieldPlaceholder + '" style="width: ' + settings.fieldWidth + '"' +
					( '' == settings.textEmptyField.trim() ? ' required' : '' ) +
					' pattern="^[^_\.\/\<\>]{1,}(\.[a-zA-Z0-9-]{2,})?(\.[a-zA-Z0-9]{2,})?$" id="dc-domain-' + id + '">';
				break;
		}
		htmlForm += '<input type="submit" value="' + settings.textButton + '" id="dc-submit-' + id + '">';
		htmlForm += '</div>';

		// recaptcha
		if ( ! settings.recaptcha ) {
			settings.recaptcha = {
				type: 'none'
			};
		}
		switch ( settings.recaptcha.type ) {
			case 'v2_check':
				htmlForm += '<br>';
				htmlForm +=
					'<div class="g-recaptcha" ' +
					'data-sitekey="' + settings.recaptcha.siteKey + '" ' +
					'data-theme="' + settings.recaptcha.theme + '" ' +
					'data-size="' + settings.recaptcha.size + '"' +
					'></div>';
				break;
			case 'v2_badge':
				htmlForm +=
					'<div class="g-recaptcha" ' +
					'data-sitekey="' + settings.recaptcha.siteKey + '" ' +
					'data-theme="' + settings.recaptcha.theme + '" ' +
					'data-size="invisible" ' +
					'data-badge="' + settings.recaptcha.position + '" ' +
					'data-callback="onFormSubmit"' +
					'></div>';

					window.onFormSubmit = function ( token ) {
						formSubmit();
					}
				break;
			case 'v3':
				htmlForm += '<div id="g-recaptcha"></div>';
				grecaptcha.ready( function() {
					recaptchaId = grecaptcha.render( 'g-recaptcha', {
						'sitekey': settings.recaptcha.siteKey,
						'theme': settings.recaptcha.theme,
						'size': 'invisible',
						'badge': settings.recaptcha.position,
					} ) ;
				} );
				break;
		}

		htmlForm += '</form><br>';
		htmlForm += '<div id="dc-result-' + id + '"></div>';
		this.html( htmlForm );
		
		// submit button
		$( '#dc-form-' + id ).on( 'submit', function( e ) {
			e.preventDefault();

			// custom empty field message
			if ( '' === $( '#dc-domain-' + id ).val().replace( / /g, '' ) && '' != settings.textEmptyField.trim() ) {
				$( '#dc-result-' + id ).empty();
				$( '#dc-result-' + id ).addClass( 'empty-field' );
				$( '#dc-result-' + id ).html( '<span>' + settings.textEmptyField + '</span>' );
				if ( '' != settings.colorEmptyField )
					$( '#dc-result-' + id + ' span' ).css( 'color', settings.colorEmptyField );
				return;
			}

			if ( 'v2_badge' == settings.recaptcha.type ) {
				grecaptcha.execute();
				return;
			}
			else if ( 'v3' == settings.recaptcha.type ) {
				grecaptcha.execute( recaptchaId, { action: 'wp24_domaincheck' } ).then( function( token ) {
					formSubmit( token );
				});
				return;
			}

			formSubmit();
		} );

		function formSubmit( e ) {
			// disable button for 2 seconds
			var btn = $( '#dc-submit-' + id );
			btn.prop( 'disabled', true );
			btn.css( 'cursor', 'wait' );
			window.setTimeout( function() {
				btn.prop( 'disabled', false );
				btn.css( 'cursor', 'pointer' );
			}, 2000 );

			$( ':focus' ).blur();
			$( '#dc-result-' + id ).empty();
			
			var domain;
			var tld;
			switch ( settings.selectionType ) {
				case 'dropdown':
					domain = $( '#dc-domain-' + id ).val().replace( / /g, '' ).toLowerCase();
					tld = $( '#dc-tld-' + id ).val().replace( / /g, '' ).toLowerCase();
					break;
				case 'freetext':
					var domainTld = $( '#dc-domain-' + id ).val().replace( / /g, '' ).toLowerCase();
					domain = domainTld.split( '.', 1 )[0];
					tld = domainTld.slice( domain.length + 1 );

					// if no tld is specified check all testable tlds
					if ( '' === tld && settings.checkAll ) {
						tld = 'all';
						break;
					}
					else if ( '' === tld ) {
						$( '#dc-result-' + id ).empty();
						$( '#dc-result-' + id ).html( '<span>' + settings.textTldMissing + '</span>' );
						if ( '' != settings.colorTldMissing )
							$( '#dc-result-' + id + ' span' ).css( 'color', settings.colorTldMissing );
						return;
					}

					// check if tld is supported
					var supportedTlds = settings.tlds.split( ',' ).map( function( item ) {
						return item.trim();
					});
					if ( -1 == supportedTlds.indexOf( tld ) ) {
						$( '#dc-result-' + id ).empty();
						$( '#dc-result-' + id ).html( '<span>' + settings.textUnsupported.replace( '[tld]', tld ) + '</span>' );
						if ( '' != settings.colorUnsupported )
							$( '#dc-result-' + id + ' span' ).css( 'color', settings.colorUnsupported );
						return;
					}
					break;
				case 'unlimited':
					var domainTld = $( '#dc-domain-' + id ).val().replace( / /g, '' ).toLowerCase();
					domain = domainTld.split( '.', 1 )[0];
					tld = domainTld.slice( domain.length + 1 );

					if ( '' === tld ) {
						$( '#dc-result-' + id ).empty();
						$( '#dc-result-' + id ).html( '<span>' + settings.textTldMissing + '</span>' );
						if ( '' != settings.colorTldMissing )
							$( '#dc-result-' + id + ' span' ).css( 'color', settings.colorTldMissing );
						return;
					}
					break;
			}
			
			var tlds = [ tld ];
			if ( 'all' == tld )
				tlds = $.map( settings.tlds.split( ',' ), $.trim );
			
			// build table with placeholders for the query results
			var htmlResult = '';
			htmlResult += '<div class="table">';
			$.each ( tlds, function( index, item ) {
				htmlResult += '<div class="table-row">';
				htmlResult += '<div class="table-cell table-cell-domain">' + domain + '.<strong>' + item + '</strong></div>';
				htmlResult += '<div class="table-cell table-cell-status dc-tld-' + id + '-' + item.replace( '.', '' ) + '">' +
					'<img src="' + settings.path + 'assets/images/loading.gif"></div>';
				if ( settings.showWhois )
					htmlResult += '<div class="table-cell table-cell-whois dc-tld-' + id + '-' + item.replace( '.', '' ) + '-whois"></div>';
				htmlResult += '<br>';
				htmlResult += '</div>';
			});
			htmlResult += '</div>';
			if ( 'whois' == settings.mode )
				htmlResult += '<div id="whois-info-' + id + '" class="whois-info-inline"></div>';
			$( '#dc-result-' + id ).html( htmlResult );

			// recaptcha
			var recaptcha = '';
			if ( -1 !== ['v2_check', 'v2_badge'].indexOf( settings.recaptcha.type ) ) {
				recaptcha = grecaptcha.getResponse();
				grecaptcha.reset();
			}
			else if ( 'v3' == settings.recaptcha.type )
				recaptcha = e;

			$.each( tlds, function( index, item ) {
				var data = {
					domain: domain,
					tld: item,
					recaptcha: recaptcha,
					hooks: settings.hooksEnabled ? 1 : 0
				}

				// execute whois query as ajax request
				$.ajax( {
					url: settings.path + 'assets/inc/domaincheck.php',
					method: 'post',
					data: data,
					dataType: 'json',
					success: function( response ) {
						if ( ! response ) {
							// request did not provide a response
							var tld = /.*tld=([a-z]+)&.*/.exec( this.data )[1];
							var classname = '.dc-tld-' + id + '-' + tld;

							$( classname ).html( settings.textError );
							if ( '' != settings.colorError )
								$( classname ).css( 'color', settings.colorError );
							$( classname ).parent().addClass( 'error' );

							return;
						}

						// set result text and color depending on whois status
						var classname = '.dc-tld-' + id + '-' + response.tld.replace( '.', '' );
						switch ( response.status ) {
							case 'error':
								$( classname ).html( settings.textError );
								if ( '' != settings.colorError )
									$( classname ).css( 'color', settings.colorError );
								break;
							case 'invalid':
								$( classname ).html( settings.textInvalid );
								if ( '' != settings.colorInvalid )
									$( classname ).css( 'color', settings.colorInvalid );
								break;
							case 'limit':
								$( classname ).html( settings.textLimit );
								if ( '' != settings.colorLimit )
									$( classname ).css( 'color', settings.colorLimit );
								break;
							case 'whoisserver':
								if ( 'unlimited' == settings.selectionType ) {
									// show unsupported message with unlimited selection type
									$( '.table-cell-domain').empty();
									$( classname ).html( settings.textUnsupported.replace( '[tld]', response.tld ) );
									if ( '' != settings.colorUnsupported )
										$( classname ).css( 'color', settings.colorUnsupported );
								}
								else {
									$( classname ).html( settings.textWhoisserver );
									if ( '' != settings.colorError )
										$( classname ).css( 'color', settings.colorError );
								}
								break;
							case 'registered':
								$( classname ).html( settings.textRegistered );
								if ( '' != settings.colorRegistered )
									$( classname ).css( 'color', settings.colorRegistered );
								break;
							case 'available':
								$( classname ).html( settings.textAvailable );
								if ( '' != settings.colorAvailable )
									$( classname ).css( 'color', settings.colorAvailable );

								// add price and purchase link
								if ( ( settings.priceEnabled && '' != response.price ) || ( settings.linkEnabled && '' != response.link ) ) {
									var textPurchase = '<div class="table-cell table-cell-purchase">' + settings.textPurchase + '</div>';
									if ( settings.priceEnabled && '' != response.price )
										textPurchase = textPurchase.replace( '[price]', response.price );
									else
										textPurchase = textPurchase.replace( '[price]', '' );
									if ( settings.linkEnabled && '' != response.link ) {
										var link = response.link.replace( '[domain]', response.domain ).replace( '[tld]', response.tld );
										textPurchase = textPurchase.replace( '[link]', '<a href="' + link + '">' );
										textPurchase = textPurchase.replace( '[/link]', '</a>' );
									}
									else {
										textPurchase = textPurchase.replace( '[link]', '' );
										textPurchase = textPurchase.replace( '[/link]', '' );
									}
									$( classname ).after( textPurchase );
								}

								break;
							case 'recaptcha':
								$( '#dc-result-' + id ).empty();
								$( '#dc-result-' + id ).html( '<span>' + settings.recaptcha.text + '</span>' );
								if ( '' != settings.recaptcha.color )
									$( '#dc-result-' + id + ' span' ).css( 'color', settings.recaptcha.color );
								break;
						}
						$( classname ).parent().addClass( response.status );

						if ( settings.showWhois && '' != $.trim( response.text ) ) {
							$( classname + '-whois' ).html( '(<a href="javascript: void(0);" ' + 
								'onclick="showWhoisInfo(\'' + id + '\', \'' + response.tld + '\'); return false;">' + settings.textWhois + '</a>)' );
							if ( ! whoisTexts[ id ] )
								whoisTexts[ id ] = new Array();
							whoisTexts[ id ][ response.tld ] = response.text;
						}
						else if ( 'whois' == settings.mode && '' != $.trim( response.text ) ) {
							$( '#whois-info-' + id ).html( '<pre>' + response.text + '</pre>' );
						}
					},
					error: function ( jqXHR, textStatus, errorThrown ) {
						// ajax request failed
						var tld = /.*tld=([a-z]+)&.*/.exec( this.data )[1];
						var classname = '.dc-tld-' + id + '-' + tld;
						$( classname ).html( settings.textError );
						if ( '' != settings.colorError )
							$( classname ).css( 'color', settings.colorError );
						$( classname ).parent().addClass( 'error' );
					}
				} );
			} );
		}
	};

} );