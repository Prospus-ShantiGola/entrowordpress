<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	if ( !is_file( "../../web/config.php" ) ){ HEADER("location: ../../setup/install.php") ; exit ; }
	include_once( "../../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	if ( !$admininfo = Util_Security_AuthSetup( $dbh ) ){ ErrorHandler( 608, "Invalid setup session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	// STANDARD header end
	/****************************************/

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$SMTP_VERSION = "1.0" ;
	if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/VERSION.php" ) )
		include_once( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/VERSION.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;

	$departments = Depts_get_AllDepts( $dbh ) ;
	$deptinfo = Array() ;
	if ( $deptid )
	{
		$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
		if ( !isset( $deptinfo["deptID"] ) ) { $action = "" ; }
	}
	else if ( count( $departments ) > 0 )
	{
		$deptinfo = $departments[0] ;
	}

	if ( $action === "send_verification" )
	{
		$smtp_type = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_type" ), "ln" ) ) ;
		$smtp_theapi = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_theapi" ), "ln" ) ) ;
		$smtp_theapi_domain = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_theapi_domain" ), "ln" ) ) ;
		$smtp_host = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_host" ), "notags" ) ) ;
		$smtp_login = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_login" ), "notags" ) ) ;
		$smtp_pass = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_pass" ), "notags" ) ) ;
		$smtp_port = Util_Format_Sanatize( Util_Format_GetVar( "smtp_port" ), "n" ) ;
		$smtp_crypt = Util_Format_Sanatize( Util_Format_GetVar( "smtp_crypt" ), "ln" ) ;

		if ( ( ( $smtp_type == "connect" ) && ( $smtp_host && $smtp_login && $smtp_pass && $smtp_port && $smtp_crypt ) ) || ( ( $smtp_type == "api" ) && ( $smtp_theapi == "sendgrid" ) && ( $smtp_login && $smtp_pass ) ) || ( ( $smtp_type == "api" ) && ( $smtp_theapi == "mailgun" ) && ( $smtp_theapi_domain && $smtp_pass ) ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Email.php" ) ;

			$smtp_array = Array() ;
			$smtp_array["host"] = ( $smtp_type == "connect" ) ? $smtp_host : "" ;
			$smtp_array["login"] = ( $smtp_theapi != "mailgun" ) ? $smtp_login : "" ;
			$smtp_array["pass"] = $smtp_pass ;
			$smtp_array["port"] = ( $smtp_type == "connect" ) ? $smtp_port : "" ;
			$smtp_array["crypt"] = ( $smtp_type == "connect" ) ? $smtp_crypt : "null" ;
			$smtp_array["api"] = ( $smtp_type == "api" ) ? $smtp_theapi : "" ;
			$smtp_array["domain"] = ( $smtp_theapi == "mailgun" ) ? $smtp_theapi_domain : "" ;

			if ( !isset( $CONF['SALT'] ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
				$salt = Util_Format_RandomString( 10 ) ;
				Util_Vals_WriteToConfFile( "SALT", $salt ) ;
			}

			$md5 = substr( md5( "$smtp_host $smtp_login $smtp_port $smtp_crypt $CONF[SALT]" ), 0, 5 ) ;
			$message = "\r\n\r\nSMTP Verification Code:\r\n\r\n$md5\r\n\r\n" ;
			$error = Util_Email_SendEmail( $deptinfo["name"], $deptinfo["email"], $deptinfo["name"], $deptinfo["email"], "SMTP Verification Code", $message,  "" ) ;

			if ( !$error )
				$json_data = "json_data = { \"status\": 1, \"email\": \"$deptinfo[email]\" };" ;
			else
				$json_data = "json_data = { \"status\": 0, \"error\": \"$error\" };" ;
		}
		else
			$json_data = "json_data = { \"status\": 0, \"error\": \"All values must be provided.\" };" ;

		print $json_data ; exit ;
	}
	else if ( $action === "verify" )
	{
		$code = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "code" ), "ln" ) ) ;
		$smtp_type = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_type" ), "ln" ) ) ;
		$smtp_theapi = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_theapi" ), "ln" ) ) ;
		$smtp_theapi_domain = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_theapi_domain" ), "ln" ) ) ;
		$smtp_host = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_host" ), "notags" ) ) ;
		$smtp_login = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_login" ), "notags" ) ) ;
		$smtp_pass = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "smtp_pass" ), "notags" ) ) ;
		$smtp_port = Util_Format_Sanatize( Util_Format_GetVar( "smtp_port" ), "n" ) ;
		$smtp_crypt = Util_Format_Sanatize( Util_Format_GetVar( "smtp_crypt" ), "ln" ) ;
		$copy_all = Util_Format_StripQuotes( Util_Format_Sanatize( Util_Format_GetVar( "copy_all" ), "n" ) ) ;

		$md5 = substr( md5( "$smtp_host $smtp_login $smtp_port $smtp_crypt $CONF[SALT]" ), 0, 5 ) ;
		if ( $code == $md5 )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/update.php" ) ;

			$smtp_array = Array() ;
			$smtp_array["host"] = ( $smtp_type == "connect" ) ? $smtp_host : "" ;
			$smtp_array["login"] = ( $smtp_theapi != "mailgun" ) ? $smtp_login : "" ;
			$smtp_array["pass"] = $smtp_pass ;
			$smtp_array["port"] = ( $smtp_type == "connect" ) ? $smtp_port : "" ;
			$smtp_array["crypt"] = ( $smtp_type == "connect" ) ? $smtp_crypt : "null" ;
			$smtp_array["api"] = ( $smtp_type == "api" ) ? $smtp_theapi : "" ;
			$smtp_array["domain"] = ( $smtp_theapi == "mailgun" ) ? $smtp_theapi_domain : "" ;

			$smtp_serialize = Util_Functions_itr_Encrypt( $CONF["SALT"], serialize( $smtp_array ) ) ;

			if ( $copy_all )
			{
				for( $c = 0; $c < count( $departments ); ++$c )
					Depts_update_DeptValue( $dbh, $departments[$c]["deptID"], "smtp", $smtp_serialize ) ;
			}
			else
				Depts_update_DeptValue( $dbh, $deptid, "smtp", $smtp_serialize ) ;

			$json_data = "json_data = { \"status\": 1 };" ;
		}
		else
			$json_data = "json_data = { \"status\": 0, \"error\": \"Invalid verification code.\" };" ;

		print $json_data ; exit ;
	}
	else if ( $action === "clear" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/update.php" ) ;

		Depts_update_DeptValue( $dbh, $deptid, "smtp", "" ) ;
		$deptinfo["smtp"] = Array() ;
	}

	if ( isset( $deptinfo["deptID"] ) && $deptinfo["smtp"] )
	{
		$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $deptinfo["smtp"] ) ) ;
	}
