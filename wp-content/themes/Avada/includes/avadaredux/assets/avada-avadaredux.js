jQuery( document ).ready( function() {

	var $parentElement,
	    $avadaMenu;

	jQuery( '.custom_color_save_button' ).on( 'click', function( e ) {

		var overlay,
		    $colorName,
		    $type,
		    $notificationBar,
		    $saveAction,
		    $themeOptionsName,
		    $customColors,
		    $data;

		e.preventDefault();

		overlay    = jQuery( '#avadaredux_ajax_overlay' );
		$colorName = '';
		$type      = '';

		overlay.fadeIn();
		jQuery( '.avadaredux-action_bar .spinner' ).addClass( 'is-active' );

		jQuery( '.avadaredux-action_bar input' ).attr( 'disabled', 'disabled' );
		$notificationBar = jQuery( '#avadaredux_notification_bar' );
		$notificationBar.slideUp();
		jQuery( '.avadaredux-save-warn' ).slideUp();
		jQuery( '.avadaredux_ajax_save_error' ).slideUp(
			'medium', function() {
				jQuery( this ).remove();
			}
		);

		// Check the action to use used.
		$saveAction = jQuery( this ).attr( 'id' );

		// If save action is not an import, then use TO values.
		if ( 'custom_color_import_submit' != $saveAction ) {

			// Set the name to save as.
			if ( 'custom_color_save_update' == $saveAction ) {

				// If updating, use selected name.
				$colorName = jQuery( '#color-scheme-update-name' ).val();
				$type = 'update';
			} else {

				//  If saving as new, use input name.
				$colorName = jQuery( '#color-scheme-new-name' ).val();
				$type = 'save';
			}
			$themeOptionsName = 'avada_theme_options';
			$customColors = {
				primary_color:                            jQuery( 'input[name="' + $themeOptionsName + '[primary_color]"]' ).val(),
				pricing_box_color:                        jQuery( 'input[name="' + $themeOptionsName + '[pricing_box_color]"]' ).val(),
				image_gradient_top_color:                 jQuery( 'input[name="' + $themeOptionsName + '[image_gradient_top_color]"]' ).val(),
				image_gradient_bottom_color:              jQuery( 'input[name="' + $themeOptionsName + '[image_gradient_bottom_color]"]' ).val(),
				button_gradient_top_color:                jQuery( 'input[name="' + $themeOptionsName + '[button_gradient_top_color]"]' ).val(),
				button_gradient_bottom_color:             jQuery( 'input[name="' + $themeOptionsName + '[button_gradient_bottom_color]"]' ).val(),
				button_gradient_top_color_hover:          jQuery( 'input[name="' + $themeOptionsName + '[button_gradient_top_color_hover]"]' ).val(),
				button_gradient_bottom_color_hover:       jQuery( 'input[name="' + $themeOptionsName + '[button_gradient_bottom_color_hover]"]' ).val(),
				button_accent_color:                      jQuery( 'input[name="' + $themeOptionsName + '[button_accent_color]"]' ).val(),
				button_accent_hover_color:                jQuery( 'input[name="' + $themeOptionsName + '[button_accent_hover_color]"]' ).val(),
				button_bevel_color:                       jQuery( 'input[name="' + $themeOptionsName + '[button_bevel_color]"]' ).val(),
				checklist_circle_color:                   jQuery( 'input[name="' + $themeOptionsName + '[checklist_circle_color]"]' ).val(),
				counter_box_color:                        jQuery( 'input[name="' + $themeOptionsName + '[counter_box_color]"]' ).val(),
				countdown_background_color:               jQuery( 'input[name="' + $themeOptionsName + '[countdown_background_color]"]' ).val(),
				dropcap_color:                            jQuery( 'input[name="' + $themeOptionsName + '[dropcap_color]"]' ).val(),
				flip_boxes_back_bg:                       jQuery( 'input[name="' + $themeOptionsName + '[flip_boxes_back_bg]"]' ).val(),
				progressbar_filled_color:                 jQuery( 'input[name="' + $themeOptionsName + '[progressbar_filled_color]"]' ).val(),
				counter_filled_color:                     jQuery( 'input[name="' + $themeOptionsName + '[counter_filled_color]"]' ).val(),
				ec_sidebar_widget_bg_color:               jQuery( 'input[name="' + $themeOptionsName + '[ec_sidebar_widget_bg_color]"]' ).val(),
				menu_hover_first_color:                   jQuery( 'input[name="' + $themeOptionsName + '[menu_hover_first_color]"]' ).val(),
				header_top_bg_color:                      jQuery( 'input[name="' + $themeOptionsName + '[header_top_bg_color]"]' ).val(),
				content_box_hover_animation_accent_color: jQuery( 'input[name="' + $themeOptionsName + '[content_box_hover_animation_accent_color]"]' ).val(),
				map_overlay_color:                        jQuery( 'input[name="' + $themeOptionsName + '[map_overlay_color]"]' ).val(),
				flyout_menu_icon_hover_color:             jQuery( 'input[name="' + $themeOptionsName + '[flyout_menu_icon_hover_color]"]' ).val()
			};

			$data = $customColors;

		} else {

			// Importing.
			$data = jQuery( '#avada-import-custom-color-textarea' ).val();
			$type = 'import';
		}

		jQuery.ajax({
			type:     'post',
			dataType: 'json',
			url:       ajaxurl,
			data: {
				action: 'custom_colors_ajax_save',
				data: { name: $colorName, values: $data, type: $type }
			},
			error: function( response ) {
				jQuery( '.avadaredux-action_bar input' ).removeAttr( 'disabled' );
				overlay.fadeOut( 'fast' );
				jQuery( '.avadaredux-action_bar .spinner' ).removeClass( 'is-active' );
			},
			success: function( response ) {
				var $interval;
				jQuery( '#avadaredux_save' ).trigger( 'click' );

				$interval = setInterval( afterSave, 500 );
				function afterSave() {
					if ( ! overlay.is( ':visible' ) ) {
						clearInterval( $interval );
						location.reload( true );
					}
				}
			}
		});
		return false;
	});

	// Custom colors, toggle selection.
	jQuery( '.custom-color-toggle' ).on( 'click', function( e ) {

		var $toggleTarget;

		e.preventDefault();

		// If its the delete toggle, allow scheme selection by adding class to body of page.
		if ( 'avada-delete-custom-color' == jQuery( this ).data( 'toggle' ) ) {
			jQuery( 'body' ).toggleClass( 'color-scheme-selection' );
		} else {
			jQuery( 'body' ).removeClass( 'color-scheme-selection' );
		}

		// Toggle target content visibility.
		$toggleTarget = '#' + jQuery( this ).data( 'toggle' );
		jQuery( '.color-toggle:not(' + $toggleTarget + ')' ).addClass( 'color-hidden' );
		jQuery( $toggleTarget ).toggleClass( 'color-hidden' );
	});

	// On click, toggle item for deletion.
	jQuery( document ).on( 'click', '.color-scheme-selection #avada_theme_options-color_scheme li:nth-child(n+11)', function( e ) {
		e.preventDefault();
		jQuery( this ).toggleClass( 'delete-selected' );
	});

	// Cancel deletion selection.
	jQuery( '#custom_color_delete_cancel' ).on( 'click', function( e ) {
		e.preventDefault();
		jQuery( '.delete-selected' ).removeClass( 'delete-selected' );
	});

	// Send the deletion request.
	jQuery( '#custom_color_delete_confirm' ).on( 'click', function( e ) {

		var overlay,
		    $schemeNames = [],
		    $noSelection,
		    $notificationBar;

		e.preventDefault();

		overlay      = jQuery( '#avadaredux_ajax_overlay' );
		$noSelection = jQuery( '#avada-delete-custom-color .hidden' ).text();

		overlay.fadeIn();
		jQuery( '.avadaredux-action_bar .spinner' ).addClass( 'is-active' );

		jQuery( '.avadaredux-action_bar input' ).attr( 'disabled', 'disabled' );
		$notificationBar = jQuery( '#avadaredux_notification_bar' );
		$notificationBar.slideUp();
		jQuery( '.redux-save-warn' ).slideUp();
		jQuery( '.redux_ajax_save_error' ).slideUp(
			'medium', function() {
				jQuery( this ).remove();
			}
		);

		// Make an array of select scheme names to delete.
		jQuery( '.delete-selected' ).each( function( i ) {
			$schemeNames[i] = jQuery( this ).find( 'input' ).val();
		});

		// If there are some selected, then delete theme.
		if ( jQuery( '.delete-selected' ).length ) {
			jQuery.ajax({
				type:     'post',
				dataType: 'json',
				url:       ajaxurl,
				data: {
					action: 'custom_colors_ajax_delete',
					data: { names: $schemeNames }
				},
				error: function( response ) {
					jQuery( '.redux-action_bar input' ).removeAttr( 'disabled' );
					overlay.fadeOut( 'fast' );
					jQuery( '.redux-action_bar .spinner' ).removeClass( 'is-active' );
				},
				success: function( response ) {
					var $interval;
					jQuery( '#avadaredux_save' ).trigger( 'click' );

					$interval = setInterval( afterSave, 500 );
					function afterSave() {
						if ( ! overlay.is( ':visible' ) ) {
							clearInterval( $interval );
							location.reload( true );
						}
					}
				}
			});
		} else {
			alert( $noSelection );
		}
	});

	// Style the update selections.
	jQuery( 'select.update-select.avadaredux-select-item' ).each(
		function() {
			var defaultParams = {
				width: '180px',
				triggerChange: true,
				allowClear: true,
				minimumResultsForSearch: Infinity
			};
			jQuery( this ).select2( defaultParams );
			jQuery( this ).on( 'change', function() {

				// jscs:disable
				/* jshint ignore:start */
				avadaredux_change( jQuery( jQuery( this ) ) );


				// jscs:enable
				/* jshint ignore:end */
				jQuery( this ).select2SortableOrder();
			});
		}
	);

	// Activate the Avada admin menu theme option entry when theme options are active
	if ( jQuery( 'a[href="themes.php?page=avada_options"]' ).hasClass( 'current' ) ) {
		$avadaMenu = jQuery( '#toplevel_page_avada' );

		$avadaMenu.addClass( 'wp-has-current-submenu wp-menu-open' );
		$avadaMenu.children( 'a' ).addClass( 'wp-has-current-submenu wp-menu-open' );
		$avadaMenu.children( '.wp-submenu' ).find( 'li' ).last().addClass( 'current' );
		$avadaMenu.children( '.wp-submenu' ).find( 'li' ).last().children().addClass( 'current' );

		// Do not show the appearance menu as active
		jQuery( '#menu-appearance a[href="themes.php"]' ).removeClass( 'wp-has-current-submenu wp-menu-open' );
		jQuery( '#menu-appearance' ).removeClass( 'wp-has-current-submenu wp-menu-open' );
		jQuery( '#menu-appearance' ).addClass( 'wp-not-current-submenu' );
		jQuery( '#menu-appearance a[href="themes.php"]' ).addClass( 'wp-not-current-submenu' );
		jQuery( '#menu-appearance' ).children( '.wp-submenu' ).find( 'li' ).removeClass( 'current' );
	}

	$parentElement = jQuery( '#' + avadaAvadareduxVars.option_name + '-social_media_icons .avadaredux-repeater-accordion' );

	// Initialize avadaredux color fields, even when they are insivible
	avadaredux.field_objects.color.init( $parentElement.find( '.avadaredux-container-color ' ) );

	$parentElement.set_social_media_repeater_custom_field_logic();

	jQuery( '.avadaredux-repeaters-add' ).click( function() {
		setTimeout( function() {
			$parentElement = jQuery( '#' + avadaAvadareduxVars.option_name + '-social_media_icons .avadaredux-repeater-accordion' );
			$parentElement.set_social_media_repeater_custom_field_logic();
		}, 50 );
	});

	// Make sure the sub menu flyouts are closed, when a new menu item is activated
	jQuery( '.avadaredux-group-tab-link-li a' ).click( function() {
		jQuery( '.avadaredux-group-tab-link-li' ).removeClass( 'avada-section-hover' );
		jQuery.avadaredux.required();
		jQuery.avadaredux.check_active_tab_dependencies();
	});

	// Make submenus flyout when a main menu item is hovered
	jQuery( '.avadaredux-group-tab-link-li.hasSubSections' ).each( function() {
		jQuery( this ).mouseenter( function() {
			if ( ! jQuery( this ).hasClass( 'activeChild' ) ) {
				jQuery( this ).addClass( 'avada-section-hover' );
			}
		});

		jQuery( this ).mouseleave( function() {
			jQuery( this ).removeClass( 'avada-section-hover' );
		});
	});

	// Add a pattern preview container to show off the background patterns
	jQuery( '#avada_theme_options-bg_pattern' ).append( '<div class="avada-pattern-preview"></div>' );

	// On pattern image click update the preview
	jQuery( '#avada_theme_options-bg_pattern' ).find( 'ul li img' ).click( function() {
		var $background = 'url("' + jQuery( this ).attr( 'src' ) + '") repeat';
		jQuery( '.avada-pattern-preview' ).css( 'background', $background );
	});

	// Setup tooltips on color presets
	jQuery( '#avada_theme_options-scheme_type li, #avada_theme_options-color_scheme li' ).qtip({
		content: {
			text: function( event, api ) {
				return jQuery( this ).find( 'img' ).attr( 'alt' );
			}
		},
		position: {
			my: 'bottom center',
			at: 'top center'
		},
		style: {
			classes: 'avada-tooltip qtip-light qtip-rounded qtip-shadow'
		}
	});

	// Color picker fallback for pre WP 4.4 versions
	jQuery( '.wp-color-result' ).on( 'click', function() {
		jQuery( this ).parent().addClass( 'wp-picker-active' );
	});

	jQuery( '#avada_theme_options-header_layout img' ).on( 'click', function() {

		// Auto adjust main menu height
		var $headerVersion = jQuery( this ).attr( 'alt' ),
		    $mainMenuHeight = '0';

		if ( 'v1' === $headerVersion || 'v2' === $headerVersion || 'v3' === $headerVersion || 'v7' === $headerVersion ) {
			$mainMenuHeight = '83';
		} else {
			$mainMenuHeight = '40';
		}

		jQuery( 'input#nav_height' ).val( $mainMenuHeight );

		// Auto adjust logo margin
		if ( 'v4' === $headerVersion ) {
			jQuery( '#avada_theme_options-logo_margin .avadaredux-spacing-bottom, #avada_theme_options-logo_margin #logo_margin-bottom' ).val( '0px' );
		} else {
			jQuery( '#avada_theme_options-logo_margin .avadaredux-spacing-bottom, #avada_theme_options-logo_margin #logo_margin-bottom' ).val( '31px' );
		}
		jQuery( '#avada_theme_options-logo_margin .avadaredux-spacing-top, #avada_theme_options-logo_margin #logo_margin-top' ).val( '31px' );

		// Auto adjust header v2 topbar color
		if ( 'v2' === $headerVersion ) {
			jQuery( '#avada_theme_options-header_top_bg_color #header_top_bg_color-color' ).val( '#fff' );
		} else {
			jQuery( '#avada_theme_options-header_top_bg_color #header_top_bg_color-color' ).val( jQuery( '#primary_color-color' ).val() );
		}
	});

	jQuery( '#avada_theme_options-header_position label' ).on( 'click', function() {
		var $headerPosition = jQuery( this ).find( 'span' ).text(),
		    $headerVersion  = jQuery( '#avada_theme_options-header_layout' ).find( '.avadaredux-image-select-selected img' ).attr( 'alt' ),
		    $mainMenuHeight;

		// Auto adjust main menu height
		if ( 'Top' === $headerPosition ) {
			if ( 'v1' === $headerVersion || 'v2' === $headerVersion || 'v3' === $headerVersion ) {
				$mainMenuHeight = '83';
			} else {
				$mainMenuHeight = '40';
			}
		} else {
			$mainMenuHeight = '40';
		}
		jQuery( 'input#nav_height' ).val( $mainMenuHeight );

		// Auto set header padding
		jQuery( '#avada_theme_options-header_padding input' ).val( '0px' );
		if ( 'Top' !== $headerPosition ) {
			jQuery( '#avada_theme_options-header_padding input.avadaredux-spacing-left, #avada_theme_options-header_padding #header_padding-left, #avada_theme_options-header_padding input.avadaredux-spacing-right, #avada_theme_options-header_padding #header_padding-right' ).val( '60px' );
		}

		// Auto adjust logo margin
		jQuery( '#avada_theme_options-logo_margin .avadaredux-spacing-top, #avada_theme_options-logo_margin #logo_margin-top, #avada_theme_options-logo_margin .avadaredux-spacing-bottom, #avada_theme_options-logo_margin #logo_margin-bottom' ).val( '31px' );
		if ( 'Top' === $headerPosition && 'v4' === $headerVersion ) {
			jQuery( '#avada_theme_options-logo_margin .avadaredux-spacing-bottom, #avada_theme_options-logo_margin #logo_margin-bottom' ).val( '0px' );
		}
	});

	// Listen for changes to header position and reset to 1 if changing away from top.
	jQuery( '#avada_theme_options-header_position' ).on( 'change', function() {
		if ( 'Top' !== jQuery( this ).find( '.ui-state-active' ).prev( 'input' ).val() ) {
			jQuery( 'input[name="avada_theme_options[header_layout]"]' ).val( 'v2' );
			jQuery( '.avadaredux-image-select-selected' ).removeClass( 'avadaredux-image-select-selected' );
			jQuery( '.header_layout_2' ).addClass( 'avadaredux-image-select-selected' );
		}
	});

	// Listen for changes to medium and update large description.
	jQuery( '#visibility_medium, #avada_theme_options-visibility_medium noUi-handle' ).on( 'change update click', function() {
		jQuery( '#avada-visibility-large span' ).html( jQuery( this ).val() );
	});

});

