<?php
	$upload_max_filesize = ini_get( "upload_max_filesize" ) ;
	$upload_max_post = ini_get( "post_max_size" ) ;

	if ( $upload_max_filesize && preg_match( "/k/i", $upload_max_filesize ) )
	{
		$temp = Util_Format_Sanatize( $upload_max_filesize, "n" ) ;
		$max_bytes = $temp * 1000 ;
	}
	else if ( $upload_max_filesize && preg_match( "/m/i", $upload_max_filesize ) )
	{
		$temp = Util_Format_Sanatize( $upload_max_filesize, "n" ) ;
		$max_bytes = $temp * 1000000 ;
	}
	else if ( $upload_max_filesize && preg_match( "/g/i", $upload_max_filesize ) )
	{
		$temp = Util_Format_Sanatize( $upload_max_filesize, "n" ) ;
		$max_bytes = $temp * 1000000000 ;
	}
	else { $max_bytes = 500000 ; }

	if ( $upload_max_post && preg_match( "/k/i", $upload_max_post ) )
	{
		$temp = Util_Format_Sanatize( $upload_max_post, "n" ) ;
		$max_post_bytes = $temp * 1000 ;
		$max_post_bytes_ = $max_post_bytes ;
	}
	else if ( $upload_max_post && preg_match( "/m/i", $upload_max_post ) )
	{
		$temp = Util_Format_Sanatize( $upload_max_post, "n" ) ;
		$max_post_bytes = $temp * 1000000 ;
		$max_post_bytes_ = $max_post_bytes ;
	}
	else if ( $upload_max_post && preg_match( "/g/i", $upload_max_post ) )
	{
		$temp = Util_Format_Sanatize( $upload_max_post, "n" ) ;
		$max_post_bytes = $temp * 1000000000 ;
		$max_post_bytes_ = $max_post_bytes ;
	}
	else if ( $upload_max_post ) { $max_post_bytes = $upload_max_post ; $max_post_bytes_ = "$max_post_bytes bytes" ; }

	if ( isset( $VALS["UPLOAD_MAX"] ) )
	{
		$upmax_array = unserialize( $VALS["UPLOAD_MAX"] ) ;
		$max_bytes = $upmax_array["bytes"] ;
	}

	$upload_var = isset( $deptinfo ) ? $deptinfo["vupload"] : $opinfo["upload"] ;
	$upload_formats_array = explode( ",", $upload_var ) ; $upload_formats_string = $upload_formats_js_extensions = "" ;
	for ( $c = 0; $c < count( $upload_formats_array ); ++$c )
	{
		$format = $upload_formats_array[$c] ;
		if ( $format == 1 )
		{
			$upload_formats_string = "GIF, PNG, JPG, JPEG, PDF, ZIP, TAR, TXT, CONF, " ;
			$upload_formats_js_extensions = "'gif','png','jpg','jpeg','pdf','txt','text','conf','zip','tar'," ;
		}
		else if ( $format )
		{
			$upload_formats_string .= $format.", " ;
			$upload_formats_js_extensions .= "'".strtolower( $format )."'," ;
			if ( $format == "JPG" )
			{
				$upload_formats_string .= "JPEG, " ;
				$upload_formats_js_extensions .= "'jpeg'," ;
			}
		}
	}
	if ( $upload_formats_string ) { $upload_formats_string = substr_replace( $upload_formats_string, "", -2 ) ; }
	if ( $upload_formats_js_extensions ) { $upload_formats_js_extensions = substr_replace( $upload_formats_js_extensions, "", -1 ) ; }
	$upload_formats_base64 = base64_encode( $upload_formats_string ) ;
