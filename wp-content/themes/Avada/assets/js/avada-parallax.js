/*jshint -W065 */
/**
 * requestAnimationFrame polyfill
 *
 * http://paulirish.com/2011/requestanimationframe-for-smart-animating/
 * http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
 * requestAnimationFrame polyfill by Erik Möller. fixes from Paul Irish and Tino Zijdel
 * requestAnimationFrame polyfill under MIT license
 */
( function( global ) {

	( function() {

		var lastTime = 0;

		if ( global.requestAnimationFrame ) {
			return;
		}

		// Chrome <= 23, Safari <= 6.1, Blackberry 10
		if ( global.webkitRequestAnimationFrame ) {
			global.requestAnimationFrame = global.webkitRequestAnimationFrame;
			global.cancelAnimationFrame  = global.webkitCancelAnimationFrame || global.webkitCancelRequestAnimationFrame;
		}

		// IE <= 9, Android <= 4.3, very old/rare browsers
		global.requestAnimationFrame = function( callback ) {
			var currTime   = new Date().getTime(),
			    timeToCall = Math.max( 0, 16 - ( currTime - lastTime ) ),
			    id = global.setTimeout( function() {
					callback( currTime + timeToCall );
			    }, timeToCall );

			lastTime = currTime + timeToCall;

			// Return the id for cancellation capabilities.
			return id;

		};

		global.cancelAnimationFrame = function( id ) {
			clearTimeout( id );
		};

	})();

	if ( 'function' === typeof define ) {
		define( function() {
			return global.requestAnimationFrame;
		});
	}

})( window );

// Don't re-initialize our variables since that can delete existing values
if ( 'undefined' === typeof window._fusionImageParallaxImages ) {
	window._fusionImageParallaxImages = [];
}

