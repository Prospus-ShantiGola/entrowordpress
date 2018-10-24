jQuery( document ).ready( function($) {

    $('#fusion-builder-import-file').on('change', FusionPrepareUpload);

    $('.fusion-builder-import-data').on('click', FusionUploadFiles);

    function FusionPrepareUpload(event) {
        if ( $(this).val() !== '' ) {
            $('.fusion-builder-import-data').prop('disabled', false);
        } else {
            $('.fusion-builder-import-data').prop('disabled', true);
        }
        files = event.target.files;
    }

    function FusionUploadFiles(event) {
        if ( event ) {
            event.stopPropagation();
            event.preventDefault();
        }

        var data = new FormData();
        var input_field = $('#fusion-builder-import-file');

        $.each(files, function(key, value) {
            data.append(key, value);
        } );

        data.append('action', 'fusion_builder_importer');

        $.ajax( {
            type: "POST",
            url: fusionBuilderConfig.ajaxurl,
            dataType: 'json',
            contentType: false,
            processData: false,
            data: data,
            cache: false,
            complete : function( data ) {
                input_field.val('');
                $('.fusion-builder-import-success').show();
            }
        } );
    }

} );
