var generateCarousel = function() {
	if ( jQuery().carouFredSel ) {
		jQuery( '.fusion-carousel' ).each( function() {

			// Initialize the needed variables from data fields
			var $imageSize        = ( jQuery( this ).attr( 'data-imagesize' ) ) ? jQuery( this ).data( 'imagesize' ) : 'fixed',
			    $centerVertically = ( jQuery( this ).attr( 'data-metacontent' ) && 'yes' === jQuery( this ).data( 'metacontent' ) ) ? false : true,
			    $autoplay         = ( jQuery( this ).attr( 'data-autoplay' ) && 'yes' === jQuery( this ).data( 'autoplay' ) ) ? true : false,
			    $timeoutDuration  = ( jQuery( this ).parents( '.related-posts' ).length ) ? avadaVars.related_posts_speed : avadaVars.carousel_speed,
			    $scrollEffect     = ( jQuery( this ).attr( 'data-scrollfx' ) ) ? jQuery( this ).data( 'scrollfx' ) : 'scroll',
			    $scrollItems      = ( jQuery( this ).attr( 'data-scrollitems' ) ) ? jQuery( this ).data( 'scrollitems' ) : null,
			    $touchScroll      = ( jQuery( this ).attr( 'data-touchscroll' ) && 'yes' === jQuery( this ).data( 'touchscroll' ) ) ? true : false,
			    $touchScrollClass = ( $touchScroll ) ? ' fusion-carousel-swipe' : '',
			    $columnMaximum    = ( jQuery( this ).attr( 'data-columns' ) ) ? jQuery( this ).data( 'columns' ) : 6,
			    $itemMargin       = ( jQuery( this ).attr( 'data-itemmargin' ) ) ? parseInt( jQuery( this ).data( 'itemmargin' ) ) : 44,
			    $itemMinWidth     = ( jQuery( this ).attr( 'data-itemwidth' ) ) ? parseInt( jQuery( this ).data( 'itemwidth' ) )  + $itemMargin : 180 + $itemMargin,
			    $carouselWidth    = jQuery( this ).width(),
			    $carouselHeight   = ( jQuery( this ).parent().hasClass( 'fusion-image-carousel' ) && 'fixed' === $imageSize ) ? '115px' : 'variable',
			    $maxNumberOfItems = Math.floor( $carouselWidth / $itemMinWidth );

			// Shift the wrapping positioning container $itemMargin to the left
			jQuery( this ).find( '.fusion-carousel-positioner' ).css( 'margin-left', '-' + $itemMargin + 'px' );

			// Add $itemMargin as left margin to all items
			jQuery( this ).find( '.fusion-carousel-item' ).css( 'margin-left', $itemMargin  + 'px' );

			// Shift the left navigation button $itemMargin to the right
			jQuery( this ).find( '.fusion-nav-prev' ).css( 'margin-left', $itemMargin + 'px' );

			// Initialize the carousel
			jQuery( this ).find( 'ul' ).carouFredSel({
				circular: true,
				infinite: true,
				responsive: true,
				centerVertically: $centerVertically,
				height: $carouselHeight,
				width: '100%',
				auto: {
					play: $autoplay,
					timeoutDuration: parseInt( $timeoutDuration )
				},
				items: {
					height: $carouselHeight,
					width: $itemMinWidth,
					visible: {
						min: 1,
						max: $columnMaximum
					}
				},
				scroll: {
					pauseOnHover: true,
					items: $scrollItems,
					fx: $scrollEffect
				},
				swipe: {
					onTouch: $touchScroll,
					onMouse: $touchScroll,
					options: {
						excludedElements: 'button, input, select, textarea, a, .noSwipe'
					}
				},
				prev: jQuery( this ).find( '.fusion-nav-prev' ),
				next: jQuery( this ).find( '.fusion-nav-next' ),
				onCreate: function( data ) {

					// Make the images visible once the carousel is loaded
					jQuery( this ).find( '.fusion-carousel-item-wrapper' ).css( 'visibility', 'inherit' );

					// Make the navigation visible once the carousel is loaded
					jQuery( this ).parents( '.fusion-carousel' ).find( '.fusion-carousel-nav' ).css( 'visibility', 'inherit' );

					// Remove overflow: hidden to  make carousel stretch full width
					if ( jQuery( this ).parents( '.fusion-woo-featured-products-slider' ).length ) {
						jQuery( this ).parent().css( 'overflow', '' );
					}

					// Set the line-height of the main ul element to the height of the wrapping container
					if ( $centerVertically ) {
						jQuery( this ).css( 'line-height', jQuery( this ).parent().height() + 'px' );
					}

					// Set the ul element to top: auto position to make is respect top padding
					jQuery( this ).css( 'top', 'auto' );

					// Set the position of the right navigation element to make it fit the overall carousel width
					jQuery( this ).parents( '.fusion-carousel' ).find( '.fusion-nav-next' ).each( function() {
						jQuery( this ).css( 'left', jQuery( this ).parents( '.fusion-carousel' ).find( '.fusion-carousel-wrapper' ).width() - jQuery( this ).width() );
					});

					// Resize the placeholder images correctly in "fixed" picture size carousels
					if ( 'fixed' === $imageSize ) {
						jQuery( this ).find( '.fusion-placeholder-image' ).each( function() {
							jQuery( this ).css(	'height', jQuery( this ).parents( '.fusion-carousel-item' ).siblings().first().find( 'img' ).height() );

						});
					}

					jQuery( window ).trigger( 'resize' );
				},
				currentVisible: function( $items ) {
					return $items;
				}
			}, {

				// Set custom class name to the injected carousel container
				wrapper: {
					classname: 'fusion-carousel-wrapper' + $touchScrollClass
				}
			});
		});
	}
};

var fusionReanimateSlider = function( contentContainer ) {
	var slideContent = contentContainer.find( '.slide-content' );

	jQuery( slideContent ).each( function() {

		jQuery( this ).stop( true, true );

		jQuery( this ).css( 'opacity', '0' );
		jQuery( this ).css( 'margin-top', '50px' );

		jQuery( this ).animate({
			'opacity': '1',
			'margin-top': '0'
		}, 1000 );

	});
};

// Calculate the responsive type values for font size and line height for all heading tags
var fusionCalculateResponsiveTypeValues = function( $customSensitivity, $customMinimumFontSizeFactor, $customMobileBreakPoint, $elements ) {

	// Setup options
	var $sensitivity           = $customSensitivity || 1,
	    $minimumFontSizeFactor = $customMinimumFontSizeFactor || 1.5,
	    $bodyFontSize          = parseInt( jQuery( 'body' ).css( 'font-size' ) ),
	    $minimumFontSize       = $bodyFontSize * $minimumFontSizeFactor,
	    $mobileBreakPoint      = ( $customMobileBreakPoint || 0 === $customMobileBreakPoint ) ? $customMobileBreakPoint : 800,
	    $windowSiteWidthRatio,
	    $resizeFactor;

	var calculateValues = function() {
		var $siteWidth;

		// Get the site width for responsive type
		if ( jQuery( window ).width() >= $mobileBreakPoint ) {

			// Get px based site width from Theme Options
			if ( avadaVars.site_width.indexOf( 'px' ) ) {
				$siteWidth = parseInt( avadaVars.site_width );

			// If site width is percentage based, use default site width
			} else {
				$siteWidth = 1100;
			}

		// If we are below $mobileBreakPoint of viewport width, set $mobileBreakPoint as site width
		} else {
			$siteWidth = $mobileBreakPoint;
		}

		// The resizing factor can be finetuned through a custom sensitivity; values below 1 decrease resizing speed
		$windowSiteWidthRatio = jQuery( window ).width() / $siteWidth;
		$resizeFactor         = 1 - ( ( 1 - $windowSiteWidthRatio ) * $sensitivity );

		// If window width is smaller than site width then let's adjust the headings
		if ( jQuery( window ).width() <= $siteWidth ) {

			// Loop over all heading tegs
			jQuery( $elements ).each( function() {

				// Only decrease font-size if the we stay above $minimumFontSize
				if ( jQuery( this ).data( 'fontsize' ) * $resizeFactor > $minimumFontSize ) {
					jQuery( this ).css( {
						'font-size': Math.round( jQuery( this ).data( 'fontsize' ) * $resizeFactor * 1000 ) / 1000,
						'line-height': ( Math.round( jQuery( this ).data( 'lineheight' ) * $resizeFactor * 1000 ) / 1000 ) + 'px'
					});

				// If decreased font size would become too small, natural font size is above $minimumFontSize, set font size to $minimumFontSize
				} else if ( jQuery( this ).data( 'fontsize' ) > $minimumFontSize ) {
					jQuery( this ).css( {
						'font-size': $minimumFontSize,
						'line-height': ( Math.round( jQuery( this ).data( 'lineheight' ) * $minimumFontSize / jQuery( this ).data( 'fontsize' ) * 1000 ) / 1000 ) + 'px'
					});
				}
			});

		// If window width is larger than site width, delete any resizing styles
		} else {
			jQuery( $elements ).each( function() {

				// If initially an inline font size was set, restore it
				if ( jQuery( this ).data( 'inline-fontsize' ) ) {
					jQuery( this ).css( 'font-size', jQuery( this ).data( 'fontsize' ) );

				// Otherwise remove inline font size
				} else {
					jQuery( this ).css( 'font-size', '' );
				}

				// If initially an inline line height was set, restore it
				if ( jQuery( this ).data( 'inline-lineheight' ) ) {
					jQuery( this ).css( 'line-height', jQuery( this ).data( 'lineheight' ) + 'px' );

				// Otherwise remove inline line height
				} else {
					jQuery( this ).css( 'line-height', '' );
				}

			});
		}
	};

	calculateValues();

	jQuery( window ).on( 'resize orientationchange', calculateValues );
};

window.avadaTop = window.avadaBottom = false;
window.lastWindowPosition = 0;
window.lastWindowHeight = jQuery( window ).height();

if ( undefined === window.$ilInstances ) {
	window.$ilInstances = [];
}

function fusionSideHeaderScroll() {
	var $mediaQueryIpad = Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait)' ) ||  Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape)' ),
	    $documentHeight,
	    $windowPosition,
	    $windowHeight,
	    $bodyHeight,
	    $adminbarHeight,
	    $sideHeader,
	    $sideHeaderWrapper,
	    $sideHeaderHeight,
	    $boxedWrapperOffset,
	    $topOffset;

	if ( ! $mediaQueryIpad ) {
		$documentHeight     = jQuery( document ).height();
		$windowPosition     = jQuery( window ).scrollTop();
		$windowHeight       = jQuery( window ).height();
		$bodyHeight         = jQuery( 'body' ).height();
		$adminbarHeight     = jQuery( '#wpadminbar' ).height();
		$sideHeader         = jQuery( '#side-header' );
		$sideHeaderWrapper  = jQuery( '.side-header-wrapper' );
		$sideHeaderHeight   = $sideHeaderWrapper.outerHeight();
		$boxedWrapperOffset = 0;

		if ( jQuery( 'body' ).hasClass( 'layout-boxed-mode' ) && jQuery( 'body' ).hasClass( 'side-header-right' ) ) {
			$sideHeader = jQuery( '.side-header-wrapper' );
			$boxedWrapperOffset = jQuery( '#boxed-wrapper' ).offset().top;
		}

		if ( Modernizr.mq( 'only screen and (max-width:' + avadaVars.side_header_break_point + 'px)' ) ) {

			if ( ! $sideHeader.hasClass( 'fusion-is-sticky' ) ) {
				$sideHeader.css({
					'bottom': '',
					'position': ''
				});
			}

			return;
		}

		if ( $sideHeaderHeight + $adminbarHeight > $windowHeight ) {
			$sideHeader.css( 'height', 'auto' );
			if ( $windowPosition > window.lastWindowPosition ) {
				if ( window.avadaTop ) {
					window.avadaTop = false;
					$topOffset = ( $sideHeaderWrapper.offset().top > 0 ) ? $sideHeaderWrapper.offset().top - $boxedWrapperOffset : $adminbarHeight;
					$sideHeader.attr( 'style', 'top: ' + $topOffset + 'px; height: auto;' );
				} else if ( ! window.avadaBottom && $windowPosition + $windowHeight > $sideHeaderHeight + $sideHeaderWrapper.offset().top && $sideHeaderHeight + $adminbarHeight < $bodyHeight ) {
					window.avadaBottom = true;
					$sideHeader.attr( 'style', 'position: fixed; bottom: 0; top: auto; height: auto;' );
				}
			} else if ( $windowPosition < window.lastWindowPosition ) {
				if ( window.avadaBottom ) {
					window.avadaBottom = false;
					$topOffset = ( $sideHeaderWrapper.offset().top > 0 ) ? $sideHeaderWrapper.offset().top - $boxedWrapperOffset : $adminbarHeight;
					$sideHeader.attr( 'style', 'top: ' + $topOffset + 'px; height: auto;' );
				} else if ( ! window.avadaTop && $windowPosition + $adminbarHeight < $sideHeaderWrapper.offset().top ) {
					window.avadaTop = true;
					$sideHeader.attr( 'style', 'position: fixed; height: auto;' );
				}
			} else {
				window.avadaTop = window.avadaBottom = false;

				$topOffset = ( $sideHeaderWrapper.offset().top > 0 ) ? $sideHeaderWrapper.offset().top - $boxedWrapperOffset : $adminbarHeight;

				if ( $windowHeight > window.lastWindowHeight && $bodyHeight > $sideHeaderWrapper.offset().top  + $boxedWrapperOffset + $sideHeaderHeight && $windowPosition + $windowHeight > $sideHeaderWrapper.offset().top + $sideHeaderHeight ) {
					$topOffset += $windowHeight - window.lastWindowHeight;
				}
				$sideHeader.attr( 'style', 'top:' + $topOffset + 'px; height: auto;' );
			}
		} else {
			window.avadaTop = true;
			$sideHeader.attr( 'style', 'position: fixed;' );
		}

		window.lastWindowPosition = $windowPosition;
		window.lastWindowHeight   = $windowHeight;
	}
}

function addStylesForOldIEVersions() {

	// IE10
	if ( '10.0' == cssua.ua.ie ) {
		jQuery( 'head' ).append( '<style type="text/css">.layout-boxed-mode .fusion-footer-parallax { left: auto; right: auto; }.fusion-imageframe,.imageframe-align-center{font-size: 0px; line-height: normal;}.fusion-button.button-pill,.fusion-button.button-pill:hover{filter: none;}.fusion-header-shadow:after, body.side-header-left .header-shadow#side-header:before, body.side-header-right .header-shadow#side-header:before{ display: none }.search input,.searchform input {padding-left:10px;} .avada-select-parent .select-arrow,.select-arrow{height:33px;background-color:' + avadaVars.form_bg_color + '}.search input{padding-left:5px;}header .tagline{margin-top:3px;}.star-rating span:before {letter-spacing: 0;}.avada-select-parent .select-arrow,.gravity-select-parent .select-arrow,.wpcf7-select-parent .select-arrow,.select-arrow{background: #fff;}.star-rating{width: 5.2em;}.star-rating span:before {letter-spacing: 0.1em;}</style>' );
	}

	// IE11
	if ( '11.0' == cssua.ua.ie ) {
		jQuery( 'head' ).append( '<style type="text/css">.layout-boxed-mode .fusion-footer-parallax { left: auto; right: auto; }</style>' );
	}
}

// Get WP admin bar height
function getAdminbarHeight() {
	var $adminbarHeight = 0;

	if ( jQuery( '#wpadminbar' ).length ) {
		$adminbarHeight = parseInt( jQuery( '#wpadminbar' ).outerHeight() );
	}

	return $adminbarHeight;
}

// Get current height of sticky header
function getStickyHeaderHeight() {
	var $stickyHeaderType   = 1,
	    $stickyHeaderHeight = 0,
	    $mediaQueryIpad     = Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait)' ) ||  Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape)' );

	// Set header type to 2 for headers v4, v5
	if ( jQuery( '.fusion-header-v4' ).length || jQuery( '.fusion-header-v5' ).length ) {
		$stickyHeaderType = 2;
	}

	// Sticky header is enabled
	if ( '1' == avadaVars.header_sticky && jQuery( '.fusion-header-wrapper' ).length ) {

		// Desktop mode - headers v1, v2, v3
		if ( 1 == $stickyHeaderType ) {
			$stickyHeaderHeight = jQuery( '.fusion-header' ).outerHeight() - 1;

			// For headers v1 - v3 the sticky header min height is always 65px
			if ( $stickyHeaderHeight < 64 ) {
				$stickyHeaderHeight = 64;
			}

		// Desktop mode - headers v4, v5
		} else {
			$stickyHeaderHeight = jQuery( '.fusion-secondary-main-menu' ).outerHeight();

			if ( 'menu_and_logo' === avadaVars.header_sticky_type2_layout ) {
				$stickyHeaderHeight += jQuery( '.fusion-header' ).outerHeight();
			}
		}

		// Mobile mode
		if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {

			// Sticky header is enabled on mobile
			if ( '1' == avadaVars.header_sticky_mobile ) {

				// Classic mobile menu
				if ( jQuery( '.fusion-mobile-menu-design-classic' ).length ) {
					$stickyHeaderHeight = jQuery( '.fusion-secondary-main-menu' ).outerHeight();
				}

				// Modern mobile menu
				if ( jQuery( '.fusion-mobile-menu-design-modern' ).length ) {
					$stickyHeaderHeight = jQuery( '.fusion-header' ).outerHeight();
				}

			// Sticky header is disabled on mobile
			} else {
				$stickyHeaderHeight = 0;
			}
		}

		// Tablet mode
		if ( '1' != avadaVars.header_sticky_tablet && $mediaQueryIpad ) {
			$stickyHeaderHeight = 0;
		}
	}

	return $stickyHeaderHeight;
}

// Calculate height of sticky header on page load
function getWaypointTopOffset() {
	var $stickyHeaderHeight = 0,
	    $mediaQueryIpad     = Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait)' ) ||  Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape)' ),
	    $stickyHeaderType   = 1;

		if ( jQuery( '.fusion-header-v4' ).length || jQuery( '.fusion-header-v5' ).length ) {
		   $stickyHeaderType = 2;
		}

	// Sticky header is enabled
	if ( '1' == avadaVars.header_sticky && jQuery( '.fusion-header-wrapper' ).length ) {

		// Desktop mode - headers v1, v2, v3
		if ( 1 == $stickyHeaderType ) {
			$stickyHeaderHeight = jQuery( '.fusion-header' ).outerHeight() - 1;

		// Desktop mode - headers v4, v5
		} else {

			// Menu only
			$stickyHeaderHeight = jQuery( '.fusion-secondary-main-menu' ).outerHeight();

			// Menu and logo
			if ( 'menu_and_logo' === avadaVars.header_sticky_type2_layout ) {
				$stickyHeaderHeight += jQuery( '.fusion-header' ).outerHeight() - 1;
			}
		}

		// Mobile mode
		if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {

			// Sticky header is enabled on mobile
			if ( '1' == avadaVars.header_sticky_mobile ) {
				$stickyHeaderHeight = jQuery( '.fusion-header' ).outerHeight() - 1;

			// Sticky header is disabled on mobile
			} else {
				$stickyHeaderHeight = 0;
			}
		}

		// Tablet mode
		if ( '1' != avadaVars.header_sticky_tablet && $mediaQueryIpad ) {
			$stickyHeaderHeight = 0;
		}
	}

	return $stickyHeaderHeight;
}

function getWaypointOffset( $object ) {
	var $offset = $object.data( 'animationoffset' ),
	    $adminbarHeight,
	    $stickyHeaderHeight;

	if ( undefined === $offset ) {
		$offset = 'bottom-in-view';
	}

	if ( 'top-out-of-view' === $offset ) {
		$adminbarHeight     = getAdminbarHeight();
		$stickyHeaderHeight = getWaypointTopOffset();

		$offset = $adminbarHeight + getWaypointTopOffset();
	}

	return $offset;
}

/**
 * Avada Quanity buttons add-back
 */
function avadaAddQuantityBoxes( $quantitySelector ) {

	var $quantityBoxes;

	if ( ! $quantitySelector ) {
		$quantitySelector = '.qty';
	}

	$quantityBoxes = jQuery( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).find( $quantitySelector );

	if ( $quantityBoxes && 'date' != $quantityBoxes.prop( 'type' ) ) {

		// Add plus and minus boxes
		$quantityBoxes.parent().addClass( 'buttons_added' ).prepend( '<input type="button" value="-" class="minus" />' );
		$quantityBoxes.addClass( 'input-text' ).after( '<input type="button" value="+" class="plus" />' );

		// Target quantity inputs on product pages
		jQuery( 'input' + $quantitySelector + ':not(.product-quantity input' + $quantitySelector + ')' ).each( function() {
				var $min = parseFloat( jQuery( this ).attr( 'min' ) );

				if ( $min && $min > 0 && parseFloat( jQuery( this ).val() ) < $min ) {
					jQuery( this ).val( $min );
				}
		});

		jQuery( '.plus, .minus' ).unbind( 'click' );

		jQuery( '.plus, .minus' ).on( 'click', function() {

				// Get values
				var $quantityBox     = jQuery( this ).parent().find( $quantitySelector ),
				    $currentQuantity = parseFloat( $quantityBox.val() ),
				    $maxQuantity     = parseFloat( $quantityBox.attr( 'max' ) ),
				    $minQuantity     = parseFloat( $quantityBox.attr( 'min' ) ),
				    $step            = $quantityBox.attr( 'step' );

				// Fallback default values
				if ( ! $currentQuantity || '' === $currentQuantity  || 'NaN' === $currentQuantity ) {
					$currentQuantity = 0;
				}
				if ( '' === $maxQuantity || 'NaN' === $maxQuantity ) {
					$maxQuantity = '';
				}

				if ( '' === $minQuantity || 'NaN' === $minQuantity ) {
					$minQuantity = 0;
				}
				if ( 'any' === $step || '' === $step  || undefined === $step || 'NaN' === parseFloat( $step )  ) {
					$step = 1;
				}

				// Change the value
				if ( jQuery( this ).is( '.plus' ) ) {

					if ( $maxQuantity && ( $maxQuantity == $currentQuantity || $currentQuantity > $maxQuantity ) ) {
						$quantityBox.val( $maxQuantity );
					} else {
						$quantityBox.val( $currentQuantity + parseFloat( $step ) );
					}

				} else {

					if ( $minQuantity && ( $minQuantity == $currentQuantity || $currentQuantity < $minQuantity ) ) {
						$quantityBox.val( $minQuantity );
					} else if ( $currentQuantity > 0 ) {
						$quantityBox.val( $currentQuantity - parseFloat( $step ) );
					}

				}

				// Trigger change event
				$quantityBox.trigger( 'change' );
			}
		);
	}
}

