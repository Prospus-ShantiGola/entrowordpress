<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	if ( !is_file( "../web/config.php" ) ){ HEADER("location: ../setup/install.php") ; exit ; }
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_itr.php" ) ;

	$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
	$ses = Util_Format_Sanatize( Util_Format_GetVar( "ses" ), "ln" ) ;
	$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "ln" ) ;
	$token = Util_Format_Sanatize( Util_Format_GetVar( "token" ), "n" ) ;
	$error = "" ;

	$expired = time() - (60*5) ;

	$ces_found = 0 ;
	$dir_files = glob( $CONF["CHAT_IO_DIR"].'/*.txt', GLOB_NOSORT ) ;
	$total_dir_files = count( $dir_files ) ;
	if ( $total_dir_files )
	{
		for ( $c = 0; $c < $total_dir_files; ++$c )
		{
			if ( $dir_files[$c] && is_file( $dir_files[$c] ) )
			{
				if ( $dir_files[$c] && is_file( $dir_files[$c] ) )
				{
					$thisces = str_replace( "$CONF[CHAT_IO_DIR]", "", $dir_files[$c] ) ;
					$thisces = preg_replace( "/[\\/]|(.txt)/", "", $thisces ) ;
					if ( $ces == md5( $thisces ) ) { $ces_found = $thisces ; }
				}
			}
		}
	}
	$dir_files = glob( $CONF["ATTACH_DIR"].'/*.fes', GLOB_NOSORT ) ;
	$total_dir_files = count( $dir_files ) ;
	if ( $total_dir_files )
	{
		for ( $c = 0; $c < $total_dir_files; ++$c )
		{
			if ( $dir_files[$c] && is_file( $dir_files[$c] ) )
			{
				$modtime = filemtime( $dir_files[$c] ) ;
				if ( $modtime < $expired )
				{
					if ( $dir_files[$c] && is_file( $dir_files[$c] ) ) { unlink( $dir_files[$c] ) ; }
				}
			}
		}
	}

	$opinfo = Ops_get_OpInfoByID( $dbh, $opid ) ;
	if ( !isset( $opinfo["opID"] ) || ( md5( $token.$opinfo["ses"] ) != $ses ) || !$ces || !$ces_found )
	{
		print "Invalid action." ; exit ;
	}
	else if ( $token < $expired )
	{
		print "<!doctype html>
<html><head>
<title>  </title>
<meta name='author' content='osicodesinc'>
<meta http-equiv='content-type' content='text/html; CHARSET=utf-8'> 
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height' />
</head>
<body style='padding: 25px;'><div style='font-family: arial; font-size: 12px; background: #FD7D7F; border: 1px solid #E16F71; padding: 5px; color: #FFFFFF; -moz-border-radius: 10px; border-radius: 10px;'>Upload session expired.  <a href='JavaScript:void(0)' onClick='window.close()' style='color: #FFFFFF;'>Close this window</a> and open the file uploader again from the operator console to re-upload the file.</div></body>
</html>" ; exit ;
	}
	
	if ( !is_file( "$CONF[ATTACH_DIR]/$ses.fes" ) ) { touch( "$CONF[ATTACH_DIR]/$ses.fes" ) ; }
	else
	{
		print "<!doctype html>
<html><head>
<title>  </title>
<meta name='author' content='osicodesinc'>
<meta http-equiv='content-type' content='text/html; CHARSET=utf-8'> 
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height' />
</head>
<body style='padding: 25px;'><div style='font-family: arial; font-size: 12px; background: #FD7D7F; border: 1px solid #E16F71; padding: 5px; color: #FFFFFF; -moz-border-radius: 10px; border-radius: 10px;'>Upload session expired.  <a href='JavaScript:void(0)' onClick='window.close()' style='color: #FFFFFF;'>Close this window</a> and open the file uploader again from the operator console to re-upload the file.</div></body>
</html>" ; exit ;
	}

	$requestinfo = Chat_get_itr_RequestCesInfo( $dbh, $ces_found ) ;

	if ( !isset( $requestinfo["ces"] ) )
	{
		print "<!doctype html>
<html><head>
<title>  </title>
<meta name='author' content='osicodesinc'>
<meta http-equiv='content-type' content='text/html; CHARSET=utf-8'> 
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height' />
</head>
<body style='padding: 25px;'><div style='font-family: arial; font-size: 12px; background: #FD7D7F; border: 1px solid #E16F71; padding: 5px; color: #FFFFFF; -moz-border-radius: 10px; border-radius: 10px;'>Chat has ended.</div></body>
</html>" ; exit ;
	}
	setcookie( "cO", $opid, time()+(60*60*24*90), "/" ) ;

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

	$autolinker_js_file = ( isset( $VARS_JS_AUTOLINK_FILE ) && ( ( $VARS_JS_AUTOLINK_FILE == "min" ) || ( $VARS_JS_AUTOLINK_FILE == "src" ) ) ) ? "autolinker_$VARS_JS_AUTOLINK_FILE.js" : "autolinker_min.js" ;

	$upload_var = $opinfo["upload"] ;
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
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> File Uploader </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 
<?php include_once( "../inc_meta_dev.php" ) ; ?>
<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height" />