?>
<?php include_once( "../../inc_doctype.php" ) ?>
<head>
<title> PHP Live! Support </title>

<meta name="description" content="PHP Live! Support <?php echo $VERSION ?>">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 

<link rel="Stylesheet" href="../../css/setup.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="../../js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../../js/setup.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../../js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../../js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		$.ajaxSetup({ cache: false }) ;

		$("body").show() ;

		init_menu() ;
		toggle_menu_setup( "extras" ) ;
		show_div( "smtp" ) ;

		<?php if ( isset( $smtp_array["host"] ) && isset( $smtp_array["login"] ) && isset( $smtp_array["pass"] ) && isset( $smtp_array["port"] ) ): ?>
			input_disable() ;
			$('#div_verified').show() ;
		<?php else: ?>
			$('#div_prep').show() ;
		<?php endif ; ?>

		<?php if ( isset( $smtp_array["api"] ) && $smtp_array["api"] ): ?>toggle_type( "api" ) ;
		<?php else: ?>toggle_type( "connect" ) ;<?php endif ; ?>
	});

	function switch_dept( thedeptid )
	{
		location.href = "smtp.php?deptid="+thedeptid ;
	}

	function toggle_type( themenu )
	{
		$(":radio[value="+themenu+"]").prop('checked', true) ;
		if ( themenu == "connect" )
		{
			$('#div_smtp_login').show() ;
			$('#div_smtp_domain').hide() ;
			$('#smtp_input_type_theapi').hide() ;
			$('#div_smtp_host').show() ;
			$('#div_smtp_port').show() ;
			$('#div_smtp_crypt').show() ;
		}
		else
		{
			var smtp_theapi = $('#smtp_input_theapis_select').val() ;

			if ( smtp_theapi == "mailgun" ) { $('#div_smtp_login').hide() ; $('#div_smtp_domain').show() ; }
			else { $('#div_smtp_login').show() ; $('#div_smtp_domain').hide() ; }

			$('#smtp_input_type_theapi').show() ;
			$('#div_smtp_host').hide() ;
			$('#div_smtp_port').hide() ;
			$('#div_smtp_crypt').hide() ;
		}
	}

	function do_submit()
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		var deptid = $('#deptid').val() ;
		var smtp_type = $('input[name=smtp_input_type]:radio:checked').val() ;
		var smtp_theapi = $('#smtp_input_theapis_select').val() ;
		var smtp_host = encodeURIComponent( $('#smtp_input_host').val() ) ;
		var smtp_login = encodeURIComponent( $('#smtp_input_login').val() ) ;
		var smtp_pass = encodeURIComponent( $('#smtp_input_pass').val() ) ;
		var smtp_port = $('#smtp_input_port').val() ;
		var smtp_crypt = $('input:radio[name=smtp_input_crypt]:checked').val() ;
		if ( typeof( smtp_crypt ) == "undefined" ) { smtp_crypt = "null" ; }
		var smtp_theapi_domain = $('#smtp_input_domain').val() ;

		$('#div_alert').fadeOut("slow") ;

		if ( ( smtp_type == "connect" ) && ( !smtp_port || !smtp_login || !smtp_pass || !smtp_port ) )
			do_alert( 0, "All values must be provided." ) ;
		else if ( ( smtp_type == "api" ) && ( ( smtp_theapi == "mailgun" ) && ( !smtp_theapi_domain || !smtp_pass ) ) )
			do_alert( 0, "All values must be provided." ) ;
		else if ( ( smtp_type == "api" ) && ( ( smtp_theapi == "sendgrid" ) && ( !smtp_login || !smtp_pass ) ) )
			do_alert( 0, "All values must be provided." ) ;
		else
		{
			$('#div_verify').hide() ;
			$('#btn_submit').attr("disabled", true) ;
			$('#btn_submit').html('Processing...') ;

			input_disable() ;

			$.ajax({
			type: "POST",
			url: "smtp.php",
			data: "action=send_verification&smtp_type="+smtp_type+"&smtp_theapi="+smtp_theapi+"&smtp_theapi_domain="+smtp_theapi_domain+"&smtp_host="+smtp_host+"&smtp_login="+smtp_login+"&smtp_pass="+smtp_pass+"&smtp_port="+smtp_port+"&smtp_crypt="+smtp_crypt+"&deptid="+deptid+"&"+unique,
			success: function(data){
				eval( data ) ;

				if ( json_data.status )
				{
					$('#dept_email').html( json_data.email ) ;
					$('#text_cancel').hide() ;
					$('#btn_submit').hide() ;
					$('#div_verify').show() ;
				}
				else
				{
					input_enable() ;
					if ( typeof( json_data.error ) == "undefined" )
					{
						// on localhost boxes sometimes it produces blank error
						do_alert_div( "../..", 0, "SMTP information is invalid.  Double check the values and try again. [e2]" ) ;
					}
					else
						do_alert_div( "../..", 0, json_data.error ) ;
				}

				reset_btn() ;
			},
			statusCode: {
				500: function() {
					input_enable() ; reset_btn() ;
					do_alert( 0, "Internal 500 error.  Check the web server error logs for more details." ) ;
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				input_enable() ;
				do_alert( 0, "Connection error.  Refresh the page and try again." ) ;
			} });
		}
	}

	function do_verify()
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		var deptid = $('#deptid').val() ;
		var smtp_type = $('input[name=smtp_input_type]:radio:checked').val() ;
		var smtp_theapi = $('#smtp_input_theapis_select').val() ;
		var smtp_host = encodeURIComponent( $('#smtp_input_host').val() ) ;
		var smtp_login = encodeURIComponent( $('#smtp_input_login').val() ) ;
		var smtp_pass = encodeURIComponent( $('#smtp_input_pass').val() ) ;
		var smtp_port = $('#smtp_input_port').val() ;
		var smtp_crypt = $('input:radio[name=smtp_input_crypt]:checked').val() ;
		if ( typeof( smtp_crypt ) == "undefined" ) { smtp_crypt = "null" ; }
		var smtp_theapi_domain = $('#smtp_input_domain').val() ;
		var copy_all = ( $('#smtp_input_copy_all').is(':checked') ) ? 1 : 0 ;
		var code = $('#code').val() ;

		$.ajax({
		type: "POST",
		url: "smtp.php",
		data: "action=verify&smtp_type="+smtp_type+"&smtp_theapi="+smtp_theapi+"&smtp_theapi_domain="+smtp_theapi_domain+"&smtp_host="+smtp_host+"&smtp_login="+smtp_login+"&smtp_pass="+smtp_pass+"&smtp_port="+smtp_port+"&smtp_crypt="+smtp_crypt+"&deptid="+deptid+"&copy_all="+copy_all+"&code="+code+"&"+unique,
		success: function(data){
			eval( data ) ;

			if ( json_data.status )
			{
				$('#div_prep').hide() ;
				$('#div_verify').hide() ;
				$('#div_verified').show() ;
			}
			else
			{
				do_alert( 0, json_data.error ) ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Connection error.  Refresh the page and try again." ) ;
		} });
	}

	function reset_btn()
	{
		$('#btn_submit').attr("disabled", false) ;
		$('#btn_submit').html('Send Verification Code and Continue') ;
	}

	function resend()
	{
		$('#div_prep').show() ;
		$('#text_cancel').show() ;
		edit_form() ;
	}

	function input_disable()
	{
		$( '#theform' ).find('*').each( function () {
			var div_name = this.id ;
			if ( div_name.indexOf( "smtp_input" ) == 0 )
				this.disabled = true ;
		}) ;
	}

	function input_enable()
	{
		$( '#theform' ).find('*').each( function () {
			var div_name = this.id ;
			if ( div_name.indexOf( "smtp_input" ) == 0 )
				this.disabled = false ;
		}) ;
	}

	function edit_form()
	{
		input_enable() ;
		$('#div_verify').hide() ;
		$('#div_verified').hide() ;
		$('#btn_submit').show() ;
		$('#smtp_input_pass').val("") ;

		$('#smtp_input_host').focus() ;
	}

	function do_clear()
	{
		var deptid = $('#deptid').val() ;

		if ( confirm( "Clear the department SMTP values?" ) )
			location.href = "smtp.php?action=clear&deptid="+deptid ;
	}

	function do_cancel()
	{
		var deptid = $('#deptid').val() ;

		location.href = "smtp.php?deptid="+deptid ;
	}