jQuery( window ).load(function() {

	// If search field is not empty, make sidebar accessible again when an item is clicked and clear the search field
	jQuery( '.avadaredux-sidebar a' ).click( function() {

		var $tabToActivate,
		    $tabToActivateID,
		    $avadareduxOptionTabExtras;

		if ( '' !== jQuery( '.avadaredux_field_search' ).val() ) {
			if ( jQuery( this ).parent().hasClass( 'hasSubSections' ) ) {
				$tabToActivateID = jQuery( this ).data( 'rel' ) + 1;
			} else {
				$tabToActivateID = jQuery( this ).data( 'rel' );
			}

			$tabToActivate = '#' + $tabToActivateID + '_section_group';
			$avadareduxOptionTabExtras = jQuery( '.avadaredux-container' ).find( '.avadaredux-section-field, .avadaredux-info-field, .avadaredux-notice-field, .avadaredux-container-group, .avadaredux-section-desc, .avadaredux-group-tab h3, .avadaredux-accordion-field' );

			// Show the correct tab

			jQuery( '.avadaredux-main' ).find( '.avadaredux-group-tab' ).not( $tabToActivate ).hide();
			jQuery( '.avadaredux-accordian-wrap' ).hide();
			$avadareduxOptionTabExtras.show();
			jQuery( '.form-table tr' ).show();
			jQuery( '.form-table tr.hide' ).hide();
			jQuery( '.avadaredux-notice-field.hide' ).hide();

			jQuery( '.avadaredux-container' ).removeClass( 'avada-avadaredux-search' );
			jQuery( '.avadaredux_field_search' ).val( '' );
			jQuery( '.avadaredux_field_search' ).trigger( 'change' );
		}
	});

	jQuery( '.avadaredux_field_search' ).typeWatch({

		callback: function( $searchString ) {
			var $tab;

			$searchString = $searchString.toLowerCase();

			if ( '' !== $searchString && null !== $searchString && 'undefined' !== typeof $searchString && $searchString.length > 2 ) {
				jQuery( '.avadaredux-sidebar .avadaredux-group-menu' ).find( 'li' ).removeClass( 'activeChild' ).removeClass( 'active' );
				jQuery( '.avadaredux-sidebar .avadaredux-group-menu' ).find( '.submenu' ).hide();

			} else {
				$tab = jQuery.cookie( 'avadaredux_current_tab' );

				if ( jQuery( '#' + $tab + '_section_group_li' ).parents( '.hasSubSections' ).length ) {
					jQuery( '#' + $tab + '_section_group_li' ).parents( '.hasSubSections' ).addClass( 'activeChild' );
					jQuery( '#' + $tab + '_section_group_li' ).parents( '.hasSubSections' ).find( '.submenu' ).show();
				}
				jQuery( '#' + $tab + '_section_group_li' ).addClass( 'active' );
			}
		},

		wait: 500,
		highlight: false,
		captureLength: 0

	} );
});

