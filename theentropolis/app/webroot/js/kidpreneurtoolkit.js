/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//$(window).load(function () {
    $('#btnSearch').click(function () {
        var textSearch=$.trim($('#txtSearch').val());
        if(textSearch==""){
            return false;  // Perform no action if search text box is blank.
        }
        var postForm = {
            'text': $('#txtSearch').val()
        };

        $.ajax({
            url: "kidpreneurToolkits/search_files/1",
            data: postForm,
            type: 'POST',
            success: function (data) {
                if (data.result == "error") {
                    bootbox.alert(data.message);
                } else {
                    $('.listing_container').html(data);
                }
                $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
            }
        });
        return false;
    });

    $('#btnSearchEdit').click(function () {
        var postForm = {
            'text': $('#txtSearchEdit').val()
        };

        $.ajax({
            url: "../kidpreneurToolkits/search_files",
            data: postForm,
            type: 'POST',
            success: function (data) {
                if (data.result == "error") {
                    bootbox.alert({
                        title: "Error!!",
                        message: data.message
                    });
                } else {
                    $('.listing_container').html(data);
                }
                $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
                
                var $body = $('body')
                $body.on('change', '.sublist', function () {
                    fileDirectoryModule.onCheckedFile('.sublist', ['#fileselector', '#editFile', '#deleteFile']);
                });
                $('#editFile, #deleteFile').addClass('opacity0');
                fileDirectoryModule.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector"]);
                fileUploadEventBind()
            }
        });
        return false;
    });

    /*$("#ToolkitEditFileForm").submit(function () {
     var datas = $('#ToolkitEditFileForm').serialize();
     $.ajax({
     url: "../kidpreneurToolkits/edit_file",
     data: datas,
     type: 'POST',
     success: function (data) {
     if (data.result == "error") {
     bootbox.alert(data.message);
     } else {
     $('.listing_container').html(data);
     $("#ToolkitEditFileForm").get(0).reset();
     $("#EditFilePopup").modal('toggle');
     bootbox.alert("File has been updated succesfully");
     }
     }
     });
     return false;
     });*/

    /*$("#ToolkitEditForm").submit(function () {
     var datas = $('#ToolkitEditForm').serialize();
     $.ajax({
     url: "kidpreneurToolkits/edit",
     data: datas,
     type: 'POST',
     success: function (data) {
     if (data.result == "error") {
     bootbox.alert(data.message);
     } else {
     $("#ToolkitAddForm").get(0).reset();
     $("#EditFolderPopup").modal('toggle');
     $('.listing_container').html(data);
     bootbox.alert("Folder has been updated succesfully");
     }
     }
     });
     return false;
     });*/
    var addFormValidation = $('#ToolkitAddForm').validate(
            {
                errorClass: "fileupload-error-fields",
                rules: {
                    'data[KidpreneurToolkit][name]': {
                        required: true,
                        maxlength: 200
                    },
                    'data[KidpreneurToolkit][short_description]': {
                        maxlength: 200
                    },
                    'data[KidpreneurToolkit][description]': {
                        maxlength: 400
                    }
                },
                submitHandler: function (form) {
                    var datas = $('#ToolkitAddForm').serialize();

                    $.ajax({
                        url: "../kidpreneurToolkits/add",
                        data: datas,
                        type: 'POST',
                        success: function (data) {
                            if (data.result == "error") {
                                bootbox.alert({
                                    title: "Error!!",
                                    message: data.message
                                });
                            } else {
                                $("#ToolkitAddForm").get(0).reset();
                                $("#newFolderPopup").modal('toggle');
                                $('.listing_container').html(data);
                                bootbox.alert({
                                    title:"Success!!",
                                    message: "A folder has been created successfully."
                                });
                            }
                            fileUploadEventBind()
                            //$('.custom_scroll').mCustomScrollbar("destroy");

                            setTimeout(function () {
                                $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
                                customScroll();
                                fileDirectoryModule.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector"]);
                            }, 1000);
                        }
                    });
                }
            });

    /*$("#ToolkitAddForm").submit(function () {
     if($("#ToolkitName").val()=="") {
     $(".validation").empty();
     $("#ToolkitName").after("<div class='validation' style='color:red;margin-bottom: 20px;'>Please enter folder name.</div>");
     return false;
     }
     var datas = $('#ToolkitAddForm').serialize();
     
     $.ajax({
     url: "../kidpreneurToolkits/add",
     data: datas,
     type: 'POST',
     success: function (data) {
     if (data.result == "error") {
     bootbox.alert(data.message);
     } else {
     $("#ToolkitAddForm").get(0).reset();
     $("#newFolderPopup").modal('toggle');
     $('.listing_container').html(data);
     bootbox.alert("Folder has been uploaded succesfully");
     }
     }
     });
     return false;
     });*/


    $('#newFolderPopup').on('hide.bs.modal', function () {
        $('#ToolkitAddForm')[0].reset();
        addFormValidation.resetForm();
    });