( function( $, window, document, undefined ) {

	// Create the defaults once
	var pluginName = 'fusionImageParallax',
	    defaults   = {
			direction: 'up', // Fixed
			mobileenabled: false,
			mobiledevice: false,
			width: '',
			height: '',
			align: 'center',
			opacity: '1',
			velocity: '.3',
			image: '', // The background image to use, if empty, the current background image is used
			target: '', // The element to apply the parallax to
			repeat: false,
			loopScroll: '',
			loopScrollTime: '2',
			removeOrig: false,
			complete: function() {}
	    };

	// The actual plugin constructor
	function Plugin( element, options ) {

		var bgPosition;

		this.element = element;

		/**
		 * The jQuery library has an extend method which merges
		 * the contents of two or more objects, storing the result in the first object.
		 * The first object is generally empty as we don't want to alter
		 * the default options for future instances of the plugin.
		 */
		this.settings = $.extend( {}, defaults, options );

		// ThemeFusion edit for Avada theme: making background position work
		bgPosition = this.settings.align.split( ' ' );
		this.settings.xpos = bgPosition[0];

		if ( 2 === bgPosition.length ) {
			this.settings.ypos = bgPosition[1];
		} else {
			this.settings.ypos = 'center';
		}

		this._defaults = defaults;
		this._name = pluginName;
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend(
		Plugin.prototype, {
			init: function() {

				// Place initialization logic here
				// You already have access to the DOM element and
				// the options via the instance, e.g. this.element
				// and this.settings
				// you can add more functions like the one below and
				// call them like so: this.yourOtherFunction(this.element, this.settings).
				// console.log("xD");

				// $(window).bind( 'parallax', function() {
				// self.fusionImageParallax();
				// });

				// If there is no target, use the element as the target
				if ( '' === this.settings.target ) {
					this.settings.target = $( this.element );
				}

				// If there is no image given, use the background image if there is one
				if ( '' === this.settings.image ) {

					// If ( typeof $(this.element).css('backgroundImage') !== 'undefined' && $(this.element).css('backgroundImage').toLowerCase() !== 'none' && $(this.element).css('backgroundImage') !== '' )
					if ( 'undefined' !== typeof $( this.element ).css( 'backgroundImage' ) && '' !== $( this.element ).css( 'backgroundImage' ) ) {
						this.settings.image = $( this.element ).css( 'backgroundImage' ).replace( /url\(|\)|"|'/g, '' );
					}
				}

				window._fusionImageParallaxImages.push( this );

				this.setup();

				this.settings.complete();

				this.containerWidth = 0;
				this.containerHeight = 0;
			},

			setup: function() {
				if ( false !== this.settings.removeOrig ) {
					$( this.element ).remove();
				}

				this.resizeParallaxBackground();
			},

			doParallax: function() {
				var $target = this.settings.target.find( '.parallax-inner' ),
				    w,
				    h,
				    percentageScroll,
				    dist,
				    translateHori,
				    translateHoriSuffix,
				    translateVert,
				    translateVertSuffix;

				// If it's a mobile device and not told to activate on mobile, stop.
				if ( this.settings.mobiledevice && ! this.settings.mobileenabled ) {

					/*
					$target.css( {
						'width': '100%',
						'top': '0',
						'left': '0',
						'right': '0',
						'height': 'auto',
						'min-height': $target.parent().outerHeight() + 'px'
					});
					*/
					return;
				}

				// Check if the container is in the view.
				if ( ! this.isInView() ) {
					return;
				}

				// Assert a minimum of 150 pixels of height globally. Prevents the illusion of parallaxes not rendering at all in empty fields.
				$target.css({
					minHeight: '150px'
				});

				// Retrigger a resize if the container's size suddenly changed.
				w = this.settings.target.width() + parseInt( this.settings.target.css( 'paddingRight' ) ) + parseInt( this.settings.target.css( 'paddingLeft' ) );
				h = this.settings.target.height() + parseInt( this.settings.target.css( 'paddingTop' ) ) + parseInt( this.settings.target.css( 'paddingBottom' ) );
				if ( 0 !== this.containerWidth && 0 !== this.containerHeight && ( w !== this.containerWidth || h !== this.containerHeight ) ) {
					this.resizeParallaxBackground();
				}
				this.containerWidth = w;
				this.containerHeight = h;

				// If we don't have anything to scroll, stop
				if ( 'undefined' === typeof $target || 0 === $target.length ) {
					return;
				}

				// Compute for the parallax amount.
				percentageScroll = ( window._fusionScrollTop - this.scrollTopMin ) / ( this.scrollTopMax - this.scrollTopMin );
				dist             = this.moveMax * percentageScroll;

				if ( 'down' ===  this.settings.direction ) {
					dist *= 1.25;
				}

				// Change direction.
				if ( 'left' === this.settings.direction || 'up' === this.settings.direction ) {
					dist *= -1;
				}

				// IE9 check, IE9 doesn't support 3d transforms, so fallback to 2d translate
				translateHori       = 'translate3d(';
				translateHoriSuffix = 'px, -2px, 0px)';
				translateVert       = 'translate3d(0px, ';
				translateVertSuffix = 'px, 0px)';

				if ( 'undefined' !== typeof _fusionParallaxIE9 ) {
					translateHori       = 'translate(';
					translateHoriSuffix = 'px, 0px)';
					translateVert       = 'translate(0px, ';
					translateVertSuffix = 'px)';
				}

				if ( 'no-repeat' === $target.css( 'background-repeat' ) ) {
					if ( 'down' === this.settings.direction && 0 > dist ) {
						dist = 0;
					} else if ( 'up' === this.settings.direction && 0 < dist ) {
						dist = 0;
					}  else if ( 'right' === this.settings.direction && 0 > dist ) {
						dist = 0;
					}  else if ( 'left' === this.settings.direction && 0 < dist ) {
						dist = 0;
					}
				}

				// Apply the parallax transforms
				// Use GPU here, use transition to force hardware acceleration
				if ( 'fixed' === this.settings.direction ) {

					// For fixed direction, mimic the position of the scroll since doing a position: fixed
					// inside an overflow: hidden doesn't work in Firefox
/*
					$target.css({
						top: -this.settings.target.offset().top,
						webkitTransition: 'webkitTransform 1ms linear',
						mozTransition: 'mozTransform 1ms linear',
						msTransition: 'msTransform 1ms linear',
						oTransition: 'oTransform 1ms linear',
						transition: 'transform 1ms linear',
						webkitTransform: translateVert + window._fusionScrollTop + translateVertSuffix,
						mozTransform: translateVert + window._fusionScrollTop + translateVertSuffix,
						msTransform: translateVert + window._fusionScrollTop + translateVertSuffix,
						oTransform: translateVert + window._fusionScrollTop + translateVertSuffix,
						transform: translateVert + window._fusionScrollTop + translateVertSuffix
					});
*/
				} else if ( 'left' === this.settings.direction || 'right' === this.settings.direction ) {
					$target.css(
						{
							webkitTransform: translateHori + dist + translateHoriSuffix,
							mozTransform: translateHori + dist + translateHoriSuffix,
							msTransform: translateHori + dist + translateHoriSuffix,
							oTransform: translateHori + dist + translateHoriSuffix,
							transform: translateHori + dist + translateHoriSuffix
						}
					);
				} else {
					$target.css(
						{
							webkitTransform: translateVert + dist + translateVertSuffix,
							mozTransform: translateVert + dist + translateVertSuffix,
							msTransform: translateVert + dist + translateVertSuffix,
							oTransform: translateVert + dist + translateVertSuffix,
							transform: translateVert + dist + translateVertSuffix
						}
					);
				}
			},

			// Checks whether the container with the parallax is inside our viewport
			isInView: function() {
				var $target = this.settings.target,
				    elemTop,
				    elemHeight;

				if ( 'undefined' === typeof $target || 0 === $target.length ) {
					return;
				}

				elemTop    = $target.offset().top;
				elemHeight = $target.height() + parseInt( $target.css( 'paddingTop' ) ) + parseInt( $target.css( 'paddingBottom' ) );

				if ( elemTop + elemHeight < window._fusionScrollTop || window._fusionScrollTop + window._fusionWindowHeight < elemTop ) {
					return false;
				}

				return true;
			},

			// Resizes the parallax to match the container size
			resizeParallaxBackground: function() {
				var $target = this.settings.target,
				    isRepeat,
				    w,
				    h,
				    position,
				    origW,
				    left,
				    heightCompensate,
				    scrollTopMin,
				    scrollTopMax,
				    origH,
				    top;

				if ( 'undefined' === typeof $target || 0 === $target.length ) {
					return;
				}

				// Repeat the background
				isRepeat = 'true' === this.settings.repeat || true === this.settings.repeat || 1 === this.settings.repeat;

				/*
				 * None, do not apply any parallax at all.
				 */
				if ( 'none' ===  this.settings.direction ) {

					// Stretch the image to fit the entire window
					w = $target.width() + parseInt( $target.css( 'paddingRight' ) ) + parseInt( $target.css( 'paddingLeft' ) );

					// Compute position
					position = $target.offset().left;
					if ( 'center' === this.settings.align ) {
						position = '50% 50%';
					} else if ( 'left' === this.settings.align ) {
						position = '0% 50%';
					} else if ( 'right' === this.settings.align ) {
						position = '100% 50%';
					} else if ( 'top' === this.settings.align ) {
						position = '50% 0%';
					} else if ( 'bottom' === this.settings.align ) {
						position = '50% 100%';
					}

					$target.css({
						opacity: Math.abs( parseFloat( this.settings.opacity ) / 100 ),
						backgroundSize: 'cover',
						backgroundAttachment: 'scroll',
						backgroundPosition: position,
						backgroundRepeat: 'no-repeat'
					});
					if ( '' !== this.settings.image && 'none' !== this.settings.image ) {
						$target.css({
							opacity: Math.abs( parseFloat( this.settings.opacity ) / 100 ),
							backgroundImage: 'url(' + this.settings.image + ')'
						});
					}

				// Fixed, just stretch to fill up the entire container
			} else if ( 'fixed' === this.settings.direction ) {

					$target.css({
						backgroundAttachment: 'fixed',
						backgroundRepeat: 'repeat'
					});

					if ( '' !== this.settings.image && 'none' !== this.settings.image ) {
						$target.attr( 'style', 'background-image: url(' + this.settings.image + ') !important;' + $target.attr( 'style' ) );
					}
/*
					 // Stretch the image to fit the entire window
					var w = $target.width() + parseInt( $target.css( 'paddingRight' ) ) + parseInt( $target.css( 'paddingLeft' ) );
					var h = window._fusionWindowHeight;

					if ( this.isMobile ) {
						h += 70;
						w = h / window._fusionWindowHeight * w;
					}

					if ( $target.find( '.parallax-inner' ).length < 1 ) {
						$target.prepend( '<div class="parallax-inner"></div>' );
					}

					// Apply the required styles
					$target.css({
						position: 'relative',
						overflow: 'hidden',
						zIndex: 1,
						'background-image': 'none' // ThemeFusion edit for Avada theme: fxing background-image duplication
					})
					.attr('style', $target.attr('style'))
					.find('.parallax-inner').css({
						pointerEvents: 'none',
						width: w,
						height: h,
						position: 'absolute',
						zIndex: -1,
						top: - this.settings.target.offset().top,
						left: 0,
						backgroundPosition: this.settings.xpos + ' ' + this.settings.ypos, // ThemeFusion edit for Avada theme: fxing bg position
						backgroundAttachment: 'scroll',
						backgroundRepeat: isRepeat ? 'repeat' : 'no-repeat',
						backgroundSize: 'cover' // ThemeFusion edit for Avada theme: make the bg image stretch over all container width
					});

					if ( this.settings.image !== '' && this.settings.image !== 'none' ) {
						$target.find('.parallax-inner').css({
							opacity: Math.abs( parseFloat ( this.settings.opacity ) / 100 ),
							backgroundImage: 'url(' + this.settings.image + ')'
						});
					}
*/

					/*
					 * Left & right parallax - Stretch the image to fit the height & extend the sides
					 */

				} else if ( 'left' === this.settings.direction || 'right' === this.settings.direction ) {

					// Stretch the image to fit the entire window
					w = $target.width() + parseInt( $target.css( 'paddingRight' ) ) + parseInt( $target.css( 'paddingLeft' ) );
					h = $target.height() + 4 + parseInt( $target.css( 'paddingTop' ) ) + parseInt( $target.css( 'paddingBottom' ) );

					origW = w;
					w += 400 * Math.abs( parseFloat( this.settings.velocity ) );

					// Compute left position
					left = 0;
					if ( 'right' === this.settings.direction ) {
						left -= w - origW;
					}

					if ( $target.find( '.parallax-inner' ).length < 1 ) {
						$target.prepend( '<div class="parallax-inner"></div>' );
					}

					// Apply the required styles
					$target.css({
						position: 'relative',
						overflow: 'hidden',
						zIndex: 1,
						'background-image': 'none' // ThemeFusion edit for Avada theme: fxing background-image duplication
					})
					.attr( 'style', $target.attr( 'style' ) ).find( '.parallax-inner' ).css({
						pointerEvents: 'none',
						width: w,
						height: h,
						position: 'absolute',
						zIndex: -1,
						top: 0,
						left: left,
						opacity: Math.abs( parseFloat( this.settings.opacity ) / 100 ),
						backgroundPosition: isRepeat ? '0 0 ' : this.settings.xpos + ' ' + this.settings.ypos, // ThemeFusion edit for Avada theme: fxing bg position
						backgroundRepeat: isRepeat ? 'repeat' : 'no-repeat',
						backgroundSize: isRepeat ? 'auto' : 'cover' // ThemeFusion edit for Avada theme: make the bg image stretch over all container width
					});

					if ( '' !== this.settings.image && 'none' !== this.settings.image ) {
						$target.find( '.parallax-inner' ).css(
							{
								opacity: Math.abs( parseFloat( this.settings.opacity ) / 100 ),
								backgroundImage: 'url(' + this.settings.image + ')',

								// ThemeFusion edit for Avada theme: IE 8 background-size: cover filter
								'filter': ( jQuery( '.ua-ie-8' ).length && ! isRepeat ) ? 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' + this.settings.image + '", sizingMethod="scale")' : '',
								'-ms-filter': ( jQuery( '.ua-ie-8' ).length && ! isRepeat ) ? 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' + this.settings.image + '", sizingMethod="scale")' : ''
							}
						);
					}

					// Compute for the positions to save cycles
					scrollTopMin = 0;
					if ( $target.offset().top > window._fusionWindowHeight ) {
						scrollTopMin = $target.offset().top - window._fusionWindowHeight;
					}
					scrollTopMax = $target.offset().top + $target.height() + parseInt( $target.css( 'paddingTop' ) ) + parseInt( $target.css( 'paddingBottom' ) );

					this.moveMax = w - origW;
					this.scrollTopMin = scrollTopMin;
					this.scrollTopMax = scrollTopMax;

					/*
					 * Up & down parallax - Stretch the image to fit the width & extend vertically
					 */

				} else { // Up or down
					// We have to add a bit more to DOWN since the page is scrolling as well,
					// or else it will not be visible
					heightCompensate = 900;
					heightCompensate = jQuery( window ).height();

					// Stretch the image to fit the entire window
					w = $target.width() + parseInt( $target.css( 'paddingRight' ) ) + parseInt( $target.css( 'paddingLeft' ) );
					h = $target.height() + parseInt( $target.css( 'paddingTop' ) ) + parseInt( $target.css( 'paddingBottom' ) );
					origH = h;
					h += heightCompensate * Math.abs( parseFloat( this.settings.velocity ) );

					// Compute top position
					top = 0;
					if ( 'down' === this.settings.direction ) {
						top -= h - origH;
					}

					if ( $target.find( '.parallax-inner' ).length < 1 ) {
						$target.prepend( '<div class="parallax-inner"></div>' );
					}

					// Apply the required styles
					$target.css({
						position: 'relative',
						overflow: 'hidden',
						zIndex: 1,
						'background-image': 'none' // ThemeFusion edit for Avada theme: fxing background-image duplication
					})
					.attr( 'style', $target.attr( 'style' ) )
					.find( '.parallax-inner' ).css({
						pointerEvents: 'none',
						width: w,
						height: h,
						position: 'absolute',
						zIndex: -1,
						top: top,
						left: 0,
						opacity: Math.abs( parseFloat( this.settings.opacity ) / 100 ),
						backgroundPosition: isRepeat ? '0 0 ' : this.settings.xpos + ' ' + this.settings.ypos, // ThemeFusion edit for Avada theme: fxing bg position
						backgroundRepeat: isRepeat ? 'repeat' : 'no-repeat',
						backgroundSize: isRepeat ? 'auto' : 'cover' // ThemeFusion edit for Avada theme: make the bg image stretch over all container width
					});

					if ( '' !== this.settings.image && 'none' !== this.settings.image ) {
						$target.find( '.parallax-inner' ).css({
							opacity: Math.abs( parseFloat( this.settings.opacity ) / 100 ),
							backgroundImage: 'url(' + this.settings.image + ')',

							// ThemeFusion edit for Avada theme: IE 8 background-size: cover filter
							'filter': ( jQuery( '.ua-ie-8' ).length && ! isRepeat ) ? 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' + this.settings.image + '", sizingMethod="scale")' : '',
							'-ms-filter': ( jQuery( '.ua-ie-8' ).length && ! isRepeat ) ? 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' + this.settings.image + '", sizingMethod="scale")' : ''
						});
					}

					// Compute for the positions to save cycles
					scrollTopMin = 0;
					if ( $target.offset().top > window._fusionWindowHeight ) {
						scrollTopMin = $target.offset().top - window._fusionWindowHeight;
					}
					scrollTopMax = $target.offset().top + $target.height() + parseInt( $target.css( 'paddingTop' ) ) + parseInt( $target.css( 'paddingBottom' ) );

					this.moveMax = h - origH;
					this.scrollTopMin = scrollTopMin;
					this.scrollTopMax = scrollTopMax;
				}
			},

			// ThemeFusion edit for Avada theme: completely new mobile check
			isMobile: function() {
				return ( jQuery( window ).width() <= 800 ) || // Small screen sizes.
						Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)' ) ||
						Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape)' ) ||
					( window.screen.width <= 1000 && window.devicePixelRatio > 1 ); // Device size estimate.
			}
		}
	);

	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn[pluginName] = function( options ) {
		this.each( function() {
			if ( ! $.data( this, 'plugin_' + pluginName ) ) {
				$.data( this, 'plugin_' + pluginName, new Plugin( this, options ) );
			}
		});

		// Chain jQuery functions.
		return this;
	};

})( jQuery, window, document );