( function( jQuery ) {

	'use strict';

	jQuery( '.tfs-slider' ).each( function() {
		var thisTFSlider = this;

		if ( 1 <= jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
			jQuery( thisTFSlider ).data( 'parallax', 0 );
			jQuery( thisTFSlider ).data( 'full_screen', 0 );
		}

		if ( cssua.ua.tablet_pc ) {
			jQuery( thisTFSlider ).data( 'parallax', 0 );
		}

		if ( cssua.ua.mobile ) {
			jQuery( thisTFSlider ).data( 'parallax', 0 );
		}
	});

	// Waypoint
	jQuery.fn.init_waypoint = function() {
		if ( jQuery().waypoint ) {

			// Counters Box
			jQuery( '.fusion-counter-box' ).not( '.fusion-modal .fusion-counter-box' ).each( function() {
				var $offset = getWaypointOffset( jQuery( this ) );

				jQuery( this ).waypoint( function() {
					jQuery( this ).find( '.display-counter' ).each( function() {
						jQuery( this ).$fusionBoxCounting();
					});
				}, {
					triggerOnce: true,
					offset: $offset
				});
			});

			// Counter Circles
			jQuery( '.counter-circle-wrapper' ).not( '.fusion-accordian .counter-circle-wrapper, .fusion-tabs .counter-circle-wrapper, .fusion-modal .counter-circle-wrapper' ).each( function() {
				var $offset = getWaypointOffset( jQuery( this ) );

				jQuery( this ).waypoint( function() {
					jQuery( this ).fusion_recalc_circles( true );
					jQuery( this ).fusion_draw_circles();
				}, {
					triggerOnce: true,
					offset: $offset
				});
			});

			// Counter Circles Responsive Resizing
			jQuery( '.counter-circle-wrapper' ).not( '.fusion-modal .counter-circle-wrapper' ).each( function() {
				var $offset = getWaypointOffset( jQuery( this ) ),
				    $adminbarHeight,
				    $stickyHeaderHeight;

				if ( 'top-out-of-view' === $offset ) {
					$adminbarHeight     = getAdminbarHeight(),
					$stickyHeaderHeight = getWaypointTopOffset();

					$offset = $adminbarHeight + getWaypointTopOffset();
				}

				jQuery( this ).waypoint( function() {
					var counterCircles = jQuery( this );

					jQuery( window ).on( 'resize', function() {
						counterCircles.fusion_redraw_circles();
					});
				}, {
					triggerOnce: true,
					offset: $offset
				});
			});

			// Progressbar
			jQuery( '.fusion-progressbar' ).not( '.fusion-modal .fusion-progressbar' ).each( function() {
				var $offset = getWaypointOffset( jQuery( this ) );

				jQuery( this ).waypoint( function() {
					jQuery( this ).fusion_draw_progress();
				}, {
					triggerOnce: true,
					offset: $offset
				});
			});

			// Content Boxes Timeline Design
			jQuery( '.fusion-content-boxes' ).each( function() {
				var $offset = getWaypointOffset( jQuery( this ) );

				jQuery( this ).waypoint( function() {
					var $delay = 0;

					jQuery( this ).find( '.content-box-column' ).each( function() {
						var $element = this,
						    $animationType,
						    $animationDuration;

						setTimeout( function() {
							jQuery( $element ).find( '.fusion-animated' ).css( 'visibility', 'visible' );

							// This code is executed for each appeared element
							$animationType = jQuery( $element ).find( '.fusion-animated' ).data( 'animationtype' );
							$animationDuration = jQuery( $element ).find( '.fusion-animated' ).data( 'animationduration' );

							jQuery( $element ).find( '.fusion-animated' ).addClass( $animationType );

							if ( $animationDuration ) {
								jQuery( $element ).find( '.fusion-animated' ).css( '-moz-animation-duration', $animationDuration + 's' );
								jQuery( $element ).find( '.fusion-animated' ).css( '-webkit-animation-duration', $animationDuration + 's' );
								jQuery( $element ).find( '.fusion-animated' ).css( '-ms-animation-duration', $animationDuration + 's' );
								jQuery( $element ).find( '.fusion-animated' ).css( '-o-animation-duration', $animationDuration + 's' );
								jQuery( $element ).find( '.fusion-animated' ).css( 'animation-duration', $animationDuration + 's' );
							}

							if ( jQuery( $element ).parents( '.fusion-content-boxes' ).hasClass( 'content-boxes-timeline-horizontal' ) ||
								jQuery( $element ).parents( '.fusion-content-boxes' ).hasClass( 'content-boxes-timeline-vertical' ) ) {
								jQuery( $element ).addClass( 'fusion-appear' );
							}
						}, $delay );

						$delay += parseInt( jQuery( this ).parents( '.fusion-content-boxes' ).attr( 'data-animation-delay' ) );
					});
				}, {
					triggerOnce: true,
					offset: $offset
				});
			});

			// CSS Animations
			jQuery( '.fusion-animated' ).each( function() {
				var $offset = getWaypointOffset( jQuery( this ) ),
				    $adminbarHeight,
				    $stickyHeaderHeight;

				if ( 'top-out-of-view' === $offset ) {
					$adminbarHeight     = getAdminbarHeight();
					$stickyHeaderHeight = getStickyHeaderHeight();

					$offset = $adminbarHeight + $stickyHeaderHeight;
				}

				jQuery( this ).waypoint( function() {

					var $animationType,
					    $animationDuration,
					    $currentElement;

					if ( ! jQuery( this ).parents( '.fusion-delayed-animation' ).length ) {
						jQuery( this ).css( 'visibility', 'visible' );

						// This code is executed for each appeared element
						$animationType     = jQuery( this ).data( 'animationtype' ),
						$animationDuration = jQuery( this ).data( 'animationduration' );

						jQuery( this ).addClass( $animationType );

						if ( $animationDuration ) {
							jQuery( this ).css( '-moz-animation-duration', $animationDuration + 's' );
							jQuery( this ).css( '-webkit-animation-duration', $animationDuration + 's' );
							jQuery( this ).css( '-ms-animation-duration', $animationDuration + 's' );
							jQuery( this ).css( '-o-animation-duration', $animationDuration + 's' );
							jQuery( this ).css( 'animation-duration', $animationDuration + 's' );

							// Remove the animation class, when the animation is finished; this is done
							// to prevent conflicts with image hover effects
							$currentElement = jQuery( this );
							setTimeout( function() {
								$currentElement.removeClass( $animationType );
							}, $animationDuration * 1000 );
						}
					}

				}, { triggerOnce: true, offset: $offset } );
			});
		}
	};

	// Recalculate carousel elements
	jQuery.fn.fusion_recalculate_carousel = function() {
		jQuery( this ).not( '.fusion-woo-featured-products-slider' ).each( function() {
			var $carousel  = jQuery( this ),
			    $imageSize = jQuery( this ).data( 'imagesize' ),
			    $imageHeights,
			    $neededHeight;

			// Timeout needed for size changes to take effect, before weaccess them
			setTimeout( function() {

				// Set the position of the right navigation element to make it fit the overall carousel width
				$carousel.find( '.fusion-nav-next' ).each( function() {
					jQuery( this ).css( 'left', $carousel.find( '.fusion-carousel-wrapper' ).width() - jQuery( this ).width() );
				});

				// Resize the placeholder images correctly in "fixed" picture size carousels
				if ( 'fixed' === $imageSize ) {
					$imageHeights = $carousel.find( '.fusion-carousel-item' ).map( function() {
						return jQuery( this ).find( 'img' ).height();
					}).get(),
					$neededHeight = Math.max.apply( null, $imageHeights );

					$carousel.find( '.fusion-placeholder-image' ).each( function() {
						jQuery( this ).css(	'height', $neededHeight );
					});
					if ( jQuery( $carousel ).parents( '.fusion-image-carousel' ).length >= 1 ) {
						$carousel.find( '.fusion-image-wrapper' ).each( function() {
							jQuery( this ).css(	'height', $neededHeight );
							jQuery( this ).css(	'width', '100%' );
							jQuery( this ).find( '> a' ).css( 'line-height', ( $neededHeight - 2 ) + 'px' );
						});
					}
				}
			}, 5 );
		});
	};

	// Animate counter boxes
	jQuery.fn.$fusionBoxCounting = function() {
		var $countValue         = jQuery( this ).data( 'value' ),
		    $countDirection     = jQuery( this ).data( 'direction' ),
		    $delimiter          = jQuery( this ).data( 'delimiter' ),
		    $fromValue          = 0,
		    $toValue            = $countValue,
		    $counterBoxSpeed    = avadaVars.counter_box_speed,
		    $counterBoxInterval = Math.round( avadaVars.counter_box_speed / 100 );

		if ( ! $delimiter ) {
			$delimiter = '';
		}

		if ( 'down' === $countDirection ) {
			$fromValue = $countValue;
			$toValue = 0;
		}

		jQuery( this ).countTo( {
			from: $fromValue,
			to: $toValue,
			refreshInterval: $counterBoxInterval,
			speed: $counterBoxSpeed,
			formatter: function( value, options ) {
				value = value.toFixed( options.decimals );
				value = value.replace( /\B(?=(\d{3})+(?!\d))/g, $delimiter );

				if ( '-0' == value ) {
					value = 0;
				}

				return value;
			}
		} );
	};

	// Animate counter circles
	jQuery.fn.fusion_draw_circles = function() {
		var circle        = jQuery( this ),
		    countdown     = circle.children( '.counter-circle' ).attr( 'data-countdown' ),
		    filledcolor   = circle.children( '.counter-circle' ).attr( 'data-filledcolor' ),
		    unfilledcolor = circle.children( '.counter-circle' ).attr( 'data-unfilledcolor' ),
		    scale         = circle.children( '.counter-circle' ).attr( 'data-scale' ),
		    size          = circle.children( '.counter-circle' ).attr( 'data-size' ),
		    speed         = circle.children( '.counter-circle' ).attr( 'data-speed' ),
		    strokesize    = circle.children( '.counter-circle' ).attr( 'data-strokesize' ),
		    percentage    = circle.children( '.counter-circle' ).attr( 'data-percent' );

		if ( scale ) {
			scale = jQuery( 'body' ).css( 'color' );
		}

		if ( countdown ) {
			circle.children( '.counter-circle' ).attr( 'data-percent', 100 );

			circle.children( '.counter-circle' ).easyPieChart({
				barColor: filledcolor,
				trackColor: unfilledcolor,
				scaleColor: scale,
				scaleLength: 5,
				lineCap: 'round',
				lineWidth: strokesize,
				size: size,
				rotate: 0,
				animate: {
					duration: speed, enabled: true
				}
			});
			circle.children( '.counter-circle' ).data( 'easyPieChart' ).enableAnimation();
			circle.children( '.counter-circle' ).data( 'easyPieChart' ).update( percentage );
		} else {
			circle.children( '.counter-circle' ).easyPieChart({
				barColor: filledcolor,
				trackColor: unfilledcolor,
				scaleColor: scale,
				scaleLength: 5,
				lineCap: 'round',
				lineWidth: strokesize,
				size: size,
				rotate: 0,
				animate: {
					duration: speed, enabled: true
				}
			});
		}
	};

	jQuery.fn.fusion_recalc_circles = function( $animate ) {
		var $counterCirclesWrapper = jQuery( this ),
		    $currentSize,
		    $originalSize,
		    $fusionCountersCircleWidth;

		// Make sure that only currently visible circles are redrawn; important e.g. for tabs
		if ( $counterCirclesWrapper.is( ':hidden' ) ) {
			return;
		}

		$counterCirclesWrapper.attr( 'data-currentsize', $counterCirclesWrapper.width() );
		$counterCirclesWrapper.removeAttr( 'style' );
		$counterCirclesWrapper.children().removeAttr( 'style' );
		$currentSize               = $counterCirclesWrapper.data( 'currentsize' );
		$originalSize              = $counterCirclesWrapper.data( 'originalsize' );
		$fusionCountersCircleWidth = $counterCirclesWrapper.parent().width();

		// Overall container width is smaller than one counter circle; e.g. happens for elements in column shortcodes
		if ( $fusionCountersCircleWidth < $counterCirclesWrapper.data( 'currentsize' ) ) {

			$counterCirclesWrapper.css({
				'width': $fusionCountersCircleWidth,
				'height': $fusionCountersCircleWidth,
				'line-height': $fusionCountersCircleWidth + 'px'
			});
			$counterCirclesWrapper.find( '.fusion-counter-circle' ).each( function() {
				jQuery( this ).css({
					'width': $fusionCountersCircleWidth,
					'height': $fusionCountersCircleWidth,
					'line-height': $fusionCountersCircleWidth + 'px',
					'font-size': 50 * $fusionCountersCircleWidth / 220
				});
				jQuery( this ).data( 'size', $fusionCountersCircleWidth );
				jQuery( this ).data( 'strokesize', $fusionCountersCircleWidth / 220 * 11 );
				if ( ! $animate ) {
					jQuery( this ).data( 'animate', false );
				}
				jQuery( this ).attr( 'data-size', $fusionCountersCircleWidth );
				jQuery( this ).attr( 'data-strokesize', $fusionCountersCircleWidth / 220 * 11 );
			});

		} else {
			$counterCirclesWrapper.css({
				'width': $originalSize,
				'height': $originalSize,
				'line-height': $originalSize + 'px'
			});
			$counterCirclesWrapper.find( '.fusion-counter-circle' ).each( function() {
				jQuery( this ).css({
					'width': $originalSize,
					'height': $originalSize,
					'line-height': $originalSize + 'px',
					'font-size': 50 * $originalSize / 220
				});

				jQuery( this ).data( 'size', $originalSize );
				jQuery( this ).data( 'strokesize', $originalSize / 220 * 11 );
				if ( ! $animate ) {
					jQuery( this ).data( 'animate', false );
				}
				jQuery( this ).attr( 'data-size', $originalSize );
				jQuery( this ).attr( 'data-strokesize', $originalSize / 220 * 11 );
			});

		}
	};

	jQuery.fn.fusion_redraw_circles = function() {
		var $counterCirclesWrapper = jQuery( this );

		// Make sure that only currently visible circles are redrawn; important e.g. for tabs
		if ( $counterCirclesWrapper.is( ':hidden' ) ) {
			return;
		}

		$counterCirclesWrapper.fusion_recalc_circles( false );
		$counterCirclesWrapper.find( 'canvas' ).remove();
		$counterCirclesWrapper.find( '.counter-circle' ).removeData( 'easyPieChart' );
		$counterCirclesWrapper.fusion_draw_circles();
	};

	// Animate progress bar
	jQuery.fn.fusion_draw_progress = function() {
		var progressbar = jQuery( this ),
		    percentage;
		if ( jQuery( 'html' ).hasClass( 'lt-ie9' ) ) {
			progressbar.css( 'visibility', 'visible' );
			progressbar.each( function() {
				percentage = progressbar.find( '.progress' ).attr( 'aria-valuenow' );
				progressbar.find( '.progress' ).css( 'width', '0%' );
				progressbar.find( '.progress' ).animate( {
					width: percentage + '%'
				}, 'slow' );
			} );
		} else {
			progressbar.find( '.progress' ).css( 'width', function() {
				return jQuery( this ).attr( 'aria-valuenow' ) + '%';
			});
		}
	};

	// Set flip boxes equal front/back height
	jQuery.fn.fusionCalcFlipBoxesHeight = function() {
		var flipBox = jQuery( this ),
		    outerHeight,
		    height,
		    topMargin = 0;

		flipBox.find( '.flip-box-front' ).css( 'min-height', '' );
		flipBox.find( '.flip-box-back' ).css( 'min-height', '' );
		flipBox.find( '.flip-box-front-inner' ).css( 'margin-top', '' );
		flipBox.find( '.flip-box-back-inner' ).css( 'margin-top', '' );
		flipBox.css( 'min-height', '' );

		setTimeout( function() {
			if ( flipBox.find( '.flip-box-front' ).outerHeight() > flipBox.find( '.flip-box-back' ).outerHeight() ) {
				height = flipBox.find( '.flip-box-front' ).height();
				if ( cssua.ua.ie && '8' == cssua.ua.ie.substr( 0, 1 ) ) {
					outerHeight = flipBox.find( '.flip-box-front' ).height();
				} else {
					outerHeight = flipBox.find( '.flip-box-front' ).outerHeight();
				}
				topMargin = ( height - flipBox.find( '.flip-box-back-inner' ).outerHeight() ) / 2;

				flipBox.find( '.flip-box-back' ).css( 'min-height', outerHeight );
				flipBox.css( 'min-height', outerHeight );
				flipBox.find( '.flip-box-back-inner' ).css( 'margin-top', topMargin );
			} else {
				height = flipBox.find( '.flip-box-back' ).height();
				if ( cssua.ua.ie && '8' == cssua.ua.ie.substr( 0, 1 ) ) {
					outerHeight = flipBox.find( '.flip-box-back' ).height();
				} else {
					outerHeight = flipBox.find( '.flip-box-back' ).outerHeight();
				}
				topMargin = ( height - flipBox.find( '.flip-box-front-inner' ).outerHeight() ) / 2;

				flipBox.find( '.flip-box-front' ).css( 'min-height', outerHeight );
				flipBox.css( 'min-height', outerHeight );
				flipBox.find( '.flip-box-front-inner' ).css( 'margin-top', topMargin );
			}

			if ( cssua.ua.ie && '8' == cssua.ua.ie.substr( 0, 1 ) ) {
				flipBox.find( '.flip-box-back' ).css( 'height', '100%' );
			}

		}, 100 );
	};

	// Fusion scroller plugin to change css while scrolling
	jQuery.fn.fusionScroller = function( options ) {
		var settings = jQuery.extend({
				type: 'opacity',
				offset: 0,
				endOffset: ''
			}, options ),
		    divs = jQuery( this );

		divs.each( function() {
			var offset,
			    height,
			    endOffset,
			    currentElement = this;

			jQuery( window ).on( 'scroll', function() {

				var st,
				    diff,
				    diffPercentage,
				    opacity,
				    blur;

				offset = jQuery( currentElement ).offset().top;
				if ( jQuery( 'body' ).hasClass( 'admin-bar' ) ) {
					offset = jQuery( currentElement ).offset().top - jQuery( '#wpadminbar' ).outerHeight();
				}
				if ( 0 < settings.offset ) {
					offset = jQuery( currentElement ).offset().top - settings.offset;
				}
				height = jQuery( currentElement ).outerHeight();

				endOffset = offset + height;
				if ( settings.endOffset && jQuery( settings.endOffset ).length ) {
					endOffset = jQuery( settings.endOffset ).offset().top;
				}

				st = jQuery( this ).scrollTop();

				if ( st >= offset && st <= endOffset ) {
					diff = endOffset - st;
					diffPercentage = ( diff / height ) * 100;

					if ( 'opacity' === settings.type ) {
						opacity = ( diffPercentage / 100 ) * 1;
						jQuery( currentElement ).css({
							'opacity': opacity
						});
					} else if ( 'blur' === settings.type ) {
						diffPercentage = 100 - diffPercentage;
						blur = 'blur(' + ( ( diffPercentage / 100 ) * 50 ) + 'px)';
						jQuery( currentElement ).css({
							'-webkit-filter': blur,
							'-ms-filter': blur,
							'-o-filter': blur,
							'-moz-filter': blur,
							'filter': blur
						});
					} else if ( 'fading_blur' === settings.type ) {
						opacity = ( diffPercentage / 100 ) * 1;
						diffPercentage = 100 - diffPercentage;
						blur = 'blur(' + ( ( diffPercentage / 100 ) * 50 ) + 'px)';
						jQuery( currentElement ).css({
							'-webkit-filter': blur,
							'-ms-filter': blur,
							'-o-filter': blur,
							'-moz-filter': blur,
							'filter': blur,
							'opacity': opacity
						});
					}
				}

				if ( st < offset ) {
					if ( 'opacity' === settings.type ) {
						jQuery( currentElement ).css({
							'opacity': 1
						});
					} else if ( 'blur' === settings.type ) {
						blur = 'blur(0px)';
						jQuery( currentElement ).css({
							'-webkit-filter': blur,
							'-ms-filter': blur,
							'-o-filter': blur,
							'-moz-filter': blur,
							'filter': blur
						});
					} else if ( 'fading_blur' === settings.type ) {
						blur = 'blur(0px)';
						jQuery( currentElement ).css({
							'opacity': 1,
							'-webkit-filter': blur,
							'-ms-filter': blur,
							'-o-filter': blur,
							'-moz-filter': blur,
							'filter': blur
						});
					}
				}
			});
		});
	};

	// Change active tab when a link containing a tab ID is clicked; on and off page
	jQuery.fn.fusionSwitchTabOnLinkClick = function( $customID ) {

		var $linkHash,
		    $linkID;

		// The custom_id is used for on page links

		if ( $customID ) {
			$linkHash = $customID;
		} else {
			$linkHash = ( '#_' == document.location.hash.substring( 0, 2 ) ) ? document.location.hash.replace( '#_', '#' ) : document.location.hash;
		}
		$linkID = ( '#_' == $linkHash.substring( 0, 2 ) ) ? $linkHash.split( '#_' )[1] : $linkHash.split( '#' )[1];

		if ( $linkHash && jQuery( this ).find( '.nav-tabs li a[href="' + $linkHash + '"]' ).length ) {
			jQuery( this ).find( '.nav-tabs li' ).removeClass( 'active' );
			jQuery( this ).find( '.nav-tabs li a[href="' + $linkHash + '"]' ).parent().addClass( 'active' );

			jQuery( this ).find( '.tab-content .tab-pane' ).removeClass( 'in' ).removeClass( 'active' );
			jQuery( this ).find( '.tab-content .tab-pane[id="' + $linkID  + '"]' ).addClass( 'in' ).addClass( 'active' );
		}

		if ( $linkHash && jQuery( this ).find( '.nav-tabs li a[id="' + $linkID + '"]' ).length ) {
			jQuery( this ).find( '.nav-tabs li' ).removeClass( 'active' );
			jQuery( this ).find( '.nav-tabs li a[id="' + $linkID + '"]' ).parent().addClass( 'active' );

			jQuery( this ).find( '.tab-content .tab-pane' ).removeClass( 'in' ).removeClass( 'active' );
			jQuery( this ).find( '.tab-content .tab-pane[id="' + jQuery( this ).find( '.nav-tabs li a[id="' + $linkID + '"]' ).attr( 'href' ).split( '#' )[1] + '"]' ).addClass( 'in' ).addClass( 'active' );
		}
	};

	// Max height for columns and content boxes
	jQuery.fn.equalHeights = function( $minHeight, $maxHeight ) {

		var $tallest;

		if ( Modernizr.mq( 'only screen and (min-width: ' + avadaVars.content_break_point + 'px)' ) || Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)' ) ) {
			$tallest = ( $minHeight ) ? $minHeight : 0;

			this.each( function() {
				jQuery( this ).css( 'min-height', '0' );
				jQuery( this ).css( 'height', 'auto' );
				jQuery( this ).find( '.fusion-column-table' ).css( 'height', 'auto' );

				if ( jQuery( this ).outerHeight() > $tallest ) {
					$tallest = jQuery( this ).outerHeight();
				}
			});

			if ( ( $maxHeight ) && $tallest > $maxHeight ) {
				$tallest = $maxHeight;
			}

			return this.each( function() {
				var $newHeight = $tallest;

				// If $newHeight is 0, then there is no content in any of the columns. Set the empty column param, so that bg images can be scaled correctly
				if ( '0' == $newHeight ) {
					jQuery( this ).attr( 'data-empty-column', 'true' );
				}

				// Needed for vertically centered columns
				if ( jQuery( this ).children( '.fusion-column-table' ).length ) {
					$newHeight = $tallest - ( jQuery( this ).outerHeight() - jQuery( this ).height() );
				}

				jQuery( this ).css( 'min-height', $newHeight );
				jQuery( this ).find( '.fusion-column-table' ).height( $newHeight );
			});
		} else {
			return this.each( function() {
				jQuery( this ).css( 'min-height', '' );
				jQuery( this ).find( '.fusion-column-table' ).css( 'height', '' );
			});
		}
	};

	// Set the bg image dimensions of an empty column as data attributes
	jQuery.fn.fusion_set_bg_img_dims = function() {
		jQuery( this ).each( function() {

			var $backgroundImage,
			    $imageHeight,
			    $imageWidth;

			if ( ( '<div class="fusion-clearfix"></div>' === jQuery.trim( jQuery( this ).html() ) || '' === jQuery.trim( jQuery( this ).html() ) ) && jQuery( this ).data( 'bg-url' ) ) {

				// For background image we need to setup the image object to get the natural heights
				$backgroundImage = new Image();
				$backgroundImage.src = jQuery( this ).data( 'bg-url' );
				$imageHeight         = parseInt( $backgroundImage.naturalHeight );
				$imageWidth          = parseInt( $backgroundImage.naturalWidth );

				// IE8, Opera fallback
				$backgroundImage.onload = function() {
					$imageHeight = parseInt( this.height );
					$imageWidth = parseInt( this.width );
				};

				// Set the
				jQuery( this ).attr( 'data-bg-height', $imageHeight );
				jQuery( this ).attr( 'data-bg-width', $imageWidth );
			}
		});
	 };

	// Calculate the correct aspect ratio respecting height of an empty column with bg image
	jQuery.fn.fusion_calculate_empty_column_height = function() {

		jQuery( this ).each( function() {

			var $imageHeight,
			    $imageWidth,
			    $containerWidth,
			    $widthRatio,
			    $calculatedContainerHeight;

			if ( ( jQuery( this ).parents( '.fusion-equal-height-columns' ).length && ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.content_break_point + 'px)' ) || true === jQuery( this ).data( 'empty-column' ) ) ) || ! jQuery( this ).parents( '.fusion-equal-height-columns' ).length ) {
				if ( '<div class="fusion-clearfix"></div>' === jQuery.trim( jQuery( this ).html() ) || '' === jQuery.trim( jQuery( this ).html() ) ) {
					$imageHeight               = jQuery( this ).data( 'bg-height' );
					$imageWidth                = jQuery( this ).data( 'bg-width' );
					$containerWidth            = jQuery( this ).outerWidth();
					$widthRatio                = $containerWidth / $imageWidth;
					$calculatedContainerHeight = $imageHeight * $widthRatio;

					jQuery( this ).height( $calculatedContainerHeight );
				}
			}
		});
	 };

	// Reinitialize google map; needed when maps are loaded inside of hidden containers
	jQuery.fn.reinitializeGoogleMap = function() {
		var fusionMapObject = jQuery( this ).data( 'plugin_fusion_maps' ),
		    map,
		    center,
		    markers,
		    i;

		if ( fusionMapObject ) {
			map     = fusionMapObject.map,
			center  = map.getCenter(),
			markers = fusionMapObject.markers;

			google.maps.event.trigger( map, 'resize' );
			map.setCenter( center );
			if ( markers ) {
				for ( i = 0; i < markers.length; i++ ) {
					google.maps.event.trigger( markers[i], 'click' );
					google.maps.event.trigger( markers[i], 'click' );
				}
			}
		}
	};

	// Initialize fusion filters and corresponding posts
	jQuery.fn.fusionFiltersInitialization = function( $posts ) {

		var $filters,
		    $filterActive,
		    $filterActiveLink,
		    $filterActiveDataSlug;

		// Check if filters are displayed
		if ( jQuery( this ).length ) {

			// Show the filters container
			jQuery( this ).fadeIn();

			// Set needed variables
			$filters              = jQuery( this ).find( '.fusion-filter' );
			$filterActive         = jQuery( this ).find( '.fusion-active' );
			$filterActiveLink     = $filterActive.children( 'a' );
			$filterActiveDataSlug = $filterActiveLink.attr( 'data-filter' ).substr( 1 );

			// Loop through filters
			if ( $filters ) {
				$filters.each( function() {
					var $filter     = jQuery( this ),
					    $filterName = $filter.children( 'a' ).data( 'filter' );

					// Loop through initial post set
					if ( $posts ) {

						// If "All" filter is deactivated, hide posts for later check for active filter
						if ( $filterActiveDataSlug.length ) {
							$posts.hide();
						}

						$posts.each( function() {
							var $post            = jQuery( this ),
							    $postGalleryName = $post.find( '.fusion-rollover-gallery' ).data( 'rel' );

							// If a post belongs to an invisible filter, fade it in
							if ( $post.hasClass( $filterName.substr( 1 ) ) ) {
								if ( $filter.hasClass( 'fusion-hidden' ) ) {
									$filter.removeClass( 'fusion-hidden' );
								}
							}

							// If "All" filter is deactivated, only show the items of the first filter (which is auto activated)
							if ( $filterActive.length && $post.hasClass( $filterActive ) ) {
								$post.show();

								// Set the lightbox gallery
								$post.find( '.fusion-rollover-gallery' ).attr( 'data-rel', $postGalleryName.replace( 'gallery', $filterActive ) );
							}
						});
					}
				});
			}

			if ( $filterActiveDataSlug.length ) {

				// Relayout the posts according to filter selection
				jQuery( instance.elements ).isotope( { filter: '.' + $filterActive } );

				// Create new lightbox instance for the new gallery
				window.$ilInstances.push( jQuery( '[data-rel="iLightbox[' + $filterActive + ']"], [rel="iLightbox[' + $filterActive + ']"]' ).iLightBox( window.avadaLightBox.prepare_options( 'iLightbox[' + $filterActive + ']' ) ) );

				// Refresh the lightbox
				window.avadaLightBox.refresh_lightbox();

				// Set active filter to lightbox created
				$filterActiveLink.data( 'lightbox', 'created' );
			}
		}
	};

	// Initialize parallax footer
	jQuery.fn.fusion_footer_parallax = function() {
		var $footer = jQuery( this ),
		    $sliderHeight,
		    $footerHeight;

		// Needed timeout for dynamic footer content
		setTimeout( function() {
			var $wrapperHeight = ( 'fixed' === $footer.css( 'position' ) ) ? jQuery( '#wrapper' ).outerHeight() : jQuery( '#wrapper' ).outerHeight() - $footer.outerHeight();

			// On desktops enable parallax footer effect
			if ( $footer.outerHeight() < jQuery( window ).height() && $wrapperHeight > jQuery( window ).height() && ( 'Top' === avadaVars.header_position || ( 'Top' !== avadaVars.header_position && jQuery( window ).height() > jQuery( '.side-header-wrapper' ).height() ) ) && ( Modernizr.mq( 'only screen and (min-width:'  + parseInt( avadaVars.side_header_break_point ) +  'px)' ) && ! Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)' ) && ! Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape)' ) ) ) {
				$footer.css( {
					'position': '',
					'margin': '',
					'padding': ''
				});
				jQuery( '#main' ).css( 'margin-bottom', $footer.outerHeight() );

				if ( 1 <= jQuery( '.tfs-slider' ).length && 1 == jQuery( '.tfs-slider' ).data( 'parallax' ) && $footer.hasClass( 'fusion-footer-parallax' ) ) {
					$sliderHeight = jQuery( '.tfs-slider' ).parents( '#sliders-container' ).outerHeight();
					$footerHeight = $footer.outerHeight();
					if ( $sliderHeight > $footerHeight ) {
						jQuery( '#main' ).css( 'min-height', $sliderHeight + 100 );
					} else if ( $footerHeight > $sliderHeight ) {
						jQuery( '#main' ).css( 'min-height', $footerHeight + 100 );
					}
				}

			// On mobiles the footer will be static
			} else {
				$footer.css( {
					'position': 'static',
					'margin': '0',
					'padding': '0'
				});
				jQuery( '#main' ).css( 'margin-bottom', '' );
			}
		}, 1 );
	};

	jQuery.fn.fusion_countdown = function() {

		var $countdown = jQuery( this ),
		    $timer     = $countdown.data( 'timer' ).split( '-' ),
		    $GMToffset = $countdown.data( 'gmt-offset' ),
		    $omitWeeks = $countdown.data( 'omit-weeks' );

		$countdown.countDown({
			gmtOffset: $GMToffset,
			omitWeeks: $omitWeeks,
			targetDate: {

				'year':  $timer[0],
				'month': $timer[1],
				'day':   $timer[2],
				'hour':  $timer[3],
				'min':   $timer[4],
				'sec':   $timer[5]
			}

		});

		$countdown.css( 'visibility', 'visible' );
	};

	jQuery.fn.fusion_deactivate_mobile_image_hovers = function() {
		if ( 1 != avadaVars.disable_mobile_image_hovers ) {
			if ( Modernizr.mq( 'only screen and (max-width:' + avadaVars.side_header_break_point + 'px)' ) ) {
				jQuery( this ).removeClass( 'fusion-image-hovers' );
			} else {
				jQuery( this ).addClass( 'fusion-image-hovers' );
			}
		}
	};

	// Add/remove the mobile title class, depending on available space and title length
	jQuery.fn.fusion_responsive_title_shortcode = function() {
		jQuery( this ).each( function() {
			var $titleWrapper        = jQuery( this ),
			    $title               = $titleWrapper.find( 'h1, h2, h3, h4, h5, h6' ),
			    $titleMinWidth       = ( $title.data( 'min-width' ) ) ? $title.data( 'min-width' ) : $title.outerWidth(),
			    $wrappingParent      = $titleWrapper.parent(),
			    $wrappingParentWidth = ( $titleWrapper.parents( '.slide-content' ).length ) ? $wrappingParent.width() : $wrappingParent.outerWidth();

			if ( ( 0 === $titleMinWidth || false === $titleMinWidth || '0' === $titleMinWidth ) && ( 0 === $wrappingParentWidth || false === $wrappingParentWidth || '0' === $wrappingParentWidth ) ) {
				$titleWrapper.removeClass( 'fusion-border-below-title' );
			} else if ( $titleMinWidth + 100 >= $wrappingParentWidth ) {
				$titleWrapper.addClass( 'fusion-border-below-title' );
				$title.data( 'min-width', $titleMinWidth );
			} else {
				$titleWrapper.removeClass( 'fusion-border-below-title' );
			}
		});
	};

	// Smooth scrolling to anchor target
	jQuery.fn.fusion_scroll_to_anchor_target = function() {
		var $href     = jQuery( this ).attr( 'href' ),
		    $hrefHash = $href.substr( $href.indexOf( '#' ) ).slice( 1 ),
		    $target   = jQuery( '#' + $hrefHash ),
		    $adminbarHeight,
		    $stickyHeaderHeight,
		    $currentScrollPosition,
		    $newScrollPosition,
		    $halfScrollAmount,
		    $halfScrollPosition;

		if ( $target.length && '' !== $hrefHash ) {
			$adminbarHeight        = getAdminbarHeight();
			$stickyHeaderHeight    = getStickyHeaderHeight();
			$currentScrollPosition = jQuery( document ).scrollTop();
			$newScrollPosition     = $target.offset().top - $adminbarHeight - $stickyHeaderHeight;
			$halfScrollAmount      = Math.abs( $currentScrollPosition - $newScrollPosition ) / 2;

			if ( $currentScrollPosition > $newScrollPosition ) {
				$halfScrollPosition = $currentScrollPosition - $halfScrollAmount;
			} else {
				$halfScrollPosition = $currentScrollPosition + $halfScrollAmount;
			}

			jQuery( 'html, body' ).animate({
				 scrollTop: $halfScrollPosition
			}, { duration: 400, easing: 'easeInExpo', complete: function() {

					$adminbarHeight = getAdminbarHeight();
					$stickyHeaderHeight = getStickyHeaderHeight();

					$newScrollPosition = ( $target.offset().top - $adminbarHeight - $stickyHeaderHeight );

					jQuery( 'html, body' ).animate({
						 scrollTop: $newScrollPosition
					}, 450, 'easeOutExpo' );

				}

			});

			// On page tab link
			if ( $target.hasClass( 'tab-link' ) ) {
				jQuery( '.fusion-tabs' ).fusionSwitchTabOnLinkClick();
			}

			return false;
		}
	};

})( jQuery );