jQuery.fn.set_social_media_repeater_custom_field_logic = function() {
	jQuery( this ).each( function( i, obj ) {

		var $iconSelect    = jQuery( '#icon-' + i + '-select' ),
		    $customFields  = jQuery( '#' + avadaAvadareduxVars.option_name + '-custom_title-' + i + ', #' + avadaAvadareduxVars.option_name + '-custom_source-' + i );

		// Get the initial value of the select input and depending on its value
		// show or hide the custom icon input elements
		if ( 'custom' == $iconSelect.val() ) {

			// Show input fields & headers
			$customFields.show();
			$customFields.prev().show();
		} else {

			// Hide input fields & headers
			$customFields.hide();
			$customFields.prev().hide();
		}

		if ( ! $iconSelect.val() ) {
			$iconSelect.parents( '.ui-accordion-content' ).css( 'height', '' );
		}

		// Check if the value of the select has changed and show/hide the elements conditionally.
		$iconSelect.change( function() {
			$iconSelect.parents( '.ui-accordion-content' ).css( 'height', '' );

			if ( 'custom' == jQuery( this ).val() ) {

				// Show input fields & headers
				$customFields.show();
				$customFields.prev().show();
			} else {

				// Hide input fields & headers
				$customFields.hide();
				$customFields.prev().hide();
			}
		});
	});
};