//});
function clearAllError() {
    $("#advice-title-val").nextAll().remove();
    $("#category-type-val").nextAll().remove();
    $("#descision-type-val").nextAll().remove();
    $("#datepicker-advice-val").nextAll().remove();
    $("#cke_featured_blog_id").nextAll().remove();
}

jQuery("body").on("click", '#delete_folder', function () {
    //var folder_id = $(this).data('id');
    var folder_id = 16;
    getHtml = '<div>Are you sure you want to permanently delete this folder?</div>';
    bootbox.dialog({
        message: getHtml,
        buttons: {
            success: {
                label: "Yes",
                className: "btn-black",
                callback: function () {
                    $.ajax({
                        type: 'POST',
                        url: 'kidpreneurToolkits/delete/' + folder_id,
                        success: function (data) {
                            if (data.result == "error") {
                                bootbox.alert({
                                    title: "Error!!",
                                    message: data.message
                                });
                            } else {
                                bootbox.alert("Folder has been deleted.");
                                $('.listing_container').html(data);
                            }
                        }
                    });
                }
            },
            danger: {
                label: "No",
                className: "btn-black"
            }

        }
    });
    return false;
});

/*
 Title: File upload
 Module Pattern: Anonymous Object Literal return
 */
var fileDirectoryModule = (function () {

    return {

        onCheckedFolder: function (selector, actionOnElm) {
            var checkedCount = $(selector + ' input[type="checkbox"]:checked').length;
            //var multipleChecked =  checkedStatus > 1;
            var activeStatusEdit = $(actionOnElm[0] + ', ' + actionOnElm[3]).hasClass("inactiveActions");
            var activeStatusDelete = $(actionOnElm[1]).hasClass("inactiveActions");
            if (checkedCount === 0 && (activeStatusEdit === false || activeStatusDelete === false)) {
                $(actionOnElm[0] + ',' + actionOnElm[1] + ',' + actionOnElm[2] + ', ' + actionOnElm[3]).addClass('inactiveActions');
            } else if (checkedCount === 1) {
                $(actionOnElm[0] + ',' + actionOnElm[1] + ', ' + actionOnElm[3]).removeClass('inactiveActions');
                $(actionOnElm[2]).removeClass('inactiveActions');
            } else if (checkedCount > 1) {
                $(actionOnElm[0] + ',' + actionOnElm[2] + ', ' + actionOnElm[3]).addClass('inactiveActions');
                $(actionOnElm[1]).removeClass('inactiveActions')
            }

            this.uncheckAllCheckbox(checkedCount)
        },
        onCheckedFile: function (selector, actionOnElm) {
            var checkedCount = $(selector + ' input[type="checkbox"]:checked').length;
            if (checkedCount === 0) {
                $(actionOnElm[1] + ',' + actionOnElm[2]).addClass('inactiveActions');
            } else if (checkedCount === 1) {
                $(actionOnElm[1] + ',' + actionOnElm[2]).removeClass('opacity0 inactiveActions');
            } else if (checkedCount > 1) {
                $(actionOnElm[1]).addClass('inactiveActions');
                $(actionOnElm[2]).removeClass('opacity0 inactiveActions');
            }
        },
        selectAllCheckbox: function (eventOnChk, checkboxList) {
            var selecAllChk = $(eventOnChk).is(':checked');
            $(checkboxList).prop('checked', selecAllChk);
        },
        uncheckAllCheckbox: function (checkedCount) {
            var checkBoxCount = $('.list_block:visible .flex_container input[type="checkbox"]').length;
            if (checkBoxCount > 0 && checkedCount === checkBoxCount) {
                $('#chkSelect').prop('checked', true);
            } else {
                $('#chkSelect').prop('checked', false);
            }
        },
        editFolder: function () {
            var currentElm = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
            var folderContainer = currentElm.parents('.first_col').find('.folder_name');
            var folderName = folderContainer.find('span').text();
            var folderTitle = folderContainer.find('small').text();
            var input = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
            $('#ToolkitEditForm [name="data[KidpreneurToolkit][id]"]').val(input.data("id"));
            $('#ToolkitEditForm [name="data[KidpreneurToolkit][name]"]').val(folderName);
            $('#ToolkitEditForm #KidpreneurToolkitShortDescription').val(folderTitle);
        },
        editDescription: function () {
            var currentElm = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
            var folderContainer = currentElm.parents('.flex_container').find('.folder_short_desc');
            var folderDesc = folderContainer.text();
            $('#EditDescPopup #ToolkitEditDescriptionId').val(currentElm.data("id"));
            $('#EditDescPopup #KidpreneurToolkitDescription').val(folderDesc);
        },
        editFile: function (selector) {
            var currentElm = $(selector +' input[type="checkbox"]:checked');
            var fileContainer = currentElm.parents('.first_col').find('.file_name');
            var fileName = fileContainer.find('span').text();
            var fileTitle = fileContainer.find('small').text();
            $('#ToolkitEditFileForm [name="data[KidpreneurToolkit][id]"]').val(currentElm.data("id"));
            $('#ToolkitEditFileForm [name="data[KidpreneurToolkit][old_name]"]').val(fileName);
            $('#ToolkitEditFileForm [name="data[KidpreneurToolkit][title]"]').val(fileName);
            $('#ToolkitEditFileForm #KidpreneurToolkitShortDescription').val(fileTitle);
        },
        editPageTitleDesc: function (editContent) {
            $('#EditpagePopup #myModalLabel').text('Edit Page ' + editContent);
            var $toolkitTitle = $('#EditpagePopup #pageTitle');
            var $toolkitDesc = $('#EditpagePopup #pageDescription');
            $toolkitTitle.val($('.dashboard-title span').text());
            $toolkitDesc.val($('.toolkit_desc p').text());

            if (editContent === 'title') {
                var toolkitTitle = $('.dashboard-title span').text();
                $toolkitTitle.removeClass('hide').val(toolkitTitle);
                $toolkitDesc.addClass('hide')
            } else {
                var toolkitDesc = $('.toolkit_desc p').text();
                $toolkitTitle.addClass('hide');
                $toolkitDesc.removeClass('hide').val(toolkitDesc);
            }
        },
        eventBind: function (selector) {
            var self = this;
            /* folder checkbox */
            var $body = $('body');
            $body.on('change', '.list_block:visible .flex_container', function () {
                self.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector", "#editDescription"]);
            });
            /* file checkbox */
            $body.on('change', '.sublist.open', function () {
                self.onCheckedFile('.sublist.open', ['#fileselector', '#editFile', '#deleteFile']);
            });
            
            /*select all checkbox */
            $('.list_header:visible').on('click', '#chkSelect', function () {
                self.selectAllCheckbox('#chkSelect', '.list_block:visible .flex_container input[type="checkbox"]');
                self.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector"]);
            });
            /* bind event for edit folder name and title */
            $('.folderManipulationBtnjs').on('click', '#editFolder', function () {
                self.editFolder();
            });
            // bind event for edit folder description
            $('.list_header').on('click', '#editDescriptionBtn', function () {
                self.editDescription();
            });
            // bind event for edit file
            $('.fileManipulationBtnjs').on('click', '#editFile', function () {
                self.editFile('.sublist')
            });
            // bind event for edit folder
            $('.fileManipulationBtnjs').on('click', '#editFolder', function () {
                self.editFolder()
            });
            // bind event for folder description
            $('.list_header').on('click', '#editDescription', function () {
                self.editDescription()
            });
            // bind event for edit page title
            $('.content-wraaper').on('click', '#editPageTitleBtn', function () {
                self.editPageTitleDesc('title');
            });
            // bind event for edit page description
            $('.content-wraaper').on('click', '#editPageDescBtn', function () {
                self.editPageTitleDesc('description');
            });

        }
    }// end of return
})();