jQuery( window ).load( function() { // Start window_load_1

	var columnClasses,
	    reviewsCycleArgs,
	    iosVersion,
	    i;

	// Static layout
	if ( '0' == avadaVars.is_responsive ) {
		columnClasses = ['col-sm-0', 'col-sm-1', 'col-sm-2', 'col-sm-3', 'col-sm-4', 'col-sm-5', 'col-sm-6', 'col-sm-7', 'col-sm-8', 'col-sm-9', 'col-sm-10', 'col-sm-11', 'col-sm-12'];
		jQuery( '.col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12' ).each( function() {
			for ( i = 0; i < columnClasses.length; i++ ) {
				if ( -1 !== jQuery( this ).attr( 'class' ).indexOf( columnClasses[ i ] ) ) {
					jQuery( this ).addClass( 'col-xs-' + i );
				}
			}
		});
	}

	// Initialize Waypoint
	setTimeout( function() {
		jQuery( window ).init_waypoint();
		jQuery.waypoints( 'viewportHeight' );
	}, 300 );

	// Counters Box - Modals
	jQuery( '.fusion-modal .fusion-counter-box' ).each( function() {
		jQuery( this ).appear( function() {
			jQuery( this ).find( '.display-counter' ).each( function() {
				jQuery( this ).$fusionBoxCounting();
			});
		});
	});

	// Counter Circles - Toggles, Tabs, Modals
	jQuery( '.fusion-accordian .counter-circle-wrapper, .fusion-tabs .counter-circle-wrapper, .fusion-modal .counter-circle-wrapper' ).each( function() {
		jQuery( this ).appear( function() {
			jQuery( this ).fusion_draw_circles();
		});
	});

	// Progressbar - Modals
	jQuery( '.fusion-modal .fusion-progressbar' ).each( function() {
		jQuery( this ).appear( function() {
			jQuery( this ).fusion_draw_progress();
		});
	});

	// Flip Boxes
	jQuery( '.flip-box-inner-wrapper' ).each( function() {
		jQuery( this ).fusionCalcFlipBoxesHeight();
	});

	jQuery( window ).resize( function() {
		jQuery( '.flip-box-inner-wrapper' ).each( function() {
			jQuery( this ).fusionCalcFlipBoxesHeight();
		});
	});

	// Testimonials
	function onBefore( curr, next, opts, fwd ) {
	  var $ht = jQuery( this ).height();

	  // Set the active testimonial class for resize event
	  jQuery( this ).parent().children().removeClass( 'active-testimonial' );
	  jQuery( this ).addClass( 'active-testimonial' );

	  // Set the container's height to that of the current slide
	  jQuery( this ).parent().animate( { height: $ht }, 500 );
	}

	if ( jQuery().cycle ) {
		reviewsCycleArgs = {
			fx: 'fade',
			before:  onBefore,
			containerResize: 0,
			containerResizeHeight: 1,
			height: 'auto',
			width: '100%',
			fit: 1,
			speed: 500,
			delay: 0
		};

		if ( avadaVars.testimonials_speed ) {
			reviewsCycleArgs.timeout = parseInt( avadaVars.testimonials_speed );
		}

		reviewsCycleArgs.pager = '.testimonial-pagination';

		jQuery( '.fusion-testimonials .reviews' ).each( function() {
			if ( 1 == jQuery( this ).children().length ) {
				jQuery( this ).children().fadeIn();
			}

			reviewsCycleArgs.pager = '#' + jQuery( this ).parent().find( '.testimonial-pagination' ).attr( 'id' );

			reviewsCycleArgs.random = jQuery( this ).parent().data( 'random' );
			jQuery( this ).cycle( reviewsCycleArgs );
		});

		jQuery( window ).resize( function() {
			jQuery( '.fusion-testimonials .reviews' ).each( function() {
				jQuery( this ).css( 'height', jQuery( this ).children( '.active-testimonial' ).height() );
			});
		});
	}

	// Toggles
	jQuery( document ).on( 'click dblclick', '.fusion-accordian .panel-title a', function( e ) {

		var clickedToggle,
		    toggleContentToActivate;

		e.preventDefault();

		clickedToggle = jQuery( this );
		toggleContentToActivate = jQuery( jQuery( this ).data( 'target' ) ).find( '.panel-body' );

		if ( clickedToggle.hasClass( 'active' ) ) {
			clickedToggle.parents( '.fusion-accordian' ).find( '.panel-title a' ).removeClass( 'active' );
		} else {
			clickedToggle.parents( '.fusion-accordian' ).find( '.panel-title a' ).removeClass( 'active' );
			clickedToggle.addClass( 'active' );

			setTimeout( function() {
				toggleContentToActivate.find( '.shortcode-map' ).each( function() {
					jQuery( this ).reinitializeGoogleMap();
				});

				if ( toggleContentToActivate.find( '.fusion-carousel' ).length ) {
					generateCarousel();
				}

				toggleContentToActivate.find( '.fusion-portfolio' ).each( function() {
					jQuery( this ).find( '.fusion-portfolio-wrapper' ).isotope();
				});

				// To make premium sliders work in tabs.
				if ( toggleContentToActivate.find( '.flexslider, .rev_slider_wrapper, .ls-container' ).length ) {
					jQuery( window ).trigger( 'resize' );
				}

				// Flip Boxes.
				toggleContentToActivate.find( '.flip-box-inner-wrapper' ).each( function() {
					jQuery( this ).fusionCalcFlipBoxesHeight();
				});

				// Columns.
				toggleContentToActivate.find( '.fusion-fullwidth.fusion-equal-height-columns' ).each( function() {
					jQuery( this ).find( '.fusion-layout-column .fusion-column-wrapper' ).equalHeights();
				});

				// Block element.
				toggleContentToActivate.find( '.fusion-blog-shortcode' ).each( function() {
					var columns = 2,
					    gridWidth;
					for ( i = 1; i < 7; i++ ) {
						if ( jQuery( this ).find( '.fusion-blog-layout-grid' ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
							columns = i;
						}
					}

					gridWidth = Math.floor( 100 / columns * 100 ) / 100  + '%';
					jQuery( this ).find( '.fusion-blog-layout-grid' ).find( '.fusion-post-grid' ).css( 'width', gridWidth );

					jQuery( this ).find( '.fusion-blog-layout-grid' ).isotope();

					// Reinitialize select arrows
					calcSelectArrowDimensions();
				});
			}, 350 );
		}
	});

	// Initialize Bootstrap Modals
	jQuery( '.fusion-modal' ).each( function() {
		jQuery( '#wrapper' ).append( jQuery( this ) );
	});

	jQuery( '.fusion-modal' ).bind( 'hidden.bs.modal', function() {
		jQuery( 'html' ).css( 'overflow', '' );
	});

	jQuery( '.fusion-modal' ).bind( 'show.bs.modal', function() {
		var $slidingbar = jQuery( '#slidingbar' ),
		    modalWindow,
		    $activeTestimonial;

		jQuery( 'html' ).css( 'overflow', 'visible' );

		modalWindow = jQuery( this );

		// Reinitialize dynamic content
		setTimeout( function() {

			// Autoplay youtube videos, if the params have been set accordingly in the video shortcodes
			modalWindow.find( '.fusion-youtube' ).find( 'iframe' ).each( function( i ) {

				var func;
				if ( 1 === jQuery( this ).parents( '.fusion-video' ).data( 'autoplay' ) || 'true' === jQuery( this ).parents( '.fusion-video' ).data( 'autoplay' ) ) {
					jQuery( this ).parents( '.fusion-video' ).data( 'autoplay', 'false' );

					func = 'playVideo';
					this.contentWindow.postMessage( '{"event":"command","func":"' + func + '","args":""}', '*' );
				}
			});

			// Autoplay vimeo videos, if the params have been set accordingly in the video shortcodes
			modalWindow.find( '.fusion-vimeo' ).find( 'iframe' ).each( function( i ) {
				if ( 1 === jQuery( this ).parents( '.fusion-video' ).data( 'autoplay' ) || 'true' === jQuery( this ).parents( '.fusion-video' ).data( 'autoplay' ) ) {
					jQuery( this ).parents( '.fusion-video' ).data( 'autoplay', 'false' );

					$f( jQuery( this )[0] ).api( 'play' );
				}
			});

			// To make premium sliders work in tabs
			if ( modalWindow.find( '.flexslider, .rev_slider_wrapper, .ls-container' ).length ) {
				jQuery( window ).trigger( 'resize' );
			}

			// Flip Boxes
			modalWindow.find( '.flip-box-inner-wrapper' ).each( function() {
				jQuery( this ).fusionCalcFlipBoxesHeight();
			});

			// Reinitialize carousels
			if ( modalWindow.find( '.fusion-carousel' ).length ) {
				generateCarousel();
			}

			// Reinitialize blog shortcode isotope grid
			modalWindow.find( '.fusion-blog-shortcode' ).each( function() {
				var columns = 2,
				    gridWidth;

				for ( i = 1; i < 7; i++ ) {
					if ( jQuery( this ).find( '.fusion-blog-layout-grid' ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
						columns = i;
					}
				}

				gridWidth = Math.floor( 100 / columns * 100 ) / 100  + '%';
				jQuery( this ).find( '.fusion-blog-layout-grid' ).find( '.fusion-post-grid' ).css( 'width', gridWidth );

				jQuery( this ).find( '.fusion-blog-layout-grid' ).isotope();

				calcSelectArrowDimensions();
			});

			// Reinitialize google maps
			modalWindow.find( '.shortcode-map' ).each( function() {
				jQuery( this ).reinitializeGoogleMap();
			});

			// Reinitialize portfolio
			modalWindow.find( '.fusion-portfolio' ).each( function() {
				jQuery( this ).find( '.fusion-portfolio-wrapper' ).isotope();
			});

			// Reinitialize testimonial height; only needed for hidden wrappers
			if ( $slidingbar.find( '.fusion-testimonials' ).length ) {
				$activeTestimonial = $slidingbar.find( '.fusion-testimonials .reviews' ).children( '.active-testimonial' );

				$slidingbar.find( '.fusion-testimonials .reviews' ).height( $activeTestimonial.height() );
			}

			// Reinitialize select arrows
			calcSelectArrowDimensions();
		}, 350 );
	});

	if ( 1 == jQuery( '#sliders-container .tfs-slider' ).data( 'parallax' ) ) {
		jQuery( '.fusion-modal' ).css( 'top', jQuery( '.header-wrapper' ).height() );
	}

	// Stop videos in modals when closed
	jQuery( '.fusion-modal' ).each( function() {
		jQuery( this ).on( 'hide.bs.modal', function() {

			// Youtube
			jQuery( this ).find( 'iframe' ).each( function( i ) {
				var func = 'pauseVideo';
				this.contentWindow.postMessage( '{"event":"command","func":"' + func + '","args":""}', '*' );
			});

			// Vimeo
			jQuery( this ).find( '.fusion-vimeo iframe' ).each( function( i ) {
				$f( this ).api( 'pause' );
			});
		});
	});

	jQuery( '[data-toggle=modal]' ).on( 'click', function( e ) {
		e.preventDefault();
	});

	jQuery( '.fusion-modal-text-link' ).click( function( e ) {
		e.preventDefault();
	});

	if ( cssua.ua.mobile || cssua.ua.tablet_pc ) {
		jQuery( '.fusion-popover, .fusion-tooltip' ).each( function() {
			jQuery( this ).attr( 'data-trigger', 'click' );
			jQuery( this ).data( 'trigger', 'click' );
		});
	}

	// Initialize Bootstrap Popovers
	jQuery( '[data-toggle~="popover"]' ).popover({
		container: 'body'
	});

	// Initialize Bootstrap Tabs
	// Initialize vertical tabs content container height
	if ( jQuery( '.vertical-tabs' ).length ) {
		jQuery( '.vertical-tabs .tab-content .tab-pane' ).each( function() {

			var videoWidth;

			if ( jQuery( this ).parents( '.vertical-tabs' ).hasClass( 'clean' ) ) {
				jQuery( this ).css( 'min-height', jQuery( '.vertical-tabs .nav-tabs' ).outerHeight() - 10 );
			} else {
				jQuery( this ).css( 'min-height', jQuery( '.vertical-tabs .nav-tabs' ).outerHeight() );
			}

			if ( jQuery( this ).find( '.video-shortcode' ).length ) {
				videoWidth = parseInt( jQuery( this ).find( '.fusion-video' ).css( 'max-width' ).replace( 'px', '' ) );
				jQuery( this ).css({
					'float': 'none',
					'max-width': videoWidth + 60
				});
			}
		});
	}

	jQuery( window ).on( 'resize', function() {
		if ( jQuery( '.vertical-tabs' ).length ) {
			jQuery( '.vertical-tabs .tab-content .tab-pane' ).css( 'min-height', jQuery( '.vertical-tabs .nav-tabs' ).outerHeight() );
		}
	});

	// Initialize Bootstrap Tooltip
	jQuery( '[data-toggle="tooltip"]' ).each( function() {

		var $container;

		if ( jQuery( this ).parents( '.fusion-header-wrapper' ).length ) {
			$container = '.fusion-header-wrapper';
		} else if ( jQuery( this ).parents( '#side-header' ).length ) {
			$container = '#side-header';
		} else {
			$container = 'body';
		}

		jQuery( this ).tooltip({
			container: $container
		});
	});

	jQuery( '.fusion-tooltip' ).hover( function() {

		// Get the current title attribute
		var $title = jQuery( this ).attr( 'title' );

			// Store it in a data var
			jQuery( this ).attr( 'data-title', $title );

			// Set the title to nothing so we don't see the tooltips
			jQuery( this ).attr( 'title', '' );

	});

	 jQuery( '.fusion-tooltip' ).click( function() {

			// Retrieve the title from the data attribute
			var $title = jQuery( this ).attr( 'data-title' );

			// Return the title to what it was
			jQuery( this ).attr( 'title', $title );

			jQuery( this ).blur();

		});

	// Events Calendar Reinitialize Scripts
	jQuery( '.tribe_events_filters_close_filters, .tribe_events_filters_show_filters' ).on( 'click', function() {
		var tribeEvents = jQuery( this );

		setTimeout( function() {
			jQuery( tribeEvents ).parents( '#tribe-events-content-wrapper' ).find( '.fusion-blog-layout-grid' ).isotope();
		});
	});

	generateCarousel();

	// Equal Heights Elements
	jQuery( '.content-boxes-icon-boxed' ).each( function() {
		jQuery( this ).find( '.content-box-column .content-wrapper-boxed' ).equalHeights();
		jQuery( this ).find( '.content-box-column .content-wrapper-boxed' ).css( 'overflow', 'visible' );
	});

	jQuery( window ).on( 'resize', function() {
		jQuery( '.content-boxes-icon-boxed' ).each( function() {
			jQuery( this ).find( '.content-box-column .content-wrapper-boxed' ).equalHeights();
			jQuery( this ).find( '.content-box-column .content-wrapper-boxed' ).css( 'overflow', 'visible' );
		});
	});

	jQuery( '.content-boxes-clean-vertical' ).each( function() {
		jQuery( this ).find( '.content-box-column .col' ).equalHeights();
		jQuery( this ).find( '.content-box-column .col' ).css( 'overflow', 'visible' );
	});

	jQuery( window ).on( 'resize', function() {
		jQuery( '.content-boxes-clean-vertical' ).each( function() {
			jQuery( this ).find( '.content-box-column .col' ).equalHeights();
			jQuery( this ).find( '.content-box-column .col' ).css( 'overflow', 'visible' );
		});
	});

	jQuery( '.content-boxes-clean-horizontal' ).each( function() {
		jQuery( this ).find( '.content-box-column .col' ).equalHeights();
		jQuery( this ).find( '.content-box-column .col' ).css( 'overflow', 'visible' );
	});

	jQuery( window ).on( 'resize', function() {
		jQuery( '.content-boxes-clean-horizontal' ).each( function() {
			jQuery( this ).find( '.content-box-column .col' ).equalHeights();
			jQuery( this ).find( '.content-box-column .col' ).css( 'overflow', 'visible' );
		});
	});

	jQuery( '.double-sidebars.woocommerce .social-share > li' ).equalHeights();

	jQuery( '.fusion-fullwidth.fusion-equal-height-columns' ).each( function() {
		jQuery( this ).find( '.fusion-layout-column .fusion-column-wrapper' ).not( function( $index, $element ) {
			return jQuery( $element ).parents( '.fusion-column-wrapper' ).length ? 1 : 0;
		}).equalHeights();
	});

	jQuery( '.fusion-fullwidth.fusion-equal-height-columns .fusion-builder-row' ).each( function() {
		jQuery( this ).find( '.fusion-layout-column .fusion-column-wrapper' ).not( function( $index, $element ) {
			return jQuery( $element ).parent( '.fusion-column-wrapper' ).length ? 1 : 0;
		}).equalHeights();
	});

	jQuery( '.fusion-layout-column .fusion-column-wrapper' ).fusion_set_bg_img_dims();
	jQuery( '.fusion-layout-column .fusion-column-wrapper' ).fusion_calculate_empty_column_height();

	jQuery( window ).on( 'resize', function() {
		jQuery( '.fusion-fullwidth.fusion-equal-height-columns' ).each( function() {
			jQuery( this ).find( '.fusion-layout-column .fusion-column-wrapper' ).not( function( $index, $element ) {
				return jQuery( $element ).parents( '.fusion-column-wrapper' ).length ? 1 : 0;
			}).equalHeights();
		});

		jQuery( '.fusion-fullwidth.fusion-equal-height-columns .fusion-builder-row' ).each( function() {
			jQuery( this ).find( '.fusion-layout-column .fusion-column-wrapper' ).not( function( $index, $element ) {
				return jQuery( $element ).parent( '.fusion-column-wrapper' ).length ? 1 : 0;
			}).equalHeights();
		});

		jQuery( '.fusion-layout-column .fusion-column-wrapper' ).fusion_calculate_empty_column_height();
	});

	/**
	 * Icon Hack for iOS7 on Buttons
	 */
	if ( cssua.ua.ios ) {
		iosVersion = parseInt( cssua.ua.ios );
		if ( 7 == iosVersion ) {
			jQuery( '.button-icon-divider-left, .button-icon-divider-right' ).each( function() {
				var height = jQuery( this ).parent().outerHeight();
				jQuery( this ).css( 'height', height );

			});
		}
	}
}); // End window_load_1

jQuery( document ).ajaxComplete( function() {
	jQuery( '.wpcf7-response-output' ).each( function() {
		if ( jQuery( this ).hasClass( 'wpcf7-mail-sent-ng' ) && ! jQuery( this ).find( '.alert-icon' ).length ) {
			jQuery( this ).addClass( 'fusion-alert' );
			if ( jQuery( 'body' ).hasClass( 'rtl' ) ) {
				jQuery( this ).append( '<button class="close toggle-alert" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><span class="alert-icon"><i class="fa fa-lg fa-exclamation-triangle"></i></span>' );
			} else {
				jQuery( this ).prepend( '<button class="close toggle-alert" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><span class="alert-icon"><i class="fa fa-lg fa-exclamation-triangle"></i></span>' );
			}
		}

		if ( jQuery( this ).hasClass( 'wpcf7-validation-errors' ) && ! jQuery( this ).find( '.alert-icon' ).length ) {
			jQuery( this ).addClass( 'fusion-alert' );
			if ( jQuery( 'body' ).hasClass( 'rtl' ) ) {
				jQuery( this ).append( '<button class="close toggle-alert" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><span class="alert-icon"><i class="fa fa-lg fa-exclamation-triangle"></i></span>' );
			} else {
				jQuery( this ).prepend( '<button class="close toggle-alert" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><span class="alert-icon"><i class="fa fa-lg fa-exclamation-triangle"></i></span>' );
			}
		}

		if ( jQuery( this ).hasClass( 'wpcf7-mail-sent-ok' ) && ! jQuery( this ).find( '.alert-icon' ).length ) {
			jQuery( this ).addClass( 'fusion-alert' );
			if ( jQuery( 'body' ).hasClass( 'rtl' ) ) {
				jQuery( this ).append( '<button class="close toggle-alert" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><span class="alert-icon"><i class="fa fa-lg fa-check-circle"></i></span>' );
			} else {
				jQuery( this ).prepend( '<button class="close toggle-alert" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><span class="alert-icon"><i class="fa fa-lg fa-check-circle"></i></span>' );
			}
		}
	});

	jQuery( '.wpcf7-response-output.fusion-alert .close' ).click( function( e ) {
		e.preventDefault();

		jQuery( this ).parent().slideUp();
	});

	avadaAddQuantityBoxes();
});

jQuery( document ).ready( function( $ ) { // Start document_ready_1

	var titleSep,
	    titleSepClassString,
	    titleMainSepClassString,
	    sidebar1Float,
	    slidingbarState,
	    $adminbarHeight,
	    $stickyHeaderHeight,
	    $tabToActivate,
	    $buttonHeight,
	    $countdownID,
	    $titleSep,
	    $titleSepClassString,
	    $titleMainSepClassString,
	    $styles,
	    tabToActivate,
	    i,
	    froogaloopLoaded;

	addStylesForOldIEVersions();

	avadaAddQuantityBoxes();

	// Deactivate image hover animations on mobiles
	jQuery( 'body' ).fusion_deactivate_mobile_image_hovers();
	jQuery( window ).on( 'resize', function() {
		jQuery( 'body' ).fusion_deactivate_mobile_image_hovers();
	});

	// Setup the countdown shortcodes
	jQuery( '.fusion-countdown-counter-wrapper' ).each( function() {
		$countdownID = jQuery( this ).attr( 'id' );
		jQuery( '#' + $countdownID ).fusion_countdown();
	});

	// Make the side header scrolling happen
	jQuery( window ).on( 'scroll', fusionSideHeaderScroll );
	jQuery( window ).on( 'resize', fusionSideHeaderScroll );

	// Loop through all headings
	jQuery( 'h1, h2, h3, h4, h5, h6' ).each(
		function() {

			// If there are inline styles on the element initially, store information about it in data attribute
			if ( jQuery( this ).prop( 'style' )['font-size'] ) {
				jQuery( this ).attr( 'data-inline-fontsize', true );
			}

			if ( jQuery( this ).prop( 'style' )['font-size'] ) {
				jQuery( this ).attr( 'data-inline-lineheight', true );
			}

			// Set the original font size and line height to every heading as data attribute
			jQuery( this ).attr( 'data-fontsize', parseInt( jQuery( this ).css( 'font-size' ) ) );
			jQuery( this ).attr( 'data-lineheight', parseInt( jQuery( this ).css( 'line-height' ) ) );
		}
	);

	// Setup responsive type for headings if enabled in Theme Options
	if ( 1 == avadaVars.typography_responsive ) {

		// Calculate responsive type values
		fusionCalculateResponsiveTypeValues( avadaVars.typography_sensitivity, avadaVars.typography_factor, 800, 'h1, h2, h3, h4, h5, h6' );
	}

	jQuery( '.tfs-slider' ).each( function() {
		fusionCalculateResponsiveTypeValues( jQuery( this ).data( 'typo_sensitivity' ), jQuery( this ).data( 'typo_factor' ), 800, '.tfs-slider h2, .tfs-slider h3' );
	});

	// Carousel resize
	jQuery( window ).on( 'resize', function() {
		jQuery( '.fusion-carousel' ).fusion_recalculate_carousel();
	});

	// Enable autoplaying videos when not in a modal
	jQuery( '.fusion-video' ).each( function() {
		if ( ! jQuery( this ).parents( '.fusion-modal' ).length && 1 == jQuery( this ).data( 'autoplay' ) && jQuery( this ).is( ':visible' ) ) {
			jQuery( this ).find( 'iframe' ).each( function( i ) {
				jQuery( this ).attr( 'src', jQuery( this ).attr( 'src' ).replace( 'autoplay=0', 'autoplay=1' ) );
			});
		}
	});

	froogaloopLoaded = false;
	if ( Number( avadaVars.status_vimeo ) &&  jQuery( '.fusion-vimeo' ).length ) {
		jQuery.getScript( 'https://secure-a.vimeocdn.com/js/froogaloop2.min.js' ).done(
			function( script, textStatus ) {
				froogaloopLoaded = true;
			}
		);
	}

	// Video resize
	jQuery( window ).on( 'resize', function() {

		var vimeoPlayers = document.querySelectorAll( 'iframe' ),
		    player,
		    i,
		    length = vimeoPlayers.length,
		    func   = 'pauseVideo';

		// Stop autoplaying youtube video when not visible on resize
		jQuery( '.fusion-youtube' ).each( function() {
			if ( ! jQuery( this ).is( ':visible' ) && ( ! jQuery( this ).parents( '.fusion-modal' ).length || jQuery( this ).parents( '.fusion-modal' ).is( ':visible' ) ) ) {
				jQuery( this ).find( 'iframe' ).each( function( i ) {
					this.contentWindow.postMessage( '{"event":"command","func":"' + func + '","args":""}', '*' );
				});
			}
		});

		// Stop autoplaying vimeo video when not visible on resize
		if ( froogaloopLoaded ) {

			for ( i = 0; i < length; i++ ) {
				if ( ! jQuery( vimeoPlayers[i] ).is( ':visible' )  && ( ! jQuery( vimeoPlayers[i] ).parents( '.fusion-modal' ).length || jQuery( vimeoPlayers[i] ).parents( '.fusion-modal' ).is( ':visible' ) ) ) {
					player = $f( vimeoPlayers[i] );
					player.api( 'pause' );
				}
			}
		}
	});

	// Handle parallax footer
	jQuery( '.fusion-footer-parallax' ).fusion_footer_parallax();

	jQuery( window ).on( 'resize', function() {
		jQuery( '.fusion-footer-parallax' ).fusion_footer_parallax();
	});

	// Disable bottom margin on empty footer columns
	jQuery( '.fusion-footer .fusion-footer-widget-area .fusion-column' ).each(
		function() {
			if ( jQuery( this ).is( ':empty' ) ) {
				jQuery( this ).css( 'margin-bottom', '0' );
			}
		}
	);

	if ( '1' != avadaVars.disable_mobile_animate_css && cssua.ua.mobile ) {
		jQuery( 'body' ).addClass( 'dont-animate' );
	} else {
		jQuery( 'body' ).addClass( 'do-animate' );
	}

	// Comment form title changes
	if ( jQuery( '.comment-respond .comment-reply-title' ).length && ! jQuery( '.comment-respond .comment-reply-title' ).parents( '.woocommerce-tabs' ).length ) {
		$titleSep                = avadaVars.title_style_type.split( ' ' );
		$titleSepClassString     = '';
		$titleMainSepClassString = '';

		for ( i = 0; i < $titleSep.length; i++ ) {
			$titleSepClassString += ' sep-' + $titleSep[i];
		}

		if ( $titleSepClassString.indexOf( 'underline' ) > -1 ) {
			$titleMainSepClassString = $titleSepClassString;
		}

		if ( jQuery( 'body' ).hasClass( 'rtl' ) ) {
			jQuery( '.comment-respond .comment-reply-title' ).addClass( 'title-heading-right' );
		} else {
			jQuery( '.comment-respond .comment-reply-title' ).addClass( 'title-heading-left' );
		}

		$styles = ' style="margin-top:' + avadaVars.title_margin_top + ';margin-bottom:' + avadaVars.title_margin_bottom + ';"';

		jQuery( '.comment-respond .comment-reply-title' ).wrap( '<div class="fusion-title title fusion-title-size-three' + $titleSepClassString + '"' + $styles + '></div>' );

		if ( $titleSepClassString.indexOf( 'underline' ) == -1 ) {
			jQuery( '.comment-respond .comment-reply-title' ).parent().append( '<div class="title-sep-container"><div class="title-sep' + $titleSepClassString + ' "></div></div>' );
		}
	}

	// Sidebar Position
	if ( 1 <= jQuery( '#sidebar-2' ).length ) {
		sidebar1Float = jQuery( '#sidebar' ).css( 'float' );
		jQuery( 'body' ).addClass( 'sidebar-position-' + sidebar1Float );
	}

	jQuery( '.fusion-flip-box' ).mouseover( function() {
		jQuery( this ).addClass( 'hover' );
	});

	jQuery( '.fusion-flip-box' ).mouseout( function() {
		jQuery( this ).removeClass( 'hover' );
	});

	jQuery( '.fusion-accordian .panel-title a' ).click( function( e ) {
		e.preventDefault();
	});

	jQuery( '.my-show' ).click( function() {
		jQuery( '.my-hidden' ).css( 'visibility', 'visible' );
	});

	if ( jQuery( '.demo_store' ).length ) {
		jQuery( '#wrapper' ).css( 'margin-top', jQuery( '.demo_store' ).outerHeight() );
		if ( 0 < jQuery( '#slidingbar-area' ).outerHeight() ) {
			jQuery( '.header-wrapper' ).css( 'margin-top', '0' );
		}
		if ( jQuery( '.sticky-header' ).length ) {
			jQuery( '.sticky-header' ).css( 'margin-top', jQuery( '.demo_store' ).outerHeight() );
		}
	}

	// Slidingbar initialization
	slidingbarState = 0;

	// Open slidingbar on page load if .open_onload class is present
	if ( jQuery( '#slidingbar-area.open_onload' ).length ) {
		jQuery( '#slidingbar' ).slideDown( 240, 'easeOutQuad' );
		jQuery( '.sb-toggle' ).addClass( 'open' );
		slidingbarState = 1;

		// Reinitialize google maps
		if ( jQuery( '#slidingbar .shortcode-map' ).length ) {
			jQuery( '#slidingbar' ).find( '.shortcode-map' ).each( function() {
				jQuery( this ).reinitializeGoogleMap();
			});
		}

		jQuery( '#slidingbar-area' ).removeClass( 'open_onload' );
	}

	// Handle the slidingbar toggle click
	jQuery( '.sb-toggle' ).click( function() {
		var $slidingbar = jQuery( this ).parents( '#slidingbar-area' ).children( '#slidingbar' ),
		    $activeTestimonial;

		// Expand
		if ( 0 === slidingbarState ) {
			$slidingbar.slideDown( 240, 'easeOutQuad' );
			jQuery( '.sb-toggle' ).addClass( 'open' );
			slidingbarState = 1;

			// Reinitialize google maps
			if ( $slidingbar.find( '.shortcode-map' ).length ) {
				$slidingbar.find( '.shortcode-map' ).each( function() {
					jQuery( this ).reinitializeGoogleMap();
				});
			}

			// Reinitialize carousels
			if ( $slidingbar.find( '.fusion-carousel' ).length ) {
				generateCarousel();
			}

			jQuery( '#slidingbar' ).find( '.fusion-carousel' ).fusion_recalculate_carousel();

			// Reinitialize testimonial height; only needed for hidden wrappers
			if ( $slidingbar.find( '.fusion-testimonials' ).length ) {
				$activeTestimonial = $slidingbar.find( '.fusion-testimonials .reviews' ).children( '.active-testimonial' );

				$slidingbar.find( '.fusion-testimonials .reviews' ).height( $activeTestimonial.height() );
			}

		//Collapse
	} else if ( 1 == slidingbarState ) {
			$slidingbar.slideUp( 240, 'easeOutQuad' );
			jQuery( '.sb-toggle' ).removeClass( 'open' );
			slidingbarState = 0;
		}
	});

	// Foter without social icons
	if ( ! jQuery( '.fusion-social-links-footer' ).find( '.fusion-social-networks' ).children().length ) {
		jQuery( '.fusion-social-links-footer' ).hide();
		jQuery( '.fusion-footer-copyright-area .fusion-copyright-notice' ).css( 'padding-bottom', '0' );
	}

	// To top
	if ( jQuery().UItoTop ) {
		if ( cssua.ua.mobile && '1' == avadaVars.status_totop_mobile ) {
			jQuery().UItoTop({ easingType: 'easeOutQuart' });
		} else if ( ! cssua.ua.mobile ) {
			jQuery().UItoTop({ easingType: 'easeOutQuart' });
		}
	}

	// Sticky header resizing control
	jQuery( window ).on( 'resize', function() {

		// Check for woo demo bar which can take on 2 lines and thus sticky position must be calculated
		if ( jQuery( '.demo_store' ).length ) {
			jQuery( '#wrapper' ).css( 'margin-top', jQuery( '.demo_store' ).outerHeight() );
			if ( jQuery( '.sticky-header' ).length ) {
				jQuery( '.sticky-header' ).css( 'margin-top', jQuery( '.demo_store' ).outerHeight() );
			}
		}

		if ( jQuery( '.sticky-header' ).length ) {
			if ( 765 > jQuery( window ).width() ) {
				jQuery( 'body.admin-bar #header-sticky.sticky-header' ).css( 'top', '46px' );
			} else {
				jQuery( 'body.admin-bar #header-sticky.sticky-header' ).css( 'top', '32px' );
			}
		}
	});

	// Side header main nav
	if ( 'classic' === avadaVars.mobile_menu_design ) {
		jQuery( '.sh-mobile-nav-holder' ).append( '<div class="mobile-selector"><span>' + avadaVars.dropdown_goto + '</span></div>' );
		jQuery( '.sh-mobile-nav-holder .mobile-selector' ).append( '<div class="selector-down"></div>' );
	}
	jQuery( '.sh-mobile-nav-holder' ).append( jQuery( '.nav-holder .fusion-navbar-nav' ).clone() );
	jQuery( '.sh-mobile-nav-holder .fusion-navbar-nav' ).attr( 'id', 'mobile-nav' );
	jQuery( '.sh-mobile-nav-holder ul#mobile-nav' ).removeClass( 'fusion-navbar-nav' );
	jQuery( '.sh-mobile-nav-holder ul#mobile-nav' ).children( '.cart' ).remove();
	jQuery( '.sh-mobile-nav-holder ul#mobile-nav .mobile-nav-item' ).children( '.login-box' ).remove();

	jQuery( '.sh-mobile-nav-holder ul#mobile-nav li' ).children( '#main-nav-search-link' ).each( function() {
		jQuery( this ).parents( 'li' ).remove();
	});
	jQuery( '.sh-mobile-nav-holder ul#mobile-nav' ).find( 'li' ).each( function() {
		var classes = 'mobile-nav-item';

		if ( jQuery( this ).hasClass( 'current-menu-item' ) || jQuery( this ).hasClass( 'current-menu-parent' ) || jQuery( this ).hasClass( 'current-menu-ancestor' ) ) {
			classes += ' mobile-current-nav-item';
		}
		jQuery( this ).attr( 'class', classes );
		if ( jQuery( this ).attr( 'id' ) ) {
			jQuery( this ).attr( 'id', jQuery( this ).attr( 'id' ).replace( 'menu-item', 'mobile-menu-item' ) );
		}
		jQuery( this ).attr( 'style', '' );
	});
	jQuery( '.sh-mobile-nav-holder .mobile-selector' ).click( function() {
		if ( jQuery( '.sh-mobile-nav-holder #mobile-nav' ).hasClass( 'mobile-menu-expanded' ) ) {
			jQuery( '.sh-mobile-nav-holder #mobile-nav' ).removeClass( 'mobile-menu-expanded' );
		} else {
			jQuery( '.sh-mobile-nav-holder #mobile-nav' ).addClass( 'mobile-menu-expanded' );
		}
		jQuery( '.sh-mobile-nav-holder #mobile-nav' ).slideToggle( 200, 'easeOutQuad' );
	});

	// Make mobile menu sub-menu toggles
	if ( 1 == avadaVars.submenu_slideout ) {
		jQuery( '.header-wrapper .mobile-topnav-holder .mobile-topnav li, .header-wrapper .mobile-nav-holder .navigation li, .sticky-header .mobile-nav-holder .navigation li, .sh-mobile-nav-holder .navigation li' ).each( function() {
			var classes = 'mobile-nav-item';

			if ( jQuery( this ).hasClass( 'current-menu-item' ) || jQuery( this ).hasClass( 'current-menu-parent' ) || jQuery( this ).hasClass( 'current-menu-ancestor' ) || jQuery( this ).hasClass( 'mobile-current-nav-item' ) ) {
				classes += ' mobile-current-nav-item';
			}
			jQuery( this ).attr( 'class', classes );

			if ( jQuery( this ).find( ' > ul' ).length ) {
				jQuery( this ).prepend( '<span href="#" aria-haspopup="true" class="open-submenu"></span>' );

				jQuery( this ).find( ' > ul' ).hide();
			}
		});

		jQuery( '.header-wrapper .mobile-topnav-holder .open-submenu, .header-wrapper .mobile-nav-holder .open-submenu, .sticky-header .mobile-nav-holder .open-submenu, .sh-mobile-nav-holder .open-submenu' ).click( function( e ) {
			e.stopPropagation();
			jQuery( this ).parent().children( '.sub-menu' ).slideToggle( 200, 'easeOutQuad' );

		});
	}

	// One page scrolling effect
	$adminbarHeight     = getAdminbarHeight();
	$stickyHeaderHeight = getStickyHeaderHeight();

	jQuery( window ).on( 'resize scroll', function() {
		$adminbarHeight     = getAdminbarHeight();
		$stickyHeaderHeight = getStickyHeaderHeight();
	});

	// Ititialize ScrollSpy script
	jQuery( 'body' ).scrollspy({
		target: '.fusion-menu',
		offset: parseInt( $adminbarHeight + $stickyHeaderHeight + 1 )
	});

	// Reset ScrollSpy offset to correct height after page is fully loaded, may be needed for
	jQuery( window ).load( function() {
		$adminbarHeight = getAdminbarHeight();
		$stickyHeaderHeight = getStickyHeaderHeight();

		jQuery( 'body' ).data()['bs.scrollspy'].options.offset = parseInt( $adminbarHeight + $stickyHeaderHeight + 1 );
	});

	jQuery( '.fusion-menu a:not([href="#"], .fusion-megamenu-widgets-container a, .search-link), .fusion-mobile-nav-item a:not([href="#"], .search-link), .fusion-button:not([href="#"], input, button), .fusion-one-page-text-link:not([href="#"])' ).click( function( e ) {

		var $currentHref,
		    $currentPath,
		    $target,
		    $targetArray,
		    $targetID,
		    $targetPath,
		    $targetPathLastChar,
		    $targetWindow;

		if ( jQuery( this ).hasClass( 'avada-noscroll' ) || jQuery( this ).parent().hasClass( 'avada-noscroll' ) ) {
			return true;
		}

		if ( this.hash ) {

			// Current path
			$currentHref = window.location.href.split( '#' );
			$currentPath = ( '/' === $currentHref[0].charAt( $currentHref[0].length - 1 ) ) ? $currentHref[0] : $currentHref[0] + '/';

			// Target path
			$targetWindow       = ( jQuery( this ).attr( 'target' ) ) ? jQuery( this ).attr( 'target' ) : '_self';
			$target             = jQuery( this ).attr( 'href' );
			$targetArray        = $target.split( '#' );
			$targetID           = ( 'undefined' !== typeof $targetArray[1] ) ? $targetArray[1] : null;
			$targetPath         = $targetArray[0];
			$targetPathLastChar = $targetPath.substring( $targetPath.length - 1, $targetPath.length );

			if ( '/' != $targetPathLastChar ) {
				$targetPath = $targetPath + '/';
			}

			e.preventDefault();

			// If the link is outbound add an underscore right after the hash tag to make sure the link isn't present on the loaded page
			if ( location.pathname.replace( /^\//, '' ) == this.pathname.replace( /^\//, '' ) || '#' === $target.charAt( 0 ) ) {
				jQuery( this ).fusion_scroll_to_anchor_target();
				if ( jQuery( this ).parents( '.fusion-flyout-menu' ).length ) {
					jQuery( '.fusion-flyout-menu-toggle' ).trigger( 'click' );
				}
			} else {
				window.open( $targetPath + '#_' + $targetID, $targetWindow );
			}
		}
	});

	// Side nav drop downs
	jQuery( '.side-nav-left .side-nav li' ).each( function() {
		if ( jQuery( this ).find( '> .children' ).length ) {
			if ( jQuery( '.rtl' ).length ) {
				jQuery( this ).find( '> a' ).prepend( '<span class="arrow"></span>' );
			} else {
				jQuery( this ).find( '> a' ).append( '<span class="arrow"></span>' );
			}
		}
	});

	jQuery( '.side-nav-right .side-nav li' ).each( function() {
		if ( jQuery( this ).find( '> .children' ).length ) {
			if ( jQuery( 'body.rtl' ).length ) {
				jQuery( this ).find( '> a' ).append( '<span class="arrow"></span>' );
			} else {
				jQuery( this ).find( '> a' ).prepend( '<span class="arrow"></span>' );
			}
		}
	});

	jQuery( '.side-nav .current_page_item' ).each( function() {
		if ( jQuery( this ).find( '.children' ).length ) {
			jQuery( this ).find( '.children' ).show( 'slow' );
		}
	});

	jQuery( '.side-nav .current_page_item' ).each( function() {
		if ( jQuery( this ).parent().hasClass( 'side-nav' ) ) {
			jQuery( this ).find( 'ul' ).show( 'slow' );
		}

		if ( jQuery( this ).parent().hasClass( 'children' ) ) {
			jQuery( this ).parents( 'ul' ).show( 'slow' );
		}
	});

	if ( 'ontouchstart' in document.documentElement || navigator.msMaxTouchPoints ) {
		jQuery( '.fusion-main-menu li.menu-item-has-children > a, .fusion-secondary-menu li.menu-item-has-children > a, .order-dropdown > li .current-li' ).on( 'click', function( e ) {
			var link = jQuery( this );
			if ( link.hasClass( 'hover' ) ) {
				link.removeClass( 'hover' );
				return true;
			} else {
				link.addClass( 'hover' );
				jQuery( '.fusion-main-menu li.menu-item-has-children > a, .fusion-secondary-menu li.menu-item-has-children > a, .order-dropdown > li .current-li' ).not( this ).removeClass( 'hover' );
				return false;
			}
		});

		jQuery( '.sub-menu li, .fusion-mobile-nav-item li' ).not( 'li.menu-item-has-children' ).on( 'click', function( e ) {
			var link = jQuery( this ).find( 'a' ).attr( 'href' );
			if ( '_blank' != jQuery( this ).find( 'a' ).attr( 'target' ) ) { // Fix for #1564
				window.location = link;
			}

			return true;
		});
	}

	// Touch support for win phone devices
	jQuery( '.fusion-main-menu li.menu-item-has-children > a, .fusion-secondary-menu li.menu-item-has-children > a, .side-nav li.page_item_has_children > a' ).each( function() {
		jQuery( this ).attr( 'aria-haspopup', 'true' );
	});

	// Ubermenu responsive fix
	if ( 1 <= jQuery( '.megaResponsive' ).length ) {
		jQuery( '.mobile-nav-holder.main-menu' ).addClass( 'set-invisible' );
	}

	// WPML search form input add
	if ( '' !== avadaVars.language_flag ) {
		jQuery( '.search-field, .searchform' ).each( function() {
			if ( ! jQuery( this ).find( 'input[name="lang"]' ).length && ! jQuery( this ).parents( '.searchform' ).find( 'input[name="lang"]' ).length ) {
				jQuery( this ).append( '<input type="hidden" name="lang" value="' + avadaVars.language_flag + '"/>' );
			}
		});
	}

	// New spinner for WPCF7
	jQuery( '<div class="fusion-slider-loading"></div>' ).insertAfter( '.wpcf7 .ajax-loader' );
	jQuery( '.wpcf7 img.ajax-loader' ).remove();

	jQuery( '.wpcf7-form .wpcf7-submit' ).on( 'click', function() {
		jQuery( this ).parents( '.wpcf7-form' ).find( '.fusion-slider-loading' ).show();
	});

	jQuery( document ).ajaxComplete( function( event, request, settings ) {
		if ( jQuery( '.wpcf7-form' ).find( '.fusion-slider-loading' ).filter( ':visible' ).length ) {
			jQuery( '.wpcf7-form' ).find( '.fusion-slider-loading' ).hide();
		}

	});

	jQuery( '#wrapper .fusion-sharing-box' ).each( function() {
		if ( ! jQuery( 'meta[property="og:title"]' ).length ) {
			jQuery( 'head title' ).after( '<meta property="og:title" content="' + jQuery( this ).data( 'title' )  + '"/>' );
			jQuery( 'head title' ).after( '<meta property="og:description" content="' + jQuery( this ).data( 'description' )  + '"/>' );
			jQuery( 'head title' ).after( '<meta property="og:type" content="article"/>' );
			jQuery( 'head title' ).after( '<meta property="og:url" content="' + jQuery( this ).data( 'link' )  + '"/>' );
			jQuery( 'head title' ).after( '<meta property="og:image" content="' + jQuery( this ).data( 'image' )  + '"/>' );
		}
	});

	// Remove title separators and padding, when there is not enough space
	jQuery( '.fusion-title' ).fusion_responsive_title_shortcode();

	jQuery( window ).on( 'resize', function() {
		jQuery( '.fusion-title' ).fusion_responsive_title_shortcode();
	});

	// Position main menu search box correctly
	if ( 'Top' ==  avadaVars.header_position ) {
		jQuery( window ).on( 'resize', function() {
			jQuery( '.main-nav-search' ).each( function() {
				var searchForm,
				    searchFormWidth,
				    searchFormLeftEdge,
				    searchFormRightEdge,
				    searchMenuItemLeftEdge,
				    windowRightEdge;

				if ( jQuery( this ).hasClass( 'search-box-open' ) ) {
					searchForm             = jQuery( this ).find( '.main-nav-search-form' );
					searchFormWidth        = searchForm.outerWidth();
					searchFormLeftEdge     = searchForm.offset().left;
					searchFormRightEdge    = searchFormLeftEdge + searchFormWidth;
					searchMenuItemLeftEdge = searchForm.parent().offset().left;
					windowRightEdge        = jQuery( window ).width();

					if ( ! jQuery( 'body.rtl' ).length ) {
						if ( ( searchFormLeftEdge < searchMenuItemLeftEdge && searchFormLeftEdge < 0 ) || ( searchFormLeftEdge == searchMenuItemLeftEdge && searchFormLeftEdge - searchFormWidth < 0 ) ) {
							searchForm.css({
								'left': '0',
								'right': 'auto'
							});
						} else {
							searchForm.css({
								'left': 'auto',
								'right': '0'
							});
						}
					} else {
						if ( ( searchFormLeftEdge == searchMenuItemLeftEdge && searchFormRightEdge > windowRightEdge ) || ( searchFormLeftEdge < searchMenuItemLeftEdge && searchFormRightEdge + searchFormWidth > windowRightEdge )  ) {
							searchForm.css({
								'left': 'auto',
								'right': '0'
							});
						} else {
							searchForm.css({
								'left': '0',
								'right': 'auto'
							});
						}
					}
				}
			});
		});
	}

	// Tabs
	// On page load
	// Direct linked tab handling
	jQuery( '.fusion-tabs' ).fusionSwitchTabOnLinkClick();

	//On Click Event
	jQuery( '.nav-tabs li' ).click( function( e ) {

		var clickedTab           = jQuery( this ),
		    tabContentToActivate = clickedTab.find( 'a' ).attr( 'href' ),
		    mapID                = clickedTab.attr( 'id' ),
		    navTabsHeight;

		clickedTab.parents( '.fusion-tabs' ).find( '.nav li' ).removeClass( 'active' );

		if ( clickedTab.parents( '.fusion-tabs' ).find( tabContentToActivate ).find( '.fusion-woo-slider' ).length ) {
			navTabsHeight = 0;
			if ( clickedTab.parents( '.fusion-tabs' ).hasClass( 'horizontal-tabs' ) ) {
				navTabsHeight = clickedTab.parents( '.fusion-tabs' ).find( '.nav' ).height();
			}
			clickedTab.parents( '.fusion-tabs' ).height( clickedTab.parents( '.fusion-tabs' ).find( '.tab-content' ).outerHeight( true ) + navTabsHeight );
		}

		/*
		// Scroll mobile tabs to correct position; Disabled because it is jumpy
		if ( clickedTab.parents( '.nav' ).hasClass( 'fusion-mobile-tab-nav' ) ) {
			setTimeout( function(){
				jQuery( 'html, body' ).animate({
					scrollTop: clickedTab.offset().top - clickedTab.outerHeight()
				}, 100 );
			}, 350 );
		}
		*/

		setTimeout( function() {

			// Google maps
			clickedTab.parents( '.fusion-tabs' ).find( tabContentToActivate ).find( '.shortcode-map' ).each( function() {
				jQuery( this ).reinitializeGoogleMap();
			});

			// Image Carousels
			if ( clickedTab.parents( '.fusion-tabs' ).find( tabContentToActivate ).find( '.fusion-carousel' ).length ) {
				generateCarousel();
			}

			// Portfolio
			clickedTab.parents( '.fusion-tabs' ).find( tabContentToActivate ).find( '.fusion-portfolio' ).each( function() {
				var $portfolioWrapper   = jQuery( this ).find( '.fusion-portfolio-wrapper' ),
				    $portfolioWrapperID = $portfolioWrapper.attr( 'id' );

				// Done for multiple instances of portfolio shortcode. Isotope needs ids to distinguish between instances
				if ( $portfolioWrapperID ) {
					$portfolioWrapper = jQuery( '#' + $portfolioWrapperID );
				}

				$portfolioWrapper.isotope();
			});

			// Make premium sliders and other elements work
			jQuery( window ).trigger( 'resize' );

			// Flip Boxes
			clickedTab.parents( '.fusion-tabs' ).find( tabContentToActivate ).find( '.flip-box-inner-wrapper' ).each( function() {
				jQuery( this ).fusionCalcFlipBoxesHeight();
			});

			// Make WooCommerce shortcodes work
			if ( clickedTab.parents( '.fusion-tabs' ).find( tabContentToActivate ).find( '.fusion-woo-slider' ).length ) {
				clickedTab.parents( '.fusion-tabs' ).css( 'height', '' );
			}

			jQuery( '.crossfade-images' ).each(	function() {
				fusionResizeCrossfadeImagesContainer( jQuery( this ) );
				fusionResizeCrossfadeImages( jQuery( this ) );
			});

			// Blog
			clickedTab.parents( '.fusion-tabs' ).find( tabContentToActivate ).find( '.fusion-blog-shortcode' ).each( function() {
				var columns = 2,
				    gridWidth,
				    i;
				for ( i = 1; i < 7; i++ ) {
					if ( jQuery( this ).find( '.fusion-blog-layout-grid' ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
						columns = i;
					}
				}

				gridWidth = Math.floor( 100 / columns * 100 ) / 100  + '%';
				jQuery( this ).find( '.fusion-blog-layout-grid' ).find( '.fusion-post-grid' ).css( 'width', gridWidth );

				jQuery( this ).find( '.fusion-blog-layout-grid' ).isotope();

				calcSelectArrowDimensions();
			});

			// Reinitialize select arrows
			calcSelectArrowDimensions();
		}, 350 );

		e.preventDefault();
	});

	// Tabs Widget
	jQuery( '.tabs-widget .tabset li a' ).click( function( e ) {
		e.preventDefault();
	});

	// When page loads
	jQuery( '.tabs-widget' ).each( function() {
		jQuery( this ).find( '.tabset li:first' ).addClass( 'active' ).show(); //Activate first tab
		jQuery( this ).find( '.tab_content:first' ).show(); //Show first tab content
	});

	//On Click Event
	jQuery( '.tabs-widget .tabset li' ).click( function( e ) {
		tabToActivate = jQuery( this ).find( 'a' ).attr( 'href' );

		jQuery( this ).parent().find( ' > li' ).removeClass( 'active' ); //Remove all 'active' classes
		jQuery( this ).addClass( 'active' ); // Add 'active' class to selected tab

		jQuery( this ).parents( '.tabs-widget' ).find( '.tab_content' ).hide(); //Hide all tab content
		jQuery( this ).parents( '.tabs-widget' ).find( tabToActivate ).fadeIn(); //Fade in the new active tab content
	});

	jQuery( '.tooltip-shortcode, .fusion-secondary-header .fusion-social-networks li, .fusion-author-social .fusion-social-networks li, .fusion-footer-copyright-area .fusion-social-networks li, .fusion-footer-widget-area .fusion-social-networks li, .sidebar .fusion-social-networks li, .social_links_shortcode li, .share-box li, .social-icon, .social li' ).mouseenter( function( e ) {
		jQuery( this ).find( '.popup' ).hoverFlow( e.type, {
			'opacity': 'show'
		});
	});

	jQuery( '.tooltip-shortcode, .fusion-secondary-header .fusion-social-networks li, .fusion-author-social .fusion-social-networks li, .fusion-footer-copyright-area .fusion-social-networks li, .fusion-footer-widget-area .fusion-social-networks li, .sidebar .fusion-social-networks li, .social_links_shortcode li, .share-box li, .social-icon, .social li' ).mouseleave( function( e ) {
		jQuery( this ).find( '.popup' ).hoverFlow( e.type, {
			'opacity': 'hide'
		});
	});

	// Make sure protfolio fixed width placeholders are sized correctly on resize
	jQuery( window ).on( 'resize', function() {
		jQuery( '.fusion-portfolio .fusion-portfolio-wrapper' ).each( function() {

			// Resize the placeholder images correctly in "fixed" picture size carousels
			if ( 'fixed' === jQuery( this ).data( 'picturesize' ) ) {
				jQuery( this ).find( '.fusion-placeholder-image' ).each( function() {
					jQuery( this ).css(	{
						'height': jQuery( this ).parents( '.fusion-portfolio-post' ).siblings().find( 'img' ).first().height(),
						'width': jQuery( this ).parents( '.fusion-portfolio-post' ).siblings().find( 'img' ).first().width()
					});

				});
			}
		});
	});

	// Handle the portfolio filter clicks
	jQuery( '.fusion-portfolio .fusion-filters a' ).click( function( e ) {

		// Relayout isotope based on filter selection
		var $filterActive      = jQuery( this ).data( 'filter' ),
		    $lightboxInstances = [],
		    $portfolioID       = jQuery( this ).parents( '.fusion-portfolio' ).data( 'id' );

		e.preventDefault();

		if ( ! $portfolioID ) {
			$portfolioID = '';
		}

		jQuery( this ).parents( '.fusion-portfolio' ).find( '.fusion-portfolio-wrapper' ).isotope( { filter: $filterActive } );

		// Remove active filter class from old filter item and add it to new
		jQuery( this ).parents( '.fusion-filters' ).find( '.fusion-filter' ).removeClass( 'fusion-active' );
		jQuery( this ).parent().addClass( 'fusion-active' );

		jQuery( this ).parents( '.fusion-portfolio' ).find( '.fusion-portfolio-wrapper' ).find( '.fusion-portfolio-post' ).each( function() {
			var $postID = '',
			    $filterSelector,
			    $lightboxString;

			// For individual per post galleries set the post id
			if ( 'individual' === avadaVars.lightbox_behavior && jQuery( this ).find( '.fusion-rollover-gallery' ).length ) {
				$postID = jQuery( this ).find( '.fusion-rollover-gallery' ).data( 'id' );
			}

			if ( $filterActive.length > 1 ) {
				$filterSelector = $filterActive.substr( 1 );
				$lightboxString = 'iLightbox[' + $filterSelector + $postID  + $portfolioID + ']';
			} else {
				$filterSelector = 'fusion-portfolio-post';
				$lightboxString = 'iLightbox[gallery' + $postID + $portfolioID + ']';
			}

			if ( jQuery( this ).hasClass( $filterSelector ) || 1 == $filterActive.length ) {

				// Make sure that if $postID is empty the filter category is only added once to the lightbox array
				if ( $filterActive.length > 1 && jQuery.inArray( $filterSelector + $postID + $portfolioID, $lightboxInstances ) === -1 ) {
					$lightboxInstances.push( $filterSelector + $postID + $portfolioID );
				} else if ( 1 === $filterActive.length && -1 === jQuery.inArray( $postID + $portfolioID, $lightboxInstances ) ) {
					$lightboxInstances.push( 'gallery' + $postID + $portfolioID );
				}

				jQuery( this ).find( '.fusion-rollover-gallery' ).attr( 'data-rel', $lightboxString );
				jQuery( this ).find( '.fusion-portfolio-gallery-hidden a' ).attr( 'data-rel', $lightboxString );
			}
		});

		// Check if we need to create a new gallery
		if ( 'created' !== jQuery( this ).data( 'lightbox' ) ) {

			// Create new lightbox instance for the new galleries
			jQuery.each( $lightboxInstances, function( $key, $value ) {
				window.$ilInstances.push( jQuery( '[data-rel="iLightbox[' + $value + ']"], [rel="iLightbox[' + $value + ']"]' ).iLightBox( window.avadaLightBox.prepare_options( 'iLightbox[' + $value + ']' ) ) );
			});

			// Set filter to lightbox created
			jQuery( this ).data( 'lightbox', 'created' );
		}

		// Refresh the lightbox
		window.avadaLightBox.refresh_lightbox();
	});

	// Setup filters and click events for faq elements
	jQuery( '.fusion-faq-shortcode' ).each( function() {

		// Initialize the filters and corresponding posts
		// Check if filters are displayed
		var $faqsElement    = jQuery( this ),
		    $filtersWrapper = $faqsElement.find( '.fusion-filters' ),
		    $filters,
		    $filterActiveElement,
		    $filterActive,
		    $posts;

			// Make the faq posts visible
			$faqsElement.find( '.fusion-faqs-wrapper' ).fadeIn();

		if ( $filtersWrapper.length ) {

			// Make filters visible
			$filtersWrapper.fadeIn();

			// Set needed variables
			$filters             = $filtersWrapper.find( '.fusion-filter' );
			$filterActiveElement = $filtersWrapper.find( '.fusion-active' ).children( 'a' );
			$filterActive        =  $filterActiveElement.attr( 'data-filter' ).substr( 1 );
			$posts               = jQuery( this ).find( '.fusion-faqs-wrapper .fusion-faq-post' );

			// Loop through filters
			if ( $filters ) {
				$filters.each( function() {
					var $filter     = jQuery( this ),
					    $filterName = $filter.children( 'a' ).data( 'filter' );

					// Loop through post set
					if ( $posts ) {

						// If "All" filter is deactivated, hide posts for later check for active filter
						if ( $filterActive.length ) {
							$posts.hide();
						}

						$posts.each( function() {
							var $post = jQuery( this );

							// If a post belongs to an invisible filter, fade the filter in
							if ( $post.hasClass( $filterName.substr( 1 ) ) ) {
								if ( $filter.hasClass( 'fusion-hidden' ) ) {
									$filter.removeClass( 'fusion-hidden' );
								}
							}

							// If "All" filter is deactivated, only show the items of the first filter (which is auto activated)
							if ( $filterActive.length && $post.hasClass( $filterActive ) ) {
								$post.show();
							}
						});
					}
				});
			}
		}

		// Handle the filter clicks
		$faqsElement.find( '.fusion-filters a' ).click( function( e ) {

			var selector = jQuery( this ).attr( 'data-filter' );

			e.preventDefault();

			// Fade out the faq posts and fade in the ones matching the selector
			$faqsElement.find( '.fusion-faqs-wrapper .fusion-faq-post' ).fadeOut();
			setTimeout( function() {
				$faqsElement.find( '.fusion-faqs-wrapper .fusion-faq-post' + selector ).fadeIn();
			}, 400 );

			// Set the active
			jQuery( this ).parents( '.fusion-filters' ).find( '.fusion-filter' ).removeClass( 'fusion-active' );
			jQuery( this ).parent().addClass( 'fusion-active' );
		});
	});

	function isScrolledIntoView( elem ) {
		var docViewTop    = jQuery( window ).scrollTop(),
		    docViewBottom = docViewTop + jQuery( window ).height(),
		    elemTop       = jQuery( elem ).offset().top,
		    elemBottom    = elemTop + jQuery( elem ).height();

		return ( ( elemBottom <= docViewBottom ) && ( elemTop >= docViewTop ) );
	}

	jQuery( '.fusion-alert .close' ).click( function( e ) {
		e.preventDefault();

		jQuery( this ).parent().slideUp();
	});

	jQuery( 'input, textarea' ).placeholder();

	function checkForImage( url ) {
		return ( null !== url.match( /\.(jpeg|jpg|gif|png)$/ ) );
	}

	if ( Modernizr.mq( 'only screen and (max-width: 479px)' ) ) {
		jQuery( '.overlay-full.layout-text-left .slide-excerpt p' ).each( function() {
			var excerpt     = jQuery( this ).html(),
			    wordArray   = excerpt.split( /[\s\.\?]+/ ), // Split based on regular expression for spaces
			    maxWords    = 10, // Max number of words
			    $totalWords = wordArray.length, // Current total of words
			    newString   = '',
			    i;

			// Roll back the textarea value with the words that it had previously before the maximum was reached
			if ( $totalWords > maxWords + 1 ) {
				 for ( i = 0; i < maxWords; i++ ) {
					newString += wordArray[ i ] + ' ';
				}
				jQuery( this ).html( newString );
			}
		});

		jQuery( '.fusion-portfolio .fusion-rollover-gallery' ).each( function() {
			var img = jQuery( this ).attr( 'href' );

			if ( true === checkForImage( img ) ) {
				jQuery( this ).parents( '.fusion-image-wrapper' ).find( '> img' ).attr( 'src', img ).attr( 'width', '' ).attr( 'height', '' );
			}
			jQuery( this ).parents( '.fusion-portfolio-post' ).css( 'width', 'auto' );
			jQuery( this ).parents( '.fusion-portfolio-post' ).css( 'height', 'auto' );
			jQuery( this ).parents( '.fusion-portfolio-one:not(.fusion-portfolio-one-text)' ).find( '.fusion-portfolio-post' ).css( 'margin', '0' );
		});

		if ( jQuery( '.fusion-portfolio' ).length ) {
			jQuery( '.fusion-portfolio-wrapper' ).isotope();
		}
	}

	if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.content_break_point + 'px)' ) ) {
		jQuery( '.tabs-vertical' ).addClass( 'tabs-horizontal' ).removeClass( 'tabs-vertical' );
	}

	jQuery( window ).on( 'resize', function() {
		if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.content_break_point + 'px)' ) ) {
			jQuery( '.tabs-vertical' ).addClass( 'tabs-original-vertical' );
			jQuery( '.tabs-vertical' ).addClass( 'tabs-horizontal' ).removeClass( 'tabs-vertical' );
		} else {
			jQuery( '.tabs-original-vertical' ).removeClass( 'tabs-horizontal' ).addClass( 'tabs-vertical' );
		}
	});

	// Text area limit expandability
	jQuery( '.textarea-comment' ).each( function() {
		jQuery( this ).css( 'max-width', jQuery( '#content' ).width() );
	});

	jQuery( window ).on( 'resize', function() {
		jQuery( '.textarea-comment' ).each( function() {
			jQuery( this ).css( 'max-width', jQuery( '#content' ).width() );
		});
	});

	if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.content_break_point + 'px)' ) ) {
		 jQuery( '.fullwidth-faded' ).each( function() {
			var bkgdImg = jQuery( this ).css( 'background-image' );
			jQuery( this ).parent().css( 'background-image', bkgdImg );
			jQuery( this ).remove();
		 });
	}

	// Remove gravity IE specific class
	jQuery( '.gform_wrapper' ).each( function() {
		jQuery( this ).removeClass( 'gf_browser_ie' );
	});

	// Content Boxes Link Area
	jQuery( '.link-area-box' ).on( 'click', function() {
		if ( jQuery( this ).data( 'link' ) ) {
			if ( '_blank' === jQuery( this ).data( 'link-target' ) ) {
				window.open( jQuery( this ).data( 'link' ), '_blank' );
				jQuery( this ).find( '.heading-link' ).removeAttr( 'href' );
				jQuery( this ).find( '.fusion-read-more' ).removeAttr( 'href' );
			} else {
				window.location = jQuery( this ).data( 'link' );
			}
			jQuery( this ).find( '.heading-link' ).attr( 'target', '' );
			jQuery( this ).find( '.fusion-read-more' ).attr( 'target', '' );
		}
	});

	// Clean Horizontal and Vertical
	jQuery( '.link-type-button' ).each( function() {
		if ( jQuery( this ).parents( '.content-boxes-clean-vertical' ).length >= 1 ) {
			$buttonHeight = jQuery( '.fusion-read-more-button' ).outerHeight();
			jQuery( this ).find( '.fusion-read-more-button' ).css( 'top', $buttonHeight / 2 );
		}
	});

	jQuery( '.link-area-link-icon .fusion-read-more-button, .link-area-link-icon .fusion-read-more, .link-area-link-icon .heading' ).mouseenter( function() {
		jQuery( this ).parents( '.link-area-link-icon' ).addClass( 'link-area-link-icon-hover' );
	});
	jQuery( '.link-area-link-icon .fusion-read-more-button, .link-area-link-icon .fusion-read-more, .link-area-link-icon .heading' ).mouseleave( function() {
		jQuery( this ).parents( '.link-area-link-icon' ).removeClass( 'link-area-link-icon-hover' );
	});

	jQuery( '.link-area-box' ).mouseenter( function() {
		jQuery( this ).addClass( 'link-area-box-hover' );
	});
	jQuery( '.link-area-box' ).mouseleave( function() {
		jQuery( this ).removeClass( 'link-area-box-hover' );
	});
}); // End document_ready_1

