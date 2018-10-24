<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	if ( !is_file( "../web/config.php" ) ){ HEADER("location: install.php") ; exit ; }
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	if ( !$admininfo = Util_Security_AuthSetup( $dbh ) ){ ErrorHandler( 608, "Invalid setup session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	// STANDARD header end
	/****************************************/

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions.php" ) ;

	$error = "" ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$jump = ( Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ) ? Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) : "eips" ;

	if ( !isset( $CONF["cookie"] ) ) { $CONF["cookie"] = "on" ; }
	$cookie_off = ( $CONF["cookie"] == "off" ) ? "checked" : "" ;
	$cookie_on = ( $cookie_off == "checked" ) ? "" : "checked" ;

	LIST( $your_ip, $null ) = Util_IP_GetIP( "" ) ;

	$max_days = 365 ; $max_bytes_ = 0 ;
	$upload_max_filesize = ini_get( "upload_max_filesize" ) ;
	$upload_max_post = ini_get( "post_max_size" ) ;

	if ( $upload_max_filesize && preg_match( "/k/i", $upload_max_filesize ) )
	{
		$temp = Util_Format_Sanatize( $upload_max_filesize, "n" ) ;
		$max_bytes = $temp * 1000 ;
		$max_bytes_ = $max_bytes ;
	}
	else if ( $upload_max_filesize && preg_match( "/m/i", $upload_max_filesize ) )
	{
		$temp = Util_Format_Sanatize( $upload_max_filesize, "n" ) ;
		$max_bytes = $temp * 1000000 ;
		$max_bytes_ = $max_bytes ;
	}
	else if ( $upload_max_filesize && preg_match( "/g/i", $upload_max_filesize ) )
	{
		$temp = Util_Format_Sanatize( $upload_max_filesize, "n" ) ;
		$max_bytes = $temp * 1000000000 ;
		$max_bytes_ = $max_bytes ;
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
		$max_days = $upmax_array["days"] ;
		$max_bytes = $upmax_array["bytes"] ;
	}
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> PHP Live! Support </title>

<meta name="description" content="PHP Live! Support <?php echo $VERSION ?>">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8">
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../css/setup.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/jquery_md5.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	var global_cookie = "<?php echo $CONF["cookie"] ?>" ;

	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		init_menu() ;
		toggle_menu_setup( "settings" ) ;

		fetch_eips() ;
		fetch_sips() ;
		show_div( "<?php echo $jump ?>" ) ;

		<?php if ( $action && !$error ): ?>do_alert( 1, "Success" ) ;<?php endif ; ?>
		<?php if ( $action && $error ): ?>do_alert_div( "..", 0, "<?php echo $error ?>" ) ;<?php endif ; ?>
	});

	function fetch_eips()
	{
		$.ajax({
			type: "POST",
			url: "../ajax/setup_actions.php",
			data: "action=eips&"+unixtime(),
			success: function(data){
				print_eips( data ) ;
			}
		});
	}

	function fetch_sips()
	{
		$.ajax({
			type: "POST",
			url: "../ajax/setup_actions.php",
			data: "action=sips&"+unixtime(),
			success: function(data){
				print_sips( data ) ;
			}
		});
	}

	function print_eips( thedata )
	{
		var json_data = new Object ;

		eval( thedata ) ;
		if ( typeof( json_data.ips ) != "undefined" )
		{
			var ip_string = "<table cellspacing=0 cellpadding=0 border=0 width=\"100%\">" ;
			for ( var c = 0; c < json_data.ips.length; ++c )
			{
				var ip = json_data.ips[c]["ip"] ;
				var ip_ = ip.replace( /\./g, "" ) ;

				ip_string += "<tr id=\"tr_eip_"+ip_+"\"><td class=\"td_dept_td\" width=\"14\"><div id=\"eip_"+ip_+"\"><a href=\"JavaScript:void(0)\" onClick=\"remove_eip( '"+ip+"' )\"><img src=\"../pics/icons/delete.png\" width=\"14\" height=\"14\" border=\"0\" alt=\"\"></a></div></td><td class=\"td_dept_td\">"+ip+"</td></tr>" ;
			}
			if ( !c )
				ip_string += "<tr><td class=\"td_dept_td\">Blank results.</td></tr>" ;
		}
		ip_string += "</table>" ;
		$('#eips').html( ip_string ) ;
	}

	function print_sips( thedata )
	{
		var json_data = new Object ;

		eval( thedata ) ;
		if ( typeof( json_data.ips ) != "undefined" )
		{
			var ip_string = "<table cellspacing=0 cellpadding=0 border=0 width=\"100%\">" ;
			for ( var c = 0; c < json_data.ips.length; ++c )
			{
				var ip = json_data.ips[c]["ip"] ;
				var ip_ = ip.replace( /\./g, "" ) ;

				ip_string += "<tr id=\"tr_sip_"+ip_+"\"><td class=\"td_dept_td\" width=\"14\"><div id=\"sip_"+ip_+"\"><a href=\"JavaScript:void(0)\" onClick=\"remove_sip( '"+ip+"' )\"><img src=\"../pics/icons/delete.png\" width=\"14\" height=\"14\" border=\"0\" alt=\"\"></a></div></td><td class=\"td_dept_td\">"+ip+"</td></tr>" ;
			}
			if ( !c )
				ip_string += "<tr><td class=\"td_dept_td\">Blank results.</td></tr>" ;
		}
		ip_string += "</table>" ;
		$('#sips').html( ip_string ) ;
	}

	function add_eip()
	{
		var ip = $('#ip_exclude').val().replace( /[^0-9.]/g, "" ) ;
		$('#ip_exclude').val( ip ) ;

		if ( !ip )
			do_alert( 0, "Blank IP field is invalid." ) ;
		else
		{
			var json_data = new Object ;
			$('#btn_eip').attr( "disabled", true ) ;
			$('#img_loading_eip').show() ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "action=add_eip&ip="+ip+"&"+unixtime(),
				success: function(data){
					eval(data) ;
					if ( json_data.status )
					{
						// timeout is due to possible server cache settings
						setTimeout( function(){
							$('#img_loading_eip').hide() ;
							$('#btn_eip').attr( "disabled", false ) ;
							fetch_eips() ;
							do_alert( 1, "Success" ) ;
						}, 3000 ) ;
					}
					else
					{
						$('#img_loading_eip').hide() ;
						$('#btn_eip').attr( "disabled", false ) ;
						do_alert( 0, "IP ("+ip+") already excluded." ) ;
					}
					$('#ip_exclude').val('') ;
				}
			});
		}
	}

	function remove_eip( theip )
	{
		var theip_ = theip.replace( /\./g, "" ) ;
		$('#eips').hide() ;
		$('#img_loading_eip').show() ;

		$.ajax({
			type: "POST",
			url: "../ajax/setup_actions.php",
			data: "action=remove_eip&ip="+theip+"&"+unixtime(),
			success: function(data){
				// timeout is due to possible server cache settings
				setTimeout( function(){
					$('#tr_eip_'+theip_).remove() ;
					$('#eips').show() ;
					$('#img_loading_eip').hide() ;
					do_alert( 1, "Success" ) ;
				}, 3000 ) ;
			}
		});
	}

	function add_sip()
	{
		var ip = $('#ip_spam').val().replace( /[^0-9.]/g, "" ) ;
		$('#ip_spam').val( ip ) ;

		if ( !ip )
			do_alert( 0, "Blank IP field is invalid." ) ;
		else
		{
			var json_data = new Object ;
			$('#btn_sip').attr( "disabled", true ) ;
			$('#img_loading_sip').show() ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "action=add_sip&ip="+ip+"&"+unixtime(),
				success: function(data){
					eval(data) ;
					if ( json_data.status )
					{
						// timeout is due to possible server cache settings
						setTimeout( function(){
							$('#img_loading_sip').hide() ;
							$('#btn_sip').attr( "disabled", false ) ;
							fetch_sips() ;
							do_alert( 1, "Success" ) ;
						}, 3000 ) ;
					}
					else
					{
						$('#img_loading_sip').hide() ;
						$('#btn_sip').attr( "disabled", false ) ;
						do_alert( 0, "IP ("+ip+") already reported as spam." ) ;
					}
					$('#ip_spam').val('') ;
				}
			});
		}
	}

	function remove_sip( theip )
	{
		var theip_ = theip.replace( /\./g, "" ) ;
		$('#sips').hide() ;
		$('#img_loading_sip').show() ;

		$.ajax({
			type: "POST",
			url: "../ajax/setup_actions.php",
			data: "action=remove_sip&ip="+theip+"&"+unixtime(),
			success: function(data){
				// timeout is due to possible server cache settings
				setTimeout( function(){
					$('#tr_sip_'+theip_).remove() ;
					$('#sips').show() ;
					$('#img_loading_sip').hide() ;
					do_alert( 1, "Success" ) ;
				}, 3000 ) ;
			}
		});
	}

	function show_div( thediv )
	{
		var divs = Array( "eips", "sips", "cookie", "upload", "profile" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#settings_'+divs[c]).hide() ;
			$('#menu_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('input#jump').val( thediv ) ;
		$('#settings_'+thediv).show() ;
		$('#menu_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}

	function switch_dept( theobject )
	{
		location.href = "settings.php?deptid="+theobject.value ;
	}

	function update_profile()
	{
		execute = 1 ;
		var inputs = Array( "email", "login" ) ;

		if ( !check_email( $('#email').val() ) ){ do_alert( 0, "Email format is invalid. (example: you@domain.com)" ) ; execute = 0 ; }

		if ( $('#npassword').val() || $('#vpassword').val() )
		{
			if ( $('#npassword').val() != $('#vpassword').val() ){ do_alert( 0, "New Password and Verify Password does not match." ) ; execute = 0 ; }
		}

		if ( execute ){ update_profile_doit() ; } ;
	}

	function update_profile_doit()
	{
		var json_data = new Object ;
		var unique = unixtime() ;

		var email = $('#email').val() ;
		var login = $('#login').val() ;
		var npassword = phplive_md5( $('#npassword').val() ) ;
		var vpassword = phplive_md5( $('#vpassword').val() ) ;
		var md5_password = phplive_md5( npassword+vpassword ) ;

		$.ajax({
		type: "POST",
		url: "../ajax/setup_actions.php",
		data: "action=update_profile&email="+email+"&login="+login+"&npassword="+npassword+"&vpassword="+vpassword+"&md5_password="+md5_password+"&"+unique,
		success: function(data){
			eval( data ) ;
			if ( json_data.status )
			{
				$('#npassword').val('') ;
				$('#vpassword').val('') ;
				do_alert( 1, "Success" ) ;
			}
			else
				do_alert( 0, json_data.error ) ;

		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Connection error.  Refresh the page and try again." ) ;
		} });
	}

	function confirm_change( theflag )
	{
		if ( global_cookie != theflag )
		{
			var json_data = new Object ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "action=update_cookie&value="+theflag+"&"+unixtime(),
				success: function(data){
					global_cookie = theflag ;
					do_alert( 1, "Success" ) ;
				}
			});
		}
	}

	function update_upmax()
	{
		var json_data = new Object ;
		var unique = unixtime() ;

		var upmax_days = parseInt( $('#upmax_days').val() ) ;
		var upmax_bytes = parseInt( $('#upmax_bytes').val().replace(/\,/g,"") ) ;

		if ( !upmax_days )
		{
			$('#upmax_days').val(365) ;
			do_alert( 0, "Days value must be a number." ) ;
			return false ;
		}
		else if ( !upmax_bytes )
		{
			$('#upmax_bytes').val(<?php echo $max_bytes ?>) ;
			do_alert( 0, "Bytes value must be a number." ) ;
			return false ;
		}
		else if ( <?php echo $max_bytes_ ?> && ( upmax_bytes > <?php echo $max_bytes_ ?> ) )
		{
			$('#upmax_bytes').val( <?php echo $max_bytes_ ?> ) ;
			upmax_bytes = <?php echo $max_bytes_ ?> ;
		}

		if ( <?php echo $max_post_bytes ?> && ( upmax_bytes > <?php echo $max_post_bytes ?> ) )
		{
			$('#upmax_bytes').val( <?php echo $max_post_bytes ?> ) ;
			upmax_bytes = <?php echo $max_post_bytes ?> ;
		}

		$('#btn_update_upmax').attr("disabled", true) ;

		$.ajax({
		type: "POST",
		url: "../ajax/setup_actions_.php",
		data: "action=update_upmax&days="+upmax_days+"&bytes="+upmax_bytes+"&"+unique,
		success: function(data){
			eval( data ) ;

			$('#btn_update_upmax').attr("disabled", false) ;
			if ( json_data.status )
			{
				do_alert( 1, "Success" ) ;
			}
			else
				do_alert( 0, json_data.error ) ;

		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Connection error.  Refresh the page and try again." ) ;
		} });
	}

//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" style="margin-left: 0px;" onClick="show_div('eips')" id="menu_eips">Excluded IPs</div>
			<div class="op_submenu" onClick="show_div('sips')" id="menu_sips">Blocked IPs</div>
			<div class="op_submenu" onClick="show_div('cookie')" id="menu_cookie">Cookies</div>
			<div class="op_submenu" onClick="show_div('upload')" id="menu_upload">File Upload</div>
			<?php if ( is_file( "$CONF[DOCUMENT_ROOT]/mapp/settings.php" ) && ( $admininfo["adminID"] == 1 ) ): ?><div class="op_submenu" onClick="location.href='../mapp/settings.php'" id="menu_system"><img src="../pics/icons/mobile.png" width="12" height="12" border="0" alt=""> Mobile App</div><?php endif ; ?>
			<?php if ( $admininfo["adminID"] == 1 ): ?><div class="op_submenu" onClick="show_div('profile')" id="menu_profile"><img src="../pics/icons/key.png" width="12" height="12" border="0" alt=""> Setup Profile</div><?php endif ; ?>
			<div class="op_submenu" onClick="location.href='system.php'" id="menu_system">System</div>
			<div style="clear: both"></div>
		</div>

		<form method="POST" action="settings.php" enctype="multipart/form-data">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="jump" id="jump" value="">

		<div style="display: none; margin-top: 25px; text-align: justify;" id="settings_eips">
			To avoid misleading page views when developing a website, exclude internal or company IP from being counted towards the overall footprint report.  Excluded IPs will not be visible on the traffic monitor. URL footprints of Excluded IPs will not be stored in the database and will not count towards the overall <a href="reports_traffic.php">footprint report</a>.

			<div style="margin-top: 15px;"><img src="../pics/icons/info.png" width="14" height="14" border="0" alt=""> IP exclude is a string containing match.  For example, IP exclude string of "123.456" will exclude "123.456.789.255", "321.123.456.89", "255.255.123.456", etc.</div>

			<div style="margin-top: 25px;">
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td valign="top" nowrap style="padding-right: 25px;">
						<div class="info_info">
							<div>Your IP: <big><b><?php echo $your_ip ?></b></big></div>
							<div style="margin-top: 15px;"><input type="text" name="ip_exclude" id="ip_exclude" size="20" maxlength="45" onKeyPress="return numbersonly(event)"></div>
							<div style="margin-top: 25px;"><input type="button" onClick="add_eip()" value="Add Exclude IP" class="btn" id="btn_eip"></div>
						</div>
					</td>
					<td valign="top" width="100%">
						<div><div class="td_dept_header">Current Excluded IPs: &nbsp; <img src="../pics/loading_ci.gif" width="14" height="14" border="0" alt="" id="img_loading_eip" style="display: none;"></div></div>
						<div id="eips" style=""></div>
					</td>
				</tr>
				</table>
			</div>
		</div>

		<div style="display: none; margin-top: 25px;" id="settings_sips">
			Blocked IPs will always see an OFFLINE live chat status.  Operators can specify an IP to block during a chat session or you can provide an IP address here.  Blocked IPs will still display on the operator traffic monitor.  It is suggested to periodically clear out the blocked IPs.

			<div style="margin-top: 15px;"><img src="../pics/icons/info.png" width="14" height="14" border="0" alt=""> Blocked IP is a string containing match.  For example, Blocked IP string of "123.456" will block IPs "123.456.789.255", "321.123.456.89", "255.255.123.456", etc.</div>

			<div style="margin-top: 25px;">
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td valign="top" nowrap style="padding-right: 25px;">
						<div class="info_info">
							<div>Example: <big><b>123.456.789.101</b></big></div>
							<div style="margin-top: 15px;"><input type="text" name="ip_spam" id="ip_spam" size="20" maxlength="45" onKeyPress="return numbersonly(event)"></div>
							<div style="margin-top: 25px;"><input type="button" onClick="add_sip()" value="Add IP to Block" class="btn" id="btn_sip"></div>
						</div>
					</td>
					<td valign="top" width="100%">
						<div><div class="td_dept_header">Current Blocked IPs: &nbsp; <img src="../pics/loading_ci.gif" width="14" height="14" border="0" alt="" id="img_loading_sip" style="display: none;"></div></div>
						<div id="sips" style="max-height: 300px; overflow-y: auto; overflow-x: hidden;"></div>
					</td>
				</tr>
				</table>
			</div>
		</div>

		<div style="display: none; margin-top: 25px;" id="settings_upload">
			File formats that can be uploaded are GIF, PNG, JPG, JPEG or PNG file types.  File upload is available during a chat session for both the visitor and the operator.  File upload On/Off for website visitors can be set for each department at the <a href="depts.php">Departments</a> area.  File upload On/Off for the operator can be set for each operator at the <a href="ops.php">Operators</a> area.
			<div style="margin-top: 15px;">Configure the duration the uploaded files are stored on the server and also the max file size that can be uploaded.</div>

			<div style="margin-top: 25px;">
				<table cellspacing=0 cellpadding=10 border=0>
				<tr>
					<td align="right">Store uploaded files on the server for </td>
					<td><input type="text" size="6" maxlength="6" class="input" name="upmax_days" id="upmax_days" value="<?php echo $max_days ?>" onKeyPress="return numbersonly(event)"> days</td>
				</tr>
				<tr>
					<td align="right">Upload max file size </td>
					<td>
						<input type="text" size="11" maxlength="11" class="input" name="upmax_bytes" id="upmax_bytes" value="<?php echo $max_bytes ?>" onKeyPress="return numbersonly(event)"> bytes (1K = 1,000 bytes, 1M = 1,000,000 bytes)
					</td>
				</tr>
				<?php if ( $max_bytes_ ): ?>
				<tr>
					<td colspan=2>
						<div style=""><img src="../pics/icons/info.png" width="14" height="14" border="0" alt=""> This web server has a pre-configured upload max file size capability of <span class="info_box" style="cursor: pointer;"><a href="http://php.net/manual/en/ini.core.php#ini.upload-max-filesize" target="_blank"><?php echo preg_replace( "/M/i", "MB", $upload_max_filesize ) ?></a></span>. ('<a href="http://php.net/manual/en/ini.core.php#ini.upload-max-filesize" target="_blank">upload_max_filesize</a>' directive)</div>

						<?php if ( $upload_max_post ): ?>
						<div style="margin-top: 25px;"><img src="../pics/icons/info.png" width="14" height="14" border="0" alt=""> This web server has a pre-configured POST max file size capability of <span class="info_box" style="cursor: pointer;"><a href="http://php.net/manual/en/ini.core.php#ini.post-max-size" target="_blank"><?php echo preg_match( "/bytes/", $max_post_bytes_ ) ? $max_post_bytes_ : preg_replace( "/M/i", "MB", $upload_max_post ) ; ?></a></span>. ('<a href="http://php.net/manual/en/ini.core.php#ini.post-max-size" target="_blank">post_max_size</a>' directive)  File upload is performed as POST method.</div>
						<?php endif ; ?>
					</td>
				</tr>
				<?php endif ; ?>
				<tr>
					<td>&nbsp;</td>
					<td>
						<?php if ( $VARS_INI_UPLOAD ): ?><button type="button" class="btn" onClick="update_upmax()" id="btn_update_upmax">Update</button>
						<?php else: ?><img src="../pics/icons/alert.png" width="16" height="16" border="0" alt=""> File upload is not enabled for this server ('<a href="http://php.net/manual/en/ini.core.php#ini.file-uploads" target="_blank">file_uploads</a>' directive).  Please contact the server admin for more information.
						<?php endif ; ?>
					</td>
				</tr>
				</table>
			</div>
		</div>

		<div style="display: none; margin-top: 25px;" id="settings_cookie">
			Switch On/Off the use of cookies on the visitor chat window.  The cookies provide convenience for the visitor and does not affect the actual chat functions.
			<div style="margin-top: 25px;" class="info_info">
				Cookies set by the system on the visitor chat request window:
				<li style="margin-top: 5px;"> <code>phplive_vname</code> - The visitor's name
				<li> <code>phplive_vemail</code> - The visitor's email address
				<li> <code>phplive_vid</code> - The visitor's session string (automatically generated by the system)
			</div>
			<div style="margin-top: 15px;" class="info_warning">It is recommended to keep the setting at <b>"Set cookies"</b> to improve visitor identification and chat performance.</div>

			<div style="margin-top: 25px;">
				<div class="li_op round" style="cursor: pointer;" onclick="$('#cookie_on').prop('checked', true);confirm_change('on');"><input type="radio" name="cookie" id="cookie_on" value="on" <?php echo $cookie_on ?>> Set cookies</div>
				<div class="li_op round" style="cursor: pointer;" onclick="$('#cookie_off').prop('checked', true);confirm_change('off');"><input type="radio" name="cookie" id="cookie_off" value="off" <?php echo $cookie_off ?>> Do not set cookies</div>
				<div style="clear: both;"></div>
			</div>
		</div>

		<div style="display: none; margin-top: 25px;" id="settings_profile">
			Update the Setup Admin contact email address and the password.  The admin email is used for the Setup Admin "forgot password" recovery and other system related features.

			<div style="margin-top: 25px;">
				<input type="hidden" name="login" id="login" value="<?php echo $admininfo["login"] ?>">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="td_dept_td" width="120">Setup Admin Email</td>
					<td class="td_dept_td"><input type="text" class="input" size="35" maxlength="50" name="email" id="email" value="<?php echo $admininfo["email"] ?>" onKeyPress="return justemails(event)" value=""></td>
				</tr>
				<tr>
					<td colspan="4" style="padding-top: 15px;">
						<div style="font-size: 14px; font-weight: bold;">Update Password (optional)</div>
						<div style="margin-top: 15px;">
							<table cellspacing=0 cellpadding=4 border=0>
							<tr> 
								<td class="td_dept_td" width="120">New Password</td> 
								<td class="td_dept_td"><input type="password" class="input" size="35" maxlength="50" id="npassword" onKeyPress="return noquotes(event)"></td> 
							</tr>
							<tr>
								<td class="td_dept_td" width="120">Verify Password</td> 
								<td class="td_dept_td"><input type="password" class="input" size="35" maxlength="50" id="vpassword" onKeyPress="return noquotes(event)"></td> 
							</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr> 
					<td></td> 
					<td class="td_dept_td"><input type="button" value="Update Profile" id="btn_submit" onClick="update_profile()" class="btn"></td> 
				</tr> 
				</table>
			</div>
		</div>

		</form>

<?php include_once( "./inc_footer.php" ) ?>