fileDirectoryModule.eventBind();

/* plugin accordion
 containerClass: accordionContainer,
 accordionTitle: accordionTitle, 
 accordionbox: accordionBox
 */
(function ($) {
    var defaults = {
        titleClass: '.greyBg',
        containerClass: '.accordionContainer',
        onOpen: null,
        onClose: null
    }
    var settings;
    $.fn.accordionPlugin = function (options) {
        settings = $.extend(true, {}, defaults, options);
        var selector = this;
        eventBind(selector);
    }

    function eventBind(selector) {
        $(selector).off('click').on('click', toggleAccordion);
    }

    function toggleAccordion(e) {
        var currentElem = $(e.target);
        if (currentElem.is('.active')) {
            closeAccordion(currentElem)
        } else {
            if ($('.accordionContainer .accordionBox.open').length) {
                closeAccordion(currentElem)
            }
            openAccordion(currentElem)
        }
    }

    function closeAccordion(currentElem) {
        $('.accordionContainer .accordionBox.open').slideUp(300).removeClass('open');
        // currentElem.siblings('.active').parent().slideUp(300).removeClass('open');
        var activeCurrentElm = currentElem.is('.accordionTitle') && currentElem.is('.active')
        $('.accordionContainer').find('.active').removeClass('active');
        if (settings.onClose && activeCurrentElm) {
            settings.onClose();
        }
    }

    function openAccordion(currentElem) {

        currentElem.addClass('active');
        // currentElem.next().slideDown(300).addClass('open');
        currentElem.parents('.flex_container').siblings('.accordionBox').slideDown(300).addClass('open');
        if (settings.onOpen) {
            settings.onOpen();
        }
    }

})(jQuery);