jQuery( window ).load( function() {
	if ( undefined === cssua.ua.mobile ) {

		// Change opacity of page title bar on scrolling
		if ( '1' == avadaVars.page_title_fading ) {
			if ( 'Left' === avadaVars.header_position || 'Right' === avadaVars.header_position ) {
				jQuery( '.fusion-page-title-wrapper' ).fusionScroller({ type: 'opacity', offset: 0 });
			} else {
				jQuery( '.fusion-page-title-wrapper' ).fusionScroller({ type: 'opacity', offset: 100 });
			}
		}

		// Fading and blur effect for new fade="" param on full width boxes
		jQuery( '.fullwidth-faded' ).fusionScroller({ type: 'fading_blur' });
	}
});

/*
 * Dynamic javascript File Port
 */
function insertParam( url, parameterName, parameterValue, atStart ) {

	var replaceDuplicates = true,
	    cl,
	    urlhash,
	    sourceUrl,
	    urlParts,
	    newQueryString,
	    parameters,
	    i,
	    parameterParts;

	if ( 0 < url.indexOf( '#' ) ) {
		cl      = url.indexOf( '#' );
		urlhash = url.substring( url.indexOf( '#' ), url.length );
	} else {
		urlhash = '';
		cl      = url.length;
	}
	sourceUrl = url.substring( 0, cl );

	urlParts = sourceUrl.split( '?' );
	newQueryString = '';

	if ( 1 < urlParts.length ) {
		parameters = urlParts[1].split( '&' );
		for ( i = 0; ( i < parameters.length ); i++ ) {
			parameterParts = parameters[ i ].split( '=' );
			if ( ! ( replaceDuplicates && parameterParts[0] == parameterName ) ) {
				if ( '' === newQueryString ) {
					newQueryString = '?' + parameterParts[0] + '=' + ( parameterParts[1] ? parameterParts[1] : '' );
				} else {
					newQueryString += '&';
					newQueryString += parameterParts[0] + '=' + ( parameterParts[1] ? parameterParts[1] : '' );
				}
			}
		}
	}
	if ( '' === newQueryString ) {
		newQueryString = '?';
	}

	if ( atStart ) {
		newQueryString = '?' + parameterName + '=' + parameterValue + ( newQueryString.length > 1 ? '&' + newQueryString.substring( 1 ) : '' );
	} else {
		if ( '' !== newQueryString && '?' != newQueryString ) {
			newQueryString += '&';
		}
		newQueryString += parameterName + '=' + ( parameterValue ? parameterValue : '' );
	}
	return urlParts[0] + newQueryString + urlhash;
}

