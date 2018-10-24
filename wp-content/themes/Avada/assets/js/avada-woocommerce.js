function fusionResizeCrossfadeImages( $parent ) {
	var $parentHeight = $parent.height();

	$parent.find( 'img' ).each( function() {
		var $imgHeight = jQuery( this ).height();

		if ( $imgHeight < $parentHeight ) {
			jQuery( this ).css( 'margin-top', ( ( $parentHeight - $imgHeight ) / 2 )  + 'px' );
		}
	});
}

function fusionResizeCrossfadaImagesContainer( $container ) {
	var $biggestHeight = 0;

	$container.find( 'img' ).each( function() {
		var $imgHeight = jQuery( this ).height();

		if ( $imgHeight > $biggestHeight ) {
			$biggestHeight = $imgHeight;
		}
	});

	$container.css( 'height', $biggestHeight );
}

function fusionCalcWoocommerceTabsLayout( $tabSelector ) {
	jQuery( $tabSelector ).each( function() {
		var $menuWidth     = jQuery( this ).parent().width(),
		    $menuItems     = jQuery( this ).find( 'li' ).length,
		    $mod           = $menuWidth % $menuItems,
		    $itemWidth     = ( $menuWidth - $mod ) / $menuItems,
		    $lastItemWidth = $menuWidth - $itemWidth * ( $menuItems - 1 );

		jQuery( this ).css( 'width', $menuWidth + 'px' );
		jQuery( this ).find( 'li' ).css( 'width', $itemWidth + 'px' );
		jQuery( this ).find( 'li:last' ).css( 'width', $lastItemWidth + 'px' ).addClass( 'no-border-right' );
	});
}

// Resize crossfade images and square to be the largest image and also vertically centered
jQuery( window ).load( function() {
	jQuery( '.variations_form' ).find( '.variations .single_variation_wrap .woocommerce-variation-description' ).remove();

	jQuery( window ).resize(
		function() {
			jQuery( '.crossfade-images' ).each(
				function() {
					fusionResizeCrossfadaImagesContainer( jQuery( this ) );
					fusionResizeCrossfadeImages( jQuery( this ) );
				}
			);
		}
	);

	jQuery( '.crossfade-images' ).each(
		function() {
			fusionResizeCrossfadaImagesContainer( jQuery( this ) );
			fusionResizeCrossfadeImages( jQuery( this ) );
		}
	);

	// Make the onsale badge also work on products without image
	jQuery( '.product-images' ).each(
		function() {
			if ( ! jQuery( this ).find( 'img' ).length && jQuery( this ).find( '.onsale' ).length ) {
				jQuery( this ).css( 'min-height', '45px' );
			}
		}
	);

	jQuery( '.woocommerce .images #carousel a' ).click( function( e ) {
		e.preventDefault();
	});

	// Make sure the variation image is also changed in the thumbs carousel and for lightbox
	jQuery( '.variations_form' ).on( 'change', '.variations select', function( event ) {
		var $variationsForm = jQuery( this ).parents( '.variations_form' );

		// Timeout needed to get updated image src attribute
		setTimeout( function() {
			var $sliderFirstImage           = jQuery( '.images' ).find( '#slider img:eq(0)' ),
			    $sliderFirstImageParentLink = $sliderFirstImage.parent(),
			    $sliderFirstImageSrc        = $sliderFirstImage.attr( 'src' ),
			    $thumbsFirstImage           = jQuery( '.images' ).find( '#carousel img:eq(0)' ),
			    $slider;

			if ( $sliderFirstImageParentLink && $sliderFirstImageParentLink.attr( 'href' ) ) {
				$sliderFirstImageSrc = $sliderFirstImageParentLink.attr( 'href' );
			}

			$sliderFirstImage.parent().attr( 'href', $sliderFirstImageSrc );
			$sliderFirstImage.removeAttr( 'sizes' );
			$sliderFirstImage.removeAttr( 'srcset' );

			// Refresh the lightbox
			window.avadaLightBox.refresh_lightbox();

			$thumbsFirstImage.attr( 'src', $sliderFirstImageSrc );
			$thumbsFirstImage.removeAttr( 'sizes' );
			$thumbsFirstImage.removeAttr( 'srcset' );

			$slider = jQuery( '.images #slider' ).data( 'flexslider' );
			if ( $slider ) {
				$slider.resize();
			}

			$slider = jQuery( '.images #carousel' ).data( 'flexslider' );
			if ( $slider ) {
				$slider.resize();
			}

			//$variationsForm.find( '.variations .single_variation_wrap .woocommerce-variation-description' ).remove();

		}, 1 );

		setTimeout( function() {
			var $slider;

			window.avadaLightBox.refresh_lightbox();

			$slider = jQuery( '.images #slider' ).data( 'flexslider' );
			if ( $slider ) {
				$slider.resize();
			}
		}, 500 );

		setTimeout( function() {
			window.avadaLightBox.refresh_lightbox();
		}, 1500 );
	});
});

