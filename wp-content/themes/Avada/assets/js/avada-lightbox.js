/*******************************************
 Avada Lightbox
 *
 * @package		Avada
 * @author		ThemeFusion
 * @link		http://theme-fusion.com
 * @copyright	ThemeFusion
********************************************/

window.avadaLightBox = {};

if ( undefined === window.$ilInstances ) {
	window.$ilInstances = [];
}

// Manipulate pretty photo content
window.avadaLightBox.initialize_lightbox = function() {
	'use strict';

	if ( 1 == Number( avadaVars.status_lightbox ) ) {

		// For old prettyPhoto instances initialize caption and titles
		window.avadaLightBox.set_title_and_caption();

		// Activate lightbox now
		window.avadaLightBox.activate_lightbox();
	}
};

// Activate lightbox]
window.avadaLightBox.activate_lightbox = function( $wrapper ) {
	'use strict';

	var $groupsArr = [],
	    $tiledGalleryCounter;

	// Default value for optional $gallery variable
	if ( 'undefined' === typeof $wrapper ) {
		$wrapper = jQuery( 'body' );
	}

	$wrapper.find( '[data-rel^="prettyPhoto["], [rel^="prettyPhoto["], [data-rel^="iLightbox["], [rel^="iLightbox["]' ).each( function() {

		var $imageFormats     = ['bmp', 'gif', 'jpeg', 'jpg', 'png', 'tiff', 'tif', 'jfif', 'jpe', 'svg', 'mp4', 'ogg', 'webm' ],
		    $imageFormatsMask = 0,
		    $href             = jQuery( this ).attr( 'href' ),
		    $i,
		    $regExp,
		    $match,
		    $dataRel,
		    $rel;

		// Fix for #1738
		if ( 'undefined' === typeof $href ) {
			$href = '';
		}

		// Loop through the image extensions array to see if we have an image link
		for ( $i = 0; $i < $imageFormats.length; $i++ ) {
			$imageFormatsMask += String( $href ).toLowerCase().indexOf( '.' + $imageFormats[$i] );
		}

		// Check for Vimeo URL
		$regExp = /http(s?):\/\/(www\.)?vimeo.com\/(\d+)/;
		$match  = $href.match( $regExp );
		if ( $match ) {
			$imageFormatsMask = 1;
		}

		// Check for Youtube URL
		$regExp =  /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		$match  = $href.match( $regExp );
		if ( $match ) {
			$imageFormatsMask = 1;
		}

		// If no image extension was found add the no lightbox class
		if ( $imageFormatsMask == -13 ) {
			jQuery( this ).addClass( 'fusion-no-lightbox' );
		}

		if ( ! jQuery( this ).hasClass( 'fusion-no-lightbox' ) ) {
			$dataRel = this.getAttribute( 'data-rel' );
			if ( null != $dataRel ) {
				jQuery.inArray( $dataRel, $groupsArr ) === -1 && $groupsArr.push( $dataRel );
			}

			$rel = this.getAttribute( 'data-rel' );
			if ( null != $rel ) {

				// For WP galleries make sure each has its own lightbox gallery
				if ( jQuery( this ).parents( '.gallery' ).length ) {
					$rel = $rel.replace( 'postimages', jQuery( this ).parents( '.gallery' ).attr( 'id' ) );
					jQuery( this ).attr( 'data-rel', $rel );
				}

				jQuery.inArray( $rel, $groupsArr ) === -1 && $groupsArr.push( $rel );
			}
		}
	});

	// Special setup for jetpack tiled gallery
	$tiledGalleryCounter = 1;
	$wrapper.find( '.tiled-gallery' ).each( function() {
		jQuery( this ).find( '.tiled-gallery-item > a' ).each( function() {
			var $dataRel = this.getAttribute( 'data-rel' );
			if ( null == $dataRel ) {
				$dataRel = 'iLightbox[tiled-gallery-' + $tiledGalleryCounter + ']';
				jQuery( this ).attr( 'data-rel', $dataRel );
			}

			jQuery.inArray( $dataRel, $groupsArr ) === -1 && $groupsArr.push( $dataRel );
		});

		$tiledGalleryCounter++;
	});

	// Activate lightbox for galleries
	jQuery.each( $groupsArr, function( $i, $groupName ) {

		// For groups with only one single image, disable the slideshow play button
		if ( 1 == jQuery( '[data-rel="' + $groupName + '"], [rel="' + $groupName + '"]' ).length ) {
			window.$ilInstances.push( jQuery( '[data-rel="' + $groupName + '"], [rel="' + $groupName + '"]' ).iLightBox( window.avadaLightBox.prepare_options( $groupName, false ) ) );
		} else {
			window.$ilInstances.push( jQuery( '[data-rel="' + $groupName + '"], [rel="' + $groupName + '"]' ).iLightBox( window.avadaLightBox.prepare_options( $groupName ) ) );
		}
	});

	// Activate lightbox for single instances
	$wrapper.find( 'a[rel="prettyPhoto"], a[data-rel="prettyPhoto"], a[rel="iLightbox"], a[data-rel="iLightbox"]' ).each( function() {
		window.$ilInstances.push( jQuery( this ).iLightBox( window.avadaLightBox.prepare_options( 'single' ) ) );
	});

	// Activate lightbox for single lightbox links
	$wrapper.find( '#lightbox-link, .lightbox-link, .fusion-lightbox-link' ).each( function() {
		window.$ilInstances.push( jQuery( this ).iLightBox( window.avadaLightBox.prepare_options( 'single' ) ) );
	});

	// Activate lightbox for images within the post content
	if ( Boolean( Number( avadaVars.lightbox_post_images ) ) ) {
		$wrapper.find( '.type-post .post-content a, #posts-container .post .post-content a, .fusion-blog-shortcode .post .post-content a' ).has( 'img' ).each( function() {

			// Make sure the lightbox is only used for image links and not for links to external pages
			var $imageFormats     = ['bmp', 'gif', 'jpeg', 'jpg', 'png', 'tiff', 'tif', 'jfif', 'jpe', 'svg', 'mp4', 'ogg', 'webm' ],
			    $imageFormatsMask = 0,
			    $i;

			// Loop through the image extensions array to see if we have an image link
			for ( $i = 0; $i < $imageFormats.length; $i++ ) {
				$imageFormatsMask += String( jQuery( this ).attr( 'href' ) ).toLowerCase().indexOf( '.' + $imageFormats[ $i ] );
			}

			// If no image extension was found add the no lightbox class
			if ( -13 == $imageFormatsMask ) {
				jQuery( this ).addClass( 'fusion-no-lightbox' );
			}

			if ( -1 === String( jQuery( this ).attr( 'rel' ) ).indexOf( 'prettyPhoto' ) && -1 === String( jQuery( this ).attr( 'data-rel' ) ).indexOf( 'prettyPhoto' ) && -1 === String( jQuery( this ).attr( 'rel' ) ).indexOf( 'iLightbox' ) && -1 === String( jQuery( this ).attr( 'data-rel' ) ).indexOf( 'iLightbox' ) && ! jQuery( this ).hasClass( 'fusion-no-lightbox' ) ) {
				jQuery( this ).attr( 'data-caption', jQuery( this ).parent().find( 'p.wp-caption-text' ).text() );
				window.$ilInstances.push( jQuery( this ).iLightBox( window.avadaLightBox.prepare_options( 'post' ) ) );
			}
		});
	}
};

