/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
   config.filebrowserBrowseUrl='http://192.168.1.15/entropolis/app/webroot/js/ckfinder/ckfinder.html';
   config.filebrowserImageBrowseUrl='http://192.168.1.15/entropolis/app/webroot/js/ckfinder/ckfinder.html?Type=Images';
   config.filebrowserFlashBrowseUrl='http://192.168.1.15/entropolis/app/webroot/js/ckfinder/ckfinder.html?Type=Flash';
   config.filebrowserUploadUrl= 'http://192.168.1.15/entropolis/app/webroot/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
   config.filebrowserImageUploadUrl='http://192.168.1.15/entropolis/app/webroot/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
   config.filebrowserFlashUploadUrl='http://192.168.1.15/entropolis/app/webroot/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	
   CKEDITOR.config.removeButtons = 'Cut,Copy,Print,New Page,Preview,Templates,Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField,Scayt';

//   CKEDITOR.replace( 'description', {
//    toolbar: [
//      //{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
//     // { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
//     // { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
//    { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
//     '/',
//     //{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
//    // { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
//    //  { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
//    // { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
//     //'/',
//     //{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
//    // { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
//     // { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
//      //{ name: 'others', items: [ '-' ] },
//      //{ name: 'about', items: [ 'About' ] }
//  ]
// });

	config.baseHref = "http://192.168.1.15/entropolis/app/webroot/img/";
	config.allowedContent = true;
	
};