jQuery( document ).ready( function() {

	var name,
	    avadaMyAccountActive,
	    $titleSep,
	    $titleSepClassString,
	    $titleMainSepClassString,
	    $headingOrientation,
	    i;

	jQuery( '.fusion-update-cart' ).on( 'click', function( e ) {
		e.preventDefault();
		jQuery( '.cart .actions > .button' ).trigger( 'click' );
	});

	jQuery( '.fusion-apply-coupon' ).on( 'click', function( e ) {
		e.preventDefault();
		jQuery( '.cart .actions .coupon #coupon_code' ).val( jQuery( '#avada_coupon_code' ).val() );
		jQuery( '.cart .actions .coupon .button' ).trigger( 'click' );
	});

	jQuery( '.product-type-variable .variations_form > .single_variation_wrap .woocommerce-variation-price' ).remove();
	jQuery( '.product-type-variable .variations_form > .single_variation_wrap .woocommerce-variation-availability' ).remove();

	jQuery( 'body' ).on( 'click', '.add_to_cart_button', function( e ) {
		var $addToCartButton = jQuery( this );

		$addToCartButton.closest( '.product, li' ).find( '.cart-loading' ).find( 'i' ).removeClass( 'fusion-icon-check-square-o' ).addClass( 'fusion-icon-spinner' );
		$addToCartButton.closest( '.product, li' ).find( '.cart-loading' ).fadeIn();
		setTimeout( function() {
			$addToCartButton.closest( '.product, li' ).find( '.cart-loading' ).find( 'i' ).hide().removeClass( 'fusion-icon-spinner' ).addClass( 'fusion-icon-check-square-o' ).fadeIn();
			jQuery( $addToCartButton ).parents( '.fusion-clean-product-image-wrapper, li' ).addClass( 'fusion-item-in-cart' );
		}, 2000 );
	});

	jQuery( 'li' ).mouseenter(function() {
		if ( jQuery( this ).find( '.cart-loading' ).find( 'i' ).hasClass( 'fusion-icon-check-square-o' ) ) {
			jQuery( this ).find( '.cart-loading' ).fadeIn();
		}
	}).mouseleave(function() {
		if ( jQuery( this ).find( '.cart-loading' ).find( 'i' ).hasClass( 'fusion-icon-check-square-o' ) ) {
			jQuery( this ).find( '.cart-loading' ).fadeOut();
		}
	});

	jQuery( '.catalog-ordering .orderby .current-li a' ).html( jQuery( '.catalog-ordering .orderby ul li.current a' ).html() );
	jQuery( '.catalog-ordering .sort-count .current-li a' ).html( jQuery( '.catalog-ordering .sort-count ul li.current a' ).html() );
	jQuery( '.woocommerce .shop_table .variation dd' ).after( '<br />' );
	jQuery( '.woocommerce .avada-myaccount-data th.order-actions' ).text( avadaVars.order_actions );

	jQuery( 'body.rtl .avada-myaccount-data .my_account_orders .order-status' ).each( function() {
		jQuery( this ).css( 'text-align', 'right' );
	});

	jQuery( '.woocommerce input' ).each( function() {
		if ( ! jQuery( this ).has( '#coupon_code' ) ) {
			name = jQuery( this ).attr( 'id' );
			jQuery( this ).attr( 'placeholder', jQuery( this ).parent().find( 'label[for=' + name + ']' ).text() );
		}
	});

	if ( jQuery( '.woocommerce #reviews #comments .comment_container .comment-text' ).length ) {
		jQuery( '.woocommerce #reviews #comments .comment_container' ).append( '<div class="clear"></div>' );
	}

	$titleSep                = avadaVars.title_style_type.split( ' ' );
	$titleSepClassString     = '';
	$titleMainSepClassString = '';
	$headingOrientation      = 'title-heading-left';

	for ( i = 0; i < $titleSep.length; i++ ) {
		$titleSepClassString += ' sep-' + $titleSep[ i ];
	}

	if ( $titleSepClassString.indexOf( 'underline' ) > -1 ) {
		$titleMainSepClassString = $titleSepClassString;
	}

	if ( jQuery( 'body' ).hasClass( 'rtl' ) ) {
		$headingOrientation = 'title-heading-right';
	}

	jQuery( '.woocommerce.single-product .related.products > h2' ).each( function() {
		var $relatedHeading = jQuery( this ).replaceWith( function() {
			return '<div class="fusion-title title' + $titleSepClassString + '"><h3 class="' + $headingOrientation + '">' + jQuery( this ).html() + '</h3><div class="title-sep-container"><div class="title-sep' + $titleSepClassString + ' "></div></div></div>';
		});
	});

	jQuery( '.woocommerce.single-product .upsells.products > h2' ).each( function() {
		var $relatedHeading = jQuery( this ).replaceWith( function() {
			return '<div class="fusion-title title' + $titleSepClassString + '"><h3 class="' + $headingOrientation + '">' + jQuery( this ).html() + '</h3><div class="title-sep-container"><div class="title-sep' + $titleSepClassString + ' "></div></div></div>';
		});
	});

	jQuery( '.woocommerce-tabs #comments > h2' ).each( function() {
		var $commentsHeading = jQuery( this ).replaceWith( function() {
			return '<h3>' + jQuery( this ).html() + '</h3>';
		});
	});

	if ( 'block' === jQuery( 'body .sidebar' ).css( 'display' ) ) {
		fusionCalcWoocommerceTabsLayout( '.woocommerce-tabs .tabs-horizontal' );
	}

	jQuery( '.sidebar .products,.fusion-footer-widget-area .products,#slidingbar-area .products' ).each(function() {
		jQuery( this ).removeClass( 'products-4' );
		jQuery( this ).removeClass( 'products-3' );
		jQuery( this ).removeClass( 'products-2' );
		jQuery( this ).addClass( 'products-1' );
	});

	jQuery( '.products-6 li, .products-5 li, .products-4 li, .products-3 li, .products-3 li' ).removeClass( 'last' );

	// Woocommerce nested products plugin support
	jQuery( '.subcategory-products' ).each( function() {
		jQuery( this ).addClass( 'products-' + avadaVars.woocommerce_shop_page_columns );
	});

	jQuery( '.woocommerce-tabs ul.tabs li a' ).unbind( 'click' );
	jQuery( 'body' ).on( 'click', '.woocommerce-tabs > ul.tabs li a', function() {

		var tab         = jQuery( this ),
		    tabsWrapper = tab.closest( '.woocommerce-tabs' );

		jQuery( 'ul.tabs li', tabsWrapper ).removeClass( 'active' );
		jQuery( '> div.panel', tabsWrapper ).hide();
		jQuery( 'div' + tab.attr( 'href' ), tabsWrapper ).show();
		tab.parent().addClass( 'active' );

		return false;
	});

	jQuery( '.woocommerce-checkout-nav a,.continue-checkout' ).on( 'click', function( e ) {
		var $adminBarHeight     = ( jQuery( '#wpadminbar' ).length ) ? jQuery( '#wpadminbar' ).height() : 0,
		    $headerDivChildren  = jQuery( '.fusion-header-wrapper' ).find( 'div' ),
		    $stickyHeaderHeight = 0,
		    $dataName,
		    $name,
		    $scrollAnchor;

		$headerDivChildren.each( function() {
			if ( 'fixed' == jQuery( this ).css( 'position' ) ) {
				$stickyHeaderHeight = jQuery( this ).height();
			}
		});

		e.preventDefault();
		jQuery( '.avada-checkout-error' ).parent().remove();

		if ( ! jQuery( '.woocommerce .avada-checkout' ).find( '.woocommerce-invalid' ).is( ':visible' ) ) {

			$dataName = jQuery( this ).attr( 'data-name' ),
			$name     = $dataName;

			if ( 'order_review' == $dataName ) {
				$name = '#' + $dataName;
			} else {
				$name = '.' + $dataName;
			}

			jQuery( 'form.checkout .col-1, form.checkout .col-2, form.checkout #order_review_heading, form.checkout #order_review' ).hide();

			jQuery( 'form.checkout' ).find( $name ).fadeIn();
			if ( 'order_review' == $name ) {
				jQuery( 'form.checkout' ).find( '#order_review_heading ' ).fadeIn();
			}

			jQuery( '.woocommerce-checkout-nav li' ).removeClass( 'is-active' );
			jQuery( '.woocommerce-checkout-nav' ).find( '[data-name=' + $dataName + ']' ).parent().addClass( 'is-active' );

			if ( jQuery( this ).hasClass( 'continue-checkout' ) && jQuery( window ).scrollTop() > 0 ) {
				if ( jQuery( '.woo-tabs-horizontal' ).length ) {
					$scrollAnchor = jQuery( '.woocommerce-checkout-nav' );
				} else {
					$scrollAnchor = jQuery( '.woocommerce-content-box.avada-checkout' );
				}

				jQuery( 'html, body' ).animate( { scrollTop: $scrollAnchor.offset().top - $adminBarHeight - $stickyHeaderHeight }, 500 );
			}
		} else {
			jQuery( '.woocommerce .avada-checkout .woocommerce-checkout' ).prepend( '<ul class="woocommerce-error"><li class="avada-checkout-error">' + avadaVars.woocommerce_checkout_error + '</li><ul>' );

			jQuery( 'html, body' ).animate( { scrollTop: jQuery( '.woocommerce-error' ).offset().top - $adminBarHeight - $stickyHeaderHeight }, 500 );
		}

		// Set heights of select arrows correctly
		calcSelectArrowDimensions();
	});

	// Ship to a different address toggle
	jQuery( 'body' ).on( 'click', 'input[name=ship_to_different_address]',
		function() {
			if ( jQuery( this ).is( ':checked' ) ) {
				setTimeout( function() {

					// Set heights of select arrows correctly
					calcSelectArrowDimensions();
				}, 1 );
			}
		}
	);

	/**
	 * WooCommerce pre 2.6 compatibility
	 */

	// My account page error check
	if ( jQuery( '.avada_myaccount_user' ).length && jQuery( '.woocommerce-error' ).length && ! jQuery( '.avada-myaccount-nav.avada-woocommerce-pre26' ).find( '.active' ).children().hasClass( 'address' ) ) {
		jQuery( '.avada-myaccount-nav.avada-woocommerce-pre26' ).find( '.is-active' ).removeClass( 'is-active' );
		jQuery( '.avada-myaccount-nav.avada-woocommerce-pre26' ).find( '.account' ).parent().addClass( 'is-active' );
	}

	avadaMyAccountActive = jQuery( '.avada-myaccount-nav.avada-woocommerce-pre26' ).find( '.is-active a' );

	if ( avadaMyAccountActive.hasClass( 'address' ) ) {
		jQuery( '.avada-myaccount-data .edit_address_heading' ).fadeIn();
	} else {
		jQuery( '.avada-myaccount-data h2:nth-of-type(1)' ).fadeIn();
	}

	if ( avadaMyAccountActive.hasClass( 'downloads' ) ) {
		jQuery( '.avada-myaccount-data .digital-downloads' ).fadeIn();
	} else if ( avadaMyAccountActive.hasClass( 'orders' ) ) {
		jQuery( '.avada-myaccount-data .my_account_orders' ).fadeIn();
	} else if ( avadaMyAccountActive.hasClass( 'address' ) ) {
		jQuery( '.avada-myaccount-data .myaccount_address, .avada-myaccount-data .address' ).fadeIn();
	} else if ( avadaMyAccountActive ) {
		jQuery( '.avada-myaccount-data .edit-account-form, .avada-myaccount-data .edit-account-heading' ).fadeIn();
		jQuery( '.avada-myaccount-data h2:nth-of-type(1)' ).hide();
	}

	jQuery( '.avada-myaccount-nav.avada-woocommerce-pre26 a' ).on( 'click', function( e ) {
		var heading;
		e.preventDefault();

		jQuery( '.avada-myaccount-data h2, .avada-myaccount-data .digital-downloads, .avada-myaccount-data .my_account_orders, .avada-myaccount-data .myaccount_address, .avada-myaccount-data .address, .avada-myaccount-data .edit-account-heading, .avada-myaccount-data .edit-account-form' ).hide();

		if ( jQuery( this ).hasClass( 'downloads' ) ) {
			jQuery( '.avada-myaccount-data h2:nth-of-type(1), .avada-myaccount-data .digital-downloads' ).fadeIn();
		} else if ( jQuery( this ).hasClass( 'orders' ) ) {

			if ( jQuery( this ).parents( '.avada-myaccount-nav' ).find( '.downloads' ).length ) {
				heading = jQuery( '.avada-myaccount-data h2:nth-of-type(2)' );
			} else {
				heading = jQuery( '.avada-myaccount-data h2:nth-of-type(1)' );
			}

			heading.fadeIn();
			jQuery( '.avada-myaccount-data .my_account_orders' ).fadeIn();
		} else if ( jQuery( this ).hasClass( 'address' ) ) {

			if ( jQuery( this ).parents( '.avada-myaccount-nav' ).find( '.downloads' ).length && jQuery( this ).parents( '.avada-myaccount-nav' ).find( '.orders' ).length ) {
				heading = jQuery( '.avada-myaccount-data h2:nth-of-type(3)' );
			} else if ( jQuery( this ).parents( '.avada-myaccount-nav' ).find( '.downloads' ).length || jQuery( this ).parents( '.avada-myaccount-nav' ).find( '.orders' ).length ) {
				heading = jQuery( '.avada-myaccount-data h2:nth-of-type(2)' );
			} else {
				heading = jQuery( '.avada-myaccount-data h2:nth-of-type(1)' );
			}

			heading.fadeIn();
			jQuery( '.avada-myaccount-data .myaccount_address, .avada-myaccount-data .address' ).fadeIn();
		} else if ( jQuery( this ).hasClass( 'account' ) ) {
			jQuery( '.avada-myaccount-data .edit-account-heading, .avada-myaccount-data .edit-account-form' ).fadeIn();
		}

		jQuery( '.avada-myaccount-nav li' ).removeClass( 'is-active' );
		jQuery( this ).parent().addClass( 'is-active' );
	});
});

// Reintalize scripts after ajax
jQuery( document ).ajaxComplete( function() {
	jQuery( '.fusion-update-cart' ).unbind( 'click' );
	jQuery( '.fusion-update-cart' ).on( 'click', function( e ) {
		e.preventDefault();
		jQuery( '.cart .actions > .button' ).trigger( 'click' );
	});
});