// Define YTReady function.
window.YTReady = ( function() {
	var onReadyFuncs = [],
	    apiIsReady   = false;

	/* @param func function	 Function to execute on ready
	 * @param func Boolean	  If true, all qeued functions are executed
	 * @param bBefore Boolean  If true, the func will added to the first
	 position in the queue*/
	return function( func, bBefore ) {
		if ( true === func ) {
			apiIsReady = true;
			while ( onReadyFuncs.length ) {

				// Removes the first func from the array, and execute func
				onReadyFuncs.shift()();
			}
		} else if ( 'function' === typeof func ) {
			if ( apiIsReady ) {
				func();
			} else {
				onReadyFuncs[ bBefore ? 'unshift' : 'push' ]( func );
			}
		}
	};
})();

function registerYoutubePlayers() {
	if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
		window.$youtube_players = [];

		jQuery( '.tfs-slider' ).each( function() {
			var $slider = jQuery( this );

			$slider.find( '[data-youtube-video-id]' ).find( 'iframe' ).each( function() {
				var $iframe = jQuery( this );

				window.YTReady( function() {
					window.$youtube_players[$iframe.attr( 'id' )] = new YT.Player( $iframe.attr( 'id' ), {
						events: {
							'onReady': onPlayerReady( $iframe.parents( 'li' ) ),
							'onStateChange': onPlayerStateChange( $iframe.attr( 'id' ), $slider )
						}
					});
				});
			});
		});
	}
}

// Load the YouTube iFrame API
function loadYoutubeIframeAPI() {

	var tag,
	    firstScriptTag;

	if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
		tag = document.createElement( 'script' );
		tag.src = 'https://www.youtube.com/iframe_api';
		firstScriptTag = document.getElementsByTagName( 'script' )[0];
		firstScriptTag.parentNode.insertBefore( tag, firstScriptTag );
	}
}

// This function will be called when the API is fully loaded
function onYouTubePlayerAPIReady() {
	window.YTReady( true );
}

function onPlayerStateChange( $frame, $slider ) {
	return function( $event ) {
		if ( $event.data == YT.PlayerState.PLAYING ) {
			jQuery( $slider ).flexslider( 'pause' );
		}

		if ( $event.data == YT.PlayerState.PAUSED ) {
			jQuery( $slider ).flexslider( 'play' );
		}

		if ( $event.data == YT.PlayerState.BUFFERING ) {
			jQuery( $slider ).flexslider( 'pause' );
		}

		if ( $event.data == YT.PlayerState.ENDED ) {
			if ( '1' == jQuery( $slider ).data( 'autoplay' ) ) {
				jQuery( $slider ).flexslider( 'play' );
			}
		}
	};
}

function onPlayerReady( $slide ) {
	return function( $event ) {
		if ( 'yes' === jQuery( $slide ).data( 'mute' ) ) {
			$event.target.mute();
		}
	};
}

