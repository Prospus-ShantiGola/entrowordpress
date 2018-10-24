<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "./web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Email.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$theme = Util_Format_Sanatize( Util_Format_GetVar( "theme" ), "ln" ) ;
	$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
	$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "lns" ) ;
	$cp = Util_Format_Sanatize( Util_Format_GetVar( "cp" ), "n" ) ;
	$chat = Util_Format_Sanatize( Util_Format_GetVar( "chat" ), "n" ) ;
	$pause = Util_Format_Sanatize( Util_Format_GetVar( "pause" ), "n" ) ;
	$disconnect_click = Util_Format_Sanatize( Util_Format_GetVar( "disconnect_click" ), "n" ) ;
	$vname = Util_Format_Sanatize( Util_Format_Sanatize( Util_Format_GetVar( "vname" ), "v" ), "ln" ) ;
	$vemail = Util_Format_Sanatize( Util_Format_GetVar( "vemail" ), "e" ) ;
	$vsubject = rawurldecode( Util_Format_Sanatize( Util_Format_GetVar( "vsubject" ), "htmltags" ) ) ;
	$vquestion = rawurldecode( Util_Format_Sanatize( Util_Format_GetVar( "vquestion" ), "htmltags" ) ) ;
	$onpage = rawurldecode( Util_Format_Sanatize( Util_Format_GetVar( "onpage" ), "url" ) ) ; $onpage = ( $onpage ) ? $onpage : "" ;
	$embed = Util_Format_Sanatize( Util_Format_GetVar( "embed" ), "n" ) ;
	$custom = Util_Format_Sanatize( Util_Format_GetVar( "custom" ), "htmltags" ) ;
	$token = Util_Format_Sanatize( Util_Format_GetVar( "token" ), "ln" ) ;
	$vclick = Util_Format_Sanatize( Util_Format_GetVar( "vclick" ), "n" ) ;
	$dept_themes = ( isset( $VALS["THEMES"] ) ) ? unserialize( $VALS["THEMES"] ) : Array() ;
	if ( !$theme && isset( $dept_themes[$deptid] ) && $deptid ) { $theme = $dept_themes[$deptid] ; }
	else if ( !$theme ) { $theme = $CONF["THEME"] ; }
	else if ( $theme && !is_file( "$CONF[DOCUMENT_ROOT]/themes/$theme/style.css" ) ) { $theme = $CONF["THEME"] ; }
	if ( $theme == "default_v2" ) { $theme = "default" ; }
	else if ( !is_file( "$CONF[DOCUMENT_ROOT]/themes/$theme/style.css" ) ) { $theme = "default" ; }

	$agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : "&nbsp;" ;
	LIST( $ip, $vis_token ) = Util_IP_GetIP( $token ) ;
	LIST( $os, $browser ) = Util_Format_GetOS( $agent ) ;
	$mobile = ( $os == 5 ) ? 1 : 0 ; $error = "" ;

	if ( preg_match( "/$ip/", $VALS["CHAT_SPAM_IPS"] ) ) { $spam_exist = 1 ; }
	else { $spam_exist = 0 ; }

	$departments = Depts_get_AllDepts( $dbh ) ; // needed for logo hash check
	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	$deptvars = Depts_get_DeptVars( $dbh, $deptid ) ;
	$emlogos_hash = ( isset( $VALS["EMLOGOS"] ) ) ? unserialize( $VALS["EMLOGOS"] ) : Array() ;
	if ( !isset( $deptinfo["deptID"] ) )
	{
		$query = isset( $_SERVER["QUERY_STRING"] ) ? Util_Format_Sanatize( $_SERVER["QUERY_STRING"], "query" ) : "" ;
		$query = preg_replace( "/^d=(\d+)&/", "d=0&", $query ) ;
		database_mysql_close( $dbh ) ;
		HEADER( "location: phplive.php?$query&" ) ; exit ;
	}

	if ( $deptinfo["smtp"] )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;
		$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $deptinfo["smtp"] ) ) ;
	}

	if ( $deptinfo["lang"] )
		$CONF["lang"] = $deptinfo["lang"] ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($CONF["lang"], "ln").".php" ) ;

	$extra = "" ;
	if ( $action === "send_email" )
	{
		$trans = Util_Format_Sanatize( Util_Format_GetVar( "trans" ), "n" ) ;

		if ( !$vsubject ) { $vsubject = $LANG["CHAT_JS_LEAVE_MSG"] ; }
		if ( $trans )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;

			$extra = "trans" ;
			$transcript = Chat_ext_get_Transcript( $dbh, $ces ) ;
			$requestinfo = Chat_get_RequestHistCesInfo( $dbh, $transcript["ces"] ) ;
			$opinfo = Ops_get_OpInfoByID( $dbh, $transcript["opID"] ) ;

			// override for emailing transcript
			if ( isset( $deptvars["trans_f_dept"] ) && $deptvars["trans_f_dept"] )
			{
				$from_name = $deptinfo["name"] ;
				$from_email = $deptinfo["email"] ;
			}
			else
			{
				$from_name = $opinfo["name"] ;
				$from_email = $opinfo["email"] ;
			}

			$to_name = $transcript["vname"] ;
			$to_email = $vemail ;

			$custom_vars = ( isset( $requestinfo["custom"] ) && $requestinfo["custom"] ) ? $requestinfo["custom"] : "" ;
			$message = Util_Email_FormatTranscript( $ces, $vquestion, $requestinfo["vname"], $requestinfo["vemail"], $opinfo["name"], $opinfo["email"], $custom_vars, $transcript["formatted"] ) ;
		}
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/IPs/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Messages/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Messages/put.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_ext.php" ) ;

			$ipinfo = IPs_get_IPInfo( $dbh, $vis_token, $ip ) ;
			$referinfo = Footprints_get_IPRefer( $dbh, $vis_token ) ;
			$t_footprints = isset( $ipinfo["t_footprints"] ) ? $ipinfo["t_footprints"] : 1 ;
			$refer_url = ( isset( $referinfo["refer"] ) && $referinfo["refer"] ) ? $referinfo["refer"] : "" ;
			$prev_message_info = ( isset( $ipinfo["t_footprints"] ) ) ? Messages_get_MessageByMd5( $dbh, $vis_token ) : false ;
			if ( !isset( $prev_message_info["created"] ) ) { $prev_message_info = Messages_get_MessageByIP( $dbh, $ip ) ; }

			if ( isset( $prev_message_info["created"] ) && ( time() < ( $prev_message_info["created"] + (60*$VARS_MAIL_SEND_BUFFER) ) ) )
				$error = $LANG["MSG_PROCESSING"] ;
			else
			{
				if ( $deptinfo["savem"] )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Messages/remove.php" ) ;
					Messages_remove_LastMessages( $dbh, $deptinfo["deptID"], $deptinfo["savem"] ) ;
				}
				Messages_put_Message( $dbh, $vis_token, $deptid, $chat, $t_footprints, $ip, $ces, $vname, $vemail, $vsubject, $onpage, $refer_url, $custom, $vquestion ) ;
				if ( $chat )
				{
					if ( $vclick ) { Chat_update_RequestLogValue( $dbh, $ces, "status_msg", 4 ) ; }
					else { Chat_update_RequestLogValue( $dbh, $ces, "status_msg", 2 ) ; }
				}

				$custom_string = "" ;
				$customs = explode( "-cus-", $custom ) ;
				for ( $c = 0; $c < count( $customs ); ++$c )
				{
					$custom_var = $customs[$c] ;
					if ( $custom_var && preg_match( "/-_-/", $custom_var ) )
					{
						LIST( $cus_name, $cus_var ) = explode( "-_-", $custom_var ) ;
						if ( $cus_name ) { $custom_string .= $cus_name.": ".$cus_var."\r\n" ; }
					}
				}

				$from_name = $vname ;
				$from_email = $vemail ;

				$to_name = $deptinfo["name"] ;
				$to_email = $deptinfo["email"] ;

				$message = "Message to $to_name:\r\n\r\n$vquestion\r\n\r\n======= Visitor Information =======\r\n\r\n$custom_string"."Name: $vname\r\nEmail: $vemail\r\n\r\nFootprints: $t_footprints\r\nIP Address: $ip\r\nVisitor ID: $vis_token\r\n\r\nClicked From:\r\n$onpage\r\n\r\n======\r\n\r\n".$LANG["MSG_EMAIL_FOOTER"]."\r\nto: $to_name" ;
			}
		}
		if ( !$error )
		{
			$message = preg_replace( "/&lt;/", "<", $message ) ; $message = preg_replace( "/&gt;/", ">", $message ) ;
			$error = Util_Email_SendEmail( $from_name, $from_email, $to_name, $to_email, $vsubject, $message, $extra ) ;
			if ( !$error && !$cp && $deptinfo["emailm_cc"] )
				Util_Email_SendEmail( $from_name, $from_email, $to_name, $deptinfo["emailm_cc"], $vsubject, $message, $extra ) ;
		}

		if ( !$error )
			$json_data = "json_data = { \"status\": 1 };" ;
		else
			$json_data = "json_data = { \"status\": 0, \"error\": \"$error\" };" ;
		print $json_data ; exit ;
	}
	else if ( $action === "send_email_trans" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/put_itr.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;

		$output = UtilChat_ExportChat( "$ces.txt" ) ;
		if ( !isset( $output[0] ) ) { $transcript = Chat_ext_get_Transcript( $dbh, $ces ) ; }

		if ( isset( $output[0] ) || isset( $transcript["ces"] ) )
		{
			$formatted = isset( $output[0] ) ? preg_replace( "/\"/", "&quot;", preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", $output[0] ) ) : $transcript["formatted"] ;
			Chat_put_itr_Transcript( $dbh, $ces, 1, "null", "null", $deptid, $opid, "null", "null", 0, "null", $vname, $vemail, "null", "null", "null", "null", $formatted, "null", $deptinfo, $deptvars ) ;
			$json_data = "json_data = { \"status\": 1 };" ;
		}
		else
			$json_data = "json_data = { \"status\": 0, \"error\": \"Could not locate chat session file.\" };" ;
		print $json_data ; exit ;
	}
	else
	{
		// on stats db the leave a message is not op specific, just use the current opID to
		// track requests that went to leave a messge
		if ( $ces && $deptid )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;

			$requestinfo = Chat_get_RequestHistCesInfo( $dbh, $ces ) ;
			if ( isset( $requestinfo["status_msg"] ) && !$requestinfo["status_msg"] && ( $requestinfo["status"] != 2 ) && !$requestinfo["op2op"] && ( $vclick != 2 ) )
			{
				if ( $vclick ) { Chat_update_RequestLogValue( $dbh, $ces, "status_msg", 3 ) ; }
				else { Chat_update_RequestLogValue( $dbh, $ces, "status_msg", 1 ) ; }
				Ops_put_itr_OpReqStat( $dbh, $deptid, 0, "message", 1 ) ;
			}
		}
	}

	if ( is_file( "$CONF[TYPE_IO_DIR]/$ces.txt" ) ) { unlink( "$CONF[TYPE_IO_DIR]/$ces.txt" ) ; }

	include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/update.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/remove.php" ) ;
	Queue_update_QueueLogValueByCes( $dbh, $ces, "status", -1, 0 ) ;
	Queue_remove_Queue( $dbh, $ces ) ;

	$deptvars = Depts_get_AllDeptsVars( $dbh ) ; $dept_offline_hasform = 0 ;
	foreach ( $deptvars as $deptid_temp => $deptvar )
	{
		if ( $deptvar["offline_form"] ) { $dept_offline_hasform = 1 ; }
	}
	if ( !count( $deptvars ) ) { $dept_offline_hasform = 1 ; }
	else if ( isset( $deptvars[$deptid] ) ) { $dept_offline_hasform = $deptvars[$deptid]["offline_form"] ; }
	else if ( count( $deptvars ) == 1 )
	{
		if ( $deptid && !isset( $deptvars[$deptid] ) ) { $dept_offline_hasform = 1 ; }
		else if ( !$deptid && ( count( $departments ) > 1 ) ) { $dept_offline_hasform = 1 ; }
	}