//-->
</script>
</head>
<?php include_once( "../../setup/inc_header.php" ) ?>

		<?php include_once( "../../setup/inc_menu.php" ) ; ?>

		<form id="theform">
		<input type="hidden" name="action" value="update">

		<div style="margin-top: 25px;">

			<?php if ( count( $departments ) > 0 ): ?>
			<table cellspacing=0 cellpadding=0 border=0 width="100%">
			<tr>
				<td valign="top" width="45%">
					<div style="">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="tab_form_title">Department</div></td>
							<td style="padding-left: 10px;">
								<div style="">
									<select name="deptid" id="deptid" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_dept( this.value )">
									<?php
										for ( $c = 0; $c < count( $departments ); ++$c )
										{
											$department = $departments[$c] ;
											if ( $department["name"] != "Archive" )
											{
												$selected = ( $deptid == $department["deptID"] ) ? "selected" : "" ;
												print "<option value=\"$department[deptID]\" $selected>$department[name]</option>" ;
											}
										}
									?>
									</select>
								</div>
							</td>
						</tr>
						</table>
					</div>

					<div style="margin-top: 15px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td valign="top"><div class="tab_form_title">Connection</div></td>
							<td style="width: 100%; padding-left: 10px; text-shadow: none;">
								<div style="padding: 7px;">
									<div class="li_op round" style="cursor: pointer;" onclick="$('#smtp_input_type_connect').prop('checked', true);toggle_type('connect');"><input type="radio" id="smtp_input_type_connect" name="smtp_input_type" value="connect"> Port Connect</div><div class="li_op round" style="cursor: pointer;"  onclick="$('#smtp_input_type_api').prop('checked', true);toggle_type('api');"><input type="radio" id="smtp_input_type_api" name="smtp_input_type" value="api"> Available APIs</div>
									<div style="clear: both;"></div>
								</div>
								<div id="smtp_input_type_theapi" style="display: none; margin-top: 15px;">
									<select id="smtp_input_theapis_select" name="api_name" style="width: 100%;" onChange="toggle_type( 'api' )"><option value="sendgrid" <?php echo ( isset( $smtp_array["api"] ) && ( $smtp_array["api"] == "sendgrid" ) ) ? "selected" : "" ?>>SendGrid API (sendgrid.com)</option><option value="mailgun" <?php echo ( isset( $smtp_array["api"] ) && ( $smtp_array["api"] == "mailgun" ) ) ? "selected" : "" ?>>Mailgun API (mailgun.com)</option></select>
								</div>
							</td>
						</tr>
						</table>
					</div>
					<div style="margin-top: 15px;" id="div_smtp_host">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="tab_form_title">SMTP Host</div></td>
							<td style="padding-left: 10px;"><input type="text" name="smtp_input_host" id="smtp_input_host" size="35" maxlength="160" onKeyPress="return noquotestags(event)" onFocus="reset_btn()" value="<?php echo ( isset( $smtp_array["host"] ) ) ? $smtp_array["host"] : "" ?>" autocomplete="off"></td>
						</tr>
						</table>
					</div>
					<div style="margin-top: 15px;" id="div_smtp_login">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="tab_form_title">SMTP Login</div></td>
							<td style="padding-left: 10px;"><input type="text" name="smtp_input_login" id="smtp_input_login" size="35" maxlength="160" onKeyPress="return noquotestags(event)" onFocus="reset_btn()" value="<?php echo ( isset( $smtp_array["login"] ) ) ? $smtp_array["login"] : "" ?>" autocomplete="off"></td>
						</tr>
						</table>
					</div>
					<div style="display: none; margin-top: 15px;" id="div_smtp_domain">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="tab_form_title">Domain Name</div></td>
							<td style="padding-left: 10px;"><input type="text" name="smtp_input_domain" id="smtp_input_domain" size="35" maxlength="160" onKeyPress="return noquotestags(event)" onFocus="reset_btn()" value="<?php echo ( isset( $smtp_array["domain"] ) ) ? $smtp_array["domain"] : "" ?>" autocomplete="off"></td>
						</tr>
						</table>
					</div>
					<div style="margin-top: 15px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="tab_form_title">SMTP Password / Key</div></td>
							<td style="padding-left: 10px;"><input type="password" name="smtp_input_pass" id="smtp_input_pass" size="35" maxlength="160" onKeyPress="return noquotestags(event)" onFocus="reset_btn()" value="<?php echo ( isset( $smtp_array["pass"] ) ) ? preg_replace( "/(.)/", "*", $smtp_array["pass"] ) : "" ?>" autocomplete="off"></td>
						</tr>
						</table>
					</div>
					<div style="margin-top: 15px;" id="div_smtp_port">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="tab_form_title">SMTP Port</div></td>
							<td style="padding-left: 10px;">
								<input type="text" name="smtp_input_port" id="smtp_input_port" size="5" maxlength="5" onKeyPress="return numbersonly(event)" onFocus="reset_btn()" value="<?php echo ( isset( $smtp_array["port"] ) ) ? $smtp_array["port"] : "587" ?>" autocomplete="off">
							</td>
						</tr>
						</table>
					</div>
					<div style="margin-top: 15px;" id="div_smtp_crypt">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="tab_form_title">Encryption</div></td>
							<td style="padding-left: 10px;">
								<span class="info_neutral" style="cursor: pointer;" onclick="$('#smtp_input_crypt_null').prop('checked', true)"><input type="radio" id="smtp_input_crypt_null" name="smtp_input_crypt" value="null" <?php echo ( !isset( $smtp_array["crypt"] ) || !$smtp_array["crypt"] || ( $smtp_array["crypt"] == "null" ) ) ? "checked" : "" ?>> none</span>
								<span class="info_neutral" style="margin-left: 5px; cursor: pointer;" onclick="$('#smtp_input_crypt_ssl').prop('checked', true)"><input type="radio" id="smtp_input_crypt_ssl" name="smtp_input_crypt" value="ssl" <?php echo ( isset( $smtp_array["crypt"] ) && $smtp_array["crypt"] && ( $smtp_array["crypt"] == "ssl" ) ) ? "checked" : "" ?>> SSL</span>
								<span class="info_neutral" style="margin-left: 5px; cursor: pointer;" onclick="$('#smtp_input_crypt_tls').prop('checked', true)"><input type="radio" id="smtp_input_crypt_tls" name="smtp_input_crypt" value="tls" <?php echo ( isset( $smtp_array["crypt"] ) && $smtp_array["crypt"] && ( $smtp_array["crypt"] == "tls" ) ) ? "checked" : "" ?>> TLS</span>
							</td>
						</tr>
						</table>
					</div>
					<div style="margin-top: 25px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="tab_form_title" style="background: #EDF1F2; border: 0px;">&nbsp;</div></td>
							<td style="padding-left: 10px;">
								<?php if ( count( $departments ) > 1 ): ?>
								<div style="padding-bottom: 15px;"><input type="checkbox" id="smtp_input_copy_all" name="copy_all" value=1> copy this update to all departments</div>
								<?php endif ; ?>
							</td>
						</tr>
						</table>
					</div>
				</td>
				<td valign="top" width="100%" style="padding-left: 50px;">
					<div id="div_prep" style="display: none; text-align: justify;">
						<div>As a default, the system will utilize the standard PHP mail() function using the web server mail settings to send out emails (transcripts, offline messages, etc).  However, if the department SMTP values are provided, emails will be sent using the external SMTP provider.</div>

						<div style="margin-top: 15px;">If utilzing the Port Connect method, the possible ports are typically: 25, 465, 587.  The most common is 465 and 587.</div>

						<div style="margin-top: 15px;"><img src="../../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Before activating the SMTP addon, the SMTP settings will need to be verified.  Using the SMTP values, the system will attempt to send an email to the <a href="../../setup/depts.php">department email address</a> containing the SMTP Verification Code, which will need to be provided on the next step.</div>

						<div id="div_alert" style="display: none; margin-top: 15px;"></div>
						<button style="margin-top: 15px;" type="button" onClick="do_submit()" class="btn" id="btn_submit">Send Verification Code and Continue</button> &nbsp; <span style="display: none;" id="text_cancel"><a href="JavaScript:void(0)" onClick="do_cancel()">cancel</a></span>

						<div style="margin-top: 25px; padding-bottom: 25px;">If you need an SMTP provider, try out <a href="https://sendgrid.com" target="_blank">SendGrid</a> or <a href="https://www.mailgun.com" target="_blank">MailGun</a>.</div>
					</div>

					<div id="div_verify" style="display: none; margin-top: 5px;" class="info_info">
						<span class="edit_title">Verification Code Sent!</span>
						<div style="margin-top: 5px;" class="info_error">Settings have not been saved yet.</div>
						<div style="margin-top: 15px;">An email has been sent to <span id="dept_email" style="font-weight: bold; color: #1DA1F2; background: #FFFFFF; padding: 1px;"></span> containing the SMTP Verification Code.  If you do not receive the email within 5 minutes, perhaps double check the SMTP values and resend. [ <a href="JavaScript:void(0)" onClick="edit_form()">edit values</a> ]</div>

						<div style="margin-top: 25px;">
							<table cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td><div class="tab_form_title">Verification Code</div></td>
								<td style="padding-left: 10px;"><input type="text" name="code" id="code" size="6" maxlength="50" onKeyPress="return logins(event)" value="" autocomplete="off"></td>
								<td style="padding-left: 10px;"><button type="button" onClick="do_verify()" class="btn" id="btn_verify">Verify</button></td>
							</tr>
							</table>
						</div>
					</div>

					<div id="div_verified" style="display: none;" class="info_info">
						<span class="edit_title">SMTP settings verified!</span>
						<div style="margin-top: 5px;" class="info_good">Settings saved and is active.</div>
						<div style="margin-top: 15px;">
							<div>All outgoing emails are sent using the department SMTP settings.</div>
							<div style="margin-top: 15px;"><img src="../../pics/icons/arrow_grey_left.png" width="16" height="16" border="0" alt=""> [ <a href="JavaScript:void(0)" onClick="resend()">edit values</a> ] &nbsp; [ <a href="JavaScript:void(0)" onClick="do_clear()">clear values</a> ]</div>
						</div>
					</div>
				</td>
			</tr>
			</table>
			<?php else: ?>
			<span class="info_error"><img src="../../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Add a <a href="../../setup/depts.php" style="color: #FFFFFF;">Department</a> to continue.</span>
			<?php endif ; ?>

		</div>
		</form>

<?php include_once( "../../setup/inc_footer.php" ) ?>