<link rel="Stylesheet" href="../themes/<?php echo $opinfo["theme"] ?>/style.css?<?php echo filemtime ( "../themes/$opinfo[theme]/style.css" ) ; ?>">
<link rel="Stylesheet" href="../mapp/css/mapp.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="../mapp/js/mapp.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/global_chat.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/jquery.tools.min.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/modernizr.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/<?php echo $autolinker_js_file ?>?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	"use strict" ;
	var base_url = ".." ;
	var base_url_full = "<?php echo $CONF["BASE_URL"] ?>" ;
	var phplive_proto = ( location.href.indexOf("https") == 0 ) ? 1 : 0 ; // to avoid JS proto error, use page proto for areas needing to access the JS objects
	if ( !phplive_proto && ( base_url_full.match( /http/i ) == null ) ) { base_url_full = "http:"+base_url_full ; }
	else if ( phplive_proto && ( base_url_full.match( /https/i ) == null ) ) { base_url_full = "https:"+base_url_full ; }
	var autolinker = new Autolinker( { newWindow: true, stripPrefix: false } ) ;

	var mobile = 0 ;
	var shortcut_enabled = 0 ;
	var widget = 0 ;
	var mapp = 0 ;

	var st_typing ;

	var ces = "<?php echo $ces_found ?>" ;
	var isop = <?php echo $opid ?> ; var isop_ = <?php echo $requestinfo["op2op"] ?> ; var isop__ = <?php echo $opid ?> ; var opc = 1 ;
	var cname = "<?php echo $opinfo["name"] ?>" ; var cemail = "<?php echo $opinfo["email"] ?>" ;

	var chats = new Object ;
	chats[ces] = new Object ;
	chats[ces]["ces"] = "<?php echo $ces_found ?>" ;
	chats[ces]["status"] = 1 ;
	chats[ces]["disconnected"] = 0 ;
	chats[ces]["opid"] = <?php echo $opid ?> ;
	chats[ces]["requestid"] = 0 ;
	chats[ces]["op2op"] = <?php echo $requestinfo["op2op"] ?> ;
	chats[ces]["t_ses"] = 3 ;

	$(document).ready(function()
	{
		$('#div_upload_wrapper').center() ;
		set_attach_vars() ;
	});

//-->
</script>
</head>
<body style="-webkit-text-size-adjust: 100%;">

<div id="div_upload_wrapper" style="position: absolute; display: inline-block; width: 265px; height: 190px; padding: 10px;" class="info_content">

	<div class="info_box" style="margin-bottom: 25px; font-size: 14px; font-weight: bold;">File Uploader</div>

	<div id="div_alert" style="display: none; margin-top: 5px;"></div>
	<div id="div_upload" style="">
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
	<div id="div_upload_success" style="display: none;">
		<div class="info_good"><img src="../pics/icons/thumbs_up.png" width="23" height="23" border="0" alt=""> Upload success!</div>
		<div style="margin-top: 25px;"><a href="JavaScript:void(0)" onClick="window.close()">Close window</a> and return to the Mobile App.</div>
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

	function upload_success( theattachment, thename )
	{
		$('#the_file').val("") ;

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

		$('#div_upload').hide() ;
		$('#div_upload_success').show() ;
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

//-->
</script>

</body>
</html>
<?php
	if ( isset( $dbh ) && $dbh['con'] )
		database_mysql_close( $dbh ) ;
?>