function _fusionRefreshScroll() {
	window._fusionScrollTop  = window.pageYOffset; // $( window ).scrollTop();
	window._fusionScrollLeft = window.pageXOffset; // $( window ).scrollLeft();
}

function _fusionParallaxAll() {
	var i;

	_fusionRefreshScroll();
	for ( i = 0; i < window._fusionImageParallaxImages.length; i++ ) {
		window._fusionImageParallaxImages[ i ].doParallax();
	}
}

// ThemeFusion edit for Avada theme: moved function out of ready event
function _fusionRefreshWindow() {
	window._fusionScrollTop    = window.pageYOffset; // $( window ).scrollTop();
	window._fusionWindowHeight = jQuery( window ).height();
	window._fusionScrollLeft   = window.pageXOffset; // $( window ).scrollLeft();
	window._fusionWindowWidth  = jQuery( window ).width();
}

jQuery( document ).ready(
	function( $ ) {
		'use strict';

		$( window ).on(
			'scroll touchmove touchstart touchend gesturechange', function( e ) {
				requestAnimationFrame( _fusionParallaxAll );
			}
		);

		function mobileParallaxAll() {

			var i;

			_fusionRefreshScroll();
			for ( i = 0; i < window._fusionImageParallaxImages.length; i++ ) {
				window._fusionImageParallaxImages[ i ].doParallax();
			}
			requestAnimationFrame( mobileParallaxAll );
		}

		if ( ( Modernizr.touch && jQuery( window ).width() <= 1024 ) || // Touch device estimate.
			( window.screen.width <= 1281 && window.devicePixelRatio > 1 ) ) { // Device size estimate.
			requestAnimationFrame( mobileParallaxAll );
		}

		// When the browser resizes, fix parallax size
		// Some browsers do not work if this is not performed after 1ms
		$( window ).on(
			'resize', function() {
				setTimeout(
					function() {
						_fusionRefreshWindow();
						jQuery.each(
							window._fusionImageParallaxImages, function( i, parallax ) {
								parallax.resizeParallaxBackground();
							}
						);
					}, 1
				);
			}
		);

		setTimeout(
			function() {
				_fusionRefreshWindow();
				jQuery.each(
					window._fusionImageParallaxImages, function( i, parallax ) {
						parallax.resizeParallaxBackground();
					}
				);
			}, 1
		);

		setTimeout(
			function() {
				_fusionRefreshWindow();
				jQuery.each(
					window._fusionImageParallaxImages, function( i, parallax ) {
						parallax.resizeParallaxBackground();
					}
				);
			}, 100
		);
	}
);