/* when accordion is open*/
function onAccordionOpen() {
    var fileActionBtn = $('#editFile').hasClass("opacity0");
    if (fileActionBtn) {
        $('#editFile, #deleteFile').removeClass('opacity0');
        fileDirectoryModule.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector"]);
    }
    fileDirectoryModule.onCheckedFile('.sublist.open', ['#fileselector', '#editFile', '#deleteFile']);
}

/* when accordion is close */
function onAccordionClose() {
    var fileActionBtn = $('#editFile').hasClass("opacity0");
    if (!fileActionBtn) {
        $('#editFile, #deleteFile').addClass('opacity0');
        fileDirectoryModule.onCheckedFile('.sublist.open', ['#fileselector', '#editFile', '#deleteFile'])
    }
}

// bind event for accordion
$('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});

$('#deleteFolder').click(function () {
    /*var input = $('.list_block:visible .flex_container input[type="checkbox"]:checked')
     var postForm = {
     'id': input.data("id")
     };
     //var datas = $('#ToolkitEditFileForm').serialize();
     $.ajax({
     url: "parenttoolkits/delete",
     data: postForm,
     type: 'POST',
     success: function (data) {
     if (data.result == "error") {
     alert(data.message);
     } else {
     $('.listing_container').html(data);
     bootbox.alert("File has been updated succesfully");
     }
     }
     });
     return false;*/

    var obj = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
    var file_id = '';
    $.each(obj, function () {
        file_id = file_id + "~" + ($(this).data("id"));
    });

    var postForm = {
        'id': file_id
    };
    var currentElm = $('.sublist.open input[type="checkbox"]:checked');

    getHtml = '<div>Are you sure you want to permanently delete the selected folder(s)?</div>';
    bootbox.dialog({
        title: "Confirm Deletion",
        message: getHtml,
        buttons: {
            success: {
                label: "Yes",
                className: "btn-black",
                callback: function () {
                    $.ajax({
                        type: 'POST',
                        url: '../kidpreneurToolkits/delete/',
                        data: postForm,
                        success: function (data) {
                            if (data.result == "error") {
                                bootbox.alert({
                                    title: "Error!!",
                                    message: data.message
                                });
                            } else {
                                bootbox.alert({
                                    title: "Folder(s) Deleted!!",
                                    message: "Selected Folder(s) has been successfully deleted."
                                });
                                $('.listing_container').html(data);
                            }
                            $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
                            $('#editFile, #deleteFile').addClass('opacity0');
                            fileDirectoryModule.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector", "#editDescription"]);
                            fileUploadEventBind();
                        }
                    });
                }
            },
            danger: {
                label: "No",
                className: "btn-black"
            }

        }
    });
    return false;
});

/*$("#upload-file-selector").change(function () {
 $("#upload_files").submit();
 });*/

/*$("#upload_files").submit(function () {
 
 var input = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
 var postForm = {
 'id': input.data("id")
 };
 var file_data = $('#upload-file-selector').prop('files')[0];
 var form_data = new FormData();
 form_data.append('file', file_data);
 form_data.append('folder_id', input.data("id"));
 
 $.ajax({
 url: 'parenttoolkits/add_file', // point to server-side PHP script 
 dataType: 'text',  // what to expect back from the PHP script, if anything
 cache: false,
 contentType: false,
 processData: false,
 data: form_data,                         
 type: 'post',
 success: function(data){
 if (data.result == "error") {
 alert(data.message);
 } else {
 $('.listing_container').html(data);
 bootbox.alert("File has been uploaded succesfully");
 }
 }
 });
 return false;
 });
 */
jQuery("body").on("click", '#deleteFile', function () {
    var obj = $('.sublist.open input[type="checkbox"]:checked');
    var file_id = '';
    $.each(obj, function () {
        file_id = file_id + "~" + ($(this).data("id"));
    });

    var postForm = {
        'id': file_id
    };
    var currentElm = $('.sublist.open input[type="checkbox"]:checked');

    getHtml = '<div>Are you sure you want to permanently delete the selected file(s)?</div>';
    bootbox.dialog({
        title: "Confirm Deletion",
        message: getHtml,
        buttons: {
            success: {
                label: "Yes",
                className: "btn-black",
                callback: function () {
                    $.ajax({
                        type: 'POST',
                        url: '../kidpreneurToolkits/delete_file/',
                        data: postForm,
                        success: function (data) {
                            if (data.result == "error") {
                                bootbox.alert({
                                    title: "Error!!",
                                    message: data.message
                                });
                            } else {
                                bootbox.alert({
                                    title: "File(s) Deleted!!",
                                    message: "Selected File(s) has been successfully deleted."
                                });
                                //$('.listing_container').html(data);
                                deleteFiles();
                            }
                            $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
                            fileUploadEventBind();
                            $('#editFile, #deleteFile').addClass('opacity0');
                            fileDirectoryModule.onCheckedFile('.sublist.open', ['#fileselector', '#editFile', '#deleteFile']);
                        }
                    });
                }
            },
            danger: {
                label: "No",
                className: "btn-black"
            }

        }
    });
    return false;
});

function deleteFiles() {
    var listofCheckedFiles = $('.sublist.open input[type="checkbox"]:checked');
    listofCheckedFiles.each(function(index, val) {
        console.log(index, val);
        $(this).closest('.row').remove();
    });
}
var pageTitleDescValidation = $('#pagetitleform').validate({
    rules: {
        "data[page][title]": {
            required: true
        },
        "data[page][description]": {
            required: true
        }
    },
    submitHandler: function (form) {
        var page_title = ($("#pageTitle").val());
        var page_desc = ($("#pageDescription").val());
        var datas = $('#pagetitleform').serialize();
        if($("#pageTitle").is(":visible")) {
            var msg = "Page title has been updated.";
        } else {
            var msg = "Page description has been updated.";
        }
        $.ajax({
            url: "../pages/edit",
            data: datas,
            type: 'POST',
            success: function (data) {
                if (data.result == "error") {
                    bootbox.alert({
                        title: "Error!!",
                        message: data.message
                    });
                } else {
                    $("#pagetitleform").get(0).reset();
                    $("#EditpagePopup").modal('toggle');
                    $('.dashboard-title span').text(page_title);
                    $('.toolkit_desc p').text(page_desc);
                    bootbox.alert({
                        title: "Updated",
                        message: msg
                    });
                }
                $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
            }
        });
    }
});

$("#ToolkitEditDescription").submit(function () {

    var datas = $('#ToolkitEditDescription').serialize();
    $.ajax({
        url: "../kidpreneurToolkits/edit_description",
        data: datas,
        type: 'POST',
        success: function (data) {
            if (data.result == "error") {
                bootbox.alert({
                    title: "Error!!",
                    message: data.message
                });
            } else {
                $("#ToolkitAddForm").get(0).reset();
                $("#EditDescPopup").modal('toggle');
                $('.listing_container').html(data);
                bootbox.alert({
                    title: "Success",
                    message: "Folder has been updated succesfully"
                });
            }
            $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
            $('#editFile, #deleteFile').addClass('opacity0');
            fileDirectoryModule.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector", "#editDescription"]);
            fileUploadEventBind()
        }
    });
    return false;
});


/*$("#ToolkitAddVideoForm").submit(function () {
 var datas = $('#ToolkitAddVideoForm').serialize();
 var input = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
 datas+="&folder_id="+input.data("id");
 alert(datas);
 
 $.ajax({
 url: "parenttoolkits/add_file",
 data: datas,
 type: 'POST',
 success: function (data) {
 if (data.result == "error") {
 alert(data.message);
 } else {
 $("#ToolkitAddVideoForm").get(0).reset();
 $("#uploadFile").modal('toggle');
 $('.listing_container').html(data);
 bootbox.alert("Url has been added");
 }
 }
 });
 return false;
 });*/

$("#upload_file").submit(function () {
    //var datas = $('#upload_files').serialize();
    /*$.ajax({
     url: "add_file",
     data: datas,
     type: 'POST',
     success: function (data) {
     if (data.result == "error") {
     alert(data.message);
     } else {
     $('.listing_container').html(data);
     bootbox.alert("File has been updated succesfully");
     }
     }
     });*/
    var input = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
    var postForm = {
        'id': input.data("id")
    };
    var file_data = $('#upload-file-selector').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('folder_id', input.data("id"));

    $.ajax({
        url: '../kidpreneurToolkits/add_file', // point to server-side PHP script 
        dataType: 'json', // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (data) {
            if (data.result == "error") {
                bootbox.alert({
                    title: "Error!!",
                    message: data.message
                });                
                // alert(data.message);
            } else {
                $('.listing_container').html(data);

                bootbox.alert({
                    title: "Success!!",
                    message: "File has been uploaded successfully."
                });
            }
            $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
            fileUploadEventBind()
        }
    });
    return false;
});

