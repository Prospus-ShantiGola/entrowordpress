jQuery( document ).ready( function() {

	'use strict';

	var iframeLoaded;

	// Position dropdown menu correctly
	jQuery.fn.fusion_position_menu_dropdown = function( variables ) {

			if ( ( 'Top' === avadaVars.header_position && ! jQuery( 'body.rtl' ).length ) || 'Left' === avadaVars.header_position  ) {
				return jQuery( this ).children( '.sub-menu' ).each( function() {

					var submenu,
					    submenuPosition,
					    submenuLeft,
					    submenuTop,
					    submenuHeight,
					    submenuWidth,
					    submenuBottomEdge,
					    submenuRightEdge,
					    browserBottomEdge,
					    browserRightEdge,
					    submenuNewTopPos,
					    adminbarHeight,
					    sideHeaderTop;

					// Reset attributes
					jQuery( this ).removeAttr( 'style' );
					jQuery( this ).show();
					jQuery( this ).removeData( 'shifted' );

					submenu = jQuery( this );

					if ( submenu.length ) {
						submenuPosition   = submenu.offset();
						submenuLeft       = submenuPosition.left;
						submenuTop        = submenuPosition.top;
						submenuHeight     = submenu.height();
						submenuWidth      = submenu.outerWidth();
						submenuBottomEdge = submenuTop + submenuHeight;
						submenuRightEdge  = submenuLeft + submenuWidth;
						browserBottomEdge = jQuery( window ).height();
						browserRightEdge  = jQuery( window ).width();

						if (	jQuery( '#wpadminbar' ).length ) {
							adminbarHeight = jQuery( '#wpadminbar' ).height();
						} else {
							adminbarHeight = 0;
						}

						if ( jQuery( '#side-header' ).length ) {
							sideHeaderTop = jQuery( '#side-header' ).offset().top - adminbarHeight;
						}

						// Current submenu goes beyond browser's right edge
						if ( submenuRightEdge > browserRightEdge ) {

							// If there are 2 or more submenu parents position this submenu below last one
							if ( submenu.parent().parent( '.sub-menu' ).parent().parent( '.sub-menu' ).length ) {
								submenu.css({
									'left': '0',
									'top': submenu.parent().parent( '.sub-menu' ).height()
								});

							// First or second level submenu
							} else {

								// First level submenu
								if ( ! submenu.parent().parent( '.sub-menu' ).length ) {
									submenu.css( 'left', ( -1 ) * submenuWidth + submenu.parent().width() );

								// Second level submenu
								} else {
									submenu.css({
										'left': ( -1 ) * submenuWidth
									});
								}
							}

							submenu.data( 'shifted', 1 );

						// Parent submenu had to be shifted
						} else if ( submenu.parent().parent( '.sub-menu' ).length ) {
							if ( submenu.parent().parent( '.sub-menu' ).data( 'shifted' ) ) {
								submenu.css( 'left', ( -1 ) * submenuWidth );
								submenu.data( 'shifted', 1 );
							}
						}

						// Calculate dropdown vertical position on side header.
						if ( 'Top' !== avadaVars.header_position && submenuBottomEdge > sideHeaderTop + browserBottomEdge && jQuery( window ).height() >= jQuery( '.side-header-wrapper' ).height() ) {
							if ( submenuHeight < browserBottomEdge  ) {
								submenuNewTopPos = ( -1 ) * ( submenuBottomEdge - sideHeaderTop - browserBottomEdge + 20 );
							} else {
								submenuNewTopPos = ( -1 ) * ( submenuTop - adminbarHeight );
							}
							submenu.css( 'top', submenuNewTopPos );
						}
					}
				});
			} else {
				return jQuery( this ).children( '.sub-menu' ).each( function() {

					var submenu,
					    submenuPosition,
					    submenuLeftEdge,
					    submenuTop,
					    submenuHeight,
					    submenuWidth,
					    submenuBottomEdge,
					    browserBottomEdge,
					    adminbarHeight,
					    sideHeaderTop,
					    submenuNewTopPos;

					// Reset attributes
					jQuery( this ).removeAttr( 'style' );
					jQuery( this ).removeData( 'shifted' );

					submenu = jQuery( this );

					if ( submenu.length ) {
						submenuPosition   = submenu.offset();
						submenuLeftEdge   = submenuPosition.left;
						submenuTop        = submenuPosition.top;
						submenuHeight     = submenu.height();
						submenuWidth      = submenu.outerWidth();
						submenuBottomEdge = submenuTop + submenuHeight;
						browserBottomEdge = jQuery( window ).height();

						if ( jQuery( '#wpadminbar' ).length ) {
							adminbarHeight = jQuery( '#wpadminbar' ).height();
						} else {
							adminbarHeight = 0;
						}

						if ( jQuery( '#side-header' ).length ) {
							sideHeaderTop = jQuery( '#side-header' ).offset().top - adminbarHeight;
						}

						// Current submenu goes beyond browser's left edge
						if ( 0 < submenuLeftEdge ) {

							//If there are 2 or more submenu parents position this submenu below last one
							if ( submenu.parent().parent( '.sub-menu' ).parent().parent( '.sub-menu' ).length ) {
								if ( 'Right' === avadaVars.header_position ) {
									submenu.css({
										'left': '0',
										'top': submenu.parent().parent( '.sub-menu' ).height()
									});
								} else {
									submenu.css({
										'right': '0',
										'top': submenu.parent().parent( '.sub-menu' ).height()
									});
								}

							// First or second level submenu
							} else {

								// First level submenu
								if ( ! submenu.parent().parent( '.sub-menu' ).length ) {
									submenu.css( 'right', ( -1 ) * submenuWidth + submenu.parent().width() );

								// Second level submenu
								} else {
									submenu.css({
										'right': ( -1 ) * submenuWidth
									});
								}
							}

							submenu.data( 'shifted', 1 );

						// Parent submenu had to be shifted
						} else if ( submenu.parent().parent( '.sub-menu' ).length ) {
							if ( submenu.parent().parent( '.sub-menu' ).data( 'shifted' ) ) {
								submenu.css( 'right', ( -1 ) * submenuWidth );
							}
						}

						// Calculate dropdown vertical position on side header
						if ( 'Top' !== avadaVars.header_position && submenuBottomEdge > sideHeaderTop + browserBottomEdge && jQuery( window ).height() >= jQuery( '.side-header-wrapper' ).height() ) {
							if ( submenuHeight < browserBottomEdge  ) {
								submenuNewTopPos = ( -1 ) * ( submenuBottomEdge - sideHeaderTop - browserBottomEdge + 20 );
							} else {
								submenuNewTopPos = ( -1 ) * ( submenuTop - adminbarHeight );
							}
							submenu.css( 'top', submenuNewTopPos );
						}
					}
				});
			}
	};

	// Recursive function for positioning menu items correctly on load
	jQuery.fn.walk_through_menu_items = function() {
		jQuery( this ).fusion_position_menu_dropdown();

		if ( jQuery( this ).find( '.sub-menu' ).length ) {
			jQuery( this ).find( '.sub-menu li' ).walk_through_menu_items();
		} else {
			return;
		}
	};

	// Position the cart dropdown vertically on side-header layouts
	jQuery.fn.position_cart_dropdown = function() {
		if ( 'Top' !== avadaVars.header_position ) {
			jQuery( this ).each( function() {

				var cartDropdown,
				    cartDropdownTop,
				    cartDropdownHeight,
				    cartDropdownBottomEdge,
				    adminbarHeight,
				    sideHeaderTop,
				    browserBottomEdge,
				    cartDropdownNewTopPos;

				jQuery( this ).css( 'top', '' );

				cartDropdown           = jQuery( this ),
				cartDropdownTop        = cartDropdown.offset().top,
				cartDropdownHeight     = cartDropdown.height(),
				cartDropdownBottomEdge = cartDropdownTop + cartDropdownHeight,
				adminbarHeight         = ( jQuery( '#wpadminbar' ).length ) ? jQuery( '#wpadminbar' ).height() : 0,
				sideHeaderTop          = jQuery( '#side-header' ).offset().top - adminbarHeight,
				browserBottomEdge      = jQuery( window ).height();

				if ( cartDropdownBottomEdge > sideHeaderTop + browserBottomEdge && jQuery( window ).height() >= jQuery( '.side-header-wrapper' ).height() ) {
					if ( cartDropdownHeight < browserBottomEdge ) {
						cartDropdownNewTopPos = ( -1 ) * ( cartDropdownBottomEdge - sideHeaderTop - browserBottomEdge + 20 );
					} else {
						cartDropdownNewTopPos = ( -1 ) * ( cartDropdownTop - adminbarHeight );
					}

					cartDropdown.css( 'top', cartDropdownNewTopPos );
				}
			});
		}
	};

	// Position the search form vertically on side-header layouts
	jQuery.fn.position_menu_search_form = function() {
		if ( 'Top' !== avadaVars.header_position ) {
			jQuery( this ).each( function() {

				var searchForm,
				    searchFormTop,
				    searchFormHeight,
				    searchFormBottomEdge,
				    adminbarHeight,
				    sideHeaderTop,
				    browserBottomEdge,
				    searchFormNewTopPos;

				jQuery( this ).css( 'top', '' );

				searchForm = jQuery( this ),
				searchFormTop        = searchForm.offset().top,
				searchFormHeight     = searchForm.outerHeight(),
				searchFormBottomEdge = searchFormTop + searchFormHeight,
				adminbarHeight       = ( jQuery( '#wpadminbar' ).length ) ? jQuery( '#wpadminbar' ).height() : 0,
				sideHeaderTop        = jQuery( '#side-header' ).offset().top - adminbarHeight,
				browserBottomEdge    = jQuery( window ).height();

				if ( searchFormBottomEdge > sideHeaderTop + browserBottomEdge && jQuery( window ).height() >= jQuery( '.side-header-wrapper' ).height() ) {
					searchFormNewTopPos = ( -1 ) * ( searchFormBottomEdge - sideHeaderTop - browserBottomEdge + 20 );

					searchForm.css( 'top', searchFormNewTopPos );
				}
			});
		}
	};

	// Position mega menu correctly
	jQuery.fn.fusion_position_megamenu = function( variables ) {

		var referenceElem,
		    mainNavContainer,
		    mainNavContainerPosition,
		    mainNavContainerWidth,
		    mainNavContainerLeftEdge,
		    mainNavContainerRightEdge;

		// Side header left handling
		if ( jQuery( '.side-header-left' ).length ) {
			return this.each( function() {
				jQuery( this ).children( 'li' ).each( function() {
					var liItem = jQuery( this ),
					    megamenuWrapper = liItem.find( '.fusion-megamenu-wrapper' ),
					    megamenuWrapperLeft,
					    megamenuWrapperTop,
					    megamenuWrapperHeight,
					    megamenuBottomEdge,
					    adminbarHeight,
					    sideHeaderTop,
					    browserBottomEdge,
					    megamenuWrapperNewTopPos;

					if ( megamenuWrapper.length ) {
						megamenuWrapper.removeAttr( 'style' );

						megamenuWrapperLeft   = jQuery( '#side-header' ).outerWidth() - 1;
						megamenuWrapperTop    = megamenuWrapper.offset().top;
						megamenuWrapperHeight = megamenuWrapper.height();
						megamenuBottomEdge    = megamenuWrapperTop + megamenuWrapperHeight;
						adminbarHeight        = ( jQuery( '#wpadminbar' ).length ) ? jQuery( '#wpadminbar' ).height() : 0;
						sideHeaderTop         = jQuery( '#side-header' ).offset().top - adminbarHeight;
						browserBottomEdge     = jQuery( window ).height();
						megamenuWrapperNewTopPos;

						if ( ! jQuery( 'body.rtl' ).length ) {
							megamenuWrapper.css( 'left', megamenuWrapperLeft );
						} else {
							megamenuWrapper.css({ 'left': megamenuWrapperLeft, 'right': 'auto' });
						}

						if ( megamenuBottomEdge > sideHeaderTop + browserBottomEdge && jQuery( window ).height() >= jQuery( '.side-header-wrapper' ).height() ) {
							if ( megamenuWrapperHeight < browserBottomEdge ) {
								megamenuWrapperNewTopPos = ( -1 ) * ( megamenuBottomEdge - sideHeaderTop - browserBottomEdge + 20 );
							} else {
								megamenuWrapperNewTopPos = ( -1 ) * ( megamenuWrapperTop - adminbarHeight );
							}

							megamenuWrapper.css( 'top', megamenuWrapperNewTopPos );
						}
					}
				});
			});
		}

		// Side header right handling
		if ( jQuery( '.side-header-right' ).length ) {
			return this.each( function() {
				jQuery( this ).children( 'li' ).each( function() {
					var liItem = jQuery( this ),
					    megamenuWrapper = liItem.find( '.fusion-megamenu-wrapper' ),
					    megamenuWrapperLeft,
					    megamenuWrapperTop,
					    megamenuWrapperHeight,
					    megamenuBottomEdge,
					    adminbarHeight,
					    sideHeaderTop,
					    browserBottomEdge,
					    megamenuWrapperNewTopPos;

					if ( megamenuWrapper.length ) {
						megamenuWrapper.removeAttr( 'style' );

						megamenuWrapperLeft   = ( -1 ) * megamenuWrapper.outerWidth();
						megamenuWrapperTop    = megamenuWrapper.offset().top;
						megamenuWrapperHeight = megamenuWrapper.height();
						megamenuBottomEdge    = megamenuWrapperTop + megamenuWrapperHeight;
						adminbarHeight        = ( jQuery( '#wpadminbar' ).length ) ? jQuery( '#wpadminbar' ).height() : 0;
						sideHeaderTop         = jQuery( '#side-header' ).offset().top - adminbarHeight;
						browserBottomEdge     = jQuery( window ).height();

						if ( ! jQuery( 'body.rtl' ).length ) {
							megamenuWrapper.css( 'left', megamenuWrapperLeft );
						} else {
							megamenuWrapper.css({ 'left': megamenuWrapperLeft, 'right': 'auto' });
						}

						if ( megamenuBottomEdge > sideHeaderTop + browserBottomEdge && jQuery( window ).height() >= jQuery( '.side-header-wrapper' ).height() ) {
							if ( megamenuWrapperHeight < browserBottomEdge ) {
								megamenuWrapperNewTopPos = ( -1 ) * ( megamenuBottomEdge - sideHeaderTop - browserBottomEdge + 20 );
							} else {
								megamenuWrapperNewTopPos = ( -1 ) * ( megamenuWrapperTop - adminbarHeight );
							}

							megamenuWrapper.css( 'top', megamenuWrapperNewTopPos );
						}
					}
				});
			});
		}

		// Top header handling
		referenceElem = '';
		if ( jQuery( '.fusion-header-v4' ).length ) {
			referenceElem = jQuery( this ).parent( '.fusion-main-menu' ).parent();
		} else {
			referenceElem = jQuery( this ).parent( '.fusion-main-menu' );
		}

		if ( jQuery( this ).parent( '.fusion-main-menu' ).length ) {

			mainNavContainer          = referenceElem,
			mainNavContainerPosition  = mainNavContainer.offset(),
			mainNavContainerWidth     = mainNavContainer.width(),
			mainNavContainerLeftEdge  = mainNavContainerPosition.left,
			mainNavContainerRightEdge = mainNavContainerLeftEdge + mainNavContainerWidth;

			if ( ! jQuery( 'body.rtl' ).length ) {
				return this.each( function() {

					jQuery( this ).children( 'li' ).each( function() {
						var liItem                  = jQuery( this ),
						    liItemPosition          = liItem.offset(),
						    megamenuWrapper         = liItem.find( '.fusion-megamenu-wrapper' ),
						    megamenuWrapperWidth    = megamenuWrapper.outerWidth(),
						    megamenuWrapperPosition = 0,
						    referenceAvadaRow       = 0;

						// Check if there is a megamenu
						if ( megamenuWrapper.length ) {
							megamenuWrapper.removeAttr( 'style' );

							// Set megamenu max width

							if ( jQuery( '.fusion-secondary-main-menu' ).length ) {
								referenceAvadaRow = jQuery( '.fusion-header-wrapper .fusion-secondary-main-menu .fusion-row' );
							} else {
								referenceAvadaRow = jQuery( '.fusion-header-wrapper .fusion-row' );
							}

							if ( megamenuWrapper.hasClass( 'col-span-12' ) && ( referenceAvadaRow.width() < megamenuWrapper.data( 'maxwidth' ) ) ) {
								megamenuWrapper.css( 'width', referenceAvadaRow.width() );
							} else {
								megamenuWrapper.removeAttr( 'style' );
							}

							// Reset the megmenu width after resizing the menu
							megamenuWrapperWidth = megamenuWrapper.outerWidth();

							if ( liItemPosition.left + megamenuWrapperWidth > mainNavContainerRightEdge ) {
								megamenuWrapperPosition = -1 * ( liItemPosition.left - ( mainNavContainerRightEdge - megamenuWrapperWidth ) );

								if ( 'right' === avadaVars.logo_alignment.toLowerCase() ) {
									if ( liItemPosition.left + megamenuWrapperPosition < mainNavContainerLeftEdge ) {
										megamenuWrapperPosition = -1 * ( liItemPosition.left - mainNavContainerLeftEdge );
									}
								}

								megamenuWrapper.css( 'left', megamenuWrapperPosition );
							}
						}
					});
				});

			} else {
				return this.each( function() {
					jQuery( this ).children( 'li' ).each( function() {
						var liItem                  = jQuery( this ),
						    liItemPosition          = liItem.offset(),
						    liItemRightEdge         = liItemPosition.left + liItem.outerWidth(),
						    megamenuWrapper         = liItem.find( '.fusion-megamenu-wrapper' ),
						    megamenuWrapperWidth    = megamenuWrapper.outerWidth(),
						    megamenuWrapperPosition = 0,
						    referenceAvadaRow;

						// Check if there is a megamenu
						if ( megamenuWrapper.length ) {
							megamenuWrapper.removeAttr( 'style' );

							if ( jQuery( '.fusion-secondary-main-menu' ).length ) {
								referenceAvadaRow = jQuery( '.fusion-header-wrapper .fusion-secondary-main-menu .fusion-row' );
							} else {
								referenceAvadaRow = jQuery( '.fusion-header-wrapper .fusion-row' );
							}

							if ( megamenuWrapper.hasClass( 'col-span-12' ) && ( referenceAvadaRow.width() < megamenuWrapper.data( 'maxwidth' ) ) ) {
								megamenuWrapper.css( 'width', referenceAvadaRow.width() );
							} else {
								megamenuWrapper.removeAttr( 'style' );
							}

							if ( liItemRightEdge - megamenuWrapperWidth < mainNavContainerLeftEdge ) {

								megamenuWrapperPosition = -1 * ( megamenuWrapperWidth - ( liItemRightEdge - mainNavContainerLeftEdge ) );

								if ( 'left' === avadaVars.logo_alignment.toLowerCase() || ( 'center' === avadaVars.logo_alignment.toLowerCase() && ! jQuery( '.header-v5' ).length ) || jQuery( this ).parents( '.sticky-header' ).length ) {
									if ( liItemRightEdge - megamenuWrapperPosition > mainNavContainerRightEdge ) {
										megamenuWrapperPosition = -1 * ( mainNavContainerRightEdge - liItemRightEdge );
									}
								}

								megamenuWrapper.css( 'right', megamenuWrapperPosition );
							}
						}
					});
				});
			}
		}
	};

	jQuery.fn.calc_megamenu_responsive_column_widths = function( variables ) {
		jQuery( this ).find( '.fusion-megamenu-menu' ).each( function() {
			var megamenuHolder          = jQuery( this ).find( '.fusion-megamenu-holder' ),
			    megamenuHolderFullWidth = megamenuHolder.data( 'width' ),
			    referenceFusionRow      = ( jQuery( '.fusion-secondary-main-menu' ).length ) ? jQuery( '.fusion-header-wrapper .fusion-secondary-main-menu .fusion-row' ) : jQuery( '.fusion-header-wrapper .fusion-row' ),
			    availableSpace          = referenceFusionRow.width(),
			    mainPaddingLeft;

			if ( 'Top' !== avadaVars.header_position ) {
				mainPaddingLeft = jQuery( '#main' ).css( 'padding-left' ).replace( 'px', '' );
				availableSpace = jQuery( window ).width() - mainPaddingLeft - jQuery( '#side-header' ).outerWidth();
			}

			if ( availableSpace < megamenuHolderFullWidth ) {
				megamenuHolder.css( 'width', availableSpace );

				if ( ! megamenuHolder.parents( '.fusion-megamenu-wrapper' ).hasClass( 'fusion-megamenu-fullwidth' ) ) {
					megamenuHolder.find( '.fusion-megamenu-submenu' ).each( function() {
						var submenu      = jQuery( this ),
						    submenuWidth = submenu.data( 'width' ) * availableSpace / megamenuHolderFullWidth;

						submenu.css( 'width', submenuWidth );
					});
				}
			} else {
				megamenuHolder.css( 'width', megamenuHolderFullWidth );

				if ( ! megamenuHolder.parents( '.fusion-megamenu-wrapper' ).hasClass( 'fusion-megamenu-fullwidth' ) ) {
					megamenuHolder.find( '.fusion-megamenu-submenu' ).each( function() {
						jQuery( this ).css( 'width', jQuery( this ).data( 'width' ) );
					});
				}
			}
		});
	};

	jQuery.fn.position_last_top_menu_item = function( variables ) {

		var lastItem,
		    lastItemLeftPos,
		    lastItemWidth,
		    lastItemChild,
		    parentContainer,
		    parentContainerLeftPos,
		    parentContainerWidth;

		if ( jQuery( this ).children( 'ul' ).length || jQuery( this ).children( 'div' ).length ) {
			lastItem               = jQuery( this );
			lastItemLeftPos        = lastItem.position().left;
			lastItemWidth          = lastItem.outerWidth();
			parentContainer        = jQuery( '.fusion-secondary-header .fusion-row' );
			parentContainerLeftPos = parentContainer.position().left;
			parentContainerWidth   = parentContainer.outerWidth();

			if ( lastItem.children( 'ul' ).length ) {
				lastItemChild =  lastItem.children( 'ul' );
			} else if ( lastItem.children( 'div' ).length ) {
				lastItemChild =  lastItem.children( 'div' );
			}

			if ( ! jQuery( 'body.rtl' ).length ) {
				if ( lastItemLeftPos + lastItemChild.outerWidth() > parentContainerLeftPos + parentContainerWidth ) {
					lastItemChild.css( 'right', '-1px' ).css( 'left', 'auto' );

					lastItemChild.find( '.sub-menu' ).each( function() {
						jQuery( this ).css( 'right', '100px' ).css( 'left', 'auto' );
					});
				}
			} else {
				if ( lastItemChild.position().left < lastItemLeftPos ) {
					lastItemChild.css( 'left', '-1px' ).css( 'right', 'auto' );

					lastItemChild.find( '.sub-menu' ).each( function() {
						jQuery( this ).css( 'left', '100px' ).css( 'right', 'auto' );
					});
				}
			}
		}
	};

	// IE8 fixes
	jQuery( '.fusion-main-menu > ul > li:last-child' ).addClass( 'fusion-last-menu-item' );
	if ( cssua.ua.ie && '8' == cssua.ua.ie.substr( 0, 1 ) ) {
		jQuery( '.fusion-header-shadow' ).removeClass( 'fusion-header-shadow' );
	}

	// Calculate main menu dropdown submenu position
	if ( jQuery.fn.fusion_position_menu_dropdown ) {
		jQuery( '.fusion-dropdown-menu, .fusion-dropdown-menu li' ).mouseenter( function() {
			jQuery( this ).fusion_position_menu_dropdown();
		});

		jQuery( '.fusion-dropdown-menu > ul > li' ).each( function() {
			jQuery( this ).walk_through_menu_items();
		});

		jQuery( window ).on( 'resize', function() {
			jQuery( '.fusion-dropdown-menu > ul > li' ).each( function() {
				jQuery( this ).walk_through_menu_items();
			});
		});
	}

	// Set overflow state of main nav items; done to get rid of menu overflow
	jQuery( '.fusion-dropdown-menu' ).mouseenter( function() {
		jQuery( this ).css( 'overflow', 'visible' );
	});
	jQuery( '.fusion-dropdown-menu' ).mouseleave( function() {
		jQuery( this ).css( 'overflow', '' );
	});

	// Search icon show/hide
	jQuery( document ).click( function() {
		jQuery( '.fusion-main-menu-search .fusion-custom-menu-item-contents' ).hide();
		jQuery( '.fusion-main-menu-search' ).removeClass( 'fusion-main-menu-search-open' );
		jQuery( '.fusion-main-menu-search' ).find( 'style' ).remove();
	});

	jQuery( '.fusion-main-menu-search' ).click( function( e ) {
		e.stopPropagation();
	});

	jQuery( '.fusion-main-menu-search .fusion-main-menu-icon' ).click( function( e ) {
		e.stopPropagation();

		if ( 'block' === jQuery( this ).parent().find( '.fusion-custom-menu-item-contents' ).css( 'display' ) ) {
			jQuery( this ).parent().find( '.fusion-custom-menu-item-contents' ).hide();
			jQuery( this ).parent().removeClass( 'fusion-main-menu-search-open' );

			jQuery( this ).parent().find( 'style' ).remove();
		} else {
			jQuery( this ).parent().find( '.fusion-custom-menu-item-contents' ).removeAttr( 'style' );
			jQuery( this ).parent().find( '.fusion-custom-menu-item-contents' ).show();
			jQuery( this ).parent().addClass( 'fusion-main-menu-search-open' );

			jQuery( this ).parent().append( '<style>.fusion-main-menu{overflow:visible!important;</style>' );
			jQuery( this ).parent().find( '.fusion-custom-menu-item-contents .s' ).focus();

			// Position main menu search box on click positioning
			if ( 'Top' === avadaVars.header_position ) {
				if ( ! jQuery( 'body.rtl' ).length && jQuery( this ).parent().find( '.fusion-custom-menu-item-contents' ).offset().left < 0 ) {
					jQuery( this ).parent().find( '.fusion-custom-menu-item-contents' ).css({
						'left': '0',
						'right': 'auto'
					});
				}

				if ( jQuery( 'body.rtl' ).length && jQuery( this ).parent().find( '.fusion-custom-menu-item-contents' ).offset().left + jQuery( this ).parent().find( '.fusion-custom-menu-item-contents' ).width()  > jQuery( window ).width() ) {
					jQuery( this ).parent().find( '.fusion-custom-menu-item-contents' ).css({
						'left': 'auto',
						'right': '0'
					});
				}
			}
		}
	});

	// Calculate megamenu position
	if ( jQuery.fn.fusion_position_megamenu ) {
		jQuery( '.fusion-main-menu > ul' ).fusion_position_megamenu();

		jQuery( '.fusion-main-menu .fusion-megamenu-menu' ).mouseenter( function() {
			jQuery( this ).parent().fusion_position_megamenu();
		});

		jQuery( window ).resize( function() {
			jQuery( '.fusion-main-menu > ul' ).fusion_position_megamenu();
		});
	}

	// Calculate megamenu column widths
	if ( jQuery.fn.calc_megamenu_responsive_column_widths ) {
		jQuery( '.fusion-main-menu > ul' ).calc_megamenu_responsive_column_widths();

		jQuery( window ).resize( function() {
			jQuery( '.fusion-main-menu > ul' ).calc_megamenu_responsive_column_widths();
		});
	}

	// Top Menu last item positioning
	jQuery( '.fusion-header-wrapper .fusion-secondary-menu > ul > li:last-child' ).position_last_top_menu_item();

	fusionRepositionMenuItem( '.fusion-main-menu .fusion-main-menu-cart' );
	fusionRepositionMenuItem( '.fusion-secondary-menu .fusion-menu-login-box' );

	function fusionRepositionMenuItem( $menuItem ) {

		// Position main menu cart dropdown correctly
		if ( 'Top' === avadaVars.header_position ) {
			jQuery( $menuItem ).mouseenter( function( e ) {

				if ( jQuery( this ).find( '> div' ).length && jQuery( this ).find( '> div' ).offset().left < 0 ) {
					jQuery( this ).find( '> div' ).css({
						'left': '0',
						'right': 'auto'
					});
				}

				if ( jQuery( this ).find( '> div' ).length && jQuery( this ).find( '> div' ).offset().left + jQuery( this ).find( '> div' ).width()  > jQuery( window ).width() ) {
					jQuery( this ).find( '> div' ).css({
						'left': 'auto',
						'right': '0'
					});
				}
			});

			jQuery( window ).on( 'resize', function() {
				jQuery( $menuItem ).find( '> div' ).each( function() {
					var $menuItemDropdown          = jQuery( this ),
					    $menuItemDropdownWidth     = $menuItemDropdown.outerWidth(),
					    $menuItemDropdownLeftEdge  = $menuItemDropdown.offset().left,
					    $menuItemDropdownRightEdge = $menuItemDropdownLeftEdge + $menuItemDropdownWidth,
					    $menuItemLeftEdge          = $menuItemDropdown.parent().offset().left,
					    windowRightEdge            = jQuery( window ).width();

					if ( ! jQuery( 'body.rtl' ).length ) {
						if ( ( $menuItemDropdownLeftEdge < $menuItemLeftEdge && $menuItemDropdownLeftEdge < 0 ) || ( $menuItemDropdownLeftEdge == $menuItemLeftEdge && $menuItemDropdownLeftEdge - $menuItemDropdownWidth < 0 ) ) {
							$menuItemDropdown.css({
								'left': '0',
								'right': 'auto'
							});
						} else {
							$menuItemDropdown.css({
								'left': 'auto',
								'right': '0'
							});
						}
					} else {
						if ( ( $menuItemDropdownLeftEdge == $menuItemLeftEdge && $menuItemDropdownRightEdge > windowRightEdge ) || ( $menuItemDropdownLeftEdge < $menuItemLeftEdge && $menuItemDropdownRightEdge + $menuItemDropdownWidth > windowRightEdge )  ) {
							$menuItemDropdown.css({
								'left': 'auto',
								'right': '0'
							});
						} else {
							$menuItemDropdown.css({
								'left': '0',
								'right': 'auto'
							});
						}
					}
				});
			});
		}
	}

	// Reinitialize google map on megamenu
	jQuery( '.fusion-megamenu-menu' ).mouseenter( function() {
		if ( jQuery( this ).find( '.shortcode-map' ).length ) {
			jQuery( this ).find( '.shortcode-map' ).each( function() {
				jQuery( this ).reinitializeGoogleMap();
			});
		}
	});

	// Make iframes in megamenu widget area load correctly in Safari and IE
	// Safari part - load the iframe correctly
	iframeLoaded = false;

	jQuery( '.fusion-megamenu-menu' ).mouseover(
		function() {
			jQuery( this ).find( '.fusion-megamenu-widgets-container iframe' ).each( function() {
				if ( ! iframeLoaded ) {
					jQuery( this ).attr( 'src', jQuery( this ).attr( 'src' ) );
				}
				iframeLoaded = true;
			});
		}
	);

	// IE part - making the megamenu stay on hover
	jQuery( '.fusion-megamenu-wrapper iframe' ).mouseover(
		function() {
			jQuery( this ).parents( '.fusion-megamenu-widgets-container' ).css( 'display', 'block' );
			jQuery( this ).parents( '.fusion-megamenu-wrapper' ).css({ 'opacity': '1', 'visibility': 'visible' });
		}
	);

	jQuery( '.fusion-megamenu-wrapper iframe' ).mouseout(
		function() {
			jQuery( this ).parents( '.fusion-megamenu-widgets-container' ).css( 'display', '' );
			jQuery( this ).parents( '.fusion-megamenu-wrapper' ).css({ 'opacity': '', 'visibility': '' });
		}
	);

	// Position main menu cart dropdown correctly on side-header
	jQuery( '.fusion-navbar-nav .cart' ).find( '.cart-contents' ).position_cart_dropdown();

	jQuery( window ).on( 'resize', function() {
		jQuery( '.fusion-navbar-nav .cart' ).find( '.cart-contents' ).position_cart_dropdown();
	});

	// Position main menu search form correctly on side-header
	jQuery( '.fusion-navbar-nav .search-link' ).click( function() {
		setTimeout( function() {
			jQuery( '.fusion-navbar-nav .search-link' ).parent().find( '.main-nav-search-form' ).position_menu_search_form();
		}, 5 );
	});

	jQuery( window ).on( 'resize', function() {
		jQuery( '.fusion-navbar-nav .main-nav-search' ).find( '.main-nav-search-form' ).position_menu_search_form();
	});

	/**
	 * Mobile Navigation
	 */
	jQuery( '.fusion-mobile-nav-holder' ).not( '.fusion-mobile-sticky-nav-holder' ).each( function() {
		var $mobileNavHolder = jQuery( this ),
		    $mobileNav       = '',
		    $menu            = jQuery( this ).parent().find( '.fusion-main-menu, .fusion-secondary-menu' ).not( '.fusion-sticky-menu' );

		if ( $menu.length ) {
			if ( 'classic' === avadaVars.mobile_menu_design ) {
				$mobileNavHolder.append( '<div class="fusion-mobile-selector"><span>' + avadaVars.dropdown_goto + '</span></div>' );
				jQuery( this ).find( '.fusion-mobile-selector' ).append( '<div class="fusion-selector-down"></div>' );
			}

			jQuery( $mobileNavHolder ).append( jQuery( $menu ).find( '> ul' ).clone() );

			$mobileNav = jQuery( $mobileNavHolder ).find( '> ul' );
			$mobileNav.removeClass( 'fusion-middle-logo-ul' );

			$mobileNav.find( '.fusion-middle-logo-menu-logo, .fusion-caret, .fusion-menu-login-box .fusion-custom-menu-item-contents, .fusion-menu-cart .fusion-custom-menu-item-contents, .fusion-main-menu-search, li> a > span > .button-icon-divider-left, li > a > span > .button-icon-divider-right' ).remove();

			if ( 'classic' === avadaVars.mobile_menu_design ) {
				$mobileNav.find( '.fusion-menu-cart > a' ).html( avadaVars.mobile_nav_cart );
			} else {
				$mobileNav.find( '.fusion-main-menu-cart' ).remove();
			}

			$mobileNav.find( 'li' ).each( function() {

				var classes = 'fusion-mobile-nav-item';
				if ( jQuery( this ).data( 'classes' ) ) {
					classes += ' ' + jQuery( this ).data( 'classes' );
				}

				jQuery( this ).find( '> a > .menu-text' ).removeAttr( 'class' ).addClass( 'menu-text' );

				if ( jQuery( this ).hasClass( 'current-menu-item' ) || jQuery( this ).hasClass( 'current-menu-parent' ) || jQuery( this ).hasClass( 'current-menu-ancestor' ) ) {
					classes += ' fusion-mobile-current-nav-item';
				}

				jQuery( this ).attr( 'class', classes );

				if ( jQuery( this ).attr( 'id' ) ) {
					jQuery( this ).attr( 'id', jQuery( this ).attr( 'id' ).replace( 'menu-item', 'mobile-menu-item' ) );
				}

				jQuery( this ).attr( 'style', '' );
			});

			jQuery( this ).find( '.fusion-mobile-selector' ).click( function() {
				if ( $mobileNav.hasClass( 'mobile-menu-expanded' ) ) {
					$mobileNav.removeClass( 'mobile-menu-expanded' );
				} else {
					$mobileNav.addClass( 'mobile-menu-expanded' );
				}

				$mobileNav.slideToggle( 200, 'easeOutQuad' );
			});
		}
	});

	jQuery( '.fusion-mobile-sticky-nav-holder' ).each( function() {
		var $mobileNavHolder = jQuery( this ),
		    $mobileNav       = '',
		    $menu            = jQuery( this ).parent().find( '.fusion-sticky-menu' );

		if ( 'classic' === avadaVars.mobile_menu_design ) {
			$mobileNavHolder.append( '<div class="fusion-mobile-selector"><span>' + avadaVars.dropdown_goto + '</span></div>' );
			jQuery( this ).find( '.fusion-mobile-selector' ).append( '<div class="fusion-selector-down"></div>' );
		}

		jQuery( $mobileNavHolder ).append( jQuery( $menu ).find( '> ul' ).clone() );

		$mobileNav = jQuery( $mobileNavHolder ).find( '> ul' );

		$mobileNav.find( '.fusion-middle-logo-menu-logo, .fusion-menu-cart, .fusion-menu-login-box, .fusion-main-menu-search' ).remove();

		$mobileNav.find( 'li' ).each( function() {
			var classes = 'fusion-mobile-nav-item';
			if ( jQuery( this ).data( 'classes' ) ) {
				classes += ' ' + jQuery( this ).data( 'classes' );
			}

			if ( jQuery( this ).hasClass( 'current-menu-item' ) || jQuery( this ).hasClass( 'current-menu-parent' ) || jQuery( this ).hasClass( 'current-menu-ancestor' ) ) {
				classes += ' fusion-mobile-current-nav-item';
			}

			jQuery( this ).attr( 'class', classes );

			if ( jQuery( this ).attr( 'id' ) ) {
				jQuery( this ).attr( 'id', jQuery( this ).attr( 'id' ).replace( 'menu-item', 'mobile-menu-item' ) );
			}

			jQuery( this ).attr( 'style', '' );
		});

		jQuery( this ).find( '.fusion-mobile-selector' ).click( function() {
			if ( $mobileNav.hasClass( 'mobile-menu-expanded' ) ) {
				$mobileNav.removeClass( 'mobile-menu-expanded' );
			} else {
				$mobileNav.addClass( 'mobile-menu-expanded' );
			}

			$mobileNav.slideToggle( 200, 'easeOutQuad' );
		});
	});

	// Make megamenu items mobile ready
	jQuery( '.fusion-mobile-nav-holder > ul > li' ).each( function() {
		jQuery( this ).find( '.fusion-megamenu-widgets-container' ).remove();

		jQuery( this ).find( '.fusion-megamenu-holder > ul' ).each( function() {
			jQuery( this ).attr( 'class', 'sub-menu' );
			jQuery( this ).attr( 'style', '' );
			jQuery( this ).find( '> li' ).each( function() {

				// Add menu needed menu classes to li elements
				var classes = 'fusion-mobile-nav-item',
				    parentLi;

				if ( jQuery( this ).data( 'classes' ) ) {
					classes += ' ' + jQuery( this ).data( 'classes' );
				}

				if ( jQuery( this ).hasClass( 'current-menu-item' ) || jQuery( this ).hasClass( 'current-menu-parent' ) || jQuery( this ).hasClass( 'current-menu-ancestor' ) || jQuery( this ).hasClass( 'fusion-mobile-current-nav-item' ) ) {
					classes += ' fusion-mobile-current-nav-item';
				}
				jQuery( this ).attr( 'class', classes );

				// Append column titles and title links correctly
				if ( ! jQuery( this ).find( '.fusion-megamenu-title a, > a' ).length ) {
					jQuery( this ).find( '.fusion-megamenu-title' ).each( function() {
						if ( ! jQuery( this ).children( 'a' ).length ) {
							jQuery( this ).append( '<a href="#">' + jQuery( this ).text() + '</a>' );
						}
					});

					if ( ! jQuery( this ).find( '.fusion-megamenu-title' ).length ) {

						parentLi = jQuery( this );

						jQuery( this ).find( '.sub-menu' ).each( function() {
							parentLi.after( jQuery( this ) );

						});
						jQuery( this ).remove();
					}
				}
				jQuery( this ).prepend( jQuery( this ).find( '.fusion-megamenu-title a, > a' ) );

				jQuery( this ).find( '.fusion-megamenu-title' ).remove();
			});
			jQuery( this ).closest( '.fusion-mobile-nav-item' ).append( jQuery( this ) );
		});

		jQuery( this ).find( '.fusion-megamenu-wrapper, .caret, .fusion-megamenu-bullet' ).remove();
	});

	// Mobile Modern Menu
	jQuery( '.fusion-mobile-menu-icons .fusion-icon-bars' ).click( function( e ) {

		var $wrapper;

		e.preventDefault();

		if ( jQuery( '.fusion-header-v4' ).length >= 1 || jQuery( '.fusion-header-v5' ).length >= 1 ) {
			$wrapper = '.fusion-secondary-main-menu';
		} else if ( jQuery( '#side-header' ).length >= 1 ) {
			$wrapper = '#side-header';
		} else {
			$wrapper = '.fusion-header';
		}

		if ( jQuery( '.fusion-is-sticky' ).length >= 1 && jQuery( '.fusion-mobile-sticky-nav-holder' ).length >= 1 ) {
			jQuery( $wrapper ).find( '.fusion-mobile-sticky-nav-holder' ).slideToggle( 200, 'easeOutQuad' );
		} else {
			jQuery( $wrapper ).find( '.fusion-mobile-nav-holder' ).not( '.fusion-mobile-sticky-nav-holder' ).slideToggle( 200, 'easeOutQuad' );
		}
	});

	jQuery( '.fusion-mobile-menu-icons .fusion-icon-search' ).click( function( e ) {
		e.preventDefault();

		jQuery( '.fusion-secondary-main-menu .fusion-secondary-menu-search, .side-header-wrapper .fusion-secondary-menu-search' ).slideToggle( 200, 'easeOutQuad' );
	});

	// Collapse mobile menus when on page anchors are clicked
	jQuery( '.fusion-mobile-nav-holder .fusion-mobile-nav-item a:not([href="#"])' ).click( function() {
		var $target = jQuery( this.hash );
		if ( '' !== $target.length && this.hash.slice( 1 ) ) {
			if ( jQuery( this ).parents( '.fusion-mobile-menu-design-classic' ).length ) {
				jQuery( this ).parents( '.fusion-menu, .menu' )
					.hide()
					.removeClass( 'mobile-menu-expanded' );
			} else {
				jQuery( this ).parents( '.fusion-mobile-nav-holder' ).hide();
			}
		}
	});

	// Make mobile menu sub-menu toggles
	if ( 1 == avadaVars.submenu_slideout ) {
		jQuery( '.fusion-mobile-nav-holder > ul li' ).each( function() {
			var classes = 'fusion-mobile-nav-item';

			if ( jQuery( this ).data( 'classes' ) ) {
				classes += ' ' + jQuery( this ).data( 'classes' );
			}

			if ( jQuery( this ).hasClass( 'current-menu-item' ) || jQuery( this ).hasClass( 'current-menu-parent' ) || jQuery( this ).hasClass( 'current-menu-ancestor' ) || jQuery( this ).hasClass( 'fusion-mobile-current-nav-item' ) ) {
				classes += ' fusion-mobile-current-nav-item';
			}

			jQuery( this ).attr( 'class', classes );

			if ( jQuery( this ).find( ' > ul' ).length ) {
				jQuery( this ).prepend( '<span href="#" aria-haspopup="true" class="fusion-open-submenu"></span>' );

				jQuery( this ).find( ' > ul' ).hide();
			}
		});

		jQuery( '.fusion-mobile-nav-holder .fusion-open-submenu' ).click( function( e ) {
			e.stopPropagation();

			jQuery( this ).parent().children( '.sub-menu' ).slideToggle( 200, 'easeOutQuad' );
		});

		jQuery( '.fusion-mobile-nav-holder a' ).click( function( e ) {
			if ( '#' === jQuery( this ).attr( 'href' ) ) {
				e.preventDefault();
				e.stopPropagation();

				jQuery( this ).prev( '.fusion-open-submenu' ).trigger( 'click' );
			}
		} );
	}

	// Flyout Menu
	function setFlyoutActiveCSS() {

		var $flyoutMenuTopHeight;

		jQuery( 'body' ).bind( 'touchmove', function( e ) {
			if ( ! jQuery( e.target ).parents( '.fusion-flyout-menu' ).length ) {
				e.preventDefault();
			}
		});

		window.$wpadminbarHeight = ( jQuery( '#wpadminbar' ).length ) ? jQuery( '#wpadminbar' ).height() : 0;
		$flyoutMenuTopHeight = jQuery( '.fusion-header-v6-content' ).height() + window.$wpadminbarHeight;

		// Make usre the menu is opened in a way, that menu items do not collide with the header
		if ( jQuery( '.fusion-header-v6' ).hasClass( 'fusion-flyout-menu-active' ) ) {
			jQuery( '.fusion-header-v6 .fusion-flyout-menu' ).css({
				'height': 'calc(100% - ' + $flyoutMenuTopHeight + 'px)',
				'margin-top': $flyoutMenuTopHeight
			});

			if ( jQuery( '.fusion-header-v6 .fusion-flyout-menu .fusion-menu' ).height() > jQuery( '.fusion-header-v6 .fusion-flyout-menu' ).height() ) {
				jQuery( '.fusion-header-v6 .fusion-flyout-menu' ).css( 'display', 'block' );
			}
		}

		// Make sure logo and menu stay sticky on flyout opened, even if sticky header is disabled
		if ( '0' == avadaVars.header_sticky ) {
			jQuery( '.fusion-header-v6 .fusion-header' ).css({
				'position': 'fixed',
				'width': '100%',
				'max-width': '100%',
				'top': window.$wpadminbarHeight,
				'z-index': '210'
			});

			jQuery( '.fusion-header-sticky-height' ).css({
				'display': 'block',
				'height': jQuery( '.fusion-header-v6 .fusion-header' ).height()
			});
		}
	}

	function resetFlyoutActiveCSS() {
		setTimeout( function() {
			jQuery( '.fusion-header-v6 .fusion-flyout-menu' ).css( 'display', '' );

			if ( '0' == avadaVars.header_sticky ) {
				jQuery( '.fusion-header-v6 .fusion-header' ).attr( 'style', '' );
				jQuery( '.fusion-header-sticky-height' ).attr( 'style', '' );
			}
			jQuery( 'body' ).unbind( 'touchmove' );
		}, 250 );
	}

	jQuery( '.fusion-flyout-menu-icons .fusion-flyout-menu-toggle' ).on( 'click', function() {
		var $flyoutContent = jQuery( this ).parents( '.fusion-header-v6' );

		if ( $flyoutContent.hasClass( 'fusion-flyout-active' ) ) {
			if ( $flyoutContent.hasClass( 'fusion-flyout-search-active' ) ) {
				$flyoutContent.addClass( 'fusion-flyout-menu-active' );

				setFlyoutActiveCSS();
			} else {
				$flyoutContent.removeClass( 'fusion-flyout-active' );
				$flyoutContent.removeClass( 'fusion-flyout-menu-active' );

				resetFlyoutActiveCSS();
			}
			$flyoutContent.removeClass( 'fusion-flyout-search-active' );
		} else {
			$flyoutContent.addClass( 'fusion-flyout-active' );
			$flyoutContent.addClass( 'fusion-flyout-menu-active' );

			setFlyoutActiveCSS();
		}
	});

	jQuery( '.fusion-flyout-menu-icons .fusion-flyout-search-toggle' ).on( 'click', function() {
		var $flyoutContent = jQuery( this ).parents( '.fusion-header-v6' );

		if ( $flyoutContent.hasClass( 'fusion-flyout-active' ) ) {
			if ( $flyoutContent.hasClass( 'fusion-flyout-menu-active' ) ) {
				$flyoutContent.addClass( 'fusion-flyout-search-active' );

				// Set focus on search field if not on mobiles
				if ( Modernizr.mq( 'only screen and (min-width:'  + parseInt( avadaVars.side_header_break_point ) +  'px)' ) ) {
					$flyoutContent.find( '.fusion-flyout-search .s' ).focus();
				}
			} else {
				$flyoutContent.removeClass( 'fusion-flyout-active' );
				$flyoutContent.removeClass( 'fusion-flyout-search-active' );

				resetFlyoutActiveCSS();
			}
			$flyoutContent.removeClass( 'fusion-flyout-menu-active' );
		} else {
			$flyoutContent.addClass( 'fusion-flyout-active' );
			$flyoutContent.addClass( 'fusion-flyout-search-active' );

			// Set focus on search field if not on mobiles
			if ( Modernizr.mq( 'only screen and (min-width:'  + parseInt( avadaVars.side_header_break_point ) +  'px)' ) ) {
				$flyoutContent.find( '.fusion-flyout-search .s' ).focus();
			}

			setFlyoutActiveCSS();
		}
	});
});