function ytVidId( url ) {
	var p = /^(?:https?:)?(\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
	return ( url.match( p ) ) ? RegExp.$1 : false;
}

function playVideoAndPauseOthers( slider ) {

	// Play the youtube video inside the current slide
	var $currentSliderIframes = jQuery( slider ).find( '[data-youtube-video-id]' ).find( 'iframe' ),
	    $currentSlide         = jQuery( slider ).data( 'flexslider' ).slides.eq( jQuery( slider ).data( 'flexslider' ).currentSlide ),
	    $currentSlideIframe   = $currentSlide.find( '[data-youtube-video-id]' ).find( 'iframe' );

	// Stop all youtube videos
	$currentSliderIframes.each( function( i ) {

		// Don't stop current video, but all others
		if ( jQuery( this ).attr( 'id' ) != $currentSlideIframe.attr( 'id' ) ) {
			window.$youtube_players[jQuery( this ).attr( 'id' )].stopVideo(); // Stop instead of pause for preview images
		}
	});

	if ( $currentSlideIframe.length ) {
		if ( ! $currentSlideIframe.parents( 'li' ).hasClass( 'clone' ) && $currentSlideIframe.parents( 'li' ).hasClass( 'flex-active-slide' ) && 'yes' === $currentSlideIframe.parents( 'li' ).attr( 'data-autoplay' ) ) { // Play only if autoplay is setup

			window.$youtube_players[$currentSlideIframe.attr( 'id' )].playVideo();
		}

		if ( 'yes' === $currentSlide.attr( 'data-mute' ) ) {
			window.$youtube_players[$currentSlideIframe.attr( 'id' )].mute();
		}
	}

	jQuery( slider ).find( 'video' ).each( function( i ) {
		if ( 'function' === typeof jQuery( this )[0].pause ) {
			jQuery( this )[0].pause();
		}
		if ( ! jQuery( this ).parents( 'li' ).hasClass( 'clone' ) && jQuery( this ).parents( 'li' ).hasClass( 'flex-active-slide' ) && 'yes' === jQuery( this ).parents( 'li' ).attr( 'data-autoplay' ) ) {
			if ( 'function' === typeof jQuery( this )[0].play ) {
				jQuery( this )[0].play();
			}
		}
	});
}

jQuery( document ).ready( function() {

	var iframes;

	jQuery( '.fusion-fullwidth.video-background' ).each( function() {
		if ( jQuery( this ).find( '[data-youtube-video-id]' ) ) {
			window.yt_vid_exists = true;
		}
	});

	iframes = jQuery( 'iframe' );
	jQuery.each( iframes, function( i, v ) {
		var src = jQuery( this ).attr( 'src' ),
		    newSrc,
		    newSrc2,
		    newSrc3;

		if ( src ) {
			if ( Number( avadaVars.status_vimeo ) && 1 <= src.indexOf( 'vimeo' ) ) {
				jQuery( this ).attr( 'id', 'player_' + ( i + 1 ) );
				newSrc  = insertParam( src, 'api', '1', false );
				newSrc2 = insertParam( newSrc, 'player_id', 'player_' + ( i + 1 ), false );
				newSrc3 = insertParam( newSrc2, 'wmode', 'opaque', false );

				jQuery( this ).attr( 'src', newSrc3 );
			}

			if ( Number( avadaVars.status_yt ) && ytVidId( src ) ) {
				jQuery( this ).attr( 'id', 'player_' + ( i + 1 ) );

				newSrc = insertParam( src, 'enablejsapi', '1', false );
				newSrc2 = insertParam( newSrc, 'wmode', 'opaque', false );

				jQuery( this ).attr( 'src', newSrc2 );

				window.yt_vid_exists = true;
			}
		}
	});

	jQuery( '.full-video, .video-shortcode, .wooslider .slide-content, .fusion-portfolio-carousel .fusion-video' ).not( '#bbpress-forums .full-video, #bbpress-forums .video-shortcode, #bbpress-forums .wooslider .slide-content, #bbpress-forums .fusion-portfolio-carousel .fusion-video' ).fitVids();
	jQuery( '#bbpress-forums' ).fitVids();

	registerYoutubePlayers();

	loadYoutubeIframeAPI();
});

jQuery( window ).load( function() {
	jQuery( '.fusion-youtube-flash-fix' ).remove();
});

// Control header-v1 and sticky on tfs parallax pages

// Setting some global vars. Those are also needed for the correct header resizing on none parallax slider pages
window.origLogoHeight = jQuery( '.header-wrapper' ).find( '.logo' ).height();
window.origLogoContainerMarginTop = String( jQuery( '.header-wrapper' ).find( '.logo' ).data( 'margin-top' ) );
window.origLogoContainerMarginBottom = String( jQuery( '.header-wrapper' ).find( '.logo' ).data( 'margin-bottom' ) );
window.origMenuHeight = jQuery( '.header-wrapper .fusion-navbar-nav > li > a' ).outerHeight();
if ( jQuery( '#wrapper' ).length >= 1 ) {
	window.wrapperPosition = jQuery( '#wrapper' ).position().left;
} else {
	window.wrapperPosition;
}
window.isParallaxTFSSlider = false;

if ( ! window.origLogoContainerMarginTop ) {
	window.origLogoContainerMarginTop = '0px';
}

if ( ! window.origLogoContainerMarginBottom ) {
	window.origLogoContainerMarginBottom = '0px';
}

jQuery( window ).load( function() {
	var headerHeight = jQuery( '.fusion-header-wrapper' ).height(),
	    vimeoPlayers = jQuery( '.flexslider' ).find( 'iframe' ), player,
	    wpadminbarHeight,
	    pageSmoothHeight,
	    flexSmoothHeight;

	if ( jQuery( '.sidebar' ).is( ':visible' ) ) {
		jQuery( '.post-content .fusion-portfolio' ).each( function() {
			var columns = jQuery( this ).data( 'columns' );
			jQuery( this ).addClass( 'fusion-portfolio-' + columns + '-sidebar' );
		});
	}

	// Portfolio isotope loading
	if ( jQuery().isotope && jQuery( '.fusion-portfolio .fusion-portfolio-wrapper' ).length ) {
		jQuery( '.fusion-portfolio .fusion-portfolio-wrapper' ).each( function() {

			var $isotopeFilter,
			    $filtersContainer,
			    $filters,
			    $filterActive,
			    $filterActiveLink,
			    $filterActiveDataSlug,
			    $posts,
			    $lightboxInstances,
			    $portfolioWrapper,
			    $portfolioWrapperID,
			    $placeholderImages,
			    $videos;

			jQuery( this ).next( '.fusion-load-more-button' ).fadeIn();

			// Resize the placeholder images correctly in "fixed" picture size carousels
			if ( 'fixed' === jQuery( this ).data( 'picturesize' ) ) {
				jQuery( this ).find( '.fusion-placeholder-image' ).each( function() {
					jQuery( this ).css(	{
						'height': jQuery( this ).parents( '.fusion-portfolio-post' ).siblings().find( 'img' ).first().height(),
						'width': jQuery( this ).parents( '.fusion-portfolio-post' ).siblings().find( 'img' ).first().width()
					});

				});
			} else {
				jQuery( this ).find( '.fusion-placeholder-image' ).each( function() {
					jQuery( this ).css(	{
						'width': jQuery( this ).parents( '.fusion-portfolio-post' ).siblings().first().find( 'img' ).width()
					});

				});
			}

			$isotopeFilter    = '',
			$filtersContainer = jQuery( this ).parents( '.fusion-portfolio' ).find( '.fusion-filters' );

			// Check if filters are displayed
			if ( $filtersContainer.length ) {

				// Set needed variables
				$filters              = $filtersContainer.find( '.fusion-filter' );
				$filterActive         = $filtersContainer.find( '.fusion-active' );
				$filterActiveLink     = $filterActive.children( 'a' );
				$filterActiveDataSlug = $filterActiveLink.attr( 'data-filter' ).substr( 1 );
				$posts                = jQuery( this ).find( '.fusion-portfolio-post' );
				$lightboxInstances    = [];

				// Loop through filters
				if ( $filters ) {
					$filters.each( function() {
						var $filter = jQuery( this ),
						    $filterName = $filter.children( 'a' ).data( 'filter' );

						// Loop through initial post set
						if ( $posts ) {

							// If "All" filter is deactivated, hide posts for later check for active filter
							if ( $filterActiveDataSlug.length ) {
								$posts.hide();
							}

							jQuery( '.fusion-filters' ).show();

							$posts.each( function() {
								var $post            = jQuery( this ),
								    $postGalleryName = $post.find( '.fusion-rollover-gallery' ).data( 'rel' ),
								    $lightboxFilter;

								// If a post belongs to an invisible filter, fade filter in
								if ( $post.hasClass( $filterName.substr( 1 ) ) ) {
									if ( $filter.hasClass( 'fusion-hidden' ) ) {
										$filter.removeClass( 'fusion-hidden' );
									}
								}

								// If "All" filter is deactivated, only show the items of the first filter (which is auto activated)
								if ( $filterActiveDataSlug.length && $post.hasClass( $filterActiveDataSlug ) ) {
									$post.show();

									// Set the lightbox gallery
									if ( $postGalleryName ) {
										$lightboxFilter = $postGalleryName.replace( 'gallery', $filterActiveDataSlug );

										$post.find( '.fusion-rollover-gallery' ).attr( 'data-rel', $lightboxFilter );
										if ( jQuery.inArray( $lightboxFilter, $lightboxInstances ) === -1 ) {
											$lightboxInstances.push( $lightboxFilter );
										}
									}
								}
							});
						}
					});
				}

				if ( $filterActiveDataSlug.length ) {

					// If "All" filter is deactivated set the sotope filter to the first active element
					$isotopeFilter = '.' + $filterActiveDataSlug;

					// Create new lightbox instance for the new galleries
					jQuery.each( $lightboxInstances, function( $key, $value ) {
						window.$ilInstances.push( jQuery( '[data-rel="' + $value + '"], [rel="' + $value + '"]' ).iLightBox( window.avadaLightBox.prepare_options( $value ) ) );
					});

					// Refresh the lightbox
					window.avadaLightBox.refresh_lightbox();

					// Set active filter to lightbox created
					$filterActiveLink.data( 'lightbox', 'created' );
				}
			}

			// Refresh the scrollspy script for one page layouts
			jQuery( '[data-spy="scroll"]' ).each( function() {
				var $spy = jQuery( this ).scrollspy( 'refresh' );
			});

			$portfolioWrapper   = jQuery( this ),
			$portfolioWrapperID = $portfolioWrapper.attr( 'id' );

			// Done for multiple instances of portfolio shortcode. Isotope needs ids to distinguish between instances.
			if ( $portfolioWrapperID ) {
				$portfolioWrapper = jQuery( '#' + $portfolioWrapperID );
			}

			setTimeout( function() {

				// Initialize isotope depending on the portfolio layout
				if ( $portfolioWrapper.parent().hasClass( 'fusion-portfolio-one' ) ) {
					window.$portfolio_isotope = $portfolioWrapper;
					window.$portfolio_isotope.isotope({

						// Isotope options
						itemSelector: '.fusion-portfolio-post',
						layoutMode: 'vertical',
						transformsEnabled: false,
						isOriginLeft: jQuery( '.rtl' ).length ? false : true,
						filter: $isotopeFilter
					});
				} else {
					window.$portfolio_isotope = $portfolioWrapper;
					window.$portfolio_isotope.isotope({

						// Isotope options
						itemSelector: '.fusion-portfolio-post',
						resizable: true,
						layoutMode: avadaVars.isotope_type,
						transformsEnabled: false,
						isOriginLeft: jQuery( '.rtl' ).length ? false : true,
						filter: $isotopeFilter
					});
				}
			}, 1 );

			// Fade in placeholder images
			$placeholderImages = jQuery( this ).find( '.fusion-portfolio-post .fusion-placeholder-image' );
			$placeholderImages.each( function() {
				jQuery( this ).parents( '.fusion-portfolio-content-wrapper, .fusion-image-wrapper' ).animate({ opacity: 1 });
			});

			// Fade in videos
			$videos = jQuery( this ).find( '.fusion-portfolio-post .fusion-video' );
			$videos.each( function() {
				jQuery( this ).animate({ opacity: 1 });
				jQuery( this ).parents( '.fusion-portfolio-content-wrapper' ).animate({ opacity: 1 });
			});

			$videos.fitVids();

			// Portfolio Images Loaded Check
			window.$portfolio_images_index = 0;

			jQuery( this ).imagesLoaded().progress( function( $instance, $image ) {
				if ( jQuery( $image.img ).parents( '.fusion-portfolio-content-wrapper' ).length >= 1 ) {
					jQuery( $image.img, $placeholderImages ).parents( '.fusion-portfolio-content-wrapper' ).delay( 100 * window.$portfolio_images_index ).animate({
						opacity: 1
					});
				} else {
					jQuery( $image.img, $placeholderImages ).parents( '.fusion-image-wrapper' ).delay( 100 * window.$portfolio_images_index ).animate({
						opacity: 1
					});
				}

				window.$portfolio_images_index++;
			});

			setTimeout(
				function() {
					jQuery( window ).trigger( 'resize' );
				}, 250
			);
		});
	}

	if ( jQuery().flexslider ) {

		if ( Number( avadaVars.status_vimeo ) ) {

			jQuery( '.flexslider' ).find( 'iframe' ).each( function() {
				var id = jQuery( this ).attr( 'id' );

				if ( id ) {
					$f( id ).addEvent( 'ready', function( playerID ) {
						var froogaloop = $f( playerID ),
						    slide      = jQuery( '#' + playerID ).parents( 'li' );

						froogaloop.addEvent( 'play', function( data ) {
							jQuery( '#' + playerID ).parents( 'li' ).parent().parent().flexslider( 'pause' );
						});

						froogaloop.addEvent( 'pause', function( data ) {
							if ( 'yes' === jQuery( slide ).attr( 'data-loop' ) ) {
								jQuery( '#' + playerID ).parents( 'li' ).parent().parent().flexslider( 'pause' );
							} else {
								jQuery( '#' + playerID ).parents( 'li' ).parent().parent().flexslider( 'play' );
							}
						});
					});
				}
			});

			/*
			// WIP
			function addEvent( element, eventName, callback ) {
				if ( element.addEventListener ) {
					element.addEventListener( eventName, callback, false );
				} else {
					element.attachEvent( eventName, callback, false );
				}
			}
			*/

		}

		jQuery( '.tfs-slider' ).each( function() {
			var thisTFSlider = this,
			    firstSlide   = jQuery( thisTFSlider ).find( 'li' ).get( 0 ),
			    sliderHeight,
			    sliderWidth,
			    percentageWidth,
			    aspectRatio,
			    compareWidth,
			    boxedModeWidth,
			    slideContent,
			    resizeWidth,
			    resizeHeight;

			if ( 1 <= jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
				jQuery( thisTFSlider ).data( 'parallax', 0 );
				jQuery( thisTFSlider ).data( 'full_screen', 0 );
			}

			if ( cssua.ua.tablet_pc ) {
				jQuery( thisTFSlider ).data( 'parallax', 0 );
			}

			if ( cssua.ua.mobile || Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
				jQuery( thisTFSlider ).data( 'parallax', 0 );
			}

			wpadminbarHeight = 0;
			if ( 1 <= jQuery( '#wpadminbar' ).length ) {
				wpadminbarHeight = jQuery( '#wpadminbar' ).height();
			}

			if ( 1 <= jQuery( thisTFSlider ).parents( '#sliders-container' ).length && 1 === jQuery( thisTFSlider ).data( 'parallax' ) ) {
				jQuery( '.fusion-header' ).addClass( 'fusion-header-backface' );
			}

			if ( 1 == jQuery( thisTFSlider ).data( 'full_screen' ) ) {
				sliderHeight = jQuery( window ).height();

				if ( 'above' === avadaVars.slider_position  ) {
					sliderHeight = sliderHeight - ( headerHeight + wpadminbarHeight );
				}

				if ( 0 === jQuery( thisTFSlider ).data( 'parallax' ) ) {
					if ( 1 == avadaVars.header_transparency || 'above' === avadaVars.slider_position ) {
						sliderHeight = jQuery( window ).height() - wpadminbarHeight;
					} else {
						sliderHeight = jQuery( window ).height() - ( headerHeight + wpadminbarHeight );
					}
				}

				if (  Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
					if ( 'below' === avadaVars.slider_position ) {
						sliderHeight = jQuery( window ).height() - ( headerHeight + wpadminbarHeight );
					} else {
						sliderHeight = jQuery( window ).height() - wpadminbarHeight;
					}
				}

				jQuery( thisTFSlider ).find( 'video' ).each( function() {
					var aspectRatio    = jQuery( this ).width() / jQuery( this ).height(),
					    arcSliderWidth = aspectRatio * sliderHeight,
					    arcSliderLeft  = '-' + ( ( arcSliderWidth - jQuery( thisTFSlider ).width() ) / 2 ) + 'px',
					    compareWidth   = jQuery( thisTFSlider ).parent().parent().parent().width(),
					    $position;

					if ( jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
						compareWidth   = jQuery( thisTFSlider ).width();
					}

					if ( compareWidth > arcSliderWidth ) {
						arcSliderWidth = '100%';
						arcSliderLeft = 0;
						$position = 'static';
					} else {
						$position = 'absolute';
					}
					jQuery( this ).width( arcSliderWidth );
					jQuery( this ).css({
						'left': arcSliderLeft,
						'position': $position
					});
				});
			} else {
				sliderWidth = jQuery( thisTFSlider ).data( 'slider_width' );

				if ( -1 != sliderWidth.indexOf( '%' ) ) {
					sliderWidth = jQuery( firstSlide ).find( '.background-image' ).data( 'imgwidth' );
					if ( ! sliderWidth && ! cssua.ua.mobile ) {
						sliderWidth = jQuery( firstSlide ).find( 'video' ).width();
					}

					if ( ! sliderWidth ) {
						sliderWidth = 940;
					}

					jQuery( thisTFSlider ).data( 'first_slide_width', sliderWidth );

					if ( sliderWidth < jQuery( thisTFSlider ).data( 'slider_width' ) ) {
						sliderWidth = jQuery( thisTFSlider ).data( 'slider_width' );
					}

					percentageWidth = true;
				} else {
					sliderWidth = parseInt( jQuery( thisTFSlider ).data( 'slider_width' ) );
				}

				sliderHeight = parseInt( jQuery( thisTFSlider ).data( 'slider_height' ) );
				aspectRatio = sliderHeight / sliderWidth;

				if ( aspectRatio < 0.5 ) {
					aspectRatio = 0.5;
				}

				compareWidth = jQuery( thisTFSlider ).parent().parent().parent().width();
				if ( 1 <= jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
					compareWidth = jQuery( thisTFSlider ).width();
				}
				sliderHeight = aspectRatio * compareWidth;

				if ( sliderHeight > parseInt( jQuery( thisTFSlider ).data( 'slider_height' ) ) ) {
					sliderHeight = parseInt( jQuery( thisTFSlider ).data( 'slider_height' ) );
				}

				if ( sliderHeight < 200 ) {
					sliderHeight = 200;
				}
			}

			if ( 1 == jQuery( thisTFSlider ).data( 'full_screen' ) ) {
				jQuery( thisTFSlider ).css( 'max-width', '100%' );
				jQuery( thisTFSlider ).find( '.slides, .background' ).css( 'width', '100%' );
			}

			if ( ( 'Left' === avadaVars.header_position || 'Right' === avadaVars.header_position ) && ! jQuery( thisTFSlider ).hasClass( 'fixed-width-slider' ) && 1 == jQuery( thisTFSlider ).data( 'parallax' ) ) {
				jQuery( thisTFSlider ).css( 'max-width', jQuery( '#wrapper' ).width() );
				if ( jQuery( 'body' ).hasClass( 'side-header-left' ) ) {
					jQuery( thisTFSlider ).css( 'left', jQuery( '#side-header' ).width() );
				} else if ( jQuery( 'body' ).hasClass( 'side-header-right' ) ) {
					jQuery( thisTFSlider ).css( 'right', jQuery( '#side-header' ).width() );
				}
			}

			jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'height', sliderHeight );
			jQuery( thisTFSlider ).css( 'height', sliderHeight );
			jQuery( thisTFSlider ).find( '.background, .mobile_video_image' ).css( 'height', sliderHeight );

			if ( 1 <= jQuery( '.layout-boxed-mode' ).length ) {
				boxedModeWidth = jQuery( '.layout-boxed-mode #wrapper' ).width();
				jQuery( thisTFSlider ).css( 'width', boxedModeWidth );
				jQuery( thisTFSlider ).css( 'margin-left', 'auto' );
				jQuery( thisTFSlider ).css( 'margin-right', 'auto' );

				if ( 1 == jQuery( thisTFSlider ).data( 'parallax' ) && ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
					jQuery( thisTFSlider ).css( 'left', '50%' );
					if ( 'Left' === avadaVars.header_position || 'Right' === avadaVars.header_position ) {
						boxedModeWidth = jQuery( '.layout-boxed-mode #wrapper' ).width() - jQuery( '.layout-boxed-mode #side-header' ).width();
						if ( 'Right' === avadaVars.header_position ) {
							boxedModeWidth = jQuery( '.layout-boxed-mode #wrapper' ).width() + jQuery( '.layout-boxed-mode #side-header' ).width();
						}
						jQuery( thisTFSlider ).css( 'margin-left', '-' + Math.floor( boxedModeWidth / 2 ) + 'px' );
					} else {
						jQuery( thisTFSlider ).css( 'margin-left', '-' + ( boxedModeWidth / 2 ) + 'px' );
					}
				}
				jQuery( thisTFSlider ).find( '.slides, .background' ).css( 'width', '100%' );
			}

			if ( cssua.ua.mobile ) {
				jQuery( thisTFSlider ).find( '.fusion-button' ).each( function() {
					jQuery( this ).removeClass( 'button-xlarge button-large button-medium' );
					jQuery( this ).addClass( 'button-small' );
				});
				jQuery( thisTFSlider ).find( 'li' ).each( function() {
					jQuery( this ).attr( 'data-autoplay', 'no' );
					jQuery( this ).data( 'autoplay', 'no' );
				});
			}

			jQuery( thisTFSlider ).find( 'a.button' ).each( function() {
				jQuery( this ).data( 'old', jQuery( this ).attr( 'class' ) );
			});

			if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.content_break_point + 'px)' ) ) {
				jQuery( thisTFSlider ).find( '.fusion-button' ).each( function() {
					jQuery( this ).data( 'old', jQuery( this ).attr( 'class' ) );
					jQuery( this ).removeClass( 'button-xlarge button-large button-medium' );
					jQuery( this ).addClass( 'button-small' );
				});
			} else {
				jQuery( thisTFSlider ).find( 'a.button' ).each( function() {
					jQuery( this ).attr( 'class', jQuery( this ).data( 'old' ) );
				});
			}

			if ( 1 == jQuery( thisTFSlider ).data( 'parallax' ) ) {

				if ( Modernizr.mq( 'only screen and (min-width: ' + avadaVars.side_header_break_point + 'px)' ) && ( 0 === avadaVars.header_transparency || '0' === avadaVars.header_transparency || false === avadaVars.header_transparency ) && 'below' === avadaVars.slider_position ) {
					slideContent = jQuery( thisTFSlider ).find( '.slide-content-container' );

					jQuery( slideContent ).each( function() {
						jQuery( this ).css( 'padding-top',  headerHeight + 'px' );
					});
				}

				jQuery( window ).scroll( function() {
					if ( jQuery( window ).scrollTop() >= jQuery( thisTFSlider ).parents( '#sliders-container' ).position().top + jQuery( thisTFSlider ).parents( '#sliders-container' ).height() ) {
						jQuery( thisTFSlider ).css( 'display', 'none' );
					} else {
						jQuery( thisTFSlider ).css( 'display', 'block' );
					}
				});
			}

			resizeWidth  = jQuery( window ).width();
			resizeHeight = jQuery( window ).height();

			jQuery( window ).on( 'resize', function() { // Start_tfslider_resize

				var headerHeight,
				    wpadminbarHeight,
				    sliderHeight,
				    sliderWidth,
				    maxHeight,
				    percentageWidth,
				    aspectRatio,
				    compareWidth,
				    boxedModeWidth,
				    wrappingContainer,
				    fixedWidthCenter,
				    slideContent,
				    $navigationArrowsTranslate;

				if ( jQuery( window ).width() != resizeWidth || jQuery( window ).height() != resizeHeight ) {
					headerHeight     = jQuery( '.fusion-header-wrapper' ).height();
					wpadminbarHeight = 0;

					if ( 1 <= jQuery( '#wpadminbar' ).length ) {
						wpadminbarHeight = jQuery( '#wpadminbar' ).height();
					}

					if ( 1 == jQuery( thisTFSlider ).data( 'full_screen' ) ) {
						sliderHeight = jQuery( window ).height();

						if (  Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) && jQuery( '#side-header' ).length ) {
							headerHeight = jQuery( '#side-header' ).outerHeight();
						}

						if ( 'above' === avadaVars.slider_position  ) {
							sliderHeight = sliderHeight - ( headerHeight + wpadminbarHeight );
						}

						if ( 0 === jQuery( thisTFSlider ).data( 'parallax' ) ) {
							if ( 1 == avadaVars.header_transparency || 'above' === avadaVars.slider_position ) {
								sliderHeight = jQuery( window ).height() - wpadminbarHeight;
							} else {
								sliderHeight = jQuery( window ).height() - ( headerHeight + wpadminbarHeight );
							}
						}

						if (  Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
							if ( 'below' === avadaVars.slider_position ) {
								sliderHeight = jQuery( window ).height() - ( headerHeight + wpadminbarHeight );
							} else {
								sliderHeight = jQuery( window ).height() - wpadminbarHeight;
							}
						}

						maxHeight = Math.max.apply(
							null,
							jQuery( thisTFSlider ).find( '.slide-content' ).map( function() {
								return jQuery( this ).outerHeight();
							}).get()
						);

						maxHeight = maxHeight + 40;

						if ( sliderHeight < maxHeight ) {
							sliderHeight = maxHeight;
						}

						// Timeout to prevent self hosted video position breaking on re-size with sideheader.
						setTimeout( function() {
							jQuery( thisTFSlider ).find( 'video' ).each( function() {
								var aspectRatio    = jQuery( this ).width() / jQuery( this ).height(),
								    arcSliderWidth = aspectRatio * sliderHeight,
								    arcSliderLeft  = '-' + ( ( arcSliderWidth - jQuery( thisTFSlider ).width() ) / 2 ) + 'px',
								    compareWidth   = jQuery( thisTFSlider ).parent().parent().parent().width(),
								    $position;

								if ( jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
									compareWidth = jQuery( thisTFSlider ).width();
								}

								if ( compareWidth > arcSliderWidth ) {
									arcSliderWidth = '100%';
									arcSliderLeft = 0;
									$position = 'static';
								} else {
									$position = 'absolute';
								}
								jQuery( this ).width( arcSliderWidth );
								jQuery( this ).css({
									'left': arcSliderLeft,
									'position': $position
								});
							});
						}, 100 );
					} else {
						sliderWidth = jQuery( thisTFSlider ).data( 'slider_width' );

						if ( -1 != sliderWidth.indexOf( '%' ) ) {
							sliderWidth = jQuery( thisTFSlider ).data( 'first_slide_width' );

							if ( sliderWidth < jQuery( thisTFSlider ).data( 'slider_width' ) ) {
								sliderWidth = jQuery( thisTFSlider ).data( 'slider_width' );
							}

							percentageWidth = true;
						} else {
							sliderWidth = parseInt( jQuery( thisTFSlider ).data( 'slider_width' ) );
						}

						sliderHeight = parseInt( jQuery( thisTFSlider ).data( 'slider_height' ) );
						aspectRatio  = sliderHeight / sliderWidth;

						if ( aspectRatio < 0.5 ) {
							aspectRatio = 0.5;
						}

						compareWidth = jQuery( thisTFSlider ).parent().parent().parent().width();
						if ( 1 <= jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
							compareWidth = jQuery( thisTFSlider ).width();
						}
						sliderHeight = aspectRatio * compareWidth;

						if ( sliderHeight > parseInt( jQuery( thisTFSlider ).data( 'slider_height' ) ) ) {
							sliderHeight = parseInt( jQuery( thisTFSlider ).data( 'slider_height' ) );
						}

						if ( sliderHeight < 200 ) {
							sliderHeight = 200;
						}

						jQuery( thisTFSlider ).find( 'video' ).each( function() {
							var aspectRatio = jQuery( this ).width() / jQuery( this ).height(),
							    arcSliderWidth = aspectRatio * sliderHeight,
							    arcSliderLeft,
							    compareWidth;

							if ( arcSliderWidth < sliderWidth && ! jQuery( thisTFSlider ).hasClass( 'full-width-slider' ) ) {
								arcSliderWidth = sliderWidth;
							}

							arcSliderLeft = '-' + ( ( arcSliderWidth - jQuery( thisTFSlider ).width() ) / 2 ) + 'px';
							compareWidth = jQuery( thisTFSlider ).parent().parent().parent().width();
							if ( 1 <= jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
								compareWidth = jQuery( thisTFSlider ).width();
							}
							if ( compareWidth > arcSliderWidth && true === percentageWidth && 1 != jQuery( thisTFSlider ).data( 'full_screen' ) ) {
								arcSliderWidth = '100%';
								arcSliderLeft = 0;
							}
							jQuery( this ).width( arcSliderWidth );
							jQuery( this ).css( 'left', arcSliderLeft );
						});
					}

					if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.content_break_point + 'px)' ) ) {
						jQuery( thisTFSlider ).find( '.fusion-button' ).each( function() {
							jQuery( this ).removeClass( 'button-xlarge button-large button-medium' );
							jQuery( this ).addClass( 'button-small' );
						});
					} else {
						jQuery( thisTFSlider ).find( '.fusion-button' ).each( function() {
							jQuery( this ).attr( 'class', jQuery( this ).data( 'old' ) );
						});
					}

					if ( 1 == jQuery( thisTFSlider ).data( 'full_screen' ) && 'fade' === jQuery( thisTFSlider ).data( 'animation' ) ) {
						jQuery( thisTFSlider ).css( 'max-width', '100%' );
						jQuery( thisTFSlider ).find( '.slides, .background' ).css( 'width', '100%' );
					}

					if ( ( 'Left' === avadaVars.header_position || 'Right' === avadaVars.header_position ) && ! jQuery( thisTFSlider ).hasClass( 'fixed-width-slider' ) && 1 == jQuery( thisTFSlider ).data( 'parallax' ) ) {
						jQuery( thisTFSlider ).css( 'max-width', jQuery( '#wrapper' ).width() );
						if ( jQuery( 'body' ).hasClass( 'side-header-left' ) ) {
							jQuery( thisTFSlider ).css( 'left', jQuery( '#side-header' ).width() );
						} else if ( jQuery( 'body' ).hasClass( 'side-header-right' ) ) {
							jQuery( thisTFSlider ).css( 'right', jQuery( '#side-header' ).width() );
						}
					}

					jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'height', sliderHeight );
					jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'max-height', sliderHeight );
					jQuery( thisTFSlider ).css( 'height', sliderHeight );
					jQuery( thisTFSlider ).find( '.background, .mobile_video_image' ).css( 'height', sliderHeight );

					if ( 1 <= jQuery( '.layout-boxed-mode' ).length && 0 === jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
						boxedModeWidth = jQuery( '.layout-boxed-mode #wrapper' ).width();
						jQuery( thisTFSlider ).css( 'width', boxedModeWidth );
						jQuery( thisTFSlider ).css( 'margin-left', 'auto' );
						jQuery( thisTFSlider ).css( 'margin-right', 'auto' );

						if ( 1 == jQuery( thisTFSlider ).data( 'parallax' ) && ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
							jQuery( thisTFSlider ).css( 'left', '50%' );
							if ( 'Left' === avadaVars.header_position || 'Right' === avadaVars.header_position ) {
								boxedModeWidth = jQuery( '.layout-boxed-mode #wrapper' ).width() - jQuery( '.layout-boxed-mode #side-header' ).width();
								if ( 'Right' === avadaVars.header_position ) {
									boxedModeWidth = jQuery( '.layout-boxed-mode #wrapper' ).width() + jQuery( '.layout-boxed-mode #side-header' ).width();
								}
								jQuery( thisTFSlider ).css( 'margin-left', '-' + Math.floor( boxedModeWidth / 2 ) + 'px' );
							} else {
								jQuery( thisTFSlider ).css( 'margin-left', '-' + ( boxedModeWidth / 2 ) + 'px' );
							}
						}

						if ( 'slide' !== jQuery( thisTFSlider ).data( 'animation' ) ) {
							jQuery( thisTFSlider ).find( '.slides' ).css( 'width', '100%' );
						}
						jQuery( thisTFSlider ).find( '.background' ).css( 'width', '100%' );
					}

					if ( 1 === jQuery( thisTFSlider ).data( 'parallax' ) && ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
						jQuery( thisTFSlider ).css( 'position', 'fixed' );
						if ( 'absolute' !== jQuery( '.fusion-header-wrapper' ).css( 'position' ) ) {
							jQuery( '.fusion-header-wrapper' ).css( 'position', 'relative' );

							$navigationArrowsTranslate = 'translate(0, ' + ( headerHeight / 2 ) + 'px)';

							if ( 'below' === avadaVars.slider_position ) {
								jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'margin-top', '-' + headerHeight + 'px' );
							}
						} else {
							$navigationArrowsTranslate = 'translate(0, 0)';
						}
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-webkit-transform', $navigationArrowsTranslate );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-ms-transform', $navigationArrowsTranslate );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-o-transform', $navigationArrowsTranslate );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-moz-transform', $navigationArrowsTranslate );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( 'transform', $navigationArrowsTranslate );

						jQuery( '#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar' ).css( 'position', 'relative' );
						jQuery( '#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar' ).css( 'z-index', '3' );
						jQuery( '.fusion-header-wrapper' ).css( 'z-index', '5' );
						jQuery( '.fusion-header-wrapper' ).css( 'height', headerHeight );

						if ( jQuery( thisTFSlider ).hasClass( 'fixed-width-slider' ) ) {
							if ( 'Left' === avadaVars.header_position || 'Right' === avadaVars.header_position ) {
								if ( jQuery( thisTFSlider ).parents( '#sliders-container' ).length ) {
									wrappingContainer = jQuery( '#sliders-container' );
								} else {
									wrappingContainer = jQuery( '#main' );
								}

								if ( wrappingContainer.width() < parseFloat( jQuery( thisTFSlider ).parent().css( 'max-width' ) ) ) {
									jQuery( thisTFSlider ).css( 'max-width', wrappingContainer.width() );
								} else {
									jQuery( thisTFSlider ).css( 'max-width', jQuery( thisTFSlider ).parent().css( 'max-width' ) );
								}

								if ( wrappingContainer.width() < parseFloat( jQuery( thisTFSlider ).parent().css( 'max-width' ) ) ) {
									jQuery( thisTFSlider ).css( 'max-width', wrappingContainer.width() );
								} else {
									jQuery( thisTFSlider ).css( 'max-width', jQuery( thisTFSlider ).parent().css( 'max-width' ) );
								}

								if ( 'Left' === avadaVars.header_position ) {
									fixedWidthCenter = '-' + ( ( jQuery( thisTFSlider ).width() - jQuery( '#side-header' ).width() ) / 2 ) + 'px';
								} else {
									fixedWidthCenter = '-' + ( ( jQuery( thisTFSlider ).width() + jQuery( '#side-header' ).width() ) / 2 ) + 'px';
								}

								if ( ( -1 ) * fixedWidthCenter > jQuery( thisTFSlider ).width() ) {
									fixedWidthCenter = ( -1 ) * jQuery( thisTFSlider ).width();
								}
							} else {
								fixedWidthCenter = '-' + ( jQuery( thisTFSlider ).width() / 2 ) + 'px';
							}
							jQuery( thisTFSlider ).css( 'left', '50%' );
							jQuery( thisTFSlider ).css( 'margin-left', fixedWidthCenter );
						}

						jQuery( thisTFSlider ).find( '.flex-control-nav' ).css( 'bottom', ( headerHeight / 2 ) );

						if ( ( 0 === avadaVars.header_transparency || '0' === avadaVars.header_transparency || false === avadaVars.header_transparency ) && 'below' === avadaVars.slider_position ) {
							slideContent = jQuery( thisTFSlider ).find( '.slide-content-container' );
							jQuery( slideContent ).each( function() {
								jQuery( this ).css( 'padding-top',  headerHeight + 'px' );
							});
						}
					} else if ( 1 == jQuery( thisTFSlider ).data( 'parallax' ) && Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
						jQuery( thisTFSlider ).css( 'position', 'relative' );
						jQuery( thisTFSlider ).css( 'left', '0' );
						jQuery( thisTFSlider ).css( 'margin-left', '0' );
						if ( 'absolute' !== jQuery( '.fusion-header-wrapper' ).css( 'position' ) ) {
							jQuery( '.fusion-header-wrapper' ).css( 'position', 'relative' );
						}
						jQuery( '#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar' ).css( 'position', 'relative' );
						jQuery( '#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar' ).css( 'z-index', '3' );
						jQuery( '.fusion-header-wrapper' ).css( 'z-index', '5' );
						jQuery( '.fusion-header-wrapper' ).css( 'height', 'auto' );
						jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'margin-top', '' );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-webkit-transform', 'translate(0, 0)' );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-ms-transform', 'translate(0, 0)' );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-o-transform', 'translate(0, 0)' );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-moz-transform', 'translate(0, 0)' );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( 'transform', 'translate(0, 0)' );

						jQuery( thisTFSlider ).find( '.flex-control-nav' ).css( 'bottom', 0 );

						if ( ( 0 === avadaVars.header_transparency || '0' === avadaVars.header_transparency || false === avadaVars.header_transparency ) && 'below' === avadaVars.slider_position ) {
							slideContent = jQuery( thisTFSlider ).find( '.slide-content-container' );
							jQuery( slideContent ).each( function() {
								jQuery( this ).css( 'padding-top',  '' );
							});
						}
					}

					if ( Modernizr.mq( 'only screen and (max-width: 640px)' ) ) {
						jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'height', sliderHeight );
						jQuery( thisTFSlider ).css( 'height', sliderHeight );
						jQuery( thisTFSlider ).find( '.background, .mobile_video_image' ).css( 'height', sliderHeight );
					} else if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
						jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'height', sliderHeight );
						jQuery( thisTFSlider ).css( 'height', sliderHeight );
						jQuery( thisTFSlider ).find( '.background, .mobile_video_image' ).css( 'height', sliderHeight );
					} else {
						jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'height', sliderHeight );
						jQuery( thisTFSlider ).css( 'height', sliderHeight );
						jQuery( thisTFSlider ).find( '.background, .mobile_video_image' ).css( 'height', sliderHeight );
					}

					slideContent = jQuery( thisTFSlider ).find( '.slide-content-container' );

					if ( 1 <= jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
						jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'height', 'auto' );
						jQuery( thisTFSlider ).css( 'height', 'auto' );
						jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'max-height', 'none' );
						jQuery( thisTFSlider ).find( '.mobile_video_image' ).each( function() {
							var imgURL = jQuery( '.mobile_video_image' ).css( 'background-image' ).replace( 'url(', '' ).replace( ')', '' ),
							    previewImage,
							    mobilePreviewHeight;

							if ( imgURL ) {
								previewImage        = new Image();
								previewImage.name   = imgURL;
								previewImage.src    = imgURL;
								previewImage.onload = function() {
									var ar           = this.height / this.width,
									    compareWidth = jQuery( thisTFSlider ).parent().parent().parent().width();
									if ( 1 <= jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
										compareWidth = jQuery( thisTFSlider ).width();
									}
									mobilePreviewHeight = ar * compareWidth;
									if ( mobilePreviewHeight < sliderHeight ) {
										jQuery( thisTFSlider ).find( '.mobile_video_image' ).css( 'height', mobilePreviewHeight );
										jQuery( thisTFSlider ).css( 'height', mobilePreviewHeight );
									}
								};
							}
						});
					}

					if ( 'Left' === avadaVars.header_position || 'Right' === avadaVars.header_position ) {
						if ( jQuery( thisTFSlider ).parents( '#sliders-container' ).length >= 1 ) {
							slideContent = jQuery( thisTFSlider ).parents( '#sliders-container' ).find( '.slide-content-container' );
							jQuery( slideContent ).each( function() {
								if ( ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
									if ( jQuery( this ).hasClass( 'slide-content-right' ) ) {
										jQuery( this ).find( '.slide-content' ).css( 'margin-right', '100px' );
									} else if ( jQuery( this ).hasClass( 'slide-content-left' ) ) {
										jQuery( this ).find( '.slide-content' ).css( 'margin-left', '100px' );
									}
								} else {
									jQuery( this ).find( '.slide-content' ).css( 'margin-left', '' );
									jQuery( this ).find( '.slide-content' ).css( 'margin-right', '' );
								}
							});
						}
					}

					if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
							jQuery( '.fusion-header-wrapper' ).css( 'height', '' );
					}

					resizeWidth = jQuery( window ).width();
					resizeHeight = jQuery( window ).height();
				}
			}); // // end_tfslider_resize

			if ( 1 <= jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
				jQuery( thisTFSlider ).css( 'max-width', '100%' );
				if ( 'slide' !== jQuery( thisTFSlider ).data( 'animation' ) ) {
					jQuery( thisTFSlider ).find( '.slides' ).css( 'max-width', '100%' );
				}
			}

			jQuery( thisTFSlider ).find( 'video' ).each( function() {
				if ( 'function' === typeof jQuery( this )[0].pause ) {
					jQuery( this )[0].pause();
				}
			});

			jQuery( thisTFSlider ).flexslider({
				animation: jQuery( thisTFSlider ).data( 'animation' ),
				slideshow: jQuery( thisTFSlider ).data( 'autoplay' ),
				slideshowSpeed: jQuery( thisTFSlider ).data( 'slideshow_speed' ),
				animationSpeed: jQuery( thisTFSlider ).data( 'animation_speed' ),
				controlNav: Boolean( Number( jQuery( thisTFSlider ).data( 'pagination_circles' ) ) ),
				directionNav: Boolean( Number( jQuery( thisTFSlider ).data( 'nav_arrows' ) ) ),
				animationLoop: Boolean( Number( jQuery( thisTFSlider ).data( 'loop' ) ) ),
				smoothHeight: true,
				pauseOnHover: false,
				useCSS: true,
				video: true,
				touch: true,
				prevText: '&#xe61e;',
				nextText: '&#xe620;',
				start: function( slider ) {

					var wpadminbarHeight = 0,
					    maxHeight,
					    sliderHeight,
					    sliderWidth,
					    percentageWidth,
					    compareWidth,
					    wrappingContainer,
					    fixedWidthCenter,
					    $navigationArrowsTranslate;

					jQuery( thisTFSlider ).parent().find( '.fusion-slider-loading' ).remove();

					if ( 1 <= jQuery( '#wpadminbar' ).length ) {
						wpadminbarHeight = jQuery( '#wpadminbar' ).height();
					}

					jQuery( slider.slides.eq( slider.currentSlide ) ).find( '.slide-content-container' ).show();

					// Remove title separators and padding, when there is not enough space
					jQuery( slider.slides.eq( slider.currentSlide ) ).find( '.fusion-title' ).fusion_responsive_title_shortcode();

					maxHeight = Math.max.apply(
						null,
						jQuery( thisTFSlider ).find( '.slide-content' ).map( function() {
							return jQuery( this ).outerHeight();
						}).get()
					);

					maxHeight = maxHeight + 40;

					if ( 1 == jQuery( thisTFSlider ).data( 'full_screen' ) ) {
						sliderHeight = jQuery( window ).height();

						if ( 'above' === avadaVars.slider_position  ) {
							sliderHeight = sliderHeight - ( headerHeight + wpadminbarHeight );
						}

						if ( 0 === jQuery( thisTFSlider ).data( 'parallax' ) ) {
							if ( 1 == avadaVars.header_transparency || 'above' === avadaVars.slider_position ) {
								sliderHeight = jQuery( window ).height() - wpadminbarHeight;
							} else {
								sliderHeight = jQuery( window ).height() - ( headerHeight + wpadminbarHeight );
							}
						}

						if (  Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
							if ( 'below' === avadaVars.slider_position ) {
								if ( jQuery( '#side-header' ).length ) {
									sliderHeight = jQuery( window ).height() - ( jQuery( '#side-header' ).outerHeight() + wpadminbarHeight );
								} else {
									sliderHeight = jQuery( window ).height() - ( headerHeight + wpadminbarHeight );
								}
							} else {
								sliderHeight = jQuery( window ).height() - wpadminbarHeight;
							}
						}

						if ( sliderHeight < maxHeight ) {
							sliderHeight = maxHeight;
						}

						jQuery( thisTFSlider ).find( 'video' ).each( function() {
							var aspectRatio    = jQuery( this ).width() / jQuery( this ).height(),
							    arcSliderWidth = aspectRatio * sliderHeight,
							    arcSliderLeft  = '-' + ( ( arcSliderWidth - jQuery( thisTFSlider ).width() ) / 2 ) + 'px';

							compareWidth   = jQuery( thisTFSlider ).parent().parent().parent().width();

							if ( 1 <= jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
								compareWidth = jQuery( thisTFSlider ).width();
							}
							if ( compareWidth > arcSliderWidth ) {
								arcSliderWidth = '100%';
								arcSliderLeft  = 0;
							}
							jQuery( this ).width( arcSliderWidth );
							jQuery( this ).css( 'left', arcSliderLeft );
						});
					} else {
						sliderWidth = jQuery( thisTFSlider ).data( 'slider_width' );

						if ( -1 != sliderWidth.indexOf( '%' ) ) {
							sliderWidth = jQuery( firstSlide ).find( '.background-image' ).data( 'imgwidth' );
							if ( ! sliderWidth && ! cssua.ua.mobile ) {
								sliderWidth = jQuery( firstSlide ).find( 'video' ).width();
							}

							if ( ! sliderWidth ) {
								sliderWidth = 940;
							}

							jQuery( thisTFSlider ).data( 'first_slide_width', sliderWidth );

							if ( sliderWidth < jQuery( thisTFSlider ).data( 'slider_width' ) ) {
								sliderWidth = jQuery( thisTFSlider ).data( 'slider_width' );
							}

							percentageWidth = true;
						} else {
							sliderWidth = parseInt( jQuery( thisTFSlider ).data( 'slider_width' ) );
						}

						sliderHeight = parseInt( jQuery( thisTFSlider ).data( 'slider_height' ) );
						aspectRatio = sliderHeight / sliderWidth;

						if ( aspectRatio < 0.5 ) {
							aspectRatio = 0.5;
						}

						compareWidth = jQuery( thisTFSlider ).parent().parent().parent().width();
						if ( 1 <= jQuery( thisTFSlider ).parents( '.post-content' ).length ) {
							compareWidth = jQuery( thisTFSlider ).width();
						}
						sliderHeight = aspectRatio * compareWidth;

						if ( sliderHeight > parseInt( jQuery( thisTFSlider ).data( 'slider_height' ) ) ) {
							sliderHeight = parseInt( jQuery( thisTFSlider ).data( 'slider_height' ) );
						}

						if ( sliderHeight < 200 ) {
							sliderHeight = 200;
						}

						if ( sliderHeight < maxHeight ) {
							sliderHeight = maxHeight;
						}

						jQuery( thisTFSlider ).find( 'video' ).each( function() {
							var aspectRatio    = jQuery( this ).width() / jQuery( this ).height(),
							    arcSliderWidth = aspectRatio * sliderHeight,
							    arcSliderLeft,
							    compareWidth;

							if ( arcSliderWidth < sliderWidth && ! jQuery( thisTFSlider ).hasClass( 'full-width-slider' ) ) {
								arcSliderWidth = sliderWidth;
							}

							arcSliderLeft = '-' + ( ( arcSliderWidth - jQuery( thisTFSlider ).width() ) / 2 ) + 'px';
							compareWidth = jQuery( thisTFSlider ).parent().parent().parent().width();
							if ( jQuery( thisTFSlider ).parents( '.post-content' ).length >= 1 ) {
								compareWidth = jQuery( thisTFSlider ).width();
							}
							if ( compareWidth > arcSliderWidth && true === percentageWidth && 1 != jQuery( thisTFSlider ).data( 'full_screen' ) ) {
								arcSliderWidth = '100%';
								arcSliderLeft = 0;
							}
							jQuery( this ).width( arcSliderWidth );
							jQuery( this ).css( 'left', arcSliderLeft );
						});
					}

					jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'max-height', sliderHeight );
					jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'height', sliderHeight );
					jQuery( thisTFSlider ).css( 'height', sliderHeight );
					jQuery( thisTFSlider ).find( '.background, .mobile_video_image' ).css( 'height', sliderHeight );

					/* WIP
					if ( jQuery( thisTFSlider ).data( 'full_screen' ) == 0 && (cssua.ua.mobile && cssua.ua.mobile != 'ipad' ) || jQuery( thisTFSlider ).parents( '.post-content' ).length >= 1) {
						jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'height', 'auto' );
						jQuery( thisTFSlider ).find( '.mobile_video_image' ).each( function() {
							var imgURL = jQuery( '.mobile_video_image' ).css( 'background-image' ).replace( 'url(', '' ).replace( ')', '' );
							if (imgURL) {
								var previewImage = new Image();
								previewImage.name = imgURL;
								previewImage.src = imgURL;
								previewImage.onload = function() {
									var ar = this.height / this.width;
									var compareWidth = jQuery( thisTFSlider ).parent().parent().parent().width();
									if ( jQuery( thisTFSlider ).parents( '.post-content' ).length >= 1) {
										compareWidth = jQuery( thisTFSlider ).width();
									}
									var mobilePreviewHeight = ar * compareWidth;
									if (mobilePreviewHeight < sliderHeight) {
										jQuery( thisTFSlider ).find( '.mobile_video_image' ).css( 'height', mobilePreviewHeight);
										jQuery( thisTFSlider ).find( '.mobile_video_image' ).css( 'height', mobilePreviewHeight);
									}
								};
							}
						});
						if ( jQuery( slider.slides.eq( slider.currentSlide ) ).find( 'video' ).length >= 1 && jQuery( slider.slides.eq( slider.currentSlide ) ).find( '.mobile_video_image' ).length >= 1) {
							var imgURL = jQuery( slider.slides.eq( slider.currentSlide ) ).find( '.mobile_video_image' ).css( 'background-image' ).replace( 'url(', '' ).replace( ')', '' );
							if (imgURL) {
								var previewImage = new Image();
								previewImage.name = imgURL;
								previewImage.src = imgURL;
								previewImage.onload = function() {
									var ar = sliderHeight / this.width;
									var compareWidth = jQuery( thisTFSlider ).parent().parent().parent().width();
									if ( jQuery( thisTFSlider ).parents( '.post-content' ).length >= 1) {
										compareWidth = jQuery( thisTFSlider ).width();
									}
									var mobilePreviewHeight = ar * compareWidth;
									if (mobilePreviewHeight < sliderHeight) {
										jQuery( thisTFSlider ).find( '.mobile_video_image' ).css( 'height', mobilePreviewHeight);
										jQuery( thisTFSlider ).css( 'height', mobilePreviewHeight);
									}
								};
							}
						}
					}*/

					if ( 1 === jQuery( thisTFSlider ).data( 'parallax' ) && ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
						jQuery( thisTFSlider ).css( 'position', 'fixed' );
						if ( 'absolute' != jQuery( '.fusion-header-wrapper' ).css( 'position' ) ) {
							jQuery( '.fusion-header-wrapper' ).css( 'position', 'relative' );
							$navigationArrowsTranslate = 'translate(0, ' + ( headerHeight / 2 ) + 'px)';

							if ( 'below' === avadaVars.slider_position ) {
								jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'margin-top', '-' + headerHeight + 'px' );
							}
						} else {
							$navigationArrowsTranslate = 'translate(0, 0)';
						}
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-webkit-transform', $navigationArrowsTranslate );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-ms-transform', $navigationArrowsTranslate );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-o-transform', $navigationArrowsTranslate );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-moz-transform', $navigationArrowsTranslate );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( 'transform', $navigationArrowsTranslate );

						jQuery( '#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar' ).css( 'position', 'relative' );
						jQuery( '#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar' ).css( 'z-index', '3' );
						jQuery( '.fusion-header-wrapper' ).css( 'z-index', '5' );
						jQuery( '.fusion-header-wrapper' ).css( 'height', headerHeight );

						if ( 1 == jQuery( thisTFSlider ).data( 'full_screen' ) ) {
							jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', ( headerHeight / 2 ) );
						} else {
							jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', 0 );
						}

						if ( jQuery( thisTFSlider ).hasClass( 'fixed-width-slider' ) ) {
							if ( 'Left' === avadaVars.header_position || 'Right' === avadaVars.header_position ) {
								if ( jQuery( thisTFSlider ).parents( '#sliders-container' ).length ) {
									wrappingContainer = jQuery( '#sliders-container' );
								} else {
									wrappingContainer = jQuery( '#main' );
								}

								if ( wrappingContainer.width() < parseFloat( jQuery( thisTFSlider ).parent().css( 'max-width' ) ) ) {
									jQuery( thisTFSlider ).css( 'max-width', wrappingContainer.width() );
								} else {
									jQuery( thisTFSlider ).css( 'max-width', jQuery( thisTFSlider ).parent().css( 'max-width' ) );
								}

								if ( 'Left' === avadaVars.header_position ) {
									fixedWidthCenter = '-' + ( ( jQuery( thisTFSlider ).width() - jQuery( '#side-header' ).width() ) / 2 ) + 'px';
								} else {
									fixedWidthCenter = '-' + ( ( jQuery( thisTFSlider ).width() + jQuery( '#side-header' ).width() ) / 2 ) + 'px';
								}

								if ( ( -1 ) * fixedWidthCenter > jQuery( thisTFSlider ).width() ) {
									fixedWidthCenter = ( -1 ) * jQuery( thisTFSlider ).width();
								}
							} else {
								fixedWidthCenter = '-' + ( jQuery( thisTFSlider ).width() / 2 ) + 'px';
							}
							jQuery( thisTFSlider ).css( 'left', '50%' );
							jQuery( thisTFSlider ).css( 'margin-left', fixedWidthCenter );
						}

						if ( ( 0 === avadaVars.header_transparency || '0' === avadaVars.header_transparency || false === avadaVars.header_transparency ) && 'below' === avadaVars.slider_position ) {
							slideContent = jQuery( thisTFSlider ).find( '.slide-content-container' );
							jQuery( slideContent ).each( function() {
								jQuery( this ).css( 'padding-top',  headerHeight + 'px' );
							});
						}

					} else if ( 1 == jQuery( thisTFSlider ).data( 'parallax' ) && Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
						jQuery( thisTFSlider ).css( 'position', 'relative' );
						jQuery( thisTFSlider ).css( 'left', '0' );
						jQuery( thisTFSlider ).css( 'margin-left', '0' );
						if ( 'absolute' !== jQuery( '.fusion-header-wrapper' ).css( 'position' ) ) {
							jQuery( '.fusion-header-wrapper' ).css( 'position', 'relative' );
						}
						jQuery( '#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar' ).css( 'position', 'relative' );
						jQuery( '#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar' ).css( 'z-index', '3' );
						jQuery( '.fusion-header-wrapper' ).css( 'z-index', '5' );
						jQuery( '.fusion-header-wrapper' ).css( 'height', 'auto' );
						jQuery( thisTFSlider ).parents( '.fusion-slider-container' ).css( 'margin-top', '' );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-webkit-transform', 'translate(0, 0)' );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-ms-transform', 'translate(0, 0)' );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-o-transform', 'translate(0, 0)' );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( '-moz-transform', 'translate(0, 0)' );
						jQuery( thisTFSlider ).find( '.flex-direction-nav li a' ).css( 'transform', 'translate(0, 0)' );

						jQuery( thisTFSlider ).find( '.flex-control-nav' ).css( 'bottom', 0 );

						if ( ( 0 === avadaVars.header_transparency || '0' === avadaVars.header_transparency || false === avadaVars.header_transparency ) && 'below' === avadaVars.slider_position ) {
							slideContent = jQuery( thisTFSlider ).find( '.slide-content-container' );
							jQuery( slideContent ).each( function() {
								jQuery( this ).css( 'padding-top',  '' );
							});
						}
					}

					slideContent = jQuery( thisTFSlider ).find( '.slide-content-container' );

					jQuery( slider.slides.eq( slider.currentSlide ) ).find( 'video' ).each( function() {
						if ( 'yes' === jQuery( this ).parents( 'li' ).attr( 'data-autoplay' ) ) {
							if ( 'function' === typeof jQuery( this )[0].play ) {
								jQuery( this )[0].play();
							}
						}
					});

					/* WIP
					jQuery( slider.slides.eq( slider.currentSlide ) ).find( 'iframe' ).each( function() {
						if ( jQuery( this ).parents( 'li' ).attr( 'data-autoplay' ) == 'yes' ) {
							jQuery( thisTFSlider ).flexslider( 'pause' );
							var video = this;
							setTimeout( function() {
								video.contentWindow.postMessage( '{"event":"command","func":"' + 'playVideo' + '","args":""}', '*' );
							}, 1000);
						}
					});
					*/

					if ( 'Left' === avadaVars.header_position || 'Right' === avadaVars.header_position ) {
						if ( jQuery( thisTFSlider ).parents( '#sliders-container' ).length >= 1 ) {
							slideContent = jQuery( thisTFSlider ).parents( '#sliders-container' ).find( '.slide-content-container' );
							jQuery( slideContent ).each( function() {
								if ( ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
									if ( jQuery( this ).hasClass( 'slide-content-right' ) ) {
										jQuery( this ).find( '.slide-content' ).css( 'margin-right', '100px' );
									} else if ( jQuery( this ).hasClass( 'slide-content-left' ) ) {
										jQuery( this ).find( '.slide-content' ).css( 'margin-left', '100px' );
									}
								}
							});
						}
					}

					fusionReanimateSlider( slideContent );

					// Control Videos
					if ( 'undefined' !== typeof( slider.slides ) && 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {

						// Vimeo
						if ( Number( avadaVars.status_vimeo ) ) {
							$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'pause' );

							if ( 'yes' === jQuery( slider.slides.eq( slider.currentSlide ) ).data( 'autoplay' ) ) {
								$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'play' );
							}
							if ( 'yes' === jQuery( slider.slides.eq( slider.currentSlide ) ).data( 'mute' ) ) {
								$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'setVolume', 0 );
							}
						}

						playVideoAndPauseOthers( slider );
					}

					jQuery( thisTFSlider ).find( '.overlay-link' ).hide();
					jQuery( slider.slides.eq( slider.currentSlide ) ).find( '.overlay-link' ).show();

					// Resize videos
					jQuery( thisTFSlider ).find( '[data-youtube-video-id], [data-vimeo-video-id]' ).each(
						function() {
							var $this = jQuery( this );
							setTimeout(
								function() {
									resizeVideo( $this );
								}, 500
							);
						}
					);

					// Reinitialize waypoint
					jQuery.waypoints( 'viewportHeight' );
					jQuery.waypoints( 'refresh' );

				},
				before: function( slider ) {
					jQuery( thisTFSlider ).find( '.slide-content-container' ).hide();

					// Control Videos
					if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {

						// Vimeo
						if ( Number( avadaVars.status_vimeo ) ) {
							jQuery( thisTFSlider ).find( 'iframe' ).each( function() {
								$f( jQuery( this )[0] ).api( 'pause' );
							});

							if ( 'yes' === jQuery( slider.slides.eq( slider.currentSlide ) ).data( 'autoplay' ) ) {
								$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'play' );
							}
							if ( 'yes' === jQuery( slider.slides.eq( slider.currentSlide ) ).data( 'mute' ) ) {
								$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'setVolume', 0 );
							}
						}
					}

					playVideoAndPauseOthers( slider );
				},
				after: function( slider ) {
					jQuery( slider.slides.eq( slider.currentSlide ) ).find( '.slide-content-container' ).show();

					// Remove title separators and padding, when there is not enough space
					jQuery( slider.slides.eq( slider.currentSlide ) ).find( '.fusion-title' ).fusion_responsive_title_shortcode();

					slideContent = jQuery( thisTFSlider ).find( '.slide-content-container' );

					fusionReanimateSlider( slideContent );

					// Control Videos
					if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {

						// Vimeo
						if ( Number( avadaVars.status_vimeo ) ) {
							jQuery( thisTFSlider ).find( 'iframe' ).each( function() {
								$f( jQuery( this )[0] ).api( 'pause' );
							});

							if ( 'yes' === jQuery( slider.slides.eq( slider.currentSlide ) ).data( 'autoplay' ) ) {
								$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'play' );
							}
							if ( 'yes' === jQuery( slider.slides.eq( slider.currentSlide ) ).data( 'mute' ) ) {
								$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'setVolume', 0 );
							}
						}
					}

					jQuery( thisTFSlider ).find( '.overlay-link' ).hide();
					jQuery( slider.slides.eq( slider.currentSlide ) ).find( '.overlay-link' ).show();

					jQuery( slider.slides.eq( slider.currentSlide ) ).find( '[data-youtube-video-id], [data-vimeo-video-id]' ).each( function() {
						resizeVideo( jQuery( this ) );
					});

					playVideoAndPauseOthers( slider );

					jQuery( '[data-spy="scroll"]' ).each( function() {
					  var $spy = jQuery( this ).scrollspy( 'refresh' );
					});
				}
			});
		});

		if ( 'false' === avadaVars.page_smoothHeight ) {
			pageSmoothHeight = false;
		} else {
			pageSmoothHeight = true;
		}

		jQuery( '.fusion-blog-layout-grid .flexslider' ).flexslider({
			slideshow: Boolean( Number( avadaVars.slideshow_autoplay ) ),
			slideshowSpeed: Number( avadaVars.slideshow_speed ),
			video: true,
			smoothHeight: pageSmoothHeight,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function( slider ) {
				jQuery( slider ).removeClass( 'fusion-flexslider-loading' );

				if ( 'undefined' !== typeof( slider.slides ) && 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}
					if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}

				// Reinitialize waypoints
				jQuery.waypoints( 'viewportHeight' );
				jQuery.waypoints( 'refresh' );
			},
			before: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( avadaVars.status_vimeo ) ) {
						$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'pause' );
					}

					if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}

					/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
					playVideoAndPauseOthers( slider );
				}
			},
			after: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}

					if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}
				jQuery( '[data-spy="scroll"]' ).each( function() {
				  var $spy = jQuery( this ).scrollspy( 'refresh' );
				});
			}
		});

		if ( 'false' === avadaVars.flex_smoothHeight ) {
			flexSmoothHeight = false;
		} else {
			flexSmoothHeight = true;
		}

		jQuery( '.fusion-flexslider' ).flexslider({
			slideshow: Boolean( Number( avadaVars.slideshow_autoplay ) ),
			slideshowSpeed: avadaVars.slideshow_speed,
			video: true,
			smoothHeight: flexSmoothHeight,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function( slider ) {

				// Remove Loading
				slider.removeClass( 'fusion-flexslider-loading' );

				// For dynamic content, like equalHeights
				jQuery( window ).trigger( 'resize' );

				if ( 'undefined' !== typeof( slider.slides ) && 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}
					if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}

				// Reinitialize waypoint
				jQuery.waypoints( 'viewportHeight' );
				jQuery.waypoints( 'refresh' );
			},
			before: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( avadaVars.status_vimeo ) ) {
						$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'pause' );
					}

					if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}

					/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
					playVideoAndPauseOthers( slider );
				}
			},
			after: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}

					if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}
				jQuery( '[data-spy="scroll"]' ).each( function() {
				  var $spy = jQuery( this ).scrollspy( 'refresh' );
				});
			}
		});

		jQuery( '.flexslider:not(.tfs-slider)' ).flexslider({
			slideshow: Boolean( Number( avadaVars.slideshow_autoplay ) ),
			slideshowSpeed: avadaVars.slideshow_speed,
			video: true,
			smoothHeight: flexSmoothHeight,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function( slider ) {

				// Remove Loading
				slider.removeClass( 'fusion-flexslider-loading' );

				if ( 'undefined' !== typeof( slider.slides ) && 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}
					if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}

				// Reinitialize waypoint
				jQuery.waypoints( 'viewportHeight' );
				jQuery.waypoints( 'refresh' );
			},
			before: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( avadaVars.status_vimeo ) ) {
						$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'pause' );
					}
					if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}

					/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
					playVideoAndPauseOthers( slider );
				}
			},
			after: function( slider ) {
				if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).hide();
					}
					if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
						window.YTReady( function() {
							new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
								events: {
									'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
								}
							});
						});
					}
				} else {
					if ( Number( avadaVars.pagination_video_slide ) ) {
						jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
					} else {
						jQuery( slider ).find( '.flex-control-nav' ).show();
					}
				}
				jQuery( '[data-spy="scroll"]' ).each( function() {
				  var $spy = jQuery( this ).scrollspy( 'refresh' );
				});
			}
		});

		/* ------------------ PREV & NEXT BUTTON FOR FLEXSLIDER (YOUTUBE) ------------------ */
		jQuery( '.flex-next, .flex-prev' ).click( function() {

			/* WIP
			playVideoAndPauseOthers( jQuery( this ).parents( '.flexslider' ) );
			*/
		});
	}

	if ( jQuery().isotope ) {

		jQuery( '.fusion-blog-layout-grid' ).each( function() {
			var columns = 2,
			    gridWidth,
			    $gridContainer = jQuery( this ),
			    i;

			for ( i = 1; i < 7; i++ ) {
				if ( jQuery( this ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
					columns = i;
				}
			}

			gridWidth = Math.floor( 100 / columns * 100 ) / 100  + '%';
			$gridContainer.find( '.fusion-post-grid' ).css( 'width', gridWidth );
			$gridContainer.isotope({
				layoutMode: 'masonry',
				itemSelector: '.fusion-post-grid',
				transformsEnabled: false,
				isOriginLeft: jQuery( 'body.rtl' ).length ? false : true,
				resizable: true
			});

			if ( ( $gridContainer.hasClass( 'fusion-blog-layout-grid-4' ) || $gridContainer.hasClass( 'fusion-blog-layout-grid-5' ) || $gridContainer.hasClass( 'fusion-blog-layout-grid-6' ) ) && Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)' ) ) {
				gridWidth = Math.floor( 100 / 3 * 100 ) / 100  + '%';
				$gridContainer.find( '.fusion-post-grid' ).css( 'width', gridWidth );
				$gridContainer.isotope({
					layoutMode: 'masonry',
					itemSelector: '.fusion-post-grid',
					transformsEnabled: false,
					isOriginLeft: jQuery( 'body.rtl' ).length ? false : true,
					resizable: true
				});
			}

			setTimeout(
				function() {
					jQuery( window ).trigger( 'resize' );
					$gridContainer.isotope();
				}, 250
			);
		});
	}

	if ( Boolean( Number( avadaVars.avada_rev_styles ) ) ) {
		jQuery( '.rev_slider_wrapper' ).each( function() {
			var revSliderWrapper = jQuery( this ),
			    revSliderID,
			    newDimension;

			if ( 1 <= revSliderWrapper.length && -1 == revSliderWrapper.attr( 'class' ).indexOf( 'tp-shadow' ) ) {
				jQuery( '<div class="shadow-left">' ).appendTo( this );
				jQuery( '<div class="shadow-right">' ).appendTo( this );

				revSliderWrapper.addClass( 'avada-skin-rev' );
			}

			if ( ! jQuery( this ).find( '.tp-leftarrow' ).hasClass( 'preview1' ) && ! jQuery( this ).find( '.tp-leftarrow' ).hasClass( 'preview2' ) && ! jQuery( this ).find( '.tp-leftarrow' ).hasClass( 'preview3' ) && ! jQuery( this ).find( '.tp-leftarrow' ).hasClass( 'preview4' ) ) {
				jQuery( this ).addClass( 'avada-skin-rev-nav' );

				if ( revSliderWrapper.find( '.tp-leftarrow' ).height() > revSliderWrapper.height() / 4 && revSliderWrapper.find( '.tp-leftarrow' ).height() < revSliderWrapper.height() ) {
					revSliderID = revSliderWrapper.attr( 'id' );
					newDimension = revSliderWrapper.height() / 4;
					if ( revSliderWrapper.children( '.avada-rev-arrows' ).length ) {
						revSliderWrapper.children( '.avada-rev-arrows' ).empty();
						revSliderWrapper.children( '.avada-rev-arrows' ).append( '<style type="text/css">#' + revSliderID + ' .tp-leftarrow, #' + revSliderID + ' .tp-rightarrow{margin-top:-' + newDimension / 2 + 'px !important;width:' + newDimension + 'px !important;height:' + newDimension + 'px !important;}#' + revSliderID + ' .tp-leftarrow:before, #' + revSliderID + ' .tp-rightarrow:before{line-height:' + newDimension  + 'px;font-size:' + newDimension / 2 + 'px;}</style>' );
					} else {
						revSliderWrapper.prepend( '<div class="avada-rev-arrows"><style type="text/css">#' + revSliderID + ' .tp-leftarrow, #' + revSliderID + ' .tp-rightarrow{margin-top:-' + newDimension / 2 + 'px !important;width:' + newDimension + 'px !important;height:' + newDimension + 'px !important;}#' + revSliderID + ' .tp-leftarrow:before, #' + revSliderID + ' .tp-rightarrow:before{line-height:' + newDimension  + 'px;font-size:' + newDimension / 2 + 'px;}</style></div>' );
					}
				}

				jQuery( window ).on( 'resize', function() {
					var revSliderID,
					    newDimension;
					if ( revSliderWrapper.find( '.tp-leftarrow' ).height() > revSliderWrapper.height() / 4 && revSliderWrapper.find( '.tp-leftarrow' ).height() < revSliderWrapper.height() ) {
						revSliderID = revSliderWrapper.attr( 'id' );
						newDimension = revSliderWrapper.height() / 4;
						if ( revSliderWrapper.children( '.avada-rev-arrows' ).length ) {
							revSliderWrapper.children( '.avada-rev-arrows' ).empty();
							revSliderWrapper.children( '.avada-rev-arrows' ).append( '<style type="text/css">#' + revSliderID + ' .tp-leftarrow, #' + revSliderID + ' .tp-rightarrow{margin-top:-' + newDimension / 2 + 'px !important;width:' + newDimension + 'px !important;height:' + newDimension + 'px !important;}#' + revSliderID + ' .tp-leftarrow:before, #' + revSliderID + ' .tp-rightarrow:before{line-height:' + newDimension  + 'px;font-size:' + newDimension / 2 + 'px;}</style>' );
						} else {
							revSliderWrapper.prepend( '<div class="avada-rev-arrows"><style type="text/css">#' + revSliderID + ' .tp-leftarrow, #' + revSliderID + ' .tp-rightarrow{margin-top:-' + newDimension / 2 + 'px !important;width:' + newDimension + 'px !important;height:' + newDimension + 'px !important;}#' + revSliderID + ' .tp-leftarrow:before, #' + revSliderID + ' .tp-rightarrow:before{line-height:' + newDimension  + 'px;font-size:' + newDimension / 2 + 'px;}</style></div>' );
						}
					} else {
						revSliderWrapper.children( '.avada-rev-arrows' ).remove();
					}
				});
			}

		});
	}
});

