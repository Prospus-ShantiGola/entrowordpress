/*
	Title: File upload
    Module Pattern: Anonymous Object Literal return
*/
var fileDirectoryModule = (function() {

	return {
		
		onCheckedFolder: function(selector, actionOnElm) {
            var checkedCount =  $(selector+' input[type="checkbox"]:checked').length;
            //var multipleChecked =  checkedStatus > 1;
            var activeStatusEdit = $(actionOnElm[0]).hasClass("inactiveActions");
            var activeStatusDelete = $(actionOnElm[1]).hasClass("inactiveActions");
            if(checkedCount === 0 && ( activeStatusEdit === false || activeStatusDelete === false) ) {
                $(actionOnElm[0]+','+ actionOnElm[1]+','+actionOnElm[2]).addClass('inactiveActions');
            }
            else if(checkedCount === 1) {
                $(actionOnElm[0]+','+ actionOnElm[1]).removeClass('inactiveActions');
                $(actionOnElm[2]).removeClass('inactiveActions');
            } else if (checkedCount > 1) {
                $(actionOnElm[0]+','+actionOnElm[2]).addClass('inactiveActions');
            } 

            this.uncheckAllCheckbox(checkedCount)
		},
        onCheckedFile: function(selector, actionOnElm) {
            console.log("onCheckedFile");
            var checkedCount =  $(selector+' input[type="checkbox"]:checked').length;
            if(checkedCount === 0) {
                $(actionOnElm[0]+','+actionOnElm[1]+','+ actionOnElm[2]).addClass('inactiveActions');
            } else if( checkedCount === 1) {
                $(actionOnElm[1]+','+ actionOnElm[2]).removeClass('inactiveActions');
            } else if(checkedCount > 1) {
                $(actionOnElm[1]).addClass('inactiveActions');
                $(actionOnElm[2]).removeClass('inactiveActions');
            }
        },
        selectAllCheckbox: function(eventOnChk, checkboxList) {
            var selecAllChk = $(eventOnChk).is(':checked');
                $(checkboxList).prop('checked', selecAllChk);
        },
        uncheckAllCheckbox: function(checkedCount) {
            var checkBoxCount = $('.list_block:visible .flex_container input[type="checkbox"]').length;
            if(checkedCount === checkBoxCount) {
               $('#chkSelect').prop('checked', true); 
            } else {
               $('#chkSelect').prop('checked', false); 
            }
        },
        editFolder: function() {
            var currentElm = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
            var parentSelector = currentElm.parents('.flex_container').find('.folder_name');
                parentSelector.prop('contenteditable', true);
        },
        editDescription: function() {
            var currentElm = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
            var parentSelector = currentElm.parents('.flex_container').find('.folder_short_desc');
                parentSelector.prop('contenteditable', true);  
        },
		eventBind: function(selector) {
			var self = this;
			/* folder checkbox */
            var $body = $('body');
            $body.on('change', '.list_block:visible .flex_container', function() {
				self.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector"]);
			});
            /* file checkbox */
            $body.on('change', '.sublist.open', function() {
                self.onCheckedFile('.sublist.open', ['#fileselector', '#editFile', '#deleteFile']);
            });
            /*select all checkbox */
            $('.list_header:visible').on('click', '#chkSelect', function() {
                self.selectAllCheckbox('#chkSelect', '.list_block:visible .flex_container input[type="checkbox"]');
                self.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector"]);
            });
            /* bind event for edit folder name and title */
            $('.folderManipulationBtnjs').on('click', '#editFolder', function() {
                self.editFolder();
            });
            // bind event for edit folder description
            $('.list_header').on('click', '#editDescriptionBtn', function() {
                self.editDescription();
            })
            
		}
	}// end of return
})();

fileDirectoryModule.eventBind();

/* plugin accordion
    containerClass: accordionContainer,
    accordionTitle: accordionTitle, 
    accordionbox: accordionBox
*/
(function( $ ) {
    var defaults = {
                    titleClass: '.greyBg',
                    containerClass: '.accordionContainer',
                    onOpen: null,
                    onClose: null
                }
    var settings;
    $.fn.accordionPlugin = function(options) {
            settings = $.extend(true, {}, defaults, options);
        var selector = this;
            eventBind(selector);
    }

    function eventBind(selector) {
        $(selector).on('click', toggleAccordion);
    }

    function toggleAccordion(e) {
        var currentElem = $(e.target);
        if( currentElem.is('.active') ){
            closeAccordion(currentElem)
        } else {
            if( $('.accordionContainer .accordionBox.open').length ) {
                closeAccordion(currentElem)
            }
            openAccordion(currentElem)
        }
    }

    function closeAccordion(currentElem) {
            $('.accordionContainer .accordionBox.open').slideUp(300).removeClass('open');
            // currentElem.siblings('.active').parent().slideUp(300).removeClass('open');
             $('.accordionContainer').find('.active').removeClass('active');
             if(settings.onClose) {
                settings.onClose();
             }
    }

    function openAccordion(currentElem) {

        currentElem.addClass('active');
        // currentElem.next().slideDown(300).addClass('open');
        currentElem.parents('.flex_container').siblings('.accordionBox').slideDown(300).addClass('open');
        if(settings.onOpen) {
            settings.onOpen();
        }
    }

})( jQuery );

/* when accordion is open*/
function onAccordionOpen() {
    var fileActionBtn = $('.fileManipulationBtnjs').is(":visible");
    if( !fileActionBtn ) {    
        $('.fileManipulationBtnjs').fadeIn();
        fileDirectoryModule.onCheckedFile('.sublist.open', ['#fileselector', '#editFile', '#deleteFile']);
        fileDirectoryModule.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector"]);
    }
}

/* when accordion is close */
function onAccordionClose() {
    var fileActionBtn = $('.fileManipulationBtnjs').is(":visible");
    if( fileActionBtn ) {
        $('.fileManipulationBtnjs').fadeOut();
        fileDirectoryModule.onCheckedFile('.sublist.open', ['#fileselector', '#editFile', '#deleteFile'])
    }
}

// bind event for accordion
$('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
