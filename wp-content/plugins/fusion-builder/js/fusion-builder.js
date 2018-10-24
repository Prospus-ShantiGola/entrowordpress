var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	/**
	 * Fetch a JavaScript template for an id, and return a templating function for it.
	 *
	 * @param  {string} id   A string that corresponds to a DOM element
	 * @return {function}    A function that lazily-compiles the template requested.
	 */
	FusionPageBuilder.template = _.memoize( function( html ) {
		var compiled,
			/*
			 * Underscore's default ERB-style templates are incompatible with PHP
			 * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
			 */
		    options = {
				evaluate:    /<#([\s\S]+?)#>/g,
				interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
				escape:      /\{\{([^\}]+?)\}\}(?!\})/g
		    };

		return function( data ) {
			compiled = compiled || _.template( html, null, options );
			return compiled( data );
		};
	});
}( jQuery ) );
;! function( name, definition ) {

	if ( 'undefined' !== typeof module && module.exports ) {
		module.exports = definition();
	} else if ( 'function' === typeof define ) {
		define( definition );
	} else {
		this[ name ] = definition();
	}

}( 'fusionBuilderStickyHeader', function() {

	return function fusionBuilderStickyHeader( el, top ) {
		var $container = document.getElementById( 'fusion_builder_container' ),
		    requiredTop = top || 0,
		    topBorderSize = 22,
		    originalRect = calcRect( el ),
		    styles = {
				position: 'fixed',
				top: requiredTop + 'px',
				left: originalRect.left + 'px',
				width: originalRect.width + 'px',
				'border-top': topBorderSize + 'px solid #ffffff',
				'z-index': 999
		    },
		    requiredOriginalStyles = ['position', 'top', 'left', 'z-index', 'border-top'],
		    originalStyles = {},
		    onscroll,
		    onresize;

		requiredOriginalStyles.forEach( function( key ) {
			originalStyles[ key ]  = el.style[ key ];
			originalStyles.width = '100%';
		});

		jQuery( '.fusion-builder-history-list' ).css( 'max-height', jQuery( window ).height() - 100 );

		if ( window.onscroll ) {
			onscroll = window.onscroll;
		}

		if ( window.onresize ) {
			onresize = window.onresize;
		}

		window.onscroll = function( event ) {

			var $mainContainer         = document.getElementById( 'fusion_builder_main_container' ),
			    $mainContainerRect     = calcRect( $mainContainer ),
			    $builderControlsHeight = jQuery( '#fusion_builder_controls' ).height(),
			    $mainContainerHeight   = ( 'fixed' === jQuery( '#fusion_builder_controls' ).css( 'position' ) ) ? $mainContainerRect.height + originalRect.height - $builderControlsHeight : $mainContainerRect.height,
			    calContainer,
			    left,
			    key;

			jQuery( '.fusion-builder-history-list' ).css( 'max-height', jQuery( window ).height() - 100 );
			if ( getWindowScroll().top > originalRect.top - requiredTop - topBorderSize && getWindowScroll().top + requiredTop + topBorderSize + originalRect.height < $mainContainerRect.top + $mainContainerHeight ) {
				calContainer = ( $container );
				left         = calContainer.left + 'px';

				styles.left = left;
				styles.width = jQuery( '#fusion_builder_container' ).outerWidth() + 'px';

				for ( key in styles ) {
					el.style[ key ] = styles[ key ];
				}
			} else {
				for ( key in originalStyles ) {
					el.style[ key ] = originalStyles[ key ];
				}
			}

			onscroll && onscroll( event );
		};

		window.onresize = function( event ) {
			var parentWidth = jQuery( '#fusion_builder_container' ).outerWidth() + 'px';

			jQuery( '.fusion-builder-history-list' ).css( 'max-height', jQuery( window ).height() - 100 );

			if ( getWindowScroll().top > originalRect.top - requiredTop ) {
				el.style.width = parentWidth;
			} else {
				el.style.width = originalStyles.width;
			}

			onresize && onresize( event );
		};

		function calcRect( el ) {
			var rect = el.getBoundingClientRect(),
			    windowScroll = getWindowScroll(),
			    headingRect,
			    top;

			// If the whole panel is collapsed, the top position needs checked from the heading
			top = rect.top + windowScroll.top;
			if ( jQuery( el ).parents( '#fusion_builder_layout' ).hasClass( 'closed' ) ) {
				headingRect = jQuery( el ).parents( '#fusion_builder_layout' ).find( '.ui-sortable-handle' )[0].getBoundingClientRect();
				top =  headingRect.top + headingRect.height + windowScroll.top;
			}

			return {
				left: rect.left + windowScroll.left,
				top: top,
				width: rect.width,
				height: rect.height
			};
		}

		function getWindowScroll() {
			return {
				top: window.pageYOffset || document.documentElement.scrollTop,
				left: window.pageXOffset || document.documentElement.scrollLeft
			};
		}
	};
});
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Builder element model
		FusionPageBuilder.Element = Backbone.Model.extend( {

			defaults: {
				type: 'element'
			},

			initialize: function() {
			}

		} );

	} );

})( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		var fusionElements          = [],
		    fusionGeneratorElements = [];

		// Loop over all available elements and add them to Fusion Builder.
		// Ignore elements tagged with 'hide_from_builder' attribute.
		_.each( fusionAllElements, function( element ) {
			var newElement;

			if ( 'undefined' === typeof element.hide_from_builder && 'undefined' === typeof element.generator_only ) {

				newElement = {
					'title': element.name,
					'label': element.shortcode
				};

				fusionElements.push( newElement );
			}
		} );

		_.each( fusionAllElements, function( element ) {
			var newElement;

			if ( 'undefined' === typeof element.hide_from_builder ) {

				newElement = {
					'title': element.name,
					'label': element.shortcode
				};

				fusionGeneratorElements.push( newElement );
			}
		} );

		//Sort elements alphabetically
		fusionElements.sort( function( a, b ) {
			var titleA = a.title.toLowerCase(),
			    titleB = b.title.toLowerCase();

			return ( ( titleA < titleB ) ? -1 : ( ( titleA > titleB ) ? 1 : 0 ) );
		});

		// Sort generator elements alphabetically
		fusionGeneratorElements.sort( function( a, b ) {
			var titleA = a.title.toLowerCase(),
			    titleB = b.title.toLowerCase();

			return ( ( titleA < titleB ) ? -1 : ( ( titleA > titleB ) ? 1 : 0 ) );
		});

		FusionPageBuilder.ViewManager = Backbone.Model.extend( {
			defaults: {
				modules: fusionElements,
				generator_elements: fusionGeneratorElements,
				elementCount: 0,
				views: {}
			},

			initialize: function() {
			},

			getView: function( cid ) {
				return this.get( 'views' )[cid];
			},

			getChildViews: function( parentID ) {
				var views      = this.get( 'views' ),
				    childViews = {};

				_.each( views, function( view, key ) {
					if ( parentID === view.model.attributes.parent ) {
						childViews[ key ] = view;
					}
				} );

				return childViews;
			},

			generateCid: function() {
				var elementCount = this.get( 'elementCount' ) + 1;

				this.set( { 'elementCount': elementCount } );

				return elementCount;
			},

			addView: function( cid, view ) {
				var views = this.get( 'views' );

				views[ cid ] = view;
				this.set( { 'views': views } );
			},

			removeView: function( cid ) {
				var views    = this.get( 'views' ),
				    updatedViews = {};

				_.each( views, function( value, key ) {
					if ( key != cid ) {
						updatedViews[key] = value;
					}
				} );

				this.set( { 'views': updatedViews } );
			},

			removeViews: function( cid ) {
				var updatedViews = {};
				this.set( { 'views': updatedViews } );
			},

			countElementsByType: function( elementType ) {
				var views = this.get( 'views' ),
				    num   = 0;

				_.each( views, function( view ) {
					if ( view.model.attributes.type === elementType ) {
						num++;
					}
				} );

				return num;
			}

		} );

		FusionPageBuilderViewManager = new FusionPageBuilder.ViewManager();

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Element collection
		FusionPageBuilder.Collection = Backbone.Collection.extend( {
			model: FusionPageBuilder.Element
		} );

        FusionPageBuilderElements = new FusionPageBuilder.Collection();

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Builder Element View
		FusionPageBuilder.ElementView = window.wp.Backbone.View.extend( {

			className: 'fusion_module_block fusion_builder_column_element',
			template: FusionPageBuilder.template( $( '#fusion-builder-block-module-template' ).html() ),
			events: {
				'click .fusion-builder-settings': 'showSettings',
				'click .fusion-builder-clone-module': 'cloneElement',
				'click .fusion-builder-remove': 'removeElement',
				'click .fusion-builder-save-module-dialog': 'saveElementDialog'
			},

			initialize: function() {
				this.elementIsCloning = false;
			},

			render: function() {
				this.$el.html( this.template( this.model.attributes ) );
				return this;
			},

			saveElementDialog: function( event ) {
				if ( event ) {
					event.preventDefault();
				}
				FusionPageBuilderApp.showLibrary();

				// Change to elements tab
				$( '#fusion-builder-layouts-elements-trigger' ).click();

				$( '#fusion-builder-layouts-elements .fusion-builder-layouts-header-element-fields' ).append( '<div class="fusion-save-element-fields"><input type="text" value="" id="fusion-builder-save-element-input" class="fusion-builder-save-element-input" placeholder="' + fusionBuilderText.enter_name + '" /><a href="#" class="fusion-builder-save-column fusion-builder-element-button-save" data-element-cid="' + this.model.get( 'cid' ) + '">' + fusionBuilderText.save_element + '</a></div>' );
			},

			saveElement: function( event ) {

				var thisEl           = this.$el,
				    elementContent   = this.getElementContent(),
				    elementName      = $( '#fusion-builder-save-element-input' ).val(),
				    layoutsContainer = $( '#fusion-builder-layouts-elements .fusion-page-layouts' ),
				    emptyMessage     = $( '#fusion-builder-layouts-elements .fusion-page-layouts .fusion-empty-library-message' );

				if ( event ) {
					event.preventDefault();
				}

				if ( '' !== elementName ) {

					$.ajax( {
						type: 'POST',
						url: FusionPageBuilderApp.ajaxurl,
						dataType: 'json',
						data: {
							action: 'fusion_builder_save_layout',
							fusion_load_nonce: FusionPageBuilderApp.fusion_load_nonce,
							fusion_layout_name: elementName,
							fusion_layout_content: elementContent,
							fusion_layout_post_type: 'fusion_element',
							fusion_layout_new_cat: 'elements'
						},
						complete: function( data ) {
							layoutsContainer.prepend( data.responseText );
							$( '.fusion-save-element-fields' ).remove();
							emptyMessage.hide();
						}
					});

				} else {
					alert( fusionBuilderText.please_enter_element_name );
				}
			},

			getElementContent: function() {
				return FusionPageBuilderApp.generateElementShortcode( this.$el, false );
			},

			removeElement: function( event ) {
				if ( event ) {
					event.preventDefault();
				}

				// Remove element view
				FusionPageBuilderViewManager.removeView( this.model.get( 'cid' ) );

				// Destroy element model
				this.model.destroy();

				this.remove();

				// If element is removed manually
				if ( event ) {

					// Save history state
					fusionHistoryManager.turnOnTracking();
					fusionHistoryState = fusionBuilderText.deleted + ' ' + fusionAllElements[ this.model.get( 'element_type' ) ].name + ' ' + fusionBuilderText.element;

					FusionPageBuilderEvents.trigger( 'fusion-element-removed' );
				}

			},

			cloneElement: function( event, parentCID ) {
				var elementAttributes;

				if ( event ) {
					event.preventDefault();
				}

				if ( true === this.elementIsCloning ) {
					return;
				} else {
					this.elementIsCloning = true;
				}

				elementAttributes = _.clone( this.model.attributes );
				elementAttributes.created = 'manually';
				elementAttributes.cid = FusionPageBuilderViewManager.generateCid();
				elementAttributes.targetElement = this.$el;
				if ( 'undefined' !== elementAttributes.from ) {
					delete elementAttributes.from;
				}

				if ( parentCID ) {
					elementAttributes.parent = parentCID;
				}

				FusionPageBuilderApp.collection.add( elementAttributes );

				if ( ! parentCID ) {

					// Save history state
					fusionHistoryManager.turnOnTracking();
					fusionHistoryState = fusionBuilderText.cloned + ' ' + fusionAllElements[ this.model.get( 'element_type' ) ].name + ' ' + fusionBuilderText.element;
				}

				this.elementIsCloning = false;

				if ( event ) {
					FusionPageBuilderEvents.trigger( 'fusion-element-cloned' );
				}

			},

			showSettings: function( event ) {
				var modalView,
				    viewSettings = {
						model: this.model,
						collection: this.collection,
						attributes: {
							'data-modal_view': 'element_settings'
						}
				    };

				if ( event ) {
					event.preventDefault();
				}

				modalView = new FusionPageBuilder.ModalView( viewSettings );

				$( 'body' ).append( modalView.render().el );
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Builder Element Preview View
		FusionPageBuilder.ElementPreviewView = window.wp.Backbone.View.extend( {

			className: 'fusion_module_block_preview ',

			initialize: function() {
				this.template = FusionPageBuilder.template( $( '#' + fusionAllElements[this.model.attributes.element_type].preview_id ).html() );
			},

			render: function() {
				this.$el.html( this.template( this.model.attributes ) );

				return this;
			}

		});

	});

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Builder Elements View
		FusionPageBuilder.ElementLibraryView = window.wp.Backbone.View.extend( {

			className: 'fusion_builder_modal_settings',

			template: FusionPageBuilder.template( $( '#fusion-builder-modules-template' ).html() ),

			events: {
				'click .fusion-builder-all-modules .fusion-builder-element': 'addModule',
				'click .fusion_builder_custom_elements_load': 'addCustomModule',
				'click .fusion-builder-column-layouts li': 'addNestedColumns'
			},

			initialize: function( attributes ) {
				this.options = attributes;
				this.listenTo( FusionPageBuilderEvents, 'fusion-modal-view-removed', this.remove );
			},

			render: function() {
				this.$el.html( this.template( FusionPageBuilderViewManager.toJSON() ) );

				// Load saved elements
				FusionPageBuilderApp.showSavedElements( 'elements', this.$el.find( '#custom-elements' ) );

				// If adding element to nested column
				if ( 'true' === FusionPageBuilderApp.innerColumn ) {
					this.$el.addClass( 'fusion-add-to-nested' );
				}

				return this;
			},

			addCustomModule: function( event ) {
				var layoutID,
				    title;

				if ( event ) {
					event.preventDefault();
				}

				if ( true === FusionPageBuilderApp.layoutIsLoading ) {
					return;
				} else {
					FusionPageBuilderApp.layoutIsLoading = true;
				}

				layoutID = $( event.currentTarget ).closest( 'li' ).data( 'layout_id' );
				title    = $( event.currentTarget ).find( '.fusion_module_title' ).text();

				$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).css( 'opacity', '0' );
				$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).prev( '#fusion-loader' ).show();

				$.ajax( {
					type: 'POST',
					url: FusionPageBuilderApp.ajaxurl,
					data: {
						action: 'fusion_builder_load_layout',
						fusion_load_nonce: FusionPageBuilderApp.fusion_load_nonce,
						fusion_layout_id: layoutID
					},

					success: function( data ) {
						var dataObj = JSON.parse( data );

						FusionPageBuilderApp.shortcodesToBuilder( dataObj.post_content, FusionPageBuilderApp.parentColumnId );
						FusionPageBuilderApp.layoutIsLoading = false;

						$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).css( 'opacity', '1' );
						$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).prev( '#fusion-loader' ).hide();
					},

					complete: function() {

						// Save history state
						fusionHistoryManager.turnOnTracking();
						fusionHistoryState = fusionBuilderText.added_custom_element + title;

						FusionPageBuilderEvents.trigger( 'fusion-element-added' );
					}
				} );
			},

			addModule: function( event ) {
				var $thisEl,
				    label,
				    params,
				    multi,
				    type,
				    name,
				    allowGenerator;

				if ( event ) {
					event.preventDefault();
				}

				$thisEl = $( event.currentTarget );
				label   = $thisEl.find( '.fusion_module_label' ).text();

				if ( label in fusionAllElements ) {

					params = fusionAllElements[ label ].params;
					multi   = fusionAllElements[ label ].multi;
					type   = fusionAllElements[ label ].shortcode;
					name   = fusionAllElements[ label ].name;
					allowGenerator = fusionAllElements[ label ].allow_generator;

				} else {
					params = '';
					multi   = '';
					type   = '';
					allowGenerator = '';
				}

				if ( event ) {
					fusionHistoryState = fusionBuilderText.added + ' ' + name + ' ' + fusionBuilderText.element;
				}

				this.collection.add( [ {
					type: 'element',
					added: 'manually',
					cid: FusionPageBuilderViewManager.generateCid(),
					element_type: type,
					params: params,
					parent: this.attributes['data-parent_cid'],
					view: this.options.view,
					allow_generator: allowGenerator,
					multi: multi
				} ] );

				this.remove();

				FusionPageBuilderEvents.trigger( 'fusion-element-added' );

			},

			addNestedColumns: function( event, appendAfter ) {
				var moduleID,
				    that,
				    $layoutEl,
				    layout,
				    layoutElementsNum,
				    thisView,
				    defaultParams,
				    params,
				    value;

				if ( event ) {
					event.preventDefault();
				}

				moduleID = FusionPageBuilderViewManager.generateCid();

				this.collection.add( [ {
					type: 'fusion_builder_row_inner',
					element_type: 'fusion_builder_row_inner',
					cid: moduleID,
					parent: this.model.get( 'cid' ),
					view: this,
					appendAfter: appendAfter
				} ] );

				FusionPageBuilderApp.activeModal = 'column';

				that              = this;
				$layoutEl         = $( event.target ).is( 'li' ) ? $( event.target ) : $( event.target ).closest( 'li' );
				layout            = $layoutEl.data( 'layout' ).split( ',' );
				layoutElementsNum = _.size( layout );
				thisView          = this.options.view;

				// Get default options
				defaultParams = fusionAllElements.fusion_builder_column_inner.params;
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

				_.each( layout, function( element, index ) {
					var updateContent    = layoutElementsNum == ( index + 1 ) ? 'true' : 'false',
					    columnAttributes = {
							type: 'fusion_builder_column_inner',
							element_type: 'fusion_builder_column_inner',
							cid: FusionPageBuilderViewManager.generateCid(),
							parent: moduleID,
							layout: element,
							view: thisView,
							params: params
					    };

					that.collection.add( [ columnAttributes ] );

				} );

				this.remove();

				FusionPageBuilderEvents.trigger( 'fusion-columns-added' );

				if ( event ) {

					// Save history state
					fusionHistoryManager.turnOnTracking();
					fusionHistoryState = fusionBuilderText.added_nested_columns;

					FusionPageBuilderEvents.trigger( 'fusion-element-cloned' );
				}
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Generator elements library
		FusionPageBuilder.GeneratorElementsView = window.wp.Backbone.View.extend( {

			className: 'fusion_builder_modal_settings',

			template: FusionPageBuilder.template( $( '#fusion-builder-generator-modules-template' ).html() ),

			events: {
				'click .fusion-builder-all-modules .fusion-builder-element': 'addElement',
				'click .fusion-builder-column-layouts .generator-column': 'addColumns',
				'click .fusion-builder-column-layouts .generator-section': 'addContainer'
			},

			initialize: function( attributes ) {
				this.options = attributes;
				this.listenTo( FusionPageBuilderEvents, 'fusion-modal-view-removed', this.remove );
			},

			render: function() {
				this.$el.html( this.template( FusionPageBuilderViewManager.toJSON() ) );
				return this;
			},

			addElement: function( event ) {
				var $thisEl,
				    title,
				    label,
				    params,
				    multi,
				    type,
				    selection,
				    defaultParams,
				    elementSettings;

				if ( event ) {
					event.preventDefault();
				}

				$thisEl = $( event.currentTarget );
				title   = $thisEl.find( '.fusion_module_title' ).text();
				label   = $thisEl.find( '.fusion_module_label' ).text();

				if ( label in fusionAllElements ) {

					multi   = fusionAllElements[ label ].multi;
					type   = fusionAllElements[ label ].shortcode;

				} else {

					params = '';
					multi   = '';
					type   = '';
				}

				// Get default settings
				defaultParams = $.extend( true, {}, fusionAllElements[ label ].params );
				params = {};

				// Process default parameters from shortcode
				_.each( defaultParams, function( param )  {
					var value;
					if ( _.isObject( param.value ) ) {
						value = param.default;
					} else {
						value = param.value;
					}
					params[param.param_name] = value;
				} );

				elementSettings = {
					type: 'generated_element',
					added: 'manually',
					element_type: type,
					params: params,
					view: this.options.view,
					multi: multi,
					cid: FusionPageBuilderViewManager.generateCid()
				};
				if ( 'undefined' !== params.element_content && 'undefined' !== typeof tinyMCE && 'undefined' !== tinyMCE.activeEditor && 'undefined' === typeof multi && window.tinyMCE.activeEditor ) {

					selection = window.tinyMCE.activeEditor.selection.getContent();

					if ( selection ) {

						elementSettings.params.element_content = selection;

						window.tinyMCE.activeEditor.selection.setContent( '' );
						selection = '';

						delete elementSettings.added;
					}
				}

				this.collection.add( elementSettings );

				this.remove();
			},

			addColumns: function( event ) {
				var that,
				    $layoutEl,
				    layout,
				    layoutElementsNum,
				    thisView,
				    defaultParams,
				    params,
				    value,
				    columnModel,
				    generatedShortcode = '[fusion_builder_row_inner]',
				    elementType        = 'fusion_builder_column_inner',
				    closingTag         = '[/fusion_builder_row_inner]';

				if ( ! FusionPageBuilderApp.builderActive && jQuery( event.target ).parents( '#builder-regular-columns' ).length ) {
					generatedShortcode = '';
					elementType = 'fusion_builder_column';
					closingTag = '';
				}
				if ( event ) {
					event.preventDefault();
				}

				FusionPageBuilderApp.activeModal = 'column';

				that              = this;
				$layoutEl         = $( event.target ).is( 'li' ) ? $( event.target ) : $( event.target ).closest( 'li' );
				layout            = $layoutEl.data( 'layout' ).split( ',' );
				layoutElementsNum = _.size( layout );
				thisView          = this.options.view;

				// Get default settings
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

				_.each( layout, function( element, index ) {

					var updateContent,
					    columnAttributes;

					params.type = element;

					updateContent    = layoutElementsNum == ( index + 1 ) ? 'true' : 'false';
					columnAttributes = {
						type: 'generated_element',
						added: 'manually',
						element_type: elementType,
						layout: element,
						view: thisView,
						params: params
					};

					columnModel = that.collection.add( columnAttributes );

					generatedShortcode += FusionPageBuilderApp.generateElementShortcode( columnModel, false, true );

				} );

				generatedShortcode += closingTag;

				fusionBuilderInsertIntoEditor( generatedShortcode, FusionPageBuilderApp.shortcodeGeneratorEditorID );

				// Reset shortcode generator
				FusionPageBuilderApp.shortcodeGenerator = '';
				FusionPageBuilderApp.shortcodeGeneratorEditorID = '';

				this.remove();
			},

			addContainer: function( event ) {
				var elementID,
				    defaultParams,
				    params,
				    value;

				if ( event ) {
					event.preventDefault();
				}

				FusionPageBuilderApp.activeModal = 'container';

				elementID = FusionPageBuilderViewManager.generateCid();
				defaultParams = fusionAllElements.fusion_builder_container.params;
				params = {};

				// Process default parameters from shortcode
				_.each( defaultParams, function( param ) {
					if ( _.isObject( param.value ) ) {
						value = param.default;
					} else {
						value = param.value;
					}
					params[ param.param_name ] = value;
				} );

				this.collection.add( [ {
					type: 'generated_element',
					added: 'manually',
					element_type: 'fusion_builder_container',
					params: params,
					view: this
				} ] );
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Builder Container View
		FusionPageBuilder.ContainerView = window.wp.Backbone.View.extend( {

			className: 'fusion_builder_container',
			template: FusionPageBuilder.template( $( '#fusion-builder-container-template' ).html() ),
			events: {
				'click .fusion-builder-clone-container': 'cloneContainer',
				'click .fusion-builder-remove': 'removeContainer',
				'click .fusion-builder-section-add': 'addContainer',
				'click .fusion-builder-toggle': 'toggleContainer',
				'click .fusion-builder-settings-container': 'showSettings',
				'paste .fusion-builder-section-name': 'renameContainer',
				'keydown .fusion-builder-section-name': 'renameContainer',
				'click .fusion-builder-save-element': 'saveElementDialog'
			},

			initialize: function() {
				this.typingTimer;
				this.doneTypingInterval = 800;
			},

			render: function() {
				this.$el.html( this.template( this.model.toJSON() ) );

				return this;
			},

			saveElement: function( event ) {
				var thisEl           = this.$el,
				    elementContent   = this.getContainerContent(),
				    elementName      = $( '#fusion-builder-save-element-input' ).val(),
				    layoutsContainer = $( '#fusion-builder-layouts-sections .fusion-page-layouts' ),
				    emptyMessage     = $( '#fusion-builder-layouts-sections .fusion-empty-library-message' );

				if ( event ) {
					event.preventDefault();
				}

				if ( '' !== elementName ) {
					$.ajax( {
						type: 'POST',
						url: FusionPageBuilderApp.ajaxurl,
						dataType: 'json',
						data: {
							action: 'fusion_builder_save_layout',
							fusion_load_nonce: FusionPageBuilderApp.fusion_load_nonce,
							fusion_layout_name: elementName,
							fusion_layout_content: elementContent,
							fusion_layout_post_type: 'fusion_element',
							fusion_layout_new_cat: 'sections'
						},
						complete: function( data ) {
							layoutsContainer.prepend( data.responseText );
							$( '.fusion-save-element-fields' ).remove();
							emptyMessage.hide();
						}
					} );

				} else {
					alert( fusionBuilderText.please_enter_element_name );
				}
			},

			getContainerContent: function( model, collection, options ) {
				var shortcode      = '',
				    $thisContainer = this.$el.find( '.fusion-builder-section-content' );

				shortcode += FusionPageBuilderApp.generateElementShortcode( this.$el, true );

				$thisContainer.find( '.fusion_builder_row' ).each( function() {
					var $thisRow = $( this );

					shortcode += '[fusion_builder_row]';

					$thisRow.find( '.fusion-builder-column-outer' ).each( function() {
						var $thisColumn = $( this ),
						    $columnCID  = $thisColumn.data( 'cid' ),
						    $columnView = FusionPageBuilderViewManager.getView( $columnCID );

						// Get column contents shortcode
						shortcode += $columnView.getColumnContent( $thisColumn );

					} );

					shortcode += '[/fusion_builder_row]';

				} );

				shortcode += '[/fusion_builder_container]';

				return shortcode;
			},

			saveElementDialog: function( event ) {
				var containerName;

				containerName = 'undefined' !== typeof this.model.get( 'admin_label' ) && '' !== this.model.get( 'admin_label' ) ? this.model.get( 'admin_label' ) : '';

				if ( event ) {
					event.preventDefault();
				}
				FusionPageBuilderApp.showLibrary();

				$( '#fusion-builder-layouts-sections-trigger' ).click();

				$( '#fusion-builder-layouts-sections .fusion-builder-layouts-header-element-fields' ).append( '<div class="fusion-save-element-fields"><input type="text" value="' + containerName + '" id="fusion-builder-save-element-input" class="fusion-builder-save-element-input" placeholder="' + fusionBuilderText.enter_name + '" /><a href="#" class="fusion-builder-save-column fusion-builder-element-button-save" data-element-cid="' + this.model.get( 'cid' ) + '">' + fusionBuilderText.save_section + '</a></div>' );
			},

			showSettings: function( event ) {

				var $modalView,
				    $viewSettings = {
						model: this.model,
						collection: this.collection,
						attributes: {
							'data-modal_view': 'element_settings'
						}
				    };

				if ( event ) {
					event.preventDefault();
				}

				// Get settings view
				$modalView = new FusionPageBuilder.ModalView( $viewSettings );

				// Render settings view
				$( 'body' ).append( $modalView.render().el );
			},

			addContainer: function( event ) {

				var elementID,
				    defaultParams,
				    params,
				    value;

				if ( event ) {
					event.preventDefault();
					FusionPageBuilderApp.newContainerAdded = true;
				}

				FusionPageBuilderApp.activeModal = 'container';

				elementID      = FusionPageBuilderViewManager.generateCid();
				defaultParams = fusionAllElements.fusion_builder_container.params;
				params        = {};

				// Process default options for shortcode.
				_.each( defaultParams, function( param )  {
					if ( _.isObject( param.value ) ) {
						value = param.default;
					} else {
						value = param.value;
					}
					params[param.param_name] = value;

					if ( 'dimension' === param.type && _.isObject( param.value ) ) {
						_.each( param.value, function( value, name )  {
							params[name] = value;
						});
					}
				});

				this.collection.add( [ {
					type: 'fusion_builder_container',
					added: 'manually',
					element_type: 'fusion_builder_container',
					cid: elementID,
					params: params,
					view: this,
					created: 'auto'
				} ] );

				FusionPageBuilderApp.activeModal = '';
			},

			addRow: function() {
				var elementID = FusionPageBuilderViewManager.generateCid();

				this.collection.add( [ {
					type: 'fusion_builder_row',
					element_type: 'fusion_builder_row',
					added: 'manually',
					cid: elementID,
					parent: this.model.get( 'cid' ),
					view: this
				} ] );
			},

			cloneContainer: function( event ) {

				var containerAttributes,
				    $thisContainer;

				if ( event ) {
					event.preventDefault();
				}

				containerAttributes = _.clone( this.model.attributes );

				containerAttributes.cid = FusionPageBuilderViewManager.generateCid();
				containerAttributes.created = 'manually';
				containerAttributes.view = this;
				FusionPageBuilderApp.collection.add( containerAttributes );

				$thisContainer = this.$el;

				// Parse rows
				$thisContainer.find( '.fusion-builder-row-content:not(.fusion_builder_row_inner .fusion-builder-row-content)' ).each( function() {

					var thisRow = $( this ),
					    rowCID  = thisRow.data( 'cid' ),

					    // Get model from collection by cid.
					    row = FusionPageBuilderElements.find( function( model ) {
							return model.get( 'cid' ) == rowCID;
					    } ),

					    // Clone row.
					    rowAttributes = _.clone( row.attributes );

					rowAttributes.created = 'manually';
					rowAttributes.cid = FusionPageBuilderViewManager.generateCid();
					rowAttributes.parent = containerAttributes.cid;
					FusionPageBuilderApp.collection.add( rowAttributes );

					// Parse columns
					thisRow.find( '.fusion-builder-column-outer' ).each( function() {

						// Parse column elements
						var thisColumn = $( this ),
						    $columnCID = thisColumn.data( 'cid' ),

						    // Get model from collection by cid
						    column = FusionPageBuilderElements.find( function( model ) {
								return model.get( 'cid' ) == $columnCID;
						    } ),

						    // Clone column
						    columnAttributes = _.clone( column.attributes );

						columnAttributes.created = 'manually';
						columnAttributes.cid     = FusionPageBuilderViewManager.generateCid();
						columnAttributes.parent  = rowAttributes.cid;
						columnAttributes.from    = 'fusion_builder_container';

						FusionPageBuilderApp.collection.add( columnAttributes );

						// Find column elements
						thisColumn.children( '.fusion_module_block, .fusion_builder_row_inner' ).each( function() {

							var thisElement,
							    elementCID,
							    element,
							    elementAttributes,
							    thisInnerRow,
							    InnerRowCID,
							    innerRowView;

							// Regular element
							if ( $( this ).hasClass( 'fusion_module_block' ) ) {

								thisElement = $( this );
								elementCID = thisElement.data( 'cid' );

								// Get model from collection by cid
								element = FusionPageBuilderElements.find( function( model ) {
									return model.get( 'cid' ) == elementCID;
								} );

								// Clone model attritubes
								elementAttributes = _.clone( element.attributes );
								elementAttributes.created = 'manually';
								elementAttributes.cid = FusionPageBuilderViewManager.generateCid();
								elementAttributes.parent = columnAttributes.cid;
								elementAttributes.from    = 'fusion_builder_container';

								FusionPageBuilderApp.collection.add( elementAttributes );

							// Inner row element
							} else if ( $( this ).hasClass( 'fusion_builder_row_inner' ) ) {

								thisInnerRow = $( this );
								InnerRowCID = thisInnerRow.data( 'cid' );

								innerRowView = FusionPageBuilderViewManager.getView( InnerRowCID );

								// Clone inner row
								if ( 'undefined' !== typeof innerRowView ) {
									innerRowView.cloneNestedRow( '', columnAttributes.cid );
								}
							}

						} );

					} );

				} );

				// Save history state
				fusionHistoryManager.turnOnTracking();
				fusionHistoryState = fusionBuilderText.cloned_section;

				FusionPageBuilderEvents.trigger( 'fusion-element-cloned' );
			},

			removeContainer: function( event ) {

				var rows;

				if ( event ) {
					event.preventDefault();
				}

				rows = FusionPageBuilderViewManager.getChildViews( this.model.get( 'cid' ) );

				_.each( rows, function( row ) {
					if ( 'fusion_builder_row' === row.model.get( 'type' ) ) {
						row.removeRow();
					}
				} );

				if ( FusionPageBuilderViewManager.countElementsByType( 'fusion_builder_container' ) > 1 ) {

				// If the only container is deleted show blank page layout
				} else {
					FusionPageBuilderApp.blankPage = true;
				}

				FusionPageBuilderViewManager.removeView( this.model.get( 'cid' ) );

				this.model.destroy();

				this.remove();

				if ( true === FusionPageBuilderApp.blankPage ) {
					FusionPageBuilderApp.clearBuilderLayout( true );

					return;
				}

				if ( event ) {

					// Save history state
					fusionHistoryManager.turnOnTracking();
					fusionHistoryState = fusionBuilderText.deleted_section;

					FusionPageBuilderEvents.trigger( 'fusion-element-removed' );
				}
			},

			toggleContainer: function( event ) {

				var thisEl = $( event.currentTarget );

				if ( event ) {
					event.preventDefault();
				}

				this.$el.toggleClass( 'fusion-builder-section-folded' );
				this.$el.find( '.fusion-builder-section-content' ).slideToggle( 'fast' );
				thisEl.find( 'span' ).toggleClass( 'dashicons-arrow-up' ).toggleClass( 'dashicons-arrow-down' );
				this.$el.find( '.fusion-builder-settings-container, .fusion-builder-clone-container, .fusion-builder-remove, .fusion-builder-save-element' ).toggle();
			},

			renameContainer: function( event ) {

				// Detect "enter" key
				var code,
				    model,
				    input;

				code = event.keyCode || event.which;

				if ( 13 == code ) {
					event.preventDefault();
					this.$el.find( '.fusion-builder-section-name' ).blur();

					return false;
				}

				model = this.model;
				input = this.$el.find( '.fusion-builder-section-name' );
				clearTimeout( this.typingTimer );

				this.typingTimer = setTimeout( function() {

					model.attributes.params.admin_label = input.val();
					FusionPageBuilderEvents.trigger( 'fusion-element-edited' );

				}, this.doneTypingInterval );
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Builder Blank Page View
		FusionPageBuilder.BlankPageView = window.wp.Backbone.View.extend( {

			className: 'fusion_builder_blank_page',

			template: FusionPageBuilder.template( $( '#fusion-builder-blank-page-template' ).html() ),

			events: {
				'click .fusion-builder-new-section-add': 'addContainer',
				'click .fusion-builder-video-button': 'openVideoModal'
			},

			initialize: function() {
			},

			render: function() {
				this.$el.html( this.template( this.model.toJSON() ) );

				this.$el.find( '#video-dialog' ).dialog({
					dialogClass: 'fusion-builder-dialog',
					autoOpen: false,
					modal: true,
					height: 410,
					width: 590
				} );

				return this;
			},

			openVideoModal: function( event ) {
				event.preventDefault();

				jQuery( '#video-dialog' ).dialog( 'open' );
			},

			addContainer: function( event ) {

				var moduleID,
				    defaultParams,
				    params,
				    value;

				if ( event ) {
					event.preventDefault();

					FusionPageBuilderApp.newContainerAdded = true;
				}

				FusionPageBuilderApp.activeModal = 'container';

				moduleID = FusionPageBuilderViewManager.generateCid(),
				defaultParams = fusionAllElements.fusion_builder_container.params,
				params = {};

				// Process default options for shortcode.
				_.each( defaultParams, function( param )  {
					if ( _.isObject( param.value ) ) {
						value = param.default;
					} else {
						value = param.value;
					}
					params[param.param_name] = value;

					if ( 'dimension' === param.type && _.isObject( param.value ) ) {
						_.each( param.value, function( value, name )  {
							params[name] = value;
						});
					}
				});

				this.collection.add( [ {
					type: 'fusion_builder_container',
					added: 'manually',
					element_type: 'fusion_builder_container',
					cid: moduleID,
					params: params,
					view: this,
					created: 'auto'
				} ] );

				this.remove();
			},

			removeBlankPageHelper: function( event ) {
				if ( event ) {
					event.preventDefault();
				}

				FusionPageBuilderViewManager.removeView( this.model.get( 'cid' ) );

				this.model.destroy();

				this.remove();
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Builder Row View
		FusionPageBuilder.RowView = window.wp.Backbone.View.extend( {

			className: 'fusion_builder_row',

			template: FusionPageBuilder.template( $( '#fusion-builder-row-template' ).html() ),

			events: {
				'click .fusion-builder-insert-column': 'displayColumnsOptions'
			},

			initialize: function() {
			},

			render: function() {

				this.$el.html( this.template( this.model.toJSON() ) );

				this.sortableColumns();

				// Show column settings when adding a new row
				if ( 'manually' !== this.model.get( 'created' ) ) {
					this.$el.find( '.fusion-builder-insert-column' ).trigger( 'click' );
				}

				return this;
			},

			sortableColumns: function() {
				var thisEl     = this,
				    selectedEl = thisEl.$el.find( '.fusion-builder-row-container' ),
				    cid        = this.model.get( 'cid' );

				selectedEl.sortable( {
					helper: 'clone',
					cancel: '.fusion-builder-settings, .fusion-builder-clone, .fusion-builder-remove, .fusion-builder-section-add, .fusion-builder-add-element, .fusion-builder-insert-column, #fusion_builder_controls, .fusion-builder-save-column, .fusion-builder-resize-column, .column-sizes, .fusion-builder-save-column-dialog, .fusion-builder-save-inner-row-dialog-button, .fusion-builder-remove-inner-row, .fusion_builder_row_inner .fusion-builder-row-content',
					items: '.fusion-builder-column-outer',
					connectWith: '.fusion-builder-row-container',
					tolerance: 'pointer',

					update: function( event, ui ) {
						var elementCID = ui.item.data( 'cid' ),
						    model     = thisEl.collection.find( function( model ) {
								return model.get( 'cid' ) == elementCID;
						    } );

						// Moved column within the same section/row
						if ( model.get( 'parent' ) === thisEl.model.attributes.cid && $( ui.item ).closest( event.target ).length ) {

						// Moved column to a different section/row
						} else {
							model.set( 'parent', thisEl.model.attributes.cid );
						}

						// Save history state
						fusionHistoryManager.turnOnTracking();
						fusionHistoryState = fusionBuilderText.moved_column;

						FusionPageBuilderEvents.trigger( 'fusion-element-sorted' );
					}

				} ).disableSelection();
			},

			displayColumnsOptions: function( event ) {

				var view;

				if ( event ) {
					event.preventDefault();
				}

				FusionPageBuilderApp.parentRowId = this.model.get( 'cid' );

				view = new FusionPageBuilder.ModalView( {
					model: this.model,
					collection: this.collection,
					attributes: {
						'data-modal_view': 'column_library'
					},
					view: this
				} );

				$( 'body' ).append( view.render().el );

			},

			removeRow: function( event, force ) {

				var columns;

				if ( event ) {
					event.preventDefault();
				}

				columns = FusionPageBuilderViewManager.getChildViews( this.model.get( 'cid' ) );

				// Remove all columns
				_.each( columns, function( column ) {
					column.removeColumn();
				} );

				FusionPageBuilderViewManager.removeView( this.model.get( 'cid' ) );

				this.model.destroy();

				this.remove();

				if ( event ) {
					FusionPageBuilderEvents.trigger( 'fusion-element-removed' );
				}
			}

		} );

	} );

} )( jQuery );
;	var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Builder Inner Row View
		FusionPageBuilder.InnerRowView = window.wp.Backbone.View.extend( {

			className: 'fusion_builder_row_inner fusion_builder_column_element',

			template: FusionPageBuilder.template( $( '#fusion-builder-row-inner-template' ).html() ),

			events: {
				'click .fusion-builder-remove-inner-row': 'removeRow',
				'click .fusion-builder-save-inner-row-dialog-button': 'saveElementDialog',
				'click .fusion-builder-clone-inner-row': 'cloneNestedRow',
				'click .fusion-builder-inner-row-overlay': 'showInnerRowDialog',
				'click .fusion-builder-inner-row-close': 'hideInnerRowDialog',
				'click .fusion-builder-inner-row-close-icon': 'hideInnerRowDialog'
			},

			initialize: function() {
				this.$el.attr( 'data-cid', this.model.get( 'cid' ) );

				// Close modal view
				this.listenTo( FusionPageBuilderEvents, 'fusion-close-inner-modal', this.hideInnerRowDialog );
			},

			showInnerRowDialog: function( event ) {

				var thisEl = this.$el;

				if ( event ) {
					event.preventDefault();
				}

				thisEl.find( '.fusion-builder-row-content' ).show();

				$( 'body' ).addClass( 'fusion_builder_inner_row_no_scroll' ).append( '<div class="fusion_builder_modal_inner_row_overlay"></div>' );
			},

			hideInnerRowDialog: function( event ) {

				var thisEl             = this.$el,
				    innerColumnsString = '';

				if ( event ) {
					event.preventDefault();
				}

				thisEl.find( '.fusion-builder-row-content' ).hide();

				$( 'body' ).removeClass( 'fusion_builder_inner_row_no_scroll' );
				$( '.fusion_builder_modal_inner_row_overlay' ).remove();

				this.$el.find( '.fusion-builder-column-inner' ).each( function() {
					innerColumnsString += jQuery( this ).data( 'column-size' ).replace( '_', '/' ) + ' + ';
				});

				this.$el.find( '> p' ).html( innerColumnsString.slice( 0, innerColumnsString.length - 3 ) );
			},

			render: function() {
				var innerColumnsWrapper = this.$el,
				    innerColumnsString  = '';

				this.$el.html( this.template( this.model.toJSON() ) );

				this.sortableColumns();

				setTimeout( function() {
					innerColumnsWrapper.find( '.fusion-builder-column-inner' ).each( function() {
						innerColumnsString += jQuery( this ).data( 'column-size' ).replace( '_', '/' ) + ' + ';
					});

					innerColumnsWrapper.find( '> h4' ).after( '<p>' + innerColumnsString.slice( 0, innerColumnsString.length - 3 ) + '</p>' );
				}, 100 );

				return this;
			},

			cloneNestedRow: function( event, parentCID ) {
				var innerRowAttributes,
				    thisInnerRow;

				if ( event ) {
					event.preventDefault();
				}

				innerRowAttributes		       = _.clone( this.model.attributes );
				innerRowAttributes.created     = 'manually';
				innerRowAttributes.cid	       = FusionPageBuilderViewManager.generateCid();

				if ( event ) {
					innerRowAttributes.appendAfter = this.$el;
				}

				if ( parentCID ) {
					innerRowAttributes.parent = parentCID;
				}

				FusionPageBuilderApp.collection.add( innerRowAttributes );

				// Parse inner columns
				thisInnerRow = this.$el;
				thisInnerRow.find( '.fusion-builder-column-inner' ).each( function() {
					var $thisColumnInner  = $( this ),
					    columnInnerCID	  = $thisColumnInner.data( 'cid' ),
					    innerColumnModule = FusionPageBuilderElements.findWhere( { cid: columnInnerCID } ),

					    // Clone model attritubes
					    innerColAttributes = _.clone( innerColumnModule.attributes );

					innerColAttributes.created = 'manually';
					innerColAttributes.cid	   = FusionPageBuilderViewManager.generateCid();
					innerColAttributes.parent  = innerRowAttributes.cid;

					FusionPageBuilderApp.collection.add( innerColAttributes );

					// Parse elements inside inner col
					$thisColumnInner.find( '.fusion_module_block' ).each( function() {
						var thisModule = $( this ),
						    moduleCID  = 'undefined' === typeof thisModule.data( 'cid' ) ? thisModule.find( '.fusion-builder-data-cid' ).data( 'cid' ) : thisModule.data( 'cid' ),

						    // Get model from collection by cid
						    module = FusionPageBuilderElements.find( function( model ) {
								return model.get( 'cid' ) == moduleCID;
						    } ),

						    // Clone model attritubes
						    innerElementAttributes = _.clone( module.attributes );

						innerElementAttributes.created = 'manually';
						innerElementAttributes.cid     = FusionPageBuilderViewManager.generateCid();
						innerElementAttributes.parent  = innerColAttributes.cid;
						innerElementAttributes.from    = 'fusion_builder_row_inner';

						FusionPageBuilderApp.collection.add( innerElementAttributes );
					} );

				} );

				if ( ! parentCID ) {

					// Save history state
					fusionHistoryManager.turnOnTracking();
					fusionHistoryState = fusionBuilderText.cloned_nested_columns;

					FusionPageBuilderEvents.trigger( 'fusion-element-cloned' );
				}

			},

			saveElementDialog: function( event ) {
				if ( event ) {
					event.preventDefault();
				}
				FusionPageBuilderApp.showLibrary();

				$( '#fusion-builder-layouts-elements-trigger' ).click();

				$( '#fusion-builder-layouts-elements .fusion-builder-layouts-header-element-fields' ).append( '<div class="fusion-save-element-fields"><input type="text" value="" id="fusion-builder-save-element-input" class="fusion-builder-save-element-input" placeholder="' + fusionBuilderText.enter_name + '" /><a href="#" class="fusion-builder-save-column fusion-builder-element-button-save" data-element-cid="' + this.model.get( 'cid' ) + '">' + fusionBuilderText.save_element + '</a></div>' );

			},

			saveElement: function( event ) {

				var thisEl           = this.$el,
				    elementContent   = this.getInnerRowContent(),
				    elementName      = $( '#fusion-builder-save-element-input' ).val(),
				    layoutsContainer = $( '#fusion-builder-layouts-elements .fusion-page-layouts' ),
				    emptyMessage     = $( '#fusion-builder-layouts-elements .fusion-page-layouts .fusion-empty-library-message' );

				if ( event ) {
					event.preventDefault();
				}

				if ( '' !== elementName ) {
					$.ajax( {
						type: 'POST',
						url: FusionPageBuilderApp.ajaxurl,
						dataType: 'json',
						data: {
							action: 'fusion_builder_save_layout',
							fusion_load_nonce: FusionPageBuilderApp.fusion_load_nonce,
							fusion_layout_name: elementName,
							fusion_layout_content: elementContent,
							fusion_layout_post_type: 'fusion_element',
							fusion_layout_new_cat: 'elements',
							fusion_layout_element_type: 'nested'
						},
						complete: function( data ) {
							layoutsContainer.prepend( data.responseText );
							$( '.fusion-save-element-fields' ).remove();
							emptyMessage.hide();
						}
					} );

				} else {
					alert( fusionBuilderText.please_enter_element_name );
				}
			},

			getInnerRowContent: function() {
				var shortcode       = '',
				    $thisRowInner   = this.$el,
				    thisRowInnerCID = $thisRowInner.data( 'cid' ),
				    module          = FusionPageBuilderElements.findWhere( { cid: thisRowInnerCID } );

				shortcode += '[fusion_builder_row_inner]';

				// Find nested columns in this row
				$thisRowInner.find( '.fusion-builder-column-inner' ).each( function() {
					var $thisColumnInner = $( this ),
					    columnInnerCID   = $thisColumnInner.data( 'cid' ),
					    module           = FusionPageBuilderElements.findWhere( { cid: columnInnerCID } ),
					    columnParams     = {},
					    columnAttributesCheck;

					_.each( module.get( 'params' ), function( value, name ) {

						if ( 'undefined' === value ) {
							columnParams[name] = '';
						} else {
							columnParams[name] = value;
						}

					} );

					// Legacy support for new column options
					columnAttributesCheck = {
						min_height: '',
						last: 'no',
						hover_type: 'none',
						link: '',
						border_position: 'all'
					};

					_.each( columnAttributesCheck, function( value, name ) {

						if ( 'undefined' === typeof columnParams[ name ] ) {
							columnParams[name] = value;
						}

					} );

					// Build column shortcdoe
					shortcode += '[fusion_builder_column_inner type="' + module.get( 'layout' ) + '" background_position="' + columnParams.background_position + '" background_color="' + columnParams.background_color + '" border_size="' + columnParams.border_size + '" border_color="' + columnParams.border_color + '" border_style="' + columnParams.border_style + '" spacing="' + columnParams.spacing + '" background_image="' + columnParams.background_image + '" background_repeat="' + columnParams.background_repeat + '" padding="' + columnParams.padding + '" margin_top="' + columnParams.margin_top + '" margin_bottom="' + columnParams.margin_bottom + '" class="' + columnParams.class + '" id="' + columnParams.id + '" animation_type="' + columnParams.animation_type + '" animation_speed="' + columnParams.animation_speed + '" animation_direction="' + columnParams.animation_direction + '" hide_on_mobile="' + columnParams.hide_on_mobile + '" center_content="' + columnParams.center_content + '" last="' + columnParams.last + '" min_height="' + columnParams.min_height + '" hover_type="' + columnParams.hover_type + '" link="' + columnParams.link + '"]';

						// Find elements in this column
						$thisColumnInner.find( '.fusion_module_block' ).each( function() {
							shortcode += FusionPageBuilderApp.generateElementShortcode( $( this ), false );
						} );

					shortcode += '[/fusion_builder_column_inner]';

				} );

				shortcode += '[/fusion_builder_row_inner]';

				return shortcode;
			},

			sortableColumns: function() {
				var thisEl     = this,
				    selectedEl = thisEl.$el.find( '.fusion-builder-row-container-inner' ),
				    cid        = this.model.get( 'cid' );

				selectedEl.sortable( {
					items: '.fusion-builder-column-inner',
					helper: 'clone',
					cancel: '.fusion-builder-settings, .fusion-builder-clone, .fusion-builder-remove, .fusion-builder-section-add, .fusion-builder-add-element, .fusion-builder-insert-column, #fusion_builder_controls, .fusion-builder-save-column, .fusion-builder-resize-column, .column-sizes, .fusion-builder-save-column-dialog',
					tolerance: 'pointer',

					update: function( event, ui ) {
						var moduleCID = ui.item.data( 'cid' ),
						    model     = thisEl.collection.find( function( model ) {
								return model.get( 'cid' ) == moduleCID;
						    } );

						// Moved the column within the same row
						if ( model.get( 'parent' ) === thisEl.model.attributes.cid && $( ui.item ).closest( event.target ).length ) {

						// Moved the column to a different row
						} else {
							model.set( 'parent', thisEl.model.attributes.cid );
						}

						// Save history state
						fusionHistoryManager.turnOnTracking();
						fusionHistoryState = fusionBuilderText.moved_nested_column;

						FusionPageBuilderEvents.trigger( 'fusion-element-sorted' );
					}

				} ).disableSelection();
			},

			removeRow: function( event, force ) {

				var columns;

				if ( event ) {
					event.preventDefault();
				}

				columns = FusionPageBuilderViewManager.getChildViews( this.model.get( 'cid' ) );

				// Remove columns
				_.each( columns, function( column ) {
					column.removeColumn();
				} );

				this.model.destroy();

				FusionPageBuilderViewManager.removeView( this.model.get( 'cid' ) );

				this.remove();

				// If row ( nested columns ) is removed manually
				if ( event ) {

					// Save history state
					fusionHistoryManager.turnOnTracking();
					fusionHistoryState = fusionBuilderText.deleted_nested_columns;

					FusionPageBuilderEvents.trigger( 'fusion-element-removed' );
				}
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Nested Column View
		FusionPageBuilder.NestedColumnView = window.wp.Backbone.View.extend( {

			template: FusionPageBuilder.template( $( '#fusion-builder-inner-column-template' ).html() ),

			events: {
				'click .fusion-builder-add-element': 'addModule',
				'click .fusion-builder-settings-column': 'showSettings'
			},

			initialize: function() {
				this.$el.attr( 'data-cid', this.model.get( 'cid' ) );
				this.$el.attr( 'data-column-size', this.model.get( 'layout' ) );
			},

			render: function() {
				this.$el.html( this.template( this.model.toJSON() ) );
				this.sortableElements();

				return this;
			},

			sortableElements: function( event ) {
				var thisEl = this;
				this.$el.sortable( {
					items: '.fusion_module_block',
					connectWith: '.fusion-builder-column-inner',
					cancel: '.fusion-builder-settings, .fusion-builder-clone, .fusion-builder-remove, .fusion-builder-add-element, .fusion-builder-insert-column, .fusion-builder-save-module-dialog',
					tolerance: 'pointer',

					update: function( event, ui ) {
						var $moduleBlock = $( ui.item ),
						    moduleCID    = ui.item.data( 'cid' ),
						    model        = thisEl.collection.find( function( model ) {
								return model.get( 'cid' ) == moduleCID;
						    } );

						// If column is empty add before "Add Element" button
						if ( $( ui.item ).closest( event.target ).length && 1 === $( event.target ).find( '.fusion_module_block' ).length ) {
							$moduleBlock.insertBefore( $( event.target ).find( '.fusion-builder-add-element' ) );
						}

						// Moved the element within the same column
						if ( model.get( 'parent' ) === thisEl.model.attributes.cid && $( ui.item ).closest( event.target ).length ) {

						// Moved the element to a different column
						} else {
							model.set( 'parent', thisEl.model.attributes.cid );
						}

						// Save history state
						fusionHistoryManager.turnOnTracking();
						fusionHistoryState = fusionBuilderText.moved + ' ' + fusionAllElements[model.get( 'element_type' )].name + ' ' + fusionBuilderText.element;
						FusionPageBuilderEvents.trigger( 'fusion-element-sorted' );
					}

				} );
			},

			showSettings: function( event ) {
				var modalView,
				    viewSettings = {
						model: this.model,
						collection: this.collection,
						attributes: {
							'data-modal_view': 'element_settings'
						}
				    };

				if ( event ) {
					event.preventDefault();
				}

				modalView = new FusionPageBuilder.ModalView( viewSettings );

				$( 'body' ).append( modalView.render().el );
			},

			removeColumn: function( event ) {
				var modules;

				if ( event ) {
					event.preventDefault();
				}

				modules = FusionPageBuilderViewManager.getChildViews( this.model.get( 'cid' ) );

				_.each( modules, function( module ) {
					module.removeElement();
				} );

				FusionPageBuilderViewManager.removeView( this.model.get( 'cid' ) );

				this.model.destroy();

				this.remove();

				// If the column is deleted manually
				if ( event ) {
					FusionPageBuilderEvents.trigger( 'fusion-element-removed' );
				}
			},

			addModule: function( event ) {
				var view,
				    $eventTarget,
				    $addModuleButton;

				if ( event ) {
					event.preventDefault();
					event.stopPropagation();
				}

				FusionPageBuilderApp.innerColumn = 'true';
				FusionPageBuilderApp.parentColumnId = this.model.get( 'cid' );

				$eventTarget     = $( event.target );
				$addModuleButton = $eventTarget.is( 'span' ) ? $eventTarget.parent( '.fusion-builder-add-element' ) : $eventTarget;

				if ( ! $addModuleButton.parent().is( event.delegateTarget ) ) {
					return;
				}

				view = new FusionPageBuilder.ModalView( {
					model: this.model,
					collection: this.collection,
					attributes: {
						'data-modal_view': 'element_library'
					},
					view: this
				} );

				$( 'body' ).append( view.render().el );
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Column View
		FusionPageBuilder.ColumnView = window.wp.Backbone.View.extend( {

			template: FusionPageBuilder.template( $( '#fusion-builder-column-template' ).html() ),

			events: {
				'click .fusion-builder-add-element:not(.fusion-builder-column-inner .fusion-builder-add-element)': 'addModule',
				'click .fusion-builder-settings-column:not(.fusion-builder-column-inner .fusion-builder-settings-column)': 'showSettings',
				'click .fusion-builder-resize-column:not(.fusion-builder-column-inner .fusion-builder-resize-column)': 'columnSizeDialog',
				'click .column-size:not(.fusion-builder-column-inner .column-size)': 'columnSize',
				'click .fusion-builder-clone-column:not(.fusion-builder-column-inner .fusion-builder-clone-column)': 'cloneColumn',
				'click .fusion-builder-remove-column:not(.fusion-builder-column-inner .fusion-builder-remove-column)': 'removeColumn',
				'click .fusion-builder-save-column-dialog:not(.fusion-builder-column-inner .fusion-builder-save-column-dialog)': 'saveColumnDialog'
			},

			initialize: function() {
				this.$el.attr( 'data-cid', this.model.get( 'cid' ) );
				this.$el.attr( 'data-column-size', this.model.get( 'layout' ) );
			},

			render: function() {
				var columnSize,
				    fractionSize;

				this.$el.html( this.template( this.model.toJSON() ) );

				this.sortableElements();

				// Add active column size CSS class
				columnSize = this.model.get( 'layout' );
				this.$el.find( '.column-size-' + columnSize ).addClass( 'active-size' );

				// Set column size fraction
				fractionSize = columnSize.replace( '_', '/' );
				this.$el.find( '.fusion-builder-resize-column' ).text( fractionSize );

				return this;
			},

			sortableElements: function( event ) {
				var thisEl = this;
				this.$el.sortable( {
					items: '.fusion_module_block:not(.fusion_builder_row_inner .fusion_module_block), .fusion_builder_row_inner',
					connectWith: '.fusion-builder-column-outer',
					cancel: '.fusion-builder-settings, .fusion-builder-clone, .fusion-builder-remove, .fusion-builder-add-element, .fusion-builder-insert-column, .fusion-builder-save-module-dialog, .fusion-builder-remove-inner-row, .fusion-builder-save-inner-row-dialog-button, .fusion-builder-remove-inner-row, .fusion_builder_row_inner .fusion-builder-row-content',
					tolerance: 'pointer',

					over: function( event, ui ) {

						// Move sortable palceholder above +Element button for empty columns.
						if ( 1 === $( event.target ).find( '.fusion_module_block, .fusion_builder_row_inner' ).length ) {
							$( event.target ).find( '.ui-sortable-placeholder' ).insertBefore( $( event.target ).find( '.fusion-builder-add-element' ) );
						}
					},

					update: function( event, ui ) {
						var $moduleBlock = $( ui.item ),
						    moduleCID    = ui.item.data( 'cid' ),
						    model        = thisEl.collection.find( function( model ) {
								return model.get( 'cid' ) == moduleCID;
						    } );

						// If column is empty add element before "Add Element" button
						if ( $( ui.item ).closest( event.target ).length && 1 === $( event.target ).find( '.fusion_module_block, .fusion_builder_row_inner' ).length ) {

							$moduleBlock.insertBefore( $( event.target ).find( '> .fusion-builder-add-element' ) );
						}

						// Moved the element within the same column
						if ( model.get( 'parent' ) === thisEl.model.attributes.cid && $( ui.item ).closest( event.target ).length ) {

						// Moved the element to a different column
						} else {
							model.set( 'parent', thisEl.model.attributes.cid );
						}

						// Save history state
						fusionHistoryManager.turnOnTracking();
						fusionHistoryState = fusionBuilderText.moved + ' ' + fusionAllElements[ model.get( 'element_type' ) ].name + ' ' + fusionBuilderText.element;
						FusionPageBuilderEvents.trigger( 'fusion-element-sorted' );
					}

				} );
			},

			saveColumnDialog: function( event ) {
				if ( event ) {
					event.preventDefault();
				}
				FusionPageBuilderApp.showLibrary();

				$( '#fusion-builder-layouts-columns-trigger' ).click();

				$( '#fusion-builder-layouts-columns .fusion-builder-layouts-header-element-fields' ).append( '<div class="fusion-save-element-fields"><input type="text" value="" id="fusion-builder-save-element-input" class="fusion-builder-save-element-input" placeholder="' + fusionBuilderText.enter_name + '" /><a href="#" class="fusion-builder-save-column fusion-builder-element-button-save" data-element-cid="' + this.model.get( 'cid' ) + '">' + fusionBuilderText.save_column + '</a></div>' );
			},

			// Save column
			saveElement: function( event ) {
				var $thisColumn      = this.$el,
				    elementContent   = this.getColumnContent( $thisColumn ),
				    elementName      = $( '#fusion-builder-save-element-input' ).val(),
				    layoutsContainer = $( '#fusion-builder-layouts-columns .fusion-page-layouts' ),
				    emptyMessage     = $( '#fusion-builder-layouts-columns .fusion-page-layouts .fusion-empty-library-message' );

				if ( event ) {
					event.preventDefault();
				}

				if ( '' !== elementName ) {

					$.ajax( {
						type: 'POST',
						url: fusionBuilderConfig.ajaxurl,
						dataType: 'json',
						data: {
							action: 'fusion_builder_save_layout',
							fusion_load_nonce: fusionBuilderConfig.fusion_load_nonce,
							fusion_layout_name: elementName,
							fusion_layout_content: elementContent,
							fusion_layout_post_type: 'fusion_element',
							fusion_layout_new_cat: 'columns'
						},
						complete: function( data ) {
							layoutsContainer.prepend( data.responseText );
							$( '.fusion-save-element-fields' ).remove();
							emptyMessage.hide();
						}
					} );

				} else {
					alert( fusionBuilderText.please_enter_element_name );
				}
			},

			getColumnContent: function( $thisColumn ) {
				var shortcode    = '',
				    columnCID    = $thisColumn.data( 'cid' ),
				    module       = FusionPageBuilderElements.findWhere( { cid: columnCID } ),
				    columnParams = {},
				    ColumnAttributesCheck;

				_.each( module.get( 'params' ), function( value, name ) {
					if ( 'undefined' === value ) {
						columnParams[ name ] = '';
					} else {
						columnParams[ name ] = value;
					}

				} );

				// Legacy support for new column options
				ColumnAttributesCheck = {
					min_height: '',
					last: 'no',
					hover_type: 'none',
					link: '',
					border_position: 'all'
				};

				_.each( ColumnAttributesCheck, function( value, name ) {

					if ( 'undefined' === typeof columnParams[ name ] ) {
						columnParams[ name ] = value;
					}

				} );

				// Build column shortcode
				shortcode += '[fusion_builder_column type="' + module.get( 'layout' ) + '"';

				_.each( columnParams, function( value, name ) {

					shortcode += ' ' + name + '="' + value + '"';

				});

				shortcode += ']';

				// Find elements inside this column
				$thisColumn.find( '.fusion_builder_column_element:not(.fusion-builder-column-inner .fusion_builder_column_element)' ).each( function() {
					var $thisRowInner;

					// Find standard elements
					if ( $( this ).hasClass( 'fusion_module_block' ) ) {
						shortcode += FusionPageBuilderApp.generateElementShortcode( $( this ), false );

					// Find inner rows
					} else {
						$thisRowInner = $( this );
						shortcode += '[fusion_builder_row_inner]';

						// Find nested columns
						$thisRowInner.find( '.fusion-builder-column-inner' ).each( function() {
							var $thisColumnInner  = $( this ),
							    columnInnerCID    = $thisColumnInner.data( 'cid' ),
							    module            = FusionPageBuilderElements.findWhere( { cid: columnInnerCID } ),
							    innerColumnParams = {},
							    innerColumnAttributesCheck;

							_.each( module.get( 'params' ), function( value, name ) {

								if ( 'undefined' === value ) {
									innerColumnParams[ name ] = '';
								} else {
									innerColumnParams[ name ] = value;
								}

							} );

							// Legacy support for new column options
							innerColumnAttributesCheck = {
								min_height: '',
								last: 'no',
								hover_type: 'none',
								link: '',
								border_position: 'all'
							};

							_.each( innerColumnAttributesCheck, function( value, name ) {

								if ( 'undefined' === typeof innerColumnParams[ name ] ) {
									innerColumnParams[ name ] = value;
								}

							} );

							// Build nested column shortcode
							shortcode += '[fusion_builder_column_inner type="' + module.get( 'layout' ) + '"';

								_.each( innerColumnParams, function( value, name ) {

									shortcode += ' ' + name + '="' + value + '"';

								});

								shortcode += ']';

								// Find elements within nested columns
								$thisColumnInner.find( '.fusion_module_block' ).each( function() {
									shortcode += FusionPageBuilderApp.generateElementShortcode( $( this ), false );
								} );

							shortcode += '[/fusion_builder_column_inner]';

						} );

						shortcode += '[/fusion_builder_row_inner]';
					}

				} );

				shortcode += '[/fusion_builder_column]';

				return shortcode;
			},

			showSettings: function( event ) {
				var modalView,
				    viewSettings = {
						model: this.model,
						collection: this.collection,
						attributes: {
							'data-modal_view': 'element_settings'
						}
				    };

				if ( event ) {
					event.preventDefault();
				}

				modalView = new FusionPageBuilder.ModalView( viewSettings );

				$( 'body' ).append( modalView.render().el );
			},

			removeColumn: function( event ) {
				var modules;

				if ( event ) {
					event.preventDefault();
				}

				modules = FusionPageBuilderViewManager.getChildViews( this.model.get( 'cid' ) );

				_.each( modules, function( module ) {
					if ( 'fusion_builder_row' === module.model.get( 'type' ) || 'fusion_builder_row_inner' === module.model.get( 'type' ) ) {
						module.removeRow();
					} else {
						module.removeElement();
					}
				} );

				FusionPageBuilderViewManager.removeView( this.model.get( 'cid' ) );

				this.model.destroy();

				this.remove();

				// If the column is deleted manually
				if ( event ) {

					// Save history state
					fusionHistoryManager.turnOnTracking();
					fusionHistoryState = fusionBuilderText.deleted + ' ' + fusionBuilderText.column;

					FusionPageBuilderEvents.trigger( 'fusion-element-removed' );
				}
			},

			addModule: function( event ) {
				var view,
				    $eventTarget,
				    $addModuleButton;

				if ( event ) {
					event.preventDefault();
					event.stopPropagation();
				}

				FusionPageBuilderApp.innerColumn = 'false';
				FusionPageBuilderApp.parentColumnId = this.model.get( 'cid' );

				$eventTarget     = $( event.target );
				$addModuleButton = $eventTarget.is( 'span' ) ? $eventTarget.parent( '.fusion-builder-add-element' ) : $eventTarget;

				if ( ! $addModuleButton.parent().is( event.delegateTarget ) ) {
					return;
				}

				view = new FusionPageBuilder.ModalView( {
					model: this.model,
					collection: this.collection,
					attributes: {
						'data-modal_view': 'element_library'
					},
					view: this
				} );

				$( 'body' ).append( view.render().el );
			},

			cloneColumn: function( event ) {
				var columnAttributes = _.clone( this.model.attributes ),
				    $thisColumn;

				if ( event ) {
					event.preventDefault();
				}

				columnAttributes.created = 'manually';
				columnAttributes.cid     = FusionPageBuilderViewManager.generateCid();
				columnAttributes.targetElement = this.$el;

				FusionPageBuilderApp.collection.add( columnAttributes );

				// Parse column elements
				$thisColumn = this.$el;
				$thisColumn.find( '.fusion_builder_column_element:not(.fusion-builder-column-inner .fusion_builder_column_element)' ).each( function() {
					var $thisModule,
					    moduleCID,
					    module,
					    elementAttributes,
					    $thisInnerRow,
					    innerRowCID,
					    innerRowView;

					// Standard element
					if ( $( this ).hasClass( 'fusion_module_block' ) ) {
						$thisModule = $( this );
						moduleCID = 'undefined' === typeof $thisModule.data( 'cid' ) ? $thisModule.find( '.fusion-builder-data-cid' ).data( 'cid' ) : $thisModule.data( 'cid' );

						// Get model from collection by cid
						module = FusionPageBuilderElements.find( function( model ) {
							return model.get( 'cid' ) == moduleCID;
						} );

						// Clone model attritubes
						elementAttributes         = _.clone( module.attributes );
						elementAttributes.created = 'manually';
						elementAttributes.cid     = FusionPageBuilderViewManager.generateCid();
						elementAttributes.parent  = columnAttributes.cid;
						elementAttributes.from    = 'fusion_builder_column';

						FusionPageBuilderApp.collection.add( elementAttributes );

					// Inner row/nested element
					} else if ( $( this ).hasClass( 'fusion_builder_row_inner' ) ) {
						$thisInnerRow = $( this );
						innerRowCID = 'undefined' === typeof $thisInnerRow.data( 'cid' ) ? $thisInnerRow.find( '.fusion-builder-data-cid' ).data( 'cid' ) : $thisInnerRow.data( 'cid' );

						innerRowView = FusionPageBuilderViewManager.getView( innerRowCID );

						// Clone inner row
						if ( 'undefined' !== typeof innerRowView ) {
							innerRowView.cloneNestedRow( '', columnAttributes.cid );
						}
					}

				} );

				// If column is cloned manually
				if ( event ) {

					// Save history state
					fusionHistoryManager.turnOnTracking();
					fusionHistoryState = fusionBuilderText.cloned + ' ' + fusionBuilderText.column;

					FusionPageBuilderEvents.trigger( 'fusion-element-cloned' );
				}
			},

			columnSizeDialog: function( event ) {
				if ( event ) {
					event.preventDefault();
				}

				this.$el.find( '.column-sizes' ).toggle();
			},

			columnSize: function( event ) {
				var $thisEl = $( event.currentTarget ),

					// Get current column size
					size = this.model.get( 'layout' ),

					// New column size
					newSize = $thisEl.attr( 'data-column-size' ),

					// Fraction size
					fractionSize = '';

					if ( event ) {
						event.preventDefault();
					}

				if ( 'undefined' !== typeof ( newSize ) ) {

					// Set new size
					this.model.set( 'layout', newSize );

					// Change css size class
					this.$el.removeClass( 'fusion-builder-column-' + size );
					this.$el.addClass( 'fusion-builder-column-' + newSize );

					fractionSize = newSize.replace( '_', '/' );

					this.$el.find( '.fusion-builder-resize-column' ).text( fractionSize );
					this.$el.find( '.column-sizes' ).hide();
					this.$el.find( '.column-sizes .column-size' ).removeClass( 'active-size' );
					this.$el.find( '.column-size-' + newSize ).addClass( 'active-size' );

					// Save history state
					fusionHistoryManager.turnOnTracking();
					fusionHistoryState = fusionBuilderText.resized_column + ' ' + fractionSize;

					FusionPageBuilderEvents.trigger( 'fusion-element-edited' );
				}
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Modal view
		FusionPageBuilder.ModalView = window.wp.Backbone.View.extend( {

			className: 'fusion-builder-modal-settings-container',

			template: FusionPageBuilder.template( $( '#fusion-builder-modal-template' ).html() ),

			events: {
				'click .fusion-builder-modal-save': 'saveSettings',
				'click .fusion-builder-modal-close': 'closeModal'
			},

			initialize: function( attributes ) {

				// New columns added. Remove modal view.
				this.listenTo( FusionPageBuilderEvents, 'fusion-columns-added', this.removeView );

				// Remove modal view
				this.listenTo( FusionPageBuilderEvents, 'fusion-remove-modal-view', this.removeView );

				// Close modal view
				this.listenTo( FusionPageBuilderEvents, 'fusion-close-modal', this.closeModal );

				this.options = attributes;

				this.elementType = '';

			},

			render: function() {
				var view,
				    viewSettings = {
						model: this.model,
						collection: this.collection,
						view: this.options.view
				    },
				    customSettingsViewName,
				    $container;

				// TODO: update the row view if it has been dragged into another column
				if ( 'undefined' !== typeof this.model && 'undefined' !== typeof this.model.get( 'view' ) && ( 'row_inner' === this.model.get( 'element_type' ) || 'fusion_builder_row' === this.model.get( 'element_type' ) ) && this.model.get( 'parent' ) !== this.model.get( 'view' ).$el.data( 'cid' ) ) {
					this.model.set( 'view', FusionPageBuilderViewManager.getView( this.model.get( 'parent' ) ), { silent: true } );
				}

				if ( 'undefined' !== typeof this.model ) {
					this.$el.html( this.template( this.model.toJSON() ) );

				} else {
					this.$el.html( this.template() );
				}

				$container = this.$el.find( '.fusion-builder-modal-container' );

				// Show columns library view
				if ( 'column_library' === this.attributes['data-modal_view'] ) {
					view = new FusionPageBuilder.ColumnLibraryView( viewSettings );

				// Show elements library view
				} else if ( 'element_library' === this.attributes['data-modal_view'] ) {
					viewSettings.attributes = {
						'data-parent_cid': this.model.get( 'cid' )
					};
					view = new FusionPageBuilder.ElementLibraryView( viewSettings );

				// Show all shortcodes for generator
				} else if ( 'all_elements_generator' === this.attributes['data-modal_view'] ) {
					viewSettings.attributes = {};
					view = new FusionPageBuilder.GeneratorElementsView( viewSettings );

				// Show multi element element child settings
				} else if ( 'multi_element_child_settings' === this.attributes['data-modal_view'] ) {
					viewSettings.attributes = {};
					view = new FusionPageBuilder.MultiElementSettingsView( viewSettings );

				// Show element settings
				} else if ( 'element_settings' === this.attributes['data-modal_view'] ) {
					viewSettings.attributes = {
						'data-element_type': this.model.get( 'element_type' )
					};

					if ( 'undefined' !== typeof this.model && 'undefined' !== typeof this.model.get( 'multi' ) && 'multi_element_parent' === this.model.get( 'multi' ) ) {
						this.elementType = 'multi';
					}

					viewSettings.view = this;

					customSettingsViewName = fusionAllElements[this.model.get( 'element_type' )].custom_settings_view_name;

					if ( 'undefined' !== typeof customSettingsViewName && '' !== customSettingsViewName ) {
						view = new FusionPageBuilder[ customSettingsViewName ]( viewSettings );

					} else {
						view = new FusionPageBuilder.ElementSettingsView( viewSettings );
					}
				}

				$container.append( view.render().el );

				$( 'body' ).addClass( 'fusion_builder_no_scroll' ).append( '<div class="fusion_builder_modal_overlay"></div>' );

				// Element search field
				if ( 'column_library' === this.attributes['data-modal_view'] || 'element_library' === this.attributes['data-modal_view'] || 'all_elements_generator' === this.attributes['data-modal_view'] ) {
					this.elementSearchFilter();
				}

				// Add additional container class for multi elements
				if ( 'multi' === this.elementType ) {
					this.$el.addClass( 'fusion_builder_modal_multi_element_settings_container' );
				}

				return this;
			},

			closeModal: function( event ) {

				var parentID,
				    parentView,
				    params,
				    defaultParams,
				    value,
				    attributes,
				    editorID,
				    sortableCID,
				    sortableUIView;

				if ( event ) {
					event.preventDefault();
				}

				FusionPageBuilderApp.activeModal = '';

				// Close colorpickers before saving
				this.$el.find( '.wp-color-picker' ).each( function() {
					$( this ).wpColorPicker( 'close' );
				} );

				// Destroy CodeMirror editor instance
				if ( FusionPageBuilderApp.codeEditor ) {
					FusionPageBuilderApp.codeEditor.toTextArea();
				}

				// If new section creation was cancelled
				if ( true == FusionPageBuilderApp.newContainerAdded ) {
					FusionPageBuilderApp.newContainerAdded = false;
				}

				// Remove each instance of tinyMCE editor from this view
				this.$el.find( '.tinymce' ).each( function() {
					editorID = $( this ).find( 'textarea.fusion-editor-field' ).attr( 'id' );
						FusionPageBuilderApp.fusionBuilderMCEremoveEditor( editorID );
				} );

				// Save history state
				if ( 'undefined' !== typeof this.model && true !== FusionPageBuilderApp.MultiElementChildSettings && 'undefined' !== this.model.get( 'added' ) && 'manually' === this.model.get( 'added' ) ) {
					fusionHistoryManager.turnOnTracking();
				} else {
					FusionPageBuilderApp.MultiElementChildSettings = false;
				}

				// Generator active
				if ( true === FusionPageBuilderApp.shortcodeGenerator ) {

					// Multi element parent
					if ( 'undefined' !== typeof this.model && 'undefined' !== typeof this.model.get( 'multi' ) && 'multi_element_parent' === this.model.get( 'multi' ) ) {

						FusionPageBuilderApp.shortcodeGeneratorMultiElement = '';
						FusionPageBuilderApp.shortcodeGeneratorMultiElementChild = '';
						FusionPageBuilderApp.shortcodeGenerator = '';

						// Remove sortable UI view
						sortableCID = this.$el.find( '.fusion-builder-option-advanced-module-settings' ).data( 'cid' );
						sortableUIView = FusionPageBuilderViewManager.getView( sortableCID );
						sortableUIView.removeView();

						sortableCID = '';
						sortableUIView = '';

					// Multi element child
					} else if ( 'undefined' !== typeof this.model && 'undefined' !== typeof this.model.get( 'multi' ) && 'multi_element_child' === this.model.get( 'multi' ) ) {

						FusionPageBuilderApp.shortcodeGeneratorMultiElementChild = '';

					// Regular element
					} else {

						FusionPageBuilderApp.shortcodeGenerator = '';
						FusionPageBuilderApp.shortcodeGeneratorEditorID = '';
					}

				} else {

					// If element was added manually ( by clicking + add element )
					if ( 'undefined' !== this.model.get( 'added' ) && 'manually' === this.model.get( 'added' ) ) {

						if ( 'fusion_builder_row' === this.model.get( 'element_type' ) ) {
							parentID   = this.model.get( 'parent' ),
							parentView = FusionPageBuilderViewManager.getView( parentID );

							if ( 'undefined' !== typeof parentView ) {
								parentView.removeContainer();
							}

						} else {

							// On Element creation set default options if Cancel button is clicked
							defaultParams = fusionAllElements[ this.model.get( 'element_type' ) ].params;
							params        = {};

							// Process default parameters from shortcode
							_.each( defaultParams, function( param ) {
								if ( _.isObject( param.value ) ) {
									value = param.default;
								} else {
									value = param.value;
								}
								params[param.param_name] = value;
							} );

							attributes = {
								params: params
							};

							this.model.set( attributes );

							if ( event ) {
								FusionPageBuilderEvents.trigger( 'fusion-element-added' );
							}
						}

						if ( 'element' === this.model.get( 'type' ) ) {
							this.deleteModel();
						}

						if ( 'undefined' !== typeof this.model && 'undefined' !== typeof this.model.get( 'multi' ) && 'multi_element_parent' === this.model.get( 'multi' ) ) {

							// Remove sortable UI view
							FusionPageBuilderEvents.trigger( 'fusion-multi-remove-sortables-view' );
						}

					}

				}

				this.removeOverlay();

				this.remove();
			},

			removeView: function() {

				this.removeOverlay();

				if ( 'undefined' === typeof this.model || ( 'fusion_builder_row' === this.model.get( 'type' ) || 'fusion_builder_column' === this.model.get( 'type' ) || 'fusion_builder_row_inner' === this.model.get( 'type' ) || 'fusion_builder_column_inner' === this.model.get( 'type' ) ) ) {
					this.remove();
				}
			},

			saveSettings: function( event ) {

				var attributes,
				    shortcode,
				    columnCounter,
				    table,
				    generatedShortcode,
				    view,
				    editorID,
				    functionName,
				    sortableUIView,
				    sortableCID;

				if ( event ) {
					event.preventDefault();
				}

				// Close colorpickers before saving
				this.$el.find( '.wp-color-picker' ).each( function() {
					$( this ).wpColorPicker( 'close' );
				} );

				// Destroy CodeMirror editor instance
				if ( FusionPageBuilderApp.codeEditor ) {
					FusionPageBuilderApp.codeEditor.toTextArea();
				}

				// Save history state
				if ( true !== FusionPageBuilderApp.MultiElementChildSettings ) {
					fusionHistoryManager.turnOnTracking();
				} else {
					FusionPageBuilderApp.MultiElementChildSettings = false;
				}

				attributes = { params: ({}) };

				this.$el.find( 'input, select, textarea, #fusion_builder_content_main, #fusion_builder_content_main_child, #generator_element_content, #generator_multi_child_content, #element_content' ).not( ':input[type=button], .fusion-icon-search, .category-search-field, .fusion-builder-table input, .fusion-builder-table textarea, .single-builder-dimension .fusion-builder-dimension input, .fusion-hide-from-atts' ).each( function() {
					var $thisEl = $( this ),
					    settingValue,
					    name;

					// Multi element
					if ( $thisEl.is( '#generator_element_content' ) ||
						 $thisEl.is( '#fusion_builder_content_main' ) ||
						 $thisEl.is( '#element_content' ) ||
						 $thisEl.is( '#generator_multi_child_content' ) ) {
						name = 'element_content';
					} else {
						name = $thisEl.attr( 'id' );
					}

					if ( $thisEl.is( '#fusion_builder_content_main' ) ) {
						settingValue = $thisEl.val();

					} else if ( ! $thisEl.is( ':checkbox' ) ) {

						if ( $thisEl.is( '#generator_element_content' ) ) {
							settingValue = fusionBuilderGetContent( 'generator_element_content' );

						} else if ( $thisEl.is( '#generator_multi_child_content' ) ) {
							settingValue = fusionBuilderGetContent( 'generator_multi_child_content' );

						} else if ( $thisEl.is( 'textarea#element_content' ) && $thisEl.parents( '.fusion-builder-option' ).hasClass( 'tinymce' ) ) {
							settingValue = fusionBuilderGetContent( 'element_content' );

						} else {
							settingValue = $thisEl.val();
						}
					}

					// Escape input fields
					if ( $thisEl.is( 'input' ) && '' !== settingValue ) {
						if ( ! $thisEl.hasClass( 'fusion-builder-upload-field' ) && ! $thisEl.is( '#generator_element_content' ) && ! $thisEl.is( '#generator_multi_child_content' ) ) {
							settingValue = _.escape( settingValue );
						} else {
							settingValue = settingValue;
						}
					}
					if ( 'infobox_content' == name ) {
						settingValue = _.escape( settingValue );
					}
					attributes.params[ name ] = settingValue;

				} );

				// Escapes &, <, >, ", `, and ' characters
				if ( 'undefined' !== typeof fusionAllElements[ this.model.get( 'element_type' ) ].escape_html && true === fusionAllElements[ this.model.get( 'element_type' ) ].escape_html ) {
					attributes.params.element_content = _.escape( attributes.params.element_content );
				}

				// Manupulate model attributes via custom function if provided by element
				if ( 'undefined' !== typeof fusionAllElements[ this.model.get( 'element_type' ) ].on_save ) {
					functionName = fusionAllElements[ this.model.get( 'element_type' ) ].on_save;

					if ( 'function' === typeof FusionPageBuilderApp[ functionName ] ) {
						attributes = FusionPageBuilderApp[ functionName ]( attributes, this );
					}
				}

				// Base64 encode for Code Block element
				if ( 'fusion_code' === this.model.get( 'element_type' ) && 1 === Number( FusionPageBuilderApp.disable_encoding ) ) {
					attributes.params.element_content = FusionPageBuilderApp.base64Encode( attributes.params.element_content );
				}

				// Generator active
				if ( true === FusionPageBuilderApp.shortcodeGenerator ) {

					// Multi element parent
					if ( 'multi_element_parent' === this.model.get( 'multi' ) ) {

						this.model.set( attributes, { silent: true } );

						generatedShortcode = FusionPageBuilderApp.generateElementShortcode( this.model, false, true );
						fusionBuilderInsertIntoEditor( generatedShortcode );

						FusionPageBuilderApp.shortcodeGeneratorMultiElement = '';
						FusionPageBuilderApp.shortcodeGeneratorMultiElementChild = '';
						FusionPageBuilderApp.shortcodeGenerator = '';

						// Remove sortable UI view
						sortableCID = this.$el.find( '.fusion-builder-option-advanced-module-settings' ).data( 'cid' );
						sortableUIView = FusionPageBuilderViewManager.getView( sortableCID );
						sortableUIView.removeView();

						sortableCID = '';
						sortableUIView = '';

						this.remove();
						this.removeOverlay();

					// Multi element child
					} else if ( 'multi_element_child' === this.model.get( 'multi' ) ) {

						this.model.set( attributes );

						FusionPageBuilderEvents.trigger( 'fusion-multi-element-edited' );
						FusionPageBuilderEvents.trigger( 'fusion-multi-child-update-preview' );

						FusionPageBuilderApp.shortcodeGeneratorMultiElementChild = '';

						this.remove();

					// Regular element
					} else {

						if ( 'fusion_builder_column' === this.model.get( 'element_type' ) ) {
							attributes.params.type = this.model.get( 'layout' );
						}

						if ( 'fusion_builder_container' === this.model.get( 'element_type' ) ) {
							attributes.params.element_content = '[fusion_builder_row][/fusion_builder_row]';
						}

						this.model.set( attributes, { silent: true } );

						generatedShortcode = FusionPageBuilderApp.generateElementShortcode( this.model, false, true );

						fusionBuilderInsertIntoEditor( generatedShortcode, FusionPageBuilderApp.shortcodeGeneratorEditorID );

						// Slide element "add video" button check
						if ( 'video' !== FusionPageBuilderApp.shortcodeGeneratorEditorID ) {
							FusionPageBuilderApp.shortcodeGenerator = '';
							FusionPageBuilderApp.shortcodeGeneratorEditorID = '';
						}

						this.remove();

						// Remove overlay if generator was triggered outside of builder
						if ( false === FusionPageBuilderApp.builderActive ) {
							this.removeOverlay();
						}
					}

				// Not from Shortcode Generator
				} else {

					if ( 'multi_element_child' === this.model.get( 'multi' ) ) {

						// Set element/model attributes
						this.model.set( attributes, { silent: true } );

						FusionPageBuilderEvents.trigger( 'fusion-multi-element-edited' );
						FusionPageBuilderEvents.trigger( 'fusion-multi-child-update-preview' );

						this.remove();

					} else if ( 'multi_element_parent' === this.model.get( 'multi' ) ) {

						// Save history state
						if ( 'undefined' === typeof this.model.get( 'added' ) ) {
							fusionHistoryState = fusionBuilderText.edited + ' ' + fusionAllElements[this.model.get( 'element_type' )].name + ' ' + fusionBuilderText.element;
						}

						// Remove 'added' attribute from newly created elements
						this.model.unset( 'added' );

						this.model.set( attributes );

						// Remove each instance of tinyMCE editor from this view
						this.$el.find( '.tinymce' ).each( function() {
							editorID = $( this ).find( 'textarea.fusion-editor-field' ).attr( 'id' );
								FusionPageBuilderApp.fusionBuilderMCEremoveEditor( editorID );
						} );

						// Remove sortable UI view
						FusionPageBuilderEvents.trigger( 'fusion-multi-remove-sortables-view' );

						this.remove();

						FusionPageBuilderEvents.trigger( 'fusion-modal-view-removed' );

						this.generatePreview();

						this.removeOverlay();

					} else {

						// Save history state
						if ( 'undefined' === typeof this.model.get( 'added' ) ) {
							fusionHistoryState = fusionBuilderText.edited + ' ' + fusionAllElements[this.model.get( 'element_type' )].name + ' ' + fusionBuilderText.element;
						}

						// Remove 'added' attribute from newly created elements
						this.model.unset( 'added' );

						this.model.set( attributes );

						// Remove each instance of tinyMCE editor from this view
						this.$el.find( '.tinymce' ).each( function() {
							editorID = $( this ).find( 'textarea.fusion-editor-field' ).attr( 'id' );
								FusionPageBuilderApp.fusionBuilderMCEremoveEditor( editorID );
						} );

						this.remove();

						FusionPageBuilderEvents.trigger( 'fusion-modal-view-removed' );

						this.generatePreview();

						this.removeOverlay();

					}

					if ( event ) {
						FusionPageBuilderEvents.trigger( 'fusion-element-added' );
					}

				}

				// Remove each instance of tinyMCE editor from this view
				this.$el.find( '.tinymce' ).each( function() {
					editorID = $( this ).find( 'textarea.fusion-editor-field' ).attr( 'id' );
						FusionPageBuilderApp.fusionBuilderMCEremoveEditor( editorID );
				} );

				FusionPageBuilderApp.activeModal = '';

			},

			removeOverlay: function() {
				if ( $( '.fusion_builder_modal_overlay' ).length ) {
					$( '.fusion_builder_modal_overlay' ).remove();
					$( 'body' ).removeClass( 'fusion_builder_no_scroll' );
				}
			},

			generatePreview: function() {
				var elementType = this.model.get( 'element_type' ),
				    viewSettings,
				    view,
				    previewView,
				    params,
				    emptySectionText;

				// Change empty section desc depending on bg image param.
				if ( 'fusion_builder_container' === elementType ) {
					params = this.model.get( 'params' );
					view = FusionPageBuilderViewManager.getView( this.model.get( 'cid' ) ).$el;
					emptySectionText = fusionBuilderText.empty_section;

					if ( '' !== params.background_image ) {
						emptySectionText = fusionBuilderText.empty_section_with_bg;
					}

					view.find( '.fusion-builder-empty-section' ).html( emptySectionText );
				}

				if ( 'undefined' !== typeof fusionAllElements[ elementType ].preview ) {

					viewSettings = {
						model: this.model,
						collection: FusionPageBuilderElements
					};

					view = FusionPageBuilderViewManager.getView( this.model.get( 'cid' ) ).$el.find( '.fusion-builder-module-preview' );
					previewView = new FusionPageBuilder.ElementPreviewView( viewSettings );
					view.html( '' ).append( previewView.render().el );
				}
			},

			deleteModel: function() {
				FusionPageBuilderViewManager.getView( this.model.get( 'cid' ) ).$el.find( '.fusion-builder-remove' ).click();
			},

			elementSearchFilter: function() {
				var thisEl = this.$el,
				    name,
				    value;

				thisEl.find( '.fusion-elements-filter' ).on( 'change paste keyup', function() {

					if ( $( this ).val() ) {
						value = $( this ).val().toLowerCase();

						thisEl.find( '.fusion-builder-all-modules li' ).each( function() {

							name = $( this ).find( '.fusion_module_title' ).text().trim().toLowerCase();

							// Also show portfolio on recent works search
							if ( 'portfolio' === name ) {
								name += ' recent works';
							}

							if ( name.search( value ) !== -1 ) {
								$( this ).show();
							} else {
								$( this ).hide();
							}

						} );

					} else {

						thisEl.find( '.fusion-builder-all-modules li' ).show();
					}

				} );
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		FusionPageBuilder.ElementSettingsView = window.wp.Backbone.View.extend( {

			className: 'fusion_builder_module_settings',

			events: {
				'click #qt_element_content_fusion_shortcodes_text_mode': 'activateSCgenerator'
			},

			activateSCgenerator: function( event ) {
				openShortcodeGenerator( $( event.target ) );
			},

			initialize: function() {
				this.template = FusionPageBuilder.template( $( '#fusion-builder-block-module-settings-template' ).html() );
				this.listenTo( FusionPageBuilderEvents, 'fusion-modal-view-removed', this.removeElement );
			},

			render: function() {
				var $thisEl = this.$el,
				    content = '',
				    view,
				    $contentTextarea,
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
				    $rangeDefault,
				    $hiddenValue,
				    $defaultValue,
				    thisModel,
				    $selectField,
				    textareaID,
				    allowGenerator = false,
				    $dimensionField,
				    $notFirst,
				    codeBlockId,
				    $codeBlock,
				    codeElement,
				    that = this,
				    $defaultReset,
				    $textField,
				    $placeholderText,
				    $theContent,
				    fixSettingsLvl = false,
				    parentAtts;

				thisModel = this.model;

				// Fix for deprecated 'settings_lvl' attribute
				if ( 'undefined' !== thisModel.attributes.params.settings_lvl && 'parent' === thisModel.attributes.params.settings_lvl ) {
					fixSettingsLvl = true;
					parentAtts = thisModel.attributes.params;
				}

				if ( 'undefined' !== typeof thisModel.get( 'allow_generator' ) && true === thisModel.get( 'allow_generator' ) ) {
					FusionPageBuilderApp.allowShortcodeGenerator = true;
				}

				this.$el.html( this.template( { atts: this.model.attributes } ) );

				$textField         = this.$el.find( '[data-placeholder]' );
				$contentTextarea   = this.$el.find( '.fusion-editor-field' );
				$colorPicker       = this.$el.find( '.fusion-builder-color-picker-hex' );
				$uploadButton      = this.$el.find( '.fusion-builder-upload-button' );
				$iconPicker        = this.$el.find( '.fusion-iconpicker' );
				$multiselect       = this.$el.find( '.fusion-form-multiple-select' );
				$checkboxbuttonset = this.$el.find( '.fusion-form-checkbox-button-set' );
				$radiobuttonset    = this.$el.find( '.fusion-form-radio-button-set' );
				$rangeSlider       = this.$el.find( '.fusion-slider-container' );
				$selectField       = this.$el.find( '.fusion-select-field' );
				$dimensionField    = this.$el.find( '.single-builder-dimension' );
				$codeBlock         = this.$el.find( '.fusion-builder-code-block' );

				if ( $textField.length ) {
					$textField.on( 'focus', function( event ) {
						if ( jQuery( event.target ).data( 'placeholder' ) === jQuery( event.target ).val() ) {
							jQuery( event.target ).val( '' );
						}
					} );
				}
				if ( $colorPicker.length ) {
					$colorPicker.each( function() {
						var self          = $( this ),
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
							$defaultReset.on( 'click', 'a', function( event ) {
								event.preventDefault();
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

				if ( $codeBlock.length ) {
					$codeBlock.each( function() {
						codeBlockId = $( this ).attr( 'id' );
						codeElement = $thisEl.find( '#' + codeBlockId );

						FusionPageBuilderApp.codeEditor = CodeMirror.fromTextArea( codeElement[0], {
							lineNumbers: true,
							lineWrapping: true,
							autofocus: true
						} );

						// Refresh editor after initialization
						setTimeout( function() {
							FusionPageBuilderApp.codeEditor.refresh();
							FusionPageBuilderApp.codeEditor.focus();
						}, 100 );

					});
				}

				if ( $dimensionField.length ) {
					$dimensionField.each( function() {
						jQuery( this ).find( '.fusion-builder-dimension input' ).on( 'change paste keyup', function( e ) {
							jQuery( this ).parents( '.single-builder-dimension' ).find( 'input[type="hidden"]' ).val(
								( ( jQuery( this ).parents( '.single-builder-dimension' ).find( 'div:nth-child(1) input' ).val().length ) ? jQuery( this ).parents( '.single-builder-dimension' ).find( 'div:nth-child(1) input' ).val() : '0px' ) + ' ' +
								( ( jQuery( this ).parents( '.single-builder-dimension' ).find( 'div:nth-child(2) input' ).val().length ) ? jQuery( this ).parents( '.single-builder-dimension' ).find( 'div:nth-child(2) input' ).val() : '0px' ) + ' ' +
								( ( jQuery( this ).parents( '.single-builder-dimension' ).find( 'div:nth-child(3) input' ).val().length ) ? jQuery( this ).parents( '.single-builder-dimension' ).find( 'div:nth-child(3) input' ).val() : '0px' ) + ' ' +
								( ( jQuery( this ).parents( '.single-builder-dimension' ).find( 'div:nth-child(4) input' ).val().length ) ? jQuery( this ).parents( '.single-builder-dimension' ).find( 'div:nth-child(4) input' ).val() : '0px' )
							);
						});
					});
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

					$multiselect.each( function() {

						$placeholderText = fusionBuilderText.select_options_or_leave_blank_for_all;
						if ( -1 !== jQuery( this ).attr( 'id' ).indexOf( 'cat_slug' ) ) {
							$placeholderText = fusionBuilderText.select_categories_or_leave_blank_for_all;
						} else if ( -1 !== jQuery( this ).attr( 'id' ).indexOf( 'exclude_cats' ) ) {
							$placeholderText = fusionBuilderText.select_categories_or_leave_blank_for_none;
						}

						jQuery( this ).chosen({
							width: '100%',
							placeholder_text_multiple: $placeholderText
						} );
					});
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
						jQuery( this.target ).closest( '.fusion-slider-container' ).prev().val( values[handle] );
						jQuery( '#' + $targetId ).trigger( 'change' );
					});

					// On manual input change, update slider position
					$rangeInput.on( 'change', function( values, handle ) {
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
						    $direction    = jQuery( this ).data( 'direction' ),
						    $value        = $rangeInput.val(),
						    $decimals     = $step.countDecimals(),
						    $rangeDefault = ( jQuery( this ).parents( '.fusion-builder-option' ).find( '.fusion-range-default' ).length ) ? jQuery( this ).parents( '.fusion-builder-option' ).find( '.fusion-range-default' ) : false,
						    $hiddenValue  = ( $rangeDefault ) ? jQuery( this ).parent().find( '.fusion-hidden-value' ) : false,
						    $defaultValue = ( $rangeDefault ) ? jQuery( this ).parents( '.fusion-builder-option' ).find( '.fusion-range-default' ).data( 'default' ) : false;

						createSlider( $i, $targetId, $rangeInput, $min, $max, $step, $value, $decimals, $rangeDefault, $hiddenValue, $defaultValue, $direction );

						$i++;
					});

				}

				// If there is tiny mce editor ( tinymce element option )
				if ( $contentTextarea.length ) {
					$contentTextareaOption = $contentTextarea.closest( '.fusion-builder-option' );

					// Multi element ( parent )
					if ( 'undefined' !== typeof this.model.get( 'multi' ) && 'multi_element_parent' === this.model.get( 'multi' ) ) {

						viewCID = FusionPageBuilderViewManager.generateCid();

						this.view_cid = viewCID;

						$contentTextareaOption.hide();

						$contentTextarea.attr( 'id', 'fusion_builder_content_main' );

						view = new FusionPageBuilder.MultiElementSortablesView( {
							model: this,
							el: this.$el.find( '.fusion-builder-option-advanced-module-settings' ),
							attributes: {
								cid: viewCID
							}
						} );

						FusionPageBuilderViewManager.addView( viewCID, view );

						$contentTextareaOption.before( view.render() );

						if ( '' !== $contentTextarea.html() ) {
							view.generateMultiElementChildSortables( $contentTextarea.html(), this.$el.find( '.fusion-builder-option-advanced-module-settings' ).data( 'element_type' ), fixSettingsLvl, parentAtts );
						}

					// Standard element
					} else {

						content = $contentTextarea.html();

						// Called from shortcode generator
						if ( true === FusionPageBuilderApp.shortcodeGenerator && true !== FusionPageBuilderApp.shortcodeGeneratorMultiElementChild ) {

							// TODO: unique id ( multiple mce )
							$contentTextarea.attr( 'id', 'generator_element_content' );

							textareaID = $contentTextarea.attr( 'id' );

							setTimeout( function() {

								$contentTextarea.wp_editor( content, textareaID );

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

						} else {

							textareaID = $contentTextarea.attr( 'id' );

							setTimeout( function() {

								if ( 'undefined' !== typeof thisModel.get( 'allow_generator' ) && true === thisModel.get( 'allow_generator' ) ) {
									allowGenerator = true;
								}

								$contentTextarea.wp_editor( content, textareaID, allowGenerator );

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

				}

				// Attachment upload alert.
				this.$el.find( '.uploadattachment .fusion-builder-upload-button' ).on( 'click', function( e ) {
					alert( fusionBuilderText.to_add_images );
				});

				setTimeout( function() {
					$thisEl.find( 'select, input, textarea, radio' ).filter( ':eq(0)' ).not( '[data-placeholder]' ).focus();
				}, 1 );

				// Range option preview
				FusionPageBuilderApp.rangeOptionPreview( this.$el );

				// Check option dependencies
				if ( 'undefined' !== typeof this.model ) {
					FusionPageBuilderApp.checkOptionDependency( fusionAllElements[ this.model.get( 'element_type' ) ], this.$el );
				}

				return this;

			},

			removeElement: function() {

				// Remove settings modal on save or close/cancel
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
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

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
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Multi Element Sortable UI
		FusionPageBuilder.MultiElementSortablesView = window.wp.Backbone.View.extend( {
			initialize: function() {

				if ( true === FusionPageBuilderApp.shortcodeGenerator ) {
					FusionPageBuilderApp.shortcodeGeneratorMultiElement = true;
				}

				this.listenTo( FusionPageBuilderEvents, 'fusion-multi-element-edited', this.generateContent );
				this.listenTo( FusionPageBuilderEvents, 'fusion-multi-remove-sortables-view', this.removeView );

				this.element_type = this.$el.data( 'element_type' );

				this.child_views = [];

				this.$el.attr( 'data-cid', this.attributes.cid );

				this.$sortable_options = this.$el.find( '.fusion-builder-sortable-options' );

				this.$sortable_options.sortable( {
					axis: 'y',
					cancel: '.fusion-builder-multi-setting-remove, .fusion-builder-multi-setting-options, .fusion-builder-multi-setting-clone',
					helper: 'clone',

					update: function( event, ui ) {
						FusionPageBuilderEvents.trigger( 'fusion-multi-element-edited' );
					}
				} );

				this.$add_sortable_item = this.$el.find( '.fusion-builder-add-multi-child' ).addClass( 'fusion-builder-add-sortable-initial' );
			},

			events: {
				'click .fusion-builder-add-multi-child': 'addChildElement'
			},

			render: function() {
				return this;
			},

			addChildElement: function( event ) {

				var params = {},
				    defaultParams,
				    value;

				if ( event ) {
					event.preventDefault();
				}

				defaultParams = fusionAllElements[ this.element_type ].params;

				// Process default parameters from shortcode
				_.each( defaultParams, function( param )  {
					if ( _.isObject( param.value ) ) {
						value = param.default;
					} else {
						value = param.value;
					}
					params[param.param_name] = value;
				} );

				this.model.collection.add( [ {
					type: 'element',
					element_type: this.element_type,
					cid: FusionPageBuilderViewManager.generateCid(),
					view: this,
					created: 'manually',
					multi: 'multi_element_child',
					child_element: 'true',
					parent: this.attributes.cid,
					params: params
				} ] );

				this.$add_sortable_item.removeClass( 'fusion-builder-add-sortable-initial' );

				FusionPageBuilderEvents.trigger( 'fusion-multi-element-edited' );

			},

			generateContent: function() {
				var content = '';

				this.$sortable_options.find( 'li' ).each( function() {
					var $thisEl = $( this );
					content += FusionPageBuilderApp.generateElementShortcode( $thisEl, false );
				} );

				this.$el.parents().find( '#fusion_builder_content_main' ).html( content );

				if ( ! this.$sortable_options.find( 'li' ).length ) {
					this.$add_sortable_item.addClass( 'fusion-builder-add-sortable-initial' );
				} else {
					this.$add_sortable_item.removeClass( 'fusion-builder-add-sortable-initial' );
				}

			},

			removeView: function( event ) {
				if ( event ) {
					event.preventDefault();
				}

				this.remove();
			},

			generateMultiElementChildSortables: function( content, moduleType, fixSettingsLvl, parentAtts ) {
				var thisEl        = this,
				    shortcodeTags = jQuery.map( fusionMultiElements, function( val, i ) {
						return val;
				    }).join( '|' ),
				    regExp      = window.wp.shortcode.regexp( shortcodeTags ),
				    innerRegExp = FusionPageBuilderApp.regExpShortcode( shortcodeTags ),
				    matches     = content.match( regExp );

				if ( '' !== content ) {
					this.$add_sortable_item.removeClass( 'fusion-builder-add-sortable-initial' );
				}

				_.each( matches, function( shortcode ) {
					var shortcodeElement     = shortcode.match( innerRegExp ),
					    shortcodeName        = shortcodeElement[2],
					    shortcodeAttributes  = '' !== shortcodeElement[3] ? window.wp.shortcode.attrs( shortcodeElement[3] ) : '',
					    shortcodeContent     = shortcodeElement[5],
					    elementName          = '',
					    moduleCID            = FusionPageBuilderViewManager.generateCid(),
					    prefixedAttributes   = { params: ( {}) },

					    // TODO: check if needed.  Commented out for FB item 420.
					    //shortcodesInContent = 'undefined' !== typeof shortcodeContent && '' !== shortcodeContent && shortcodeContent.match( regExp ),

					    // Check if shortcode allows generator
					    allowGenerator = 'undefined' !== typeof fusionAllElements[ shortcodeName ].allow_generator ? fusionAllElements[ shortcodeName ].allow_generator : '',
					    moduleSettings,
					    key,
					    prefixedKey,
					    dependencyOption,
					    dependencyOptionValue,
					    moduleContent;

					if ( 'undefined' !== typeof shortcodeAttributes.named && 'undefined' !== typeof shortcodeAttributes.named.title && shortcodeAttributes.named.title.length ) {
						elementName = shortcodeAttributes.named.title;
					} else if ( 'undefined' !== typeof shortcodeAttributes.named && 'undefined' !== typeof shortcodeAttributes.named.title_front && shortcodeAttributes.named.title_front.length ) {
						elementName = shortcodeAttributes.named.title_front;
					} else if ( 'undefined' !== typeof shortcodeAttributes.named && 'undefined' !== typeof shortcodeAttributes.named.image && shortcodeAttributes.named.image.length ) {
						elementName = shortcodeAttributes.named.image;

						// If contains backslash, retrieve only last part.
						if ( -1 !== elementName.indexOf( '/' ) && -1 === elementName.indexOf( '[' ) ) {
							elementName = elementName.split( '/' );
							elementName = elementName.slice( -1 )[0];
						}
					} else if ( 'undefined' !== typeof shortcodeAttributes.named && 'undefined' !== typeof shortcodeAttributes.named.video && shortcodeAttributes.named.video.length ) {
						elementName = shortcodeAttributes.named.video;
					} else if ( 'undefined' !== typeof shortcodeAttributes.named && 'undefined' !== typeof shortcodeContent && shortcodeContent.length ) {
						elementName = shortcodeContent;
					}

					// Remove HTML tags but keep quotation marks etc.
					elementName = jQuery( '<div/>' ).html( elementName ).text();
					elementName = jQuery( '<div/>' ).html( elementName ).text();
					elementName = ( elementName && elementName.length  > 15 ) ? elementName.substring( 0, 15 ) + '...' : elementName;

					moduleSettings = {
						type: 'element',
						element_type: moduleType,
						element_name: elementName,
						cid: FusionPageBuilderViewManager.generateCid(),
						view: thisEl,
						created: 'auto',
						multi: 'multi_element_child',
						child_element: 'true',
						allow_generator: allowGenerator,
						params: {},
						parent: thisEl.attributes.cid
					};

					if ( _.isObject( shortcodeAttributes.named ) ) {

						for ( key in shortcodeAttributes.named ) {

							prefixedKey = key;

							if ( ( 'fusion_builder_column' === shortcodeName ) && 'type' === prefixedKey || ( 'fusion_builder_column_inner' === shortcodeName ) && 'type' === prefixedKey ) {
								prefixedKey = 'layout';

								prefixedAttributes[ prefixedKey ] = shortcodeAttributes.named[ key ];
							}

							prefixedAttributes.params[ prefixedKey ] = shortcodeAttributes.named[ key ];

						}

						moduleSettings = _.extend( moduleSettings, prefixedAttributes );
					}

					// TODO: check if needed.  Commented out for FB item 420.
					// if ( ! shortcodesInContent ) {
					moduleSettings.params.element_content = shortcodeContent;

					// }.

					// Set module settings for modules with dependency options
					if ( 'undefined' !== typeof fusionAllElements[ shortcodeName ].option_dependency ) {

						dependencyOption      = fusionAllElements[ shortcodeName ].option_dependency;
						dependencyOptionValue = prefixedAttributes.params[ dependencyOption ];
						moduleContent         = prefixedAttributes.params.element_content;
						prefixedAttributes.params[ dependencyOptionValue ] = moduleContent;

					}

					// Fix for deprecated 'settings_lvl' attribute
					if ( true === fixSettingsLvl ) {
						if ( 'fusion_content_box' === moduleType ) {

							// Reset values that are inherited from parent
							moduleSettings.params.iconcolor              = '';
							moduleSettings.params.backgroundcolor        = '';
							moduleSettings.params.circlecolor            = '';
							moduleSettings.params.circlebordercolor      = '';
							moduleSettings.params.circlebordersize       = '';
							moduleSettings.params.outercirclebordercolor = '';
							moduleSettings.params.outercirclebordersize  = '';

							// Set values from parent element
							moduleSettings.params.animation_type      = parentAtts.animation_type;
							moduleSettings.params.animation_direction = parentAtts.animation_direction;
							moduleSettings.params.animation_speed     = parentAtts.animation_speed;
							moduleSettings.params.link_target         = parentAtts.link_target;
						}
					}

					thisEl.model.collection.add( [ moduleSettings ] );
				} );
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Multi Element child sortable item
		FusionPageBuilder.MultiElementSortableChild = window.wp.Backbone.View.extend( {
			tagName: 'li',
			className: 'fusion-builder-data-cid',

			initialize: function() {
				this.template = FusionPageBuilder.template( $( '#fusion-builder-multi-child-sortable' ).html() );
				this.listenTo( FusionPageBuilderEvents, 'fusion-multi-child-update-preview', this.updatePreview );
			},

			events: {
				'click .fusion-builder-multi-setting-options': 'showSettings',
				'click .fusion-builder-multi-setting-remove': 'removeView',
				'click .fusion-builder-multi-setting-clone': 'cloneElement'
			},

			render: function() {
				var view;

				this.$el.html( this.template( { atts: this.model.attributes } ) );

				return this;
			},

			cloneElement: function( event ) {

				var elementAttributes;

				if ( event ) {
					event.preventDefault();
				}

				elementAttributes         = _.clone( this.model.attributes );
				elementAttributes.created = 'manually';
				elementAttributes.cid     = FusionPageBuilderViewManager.generateCid();

				FusionPageBuilderApp.collection.add( elementAttributes );

				FusionPageBuilderEvents.trigger( 'fusion-multi-element-edited' );

				// Clone exact tab title being used.
				jQuery( event.target ).parents( 'ul' ).find( 'li:last-child .multi-element-child-name' ).text( jQuery( event.target ).parents( 'li' ).find( '.multi-element-child-name' ).text() );
			},

			showSettings: function( event ) {

				var modalView,
				    viewSettings,
				    $parentValues = {},
				    $parentOptions;

				if ( event ) {
					event.preventDefault();
				}

				FusionPageBuilderApp.MultiElementChildSettings = true;

				if ( true === FusionPageBuilderApp.shortcodeGenerator ) {
					FusionPageBuilderApp.shortcodeGeneratorMultiElementChild = true;
				}

				// Check for parent options with value set. If set, add to object.
				$parentOptions = jQuery( document ).find( '.fusion-builder-option.range .fusion-hidden-value, .wp-color-picker, .has-child-dependency input, .has-child-dependency select, .has-child-dependency textarea, .has-child-dependency #fusion_builder_content_main, .has-child-dependency #fusion_builder_content_main_child' ).not( ':input[type=button], .fusion-icon-search, .category-search-field, .fusion-builder-table input, .fusion-builder-table textarea, .single-builder-dimension .fusion-builder-dimension input, .fusion-hide-from-atts' );
				$parentOptions.each( function() {
					if ( jQuery( this ).val().length ) {
						$parentValues[ jQuery( this ).attr( 'id' ) ] = jQuery( this ).val();
					}
				});

				// Add parent value object to the child model.
				this.model.set({ parent_values: $parentValues });

				viewSettings = {
					model: this.model,
					collection: this.collection,
					attributes: {
						'data-modal_view': 'multi_element_child_settings'
					}
				};

				modalView = new FusionPageBuilder.ModalView( viewSettings );

				$( '.fusion_builder_modal_multi_element_settings_container' ).last().after( modalView.render().el );

			},

			updatePreview: function() {
				var $title,
				    $attributes = this.model.attributes,
				    $model      = this.model;

				if ( 'undefined' !== typeof $attributes ) {
					$title = '';
					if ( 'undefined' !== typeof $attributes.params.title && $attributes.params.title.length ) {
						$title = $attributes.params.title;
					} else if ( 'fusion_flip_box' == $model.get( 'element_type' ) && 'undefined' !== typeof $attributes.params.title_front && $attributes.params.title_front.length ) {
						$title = $attributes.params.title_front;
					} else if ( 'undefined' !== typeof $attributes.params.image && $attributes.params.image.length ) {
						$title = $attributes.params.image;

						// If contains backslash, retreive only last part.
						if ( -1 !== $title.indexOf( '/' ) && -1 === $title.indexOf( '[' ) ) {
							$title = $title.split( '/' );
							$title = $title.slice( -1 )[0];
						}
					} else if ( 'undefined' !== typeof $attributes.params.video && $attributes.params.video.length ) {
						$title = $attributes.params.video;
					} else if ( 'undefined' !== typeof $attributes.params.element_content && $attributes.params.element_content.length ) {
						$title = $attributes.params.element_content;
					}

					// Remove HTML tags but keep quotation marks etc.
					$title = jQuery( '<div/>' ).html( $title ).text();
					$title = jQuery( '<div/>' ).html( $title ).text();
					if ( $title ) {
						$title = ( $title.length  > 15 ) ? $title.substring( 0, 15 ) + '...' : $title;
						jQuery( 'li[data-cid=' + $model.get( 'cid' ) + '] .multi-element-child-name' ).text( $title );
					}
				}
			},

			removeView: function( event ) {
				if ( event ) {
					event.preventDefault();
				}

				this.remove();

				this.model.destroy();

				FusionPageBuilderEvents.trigger( 'fusion-multi-element-edited' );
			}

		} );

	} );

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

( function( $ ) {

	$( document ).ready( function() {

		// Column Library View
		FusionPageBuilder.ColumnLibraryView = window.wp.Backbone.View.extend( {

			className: 'fusion_builder_modal_settings',

			template: FusionPageBuilder.template( $( '#fusion-builder-column-library-template' ).html() ),

			events: {
				'click .fusion-builder-column-layouts li': 'addColumns',
				'click .fusion_builder_custom_columns_load': 'addCustomColumn',
				'click .fusion_builder_custom_sections_load': 'addCustomSection'
			},

			initialize: function( attributes ) {
				this.listenTo( FusionPageBuilderEvents, 'fusion-columns-added', this.removeView );
				this.listenTo( FusionPageBuilderEvents, 'fusion-modal-view-removed', this.removeView );

				this.options = attributes;
			},

			render: function() {
				this.$el.html( this.template( this.model.toJSON() ) );

				// Show saved custom columns
				FusionPageBuilderApp.showSavedElements( 'columns', this.$el.find( '#custom-columns' ) );

				// Show saved custom sections
				if ( 'container' === FusionPageBuilderApp.activeModal ) {
					FusionPageBuilderApp.showSavedElements( 'sections', this.$el.find( '#custom-sections' ) );
				}

				return this;
			},

			addCustomColumn: function( event ) {
				var thisModel,
				    layoutID,
				    title;

				if ( event ) {
					event.preventDefault();
				}

				FusionPageBuilderApp.activeModal = 'column';

				if ( true === FusionPageBuilderApp.layoutIsLoading ) {
					return;
				} else {
					FusionPageBuilderApp.layoutIsLoading = true;
				}

				thisModel = this.model;
				layoutID  = $( event.currentTarget ).data( 'layout_id' );
				title     = $( event.currentTarget ).find( '.fusion_module_title' ).text();

				$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).css( 'opacity', '0' );
				$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).prev( '#fusion-loader' ).show();

				$.ajax( {
					type: 'POST',
					url: FusionPageBuilderApp.ajaxurl,
					data: {
						action: 'fusion_builder_load_layout',
						fusion_load_nonce: FusionPageBuilderApp.fusion_load_nonce,
						fusion_layout_id: layoutID
					},
					success: function( data ) {

						var dataObj = JSON.parse( data );

						FusionPageBuilderApp.shortcodesToBuilder( dataObj.post_content, FusionPageBuilderApp.parentRowId );

						FusionPageBuilderApp.layoutIsLoading = false;

						$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).css( 'opacity', '1' );
						$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).prev( '#fusion-loader' ).hide();

					},
					complete: function() {

						// Unset 'added' attribute from newly created row model
						thisModel.unset( 'added' );

						// Save history state
						fusionHistoryManager.turnOnTracking();
						fusionHistoryState = fusionBuilderText.added_custom_column + title;

						FusionPageBuilderEvents.trigger( 'fusion-columns-added' );
						FusionPageBuilderEvents.trigger( 'fusion-element-cloned' );
					}
				} );
			},

			addColumns: function( event ) {

				var that,
				    $layoutEl,
				    layout,
				    layoutElementsNum,
				    thisView,
				    defaultParams,
				    params,
				    value;

				if ( event ) {
					event.preventDefault();
				}

				FusionPageBuilderApp.activeModal = 'column';

				that              = this;
				$layoutEl         = $( event.target ).is( 'li' ) ? $( event.target ) : $( event.target ).closest( 'li' );
				layout            = $layoutEl.data( 'layout' ).split( ',' );
				layoutElementsNum = _.size( layout );
				thisView          = this.options.view;

				// Get default settings
				defaultParams = fusionAllElements.fusion_builder_column.params;
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

				_.each( layout, function( element, index ) {
					var updateContent    = layoutElementsNum == ( index + 1 ) ? 'true' : 'false',
					    columnAttributes = {
							type: 'fusion_builder_column',
							element_type: 'fusion_builder_column',
							cid: FusionPageBuilderViewManager.generateCid(),
							parent: that.model.get( 'cid' ),
							layout: element,
							view: thisView,
							params: params
					    };

					that.collection.add( [ columnAttributes ] );

				} );

				// Unset 'added' attribute from newly created row model
				this.model.unset( 'added' );

				FusionPageBuilderEvents.trigger( 'fusion-columns-added' );

				if ( event ) {

					// Save history state
					fusionHistoryManager.turnOnTracking();

					if ( true == FusionPageBuilderApp.newContainerAdded ) {
						fusionHistoryState = fusionBuilderText.added_section;
						FusionPageBuilderApp.newContainerAdded = false;
					} else {
						fusionHistoryState = fusionBuilderText.added_columns;
					}

					FusionPageBuilderEvents.trigger( 'fusion-element-added' );
				}

			},

			removeView: function() {
				this.remove();
			},

			addCustomSection: function( event ) {
				var thisModel  = this.model,
				    parentID   = this.model.get( 'parent' ),
				    parentView = FusionPageBuilderViewManager.getView( parentID ),
				    layoutID,
				    title,
				    targetContainer;

				targetContainer = parentView.$el.prev( '.fusion_builder_container' );
				FusionPageBuilderApp.targetContainerCID = targetContainer.find( '.fusion-builder-data-cid' ).data( 'cid' );

				if ( event ) {
					event.preventDefault();
				}

				if ( 'undefined' !== typeof parentView ) {
					parentView.removeContainer();
				}

				if ( true === FusionPageBuilderApp.layoutIsLoading ) {
					return;
				} else {
					FusionPageBuilderApp.layoutIsLoading = true;
				}

				layoutID = $( event.currentTarget ).data( 'layout_id' );
				title    = $( event.currentTarget ).find( '.fusion_module_title' ).text();

				$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).css( 'opacity', '0' );
				$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).prev( '#fusion-loader' ).show();

				$.ajax( {
					type: 'POST',
					url: FusionPageBuilderApp.ajaxurl,
					data: {
						action: 'fusion_builder_load_layout',
						fusion_load_nonce: FusionPageBuilderApp.fusion_load_nonce,
						fusion_layout_id: layoutID
					},
					success: function( data ) {
						var dataObj = JSON.parse( data );

						FusionPageBuilderApp.shortcodesToBuilder( dataObj.post_content, FusionPageBuilderApp.parentRowId );

						FusionPageBuilderApp.layoutIsLoading = false;

						$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).css( 'opacity', '1' );
						$( event.currentTarget ).parent( '.fusion-builder-all-modules' ).prev( '#fusion-loader' ).hide();

					},
					complete: function() {

						// Unset 'added' attribute from newly created section model
						thisModel.unset( 'added' );

						// Save history state
						fusionHistoryManager.turnOnTracking();
						fusionHistoryState = fusionBuilderText.added_custom_section + title;

						FusionPageBuilderEvents.trigger( 'fusion-columns-added' );
						FusionPageBuilderEvents.trigger( 'fusion-element-cloned' );
					}
				});
			}

		} );

	});

} )( jQuery );
;var FusionPageBuilder = FusionPageBuilder || {};

// Events
var FusionPageBuilderEvents = _.extend( {}, Backbone.Events );

( function( $ ) {

	var FusionIconPickHandler,
		FusionDelay;

	$.fn.outerHTML = function() {
		return ( ! this.length ) ? this : ( this[0].outerHTML || ( function( el ) {
			var div = document.createElement( 'div' ),
			    contents;

			div.appendChild( el.cloneNode( true ) );
			contents = div.innerHTML;
			div = null;
			return contents;
		})( this[0] ) );
	};

	fusionBuilderGetContent = function( textareaID, removeAutoP, initialLoad ) {

		var content;

		if ( 'undefined' === typeof removeAutoP ) {
			removeAutoP = false;
		}

		if ( 'undefined' === typeof initialLoad ) {
			initialLoad = false;
		}

		if ( ! initialLoad && 'undefined' !== typeof window.tinyMCE && window.tinyMCE.get( textareaID ) && ! window.tinyMCE.get( textareaID ).isHidden() ) {
			content = window.tinyMCE.get( textareaID ).getContent();
		} else {
			content = $( '#' + textareaID ).val().replace( /\r?\n/g, '\r\n' );
		}

		// Remove auto p tags from content.
		if ( removeAutoP && 'undefined' !== typeof window.tinyMCE ) {
			content = content.replace( /<p>\[/g, '[' );
			content = content.replace( /\]<\/p>/g, ']' );
		}

		if ( 'undefined' !== typeof content ) {
			return content.trim();
		}
	};

	// Icon picker handler
	FusionIconPickHandler = $( '.icon_select_container .icon_preview' );

	// Delay
	FusionDelay = ( function() {
		var timer = 0;

		return function( callback, ms ) {
			clearTimeout( timer );
			timer = setTimeout( callback, ms );
		};
	})();

	$( window ).load( function() {
		if ( $( '#fusion_toggle_builder' ).data( 'enabled' ) ) {
			$( '#fusion_toggle_builder' ).trigger( 'click' );
		}
	});

	$( document ).ready( function() {

		var WooShortcodeHanlder,
		    $selectedDemo,
		    $useBuilderMetaField,
		    $toggleBuilderButton,
		    $builder,
		    $mainEditorWrapper,
		    $container,
		    LightboxShortcodeHandler;

		// Column sizes dialog. Close on outside click.
		$( document ).click( function( e ) {
			if ( $( e.target ).parents( '.column-sizes' ).length || $( e.target ).hasClass( 'fusion-builder-resize-column' ) ) {

				// Column sizes dialog clicked
			} else {
				$( '.column-sizes' ).hide();
			}
		} );

		// Fusion Builder App View
		FusionPageBuilder.AppView = window.wp.Backbone.View.extend( {

			el: $( '#fusion_builder_main_container' ),

			template: FusionPageBuilder.template( $( '#fusion-builder-app-template' ).html() ),

			events: {
				'click .fusion-builder-layout-button-save': 'saveLayout',
				'click .fusion-builder-layout-button-load': 'loadLayout',
				'click .fusion-builder-layout-button-delete': 'deleteLayout',
				'click .fusion-builder-layout-buttons-clear': 'clearLayout',
				'click .fusion-builder-demo-button-load': 'loadDemoPage',
				'click .fusion-builder-layout-custom-css': 'customCSS',
				'click .fusion-builder-template-buttons-save': 'saveTemplateDialog',
				'click #fusion-builder-layouts .fusion-builder-modal-close': 'hideLibrary',
				'click .fusion-builder-library-dialog': 'openLibrary',
				'mouseenter .fusion-builder-layout-buttons-history': 'showHistoryDialog',
				'mouseleave .fusion-builder-layout-buttons-history': 'hideHistoryDialog',
				'click .fusion-builder-element-button-save': 'saveElement',
				'click #fusion-load-template-dialog': 'loadPreBuiltPage',
				'click .fusion-builder-layout-buttons-toggle-containers': 'toggleAllContainers'
			},

			initialize: function() {

				this.builderActive             = false;
				this.ajaxurl                   = fusionBuilderConfig.ajaxurl;
				this.fusion_load_nonce         = fusionBuilderConfig.fusion_load_nonce;
				this.fusion_builder_plugin_dir = fusionBuilderConfig.fusion_builder_plugin_dir;
				this.layoutIsLoading           = false;
				this.layoutIsDeleting          = false;
				this.parentRowId               = '';
				this.parentColumnId            = '';
				this.targetContainerCID        = '';
				this.activeModal               = '';
				this.innerColumn               = '';
				this.blankPage                 = '';
				this.newLayoutLoaded           = false;
				this.newContainerAdded         = false;

				// Shortcode Generator
				this.shortcodeGenerator                  = '';
				this.shortcodeGeneratorMultiElement      = '';
				this.shortcodeGeneratorMultiElementChild = '';
				this.allowShortcodeGenerator             = '';
				this.shortcodeGeneratorActiveEditor      = '';
				this.shortcodeGeneratorEditorID          = '';

				// Code Block encoding
				this.disable_encoding = fusionBuilderConfig.disable_encoding;
				this._keyStr          = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
				this.codeEditor       = '';

				this.MultiElementChildSettings = false;

				// Listen for new elements
				this.listenTo( this.collection, 'add', this.addBuilderElement );

				// Convert builder layout to shortcodes
				this.listenTo( FusionPageBuilderEvents, 'fusion-element-added', this.builderToShortcodes );
				this.listenTo( FusionPageBuilderEvents, 'fusion-element-removed', this.builderToShortcodes );
				this.listenTo( FusionPageBuilderEvents, 'fusion-element-cloned', this.builderToShortcodes );
				this.listenTo( FusionPageBuilderEvents, 'fusion-element-edited', this.builderToShortcodes );
				this.listenTo( FusionPageBuilderEvents, 'fusion-element-sorted', this.builderToShortcodes );

				// Loader animation
				this.listenTo( FusionPageBuilderEvents, 'fusion-show-loader', this.showLoader );
				this.listenTo( FusionPageBuilderEvents, 'fusion-hide-loader', this.hideLoader );

				// Hide library
				this.listenTo( FusionPageBuilderEvents, 'fusion-hide-library', this.hideLibrary );

				// Save layout template on return key
				this.listenTo( FusionPageBuilderEvents, 'fusion-save-layout', this.saveLayout );

				// Save history state
				this.listenTo( FusionPageBuilderEvents, 'fusion-save-history-state', this.saveHistoryState );

				this.render();

				if ( $( '#fusion_toggle_builder' ).hasClass( 'fusion_builder_is_active' ) ) {

					// Create builder layout on initial load.
					this.initialBuilderLayout( true );
				}

				// Turn on history tracking. Capture editor. Save initial history state.
				fusionHistoryManager.turnOnTracking();
				fusionHistoryManager.captureEditor();
				fusionHistoryManager.turnOffTracking();
			},

			render: function() {
				this.$el.html( this.template() );
				this.sortableContainers();

				return this;
			},

			isTinyMceActive: function() {
				var isActive = ( 'undefined' !== typeof tinyMCE ) && tinyMCE.activeEditor && ! tinyMCE.activeEditor.isHidden();

				return isActive;
			},

			base64Encode: function( data ) {
				var b64 = this._keyStr,
				    o1,
				    o2,
				    o3,
				    h1,
				    h2,
				    h3,
				    h4,
				    bits,
				    i      = 0,
				    ac     = 0,
				    enc    = '',
				    tmpArr = [],
				    r;

				if ( ! data ) {
					return data;
				}

				data = unescape( encodeURIComponent( data ) );

				do {

					// Pack three octets into four hexets
					o1 = data.charCodeAt( i++ );
					o2 = data.charCodeAt( i++ );
					o3 = data.charCodeAt( i++ );

					bits = o1 << 16 | o2 << 8 | o3;

					h1 = bits >> 18 & 0x3f;
					h2 = bits >> 12 & 0x3f;
					h3 = bits >> 6 & 0x3f;
					h4 = bits & 0x3f;

					// Use hexets to index into b64, and append result to encoded string.
					tmpArr[ ac++ ] = b64.charAt( h1 ) + b64.charAt( h2 ) + b64.charAt( h3 ) + b64.charAt( h4 );
				} while ( i < data.length );

				enc = tmpArr.join( '' );
				r   = data.length % 3;

				return ( r ? enc.slice( 0, r - 3 ) : enc ) + '==='.slice( r || 3 );
			},

			base64Decode: function( input ) {
				var output = '',
				    chr1,
				    chr2,
				    chr3,
				    enc1,
				    enc2,
				    enc3,
				    enc4,
				    i = 0;

				input = input.replace( /[^A-Za-z0-9\+\/\=]/g, '' );

				while ( i < input.length ) {

					enc1 = this._keyStr.indexOf( input.charAt( i++ ) );
					enc2 = this._keyStr.indexOf( input.charAt( i++ ) );
					enc3 = this._keyStr.indexOf( input.charAt( i++ ) );
					enc4 = this._keyStr.indexOf( input.charAt( i++ ) );

					chr1 = ( enc1 << 2 ) | ( enc2 >> 4 );
					chr2 = ( ( enc2 & 15 ) << 4 ) | ( enc3 >> 2 );
					chr3 = ( ( enc3 & 3 ) << 6 ) | enc4;

					output = output + String.fromCharCode( chr1 );

					if ( 64 != enc3 ) {
						output = output + String.fromCharCode( chr2 );
					}
					if ( 64 != enc4 ) {
						output = output + String.fromCharCode( chr3 );
					}

				}

				output = this.utf8Decode( output );

				return output;
			},

			utf8Decode: function( utftext ) {
				var string = '',
				    i  = 0,
				    c  = 0,
				    c1 = 0,
				    c2 = 0,
				    c3;

				while ( i < utftext.length ) {

					c = utftext.charCodeAt( i );

					if ( c < 128 ) {
						string += String.fromCharCode( c );
						i++;
					} else if ( ( c > 191 ) && ( c < 224 ) ) {
						c2 = utftext.charCodeAt( i + 1 );
						string += String.fromCharCode( ( ( c & 31 ) << 6 ) | ( c2 & 63 ) );
						i += 2;
					} else {
						c2 = utftext.charCodeAt( i + 1 );
						c3 = utftext.charCodeAt( i + 2 );
						string += String.fromCharCode( ( ( c & 15 ) << 12 ) | ( ( c2 & 63 ) << 6 ) | ( c3 & 63 ) );
						i += 3;
					}

				}

				return string;
			},

			fusionBuilderMCEremoveEditor: function( id ) {
				if ( 'undefined' !== typeof window.tinyMCE ) {
					window.tinyMCE.execCommand( 'mceRemoveEditor', false, id );
					if ( 'undefined' !== typeof window.tinyMCE.get( id ) ) {
						window.tinyMCE.remove( '#' + id );
					}
				}
			},

			fusion_builder_iconpicker: function( value, id, container, search ) {

				var icons  = fusionBuilderConfig.fontawesomeicons,
				    output = '';

				_.each( icons, function( icon ) {

					var selectedClass = '';

					if ( value == icon ) {
						selectedClass = 'selected-element';
					}

					output += '<span class="icon_preview icon-' + icon + ' ' + selectedClass + '"><i class="fa ' + icon + '" data-name="' + icon + '"></i></span>';
				} );

				$( container ).append( output );

				// Icon Search bar
				$( search ).on( 'change paste keyup', function() {
					var thisEl = $( this );

					FusionDelay( function() {
						if ( thisEl.val() ) {
							value = thisEl.val().toLowerCase();

							_.each( icons, function( icon ) {
								name = icon.toLowerCase();

								if ( name.search( value ) !== -1 ) {
									$( '.icon_select_container .icon-' + name ).show();
								} else {
									$( '.icon_select_container .icon-' + name ).hide();
								}
							} );

						} else {
							$( '.icon_select_container .icon_preview' ).show();
						}
					}, 500 );
				} );
			},

			fusionBuilderImagePreview: function( $uploadButton ) {
				var $uploadField = $uploadButton.siblings( '.fusion-builder-upload-field' ),
				    $preview     = $uploadField.siblings( '.fusion-builder-upload-preview' ),
				    $removeBtn   = $uploadButton.siblings( '.upload-image-remove' ),
				    imageURL     = $uploadField.val().trim(),
				    imagePreview;

				if ( 0 <= imageURL.indexOf( '<img' ) ) {
					imagePreview = imageURL;
				} else {
					imagePreview = '<img src="' + imageURL + '" />';
				}

				if ( 'image' !== $uploadButton.data( 'type' ) ) {
					return;
				}

				if ( '' === imageURL ) {
					if ( $preview.length ) {
						$preview.remove();
						$removeBtn.remove();
						$uploadButton.val( 'Upload Image' );
					}

					if ( $( '#image_id' ).length ) {
						$( '#image_id' ).val( '' );
					}

					return;
				}

				if ( ! $preview.length ) {
					$uploadButton.siblings( '.preview' ).before( '<div class="fusion-builder-upload-preview">' + '<strong class="fusion-builder-upload-preview-title">Preview</strong>' + '<div class="fusion-builder-preview-image"><img src="" width="300" height="300" /></div></div>' );
					$uploadButton.after( '<input type="button" class="upload-image-remove" value="Remove" />' );
					$uploadButton.val( 'Edit' );
					$preview = $uploadField.siblings( '.fusion-builder-upload-preview' );

				}

				$preview.find( 'img' ).replaceWith( imagePreview );
			},

			FusionBuilderActivateUpload: function( $uploadButton ) {
				$uploadButton.click( function( event ) {

					var $thisEl,
					    fileFrame;

					if ( event ) {
						event.preventDefault();
					}

					$thisEl = $( this );

					fileFrame = wp.media.frames.file_frame = wp.media({
						library: {
							type: $thisEl.data( 'type' )
						},
						title: $thisEl.data( 'title' ),
						multiple: false
					} );

					// Select currently active image automatically.
					fileFrame.on( 'open', function() {
						var selection = fileFrame.state().get( 'selection' ),
							id = $thisEl.parents( '.fusion-builder-module-settings' ).find( '#image_id' ).val(),
							attachment = wp.media.attachment( id );

						attachment.fetch();
						selection.add( attachment ? [ attachment ] : [] );
					});

					fileFrame.on( 'select insert', function() {
						var attachment = fileFrame.state().get( 'selection' ).first().toJSON();
						$thisEl.siblings( '.fusion-builder-upload-field' ).val( attachment.url ).trigger( 'change' );

						// Set image id.
						if ( $( '#image_id' ).length ) {
							$( '#image_id' ).val( attachment.id );
						}

						FusionPageBuilderApp.fusionBuilderImagePreview( $thisEl );
					} );

					fileFrame.open();

					return false;
				} );

				$uploadButton.siblings( '.fusion-builder-upload-field' ).on( 'input', function() {
					FusionPageBuilderApp.fusionBuilderImagePreview( $( this ).siblings( '.fusion-builder-upload-button' ) );
				} );

				$uploadButton.siblings( '.fusion-builder-upload-field' ).each( function() {
					FusionPageBuilderApp.fusionBuilderImagePreview( $( this ).siblings( '.fusion-builder-upload-button' ) );
				} );
			},

			fusionBuilderSetContent: function( textareaID, content ) {
				if ( 'undefined' !== typeof window.tinyMCE && window.tinyMCE.get( textareaID ) && ! window.tinyMCE.get( textareaID ).isHidden() ) {

					if ( window.tinyMCE.get( textareaID ).getParam( 'wpautop', true ) && 'undefined' !== typeof window.switchEditors ) {
						content = window.switchEditors.wpautop( content );
					}

					window.tinyMCE.get( textareaID ).setContent( content, { format: 'html' } );
				} else {
					$( '#' + textareaID ).val( content );
				}
			},

			layoutLoaded: function() {
				this.newLayoutLoaded = true;
			},

			clearLayout: function( event ) {

				var r;

				if ( event ) {
					event.preventDefault();
				}

				r = confirm( fusionBuilderText.are_you_sure_you_want_to_delete_this_layout );

				if ( false == r ) {
					return false;
				}

				this.blankPage = true;
				this.clearBuilderLayout( true );

				// Clear history
				fusionHistoryManager.clearEditor( 'blank' );

			},

			showHistoryDialog: function( event ) {
				if ( event ) {
					event.preventDefault();
				}
				this.$el.find( '.fusion-builder-history-list' ).show();
			},

			hideHistoryDialog: function( event ) {
				if ( event ) {
					event.preventDefault();
				}
				this.$el.find( '.fusion-builder-history-list' ).hide();
			},

			saveTemplateDialog: function( event ) {
				if ( event ) {
					event.preventDefault();
				}
				this.showLibrary();
				$( '#fusion-builder-layouts-templates-trigger' ).click();
			},

			loadPreBuiltPage: function( event ) {
				if ( event ) {
					event.preventDefault();
				}
				this.showLibrary();
				$( '#fusion-builder-layouts-demos-trigger' ).click();
			},

			saveLayout: function( event ) {

				var templateContent,
				    templateName,
				    layoutsContainer,
				    currentPostID,
				    emptyMessage,
				    customCSS,
				    pageTemplate,
				    $customFields = [],
				    $name,
				    $value;

				if ( event ) {
					event.preventDefault();
				}

				// Get custom field values for saving.
				jQuery( 'input[id^="pyre_"], select[id^="pyre_"]' ).each( function( n ) {
					$name = jQuery( this ).attr( 'id' );
					$value = jQuery( this ).val();
					if ( 'undefined' !== typeof $name && 'undefined' !== typeof $value ) {
						$customFields[n] = [$name, $value];
					}
				});

				templateContent  = fusionBuilderGetContent( 'content' );
				templateName     = $( '#new_template_name' ).val();
				layoutsContainer = $( '#fusion-builder-layouts-templates .fusion-page-layouts' );
				currentPostID    = $( '#fusion_builder_main_container' ).data( 'post-id' );
				emptyMessage     = $( '#fusion-builder-layouts-templates .fusion-page-layouts .fusion-empty-library-message' );
				customCSS = $( '#fusion-custom-css-field' ).val();
				pageTemplate = $( '#page_template' ).val();

				if ( '' !== templateName ) {

					$.ajax( {
						type: 'POST',
						url: fusionBuilderConfig.ajaxurl,
						dataType: 'json',
						data: {
							action: 'fusion_builder_save_layout',
							fusion_load_nonce: fusionBuilderConfig.fusion_load_nonce,
							fusion_layout_name: templateName,
							fusion_layout_content: templateContent,
							fusion_layout_post_type: 'fusion_template',
							fusion_current_post_id: currentPostID,
							fusion_custom_css: customCSS,
							fusion_page_template: pageTemplate,
							fusion_options: $customFields
						},
						complete: function( data ) {
							layoutsContainer.prepend( data.responseText );
							emptyMessage.hide();
						}
					} );

					$( '#new_template_name' ).val( '' );

				} else {
					alert( fusionBuilderText.please_enter_template_name );
				}
			},

			saveElement: function( event ) {
				var fusionElementType,
				    elementCID,
				    elementView;

				if ( event ) {
					event.preventDefault();
				}

				fusionElementType = $( event.currentTarget ).data( 'element-type' );
				elementCID        = $( event.currentTarget ).data( 'element-cid' );
				elementView       = FusionPageBuilderViewManager.getView( elementCID );

				elementView.saveElement();
			},

			loadLayout: function( event ) {
				var $layout,
				    contentPlacement,
				    content,
				    $customCSS;

				if ( event ) {
					event.preventDefault();
				}

				if ( true === this.layoutIsLoading ) {
					return;
				} else {
					this.layoutIsLoading = true;
				}

				$layout          = $( event.currentTarget ).closest( 'li' );
				contentPlacement = $( event.currentTarget ).data( 'load-type' );
				content          = fusionBuilderGetContent( 'content' );
				$customCSS       = jQuery( '#fusion-custom-css-field' ).val();

				$.ajax( {
					type: 'POST',
					url: fusionBuilderConfig.ajaxurl,
					data: {
						action: 'fusion_builder_load_layout',
						fusion_load_nonce: fusionBuilderConfig.fusion_load_nonce,
						fusion_layout_id: $layout.data( 'layout_id' )
					},
					beforeSend: function() {
						FusionPageBuilderEvents.trigger( 'fusion-show-loader' );

						$( 'body' ).removeClass( 'fusion_builder_inner_row_no_scroll' );
						$( '.fusion_builder_modal_inner_row_overlay' ).remove();
						$( '#fusion-builder-layouts' ).hide();

					},
					success: function( data ) {
						var dataObj;

						// New layout loaded
						FusionPageBuilderApp.layoutLoaded();

						dataObj = JSON.parse( data );

						if ( 'above' === contentPlacement ) {
							content = dataObj.post_content + content;

							// Set custom css above
							if ( 'undefined' !== typeof ( dataObj.custom_css ) ) {
								$( '#fusion-custom-css-field' ).val( dataObj.custom_css + '\n' + $customCSS );
							}

						} else if ( 'below' === contentPlacement ) {
							content = content + dataObj.post_content;

							// Set custom css below
							if ( 'undefined' !== typeof ( dataObj.custom_css ) ) {
								if ( $customCSS.length ) {
									$( '#fusion-custom-css-field' ).val( $customCSS + '\n' + dataObj.custom_css );
								} else {
									$( '#fusion-custom-css-field' ).val( dataObj.custom_css );
								}
							}

						} else {
							content = dataObj.post_content;

							// Set custom css.
							if ( 'undefined' !== typeof ( dataObj.custom_css ) ) {
								$( '#fusion-custom-css-field' ).val( dataObj.custom_css );
							}

							//  Set Fusion Option selection.
							jQuery.each( dataObj.post_meta, function( $name, $value ) {
								jQuery( '#' + $name ).val( $value ).trigger( 'change' );
							});
						}

						FusionPageBuilderApp.clearBuilderLayout();

						FusionPageBuilderApp.createBuilderLayout( content );

						// Set page template
						if ( 'undefined' !== typeof ( dataObj.page_template ) ) {
							$( '#page_template' ).val( dataObj.page_template );
						}

						FusionPageBuilderApp.layoutIsLoading = false;
					},
					complete: function() {
						FusionPageBuilderEvents.trigger( 'fusion-hide-loader' );
					}
				} );
			},

			loadDemoPage: function( event ) {
				var pageName,
				    demoName,
				    postId,
				    content,
				    r;

				if ( event ) {
					event.preventDefault();
				}

				r = confirm( fusionBuilderText.importing_single_page );

				if ( false == r ) {
					return false;
				}

				if ( true === this.layoutIsLoading ) {
					return;
				} else {
					this.layoutIsLoading = true;
				}

				pageName = $( event.currentTarget ).data( 'page-name' );
				demoName = $( event.currentTarget ).data( 'demo-name' );
				postId = $( event.currentTarget ).data( 'post-id' );

				$.ajax( {
					type: 'POST',
					url: fusionBuilderConfig.ajaxurl,
					data: {
						action: 'fusion_builder_load_demo',
						fusion_load_nonce: fusionBuilderConfig.fusion_load_nonce,
						page_name: pageName,
						demo_name: demoName,
						post_id: postId
					},
					beforeSend: function() {
						FusionPageBuilderEvents.trigger( 'fusion-show-loader' );

						$( 'body' ).removeClass( 'fusion_builder_inner_row_no_scroll' );
						$( '.fusion_builder_modal_inner_row_overlay' ).remove();
						$( '#fusion-builder-layouts' ).hide();

					},
					success: function( data ) {
						var dataObj,
						    meta;

						// New layout loaded
						FusionPageBuilderApp.layoutLoaded();

						dataObj = JSON.parse( data );

						content = dataObj.post_content;

						FusionPageBuilderApp.clearBuilderLayout( false );

						FusionPageBuilderApp.createBuilderLayout( content );

						// Set page template
						if ( 'undefined' !== typeof ( dataObj.page_template ) ) {
							$( '#page_template' ).val( dataObj.page_template );
						}

						meta = dataObj.meta;

						// Set page options
						_.each( meta, function( value, name ) {
							$( '#' + name ).val( value ).trigger( 'change' );
						});

						FusionPageBuilderApp.layoutIsLoading = false;
					},
					complete: function() {
						FusionPageBuilderEvents.trigger( 'fusion-hide-loader' );
					}
				} );
			},

			deleteLayout: function( event ) {

				var $layout,
				    r;

				if ( event ) {
					event.preventDefault();

					r = confirm( fusionBuilderText.are_you_sure_you_want_to_delete_this );

					if ( false == r ) {
						return false;
					}
				}

				if ( true === this.layoutIsDeleting ) {
					return;
				} else {
					this.layoutIsDeleting = true;
				}

				$layout = $( event.currentTarget ).closest( 'li' );

				$.ajax( {
					type: 'POST',
					url: fusionBuilderConfig.ajaxurl,
					data: {
						action: 'fusion_builder_delete_layout',
						fusion_load_nonce: fusionBuilderConfig.fusion_load_nonce,
						fusion_layout_id: $layout.data( 'layout_id' )
					},
					success: function( data ) {
						var $containerSuffix;
						if ( $layout.parents( '#fusion-builder-layouts-templates' ).length ) {
							$containerSuffix = 'templates';
						} else {
							$containerSuffix = 'elements';
						}

						$layout.remove();

						FusionPageBuilderApp.layoutIsDeleting = false;
						if ( ! $( '#fusion-builder-layouts-' + $containerSuffix + ' .fusion-page-layouts' ).find( 'li' ).length ) {
							$( '#fusion-builder-layouts-' + $containerSuffix + ' .fusion-page-layouts .fusion-empty-library-message' ).show();
						}
					}
				} );
			},

			openLibrary: function( event ) {
				if ( event ) {
					event.preventDefault();
				}
				this.showLibrary();
				$( '#fusion-builder-layouts-templates-trigger' ).click();
			},

			showLibrary: function( event ) {
				if ( event ) {
					event.preventDefault();
				}

				$( '#fusion-builder-layouts' ).show();
				$( 'body' ).addClass( 'fusion_builder_inner_row_no_scroll' ).append( '<div class="fusion_builder_modal_inner_row_overlay"></div>' );
			},

			hideLibrary: function( event ) {
				if ( event ) {
					event.preventDefault();
				}

				$( '#fusion-builder-layouts' ).hide();
				$( 'body' ).removeClass( 'fusion_builder_inner_row_no_scroll' );
				$( '.fusion_builder_modal_inner_row_overlay' ).remove();
				$( '.fusion-save-element-fields' ).remove();
			},

			showLoader: function() {
				$( '#fusion_builder_main_container' ).css( 'height', '148px' );
				$( '#fusion_builder_container' ).hide();
				$( '#fusion-loader' ).fadeIn( 'fast' );
			},

			hideLoader: function() {
				$( '#fusion_builder_container' ).fadeIn( 'fast' );
				$( '#fusion_builder_main_container' ).removeAttr( 'style' );
				$( '#fusion-loader' ).fadeOut( 'fast' );
			},

			sortableContainers: function() {
				this.$el.sortable( {
					handle: '.fusion-builder-section-header',
					items: '.fusion_builder_container',
					cancel: '.fusion-builder-section-name, .fusion-builder-settings, .fusion-builder-clone, .fusion-builder-remove, .fusion-builder-section-add, .fusion-builder-add-element, .fusion-builder-insert-column, #fusion_builder_controls, .fusion-builder-save-element',
					cursor: 'move',
					update: function( event, ui ) {
						fusionHistoryManager.turnOnTracking();
						fusionHistoryState = fusionBuilderText.moved_container;
						FusionPageBuilderEvents.trigger( 'fusion-element-sorted' );
					}
				} );
			},

			initialBuilderLayout: function( initialLoad ) {

				// Clear all views
				FusionPageBuilderViewManager.removeViews();

				FusionPageBuilderEvents.trigger( 'fusion-show-loader' );

				setTimeout( function() {

					var content                   = fusionBuilderGetContent( 'content', true, initialLoad ),
					    contentErrorMarkup        = '',
					    contentErrorMarkupWrapper = '',
					    contentErrorMarkupClone   = '';

					try {

						content = FusionPageBuilderApp.validateContent( content );

						FusionPageBuilderApp.createBuilderLayout( content );

						FusionPageBuilderEvents.trigger( 'fusion-hide-loader' );

					} catch ( error ) {
						console.log( error );
						FusionPageBuilderApp.fusionBuilderSetContent( 'content', content );
						jQuery( '#fusion_toggle_builder' ).trigger( 'click' );

						contentErrorMarkup = FusionPageBuilderApp.$el.find( '#content-error' );
						contentErrorMarkupWrapper = FusionPageBuilderApp.$el;
						contentErrorMarkupClone = contentErrorMarkup.clone();

						contentErrorMarkup.dialog({
							dialogClass: 'fusion-builder-dialog',
							autoOpen: false,
							modal: true,
							buttons: {
								OK: function() {
									jQuery( this ).dialog( 'close' );
								}
							},
							close: function() {
								contentErrorMarkupWrapper.append( contentErrorMarkupClone );
							}
						});

						contentErrorMarkup.dialog( 'open' );
					}

				}, 50 );
			},

			validateContent: function( content ) {
				var contentIsEmpty      = '' == content,
				    container           = '',
				    column              = '',
				    textNodes           = '',
				    innerColumnsContent = '',
				    columns             = [],
				    containers          = [],
				    shortcodeTags,
				    columnwrapped,
				    insertionFlag;

				// Throw exception with the fullwidth shortcode.
				if ( -1 !== content.indexOf( '[fullwidth' ) ) {
					throw 'Avada 4.0.3 or earlier fullwidth container used!';
				}

				if ( ! contentIsEmpty ) {

					// Fixes [fusion_text /] instances, which were created in 5.0.1 for empty text blocks.
					content = content.replace( /\[fusion\_text \/\]/g, '[fusion_text][/fusion_text]' ).replace(  /\[\/fusion\_text\]\[\/fusion\_text\]/g, '[/fusion_text]' );

					content = content.replace( /\$\$/g, '&#36;&#36;' );
					textNodes = content;

					// Add container if missing.
					textNodes = wp.shortcode.replace( 'fusion_builder_container', textNodes, function( tag ) {
						return '|';
					});
					textNodes = textNodes.trim().split( '|' );

					_.each( textNodes, function( textNodes ) {
						if ( '' !== textNodes.trim() ) {
							content = content.replace( textNodes, '[fusion_builder_container hundred_percent="no" equal_height_columns="no" menu_anchor="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" background_color="" background_image="" background_position="center center" background_repeat="no-repeat" fade="no" background_parallax="none" parallax_speed="0.3" video_mp4="" video_webm="" video_ogv="" video_url="" video_aspect_ratio="16:9" video_loop="yes" video_mute="yes" overlay_color="" overlay_opacity="0.5" video_preview_image="" border_size="" border_color="" border_style="solid" padding_top="" padding_bottom="" padding_left="" padding_right=""][fusion_builder_row]' + textNodes + '[/fusion_builder_row][/fusion_builder_container]' );
						}
					});

					textNodes = wp.shortcode.replace( 'fusion_builder_container', content, function( tag ) {
						containers.push( tag.content );
					});

					_.each( containers, function( textNodes ) {

						// Add column if missing.
						textNodes = wp.shortcode.replace( 'fusion_builder_row', textNodes, function( tag ) {
							return tag.content;
						});

						textNodes = wp.shortcode.replace( 'fusion_builder_column', textNodes, function( tag ) {
							return '|';
						});

						textNodes = textNodes.trim().split( '|' );
						_.each( textNodes, function( textNodes ) {
							if ( '' !== textNodes.trim() && '[fusion_builder_row][/fusion_builder_row]' !== textNodes.trim() ) {
								columnwrapped = '[fusion_builder_column type="1_1" background_position="left top" background_color="" border_size="" border_color="" border_style="solid" border_position="all" spacing="yes" background_image="" background_repeat="no-repeat" padding="" margin_top="0px" margin_bottom="0px" class="" id="" animation_type="" animation_speed="0.3" animation_direction="left" hide_on_mobile="small-visibility,medium-visibility,large-visibility" center_content="no" last="no" min_height="" hover_type="none" link=""]' + textNodes + '[/fusion_builder_column]';
								content = content.replace( textNodes, columnwrapped );

							}
						});
					});

					textNodes = wp.shortcode.replace( 'fusion_builder_column_inner', content, function( tag ) {
						columns.push( tag.content );
					});
					textNodes = wp.shortcode.replace( 'fusion_builder_column', content, function( tag ) {
						columns.push( tag.content );
					});
					_.each( columns, function( textNodes ) {

						// Wrap non fusion elements.
						shortcodeTags = fusionAllElements;
						_.each( shortcodeTags, function( shortcode ) {
							if ( 'undefined' === typeof shortcode.generator_only ) {
								textNodes = wp.shortcode.replace( shortcode.shortcode, textNodes, function( tag ) {
									return '|';
								} );
							}
						});

						textNodes = textNodes.trim().split( '|' );
						_.each( textNodes, function( textNodes ) {
							if ( '' !== textNodes.trim() ) {
								insertionFlag = '@=%~@';
								if ( '@' === textNodes.slice( -1 ) ) {
									insertionFlag = '#=%~#';
								}
								content = content.replace( textNodes, '[fusion_text]' + textNodes.slice( 0, -1 ) + insertionFlag + textNodes.slice( -1 ) + '[/fusion_text]' );
							}
						});
					});
					content = content.replace( /@=%~@/g, '' ).replace( /#=%~#/g, '' );

					// Check for once deactivated elements in text blocks that are active again.
					content = wp.shortcode.replace( 'fusion_text', content, function( tag ) {
						shortcodeTags = fusionAllElements;
						textNodes = tag.content;
						_.each( shortcodeTags, function( shortcode ) {
							if ( 'undefined' === typeof shortcode.generator_only ) {
								textNodes = wp.shortcode.replace( shortcode.shortcode, textNodes, function( tag ) {
									return '|';
								} );
							}
						});
						if ( ! textNodes.replace( /\|/g, '' ).length ) {
							return tag.content;
						}
					});
				}

				function replaceDollars( match ) {
					return '$$';
				}

				content = content.replace( /&#36;&#36;/g, replaceDollars );

				return content;
			},

			clearBuilderLayout: function( blankPageLayout ) {

				// Remove blank page layout
				this.$el.find( '.fusion-builder-blank-page-content' ).each( function() {
					var
					$that = $( this ),
					thisView = FusionPageBuilderViewManager.getView( $that.data( 'cid' ) );

					if ( 'undefined' !== typeof thisView ) {
						thisView.removeBlankPageHelper();
					}
				} );

				// Remove all containers
				this.$el.find( '.fusion-builder-section-content' ).each( function() {
					var
					$that = $( this ),
					thisView = FusionPageBuilderViewManager.getView( $that.data( 'cid' ) );

					if ( 'undefined' !== typeof thisView ) {
						thisView.removeContainer();
					}
				} );

				// Create blank page layout
				if ( blankPageLayout ) {

					if ( true === this.blankPage ) {
						if ( ! this.$el.find( '.fusion-builder-blank-page-content' ).length ) {
							this.createBuilderLayout( '[fusion_builder_blank_page][/fusion_builder_blank_page]' );
						}

						this.blankPage = false;
					}

				}

			},

			createBuilderLayout: function( content ) {
				this.shortcodesToBuilder( content );
				this.builderToShortcodes();
			},

			shortcodesToBuilder: function( content, parentCID ) {
				var thisEl,
				    regExp,
				    innerRegExp,
				    matches,
				    shortcodeTags;

				// Show blank page layout
				if ( '' === content && ! this.$el.find( '.fusion-builder-blank-page-content' ).length ) {
					this.createBuilderLayout( '[fusion_builder_blank_page][/fusion_builder_blank_page]' );

					return;
				}

				thisEl        = this;
				shortcodeTags = _.keys( fusionAllElements ).join( '|' );
				regExp        = window.wp.shortcode.regexp( shortcodeTags );
				innerRegExp   = this.regExpShortcode( shortcodeTags );
				matches       = content.match( regExp );

				_.each( matches, function( shortcode ) {

					var shortcodeElement    = shortcode.match( innerRegExp ),
					    shortcodeName       = shortcodeElement[2],
					    shortcodeAttributes = '' !== shortcodeElement[3] ? window.wp.shortcode.attrs( shortcodeElement[3] ) : '',
					    shortcodeContent    = shortcodeElement[5],
					    elementCID           = FusionPageBuilderViewManager.generateCid(),
					    prefixedAttributes  = { params: ({}) },
					    elementSettings,
					    key,
					    prefixedKey,
					    dependencyOption,
					    dependencyOptionValue,
					    elementContent,

						// Check for shortcodes inside shortcode content
						shortcodesInContent = 'undefined' !== typeof shortcodeContent && '' !== shortcodeContent && shortcodeContent.match( regExp ),

						// Check if shortcode allows generator
						allowGenerator = 'undefined' !== typeof fusionAllElements[ shortcodeName ].allow_generator ? fusionAllElements[ shortcodeName ].allow_generator : '';

					elementSettings = {
						type: shortcodeName,
						element_type: shortcodeName,
						cid: elementCID,
						created: 'manually',
						multi: '',
						params: {},
						allow_generator: allowGenerator
					};

					if ( 'fusion_builder_container' !== shortcodeName ) {
						elementSettings.parent = parentCID;
					}

					if ( 'fusion_builder_container' !== shortcodeName && 'fusion_builder_row' !== shortcodeName && 'fusion_builder_column' !== shortcodeName && 'fusion_builder_column_inner' !== shortcodeName && 'fusion_builder_row_inner' !== shortcodeName  && 'fusion_builder_blank_page' !== shortcodeName ) {

						if ( -1 !== shortcodeName.indexOf( 'fusion_' ) ||
							 -1 !== shortcodeName.indexOf( 'layerslider' ) ||
							 -1 !== shortcodeName.indexOf( 'rev_slider' ) ) {
							elementSettings.type = 'element';
						}
					}

					if ( _.isObject( shortcodeAttributes.named ) ) {
						for ( key in shortcodeAttributes.named ) {

							prefixedKey = key;
							if ( ( 'fusion_builder_column' === shortcodeName || 'fusion_builder_column_inner' === shortcodeName ) && 'type' === prefixedKey ) {
								prefixedKey = 'layout';

								prefixedAttributes[ prefixedKey ] = shortcodeAttributes.named[ key ];
							}

							prefixedAttributes.params[ prefixedKey ] = shortcodeAttributes.named[ key ];
							if ( 'gradient_colors' === key ) {
								delete prefixedAttributes.params[ prefixedKey ];
								if ( -1 !== shortcodeAttributes.named[ key ].indexOf( '|' ) ) {
									prefixedAttributes.params.button_gradient_top_color = shortcodeAttributes.named[ key ].split( '|' )[0].replace( 'transparent', 'rgba(255,255,255,0)' );
									prefixedAttributes.params.button_gradient_bottom_color = shortcodeAttributes.named[ key ].split( '|' )[1] ? shortcodeAttributes.named[ key ].split( '|' )[1].replace( 'transparent', 'rgba(255,255,255,0)' ) : shortcodeAttributes.named[ key ].split( '|' )[0].replace( 'transparent', 'rgba(255,255,255,0)' );
								} else {
									prefixedAttributes.params.button_gradient_bottom_color = prefixedAttributes.params.button_gradient_top_color = shortcodeAttributes.named[ key ].replace( 'transparent', 'rgba(255,255,255,0)' );
								}
							}
							if ( 'gradient_hover_colors' === key ) {
								delete prefixedAttributes.params[ prefixedKey ];
								if ( -1 !== shortcodeAttributes.named[ key ].indexOf( '|' ) ) {
									prefixedAttributes.params.button_gradient_top_color_hover = shortcodeAttributes.named[ key ].split( '|' )[0].replace( 'transparent', 'rgba(255,255,255,0)' );
									prefixedAttributes.params.button_gradient_bottom_color_hover = shortcodeAttributes.named[ key ].split( '|' )[1] ? shortcodeAttributes.named[ key ].split( '|' )[1].replace( 'transparent', 'rgba(255,255,255,0)' ) : shortcodeAttributes.named[ key ].split( '|' )[0].replace( 'transparent', 'rgba(255,255,255,0)' );
								} else {
									prefixedAttributes.params.button_gradient_bottom_color_hover = prefixedAttributes.params.button_gradient_top_color_hover = shortcodeAttributes.named[ key ].replace( 'transparent', 'rgba(255,255,255,0)' );
								}
							}
						}

						elementSettings = _.extend( elementSettings, prefixedAttributes );
					}

					if ( ! shortcodesInContent ) {
						elementSettings.params.element_content = shortcodeContent;
					}

					// Compare shortcode name to multi elements object / array
					if ( shortcodeName in fusionMultiElements ) {
						elementSettings.multi = 'multi_element_parent';
					}

					// Set content for elements with dependency options
					if ( 'undefined' !== typeof fusionAllElements[ shortcodeName ].option_dependency ) {

						dependencyOption      = fusionAllElements[ shortcodeName ].option_dependency;
						dependencyOptionValue = prefixedAttributes.params[ dependencyOption ];
						elementContent         = prefixedAttributes.params.element_content;
						prefixedAttributes.params[ dependencyOptionValue ] = elementContent;
					}

					if ( shortcodesInContent ) {
						if ( 'fusion_builder_container' !== shortcodeName && 'fusion_builder_row' !== shortcodeName && 'fusion_builder_row_inner' !== shortcodeName && 'fusion_builder_column' !== shortcodeName && 'fusion_builder_column_inner' !== shortcodeName ) {
							elementSettings.params.element_content = shortcodeContent;
						}
					}

					thisEl.collection.add( [ elementSettings ] );

					if ( shortcodesInContent ) {

						if ( 'fusion_builder_container' == shortcodeName || 'fusion_builder_row' == shortcodeName || 'fusion_builder_row_inner' == shortcodeName || 'fusion_builder_column' == shortcodeName || 'fusion_builder_column_inner' == shortcodeName ) {
							thisEl.shortcodesToBuilder( shortcodeContent, elementCID );
						}
					}

				} );
			},

			addBuilderElement: function( element ) {

				var view,
				    modalView,
				    viewSettings = {
						model: element,
						collection: FusionPageBuilderElements
				    },
				    parentModel,
				    elementType,
				    previewView;

				switch ( element.get( 'type' ) ) {

					case 'fusion_builder_blank_page':

						view = new FusionPageBuilder.BlankPageView( viewSettings );

						FusionPageBuilderViewManager.addView( element.get( 'cid' ), view );

						if ( ! _.isUndefined( element.get( 'view' ) ) ) {
							element.get( 'view' ).$el.after( view.render().el );

						} else {
							this.$el.find( '#fusion_builder_container' ).append( view.render().el );
						}

						break;

					case 'fusion_builder_container':

						// Check custom container position
						if ( '' !== FusionPageBuilderApp.targetContainerCID ) {
							element.attributes.view = FusionPageBuilderViewManager.getView( FusionPageBuilderApp.targetContainerCID );

							FusionPageBuilderApp.targetContainerCID = '';
						}

						view = new FusionPageBuilder.ContainerView( viewSettings );

						FusionPageBuilderViewManager.addView( element.get( 'cid' ), view );

						if ( ! _.isUndefined( element.get( 'view' ) ) ) {
							element.get( 'view' ).$el.after( view.render().el );

						} else {
							this.$el.find( '#fusion_builder_container' ).append( view.render().el );
							this.$el.find( '.fusion_builder_blank_page' ).remove();
						}

						// Add row if needed
						if ( 'manually' !== element.get( 'created' ) ) {
							view.addRow();
						}

						break;

					case 'fusion_builder_row':

						view = new FusionPageBuilder.RowView( viewSettings );

						FusionPageBuilderViewManager.addView( element.get( 'cid' ), view );

						if ( FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '.fusion-builder-section-content' ).length ) {
							FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '.fusion-builder-section-content' ).append( view.render().el );

						} else {
							FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '> .fusion-builder-add-element' ).hide().end().append( view.render().el );
						}

						// Add parent view to inner rows that have been converted from shortcodes
						if ( 'manually' === element.get( 'created' ) && 'row_inner' === element.get( 'element_type' ) ) {
							element.set( 'view', FusionPageBuilderViewManager.getView( element.get( 'parent' ) ), { silent: true } );
						}

						break;

					case 'fusion_builder_row_inner':

						view = new FusionPageBuilder.InnerRowView( viewSettings );

						FusionPageBuilderViewManager.addView( element.get( 'cid' ), view );

						if ( ! _.isUndefined( element.get( 'appendAfter' ) ) ) {
							element.get( 'appendAfter' ).after( view.render().el );
							element.unset( 'appendAfter' );

						} else {

							if ( FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '.fusion-builder-section-content' ).length ) {
								FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '.fusion-builder-section-content' ).append( view.render().el );

							} else {
								FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '> .fusion-builder-add-element' ).before( view.render().el );
							}
						}

						// Add parent view to inner rows that have been converted from shortcodes
						if ( 'manually' === element.get( 'created' ) && 'row_inner' === element.get( 'element_type' ) ) {
							element.set( 'view', FusionPageBuilderViewManager.getView( element.get( 'parent' ) ), { silent: true } );
						}

						break;

					case 'fusion_builder_column':

						if ( element.get( 'layout' ) ) {
							viewSettings.className = 'fusion-builder-column fusion-builder-column-outer fusion-builder-column-' + element.get( 'layout' );
							view = new FusionPageBuilder.ColumnView( viewSettings );

							FusionPageBuilderViewManager.addView( element.get( 'cid' ), view );

							if ( ! _.isUndefined( element.get( 'targetElement' ) ) && 'undefined' === typeof element.get( 'from' ) ) {
								element.get( 'targetElement' ).after( view.render().el );
							} else {
								FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '.fusion-builder-row-container' ).append( view.render().el );
							}
						}
						break;

					case 'fusion_builder_column_inner':

						viewSettings.className = 'fusion-builder-column fusion-builder-column-inner fusion-builder-column-' + element.get( 'layout' );

						view = new FusionPageBuilder.NestedColumnView( viewSettings );

						FusionPageBuilderViewManager.addView( element.get( 'cid' ), view );

						FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '.fusion-builder-row-container-inner' ).append( view.render().el );

						break;

					case 'element':

						viewSettings.attributes = {
							'data-cid': element.get( 'cid' )
						};

						// Multi element child
						if ( 'undefined' !== typeof element.get( 'multi' ) && 'multi_element_child' === element.get( 'multi' ) ) {

							view = new FusionPageBuilder.MultiElementSortableChild( viewSettings );

							element.attributes.view.child_views.push( view );

							FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '.fusion-builder-sortable-options' ).append( view.render().el );

							FusionPageBuilderViewManager.addView( element.get( 'cid' ), view );

						// Standard element
						} else {

							FusionPageBuilderEvents.trigger( 'fusion-remove-modal-view' );

							view = new FusionPageBuilder.ElementView( viewSettings );

							// Get element parent
							parentModel = this.collection.find( function( model ) {
								return model.get( 'cid' ) == element.get( 'parent' );
							} );

							// Add element builder view to proper column
							if (  'undefined' !== typeof parentModel && 'fusion_builder_column_inner' === parentModel.get( 'type' ) ) {

								if ( ! _.isUndefined( element.get( 'targetElement' ) ) && 'undefined' === typeof element.get( 'from' ) ) {
										element.get( 'targetElement' ).after( view.render().el );
								} else {
									FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '.fusion-builder-add-element' ).before( view.render().el );
								}

							} else {

								if ( ! _.isUndefined( element.get( 'targetElement' ) ) && 'undefined' === typeof element.get( 'from' ) ) {
									element.get( 'targetElement' ).after( view.render().el );
								} else {
									FusionPageBuilderViewManager.getView( element.get( 'parent' ) ).$el.find( '.fusion-builder-add-element:not(.fusion-builder-column-inner .fusion-builder-add-element)' ).before( view.render().el );
								}
							}

							FusionPageBuilderViewManager.addView( element.get( 'cid' ), view );

							// Check if element was added manually
							if ( 'manually' == element.get( 'added' ) ) {

								viewSettings.attributes = {
									'data-modal_view': 'element_settings'
								};

								view = new FusionPageBuilder.ModalView( viewSettings );

								$( 'body' ).append( view.render().el );

							// Generate element preview
							} else {

								elementType = element.get( 'element_type' );

								if ( 'undefined' !== typeof fusionAllElements[ elementType ].preview ) {

									previewView = new FusionPageBuilder.ElementPreviewView( viewSettings );
									view.$el.find( '.fusion-builder-module-preview' ).append( previewView.render().el );
								}
							}
						}

						break;

					case 'generated_element':

						FusionPageBuilderEvents.trigger( 'fusion-remove-modal-view' );

						// Ignore modals for columns inserted with generator
						if ( 'fusion_builder_column_inner' !== element.get( 'element_type' ) && 'fusion_builder_column' !== element.get( 'element_type' ) ) {

							viewSettings.attributes = {
								'data-modal_view': 'element_settings'
							};
							view = new FusionPageBuilder.ModalView( viewSettings );
							$( 'body' ).append( view.render().el );

						}

						break;

				}
			},

			regExpShortcode: _.memoize( function( tag ) {
				return new RegExp( '\\[(\\[?)(' + tag + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)' );
			} ),

			findShortcodeMatches: function( content, match ) {

				var shortcodeMatches,
				    shortcodeRegExp,
				    shortcodeInnerRegExp;

				if ( _.isObject( content ) ) {
					content = content.value;
				}

				shortcodeMatches     = '';
				content              = 'undefined' !== typeof content ? content : '';
				shortcodeRegExp      = window.wp.shortcode.regexp( match );
				shortcodeInnerRegExp = new RegExp( '\\[(\\[?)(' + match + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)' );

				if ( 'undefined' !== typeof content && '' !== content ) {
					shortcodeMatches = content.match( shortcodeRegExp );
				}

				return shortcodeMatches;
			},

			builderToShortcodes: function() {

				var shortcode = '',
				    thisEl    = this;

				this.$el.find( '.fusion_builder_container' ).each( function() {

					var $thisContainer = $( this ).find( '.fusion-builder-section-content' );

					shortcode += thisEl.generateElementShortcode( $( this ), true );

					$thisContainer.find( '.fusion_builder_row' ).each( function() {

						var $thisRow = $( this );

						shortcode += '[fusion_builder_row]';

						$thisRow.find( '.fusion-builder-column-outer' ).each( function() {
							var
							$thisColumn = $( this ),
							columnCID   = $thisColumn.data( 'cid' ),
							columnView  = FusionPageBuilderViewManager.getView( columnCID );

							shortcode += columnView.getColumnContent( $thisColumn );

						} );

						shortcode += '[/fusion_builder_row]';

					} );

					shortcode += '[/fusion_builder_container]';

				} );

				setTimeout( function() {

					FusionPageBuilderApp.fusionBuilderSetContent( 'content', shortcode );
					FusionPageBuilderEvents.trigger( 'fusion-save-history-state' );

				}, 500 );

			},

			saveHistoryState: function() {

				if ( true === this.newLayoutLoaded ) {
					fusionHistoryManager.clearEditor();
					this.newLayoutLoaded = false;
				}

				fusionHistoryManager.captureEditor();
				fusionHistoryManager.turnOffTracking();
			},

			generateElementShortcode: function( $element, openTagOnly, generator ) {
				var attributes = '',
				    content    = '',
				    element,
				    $thisElement,
				    elementCID,
				    elementType,
				    elementSettings = '',
				    shortcode,
				    ignoredAtts,
				    optionDependency,
				    optionDependencyValue,
				    key,
				    setting,
				    settingName,
				    settingValue,
				    param,
				    keyName,
				    optionValue,
				    ignored,
				    paramDependency,
				    paramDependencyElement,
				    paramDependencyValue;

				// Check if added from Shortcode Generator
				if ( true === generator ) {
					element = $element;
				} else {
					$thisElement = $element;

					// Get cid from html element
					elementCID = 'undefined' === typeof $thisElement.data( 'cid' ) ? $thisElement.find( '.fusion-builder-data-cid' ).data( 'cid' ) : $thisElement.data( 'cid' ),

					// Get model by cid
					element = FusionPageBuilderElements.find( function( model ) {
						return model.get( 'cid' ) == elementCID;
					} );
				}

				elementType     = 'undefined' !== typeof element ? element.get( 'element_type' ) : 'undefined';
				elementSettings = '';
				shortcode      = '';
				elementSettings = element.attributes;

				// Ignored shortcode attributes
				ignoredAtts = 'undefined' !== typeof fusionAllElements[ elementType ].remove_from_atts ? fusionAllElements[ elementType ].remove_from_atts : '';
				ignoredAtts.push( 'undefined' );

				// Option dependency
				optionDependency = 'undefined' !== typeof( fusionAllElements[ elementType ].option_dependency ) ? fusionAllElements[ elementType ].option_dependency : '';

				for ( key in elementSettings ) {

					settingName = key;

					if ( 'params' !== settingName ) {
						continue;
					}

					settingValue = 'undefined' !== typeof element.get( settingName ) ? element.get( settingName ) : '';

					if ( 'params' === settingName ) {

						// Loop over params
						for ( param in settingValue ) {

							keyName = param;

							if ( 'element_content' === keyName ) {

								optionValue = 'undefined' !== typeof( settingValue[ param ] ) ? settingValue[ param ] : '';

								content = optionValue;

								if ( 'undefined' !== typeof settingValue[ optionDependency ] ) {
									optionDependency = fusionAllElements[ elementType ].option_dependency;
									optionDependencyValue = 'undefined' !== typeof( settingValue[ optionDependency ] ) ? settingValue[ optionDependency ] : '';

									// Set content
									content = settingValue[ optionDependencyValue ];
								}

							} else {

								ignored = '';

								if ( '' !== optionDependency ) {

									setting = keyName;

									// Get option dependency value ( value for type )
									optionDependencyValue = 'undefined' !== typeof ( settingValue[ optionDependency ] ) ? settingValue[ optionDependency ] : '';

									// Check for old fusion_map array structure
									if ( 'undefined' !== typeof  fusionAllElements[ elementType ].params[ setting ] ) {

										// Dependency exists
										if ( 'undefined' !== typeof ( fusionAllElements[ elementType ].params[ setting ].dependency ) ) {

											paramDependency = fusionAllElements[ elementType ].params[setting].dependency;

											paramDependencyElement = 'undefined' !== typeof ( paramDependency.element ) ? paramDependency.element : '';

											paramDependencyValue = 'undefined' !== typeof ( paramDependency.value ) ? paramDependency.value : '';

											if ( paramDependencyElement === optionDependency ) {

												if ( paramDependencyValue !== optionDependencyValue ) {

													ignored = '';
													ignored = setting;

												}
											}
										}
									}
								}

								// Ignore shortcode attributes tagged with "remove_from_atts"
								if ( $.inArray( param, ignoredAtts ) > -1 || ignored === param ) {

									// This attribute should be ignored from the shortcode

								} else {

									optionValue = 'undefined' !== typeof settingValue[ param ] ? settingValue[ param ] : '';

									// Check if attribute value is null
									if ( null === optionValue ) {
										optionValue = '';
									}

									attributes += ' ' + param + '="' + optionValue + '"';
								}
							}
						}

					} else if ( '' !== settingValue ) {
						attributes += ' ' + settingName + '="' + settingValue + '"';
					}
				}

				shortcode = '[' + elementType + attributes;

				if ( '' === content && 'fusion_text' !== elementType && 'fusion_code' !== elementType && ( 'undefined' !== typeof elementSettings.type && 'element' === elementSettings.type ) ) {
					openTagOnly = true;
					shortcode += ' /]';
				} else {
					shortcode += ']';
				}

				if ( ! openTagOnly ) {
					shortcode += content + '[/' + elementType + ']';
				}

				return shortcode;
			},

			customCSS: function( event ) {
				if ( event ) {
					event.preventDefault();
				}

				$( '.fusion-custom-css' ).slideToggle();
			},

			toggleAllContainers: function( event ) {

				var toggleButton;

				if ( event ) {
					event.preventDefault();
				}

				toggleButton = $( '.fusion-builder-layout-buttons-toggle-containers' ).find( 'span' );

				if ( toggleButton.hasClass( 'dashicons-arrow-up' ) ) {
					toggleButton.removeClass( 'dashicons-arrow-up' ).addClass( 'dashicons-arrow-down' );

					$( '.fusion-builder-section-content' ).hide();
					$( '.fusion-builder-settings-container, .fusion-builder-clone-container, .fusion-builder-remove, .fusion-builder-save-element' ).hide();
					$( '.fusion-builder-toggle' ).find( 'span' ).removeClass( 'dashicons-arrow-up' ).addClass( 'dashicons-arrow-down' );

				} else {
					toggleButton.addClass( 'dashicons-arrow-up' ).removeClass( 'dashicons-arrow-down' );
					$( '.fusion-builder-section-content' ).show();
					$( '.fusion-builder-settings-container, .fusion-builder-clone-container, .fusion-builder-remove, .fusion-builder-save-element' ).show();
					$( '.fusion-builder-toggle' ).find( 'span' ).addClass( 'dashicons-arrow-up' ).removeClass( 'dashicons-arrow-down' );
				}
			},

			showSavedElements: function( elementType, container ) {

				var data = jQuery( '#fusion-builder-layouts-' + elementType ).find( '.fusion-page-layouts' ).clone(),
				    postId;
				data.find( 'li' ).each( function() {
					postId = jQuery( this ).find( '.fusion-builder-demo-button-load' ).attr( 'data-post-id' );
					jQuery( this ).find( '.fusion-layout-buttons' ).remove();
					jQuery( this ).find( 'h4' ).attr( 'class', 'fusion_module_title' );
					jQuery( this ).attr( 'data-layout_id', postId );
					jQuery( this ).addClass( 'fusion_builder_custom_' + elementType + '_load' );
					if ( '' !== jQuery( this ).attr( 'data-layout_type' ) ) {
						jQuery( this ).addClass( 'fusion-element-type-' + jQuery( this ).attr( 'data-layout_type' ) );
					}
				} );
				container.append( '<div id="fusion-loader"><span class="fusion-builder-loader"></span></div>' );
				container.append( '<ul class="fusion-builder-all-modules">' + data.html() + '</div>' );
			},

			rangeOptionPreview: function( view ) {
				 view.find( '.fusion-range-option' ).each( function() {
					$( this ).next().html( $( this ).val() );
					$( this ).on( 'change mousemove', function() {
						$( this ).next().html( $( this ).val() );
					} );
				} );
			},

			checkOptionDependency: function( view, thisEl, parentValues ) {
				var
					$dependencies = {},
					$currentVal,
					$dependencyIds = '',
					$currentId,
					$optionId,
					$passed,
					$passedArray,
					dividerType,
					upAndDown,
					centerOption;

				function doesTestPass( current, comparison, operator ) {
					$passed = false;
					if ( '==' == operator && current == comparison ) {
						$passed = true;
					}
					if ( '!=' == operator && current != comparison ) {
						$passed = true;
					}
					if ( '>' == operator && current > comparison ) {
						$passed = true;
					}
					if ( '<' == operator && current < comparison ) {
						$passed = true;
					}
					return $passed;
				}

				// Special check for section separator.
				if ( 'undefined' !== typeof view.shortcode && 'fusion_section_separator' === view.shortcode ) {
					dividerType = thisEl.find( '#divider_type' );
					upAndDown = dividerType.parents( 'ul' ).find( 'li[data-option-id="divider_candy"]' ).find( '.divider_candy' ).find( '.ui-button[data-value="bottom,top"]' );
					centerOption = dividerType.parents( 'ul' ).find( 'li[data-option-id="divider_position"]' ).find( '.divider_position' ).find( '.ui-button[data-value="center"]' );

					if ( 'triangle' !== dividerType.val() ) {
						upAndDown.hide();
					} else {
						upAndDown.show();
					}

					if ( 'bigtriangle' !== dividerType.val() ) {
						centerOption.hide();
					} else {
						centerOption.show();
					}

					dividerType.on( 'change paste keyup', function() {

						if ( 'triangle' !== jQuery( this ).val() ) {
							upAndDown.hide();
						} else {
							upAndDown.show();
						}

						if ( 'bigtriangle' !== jQuery( this ).val() ) {
							centerOption.hide();
							if ( centerOption.hasClass( 'ui-state-active' ) ) {
								centerOption.prev().click();
							}
						} else {
							centerOption.show();
						}

					});
				}

				// Initial checks and create helper objects.
				jQuery.each( view.params, function( index, value ) {
					if ( 'undefined' !== typeof value.dependency ) {
						$optionId = index;
						$passedArray = [];

						// Check each dependency for this option
						jQuery.each( value.dependency, function( index, dependency ) {

							// Create IDs of fields to check for.
							if ( 0 > $dependencyIds.indexOf( '#' + dependency.element ) ) {
								$dependencyIds += ', #' + dependency.element;
							}

							// If option has dependency add to check array.
							if ( 'undefined' == typeof $dependencies[dependency.element] ) {
								$dependencies[dependency.element] = [ { option: $optionId, or: value.or } ];
							} else {
								$dependencies[dependency.element].push( { option: $optionId, or: value.or } );
							}

							// If parentValues is an object and this is a parent dependency, then we should take value from there.
							if ( 'parent_' === dependency.element.substring( 0, 7 ) ) {
								if ( 'object' === typeof parentValues && parentValues[ dependency.element.replace( dependency.element.substring( 0, 7 ), '' ) ] ) {
									$currentVal = parentValues[ dependency.element.replace( dependency.element.substring( 0, 7 ), '' ) ];
								} else {
									$currentVal = '';
								}
							} else {
								$currentVal = thisEl.find( '#' + dependency.element ).val();
							}
							$passedArray.push( doesTestPass( $currentVal, dependency.value, dependency.operator ) );
						});

						// Check if it passes for regular "and" test.
						if ( -1 === $.inArray( false, $passedArray ) && 'undefined' === typeof value.or ) {
							thisEl.find( '#' + index ).parents( '.fusion-builder-option' ).fadeIn( 300 );

						// Check if it passes "or" test.
						} else if (  -1 !== $.inArray( true, $passedArray ) && 'undefined' !== typeof value.or ) {
							thisEl.find( '#' + index ).parents( '.fusion-builder-option' ).fadeIn( 300 );

						// If it fails.
						} else {
							thisEl.find( '#' + index ).parents( '.fusion-builder-option' ).hide();
						}
					}
				});

				// Listen for changes to options which other are dependent on.
				if ( $dependencyIds.length ) {
					thisEl.on( 'change paste keyup', $dependencyIds.substring( 2 ), function() {
						$currentId    = jQuery( this ).attr( 'id' );

						// Loop through each option id that is dependent on this option.
						jQuery.each( $dependencies[ $currentId ], function( index, value ) {
							$passedArray = [];

							// Check each dependency for that id.
							jQuery.each( view.params[value.option].dependency, function( index, dependency ) {

								// If parentValues is an object and this is a parent dependency, then we should take value from there.
								if ( 'parent_' === dependency.element.substring( 0, 7 ) ) {
									if ( 'object' === typeof parentValues && parentValues[ dependency.element.replace( dependency.element.substring( 0, 7 ), '' ) ] ) {
										$currentVal = parentValues[ dependency.element.replace( dependency.element.substring( 0, 7 ), '' ) ];
									} else {
										$currentVal = '';
									}
								} else {
									$currentVal = thisEl.find( '#' + dependency.element ).val();
								}
								$passedArray.push( doesTestPass( $currentVal, dependency.value, dependency.operator ) );
							});

							// Check if it passes for regular "and" test.
							if ( -1 === $.inArray( false, $passedArray ) && 'undefined' === typeof value.or ) {
								thisEl.find( '#' + value.option ).parents( '.fusion-builder-option' ).fadeIn( 300 );

							// Check if it passes "or" test.
							} else if (  -1 !== $.inArray( true, $passedArray ) && 'undefined' !== typeof value.or ) {
								thisEl.find( '#' + value.option ).parents( '.fusion-builder-option' ).fadeIn( 300 );

							// If it fails.
							} else {
								thisEl.find( '#' + value.option ).parents( '.fusion-builder-option' ).hide();
							}
						});

					});
				}

			}

		} );

		// Instantiate Builder App
		FusionPageBuilderApp = new FusionPageBuilder.AppView( {
			model: FusionPageBuilder.Element,
			collection: FusionPageBuilderElements
		} );

		// Stores 'active' value in fusion_builder_status meta key if builder is activa
		$useBuilderMetaField = $( '#fusion_use_builder' );

		// Fusion Builder Toggle Button
		$toggleBuilderButton = $( '#fusion_toggle_builder' );

		// Fusion Builder div
		$builder = $( '#fusion_builder_layout' );

		// Main wrap for the main editor
		$mainEditorWrapper = $( '#fusion_main_editor_wrap' );

		// Show builder div if it's activated
		if ( $toggleBuilderButton.hasClass( 'fusion_builder_is_active' ) ) {
			$builder.show();
			FusionPageBuilderApp.builderActive = true;

			// Sticky header
			fusionBuilderEnableStickyHeader();
		}

		// Builder toggle button event
		$toggleBuilderButton.click( function( event ) {

			var isBuilderUsed;

			if ( event ) {
				event.preventDefault();
			}

			isBuilderUsed = $( this ).hasClass( 'fusion_builder_is_active' );

			if ( isBuilderUsed ) {
				fusionBuilderDeactivate( $( this ) );
				FusionPageBuilderApp.builderActive = false;
			} else {
				fusionBuilderActivate( $( this ) );
				FusionPageBuilderApp.builderActive = true;
			}
		} );

		// Sticky builder header
		function fusionBuilderEnableStickyHeader() {
			var builderHeader = document.getElementById( 'fusion_builder_controls' );
			fusionBuilderStickyHeader( builderHeader, jQuery( '#wpadminbar' ).height() );
		}

		function fusionBuilderActivate( toggle ) {

			fusionBuilderReset();

			FusionPageBuilderApp.initialBuilderLayout();

			$useBuilderMetaField.val( 'active' );

			$builder.show();

			toggle.text( toggle.data( 'editor' ) );

			$mainEditorWrapper.toggleClass( 'fusion_builder_hidden' );

			toggle.toggleClass( 'fusion_builder_is_active' );

			// Sticky header
			fusionBuilderEnableStickyHeader();

		}

		function fusionBuilderReset() {

			// Clear all models and views
			FusionPageBuilderElements.reset();
			FusionPageBuilderViewManager.set( 'elementCount', 0 );
			FusionPageBuilderViewManager.set( 'views', {} );
		}

		function fusionBuilderDeactivate( toggle ) {
			var $body,
			    pagePosition;

			fusionBuilderReset();

			$body        = $( 'body' );
			pagePosition = 0;

			window.wpActiveEditor = 'content';

			$useBuilderMetaField.val( 'off' );

			$builder.hide();

			$toggleBuilderButton.text( $toggleBuilderButton.data( 'builder' ) ).toggleClass( 'fusion_builder_is_active' );

			$mainEditorWrapper.toggleClass( 'fusion_builder_hidden' );

			FusionPageBuilderApp.$el.find( '.fusion_builder_container' ).remove();

			pagePosition = $body.scrollTop();
			jQuery( 'html, body' ).scrollTop( pagePosition + 1 );

		}

		// Remove preview image.
		$container = $( 'body' );
		$container.on( 'click', '.upload-image-remove', function( event ) {
			var $field,
			    $preview,
			    $upload;

			if ( event ) {
				event.preventDefault();
			}

			$field   = $( this ).parents( '.fusion-builder-option-container' ).find( '.fusion-builder-upload-field' );
			$preview = $( this ).parents( '.fusion-builder-option-container' ).find( '.fusion-builder-upload-preview' );
			$upload  = $( this ).parents( '.fusion-builder-option-container' ).find( '.fusion-builder-upload-button' );

			$field.val( '' ).trigger( 'change' );
			$upload.val( 'Upload Image' );
			$preview.remove();

			if ( $( '#image_id' ).length ) {
				$( '#image_id' ).val( '' );
			}
			jQuery( this ).remove();
		} );

		// History steps.
		$( '.fusion-builder-history-list li' ).live( 'click', function( event ) {
			var step;

			if ( event ) {
				event.preventDefault();
			}

			step = $( event.currentTarget ).data( 'state-id' );
			fusionHistoryManager.historyStep( step );
		} );

		// Element option tabs.
		$( '.fusion-tabs-menu a' ).live( 'click', function( event ) {

			var tab;

			if ( event ) {
				event.preventDefault();
			}

			$( this ).parent().addClass( 'current' ).removeClass( 'inactive' );
			$( this ).parent().siblings().removeClass( 'current' ).addClass( 'inactive' );
			tab = $( this ).attr( 'href' );
			$( this ).parents( '.fusion-builder-modal-container' ).find( '.fusion-tab-content' ).not( tab ).css( 'display', 'none' );
			$( '.fusion-builder-layouts-tab' ).hide();
			$( tab ).fadeIn( 'fast' );
		} );

		// Close modal on overlick click.
		$( '.fusion_builder_modal_overlay' ).live( 'click', function() {
			FusionPageBuilderEvents.trigger( 'fusion-remove-modal-view' );
			FusionPageBuilderEvents.trigger( 'fusion-close-modal' );
		} );

		// Close nested modal on overlick click.
		$( '.fusion_builder_modal_inner_row_overlay' ).live( 'click', function() {
			FusionPageBuilderEvents.trigger( 'fusion-close-inner-modal' );
			FusionPageBuilderEvents.trigger( 'fusion-hide-library' );
		} );

		// Demo select.
		$selectedDemo = $( '.fusion-builder-demo-select' ).val();
		$( '#fusion-builder-layouts-demos .demo-' + $selectedDemo ).show();

		$( '.fusion-builder-demo-select' ).live( 'change', function( event ) {
			$selectedDemo = $( '.fusion-builder-demo-select' ).val();
			$( '#fusion-builder-layouts-demos .fusion-page-layouts' ).hide();
			$( '#fusion-builder-layouts-demos .demo-' + $selectedDemo ).show();
		} );

		// Iconpicker select/deselect handler.
		FusionIconPickHandler.live( 'click', function( e ) {

			var iconWithPrefix,
			    fontName;

			e.preventDefault();

			iconWithPrefix  = $( this ).find( 'i' ).attr( 'class' );
			fontName		= $( this ).find( 'i' ).attr( 'data-name' );

			if ( $( this ).hasClass( 'selected-element' ) ) {
				$( this ).find( 'i' ).parent().parent().find( '.selected-element' ).removeClass( 'selected-element' );
				$( this ).find( 'i' ).parent().parent().parent().find( '.fusion-iconpicker-input' ).attr( 'value', '' ).trigger( 'change' );

			} else {

				$( this ).find( 'i' ).parent().parent().find( '.selected-element' ).removeClass( 'selected-element' );
				$( this ).find( 'i' ).parent().addClass( 'selected-element' );
				$( this ).find( 'i' ).parent().parent().parent().find( '.fusion-iconpicker-input' ).attr( 'value', fontName ).trigger( 'change' );
			}
		} );

		// Open shortcode generator.
		$( '#qt_content_fusion_shortcodes_text_mode, #qt_excerpt_fusion_shortcodes_text_mode' ).live( 'click', function() {
			openShortcodeGenerator( $( this ) );
		} );

		// Save layout template on return key.
		$( '#new_template_name' ).keydown( function( e ) {
			if ( 13 == e.keyCode ) {
				e.preventDefault();
				e.stopPropagation();
				FusionPageBuilderEvents.trigger( 'fusion-save-layout' );
				return false;
			} else {
				return true;
			}
		} );

		// Save elements on return key.
		$( 'body' ).on( 'keydown', '#fusion-builder-save-element-input', function( e ) {
			if ( 13 == e.keyCode ) {
				e.preventDefault();
				e.stopPropagation();
				$( '.fusion-builder-element-button-save' ).trigger( 'click' );
				return false;
			} else {
				return true;
			}
		} );
	} );
} )( jQuery );
;( function( $ ) {

	// Insert shortcode into post editor
	fusionBuilderInsertIntoEditor = function( shortcode, editorID ) {
		var currentEditor = window.SCmoduleContentEditorMode,
		    editorArea,
		    editor;

		if ( 'tinymce' === window.SCmoduleContentEditorMode ) {

			if ( 'undefined' !== typeof window.tinyMCE ) {

				// Set active editor
				editor = FusionPageBuilderApp.shortcodeGeneratorActiveEditor;
				editor.focus();

				// Insert shortcode
				window.tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, shortcode );
				window.tinyMCE.activeEditor.execCommand( 'mceCleanup', false );
			}

		} else {

			if ( null === editorID || '' === editorID || 'undefined' === typeof editorID ) {
				editorArea = $( window.editorArea );

			} else {
				editorArea = $( '#' + editorID );
			}

			if ( 'undefined' === typeof window.cursorPosition ) {
				if ( 0 === editorArea.getCursorPosition() ) {
					editorArea.val( shortcode + editorArea.val() );
				} else if ( editorArea.val().length === editorArea.getCursorPosition() ) {
					editorArea.val( editorArea.val() + shortcode );
				} else {
					editorArea.val( editorArea.val().slice( 0, editorArea.getCursorPosition() ) + shortcode + editorArea.val().slice( editorArea.getCursorPosition() ) );
				}
			} else {
				editorArea.val( [ editorArea.val().slice( 0, window.cursorPosition ), shortcode, editorArea.val().slice( window.cursorPosition ) ].join( '' ) );
			}
		}

		FusionPageBuilderApp.shortcodeGeneratorActiveEditor = '';
	};

} )( jQuery );

function openShortcodeGenerator( trigger ) {

	// Get editor id from event.trigger.  parent.parent

	var view,
	    editorArea = '#' + trigger.parent().parent().find( '.wp-editor-area' ).attr( 'id' );

	window.cursorPosition = 0;
	window.editorArea = editorArea;

	// Set shortcode generator flag
	FusionPageBuilderApp.shortcodeGenerator = true;

	// Get active editor mode
	if ( FusionPageBuilderApp.isTinyMceActive() ) {
		window.SCmoduleContentEditorMode = 'tinymce';
	} else {
		window.SCmoduleContentEditorMode = 'html';
	}

	// Get current cursor position ( for html editor )
	if ( 'tinymce' !== window.SCmoduleContentEditorMode ) {
		window.cursorPosition = jQuery( editorArea ).getCursorPosition();
	}

	view = new FusionPageBuilder.ModalView( {
		model: this.model,
		collection: FusionPageBuilderElements,
		attributes: {
			'data-modal_view': 'all_elements_generator'
		},
		view: this
	} );

	jQuery( 'body' ).append( view.render().el );
}

// Helper function to check the cursor position of text editor content field before the shortcode generator is opened
( function( $, undefined ) {
	$.fn.getCursorPosition = function() {
		var el  = $( this ).get( 0 ),
		    pos = 0,
		    Sel,
		    SelLength;

		if ( 'selectionStart' in el ) {
			pos = el.selectionStart;
		} else if ( 'selection' in document ) {
			el.focus();
			Sel       = document.selection.createRange();
			SelLength = document.selection.createRange().text.length;
			Sel.moveStart( 'character', -el.value.length );
			pos = Sel.text.length - SelLength;
		}
		return pos;
	};
})( jQuery );
;/*
 * Adds undo and redo functionality to the Fusion Page Builder
 */
( function( $ ) {
	var fusionHistoryManager = {},
	    fusionCommands       = new Array( '[]' ),
	    fusionCommandsStates = new Array( '[]' ), // History states
	    maxSteps             = 25, // Maximum steps allowed/saved
	    currStep             = 0; // Current Index of step

	// Is tracking on or off?
	window.tracking = 'on';

	// History state title
	window.fusionHistoryState = '';

	window.fusionHistoryManager = fusionHistoryManager;

	/**
	 * Get editor data and add to array
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.captureEditor = function( ) {

		var allElements;

		if ( fusionHistoryManager.isTrackingOn() ) {

			if ( currStep ==  maxSteps ) { // If reached limit
				fusionCommands.shift(); // Remove first index
			} else {
				currStep += 1; // Else increment index
			}

			if ( currStep > 1 ) {
				$( '.fusion-builder-history-list li' ).removeClass( 'fusion-history-active-state' );
				$( '.fusion-builder-history-list' ).prepend( '<li data-state-id="' + currStep + '" class="history-state-' + currStep + ' fusion-history-active-state"><span class="dashicons dashicons-arrow-right-alt2"></span>' + fusionHistoryState + '</li>' );
			}

			// Get content
			allElements = fusionBuilderGetContent( 'content', true );

			// Add editor data to Array
			fusionCommands[currStep] = allElements;

			// Add history state
			fusionCommandsStates[currStep] = fusionHistoryState;

			// Update buttons
			fusionHistoryManager.updateButtons();
			fusionHistoryState = '';
		}
	};

	/**
	 * Set tracking flag ON.
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.turnOnTracking = function( ) {
		window.tracking = 'on';
	};

	/**
	 * Set tracking flag OFF.
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.turnOffTracking = function( ) {
		window.tracking = 'off';
	};

	/**
	 * Get editor elements of current index for UNDO. Remove all elements currenlty visible in eidor and then reset models
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.doUndo = function( event ) {

		var undoData;

		if ( event ) {
			event.preventDefault();
		}

		// Turn off tracking first, so these actions are not captured
		if ( fusionHistoryManager.hasUndo() ) { // If no data or end of stack and nothing to undo

			fusionHistoryManager.turnOffTracking();

			currStep -= 1;

			// Data to undo
			undoData = fusionCommands[ currStep ];

			if ( '[]' !== undoData ) { // If not empty state

				// Remove all current editor elements first
				FusionPageBuilderApp.clearBuilderLayout();
				FusionPageBuilderApp.$el.find( '.fusion_builder_container' ).remove();

				// Reset models with new elements
				FusionPageBuilderApp.createBuilderLayout( undoData );

				$( '.fusion-builder-history-list li' ).removeClass( 'fusion-history-active-state' );
				$( '.fusion-builder-history-list' ).find( '.history-state-' + currStep ).addClass( 'fusion-history-active-state' );
			}

			// Update buttons
			fusionHistoryManager.updateButtons();
		}
	};

	/**
	 * Get editor elements of current index for REDO. Remove all elements currenlty visible in eidor and then reset models
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.doRedo = function( event ) {

		var redoData;

		if ( event ) {
			event.preventDefault();
		}

		if ( fusionHistoryManager.hasRedo() ) { // If not at end and nothing to redo

			// Turn off tracking, so these actions are not tracked
			fusionHistoryManager.turnOffTracking();

			// Move index
			currStep += 1;

			// Get data to redo
			redoData = fusionCommands[ currStep ];

			// Remove all current editor elements first
			FusionPageBuilderApp.clearBuilderLayout();
			FusionPageBuilderApp.$el.find( '.fusion_builder_container' ).remove();

			// Reset models with new elements
			FusionPageBuilderApp.createBuilderLayout( redoData );

			// Update buttons
			fusionHistoryManager.updateButtons();

			$( '.fusion-builder-history-list li' ).removeClass( 'fusion-history-active-state' );
			$( '.fusion-builder-history-list' ).find( '.history-state-' + currStep ).addClass( 'fusion-history-active-state' );
		}

	};

	/**
	 * Save history state
	 * @param   step
	 * @return  NULL
	 */
	fusionHistoryManager.historyStep = function( step, event ) {

		var stepData;

		if ( event ) {
			event.preventDefault();
		}

		// Get data
		stepData = fusionCommands[step];

		// Remove all current editor elements first
		FusionPageBuilderApp.clearBuilderLayout();
		FusionPageBuilderApp.$el.find( '.fusion_builder_container' ).remove();

		// Reset models with new elements
		FusionPageBuilderApp.createBuilderLayout( stepData );

		currStep = step;

		// Update buttons
		fusionHistoryManager.updateButtons();

		$( '.fusion-builder-history-list li' ).removeClass( 'fusion-history-active-state' );
		$( '.fusion-builder-history-list' ).find( '.history-state-' + currStep ).addClass( 'fusion-history-active-state' );
	};

	/**
	 * Check whether tracking is on or off
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.isTrackingOn = function( ) {
		return 'on' === window.tracking;
	};

	/**
	 * Log current data
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.logStacks = function() {
		console.log( JSON.parse( fusionCommands ) );
	};

	/**
	 * Clear all commands and reset manager
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.clearEditor = function( state ) {

		var allElements;

		fusionCommands       = new Array( '[]' );
		fusionCommandsStates = new Array( '[]' );
		currStep             = 1;
		fusionHistoryState   = '';

		if ( 'blank' === state ) {
			fusionCommands[ currStep ] = '';
		} else {
			allElements = fusionBuilderGetContent( 'content', true );
			fusionCommands[ currStep ] = allElements;
		}

		fusionHistoryManager.updateButtons();

		$( '.fusion-builder-history-list' ).html( '<li data-state-id="1" class="history-state-1 fusion-history-active-state"><span class="dashicons dashicons-arrow-right-alt2"></span>' + fusionBuilderText.empty + '</li>' );
	};

	/**
	 * Check if undo commands exist
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.hasUndo = function() {
		return 1 !== currStep;
	};

	/**
	 * Check if redo commands exist
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.hasRedo = function() {
		return currStep < ( fusionCommands.length - 1 );
	};

	/**
	 * Get existing commands
	 * @param   NULL
	 * @return  {string}	actions
	 */
	fusionHistoryManager.getCommands = function() {
		return fusionCommands;
	};

	/**
	 * Update buttons colors accordingly
	 * @param   NULL
	 * @return  NULL
	 */
	fusionHistoryManager.updateButtons = function() {

		// Undo button
		$( '.fusion-builder-layout-buttons-undo' ).css( 'background', fusionHistoryManager.hasUndo() ? '#222222' : '' );

		// Redo button
		$( '.fusion-builder-layout-buttons-redo' ).css( 'background', fusionHistoryManager.hasRedo() ? '#222222' : '' );

		// History states button
		$( '.fusion-builder-layout-buttons-history' ).css( 'background', fusionHistoryManager.hasUndo() ? '#222222' : '' );
	};

})( jQuery );