// ThemeFusion edit for Avada theme: needed if FusionSlider is present to recalc the dimensions
jQuery( window ).load( function() {

	setTimeout(
		function() {
			_fusionRefreshWindow();
			jQuery.each(
				window._fusionImageParallaxImages, function( i, parallax ) {
					parallax.resizeParallaxBackground();
				}
			);
		}, 1
	);

	setTimeout(
		function() {
			_fusionRefreshWindow();
			jQuery.each(
				window._fusionImageParallaxImages, function( i, parallax ) {
					parallax.resizeParallaxBackground();
				}
			);
		}, 1000
	);
});

// @codekit-prepend "fusion-parallax.js"
// @codekit-append "fusion-video-bg.js"

jQuery( document ).ready( function( $ ) {
	'use strict';

	/*
	 * Remove video background in mobile devices.
	 */

	// Remove the video for mobile devices
	function _isMobile() {
		return ( Modernizr.touch && jQuery( window ).width() <= 1000 ) || // Touch device estimate.
			( window.screen.width <= 1281 && window.devicePixelRatio > 1 ); // Device size estimate.
	}

	if ( _isMobile() ) {
		$( '.fusion-bg-parallax.video > div' ).remove();
	}

	// Hide the placeholder
	$( '.fusion-bg-parallax' ).next().addClass( 'bg-parallax-parent' );
	$( '.fusion-bg-parallax' ).attr( 'style', '' ).css( 'display', 'none' );

	/*
	 * Initialize the image parallax
	 */

	$( '.fusion-bg-parallax' ).each(function() {
		$( this ).fusionImageParallax({
			image: $( this ).data( 'bg-image' ),
			direction: $( this ).data( 'direction' ),
			mobileenabled: $( this ).data( 'mobile-enabled' ),
			mobiledevice: _isMobile(),
			opacity: $( this ).data( 'opacity' ),
			width: $( this ).data( 'bg-width' ),
			height: $( this ).data( 'bg-height' ),
			velocity: $( this ).data( 'velocity' ),
			align: $( this ).data( 'bg-align' ),
			repeat: $( this ).data( 'bg-repeat' ),
			target: $( this ).next(),
			complete: function() {
			}
		});
	});

	// ThemeFusion edit for Avada theme: remove IE 8 background-size: cover filter for all others
	if ( ! jQuery( '.ua-ie-8' ).length ) {
		$( '.fusion-parallax-fixed' ).each( function() {
			$( this ).css({
				'filter': '',
				'-ms-filter': ''
			});
		});
	}

	/*
	 * Initialize the video background
	 */

	// This is currently performed in the bg-video.js script FIXME

});