jQuery( document ).ready( function() {

	var wooThumbWidth;

	if ( jQuery().flexslider && 1 <= jQuery( '.woocommerce .images #carousel' ).length ) {
		wooThumbWidth = 100;

		if ( jQuery( 'body.woocommerce .sidebar' ).is( ':visible' ) ) {
			wooThumbWidth = 100;
		} else {
			wooThumbWidth = 118;
		}

		if ( 'undefined' !== typeof jQuery( '.woocommerce .images #carousel' ).data( 'flexslider' ) ) {
			jQuery( '.woocommerce .images #carousel' ).flexslider( 'destroy' );
			jQuery( '.woocommerce .images #slider' ).flexslider( 'destroy' );
		}

		jQuery( '.woocommerce .images #carousel' ).flexslider({
			animation: 'slide',
			controlNav: false,
			directionNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: wooThumbWidth,
			itemMargin: 9,
			touch: false,
			useCSS: false,
			asNavFor: '.woocommerce .images #slider',
			smoothHeight: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function( slider ) {
				jQuery( slider ).removeClass( 'fusion-flexslider-loading' );
			}
		});

		jQuery( '.woocommerce .images #slider' ).flexslider({
			animation: 'slide',
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			smoothHeight: true,
			touch: true,
			useCSS: false,
			sync: '.woocommerce .images #carousel',
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function( slider ) {
				jQuery( slider ).removeClass( 'fusion-flexslider-loading' );
			}
		});
	}

	if ( 2 <= jQuery().flexslider && jQuery( '.flexslider-attachments' ).length ) {
		if ( 'undefined' !== typeof jQuery( '.flexslider-attachments' ).data( 'flexslider' ) ) {
			jQuery( '.flexslider-attachments' ).flexslider( 'destroy' );
		}

		jQuery( '.flexslider-attachments' ).flexslider({
			slideshow: Boolean( Number( avadaVars.slideshow_autoplay ) ),
			slideshowSpeed: avadaVars.slideshow_speed,
			video: false,
			smoothHeight: false,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			controlNav: 'thumbnails',
			start: function( slider ) {
				jQuery( slider ).find( '.fusion-slider-loading' ).remove();

				// Remove Loading
				slider.removeClass( 'fusion-flexslider-loading' );
			}
		});
	}
});

