var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		FusionPageBuilder.MultiElementSettingsView = window.wp.Backbone.View.extend( {

			className: 'fusion_builder_module_settings',

			events: {
				'click #qt_element_content_fusion_shortcodes_text_mode': 'activateSCgenerator',
				'click .insert-slider-video': 'addSliderVideo'
			},

			activateSCgenerator: function() {
				openShortcodeGenerator( $( event.target ) );
			},

			initialize: function() {
				this.template = FusionPageBuilder.template( $( '#fusion-builder-block-module-settings-template' ).html() );
				this.listenTo( FusionPageBuilderEvents, 'fusion-modal-view-removed', this.removeElement );
			},

			addSliderVideo: function( event ) {

				var defaultParams,
				    params,
				    elementType,
				    value;

				if ( event ) {
					event.preventDefault();
				}

				FusionPageBuilderApp.shortcodeGenerator = true;
				FusionPageBuilderApp.shortcodeGeneratorEditorID = 'video';

				elementType = $( event.currentTarget ).data( 'type' );

				// Get default options
				defaultParams = fusionAllElements[elementType].params;
				params = {};

				// Process default parameters from shortcode
				_.each( defaultParams, function( param )  {
					if ( _.isObject( param.value ) ) {
						value = param.default;
					} else {
						value = param.value;
					}
					params[param.param_name] = value;
				} );

				this.collection.add( [ {
					type: 'generated_element',
					added: 'manually',
					element_type: elementType,
					params: params
				} ] );
			},

			render: function() {
				var $thisEl = this.$el,
				    content = '',
				    view,
				    $tinymce,
				    $contentTextareaContainer,
				    $contentTextareaOption,
				    $colorPicker,
				    $uploadButton,
				    $iconPicker,
				    $multiselect,
				    $checkboxbuttonset,
				    $radiobuttonset,
				    $value,
				    $id,
				    $container,
				    $search,
				    viewCID,
				    $checkboxsetcontainer,
				    $radiosetcontainer,
				    $visibility,
				    $choice,
				    $rangeSlider,
				    $i,
				    $slider,
				    $slide,
				    $targetId,
				    $rangeInput,
				    $min,
				    $max,
				    $step,
				    value,
				    $decimals,
				    activeMCE,
				    $editor,
				    $rangeDefault,
				    $hiddenValue,
				    $defaultValue,
				    $selectField,
				    $notFirst,
				    textareaID,
				    thisModel,
				    allowGenerator = false,
				    that           = this,
				    $parentValues,
				    defaultReset,
				    $textField,
				    $theContent;

				thisModel = this.model;

				if ( 'undefined' !== typeof thisModel.get( 'allow_generator' ) && true === thisModel.get( 'allow_generator' ) ) {
					FusionPageBuilderApp.allowShortcodeGenerator = true;
				}
				$parentValues = ( 'undefined' !== typeof thisModel.attributes.parent_values ) ? thisModel.attributes.parent_values : '';

				this.$el.html( this.template( { atts: this.model.attributes } ) );

				$textField         = this.$el.find( '[data-placeholder]' );
				$tinymce           = this.$el.find( '.fusion-editor-field' );
				$colorPicker       = this.$el.find( '.fusion-builder-color-picker-hex' );
				$uploadButton      = this.$el.find( '.fusion-builder-upload-button' );
				$iconPicker        = this.$el.find( '.fusion-iconpicker' );
				$multiselect       = this.$el.find( '.fusion-form-multiple-select' );
				$checkboxbuttonset = this.$el.find( '.fusion-form-checkbox-button-set' );
				$radiobuttonset    = this.$el.find( '.fusion-form-radio-button-set' );
				$rangeSlider       = this.$el.find( '.fusion-slider-container' );
				$selectField       = this.$el.find( '.fusion-select-field' );

				if ( $textField.length ) {
					$textField.on( 'focus', function( event ) {
						if ( jQuery( event.target ).data( 'placeholder' ) === jQuery( event.target ).val() ) {
							jQuery( event.target ).val( '' );
						}
					} );
				}
				if ( $colorPicker.length ) {
					$colorPicker.each( function() {
						var self = $( this ),
						    $defaultReset = self.parents( '.fusion-builder-option' ).find( '.fusion-builder-default-reset' );

						// Picker with default.
						if ( $( this ).data( 'default' ) && $( this ).data( 'default' ).length ) {
							$( this ).wpColorPicker( {
								change: function( event, ui ) {
									if ( 'undefined' !== typeof thisModel.attributes.parent_values[ self.attr( 'id' ) ] ) {
										that.colorChange( ui.color.toString(), self, $defaultReset, thisModel.attributes.parent_values[ self.attr( 'id' ) ] );
									} else {
										that.colorChange( ui.color.toString(), self, $defaultReset );
									}
								},
								clear: function( event, ui ) {
									if ( 'undefined' !== typeof thisModel.attributes.parent_values[ self.attr( 'id' ) ] ) {
										that.colorClear( event, self, thisModel.attributes.parent_values[ self.attr( 'id' ) ] );
									} else {
										that.colorClear( event, self );
									}
								}
							} );

							// Make it so the reset link also clears color.
							$defaultReset.on( 'click', 'a', function( event ) {
								event.preventDefault();
								if ( 'undefined' !== typeof thisModel.attributes.parent_values[ self.attr( 'id' ) ] ) {
									that.colorClear( event, self, thisModel.attributes.parent_values[ self.attr( 'id' ) ] );
								} else {
									that.colorClear( event, self );
								}
							});

						// Picker without default.
						} else {
							$( this ).wpColorPicker( {

							} );
						}

						// For some reason non alpha are not triggered straight away.
						if ( true !== $( this ).data( 'alpha' ) ) {
							$( this ).wpColorPicker().change();
						}
					} );
				}

				if ( $selectField.length ) {
					$selectField.chosen({
						width: '100%',
						disable_search_threshold: 10
					});
				}

				if ( $uploadButton.length ) {
					FusionPageBuilderApp.FusionBuilderActivateUpload( $uploadButton );
				}

				if ( $iconPicker.length ) {
					$value     = $iconPicker.find( '.fusion-iconpicker-input' ).val();
					$id        = $iconPicker.find( '.fusion-iconpicker-input' ).attr( 'id' );
					$container = $iconPicker.find( '.icon_select_container' );
					$search    = $iconPicker.find( '.fusion-icon-search' );

					FusionPageBuilderApp.fusion_builder_iconpicker( $value, $id, $container, $search );
				}

				if ( $multiselect.length ) {
					$multiselect.chosen({
						width: '100%',
						placeholder_text_multiple: fusionBuilderText.select_options_or_leave_blank_for_all
					} );
				}

				if ( $checkboxbuttonset.length ) {

					// For the visibility option check if choice is no or yes then convert to new style
					$visibility = this.$el.find( '.fusion-form-checkbox-button-set.hide_on_mobile' );
					if ( $visibility.length ) {
						$choice = $visibility.find( '.button-set-value' ).val();
						if ( 'no' == $choice || '' == $choice ) {
							$visibility.find( 'a' ).addClass( 'ui-state-active' );
						}
						if ( 'yes' == $choice ) {
							$visibility.find( 'a:not([data-value="small-visibility"])' ).addClass( 'ui-state-active' );
						}
					}

					$checkboxbuttonset.find( 'a' ).on( 'click', function( e ) {
						e.preventDefault();
						$checkboxsetcontainer = jQuery( this ).parents( '.fusion-form-checkbox-button-set' );
						jQuery( this ).toggleClass( 'ui-state-active' );
						$checkboxsetcontainer.find( '.button-set-value' ).val( $checkboxsetcontainer.find( '.ui-state-active' ).map( function( _, el ) {
							return jQuery( el ).data( 'value' );
						}).get() );
					});
				}

				if ( $radiobuttonset.length ) {
					$radiobuttonset.find( 'a' ).on( 'click', function( e ) {
						e.preventDefault();
						$radiosetcontainer = jQuery( this ).parents( '.fusion-form-radio-button-set' );
						$radiosetcontainer.find( '.ui-state-active' ).removeClass( 'ui-state-active' );
						jQuery( this ).addClass( 'ui-state-active' );
						$radiosetcontainer.find( '.button-set-value' ).val( $radiosetcontainer.find( '.ui-state-active' ).data( 'value' ) ).trigger( 'change' );
					});
				}

				function createSlider( $slide, $targetId, $rangeInput, $min, $max, $step, $value, $decimals, $rangeDefault, $hiddenValue, $defaultValue, $direction ) {

					// Create slider with values passed on in data attributes.
					var $slider = noUiSlider.create( $rangeSlider[$slide], {
							start: [ $value ],
							step: $step,
							direction: $direction,
							range: {
								'min': $min,
								'max': $max
							},
							format: wNumb({
								decimals: $decimals
							})
					    }),
					    $notFirst = false;

					// Check if default is currently set.
					if ( $rangeDefault && '' === $hiddenValue.val() ) {
						$rangeDefault.parent().addClass( 'checked' );
					}

					// If this range has a default option then if checked set slider value to data-value.
					if ( $rangeDefault ) {
						$rangeDefault.on( 'click', function( e ) {
							e.preventDefault();
							$rangeSlider[$slide].noUiSlider.set( $defaultValue );
							$hiddenValue.val( '' );
							jQuery( this ).parent().addClass( 'checked' );
						});
					}

					// On slider move, update input
					$slider.on( 'update', function( values, handle ) {
						if ( $rangeDefault && $notFirst ) {
							$rangeDefault.parent().removeClass( 'checked' );
							$hiddenValue.val( values[handle] );
						}
						$notFirst = true;
						jQuery( this.target ).closest( '.fusion-slider-container' ).prev().val( values[handle] ).trigger( 'change' );
						$thisEl.find( '#' + $targetId ).trigger( 'change' );
					});

					// On manual input change, update slider position
					$rangeInput.on( 'keyup', function( values, handle ) {
						if ( $rangeDefault ) {
							$rangeDefault.parent().removeClass( 'checked' );
							$hiddenValue.val( values[handle] );
						}

						if ( this.value !== $rangeSlider[$slide].noUiSlider.get() ) {
							$rangeSlider[$slide].noUiSlider.set( this.value );
						}
					});
				}

				if ( $rangeSlider.length ) {

					// Counter variable for sliders
					$i = 0;

					// Method for retreiving decimal places from step
					Number.prototype.countDecimals = function() {
						if ( Math.floor( this.valueOf() ) === this.valueOf() ) {
							return 0;
						}
						return this.toString().split( '.' )[1].length || 0;
					};

					// Each slider on page, determine settings and create slider
					$rangeSlider.each( function() {

						var $targetId     = jQuery( this ).data( 'id' ),
						    $rangeInput   = jQuery( this ).prev( '.fusion-slider-input' ),
						    $min          = jQuery( this ).data( 'min' ),
						    $max          = jQuery( this ).data( 'max' ),
						    $step         = jQuery( this ).data( 'step' ),
						    $direction    = jQuery( this ).data( 'direction' );
						    $value        = $rangeInput.val(),
						    $decimals     = $step.countDecimals(),
						    $rangeDefault = ( jQuery( this ).parents( '.fusion-builder-option' ).find( '.fusion-range-default' ).length ) ? jQuery( this ).parents( '.fusion-builder-option' ).find( '.fusion-range-default' ) : false,
						    $hiddenValue  = ( $rangeDefault ) ? jQuery( this ).parent().find( '.fusion-hidden-value' ) : false,
						    $defaultValue = ( $rangeDefault ) ? jQuery( this ).parents( '.fusion-builder-option' ).find( '.fusion-range-default' ).data( 'default' ) : false;

						// Check if parent has another value set to override TO default.
						if ( 'undefined' !== typeof thisModel.attributes.parent_values[ $targetId ] && $rangeDefault ) {

							//  Set default values to new value.
							jQuery( this ).parents( '.fusion-builder-option' ).find( '.fusion-range-default' ).data( 'default', thisModel.attributes.parent_values[ $targetId ] );
							$defaultValue = thisModel.attributes.parent_values[ $targetId ];

							// If no current value is set, also update $value as representation on load.
							if ( ! $hiddenValue || '' === $hiddenValue.val() ) {
								$value = $defaultValue;
							}
						}

						createSlider( $i, $targetId, $rangeInput, $min, $max, $step, $value, $decimals, $rangeDefault, $hiddenValue, $defaultValue, $direction );

						$i++;
					});

				}

				// If there is tiny mce editor ( tinymce element option )
				if ( $tinymce.length ) {

					$contentTextareaOption = $tinymce.closest( '.fusion-builder-option' );

					// Shortcode Generator. Multi element child view.
					if ( true === FusionPageBuilderApp.shortcodeGenerator ) {

						content = $tinymce.html();

						// TODO: unique id ( multiple mce )
						$tinymce.attr( 'id', 'generator_multi_child_content' );

						textareaID = $tinymce.attr( 'id' );

						setTimeout( function() {

							$tinymce.wp_editor( content, textareaID );

							// If it is a placeholder, add an on focus listener.
							if ( jQuery( '#' + textareaID ).data( 'placeholder' ) ) {
								window.tinyMCE.get( textareaID ).on( 'focus', function( e ) {
									$theContent = window.tinyMCE.get( textareaID ).getContent();
									$theContent = jQuery( '<div/>' ).html( $theContent ).text();
									if ( $theContent === jQuery( '#' + textareaID ).data( 'placeholder' ) ) {
										window.tinyMCE.get( textareaID ).setContent( '' );
									}
								});
							}
						}, 300 );

					// Not from Shortcode Generator
					} else {

						if ( 'undefined' !== typeof ( this.model.get( 'params' ).element_content ) ) {
							content = this.model.get( 'params' ).element_content;

						} else {
							content = $tinymce.html();
						}

						textareaID = $tinymce.attr( 'id' );

						setTimeout( function() {

							if ( 'undefined' !== typeof thisModel.get( 'allow_generator' ) && true === thisModel.get( 'allow_generator' ) ) {
								allowGenerator = true;
							}

							$tinymce.wp_editor( content, textareaID, allowGenerator );

							// If it is a placeholder, add an on focus listener.
							if ( jQuery( '#' + textareaID ).data( 'placeholder' ) ) {
								window.tinyMCE.get( textareaID ).on( 'focus', function( e ) {
									$theContent = window.tinyMCE.get( textareaID ).getContent();
									$theContent = jQuery( '<div/>' ).html( $theContent ).text();
									if ( $theContent === jQuery( '#' + textareaID ).data( 'placeholder' ) ) {
										window.tinyMCE.get( textareaID ).setContent( '' );
									}
								});
							}
						}, 100 );

					}
				}

				setTimeout( function() {
					$thisEl.find( 'select, input, textarea, radio' ).filter( ':eq(0)' ).not( '[data-placeholder]' ).focus();
				}, 1 );

				// Range option preview
				FusionPageBuilderApp.rangeOptionPreview( this.$el );

				// Check option dependencies
				if ( 'undefined' !== typeof this.model ) {
					FusionPageBuilderApp.checkOptionDependency( fusionAllElements[ this.model.get( 'element_type' ) ], this.$el, $parentValues );
				}

				return this;
			},

			removeElement: function() {

				// Remove settings modal on save or close/cancel
				this.remove();
			},

			colorChange: function( value, self, defaultReset, customDefault ) {
				var defaultColor = ( customDefault ) ? customDefault : self.data( 'default' );

				if ( value === defaultColor ) {
					defaultReset.addClass( 'checked' );
				} else {
					defaultReset.removeClass( 'checked' );
				}

				if ( '' === value && null !== defaultColor ) {
					self.val( defaultColor );
					self.change();
					self.val( '' );
				}
			},

			colorClear: function( event, self, customDefault ) {
				var  defaultColor = ( customDefault ) ? customDefault : self.data( 'default' );

				if ( null !== defaultColor ) {
					self.val( defaultColor );
					self.change();
					self.val( '' );
					self.parent().parent().find( '.wp-color-result' ).css( 'background-color', defaultColor );
				}
			}

		} );

	} );

} )( jQuery );