?>
<div style="display: none; position: absolute; top: 0px; left: 0px; padding: 2px; width: 265px; height: 195px; overflow: auto; box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2); z-Index: 1000;" class="info_content" id="file_attach_box">
	<div style="text-align: center; cursor: pointer;" class="info_error" onClick="close_misc('all')"><img src="<?php echo $CONF["BASE_URL"] ?>/themes/<?php echo $theme ?>/close_extra.png" width="16" height="16" border="0"> <?php echo ( isset( $LANG["CHAT_CLOSE"] ) ) ? $LANG["CHAT_CLOSE"] : "Close window" ; ?></div>
	<div id="div_alert" style="display: none; margin-top: 5px;"></div>
	<div style="padding: 10px;">
		<div id="div_upload">
			<form method="POST" action="<?php echo $CONF["BASE_URL"] ?>/addons/file_attach/file_attach_doit.php" enctype="multipart/form-data" id="form_attach" name="form_attach" target='iframe_attach'>
			<input type="hidden" name="action" value="upload">
			<input type="hidden" name="attach_ces" id="attach_ces" value="">
			<input type="hidden" name="attach_status" id="attach_status" value="">
			<input type="hidden" name="attach_dis" id="attach_dis" value="">
			<input type="hidden" name="attach_uf" value="<?php echo $upload_formats_base64 ?>">
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_bytes ?>">
			<div style="margin-top: 10px;">
				<div><input type="file" name="the_file" id="the_file" size="20"></div>
				<div style="margin-top: 15px;"><input type="submit" value="<?php echo ( isset( $LANG["TXT_UPLOAD_FILE"] ) ) ? $LANG["TXT_UPLOAD_FILE"] : "Send File" ; ?>" style="margin-top: 10px; padding: 10px;" id="btn_send_file" class="input_op_button" onClick="do_status_upload(1)"><input type="button" value="<?php echo ( isset( $LANG["TXT_UPLOAD_SEND"] ) ) ? $LANG["TXT_UPLOAD_SEND"] : "Sending..." ; ?> " style="display: none; margin-top: 10px; padding: 10px;" id="btn_send_file_status" class="input_op_button" disabled></div>
			</div>
			</form>
		</div>
		<div id="div_upload_ios" style="display: none; text-align: center;">

			<div style="margin-top: 25px;"><button type="button" class="input_button" onClick="launch_upload_manager()" style="padding: 10px;">Open File Uploader</button></div>

		</div>
	</div>
