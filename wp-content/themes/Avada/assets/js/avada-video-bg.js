/*jshint -W065 */
/*jshint -W083 */
/**
 * These are in charge of initializing YouTube
 */

var $youtubeBGVideos = {};

function _fbRowGetAllElementsWithAttribute( attribute ) {
	var matchingElements = [],
	    allElements = document.getElementsByTagName( '*' ),
	    i,
	    n;

	for ( i = 0, n = allElements.length; i < n; i++ ) {
		if ( allElements[i].getAttribute( attribute ) && ! jQuery( allElements[i] ).parents( '.tfs-slider' ).length ) {

			// Element exists with attribute. Add to array.
			matchingElements.push( allElements[i] );
		}
	}
	return matchingElements;
}

/*
// WIP
function _fbRowOnPlayerReady( event ) {

   var player = event.target;

   player.playVideo();
   if ( player.isMute ) {
	   player.mute();
   }

   //jQuery( player.a ).parent().css( 'position', 'relative' );

   //if ( jQuery( player.a ).parent().data( 'loop' ) ) {
   //    player.loopInterval = setInterval(
   //        function() {
   //            if ( typeof player.loopTimeout !== 'undefined' ) {
   //                clearTimeout( player.loopTimeout );
   //            }
   //
   //            var loopAdjustment = 0;
   //            if ( typeof jQuery( player.a ).parent().attr( 'data-loop-adjustment' ) !== 'undefined' &&
   //                jQuery( player.a ).parent().attr( 'data-loop-adjustment' ) !== '' &&
   //                jQuery( player.a ).parent().attr( 'data-loop-adjustment' ) !== '0' ) {
   //                loopAdjustment = parseInt( jQuery( player.a ).parent().attr( 'data-loop-adjustment' ) );
   //            }
   //
   //
   //            player.loopTimeout = setTimeout(
   //                function() {
   //                    player.seekTo( 0 );
   //                }, player.getDuration() * 1000 - player.getCurrentTime() * 1000 - 60 - loopAdjustment
   //            );
   //        }, 400
   //    );
   //}
   player.loopInterval = setInterval(function() {
	   if ( typeof player.loopTimeout !== 'undefined' ) {
		   clearTimeout( player.loopTimeout );
	   }

	   var loopAdjustment = 0;
	   if ( typeof jQuery(player.a).parent().attr('data-loop-adjustment') !== 'undefined' &&
		   jQuery(player.a).parent().attr('data-loop-adjustment') !== '' &&
		   jQuery(player.a).parent().attr('data-loop-adjustment') !== '0' ) {
		   loopAdjustment = parseInt( jQuery(player.a).parent().attr('data-loop-adjustment') );
	   }


	   player.loopTimeout = setTimeout(function() {
		   player.seekTo(0);
	   }, player.getDuration() * 1000 - player.getCurrentTime() * 1000 - 60 - loopAdjustment );
   }, 400);
}

function clearThisTimeout( player ) {

   console.log('clearThisTimeout');

   if ( !jQuery( player.getIframe() ).parent().data( 'loop' ) ) {
	   player.pauseVideo();
	   return;
   }
   player.seekTo( 0 );
   event.target.trackTime = trackPlaytime( event.target );
}

function checkTime( player ) {

   if ( typeof player.customLoop !== 'undefined' ) {
	   return;
   }

   clearTimeout( player.customLoop );

   var $timeLeft = ( player.getDuration() - player.getCurrentTime() ) * 1000 - 500;
   player.customLoop = setTimeout(
	   function() {
		   clearThisTimeout( player );
	   }, $timeLeft
   );
}

function trackPlaytime( player ) {

   var $timeLeft = ( player.getDuration() - player.getCurrentTime() ) * 1000 - 500;
   console.log("trackPlaytime"+$timeLeft);
   if ( $timeLeft <= 0 ) {
	   window.clearInterval( player.trackTime );
	   clearThisTimeout( player );
   }
};

function _fbRowOnPlayerStateChange( event ) {

   if ( event.data === YT.PlayerState.PLAYING ) {
	   jQuery( event.target.getIframe() ).parent().css( 'visibility', 'visible' );
	   if ( event.target.trackTime === 'undefined' ) {
		   console.log('here');
		   event.target.trackTime =  window.setInterval( function() {
			   trackPlaytime( event.target );
		   }, 100 );
	   }
   }

   //if (event.data === 0 && jQuery( event.target.getIframe() ).parent().data( 'loop' ) ) { // video ended and repeat option is set true
   //    event.target.seekTo( 0 ); // restart
   //}
   //
   //console.log(YT.PlayerState);
   //console.log(event.data);
   //
   //if ( event.data === YT.PlayerState.ENDED ) {
   //    clearThisTimeout( event.target );
   //} else if ( event.data === YT.PlayerState.PLAYING ) {
   //
   //    jQuery( event.target.getIframe() ).parent().css( 'visibility', 'visible' );
   //    setTimeout(
   //        function() {
   //            checkTime( event.target );
   //        }, 500
   //    );
   //}
}
*/