jQuery( window ).load( function() {

	var $hrefTarget,
	    $optionTarget,
	    $tabTarget,
	    $adminbarHeight,
	    $theTarget;

	// Check option name and open relevant tab.
	if ( location.hash ) {
		$hrefTarget = window.location.href.split( '#' );

		// If it doesn't contains tab- then assume as option.
		if ( $hrefTarget[1].indexOf( 'tab-' ) == -1 ) {
			$optionTarget   = '#avada_theme_options-' + $hrefTarget[1];
			$tabTarget      = jQuery( $optionTarget ).parents( '.avadaredux-group-tab' ).data( 'rel' );
			$adminbarHeight = 0;

			if ( $tabTarget ) {

				// Check if target element exists.
				$theTarget = jQuery( 'a[data-key="' + $tabTarget + '"]' );
				if ( $theTarget ) {
					setTimeout( function() {

						// Open desired tab.
						jQuery( 'a[data-key="' + $tabTarget + '"]' ).click();
						if ( 'fusion_builder_elements' == $theTarget.data( 'css-id' ) ) {
							jQuery( $optionTarget ).parents( '.avadaredux-accordian-wrap' ).prev( 'div' ).click();
						}
						setTimeout( function() {

							// Scroll to the desired option.
							if ( jQuery( '#wpadminbar' ).length ) {
								$adminbarHeight = parseInt( jQuery( '#wpadminbar' ).outerHeight() );
							}
							jQuery( 'html, body' ).animate({
								scrollTop: jQuery( $optionTarget ).parents( 'tr' ).offset().top - $adminbarHeight }, 450
							);
						}, 200 );
					}, 100 );
				}

			}
		} else {
			$tabTarget = $hrefTarget[1].split( '-' );
			$theTarget = jQuery( 'a[data-css-id="' + $tabTarget[1] + '"]' );

			// Check if desired tab exists.
			if ( $theTarget.length ) {

				// Open desired tab.
				setTimeout( function() {
					$theTarget.click();
				}, 100 );
			}
		}
	}
});