jQuery( window ).load( function() {

	var $animationDuration,
	    $headerParent,
	    $menuHeight,
	    $menuBorderHeight,
	    $logo,
	    $stickyHeaderScrolled,
	    $standardLogoHeight,
	    $logoImage,
	    resizeWidth,
	    resizeHeight;

	// Sticky Header
	if ( '1' == avadaVars.header_sticky && ( jQuery( '.fusion-header-wrapper' ).length >= 1 || jQuery( '#side-header' ).length >= 1 )  ) {
		$animationDuration = 300;
		if ( '0' == avadaVars.sticky_header_shrinkage ) {
			$animationDuration = 0;
		}
		$headerParent                   = jQuery( '.fusion-header' ).parent();
		window.$headerParentHeight      = $headerParent.outerHeight();
		window.$headerHeight            = jQuery( '.fusion-header' ).outerHeight();
		$menuHeight                     = parseInt( avadaVars.nav_height );
		$menuBorderHeight               = parseInt( avadaVars.nav_highlight_border );
		window.$scrolled_header_height  = 65;
		$logo                           = ( jQuery( '.fusion-logo img:visible' ).length ) ? jQuery( '.fusion-logo img:visible' ) : '';
		$stickyHeaderScrolled           = false;
		window.$stickyTrigger           = jQuery( '.fusion-header' );
		window.$wpadminbarHeight        = ( jQuery( '#wpadminbar' ).length ) ? jQuery( '#wpadminbar' ).height() : 0;
		window.$stickyTrigger_position  = ( window.$stickyTrigger.length ) ? Math.round( window.$stickyTrigger.offset().top ) - window.$wpadminbarHeight - window.$woo_store_notice : 0;
		window.$woo_store_notice        = ( jQuery( '.demo_store' ).length ) ? jQuery( '.demo_store' ).outerHeight() : 0;
		window.$sticky_header_type      = 1;
		window.$logo_height, window.$main_menu_height;
		window.$slider_offset           = 0;
		window.$site_width              = jQuery( '#wrapper' ).outerWidth();
		window.$media_query_test_1      = Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait)' ) ||  Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape)' );
		window.$media_query_test_2      = Modernizr.mq( 'screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' );
		window.$media_query_test_3      = Modernizr.mq( 'screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' );
		window.$media_query_test_4      = Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' );
		$standardLogoHeight             = jQuery( '.fusion-standard-logo' ).height() + parseInt( jQuery( '.fusion-logo' ).data( 'margin-top' ) ) + parseInt( jQuery( '.fusion-logo' ).data( 'margin-bottom' ) );

		window.$initial_desktop_header_height   = Math.max( window.$headerHeight, Math.max( $menuHeight + $menuBorderHeight, $standardLogoHeight ) + parseInt( jQuery( '.fusion-header' ).find( '.fusion-row' ).css( 'padding-top' ) ) + parseInt( jQuery( '.fusion-header' ).find( '.fusion-row' ).css( 'padding-bottom' ) ) );
		window.$initial_sticky_header_shrinkage = avadaVars.sticky_header_shrinkage;
		window.$sticky_can_be_shrinked          = true;

		if ( '0' == avadaVars.sticky_header_shrinkage ) {
			$animationDuration = 0;
			window.$scrolled_header_height = window.$headerHeight;
		}
		if ( $logo ) {

			// Getting the correct natural height of the visible logo
			if ( $logo.hasClass( 'fusion-logo-2x' ) ) {
				$logoImage = new Image();
				$logoImage.src = $logo.attr( 'src' );
				window.original_logo_height = parseInt( $logo.height() ) + parseInt( avadaVars.logo_margin_top ) + parseInt( avadaVars.logo_margin_bottom );
			} else {

				// For normal logo we need to setup the image object to get the natural heights
				$logoImage = new Image();
				$logoImage.src = $logo.attr( 'src' );
				window.original_logo_height = parseInt( $logoImage.naturalHeight ) + parseInt( avadaVars.logo_margin_top ) + parseInt( avadaVars.logo_margin_bottom );

				// IE8, Opera fallback
				$logoImage.onload = function() {
					window.original_logo_height = parseInt( this.height ) + parseInt( avadaVars.logo_margin_top ) + parseInt( avadaVars.logo_margin_bottom );
				};
			}
		}

		// Different sticky header behavior for header v4/v5
		// Instead of header with logo, secondary menu is made sticky
		if ( jQuery( '.fusion-header-v4' ).length >= 1 || jQuery( '.fusion-header-v5' ).length >= 1 ) {
			window.$sticky_header_type = 2;
			if ( 'menu_and_logo' === avadaVars.header_sticky_type2_layout || ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) && 'modern' === avadaVars.mobile_menu_design ) ) {
				window.$stickyTrigger = jQuery( '.fusion-sticky-header-wrapper' );
			} else {
				window.$stickyTrigger = jQuery( '.fusion-secondary-main-menu' );
			}
			window.$stickyTrigger_position = Math.round( window.$stickyTrigger.offset().top ) - window.$wpadminbarHeight - window.$woo_store_notice;
		}

		if ( 1 == window.$sticky_header_type ) {
			if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
				window.$scrolled_header_height = window.$headerHeight;
			} else {
				window.$original_sticky_trigger_height = jQuery( window.$stickyTrigger ).outerHeight();
			}
		}

		if ( 2 == window.$sticky_header_type ) {
			if ( 'classic' === avadaVars.mobile_menu_design ) {
				jQuery( $headerParent ).height( window.$headerParentHeight );
			}

			if ( ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
				jQuery( $headerParent ).height( window.$headerParentHeight );
			} else {
				window.$scrolled_header_height = window.$headerParentHeight;
			}
		}

		// Side Header
		if ( jQuery( '#side-header' ).length >= 1 ) {
			window.$sticky_header_type = 3;
		}

		if ( jQuery( document ).height() - ( window.$initial_desktop_header_height - window.$scrolled_header_height ) < jQuery( window ).height() && 1 == avadaVars.sticky_header_shrinkage ) {
			window.$sticky_can_be_shrinked = false;
			jQuery( '.fusion-header-wrapper' ).removeClass( 'fusion-is-sticky' );
		} else {
			window.$sticky_can_be_shrinked = true;
		}

		resizeWidth = jQuery( window ).width();
		resizeHeight = jQuery( window ).height();

		jQuery( window ).resize( function() {
			var $menuHeight,
			    $menuBorderHeight,
			    $stickyTrigger,
			    $logoHeightWithMargin,
			    $mainMenuWidth,
			    $availableWidth,
			    $positionTop,
			    $scrolledLogoHeight,
			    $scrolledLogoContainerMargin;

			window.$media_query_test_1 = Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait)' ) ||  Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape)' );
			window.$media_query_test_2 = Modernizr.mq( 'screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' );
			window.$media_query_test_3 = Modernizr.mq( 'screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' );
			window.$media_query_test_4 = Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' );

			if ( '1' != avadaVars.header_sticky_tablet && ( window.$media_query_test_1 ) ) {
				jQuery( '.fusion-header-wrapper, .fusion-header-sticky-height, .fusion-header, .fusion-logo, .fusion-header-wrapper .fusion-main-menu > li a, .fusion-header-wrapper .fusion-secondary-main-menu' ).attr( 'style', '' );
				jQuery( '.fusion-header-wrapper' ).removeClass( 'fusion-is-sticky' );
			} else if ( '1' == avadaVars.header_sticky_tablet && ( window.$media_query_test_1 ) ) {
				$animationDuration = 0;
			}

			if ( '1' != avadaVars.header_sticky_mobile && window.$media_query_test_2 ) {
				jQuery( '.fusion-header-wrapper, .fusion-header-sticky-height, .fusion-header, .fusion-logo, .fusion-header-wrapper .fusion-main-menu > li a, .fusion-header-wrapper .fusion-secondary-main-menu' ).attr( 'style', '' );
				jQuery( '.fusion-header-wrapper' ).removeClass( 'fusion-is-sticky' );
			} else if ( '1' == avadaVars.header_sticky_mobile && window.$media_query_test_2 ) {
				$animationDuration = 0;
			}

			if ( jQuery( window ).width() != resizeWidth || jQuery( window ).height() != resizeHeight ) { // Check for actual resize
				$menuHeight = parseInt( avadaVars.nav_height );
				$menuBorderHeight = parseInt( avadaVars.nav_highlight_border );

				if ( jQuery( '#wpadminbar' ).length ) {
					window.$wpadminbarHeight = jQuery( '#wpadminbar' ).height();
				} else {
					window.$wpadminbarHeight = 0;
				}

				window.$woo_store_notice = ( jQuery( '.demo_store' ).length ) ? jQuery( '.demo_store' ).outerHeight() : 0;

				if ( jQuery( '.fusion-is-sticky' ).length ) {
					$stickyTrigger = jQuery( '.fusion-header' );

					if ( 2 == window.$sticky_header_type ) {
						if ( 'menu_only' === avadaVars.header_sticky_type2_layout && ( 'classic' === avadaVars.mobile_menu_design || ! window.$media_query_test_4 ) ) {
							$stickyTrigger = jQuery( '.fusion-secondary-main-menu' );
						} else {
							$stickyTrigger = jQuery( '.fusion-sticky-header-wrapper' );
						}
					}

					if ( jQuery( '#wpadminbar' ).length ) {

						// Unset the top value for all candidates
						jQuery( '.fusion-header, .fusion-sticky-header-wrapper, .fusion-secondary-main-menu' ).css( 'top', '' );

						// Set top value for coreect selector
						jQuery( $stickyTrigger ).css( 'top', window.$wpadminbarHeight + window.$woo_store_notice );
					}

					if ( 'boxed' === avadaVars.layout_mode ) {
						jQuery( $stickyTrigger ).css( 'max-width', jQuery( '#wrapper' ).outerWidth() + 'px' );
					}
				}

				// Refresh header v1, v2, v3 and v6
				if ( 1 == window.$sticky_header_type ) {
					avadaVars.sticky_header_shrinkage = window.$initial_sticky_header_shrinkage;

					if ( jQuery( '.fusion-secondary-header' ).length ) {
						window.$stickyTrigger_position = Math.round( jQuery( '.fusion-secondary-header' ).offset().top )  - window.$wpadminbarHeight - window.$woo_store_notice + jQuery( '.fusion-secondary-header' ).outerHeight();

					// If there is no secondary header, trigger position is 0
					} else {
						window.$stickyTrigger_position = Math.round( jQuery( '.fusion-header' ).offset().top )  - window.$wpadminbarHeight - window.$woo_store_notice;
					}

					// Desktop mode
					if ( ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
						$logoHeightWithMargin = jQuery( '.fusion-logo img:visible' ).outerHeight() + parseInt( avadaVars.logo_margin_top ) + parseInt( avadaVars.logo_margin_bottom );
						$mainMenuWidth = 0;

						// Calculate actual menu width
						jQuery( '.fusion-main-menu > ul > li' ).each( function() {
							$mainMenuWidth += jQuery( this ).outerWidth();
						});

						if ( jQuery( '.fusion-header-v6' ).length ) {
							$mainMenuWidth = 0;
						}

						// Sticky desktop header
						if ( jQuery( '.fusion-is-sticky' ).length ) {
							if ( $mainMenuWidth > ( jQuery( '.fusion-header .fusion-row' ).width() - jQuery( '.fusion-logo img:visible' ).outerWidth() ) ) {
								window.$headerHeight = jQuery( '.fusion-main-menu' ).outerHeight() + $logoHeightWithMargin;
								if ( jQuery( '.fusion-header-v7' ).length ) {
									window.$headerHeight = jQuery( '.fusion-middle-logo-menu' ).height();
								}

								// Headers v2 and v3 have a 1px bottom border
								if ( jQuery( '.fusion-header-v2' ).length || jQuery( '.fusion-header-v3' ).length ) {
									window.$headerHeight += 1;
								}
							} else {
								if ( '0' == avadaVars.sticky_header_shrinkage ) {
									if ( window.original_logo_height > $menuHeight + $menuBorderHeight ) {
										window.$headerHeight = window.original_logo_height;
									} else {
										window.$headerHeight = $menuHeight + $menuBorderHeight;
									}

									window.$headerHeight += parseInt( avadaVars.header_padding_top ) + parseInt( avadaVars.header_padding_bottom );

									// Headers v2 and v3 have a 1px bottom border
									if ( jQuery( '.fusion-header-v2' ).length || jQuery( '.fusion-header-v3' ).length ) {
										window.$headerHeight += 1;
									}
								} else {
									window.$headerHeight = 65;
								}
							}

							window.$scrolled_header_height = window.$headerHeight;

							jQuery( '.fusion-header-sticky-height' ).css( 'height', window.$headerHeight );
							jQuery( '.fusion-header' ).css( 'height', window.$headerHeight );

						// Non sticky desktop header
						} else {
							$availableWidth =  jQuery( '.fusion-header .fusion-row' ).width() - jQuery( '.fusion-logo img:visible' ).outerWidth();
							if ( jQuery( '.fusion-header-v7' ).length ) {
								$availableWidth =  jQuery( '.fusion-header .fusion-row' ).width();
							}
							if ( $mainMenuWidth > $availableWidth ) {
								window.$headerHeight = jQuery( '.fusion-main-menu' ).outerHeight() + $logoHeightWithMargin;
								if ( jQuery( '.fusion-header-v7' ).length ) {
									window.$headerHeight = jQuery( '.fusion-middle-logo-menu' ).height();
								}
								avadaVars.sticky_header_shrinkage = '0';
							} else {
								if ( window.original_logo_height > $menuHeight + $menuBorderHeight ) {
									window.$headerHeight = window.original_logo_height;
								} else {
									window.$headerHeight = $menuHeight + $menuBorderHeight;
								}

								if ( jQuery( '.fusion-header-v7' ).length ) {
									window.$headerHeight = jQuery( '.fusion-main-menu' ).outerHeight();
								}
							}

							window.$headerHeight += parseInt( avadaVars.header_padding_top ) + parseInt( avadaVars.header_padding_bottom );

							// Headers v2 and v3 have a 1px bottom border
							if ( jQuery( '.fusion-header-v2' ).length || jQuery( '.fusion-header-v3' ).length ) {
								window.$headerHeight += 1;
							}

							window.$scrolled_header_height = 65;

							if ( '0' == avadaVars.sticky_header_shrinkage ) {
								window.$scrolled_header_height = window.$headerHeight;
							}

							jQuery( '.fusion-header-sticky-height' ).css( 'height', window.$headerHeight );
							jQuery( '.fusion-header' ).css( 'height', window.$headerHeight );
						}
					}

					// Mobile mode
					if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
						jQuery( '.fusion-header' ).css( 'height', '' );

						window.$headerHeight = jQuery( '.fusion-header' ).outerHeight();
						window.$scrolled_header_height = window.$headerHeight;

						jQuery( '.fusion-header-sticky-height' ).css( 'height', window.$scrolled_header_height );
					}
				}

				// Refresh header v4 and v5
				if ( 2 == window.$sticky_header_type ) {
					if ( 'modern' === avadaVars.mobile_menu_design ) {

						// Desktop mode and sticky active
						if ( ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) && jQuery( '.fusion-is-sticky' ).length && 'menu_only' === avadaVars.header_sticky_type2_layout ) {
							window.$headerParentHeight = jQuery( '.fusion-header' ).parent().outerHeight() + jQuery( '.fusion-secondary-main-menu' ).outerHeight();
						} else {
							window.$headerParentHeight = jQuery( '.fusion-header' ).parent().outerHeight();
						}
						window.$scrolled_header_height = window.header_parent_height;

						// Desktop Mode
						if ( ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
							window.$headerParentHeight = jQuery( '.fusion-header' ).outerHeight() + jQuery( '.fusion-secondary-main-menu' ).outerHeight();
							window.$stickyTrigger_position = Math.round( jQuery( '.fusion-header' ).offset().top )  - window.$wpadminbarHeight - window.$woo_store_notice + jQuery( '.fusion-header' ).outerHeight();

							jQuery( $headerParent ).height( window.$headerParentHeight );
							jQuery( '.fusion-header-sticky-height' ).css( 'height', '' );
						}

						// Mobile Mode
						if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {

							// Trigger position basis is fusion-secondary-header, if there is a secondary header
							if ( jQuery( '.fusion-secondary-header' ).length ) {
								window.$stickyTrigger_position = Math.round( jQuery( '.fusion-secondary-header' ).offset().top )  - window.$wpadminbarHeight - window.$woo_store_notice + jQuery( '.fusion-secondary-header' ).outerHeight();

							// If there is no secondary header, trigger position is 0
							} else {
								window.$stickyTrigger_position = Math.round( jQuery( '.fusion-header' ).offset().top )  - window.$wpadminbarHeight - window.$woo_store_notice;
							}

							jQuery( $headerParent ).height( '' );
							jQuery( '.fusion-header-sticky-height' ).css( 'height', jQuery( '.fusion-sticky-header-wrapper' ).outerHeight() ).hide();
						}
					}

					if ( 'classic' === avadaVars.mobile_menu_design ) {
						window.$headerParentHeight = jQuery( '.fusion-header' ).outerHeight() + jQuery( '.fusion-secondary-main-menu' ).outerHeight();
						window.$stickyTrigger_position = Math.round( jQuery( '.fusion-header' ).offset().top ) - window.$wpadminbarHeight - window.$woo_store_notice + jQuery( '.fusion-header' ).outerHeight();

						jQuery( $headerParent ).height( window.$headerParentHeight );
					}
				}

				// Refresh header v3
				if ( 3 == window.$sticky_header_type ) {
					$positionTop = '';

					// Desktop mode
					if ( ! Modernizr.mq( 'only screen and (max-width:' + avadaVars.side_header_break_point + 'px)' ) ) {
						jQuery( '#side-header-sticky' ).css({
							height: '',
							top: ''
						});

						if ( jQuery( '#side-header' ).hasClass( 'fusion-is-sticky' ) ) {
							jQuery( '#side-header' ).css({
								top: '',
								position: ''
							});

							jQuery( '#side-header' ).removeClass( 'fusion-is-sticky' );
						}
					}
				}

				if ( jQuery( document ).height() - ( window.$initial_desktop_header_height - window.$scrolled_header_height ) < jQuery( window ).height() && 1 == avadaVars.sticky_header_shrinkage ) {
					window.$sticky_can_be_shrinked = false;
					jQuery( '.fusion-header-wrapper' ).removeClass( 'fusion-is-sticky' );
					jQuery( '.fusion-header-sticky-height' ).hide();
					jQuery( '.fusion-header' ).css( 'height', '' );

					jQuery( '.fusion-logo' ).css({
						'margin-top': '',
						'margin-bottom': ''
					});

					jQuery( '.fusion-main-menu > ul > li > a' ).css({
						'height': '',
						'line-height': ''
					});

					jQuery( '.fusion-logo img' ).css( 'height', '' );
				} else {
					window.$sticky_can_be_shrinked = true;

					// Resizing sticky header
					if ( jQuery( '.fusion-is-sticky' ).length >= 1 ) {
						if ( 1 == window.$sticky_header_type && ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {

							// Animate Header Height
							if ( ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
								if ( window.$headerHeight == window.$initial_desktop_header_height ) {
									jQuery( window.$stickyTrigger ).stop( true, true ).animate({
										height: window.$scrolled_header_height
									}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic', complete: function() {
										jQuery( this ).css( 'overflow', 'visible' );
									} });
									jQuery( '.fusion-header-sticky-height' ).show();
									jQuery( '.fusion-header-sticky-height' ).stop( true, true ).animate({
										height: window.$scrolled_header_height
									}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic', complete: function() {
										jQuery( this ).css( 'overflow', 'visible' );
									} });
								} else {
									jQuery( '.fusion-header-sticky-height' ).show();
								}
							} else {
								jQuery( '.fusion-header-sticky-height' ).css( 'height', window.$scrolled_header_height ).show();
							}

							// Animate Logo
							if ( '1' == avadaVars.sticky_header_shrinkage && window.$headerHeight == window.$initial_desktop_header_height ) {
								if ( $logo ) {
									$scrolledLogoHeight = $logo.height();

									if (  $scrolledLogoHeight < window.$scrolled_header_height - 10 ) {
										$scrolledLogoContainerMargin = ( window.$scrolled_header_height - $scrolledLogoHeight ) / 2;
									} else {
										$scrolledLogoHeight = window.$scrolled_header_height - 10;
										$scrolledLogoContainerMargin = 5;
									}

									$logo.stop( true, true ).animate({
										'height': $scrolledLogoHeight
									}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic', complete: function() {
										jQuery( this ).css( 'display', '' );
									}, step: function() {
										jQuery( this ).css( 'display', '' );
									} });
								}

								jQuery( '.fusion-logo' ).stop( true, true ).animate({
									'margin-top': $scrolledLogoContainerMargin,
									'margin-bottom': $scrolledLogoContainerMargin
								}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic' });

								// Animate Menu Height
								if ( ! jQuery( '.fusion-header-v6' ).length ) {
									jQuery( '.fusion-main-menu > ul > li' ).not( '.fusion-middle-logo-menu-logo' ).find( '> a' ).stop( true, true ).animate({
										height: window.$scrolled_header_height - $menuBorderHeight,
										'line-height': window.$scrolled_header_height - $menuBorderHeight
									}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic' });
								}
							}
						}
					}
				}

				resizeWidth = jQuery( window ).width();
				resizeHeight = jQuery( window ).height();
			}
		}); // End resize event

		jQuery( window ).scroll( function() {

			var $scrolledLogoHeight,
			    $scrolledLogoContainerMargin;

			if ( window.$sticky_can_be_shrinked ) {
				if ( '1' != avadaVars.header_sticky_tablet && ( window.$media_query_test_1 ) ) {
					return;
				} else if ( '1' == avadaVars.header_sticky_tablet && ( window.$media_query_test_1 ) ) {
					$animationDuration = 0;
				}

				if ( '1' != avadaVars.header_sticky_mobile && window.$media_query_test_2 ) {
					return;
				} else if ( '1' == avadaVars.header_sticky_mobile && window.$media_query_test_2 ) {
					$animationDuration = 0;
				}

				if ( 3 == window.$sticky_header_type && '1' != avadaVars.header_sticky_mobile ) {
					return;
				}

				if ( 3 == window.$sticky_header_type && '1' == avadaVars.header_sticky_mobile && ! window.$media_query_test_3 ) {
					return;
				}

				// Change the sticky trigger position to the bottom of the mobile menu
				if ( 0 === jQuery( '.fusion-is-sticky' ).length && jQuery( '.fusion-header, .fusion-secondary-main-menu' ).find( '.fusion-mobile-nav-holder > ul' ).is( ':visible' ) ) {
					window.$stickyTrigger_position = Math.round( jQuery( '.fusion-header, .fusion-sticky-header-wrapper' ).find( '.fusion-mobile-nav-holder:visible' ).offset().top ) - window.$wpadminbarHeight - window.$woo_store_notice + jQuery( '.fusion-header, .fusion-sticky-header-wrapper' ).find( '.fusion-mobile-nav-holder:visible' ).height();
				}

				// If sticky header is not active, reassign the triggers
				if ( 3 != window.$sticky_header_type && 0 === jQuery( '.fusion-is-sticky' ).length && ! jQuery( '.fusion-header, .fusion-secondary-main-menu' ).find( '.fusion-mobile-nav-holder > ul' ).is( ':visible' ) ) {
					window.$stickyTrigger = jQuery( '.fusion-header' );
					window.$stickyTrigger_position = Math.round( window.$stickyTrigger.offset().top )  - window.$wpadminbarHeight - window.$woo_store_notice;

					if ( 2 == window.$sticky_header_type ) {
						if ( 'menu_and_logo' === avadaVars.header_sticky_type2_layout || ( window.$media_query_test_4 && 'modern' === avadaVars.mobile_menu_design ) ) {
							window.$stickyTrigger = jQuery( '.fusion-sticky-header-wrapper' );
						} else {
							window.$stickyTrigger = jQuery( '.fusion-secondary-main-menu' );
						}
						window.$stickyTrigger_position = Math.round( window.$stickyTrigger.offset().top )  - window.$wpadminbarHeight - window.$woo_store_notice;
					}

					// Set sticky header height for header v4 and v5
					if ( 'modern' === avadaVars.mobile_menu_design && 2 == window.$sticky_header_type && ( window.$media_query_test_4 || 'menu_and_logo' === avadaVars.header_sticky_type2_layout ) ) {

						// Refresh header height on scroll
						window.$headerHeight = jQuery( window.$stickyTrigger ).outerHeight();
						window.$scrolled_header_height = window.$headerHeight;
						jQuery( '.fusion-header-sticky-height' ).css( 'height', window.$scrolled_header_height ).show();
					}
				}

				if ( jQuery( window ).scrollTop() > window.$stickyTrigger_position ) { // Sticky header mode

					if ( false === $stickyHeaderScrolled ) {
						window.$woo_store_notice = ( jQuery( '.demo_store' ).length ) ? jQuery( '.demo_store' ).outerHeight() : 0;

						jQuery( '.fusion-header-wrapper' ).addClass( 'fusion-is-sticky' );
						jQuery( window.$stickyTrigger ).css( 'top', window.$wpadminbarHeight + window.$woo_store_notice );
						$logo = jQuery( '.fusion-logo img:visible' );

						// Hide all mobile menus
						if ( 'modern' === avadaVars.mobile_menu_design ) {
							jQuery( '.fusion-header, .fusion-secondary-main-menu' ).find( '.fusion-mobile-nav-holder' ).hide();
							jQuery( '.fusion-secondary-main-menu .fusion-main-menu-search .fusion-custom-menu-item-contents' ).hide();
						} else {
							jQuery( '.fusion-header, .fusion-secondary-main-menu' ).find( '.fusion-mobile-nav-holder > ul' ).hide();
						}

						if ( 'modern' === avadaVars.mobile_menu_design ) {

							// Hide normal mobile menu if sticky menu is set in sticky header
							if ( jQuery( '.fusion-is-sticky' ).length >= 1 && jQuery( '.fusion-mobile-sticky-nav-holder' ).length >= 1 && jQuery( '.fusion-mobile-nav-holder' ).is( ':visible' ) ) {
								jQuery( '.fusion-mobile-nav-holder' ).not( '.fusion-mobile-sticky-nav-holder' ).hide();
							}
						}

						if ( 'boxed' === avadaVars.layout_mode ) {
							jQuery( window.$stickyTrigger ).css( 'max-width', jQuery( '#wrapper' ).outerWidth() );

						}

						if ( 1 == window.$sticky_header_type ) {

							// Animate Header Height
							if ( ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
								if ( window.$headerHeight == window.$initial_desktop_header_height ) {
									jQuery( window.$stickyTrigger ).stop( true, true ).animate({
										height: window.$scrolled_header_height
									}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic', complete: function() {
										jQuery( this ).css( 'overflow', 'visible' );
									} });

									jQuery( '.fusion-header-sticky-height' ).show();

									jQuery( '.fusion-header-sticky-height' ).stop( true, true ).animate({
										height: window.$scrolled_header_height
									}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic', complete: function() {
										jQuery( this ).css( 'overflow', 'visible' );
									} });
								} else {
									jQuery( '.fusion-header-sticky-height' ).show();
								}
							} else {
								jQuery( '.fusion-header-sticky-height' ).css( 'height', window.$scrolled_header_height ).show();
							}

							// Add sticky shadow
							setTimeout( function() {
								jQuery( '.fusion-header' ).addClass( 'fusion-sticky-shadow' );
							}, 150 );

							if ( '1' == avadaVars.sticky_header_shrinkage && window.$headerHeight == window.$initial_desktop_header_height ) {

								// Animate header padding
								jQuery( window.$stickyTrigger ).find( '.fusion-row' ).stop( true, true ).animate({
									'padding-top': 0,
									'padding-bottom': 0
								}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic' });

								// Animate Logo
								if ( $logo ) {
									$scrolledLogoHeight = $logo.height();

									$logo.attr( 'data-logo-height', $logo.height() );
									$logo.attr( 'data-logo-width', $logo.width() );

									if (  $scrolledLogoHeight < window.$scrolled_header_height - 10 ) {
										$scrolledLogoContainerMargin = ( window.$scrolled_header_height - $scrolledLogoHeight ) / 2;
									} else {
										$scrolledLogoHeight = window.$scrolled_header_height - 10;
										$scrolledLogoContainerMargin = 5;
									}

									$logo.stop( true, true ).animate({
										'height': $scrolledLogoHeight
									}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic', complete: function() {
										jQuery( this ).css( 'display', '' );
									}, step: function() {
										jQuery( this ).css( 'display', '' );
									} });
								}

								jQuery( '.fusion-logo' ).stop( true, true ).animate({
									'margin-top': $scrolledLogoContainerMargin,
									'margin-bottom': $scrolledLogoContainerMargin
								}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic' });

								// Animate Menu Height
								if ( ! jQuery( '.fusion-header-v6' ).length ) {
									jQuery( '.fusion-main-menu > ul > li' ).not( '.fusion-middle-logo-menu-logo' ).find( '> a' ).stop( true, true ).animate({
										height: window.$scrolled_header_height - $menuBorderHeight,
										'line-height': window.$scrolled_header_height - $menuBorderHeight
									}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic' });
								}
							}

						}

						if ( 2 == window.$sticky_header_type ) {
							if ( 'menu_and_logo' === avadaVars.header_sticky_type2_layout ) {
								jQuery( window.$stickyTrigger ).css( 'height', '' );

								// Refresh header height on scroll
								window.$headerHeight = jQuery( window.$stickyTrigger ).outerHeight();
								window.$scrolled_header_height = window.$headerHeight;
								jQuery( window.$stickyTrigger ).css( 'height', window.$scrolled_header_height );
								jQuery( '.fusion-header-sticky-height' ).css( 'height', window.$scrolled_header_height );
							}

							jQuery( '.fusion-header-sticky-height' ).show();
						}

						if ( 3 == window.$sticky_header_type && Modernizr.mq( 'only screen and (max-width:' + avadaVars.side_header_break_point + 'px)' ) ) {
							jQuery( '#side-header-sticky' ).css({
								height: jQuery( '#side-header' ).outerHeight()
							});

							jQuery( '#side-header' ).css({
								position: 'fixed',
								top: window.$wpadminbarHeight + window.$woo_store_notice
							}).addClass( 'fusion-is-sticky' );
						}

						$stickyHeaderScrolled = true;
					}
				} else if ( jQuery( window ).scrollTop() <= window.$stickyTrigger_position ) {
					jQuery( '.fusion-header-wrapper' ).removeClass( 'fusion-is-sticky' );
					jQuery( '.fusion-header' ).removeClass( 'fusion-sticky-shadow' );
					$logo = jQuery( '.fusion-logo img:visible' );

					if ( 'modern' === avadaVars.mobile_menu_design ) {

						// Hide sticky menu if sticky menu is set in normal header
						if ( 0 === jQuery( '.fusion-is-sticky' ).length && jQuery( '.fusion-mobile-sticky-nav-holder' ).length >= 1 && jQuery( '.fusion-mobile-nav-holder' ).is( ':visible' ) ) {
							jQuery( '.fusion-mobile-sticky-nav-holder' ).hide();
						}
					}

					if ( 1 == window.$sticky_header_type ) {

						// Animate Header Height to Original Size
						if ( ! Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {

							// Done to make sure that resize event while sticky is active doesn't lead to no animation on scroll up
							if ( 1 == window.$sticky_header_type && 65 == window.$headerHeight ) {
								window.$headerHeight = window.$initial_desktop_header_height;
							}

							if ( window.$headerHeight == window.$initial_desktop_header_height ) {
								jQuery( window.$stickyTrigger ).stop( true, true ).animate({
									height: window.$headerHeight
								}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic', complete: function() {
									jQuery( this ).css( 'overflow', 'visible' );
								}, step: function() {
									jQuery( this ).css( 'overflow', 'visible' );
								} });

								jQuery( '.fusion-header-sticky-height' ).stop( true, true ).animate({
									height: window.$headerHeight
								}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic', complete: function() {
									jQuery( this ).css( 'overflow', 'visible' );
								}, step: function() {
									jQuery( this ).css( 'overflow', 'visible' );
								} });
							} else {
								if ( jQuery( '.fusion-header-v7' ).length ) {
									jQuery( '.fusion-header-sticky-height' ).css( 'height', jQuery( '.fusion-middle-logo-menu' ).height() );
									jQuery( '.fusion-header' ).css( 'height', jQuery( '.fusion-middle-logo-menu' ).height() );
								}
							}
							jQuery( '.fusion-header-sticky-height' ).hide();
						} else {
							jQuery( '.fusion-header-sticky-height' ).hide().css( 'height', window.$headerHeight + $menuBorderHeight );
						}

						if ( '1' == avadaVars.sticky_header_shrinkage && window.$headerHeight == window.$initial_desktop_header_height ) {

							// Animate header padding to Original Size
							jQuery( window.$stickyTrigger ).find( '.fusion-row' ).stop( true, true ).animate({
								'padding-top': avadaVars.header_padding_top,
								'padding-bottom': avadaVars.header_padding_bottom
							}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic' });

							// Animate Logo to Original Size
							if ( $logo ) {
								$logo.stop( true, true ).animate({
									'height': $logo.data( 'logo-height' )
								}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic', complete: function() {
									jQuery( this ).css( 'display', '' );
									jQuery( '.fusion-sticky-logo-1x, .fusion-sticky-logo-2x' ).css( 'height', '' );
								} });
							}

							jQuery( '.fusion-logo' ).stop( true, true ).animate({
								'margin-top': jQuery( '.fusion-logo' ).data( 'margin-top' ),
								'margin-bottom': jQuery( '.fusion-logo' ).data( 'margin-bottom' )
							}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic' });

							// Animate Menu Height to Original Size
							if ( ! jQuery( '.fusion-header-v6' ).length ) {
								jQuery( '.fusion-main-menu > ul > li' ).not( '.fusion-middle-logo-menu-logo' ).find( '> a' ).stop( true, true ).animate({
									height: $menuHeight,
									'line-height': $menuHeight
								}, { queue: false, duration: $animationDuration, easing: 'easeOutCubic' });
							}
						}
					}

					if ( 2 == window.$sticky_header_type ) {
						jQuery( '.fusion-header-sticky-height' ).hide();

						if ( 'menu_and_logo' == avadaVars.header_sticky_type2_layout ) {
							jQuery( window.$stickyTrigger ).css( 'height', '' );

							// Refresh header height on scroll
							window.$headerHeight = jQuery( window.$stickyTrigger ).outerHeight();
							window.$scrolled_header_height = window.$headerHeight;
							jQuery( window.$stickyTrigger ).css( 'height', window.$scrolled_header_height );
							jQuery( '.fusion-header-sticky-height' ).css( 'height', window.$scrolled_header_height );
						}

					}

					if ( 3 == window.$sticky_header_type && Modernizr.mq( 'only screen and (max-width:' + avadaVars.side_header_break_point + 'px)' ) ) {
						jQuery( '#side-header-sticky' ).css({
							height: ''
						});

						jQuery( '#side-header' ).css({
							'position': ''
						}).removeClass( 'fusion-is-sticky' );
					}

					$stickyHeaderScrolled = false;
				}

			}
		});

		jQuery( window ).trigger( 'scroll' ); // Trigger scroll for page load

	}

	// Adjust mobile menu when it falls to 2 rows
	window.mobileMenuSepAdded = false;

	function adjustMobileMenuSettings() {
		var menuWidth = 0;

		if ( Modernizr.mq( 'only screen and (max-width: ' + avadaVars.side_header_break_point + 'px)' ) ) {
			jQuery( '.fusion-secondary-menu > ul' ).children( 'li' ).each( function() {
				menuWidth += jQuery( this ).outerWidth( true ) + 2;
			});

			if ( menuWidth > jQuery( window ).width() && jQuery( window ).width() > 318 ) {
				if ( ! window.mobileMenuSepAdded ) {
					jQuery( '.fusion-secondary-menu > ul' ).append( '<div class="fusion-mobile-menu-sep"></div>' );
					jQuery( '.fusion-secondary-menu > ul' ).css( 'position', 'relative' );
					jQuery( '.fusion-mobile-menu-sep' ).css( {
						'position': 'absolute',
						'top': jQuery( '.fusion-secondary-menu > ul > li' ).height() - 1 + 'px',
						'width': '100%',
						'border-bottom-width': '1px',
						'border-bottom-style': 'solid'
					});
					window.mobileMenuSepAdded = true;
				}
			} else {
				jQuery( '.fusion-secondary-menu > ul' ).css( 'position', '' );
				jQuery( '.fusion-secondary-menu > ul' ).find( '.fusion-mobile-menu-sep' ).remove();
				window.mobileMenuSepAdded = false;
			}
		} else {
			jQuery( '.fusion-secondary-menu > ul' ).css( 'position', '' );
			jQuery( '.fusion-secondary-menu > ul' ).find( '.fusion-mobile-menu-sep' ).remove();
			window.mobileMenuSepAdded = false;
		}
	}

	adjustMobileMenuSettings();

	jQuery( window ).on( 'resize', function() {
		adjustMobileMenuSettings();
	});
});

// Reintalize scripts after ajax
jQuery( document ).ajaxComplete( function() {

	var $stickyTrigger,
	    $menuBorderHeight,
	    $menuHeight;

	jQuery( window ).trigger( 'scroll' ); // Trigger scroll for page load

	if ( 1 <= jQuery( '.fusion-is-sticky' ).length && window.$stickyTrigger && 3 != window.$sticky_header_type ) {
		$stickyTrigger    = jQuery( window.$stickyTrigger );
		$menuBorderHeight = parseInt( avadaVars.nav_highlight_border );
		$menuHeight       = $stickyTrigger.height() - $menuBorderHeight;

		if ( 2 == window.$sticky_header_type ) {
			$stickyTrigger = jQuery( '.fusion-secondary-main-menu' );
			$menuHeight    = $stickyTrigger.find( '.fusion-main-menu > ul > li > a' ).height();
		}

		jQuery( '.fusion-main-menu > ul > li' ).not( '.fusion-middle-logo-menu-logo' ).find( '> a' ).css({
			height: $menuHeight + 'px',
			'line-height': $menuHeight + 'px'
		});
	}
});