function _fbRowOnPlayerReady( event ) {
	var player   = event.target,
	    currTime = 0,
	    firstRun = true,
	    prevCurrTime,
	    timeLastCall;

	player.playVideo();
	if ( player.isMute ) {
		player.mute();
	}

	prevCurrTime = player.getCurrentTime();
	timeLastCall = +new Date() / 1000;

	player.loopInterval = setInterval( function() {
		if ( 'undefined' !== typeof player.loopTimeout ) {
				clearTimeout( player.loopTimeout );
			}

			if ( prevCurrTime === player.getCurrentTime() ) {
				currTime = prevCurrTime + ( +new Date() / 1000 - timeLastCall );
			} else {
				currTime = player.getCurrentTime();
				timeLastCall = +new Date() / 1000;
			}
			prevCurrTime = player.getCurrentTime();

			if ( currTime + ( firstRun ? 0.45 : 0.21 ) >= player.getDuration() ) {
				player.pauseVideo();
				player.seekTo( 0 );
				player.playVideo();
				firstRun = false;
			}
		}, 150
	);
}

function _fbRowOnPlayerStateChange( event ) {
	if ( event.data === YT.PlayerState.ENDED ) {
		if ( 'undefined' !== typeof event.target.loopTimeout ) {
			clearTimeout( event.target.loopTimeout );
		}
		event.target.seekTo( 0 );

		// Make the video visible when we start playing
	} else if ( event.data === YT.PlayerState.PLAYING ) {
		jQuery( event.target.getIframe() ).parent().css( 'visibility', 'visible' );
	}
}