// For old prettyPhoto instances initialize caption and titles]
window.avadaLightBox.set_title_and_caption = function() {
	'use strict';

	jQuery( 'a[rel^="prettyPhoto"], a[data-rel^="prettyPhoto"]' ).each( function( index ) {
		if ( ! jQuery( this ).attr( 'data-caption' ) ) {

			if ( ! jQuery( this ).attr( 'title' ) ) {
				jQuery( this ).attr( 'data-caption', jQuery( this ).parents( '.gallery-item' ).find( '.gallery-caption' ).text() );
			} else {
				jQuery( this ).attr( 'data-caption', jQuery( this ).attr( 'title' ) );
			}
		}

		if ( ! jQuery( this ).attr( 'data-title' ) ) {
			jQuery( this ).attr( 'data-title', jQuery( this ).find( 'img' ).attr( 'alt' ) );
		}
	});

	jQuery( 'a[rel^="iLightbox"], a[data-rel^="iLightbox"]' ).each(function( index ) {
		if ( ! jQuery( this ).attr( 'data-caption' ) ) {
			jQuery( this ).attr( 'data-caption', jQuery( this ).parents( '.gallery-item' ).find( '.gallery-caption' ).text() );
		}
	});
};

/**
* [prepare_options set data for page options]
*/
window.avadaLightBox.prepare_options = function( $linkID, $gallery ) {
	'use strict';

	var $showSpeed,
	    $autoplay,
	    $ilightboxArgs;

	// Default value for optional $gallery variable
	if ( 'undefined' === typeof $gallery ) {
		$gallery = Boolean( Number( avadaVars.lightbox_gallery  ) );
	}

	$showSpeed     = { Fast: 100, Slow: 800, Normal: 400 };
	$autoplay      = { 1: false, 0: true };
	$ilightboxArgs = {
		skin: avadaVars.lightbox_skin,
		smartRecognition: false,
		minScale: 0.075,
		show: {
			title: Boolean( Number( avadaVars.lightbox_title ) ),
			speed: $showSpeed[avadaVars.lightbox_animation_speed]
		},
		path: avadaVars.lightbox_path,
		controls: {
			slideshow: $gallery,
			arrows: Boolean( Number( avadaVars.lightbox_arrows ) )
		},
		slideshow: {
			pauseTime: avadaVars.lightbox_slideshow_speed,
			pauseOnHover: false,
			startPaused: $autoplay[Number( avadaVars.lightbox_autoplay )]
		},
		overlay: {
			opacity: avadaVars.lightbox_opacity
		},
		caption: {
			start: Boolean( Number( avadaVars.lightbox_desc ) ),
			show: '',
			hide: ''
		},
		isMobile: true
	};

	// For social sharing
	if ( Boolean( Number( avadaVars.lightbox_social ) ) ) {

		$ilightboxArgs.social = {
			buttons: {
				facebook: true,
				twitter: true,
				googleplus: true,
				reddit: true,
				digg: true,
				delicious: true
			}
		};
	}

	// For deep linking
	if ( Boolean( Number( avadaVars.lightbox_deeplinking ) ) ) {
		$ilightboxArgs.linkId = $linkID;
	}

	return $ilightboxArgs;
};

// A function to refresh all items and rebind all elements.]
window.avadaLightBox.refresh_lightbox = function( ) {
	'use strict';

	window.avadaLightBox.set_title_and_caption();

	jQuery.each( window.$ilInstances, function( $key, $value ) {
		if ( $value.hasOwnProperty( 'refresh' ) ) {
			$value.refresh();
		}
	});
};

// Lightbox initialization for dynamically loaded content
jQuery( document ).ajaxComplete( function() {
	'use strict';
	window.avadaLightBox.refresh_lightbox();
});

jQuery( window ).load( function() {
	'use strict';

	// Initialize lightbox
	window.avadaLightBox.initialize_lightbox();
});