$("div.uploadPdfFields, div.uploadLinkFields").hide();

$(function () {
    'use strict';
// form validation for pdf upload    
    $.validator.addMethod('filesize', function (value, element, param) {
        // param = size (in bytes) 
        // element = element to validate (<input>)
        // value = value of the element (file name)
        return this.optional(element) || (element.files[0].size <= param)
    }, "File size must be less than 2MB");

    var validatorPdf = $('#ToolkitAddPdfForm').validate(
            {
                errorClass: "fileupload-error-fields",
                rules: {
                    'files[]': {
                        required: true,
                        extension: 'pdf',
                        filesize: 2097152
                    },
                    title: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    var input = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
                    var postForm = {
                        'id': input.data("id")
                    };
                    var file_data = $('#fileupload').prop('files')[0];
                    var form_data = new FormData();

                    form_data.append('file', file_data);
                    form_data.append('folder_id', input.data("id"));
                    form_data.append('title', $("#pdfTitle").val());
                    form_data.append('short_desc', $("#file_short_desc").val());

                    $.ajax({
                        url: '../kidpreneurToolkits/add_file', // point to server-side PHP script 
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (data) {
                            if (data.result == "error") {
                                bootbox.alert({
                                    title: "Error!!",
                                    message: data.message
                                });
                            } else {
                            var selectedFolderId = $('.list_block:visible .flex_container input[type="checkbox"]:checked').attr('id');
                                $('.listing_container').html(data);
                                $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
                                setTimeout(function() {
                                    addFiles(selectedFolderId);
                                    fileUploadEventBind()
                                    fileDirectoryModule.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector"]);
                                }, 500)
                                bootbox.alert({
                                    title: "Success",
                                    message: "File has been uploaded successfully."
                                });

                            $("#uploadFile").modal("hide");
                            }
                            
                            
                        },
                    });
                    return false;
                    //console.log('pdf upload')
                    //handleFileSelect(form[1]);
                    //form.submit();
                }
            }
    );
function addFiles(folderSelector) {
        $('#'+folderSelector).prop('checked', true);
        $('#'+folderSelector).closest('.first_col').find('.accordionTitle').trigger('click');
}
// form validation of video upload
    var validatorVideo = $('#ToolkitAddVideoForm').validate(
            {
                errorClass: "fileupload-error-fields",
                rules: {
                    'data[KidpreneurToolkit][video_url]': {
                        required: true,
                        url: true
                    },
                    'data[KidpreneurToolkit][title]': {
                        required: true
                    }
                },
                submitHandler: function (form) {

                    var datas = $('#ToolkitAddVideoForm').serialize();
                    var input = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
                    datas += "&folder_id=" + input.data("id");

                    $.ajax({
                        url: "../kidpreneurToolkits/add_file",
                        data: datas,
                        type: 'POST',
                        success: function (data) {
                            if (data.result == "error") {
                                bootbox.alert({
                                    title: "Error!!",
                                    message: data.message
                                });
                            } else {
                            var selectedFolderId = $('.list_block:visible .flex_container input[type="checkbox"]:checked').attr('id');
                                $("#ToolkitAddVideoForm").get(0).reset();
                                $("#uploadFile").modal('toggle');
                                $('.listing_container').html(data);
                                setTimeout(function() {
                                    addFiles(selectedFolderId);
                                    fileUploadEventBind()
                                    fileDirectoryModule.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector"]);
                                }, 500)
                                bootbox.alert({
                                    title: "Success!!",
                                    message: "Link has been uploaded successfully."
                                });
                            }
                            $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
                        }
                    });
                    return false;
                    form.submit();
                }
            }
    );


    $('#uploadFile').on('hide.bs.modal', function () {
        $('#ToolkitAddPdfForm')[0].reset();
        validatorPdf.resetForm();
        $('#ToolkitAddVideoForm')[0].reset();
        validatorVideo.resetForm();
    });

    var editFileFormValidator = $("#ToolkitEditFileForm").validate({
        errorClass: "fileupload-error-fields",
        rules: {
            'data[KidpreneurToolkit][title]': {
                required: true,
                maxlength: 100
            },
            'data[KidpreneurToolkit][short_description]': {
                required: true,
                maxlength: 200
            }
        },
        submitHandler: function (form) {
            var datas = $('#ToolkitEditFileForm').serialize();
            $.ajax({
                url: "../kidpreneurToolkits/edit_file",
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error") {
                        bootbox.alert({
                            title: "Error!!",
                            message: data.message
                        });
                    } else {
                        $('.listing_container').html(data);
                        $("#ToolkitEditFileForm").get(0).reset();
                        $("#EditFilePopup").modal('toggle');
                        bootbox.alert({
                            title: "Success!!",
                            message: "File has been updated successfully."
                        });
                    }
                    $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
                    fileUploadEventBind()
                }
            });
        }
    });
    var editFolderValidator = $('#ToolkitEditForm').validate({
        errorClass: "fileupload-error-fields",
        rules: {
            'data[KidpreneurToolkit][name]': {
                required: true,
                maxlength: 200
            },
            'data[KidpreneurToolkit][short_description]': {
                required: true,
                maxlength: 200
            }
        },
        submitHandler: function (form) {
            console.log('folder title and description edit');
            var datas = $('#ToolkitEditForm').serialize();
            $.ajax({
                url: "../kidpreneurToolkits/edit_folder",
                data: datas,
                type: 'POST',
                success: function (data) {
                    if (data.result == "error") {
                        bootbox.alert({
                            title:"Error!!",
                            message: data.message
                        });
                    } else {
                        $("#ToolkitAddForm").get(0).reset();
                        $("#EditFolderPopup").modal('toggle');
                        $('.listing_container').html(data);
                        bootbox.alert({
                            title: "Success!!",
                            message: "Folder has been updated successfully."
                        });
                    }
                    $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
                    fileDirectoryModule.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector", "#editDescription"]);
                    fileUploadEventBind()
                }
            });
        }
    });

    $('#EditFolderPopup').on('hide.bs.modal', function () {
        $('#ToolkitEditForm')[0].reset();
        editFolderValidator.resetForm();
    });

    $('#EditFilePopup').on('hide.bs.modal', function () {
        $('#ToolkitEditFileForm')[0].reset();
        editFileFormValidator.resetForm();
    });

    $('#EditpagePopup').on('hide.bs.modal', function () {
        pageTitleDescValidation.resetForm();
    });



    fileUploadEventBind()