function resizeVideo( $wrapper ) {
	var $videoContainer = $wrapper.parent(),
	    $videoWrapper,
	    vidWidth,
	    vidHeight,
	    containerWidth,
	    containerHeight,
	    containerPaddingLeft,
	    containerPaddingRight,
	    finalWidth,
	    finalHeight,
	    deltaWidth,
	    deltaHeight,
	    aspectRatio,
	    height,
	    width,
	    $parent,
	    marginTop,
	    marginLeft,
	    $videoDisplay;

	if ( null === $videoContainer.find( 'iframe' ).width() ) {
		setTimeout( function() {
			resizeVideo( $wrapper );
		}, 500 );
		return;
	}

	$videoWrapper = $wrapper;

	$videoWrapper.css({
			width: 'auto',
			height: 'auto',
			left: 'auto',
			top: 'auto'
		}
	);

	$videoWrapper.css( 'position', 'absolute' );

	$videoDisplay         = $videoContainer.find( '> div' ).data( 'display' );
	vidWidth              = $videoContainer.find( 'iframe' ).width();
	vidHeight             = $videoContainer.find( 'iframe' ).height();
	containerWidth        = $videoContainer.width();
	containerHeight       = $videoContainer.height();
	containerPaddingLeft  = parseInt( $videoContainer.css( 'padding-left' ) );
	containerPaddingRight = parseInt( $videoContainer.css( 'padding-right' ) );

	if ( 1 <= jQuery( '.width-100' ).length ) {
		if ( 0 < containerPaddingRight ) {
			containerWidth += containerPaddingRight;
		}

		if ( 0 < containerPaddingLeft > 0 ) {
			containerWidth += containerPaddingLeft;
		}
	}

	aspectRatio = '16:9';
	if ( 'undefined' !== typeof $wrapper.attr( 'data-video-aspect-ratio' ) ) {
		if ( $wrapper.attr( 'data-video-aspect-ratio' ).indexOf( ':' ) !== -1 ) {
			aspectRatio = $wrapper.attr( 'data-video-aspect-ratio' ).split( ':' );
			aspectRatio[0] = parseFloat( aspectRatio[0] );
			aspectRatio[1] = parseFloat( aspectRatio[1] );
		}
	}

	finalHeight = containerHeight;
	finalWidth  = aspectRatio[0] / aspectRatio[1] * containerHeight;
	deltaWidth  = ( aspectRatio[0] / aspectRatio[1] * containerHeight ) - containerWidth;
	deltaHeight = ( containerWidth * aspectRatio[1] ) / aspectRatio[0] - containerHeight;
	if ( 'contain' === $videoDisplay ) {
		$videoContainer.css( 'paddingTop', $videoContainer.parent( 'li' ).find( '.slide-content-container' ).css( 'paddingTop' ) );
		if ( finalHeight >= containerHeight ) {
			height = containerHeight;
			width  = aspectRatio[0] / aspectRatio[1] * containerHeight;
		}
		if ( width >= containerWidth ) {
			width  = containerWidth;
			height  = aspectRatio[1] / aspectRatio[0] * containerWidth;
		}
	} else {
		if ( finalWidth >= containerWidth && finalHeight >= containerHeight ) {
			height = containerHeight;
			width  = aspectRatio[0] / aspectRatio[1] * containerHeight;
		} else {
			width  = containerWidth;
			height = ( containerWidth * aspectRatio[1] ) / aspectRatio[0];
		}
	}
	if ( 1 <= jQuery( '.width-100' ).length ) {
		if ( 0 < containerPaddingRight ) {
			width += containerPaddingRight;
		}

		if ( 0 < containerPaddingLeft ) {
			width += containerPaddingLeft;
		}

		height = ( width * aspectRatio[1] ) / aspectRatio[0];
	}

	marginTop  = -( height - containerHeight ) / 2;
	marginLeft = -( width - containerWidth ) / 2;

	if ( 1 > $videoContainer.find( '.fusion-video-cover' ).length ) {
		$parent = $videoContainer.find( 'iframe' ).parent();
		$parent.prepend( '<div class="fusion-video-cover">&nbsp;</div>' );
	}

	// No YouTube right click stuff!
	$videoContainer.find( '.fusion-video-cover' ).css({
			'z-index': 0,
			'width': width,
			'height': height,
			'position': 'absolute'
		}
	);
	$videoContainer.find( 'iframe' ).parent().css({
			'marginLeft': marginLeft,
			'marginTop': marginTop
		}
	);

	$videoContainer.find( 'iframe' ).css({
			'width': width,
			'height': height,
			'z-index': -1
		}
	);

}

function onYouTubeIframeAPIReady() {
	var videos = _fbRowGetAllElementsWithAttribute( 'data-youtube-video-id' ),
	    i,
	    videoID,
	    elemID,
	    k,
	    player;

	for ( i = 0; i < videos.length; i++ ) {
		videoID = videos[i].getAttribute( 'data-youtube-video-id' );

		// Get the elementID for the placeholder where we'll put in the video
		elemID = '';
		for ( k = 0; k < videos[ i ].childNodes.length; k++ ) {
			if ( /div/i.test( videos[ i ].childNodes[ k ].tagName ) ) {
				elemID = videos[ i ].childNodes[ k ].getAttribute( 'id' );
				break;
			}
		}
		if ( '' === elemID ) {
			continue;
		}

		player = new YT.Player(
			elemID, {
				height: 'auto',
				width: 'auto',
				videoId: videoID,
				playerVars: {
					autohide: 1,
					autoplay: 1,
					fs: 0,
					showinfo: 0,
					modestBranding: 1,
					start: 0,
					controls: 0,
					rel: 0,
					disablekb: 1,
					iv_load_policy: 3,
					wmode: 'transparent'
				},
				events: {
					'onReady': _fbRowOnPlayerReady,
					'onStateChange': _fbRowOnPlayerStateChange
				}
			}
		);

		if ( 'yes' === videos[ i ].getAttribute( 'data-mute' ) ) {
			player.isMute = true;
		} else {
			player.isMute = false;
		}

		// Force YT video to load in HD
		if ( 'true' === videos[ i ].getAttribute( 'data-youtube-video-id' ) ) {
			player.setPlaybackQuality( 'hd720' );
		}

		// Videos in Windows 7 IE do not fire onStateChange events so the videos do not play.
		// This is a fallback to make those work.
		setTimeout(
			function() {
				jQuery( '#' + elemID ).css( 'visibility', 'visible' );
			}, 500
		);
	}
}