?>
<?php include_once( "./inc_doctype.php" ) ?>
<?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?>
<!--
********************************************************************
* PHP Live! (c) OSI Codes Inc.
* www.phplivesupport.com
********************************************************************
-->
<?php endif ; ?>
<head>
<title> <?php echo $LANG["CHAT_WELCOME"] ?> </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=<?php echo $LANG["CHARSET"] ?>">
<?php include_once( "./inc_meta_dev.php" ) ; ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

<link rel="Stylesheet" href="./themes/<?php echo $theme ?>/style.css?<?php echo filemtime ( "./themes/$theme/style.css" ) ; ?>">
<script data-cfasync="false" type="text/javascript" src="./js/global.js?<?php echo filemtime ( "./js/global.js" ) ; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/global_chat.js?<?php echo filemtime ( "./js/global_chat.js" ) ; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/jquery_md5.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	var mobile = ( <?php echo $mobile ?> ) ? is_mobile() : 0 ;
	var phplive_mobile = 0 ; var phplive_ios = 0 ; var embed = <?php echo $embed ?> ;
	var popout = <?php echo ( isset( $VALS["POPOUT"] ) && ( $VALS["POPOUT"] == "on" ) ) ? 1 : 0 ?> ;

	var phplive_userAgent = navigator.userAgent || navigator.vendor || window.opera ;
	if ( phplive_userAgent.match( /iPad/i ) || phplive_userAgent.match( /iPhone/i ) || phplive_userAgent.match( /iPod/i ) )
	{
		phplive_ios = 1 ;
		if ( phplive_userAgent.match( /iPad/i ) ) { phplive_mobile = 0 ; }
		else { phplive_mobile = 1 ; }
	}
	else if ( phplive_userAgent.match( /Android/i ) ) { phplive_mobile = 2 ; }
	var phplive_browser = navigator.appVersion ; var phplive_mime_types = "" ;
	var phplive_display_width = screen.availWidth ; var phplive_display_height = screen.availHeight ; var phplive_display_color = screen.colorDepth ; var phplive_timezone = new Date().getTimezoneOffset() ;
	if ( navigator.mimeTypes.length > 0 ) { for (var x=0; x < navigator.mimeTypes.length; x++) { phplive_mime_types += navigator.mimeTypes[x].description ; } }
	var phplive_browser_token = phplive_md5( phplive_display_width+phplive_display_height+phplive_display_color+phplive_timezone+phplive_browser+phplive_mime_types ) ;
	var win_st_resizing ;
	var si_win_status ; var win_minimized ;

	$(document).ready(function()
	{
		if ( mobile ) { $('#embed_win_popout').hide() ; }
		else if ( popout ) { $('#embed_win_popout').show() ; }

		<?php if ( $disconnect_click && $embed ): ?>
			// future options
		<?php else: ?>
			$('#chat_text_header_sub').show() ;
		<?php endif ; ?>

		$('#token').val( phplive_browser_token ) ;

		$('#chat_submit_btn').show() ;
		if ( <?php echo $dept_offline_hasform ?> ) { $('#table_pre_chat_form').show() ; $('#chat_text_header').show() ; }
		else { $('#chat_submit_btn').css('opacity', '0.0') ; }
		$("body").show() ;

		init_divs_pre() ;
		if ( embed )
			start_win_status_listener() ;
	});
	$(window).resize(function() {
		init_divs_pre() ;
	});

	function init_divs_pre()
	{
		var chat_body_padding = $('#request_body').css('padding-left') ;
		chat_body_padding = ( typeof( chat_body_padding ) != "undefined" ) ? parseInt( chat_body_padding.replace( /px/, "" ) ) : 0 ;

		var browser_height = $('body').height( ) ;
		var buffer_padding = ( mobile ) ? 140 : 150 ;
		var body_height = browser_height - buffer_padding ;
		if ( <?php echo $embed ?> )
		{
			body_height = body_height - 25 - $('#chat_embed_header').height() ;
		}
		body_height = body_height+"px" ;

		var submit_btn_padding_top = ( mobile ) ? 25 : 25 ;
		submit_btn_padding_top = submit_btn_padding_top+"px" ;

		var browser_width = $('body').width( ) ;
		var body_width = browser_width - (chat_body_padding*2) ;
		body_width = body_width+"px" ;

		var chat_btn_left = chat_body_padding+"px" ;

		var deptid_width = $('#request_body').width( ) ;
		var vquestion_width = deptid_width - 15 ;
		var input_width = Math.floor( deptid_width/2 ) - 25 ;

		$('#request_body').css({'height': body_height}) ;
		$('#table_pre_chat_form_table').css({'width': body_width}) ;
		$('#chat_text_powered').css({'margin-right': chat_btn_left, 'font-size': '10px'}) ;
		$('#chat_submit_btn').css({'margin-left': chat_btn_left, 'margin-top': submit_btn_padding_top}) ;
		$('#vdeptid').css({'width': deptid_width}) ;

		$('#vname').css({'width': input_width}) ;
		$('#vemail').css({'width': input_width}) ;
		$('#vsubject').css({'width': input_width}) ;
		$('#vquestion').css({'width': vquestion_width}) ;
		$('#custom_field_input_1').css({'width': input_width}) ;
		$('#custom_field_input_2').css({'width': input_width}) ;
		$('#custom_field_input_3').css({'width': input_width}) ;
		if ( mobile ) { $('#vquestion').css({'height': "45px" }) ; }
	}

	function do_submit()
	{
		if ( !$('#vname').val() )
		{
			$('#vname').addClass('input_focus') ;
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_NAME"] ?>" ) ;
			return false ;
		}
		if ( !$('#vemail').val() )
		{
			$('#vemail').addClass('input_focus') ;
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_EMAIL"] ?>" ) ;
			return false ;
		}
		if ( !check_email( $('#vemail').val() ) )
		{
			$('#vemail').addClass('input_focus') ;
			do_alert( 0, "<?php echo $LANG["CHAT_JS_INVALID_EMAIL"] ?>" ) ;
			return false ;
		}
		if ( !$('#vsubject').val() )
		{
			$('#vsubject').addClass('input_focus') ;
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_SUBJECT"] ?>" ) ;
			if ( $('#div_field_3').is(':visible') ) { $("#request_body").animate({ scrollTop: $(document).height() }, "slow") ; }
			return false ;
		}
		if ( !$('#vquestion').val() )
		{
			$('#vquestion').addClass('input_focus') ;
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_QUESTION"] ?>" ) ;
			if ( $('#div_field_4').is(':visible') ) { $("#request_body").animate({ scrollTop: $(document).height() }, "slow") ; }
			return false ;
		}
		do_it() ;
	}

	function do_it()
	{
		var json_data = new Object ;
		var unique = unixtime() ;
		var vname = $('#vname').val() ;
		var vemail = encodeURIComponent( $('#vemail').val() ) ;
		var vsubject = encodeURIComponent( $('#vsubject').val() ) ;
		var vquestion =  encodeURIComponent( $('#vquestion').val() ) ;
		var onpage =  encodeURIComponent( "<?php echo $onpage ?>" ).replace( /http/g, "hphp" ) ;
		var vclick = <?php echo $vclick ?> ;

		$('#chat_button_start').attr( "disabled", true ) ;
		$.ajax({
		type: "POST",
		url: "./phplive_m.php",
		data: "action=send_email&ces=<?php echo $ces ?>&deptid=<?php echo $deptid ?>&token="+phplive_browser_token+"&chat=<?php echo $chat ?>&vname="+vname+"&vemail="+vemail+"&vsubject="+vsubject+"&vquestion="+vquestion+"&vclick="+vclick+"&onpage="+onpage+"&custom=<?php echo rawurlencode( $custom ) ?>&unique="+unique,
		success: function(data){
			try {
				eval(data) ;
			} catch(err) {
				$('#chat_button_start').attr( "disabled", false ) ;
				do_alert( 0, "Email did not send. [Error: "+err+"]" ) ;
				return false ;
			}

			if ( json_data.status )
			{
				do_alert( 1, "<?php echo $LANG["CHAT_JS_EMAIL_SENT"] ?>" ) ;
				$('#chat_button_start').attr( "disabled", true ) ;
				$('#chat_button_start').html( "<img src=\"./themes/<?php echo $theme ?>/alert_good.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\"> <?php echo $LANG["CHAT_JS_EMAIL_SENT"] ?>" ) ;
			}
			else
			{
				do_alert( 0, json_data.error ) ;
				$('#chat_button_start').attr( "disabled", false ) ;
				$('#chat_button_start').html( "<?php echo $LANG["CHAT_BTN_EMAIL"] ?>" ) ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Email did not send.  Please refresh the page and try again." ) ;
		} });
	}

	function check_mobile_view( theinput, theflag )
	{
		$('#'+theinput).removeClass('input_focus') ;
	}
//-->
</script>
</head>
<body style="display: none; overflow: hidden; -webkit-text-size-adjust: 100%;">
<div id="chat_canvas" style="min-height: 100%; width: 100%;"></div>
<div style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;">
	<?php include_once( "inc_embed_menu.php" ) ; ?>
	<div id="request_body" style="overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch;">

		<?php if ( !$embed || ( $embed && isset( $emlogos_hash[0] ) && $emlogos_hash[0] ) ): ?>
		<div id="chat_logo" style="padding-bottom: 15px;"><img src="<?php echo Util_Upload_GetLogo( "logo", $deptid ) ?>" border=0 style="max-width: 100%; max-height: 100%;"></div>
		<?php endif ; ?>
		<div id="chat_text_header" style="display: none; margin-bottom: 5px;"><?php echo $LANG["MSG_LEAVE_MESSAGE"] ?></div>
		<div id="chat_text_header_sub" style="display: none;"><?php echo ( $chat && $deptinfo["msg_busy"] ) ? $deptinfo["msg_busy"] : $deptinfo["msg_offline"] ; ?></div>

		<form method="POST" action="phplive_m.php" id="theform" accept-charset="<?php echo $LANG["CHARSET"] ?>">
		<input type="hidden" name="action" value="submit">
		<input type="hidden" name="deptid" id="deptid" value="<?php echo $deptid ?>">
		<input type="hidden" name="ces" value="<?php echo $ces ?>">
		<input type="hidden" name="onpage" value="<?php echo urlencode( $onpage ) ?>">
		<input type="hidden" name="vclick" value="<?php echo $vclick ?>">
		<input type="hidden" name="custom" id="custom" value="<?php echo rawurlencode( $custom ) ?>">
		<input type="hidden" name="token" id="token" value="">

		<div id="table_pre_chat_form" style="display: none; margin-top: 15px;">
			<table cellspacing=0 cellpadding=0 border=0 id="table_pre_chat_form_table">
			<tr>
				<td width="50%" style="padding-right: 10px;" id="div_field_1" valign="top">
					<div><?php echo $LANG["TXT_NAME"] ?></div>
					<input type="input" class="input_text" id="vname" name="vname" size="10" maxlength="30" value="<?php echo ( $vname ) ? $vname : "" ; ?>" onKeyPress="return noquotestags(event)" onFocus="check_mobile_view('vname', 1)" onBlur="check_mobile_view('vname', 0)">
				</td>
				<td width="50%" style="padding-left: 10px;" id="div_field_2" valign="top">
					<div><?php echo $LANG["TXT_EMAIL"] ?></div>
					<input type="input" class="input_text" id="vemail" name="vemail" size="10" maxlength="160" value="<?php echo ( $vemail && ( $vemail != "null" ) ) ? $vemail : "" ; ?>" onFocus="check_mobile_view('vemail', 1)" onBlur="check_mobile_view('vemail', 0)" <?php echo ( $vemail && ( $vemail != "null" ) ) ? "tabindex=\"-1\"" : "" ; ?>>
				</td>
			</tr>
			<tr>
				<td width="50%" style="padding-right: 10px; padding-top: 15px;" id="div_field_3" valign="top">
					<div><?php echo $LANG["TXT_SUBJECT"] ?></div>
					<input type="input" class="input_text" id="vsubject" name="vsubject" maxlength="125" value="<?php echo ( $vsubject ) ? $vsubject : "" ; ?>" onFocus="check_mobile_view('vsubject', 1)" onBlur="check_mobile_view('vsubject', 0)">
				</td>
			</tr>
			<tr>
				<td colspan=2 style="padding-top: 15px;" id="div_field_4" valign="top">
					<div><?php echo $LANG["TXT_MESSAGE"] ?></div>
					<textarea class="input_text" id="vquestion" name="vquestion" rows="4" wrap="virtual" style="resize: vertical;" onFocus="check_mobile_view('vquestion', 1)" onBlur="check_mobile_view('vquestion', 0)" <?php echo ( isset( $VALS["AUTOCORRECT_V"] ) && !$VALS["AUTOCORRECT_V"] ) ? "autocomplete=\"off\" autocorrect=\"off\"" : "" ; ?>><?php echo ( $vquestion ) ? preg_replace( "/&lt;br&gt;/i", "\r\n", $vquestion ) : "" ?></textarea>
				</td>
			</tr>
			</table>
		</div>
	</div>
	<div id="chat_submit_btn" style="display: none; padding: 0px !important; width: 160px; z-Index: 15;"><button id="chat_button_start" type="button" class="input_button" style="width: 160px; height: 45px; font-size: 14px; font-weight: bold; padding: 6px;" onClick="do_submit()"><?php echo $LANG["CHAT_BTN_EMAIL"] ?></button></div>
	<div id="chat_text_powered" style="text-align: right; font-size: 10px; opacity: 0.6; filter: alpha(opacity=60); z-Index: 3;"><?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?>&nbsp;<br><a href="https://www.phplivesupport.com/?plk=pi-23-78m-m" target="_blank">PHP Live!</a><?php endif ; ?></div>
</div>
</form>

</body>
</html>
<?php
	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;
?>