// add links form validation
var validateLink = $('#ToolkitAddLinkForm').validate(
            {
                errorClass: "fileupload-error-fields",
                rules: {
                    'data[KidpreneurToolkit][link_url]': {
                        required: true,
                        url: true
                    },
                    'data[KidpreneurToolkit][title]': {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    console.log('link form submitted');
                    var datas = $('#ToolkitAddLinkForm').serialize();
                    var input = $('.list_block:visible .flex_container input[type="checkbox"]:checked');
                    datas += "&folder_id=" + input.data("id");

                    $.ajax({
                        url: "../kidpreneurToolkits/add_file",
                        data: datas,
                        type: 'POST',
                        success: function (data) {
                            if (data.result == "error") {
                                bootbox.alert({
                                    title: 'Error!!',
                                    message: data.message
                                });
                            } else {
                            var selectedFolderId = $('.list_block:visible .flex_container input[type="checkbox"]:checked').attr('id');
                                $("#ToolkitAddLinkForm").get(0).reset();
                                $("#uploadFile").modal('toggle');
                                $('.listing_container').html(data);
                                setTimeout(function() {
                                    addFiles(selectedFolderId);
                                    fileUploadEventBind()
                                    fileDirectoryModule.onCheckedFolder('.list_block:visible .flex_container', ["#editFolder", "#deleteFolder", "#fileselector"]);
                                }, 500)
                                bootbox.alert({
                                    title: "Success!!",
                                    message: "Link has been uploaded successfully."
                                });
                            }
                            $('.accordionTitle').accordionPlugin({onOpen: onAccordionOpen, onClose: onAccordionClose});
                        }
                    });
                    return false;
                    form.submit();
                    
                }
            }
    );

/*tab changes*/

$("input[name$='pdfradio']").click(function () {
    var selectedTabVal = $(this).val();

    if (selectedTabVal == "1") {
        validatorPdf.resetForm();
        $('#ToolkitAddPdfForm').get(0).reset();
        $("div.uploadVideoFields, div.uploadLinkFields").hide();
        $("div.uploadPdfFields").show();
    } else if(selectedTabVal == "2") {
        validatorVideo.resetForm();
        $('#ToolkitAddVideoForm').get(0).reset();
        $("div.uploadPdfFields, div.uploadLinkFields").hide();
        $("div.uploadVideoFields").show();
    } else {
        validateLink.resetForm();
        $('#ToolkitAddLinkForm').get(0).reset();
        $("div.uploadPdfFields, div.uploadVideoFields").hide();
        $("div.uploadLinkFields").show();
    }
});

});