jQuery( window ).load( function() {

	var eislideshowArgs,
	    lastTimelineDate,
	    collapseMonthVisible,
	    $infiniteScrollContainer;

	if ( 'Click' === avadaVars.sidenav_behavior ) {
		jQuery( '.side-nav li a' ).on( 'click', function( e ) {
			if ( jQuery( this ).parent( '.page_item_has_children' ).length ) {
				if ( jQuery( this ).parent().find( '> .children' ).length  && ! jQuery( this ).parent().find( '> .children' ).is( ':visible' ) ) {
					jQuery( this ).parent().find( '> .children' ).stop( true, true ).slideDown( 'slow' );
				} else {
					jQuery( this ).parent().find( '> .children' ).stop( true, true ).slideUp( 'slow' );
				}
			}

			if ( jQuery( this ).parent( '.page_item_has_children.current_page_item' ).length ) {
				return false;
			}
		});
	} else {
		jQuery( '.side-nav li' ).hoverIntent({
			over: function() {
				if ( jQuery( this ).find( '> .children' ).length ) {
					jQuery( this ).find( '> .children' ).stop( true, true ).slideDown( 'slow' );
				}
			},
			out: function() {
				if ( 0 === jQuery( this ).find( '.current_page_item' ).length && false === jQuery( this ).hasClass( 'current_page_item' ) ) {
					jQuery( this ).find( '.children' ).stop( true, true ).slideUp( 'slow' );
				}
			},
			timeout: 500
		});
	}

	if ( jQuery().eislideshow ) {
		eislideshowArgs = {
			autoplay: Boolean( Number( avadaVars.tfes_autoplay ) )
		};

		if ( avadaVars.tfes_animation ) {
			eislideshowArgs.animation = avadaVars.tfes_animation;
		}
		if ( avadaVars.tfes_interval ) {
			eislideshowArgs.slideshow_interval = avadaVars.tfes_interval;
		}
		if ( avadaVars.tfes_speed ) {
			eislideshowArgs.speed = avadaVars.tfes_speed;
		}
		if ( avadaVars.tfes_width ) {
			eislideshowArgs.thumbMaxWidth = avadaVars.tfes_width;
		}

		jQuery( '#ei-slider' ).eislideshow( eislideshowArgs );
	}

	// Timeline vars and click events for infinite scroll
	lastTimelineDate = jQuery( '.fusion-blog-layout-timeline' ).find( '.fusion-timeline-date' ).last().text();
	collapseMonthVisible = true;

	jQuery( '.fusion-blog-layout-timeline' ).find( '.fusion-timeline-date' ).click( function() {
		jQuery( this ).next( '.fusion-collapse-month' ).slideToggle();
	});

	jQuery( '.fusion-timeline-icon' ).find( '.fusion-icon-bubbles' ).click( function() {
		if ( collapseMonthVisible ) {
			jQuery( this ).parent().next( '.fusion-blog-layout-timeline' ).find( '.fusion-collapse-month' ).slideUp();
			collapseMonthVisible = false;
		} else {
			jQuery( this ).parent().next( '.fusion-blog-layout-timeline' ).find( '.fusion-collapse-month' ).slideDown();
			collapseMonthVisible = true;
		}
	});

	// Setup infinite scroll for each blog instance; main blog page and blog shortcodes
	jQuery( '.fusion-posts-container-infinite' ).each( function() {

		// Set the correct container for blog shortcode infinite scroll
		var $blogInfiniteContainer = jQuery( this ),
		    $originalPosts         = jQuery( this ).find( '.post' ),
		    $parentWrapperClasses,
		    $fusionPostsContainer,
		    $currentPage,
		    $loadMoreButton;

		if ( jQuery( this ).find( '.fusion-blog-layout-timeline' ).length ) {
			$blogInfiniteContainer = jQuery( this ).find( '.fusion-blog-layout-timeline' );
		}

		// If more than one blog shortcode is on the page, make sure the infinite scroll selectors are correct
		$parentWrapperClasses = '';
		if ( $blogInfiniteContainer.parents( '.fusion-blog-shortcode' ).length ) {
			$parentWrapperClasses = '.' + $blogInfiniteContainer.parents( '.fusion-blog-shortcode' ).attr( 'class' ).replace( /\ /g, '.' ) + ' ';
		}

		// Infite scroll for main blog page and blog shortcode
		jQuery( $blogInfiniteContainer ).infinitescroll({

			navSelector: $parentWrapperClasses + 'div.pagination',

			// Selector for the paged navigation (it will be hidden)
			nextSelector: $parentWrapperClasses + 'a.pagination-next',

			// Selector for the NEXT link (to page 2)
			itemSelector: $parentWrapperClasses + 'div.pagination .current, ' + $parentWrapperClasses + 'article.post:not( .fusion-archive-description ), ' + $parentWrapperClasses + '.fusion-collapse-month, ' + $parentWrapperClasses + '.fusion-timeline-date',

			// Selector for all items you'll retrieve
			loading: {
				finishedMsg: avadaVars.infinite_finished_msg,
				msg: jQuery( '<div class="fusion-loading-container fusion-clearfix"><div class="fusion-loading-spinner"><div class="fusion-spinner-1"></div><div class="fusion-spinner-2"></div><div class="fusion-spinner-3"></div></div><div class="fusion-loading-msg">' + avadaVars.infinite_blog_text + '</div>' )
			},
			errorCallback: function() {
				if ( jQuery( $blogInfiniteContainer ).hasClass( 'isotope' ) ) {
					jQuery( $blogInfiniteContainer ).isotope();
				}
			}
		}, function( posts ) {

			var columns,
			    gridWidth,
			    i;

			// Timeline layout specific actions
			if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-timeline' ) ) {

				// Check if the last already displayed moth is the same as the first newly loaded; if so, delete one label
				if ( jQuery( posts ).first( '.fusion-timeline-date' ).text() == lastTimelineDate ) {
					jQuery( posts ).first( '.fusion-timeline-date' ).remove();
				}

				// Set the last timeline date to lat of the currently loaded
				lastTimelineDate = jQuery( $blogInfiniteContainer ).find( '.fusion-timeline-date' ).last().text();

				// Append newly loaded items of the same month to the container that is already there
				jQuery( $blogInfiniteContainer ).find( '.fusion-timeline-date' ).each( function() {
					jQuery( this ).next( '.fusion-collapse-month' ).append( jQuery( this ).nextUntil( '.fusion-timeline-date', '.fusion-post-timeline' ) );
				});

				// If all month containers are collapsed, also collapse the new ones
				if ( ! collapseMonthVisible ) {
					setTimeout( function() {
						jQuery( $blogInfiniteContainer ).find( '.fusion-collapse-month' ).hide();
					}, 200 );
				}

				// Delete empty collapse-month containers
				setTimeout( function() {
					jQuery( $blogInfiniteContainer ).find( '.fusion-collapse-month' ).each( function() {
						if ( ! jQuery( this ).children().length ) {
							jQuery( this ).remove();
						}
					});
				}, 10 );

				// Reset the click event for the collapse-month toggle
				jQuery( $blogInfiniteContainer ).find( '.fusion-timeline-date' ).unbind( 'click' );
				jQuery( $blogInfiniteContainer ).find( '.fusion-timeline-date' ).click( function() {
					jQuery( this ).next( '.fusion-collapse-month' ).slideToggle();
				});
			}

			// Grid layout specific actions
			if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-grid' ) &&
				 jQuery().isotope
			) {
				jQuery( posts ).hide();

				// Get the amount of columns
				columns = 2;
				for ( i = 1; i < 7; i++ ) {
					if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
						columns = i;
					}
				}

				// Calculate grid with
				gridWidth = Math.floor( 100 / columns * 100 ) / 100  + '%';
				jQuery( $blogInfiniteContainer ).find( '.post' ).css( 'width', gridWidth );

				// Add and fade in new posts when all images are loaded
				imagesLoaded( posts, function() {
					jQuery( posts ).fadeIn();

					// Relayout isotope
					if ( jQuery( $blogInfiniteContainer ).hasClass( 'isotope' ) ) {
						jQuery( $blogInfiniteContainer ).isotope( 'appended', jQuery( posts ) );
						jQuery( $blogInfiniteContainer ).isotope();
					}

					// Refresh the scrollspy script for one page layouts
					jQuery( '[data-spy="scroll"]' ).each( function() {
						var $spy = jQuery( this ).scrollspy( 'refresh' );
					});
				});
			}

			// Initialize flexslider for post slideshows
			jQuery( $blogInfiniteContainer ).find( '.flexslider' ).flexslider({
				slideshow: Boolean( Number( avadaVars.slideshow_autoplay ) ),
				slideshowSpeed: avadaVars.slideshow_speed,
				video: true,
				pauseOnHover: false,
				useCSS: false,
				prevText: '&#xf104;',
				nextText: '&#xf105;',
				start: function( slider ) {

					// Remove Loading
					slider.removeClass( 'fusion-flexslider-loading' );

					if ( 'undefined' !== typeof( slider.slides ) && 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
						if ( Number( avadaVars.pagination_video_slide ) ) {
							jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
						} else {
							jQuery( slider ).find( '.flex-control-nav' ).hide();
						}
						if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
							window.YTReady( function() {
								new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
									events: {
										'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
									}
								});
							});
						}
					} else {
						if ( Number( avadaVars.pagination_video_slide ) ) {
							jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
						} else {
							jQuery( slider ).find( '.flex-control-nav' ).show();
						}
					}

					// Reinitialize waypoints
					jQuery.waypoints( 'viewportHeight' );
					jQuery.waypoints( 'refresh' );
				},
				before: function( slider ) {
					if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
						if ( Number( avadaVars.status_vimeo ) ) {
							$f( slider.slides.eq( slider.currentSlide ).find( 'iframe' )[0] ).api( 'pause' );
						}

						if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
							window.YTReady( function() {
								new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
									events: {
										'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
									}
								});
							});
						}

						/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
						/* WIP
						playVideoAndPauseOthers( slider );
						*/
					}
				},
				after: function( slider ) {
					if ( 0 !== slider.slides.eq( slider.currentSlide ).find( 'iframe' ).length ) {
						if ( Number( avadaVars.pagination_video_slide ) ) {
							jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '-20px' );
						} else {
							jQuery( slider ).find( '.flex-control-nav' ).hide();
						}

						if ( Number( avadaVars.status_yt ) && true === window.yt_vid_exists ) {
							window.YTReady( function() {
								new YT.Player( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), {
									events: {
										'onStateChange': onPlayerStateChange( slider.slides.eq( slider.currentSlide ).find( 'iframe' ).attr( 'id' ), slider )
									}
								});
							});
						}
					} else {
						if ( Number( avadaVars.pagination_video_slide ) ) {
							jQuery( slider ).find( '.flex-control-nav' ).css( 'bottom', '0px' );
						} else {
							jQuery( slider ).find( '.flex-control-nav' ).show();
						}
					}
					jQuery( '[data-spy="scroll"]' ).each( function() {
						var $spy = jQuery( this ).scrollspy( 'refresh' );
					});
				}
			});

			// Trigger fitvids
			jQuery( posts ).each( function() {
				jQuery( this ).find( '.full-video, .video-shortcode, .wooslider .slide-content' ).fitVids();
			});

			// Hide the load more button, if the currently loaded page is already the last page
			$fusionPostsContainer = $blogInfiniteContainer;
			if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-timeline' ) ) {
				$fusionPostsContainer = jQuery( $blogInfiniteContainer ).parents( '.fusion-posts-container-infinite' );
			}

			$currentPage = $fusionPostsContainer.find( '.current' ).html();
			$fusionPostsContainer.find( '.current' ).remove();

			if ( $fusionPostsContainer.data( 'pages' ) == $currentPage ) {
				$fusionPostsContainer.parent().find( '.fusion-loading-container' ).hide();
				$fusionPostsContainer.parent().find( '.fusion-load-more-button' ).hide();
			}

			// Activate lightbox for the newly added posts
			if ( 'individual' === avadaVars.lightbox_behavior || ! $originalPosts.find( '.fusion-post-slideshow' ).length ) {
				window.avadaLightBox.activate_lightbox( jQuery( posts ) );

				$originalPosts = $blogInfiniteContainer.find( '.post' );
			}

			// Refresh the lightbox, needed in any case
			window.avadaLightBox.refresh_lightbox();
			jQuery( window ).trigger( 'resize' );

			// Trigger resize so that any parallax sections below get recalculated.
			setTimeout( function() {
				jQuery( window ).trigger( 'resize' );
			}, 500 );

		});

		// Setup infinite scroll manual loading
		if ( ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-archive' ) && 'load_more_button' === avadaVars.blog_pagination_type ) ||
			 jQuery( $blogInfiniteContainer ).hasClass( 'fusion-posts-container-load-more' ) ||
			 ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-timeline' ) && jQuery( $blogInfiniteContainer ).parent().hasClass( 'fusion-posts-container-load-more' ) )
		) {
			jQuery( $blogInfiniteContainer ).infinitescroll( 'unbind' );

			// Load more posts button click
			if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-archive' ) ) {
				$loadMoreButton = jQuery( $blogInfiniteContainer ).parent().find( '.fusion-load-more-button' );
			} else {
				$loadMoreButton = jQuery( $blogInfiniteContainer ).parents( '.fusion-blog-archive' ).find( '.fusion-load-more-button' );
			}

			$loadMoreButton.on( 'click', function( e ) {
				e.preventDefault();

				// Use the retrieve method to get the next set of posts
				jQuery( $blogInfiniteContainer ).infinitescroll( 'retrieve' );

				// Trigger isotope for correct positioning
				if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-grid' ) ) {
					jQuery( $blogInfiniteContainer ).isotope();
				}
			});
		}

		// Hide the load more button, if there is only one page
		$fusionPostsContainer = $blogInfiniteContainer;
		if ( jQuery( $blogInfiniteContainer ).hasClass( 'fusion-blog-layout-timeline' ) && jQuery( $blogInfiniteContainer ).parents( '.fusion-blog-layout-timeline-wrapper' ).length ) {
			$fusionPostsContainer = jQuery( $blogInfiniteContainer ).parents( '.fusion-posts-container-infinite' );
		}

		if ( 1 == $fusionPostsContainer.data( 'pages' ) ) {
			$fusionPostsContainer.parent().find( '.fusion-loading-container' ).hide();
			$fusionPostsContainer.parent().find( '.fusion-load-more-button' ).hide();
		}
	});

	/*
	 Portfolio infinite scroll
	 Setup infinite scroll for each portfolio instance.
	 */
	jQuery( '.fusion-portfolio-paging-infinite, .fusion-portfolio-paging-load-more-button' ).each( function() {
		var $portfolioInfiniteScrollContainer        = jQuery( this ),
		    $portfolioInfiniteScrollContainerClasses = '.' + $portfolioInfiniteScrollContainer.attr( 'class' ).replace( /\ /g, '.' ) + ' ';

		// Initialize the infinite scroll object
		$portfolioInfiniteScrollContainer.children( '.fusion-portfolio-wrapper' ).infinitescroll({
			navSelector: $portfolioInfiniteScrollContainerClasses + '.pagination',

			// Selector for the paged navigation (it will be hidden)
			nextSelector: $portfolioInfiniteScrollContainerClasses + '.pagination-next',

			// Selector for the NEXT link (to page 2)
			itemSelector: $portfolioInfiniteScrollContainerClasses + 'div.pagination .current, ' + $portfolioInfiniteScrollContainerClasses + ' .fusion-portfolio-post',

			// Selector for all items you'll retrieve
			loading: {
				finishedMsg: avadaVars.infinite_finished_msg,
				msg: jQuery( '<div class="fusion-loading-container fusion-clearfix"><div class="fusion-loading-spinner"><div class="fusion-spinner-1"></div><div class="fusion-spinner-2"></div><div class="fusion-spinner-3"></div></div><div class="fusion-loading-msg">' + avadaVars.infinite_blog_text + '</div>' )
			},
			errorCallback: function() {
				$portfolioInfiniteScrollContainer.find( '.fusion-portfolio-wrapper' ).isotope();
			}

		}, function( $posts ) {

			var $filters;

			if ( jQuery().isotope ) {

				$filters = $portfolioInfiniteScrollContainer.find( '.fusion-filters' ).find( '.fusion-filter' ),
				$posts   = jQuery( $posts );

				// Hide posts while loading
				$posts.hide();

					// Make sure images are loaded before the posts get shown
				imagesLoaded( $posts, function() {

					var $placeholderImages,
					    $videos,
					    $filterActiveElement,
					    $filterActive,
					    $currentPage;

					// Fade in placeholder images
					$placeholderImages = jQuery( $posts ).find( '.fusion-placeholder-image' );
					$placeholderImages.parents( '.fusion-portfolio-content-wrapper, .fusion-image-wrapper' ).animate({ opacity: 1 });

					// Fade in videos
					$videos = jQuery( $posts ).find( '.fusion-video' );
					$videos.each( function() {
						jQuery( this ).animate({ opacity: 1 });
						jQuery( this ).parents( '.fusion-portfolio-content-wrapper' ).animate({ opacity: 1 });
					});

					$videos.fitVids();

					// Portfolio Images Loaded Check
					window.$portfolio_images_index = 0;
					jQuery( $posts ).imagesLoaded().progress( function( $instance, $image ) {
						if ( jQuery( $image.img ).parents( '.fusion-portfolio-content-wrapper' ).length >= 1 ) {
							jQuery( $image.img, $placeholderImages ).parents( '.fusion-portfolio-content-wrapper' ).delay( 100 * window.$portfolio_images_index ).animate({
								opacity: 1
							});
						} else {
							jQuery( $image.img, $placeholderImages ).parents( '.fusion-image-wrapper' ).delay( 100 * window.$portfolio_images_index ).animate({
								opacity: 1
							});
						}

						window.$portfolio_images_index++;
					});

					if ( $filters ) {

						// Loop through all filters
						$filters.each( function() {
							var $filter     = jQuery( this ),
							    $filterName = $filter.children( 'a' ).data( 'filter' ),
							    $filterWidth,
							    $filterMarginRight,
							    $post;

							if ( $posts ) {

								// Loop through the newly loaded posts
								$posts.each( function() {
									$post = jQuery( this );

									// Check if one of the new posts has the class of a still hidden filter
									if ( $post.hasClass( $filterName.substr( 1 ) ) ) {
										if ( $filter.hasClass( 'fusion-hidden' ) ) {

											if ( ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.content_break_point + 'px)' ) ) {

												// Animate the filter to make it visible
												$filterWidth       = $filter.css( 'width' ),
												$filterMarginRight = $filter.css( 'margin-right' );

												$filter.css( 'width', 0 );
												$filter.css( 'margin-right', 0 );
												$filter.removeClass( 'fusion-hidden' );

												$filter.animate({
													'width': $filterWidth,
													'margin-right': $filterMarginRight
												}, 400, function() {

													// Finally remove animation style values
													$filter.removeAttr( 'style' );
												});
											} else {
												$filter.fadeIn( 400, function() {
													$filter.removeClass( 'fusion-hidden' );
												});
											}
										}
									}
								});
							}
						});
					}

					// Check if filters are displayed
					if ( $portfolioInfiniteScrollContainer.find( '.fusion-filters' ).length ) {

						// Display new posts based on filter selection
						$filterActiveElement = $portfolioInfiniteScrollContainer.find( '.fusion-filters' ).find( '.fusion-filter.fusion-active a' ),
							$filterActive = $filterActiveElement.attr( 'data-filter' ).substr( 1 );

						// If active filter is not the "All" filter
						if ( $filterActive.length ) {

							// Show the new posts matching the active filter
							$posts.each( function() {
								var $post = jQuery( this ),
								    $postGalleryName = $post.find( '.fusion-rollover-gallery' ).data( 'rel' );

								if ( $post.hasClass( $filterActive ) ) {
									$post.fadeIn();

									// Set the lightbox gallery
									if ( $postGalleryName ) {
										$post.find( '.fusion-rollover-gallery' ).attr( 'data-rel', $postGalleryName.replace( 'gallery', $filterActive ) );
									}
								}
							});

							// Check if we need to create a new gallery
							if ( 'created' !== $filterActiveElement.data( 'lightbox' ) ) {

								// Create new lightbox instance for the new gallery
								window.$ilInstances.push( jQuery( '[data-rel^="iLightbox[' + $filterActive + ']"]' ).iLightBox( window.avadaLightBox.prepare_options( 'iLightbox[' + $filterActive + ']' ) ) );

								// Set active filter to lightbox created
								$filterActiveElement.data( 'lightbox', 'created' );
							}

							// Refresh the lightbox, needed in any case
							window.avadaLightBox.refresh_lightbox();

						} else {
							$posts.fadeIn();
						}
					} else {
						$posts.fadeIn();
					}

					// Trigger isotope for correct positioning
					$portfolioInfiniteScrollContainer.find( '.fusion-portfolio-wrapper' ).isotope( 'appended', $posts );

					// Trigger fitvids
					$posts.each( function() {
						jQuery( this ).find( '.full-video, .video-shortcode, .wooslider .slide-content' ).fitVids();
					});

					// Refresh the scrollspy script for one page layouts
					jQuery( '[data-spy="scroll"]' ).each( function() {
						var $spy = jQuery( this ).scrollspy( 'refresh' );
					});

					// Hide the load more button, if the currently loaded page is already the last page
					$currentPage = $portfolioInfiniteScrollContainer.find( '.current' ).html();
					$portfolioInfiniteScrollContainer.find( '.current' ).remove();

					if ( $portfolioInfiniteScrollContainer.data( 'pages' ) == $currentPage ) {
						$portfolioInfiniteScrollContainer.find( '.fusion-loading-container' ).hide();
						$portfolioInfiniteScrollContainer.find( '.fusion-load-more-button' ).hide();
					}
				});
			}
		});

		// Hide the load more button, if there is only one page
		if ( '1' == $portfolioInfiniteScrollContainer.data( 'pages' ) ) {
			$portfolioInfiniteScrollContainer.find( '.fusion-loading-container' ).hide();
			$portfolioInfiniteScrollContainer.find( '.fusion-load-more-button' ).hide();
		}

		// Setup infinite scroll manual loading
		if ( $portfolioInfiniteScrollContainer.hasClass( 'fusion-portfolio-paging-load-more-button' ) ) {
			$portfolioInfiniteScrollContainer.find( '.fusion-portfolio-wrapper' ).infinitescroll( 'unbind' );

			$portfolioInfiniteScrollContainer.find( '.fusion-load-more-button' ).on( 'click', function( e ) {
				e.preventDefault();

				// Use the retrieve method to get the next set of posts
				$portfolioInfiniteScrollContainer.find( '.fusion-portfolio-wrapper' ).infinitescroll( 'retrieve' );

				// Trigger isotope for correct positioning
				$portfolioInfiniteScrollContainer.find( '.fusion-portfolio-wrapper' ).isotope();
			});
		}
	});
});

// Prevent anchor jumping on page load
if ( location.hash && '#_' === location.hash.substring( 0, 2 ) ) {

	// Add the anchor link to the hidden a tag
	jQuery( '.fusion-page-load-link' ).attr( 'href', '#' + location.hash.substring( 2 ) );

	// Scroll the page
	jQuery( window ).load( function() {
		if ( jQuery( '.fusion-blog-shortcode' ).length ) {
			setTimeout( function() {
				jQuery( '.fusion-page-load-link' ).fusion_scroll_to_anchor_target();
			}, 300 );
		} else {
			jQuery( '.fusion-page-load-link' ).fusion_scroll_to_anchor_target();
		}
	});
}
