var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		FusionPageBuilder.ModuleSettingsTableView = window.wp.Backbone.View.extend( {

			className: 'fusion_builder_module_settings',

			initialize: function() {
				this.template = FusionPageBuilder.template( $( '#fusion-builder-block-module-settings-table-template' ).html() );
				this.listenTo( FusionPageBuilderEvents, 'fusion-modal-view-removed', this.removeElement );
			},

			events: {
				'click .fusion-table-builder-add-column': 'addTableColumn',
				'click .fusion-builder-table-clone-column': 'cloneTableColumn',
				'click .fusion-table-builder-add-row': 'addTableRow',
				'click .fusion-builder-table-delete-column': 'removeTableColumn',
				'click .fusion-builder-table-delete-row': 'removeTableRow',
				'click .fusion-builder-table-add-button': 'addButton',
				'click .fusion-form-radio-button-set-button': 'buttonSetClick'
			},

			removeTableRow: function( event ) {
				var rowID;

				if ( event ) {
					event.preventDefault();

					rowID = $( event.currentTarget ).data( 'row-id' );

					$( event.currentTarget ).parents( 'tr' ).remove();
				}

			},

			removeTableColumn: function( event ) {
				var columnID;

				if ( event ) {
					event.preventDefault();

					columnID = $( event.currentTarget ).parents( 'th' ).data( 'th-id' );

					this.$el.find( 'td[data-td-id="' + columnID + '"]' ).remove();
					this.$el.find( 'th[data-th-id="' + columnID + '"]' ).remove();
				}
			},

			addTableColumn: function( event ) {
				var columnID,
					columnIds;

				if ( event ) {
					event.preventDefault();
				}

				if ( ! this.$el.find( '.fusion-table-builder .fusion-builder-table thead tr th' ).length ) {
					columnID = 1;
				} else {
					columnIds = this.$el.find( '.fusion-table-builder .fusion-builder-table thead tr th' ).map( function() {
						return $( this ).data( 'th-id' );
					}).get();

					columnID = Math.max.apply( Math, columnIds ) + 1;
				}

				// Add th
				this.$el.find( '.fusion-table-builder .fusion-builder-table thead tr' ).append( '<th align="left" class="th-' + columnID + '" data-th-id="' + columnID + '"><div class="fusion-builder-table-hold"><div class="fusion-builder-table-column-options"><strong>' + fusionBuilderText.column_title + '</strong><span class="fa fusiona-trash-o fusion-builder-table-delete-column" title="' + fusionBuilderText.delete_column + '" data-column-id="' + columnID + '" /><span class="fa fusiona-file-add fusion-builder-table-clone-column" title="' + fusionBuilderText.clone_column + '" data-column-id="' + columnID + '" /></div></div><div class="fusion-builer-table-featured"><span>' + fusionBuilderText.standout_design + '</span> <div class="fusion-form-radio-button-set ui-buttonset"><input type="hidden" value="no" class="button-set-value" /><a href="#" class="fusion-form-radio-button-set-button ui-button buttonset-item ui-state-active" data-value="no">' + fusionBuilderText.no + '</a><a href="#" class="fusion-form-radio-button-set-button ui-button buttonset-item" data-value="yes">' + fusionBuilderText.yes + '</a></div></div><div class="fusion-builder-column-title"><input type="text" placeholder="' + fusionBuilderText.head_title + '" value="" /></div></th>' );

				// Add td
				this.$el.find( '.fusion-table-builder .fusion-builder-table tbody tr' ).each( function() {

					if ( $( this ).hasClass( 'price' ) ) {
						$( this ).append( '<td class="td-' + columnID + '" data-td-id="' + columnID + '"><input type="text" class="currency-input" placeholder="' + fusionBuilderText.currency + '" value="" /><input type="text" class="price-input" placeholder="' + fusionBuilderText.price + '" value="" /><input type="text" class="time-input" placeholder="' + fusionBuilderText.period + '" value="" /></td>' );

					} else {
						$( this ).append( '<td class="td-' + columnID + '" data-td-id="' + columnID + '"><input type="text" placeholder="' + fusionBuilderText.enter_text + '" value="" /><span class="fa fusiona-trash-o fusion-builder-table-delete-row" title="' + fusionBuilderText.delete_row + '" data-row-id="' + columnID + '" /></td>' );
					}
				} );

				// Add tfoot
				this.$el.find( '.fusion-table-builder .fusion-builder-table tfoot tr' ).each( function() {

					$( this ).append( '<td class="td-' + columnID + '" data-td-id="' + columnID + '"><a href="#" class="fusion-builder-table-add-button fusion-builder-button-default" data-type="fusion_button" data-id="' + columnID + '">' + fusionBuilderText.add_button + '</a><textarea placeholder="' + fusionBuilderText.enter_text + '" id="button_' + columnID + '"></textarea></td>' );
				} );
			},

			cloneTableColumn: function( event ) {
				var columnID,
					columnIds,
					newColumnID,
					$theadTr,
					$tbodyTd,
					$tfootTd;

				jQuery( event.target ).trigger( 'focus' );

				if ( event ) {
					event.preventDefault();
					columnID = $( event.currentTarget ).data( 'column-id' );
					columnIds = this.$el.find( '.fusion-table-builder .fusion-builder-table thead tr th' ).map( function() {
						return $( this ).data( 'th-id' );
					}).get();

					newColumnID = Math.max.apply( Math, columnIds ) + 1;
				}

				// Add cloned th.
				$theadTr = $( event.currentTarget ).parents( 'th' ).clone( true );
				$theadTr.attr( 'data-th-id', newColumnID );
				$theadTr.attr( 'class', 'th-' +  newColumnID );
				$theadTr.find( '.fusion-builder-table-clone-column' ).attr( 'data-column-id', newColumnID );
				$theadTr.find( 'input' ).each( function() {
						jQuery( this ).attr( 'value', jQuery( this ).val() );
				} );
				$( event.currentTarget ).parents( 'th' ).after( $theadTr.outerHTML() );

				// Add cloned td.
				this.$el.find( '.fusion-table-builder .fusion-builder-table tbody tr' ).each( function() {
					$tbodyTd = jQuery( this ).find( 'td[data-td-id="' + columnID + '"]' ).clone( true );
					$tbodyTd.attr( 'data-td-id', newColumnID );
					$tbodyTd.attr( 'class', 'td-' +  newColumnID );
					$tbodyTd.find( 'input' ).each( function() {
						jQuery( this ).attr( 'value', jQuery( this ).val() );
					} );
					jQuery( this ).find( 'td[data-td-id="' + columnID + '"]' ).after( $tbodyTd.outerHTML() );
				} );

				// Add cloned tfoot.
				this.$el.find( '.fusion-table-builder .fusion-builder-table tfoot tr' ).each( function() {
					$tfootTd = jQuery( this ).find( 'td[data-td-id="' + columnID + '"]' ).clone( true );
					$tfootTd.attr( 'data-td-id', newColumnID );
					$tfootTd.attr( 'class', 'td-' +  newColumnID );
					$tfootTd.find( 'a' ).attr( 'data-id', newColumnID );
					$tfootTd.find( 'textarea' ).attr( 'id', 'button_' + newColumnID );
					$tfootTd.find( 'textarea' ).text( jQuery( this ).find( 'td[data-td-id="' + columnID + '"] textarea' ).val() );
					jQuery( this ).find( 'td[data-td-id="' + columnID + '"]' ).after( $tfootTd.outerHTML() );
				} );

			},

			addTableRow: function() {
				var columns   = 0,
				    td        = '',
				    lastRowID = ( 'undefined' !== typeof this.$el.find( '.fusion-table-builder .fusion-builder-table tbody tr:last-child' ).data( 'tr-id' ) ) ? this.$el.find( '.fusion-table-builder .fusion-builder-table tbody tr:last-child' ).data( 'tr-id' ) : 0,
				    newRowID  = lastRowID + 1,
				    i;

				if ( 1 > this.$el.find( '.fusion-table-builder .fusion-builder-table thead tr th' ).length ) {
					return;
				}

				// Count columns
				this.$el.find( '.fusion-table-builder .fusion-builder-table thead tr th' ).each( function() {
					columns = columns + 1;
				});

				for ( i = 1; i <= columns; i++ ) {
					td += '<td class="td-' + i + '" data-td-id="' + i + '" ><input type="text" placeholder="' + fusionBuilderText.enter_text + '" value="" /><span class="fa fusiona-trash-o fusion-builder-table-delete-row" title="' + fusionBuilderText.delete_row + '" data-row-id="' + newRowID + '" /></td>';
				}

				// Add td
				this.$el.find( '.fusion-table-builder .fusion-builder-table tbody' ).append( '<tr class="fusion-table-row tr-' + newRowID + '" data-tr-id="' + newRowID + '">' + td + '</tr>' );
			},

			render: function() {

				var $thisEl = this.$el,
				    content  = '',
				    view,
				    $contentTextarea,
				    $contentTextareaContainer,
				    $contentTextareaOption,
				    $colorPicker,
				    $uploadButton,
				    $iconPicker,
				    $multiselect,
				    $value,
				    $id,
				    $container,
				    $search,
				    $checkboxsetcontainer,
				    $radiosetcontainer,
				    $visibility,
				    $choice,
				    $checkboxbuttonset,
				    that = this,
				    $radiobuttonset;

				this.$el.html( this.template( { atts: this.model.attributes } ) );

				$contentTextarea   = this.$el.find( '.fusion-editor-field' );
				$colorPicker       = this.$el.find( '.fusion-builder-color-picker-hex' );
				$uploadButton      = this.$el.find( '.fusion-builder-upload-button' );
				$iconPicker        = this.$el.find( '.fusion-iconpicker' );
				$multiselect       = this.$el.find( '.fusion-form-multiple-select' );
				$checkboxbuttonset = this.$el.find( '.fusion-form-checkbox-button-set' );
				$radiobuttonset    = this.$el.find( '.fusion-form-radio-button-set' );

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
						$radiosetcontainer.find( '.button-set-value' ).val( $radiosetcontainer.find( '.ui-state-active' ).data( 'value' ) );
					});
				}

				if ( $colorPicker.length ) {
					$colorPicker.each( function() {
						var self = $( this ),
							$defaultReset = self.parents( '.fusion-builder-option' ).find( '.fusion-builder-default-reset' );

						// Picker with default.
						if ( $( this ).data( 'default' ) && $( this ).data( 'default' ).length ) {
							$( this ).wpColorPicker( {
								change: function( event, ui ) {
									that.colorChange( ui.color.toString(), self, $defaultReset );
								},
								clear: function( event, ui ) {
									that.colorClear( event, self );
								}
							} );

							// Make it so the reset link also clears color.
							$defaultReset.on( 'click', 'a', function( e ) {
								e.preventDefault();
								that.colorClear( event, self );
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

				this.$el.find( '#element_content' ).closest( '.fusion-builder-option' ).hide();

				setTimeout( function() {
					$thisEl.find( 'select, input, textarea, radio' ).filter( ':eq(0)' ).focus();
				}, 1 );

				return this;
			},

			removeElement: function() {

				// Remove element settings modal on save or close/cancel
				this.remove();
			},

			colorChange: function( value, self, defaultReset ) {
				var defaultColor = self.data( 'default' );

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

			colorClear: function( event, self ) {
				var defaultColor = self.data( 'default' );

				if ( null !== defaultColor ) {
					self.val( defaultColor );
					self.change();
					self.val( '' );
					self.parent().parent().find( '.wp-color-result' ).css( 'background-color', defaultColor );
				}
			},
			buttonSetClick: function( event ) {
				var $radiosetcontainer;

				event.preventDefault();

				$radiosetcontainer = jQuery( event.target ).parents( '.fusion-form-radio-button-set' );
				$radiosetcontainer.find( '.ui-state-active' ).removeClass( 'ui-state-active' );
				jQuery( event.target ).addClass( 'ui-state-active' );
				$radiosetcontainer.find( '.button-set-value' ).val( $radiosetcontainer.find( '.ui-state-active' ).data( 'value' ) );
			},

			addButton: function( event ) {

				var defaultParams,
				    params,
					elementType,
				    value,
				    elementID;

				if ( event ) {
					event.preventDefault();
				}

				elementType = $( event.currentTarget ).data( 'type' );
				elementID   = $( event.currentTarget ).data( 'id' );

				FusionPageBuilderApp.shortcodeGenerator = true;
				FusionPageBuilderApp.shortcodeGeneratorEditorID = 'button_' + elementID;

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
			}

		} );

	} );

} )( jQuery );