// Set up both YouTube and Vimeo videos.
jQuery( document ).ready(
	function( $ ) {
		var $videoContainer,
		    $vimeos,
		    $protocol;

		// Disable showing/rendering the parallax in the VC's frontend editor.
		if ( $( 'body' ).hasClass( 'vc_editor' ) ) {
			return;
		}
		$( '.bg-parallax.video, .fusion-bg-parallax.video' ).each(
			function() {
				$( this ).prependTo( $( this ).next().addClass( 'video' ) );
				$( this ).css({
						opacity: Math.abs( parseFloat( $( this ).attr( 'data-opacity' ) ) / 100 )
					}
				);
			}
		);

		$videoContainer = $( '[data-youtube-video-id], [data-vimeo-video-id]' ).parent();
		$videoContainer.css( 'overflow', 'hidden' );

		$( '[data-youtube-video-id], [data-vimeo-video-id]' ).each( function() {
			var $this = $( this );
			setTimeout(	function() {
				resizeVideo( $this );
			}, 100 );
		});

		$( '[data-youtube-video-id], [data-vimeo-video-id]' ).each( function() {
			var $this = $( this );
			setTimeout( function() {
				resizeVideo( $this );
			}, 1000 );
		});

		$( window ).resize( function() {
			$( '[data-youtube-video-id], [data-vimeo-video-id]' ).each( function() {
				var $this = $( this );
				setTimeout( function() {
					resizeVideo( $this );
				}, 2 );
			});
		});

		/**
		 * Called once a vimeo player is loaded and ready to receive
		 * commands. You can add events and make api calls only after this
		 * function has been called.
		 */
		function vimeoReady( playerID ) {

			// Keep a reference to Froogaloop for this player
			var container  = document.getElementById( playerID ).parentElement,
			    froogaloop = $f( playerID );

			if ( 'yes' === jQuery( container ).data( 'mute' ) ) {
				froogaloop.api( 'setVolume', '0' );
			}

			if ( 'no' === jQuery( container ).data( 'mute' ) ) {
				froogaloop.api( 'setVolume', '1' );
			}

			froogaloop.addEvent( 'playProgress', function onPlayProgress( data, id ) {
				jQuery( container ).css( 'visibility', 'visible' );
			});

		}

		if ( Number( avadaVars.status_vimeo ) ) {
			$vimeos = $( '[data-vimeo-video-id]' );
			if ( 0 < $vimeos.length ) {
				$.getScript( 'https://secure-a.vimeocdn.com/js/froogaloop2.min.js' ).done(
					function( script, textStatus ) {
						var vimeoPlayers = document.querySelectorAll( 'iframe' ),
						    player,
						    i,
						    length = vimeoPlayers.length;

						for ( i = 0; i < length; i++ ) {
							player = vimeoPlayers[i];
							if ( jQuery( 'html' ).hasClass( 'ua-ie-11' ) ) {
								jQuery( player ).parent().css( 'visibility', 'visible' );
							}
							$f( player ).addEvent( 'ready', vimeoReady );
						}
					}
				);
			}
		}

		/**
		 * Utility function for adding an event. Handles the inconsistencies
		 * between the W3C method for adding events (addEventListener) and
		 * IE's (attachEvent).
		 */
		function addEvent( element, eventName, callback ) {
			if ( element.addEventListener ) {
				element.addEventListener( eventName, callback, false );
			} else {
				element.attachEvent( 'on' + eventName, callback );
			}
		}

		/*
		WIP
		player.addEvent('ready', function() {
		   // mute
		   if ( $this.attr( 'data-mute' ) === 'true' ) {
			   player.api( 'setVolume', 0 );
		   }
		});

		player.addEvent('ready', function() {
			console.log('here');
			// mute
			if ( $this.attr('data-mute') === 'true' ) {
				player.api( 'setVolume', 0 );
			}

			// show the video after the player is loaded
			player.addEvent('playProgress', function onPlayProgress(data, id) {
				jQuery('#' + id).parent().css('visibility', 'visible');
			});
		});
		*/

		// When the player is ready, add listeners for pause, finish, and playProgress
	}
);

jQuery( window ).load( function() {
	jQuery( '[data-youtube-video-id], [data-vimeo-video-id]' ).each( function() {
		var $this = jQuery( this );
		setTimeout( function() {
			resizeVideo( $this );
		}, 500 );
	});
});