// file upload function 
function fileUploadEventBind() {
    $('.third_col').off('click').on('click', '.openFileUpload', function () {
        $('.list_block:visible .flex_container input[type="checkbox"]:checked').prop('checked', false);
        var currrentCheckedStatus = $(this).parents('.flex_container').find('.custom_checkbox input[type="checkbox"]').is(':checked');
        $(this).parents('.flex_container').find('.custom_checkbox input[type="checkbox"]').trigger('click');
        $('#fileselector').trigger('click')
    });
}


function containerToolkit(viewContainer, selector, elmArray, buffer) {
    setTimeout(function () {

        var totalHeight = $(viewContainer || window).outerHeight(true),
                bufferH = buffer || 26,
                minusHeight = 0;
        $.each(elmArray, function (index, value) {
            minusHeight += $(value + ":visible").length ? $(value + ":visible").outerHeight(true) : 0;
            console.log(index, '-', $(value + ":visible").outerHeight(true))
        });
        var calculatedHeight = totalHeight - (minusHeight + bufferH);
        $(selector).height(calculatedHeight);
    }, 1000);
}

/*$(window).resize(function(){
 containerHResponsive();
 });
 */
function containerHResponsive() {
    if ($(window).height() === 1024 || $(window).width() === 1024) {
        containerToolkit('', '.listing_container', ['.main_title', '.title_text', '.toolkit_search', '.upload_conatiner', '.list_header', '.dash_bottom_links'], 30)
    } else {
        containerToolkit('', '.listing_container', ['.upper-links', '.main_title', '.title_text', '.toolkit_search', '.upload_conatiner', '.list_header', '.dash_bottom_links'], 40)
    }
    customScroll();
}

//containerHResponsive();

$('#txtSearch').keypress(function(e) {
    if (e.keyCode == 13) {
        $('#btnSearch').click();
        return false; // prevent the button click from happening
    }
});

$('#txtSearchEdit').keypress(function(e) {
    if (e.keyCode == 13) {
        $('#btnSearchEdit').click();
        return false; // prevent the button click from happening
    }
});



// reset form
$('#uploadFile').on('show.bs.modal', function() {
    $("input[type=text], textarea").val("");
})