</div><iframe id="iframe_attach" name="iframe_attach" style="display: none; position: absolute; background: #FFFFFF; top: 0px; left: 0px; width: 325px; height: 100px; border: 1px solid #2D2D2D;"></iframe>
<script data-cfasync="false" type="text/javascript">
<!--
	$('#the_file').bind('change', function() {
		var error = 0 ;
		var upload_ses = "" ;
		var upload_token = "" ;

		if ( ( typeof( this.files ) != "undefined" ) )
		{
			var obj_length = this.files.length ;
			for ( var c = 0; c < obj_length; ++c )
			{
				var thisfile = this.files[c] ;
				if ( thisfile.size > <?php echo $max_bytes ?> )
				{
					error = 1 ;
					$('#the_file').val("") ;
					do_alert_div( base_url_full, 0, "File size must be <?php echo Util_Functions_Bytes($max_bytes, 0) ?> or less." ) ;
					$('#div_alert').fadeTo( "fast", 0.1 ).fadeTo( "fast", 1 ) ;
					break ;
				}
			}
		}

		var file_extension = $('#the_file').val().split('.').pop().toLowerCase() ;
		if ( file_extension && ( $.inArray( file_extension, [<?php echo $upload_formats_js_extensions ?>] ) == -1 ) )
		{
			error = 1 ;
			$('#the_file').val("") ;
			do_alert_div( base_url_full, 0, 'File Upload Formats:<br><?php echo $upload_formats_string ?>' ) ;
			$('#div_alert').fadeTo( "fast", 0.1 ).fadeTo( "fast", 1 ) ;
		}

		if ( !error ) { $('#div_alert').fadeOut("fast") ; }
		else { do_status_upload(0) ; }
	}) ;

	function toggle_file_attach( theforce_close )
	{
		$('#div_alert').hide() ;
		do_status_upload(0) ;
		if ( ( ( ( typeof( ces ) != "undefined" ) && chats[ces]["status"] && !chats[ces]["disconnected"] ) || ( ( typeof( ces ) != "undefined" ) && chats[ces]["disconnected"] && $('#file_attach_box').is(':visible') ) ) || theforce_close )
		{
			set_attach_vars() ;
			if ( $('#file_attach_box').is(':visible') || theforce_close )
			{
				$('#the_file').val("") ;
				$('#file_attach_box').fadeOut("fast") ;
			}
			else
			{
				position_file_attach() ;

				if ( mapp && ( mobile != 2 ) )
				{
					$('#div_upload').hide() ;
					$('#div_upload_ios').show() ;

					file_attach_create_ses() ;
				}

				if ( !isop || mapp )
					$('#file_attach_box').center().fadeIn("fast") ;
				else
					$('#file_attach_box').fadeIn("fast") ;
			}
		}
		else if ( !theforce_close )
		{
			if ( isop )
				do_alert( 0, "A chat session must be active." ) ;
			else
				do_alert( 0, "<?php echo $LANG["CHAT_NOTIFY_DISCONNECT"] ?>" ) ;
		}
	}

	function position_file_attach()
	{
		var attach_pos = $("#chat_file_attach").position() ;
		var height_attach_box = parseInt( $('#file_attach_box').outerHeight() ) ;
		var attach_top = attach_pos.top - height_attach_box - 15 ;
		var attach_left = attach_pos.left ;
		if ( !isop || mapp )
		{
			// center position
		}
		else
			$("#file_attach_box").css({'top': attach_top, 'left': attach_left}) ;
	}

	function upload_success( theattachment, thename )
	{
		$('#the_file').val("") ;
		toggle_file_attach( 1 ) ;

		if ( thename.match( /\.pdf$/i ) )
			add_text_prepare(1, "pdf:"+thename) ;
		else if ( thename.match( /((\.txt)|(\.text))$/i ) )
			add_text_prepare(1, "txt:"+thename) ;
		else if ( thename.match( /\.conf$/i ) )
			add_text_prepare(1, "conf:"+thename) ;
		else if ( thename.match( /\.zip$/i ) )
			add_text_prepare(1, "zip:"+thename) ;
		else if ( thename.match( /\.tar$/i ) )
			add_text_prepare(1, "tar:"+thename) ;
		else
			add_text_prepare(1, "image:"+theattachment+":name:"+thename) ;
	}

	function upload_error( theerror )
	{
		if ( theerror == "" )
			theerror = "Upload POST limit exceeded.<br>File size must be <?php echo $max_post_bytes_ ?> or less." ;

		$('#the_file').val("") ; do_status_upload(0) ;
		do_alert_div( base_url_full, 0, theerror ) ;
	}

	function set_attach_vars()
	{
		if ( typeof( ces ) != "undefined" )
		{
			$('#attach_ces').val(ces) ;
			$('#attach_status').val(chats[ces]["status"]) ;
			$('#attach_dis').val(chats[ces]["disconnected"]) ;
		}
		else
		{
			$('#attach_ces').val('') ;
			$('#attach_status').val(0) ;
			$('#attach_dis').val(1) ;
		}
	}

	function do_status_upload( thestatus )
	{
		if ( thestatus )
		{
			$('#btn_send_file').hide() ;
			$('#btn_send_file_status').show() ;
		}
		else
		{
			$('#btn_send_file_status').hide() ;
			$('#btn_send_file').show() ;
		}
	}

	if ( typeof( window.addEventListener ) != "undefined" )
	{
		window.addEventListener( "dragover", function(e) {
			e = e || event ;
			e.preventDefault() ;
		}, false ) ;
		window.addEventListener( "drop", function(e) {
			e = e || event ;
			e.preventDefault() ;
		}, false ) ;
	}

	function file_attach_create_ses()
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		$.ajax({
		type: "POST",
		url: "../ajax/chat_actions_upload_ses.php",
		data: "action=ses&unique="+unique+"&",
		success: function(data){
			eval( data ) ;
			status_update_flag = 0 ;

			if ( json_data.status )
			{
				upload_ses = json_data.ses ;
				upload_token = json_data.token ;
			}
			else{ $('#div_upload_ios').html( "<div class='info_error'>Error processing upload action.  Log out and login and please try again.</div>" ) ; }
		},
		error:function (xhr, ajaxOptions, thrownError){
			$('#div_upload_ios').html( "<div class='info_error'>Error processing upload action.  Log out and login and please try again [e2].</div>" ) ;
		} });
	}

	function launch_upload_manager()
	{
		var unique = unixtime() ;
		var url_uploader = base_url_full+"/mapp/mapp_file_uploader.php?ses="+upload_ses+"&ces="+phplive_md5( ces )+"&token="+upload_token+"&opid="+isop+"&unique="+unique ;

		toggle_file_attach(1) ;

		external_url = url_uploader ;
		//window.open( url_uploader, '_blank' ) ;
	}

//-->
</script>