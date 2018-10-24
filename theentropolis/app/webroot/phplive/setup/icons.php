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
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	if ( !$admininfo = Util_Security_AuthSetup( $dbh ) ){ ErrorHandler( 608, "Invalid setup session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	// STANDARD header end
	/****************************************/

	$error = "" ;

	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_File.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$deptinfo = Array() ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$option = Util_Format_Sanatize( Util_Format_GetVar( "option" ), "ln" ) ;
	$jump = Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ;

	$online = ( isset( $VALS['ONLINE'] ) && $VALS['ONLINE'] ) ? unserialize( $VALS['ONLINE'] ) : Array() ;
	$offline = ( isset( $VALS['OFFLINE'] ) && $VALS['OFFLINE'] ) ? unserialize( $VALS['OFFLINE'] ) : Array() ;

	if ( $action === "upload" )
	{
		$icon = isset( $_FILES['icon_online']['name'] ) ? "icon_online" : "icon_offline" ;
		LIST( $error, $filename ) = Util_Upload_File( $icon, $deptid ) ;
	}
	else if ( $action === "update_offline" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
		$url = Util_Format_Sanatize( Util_Format_GetVar( "url" ), "url" ) ;

		$dept_hash = Array() ; $departments = Depts_get_AllDepts( $dbh ) ;
		for ( $c = 0; $c < count( $departments ); ++$c )
		{
			$department = $departments[$c] ;
			$dept_hash[$department["deptID"]] = 1 ; 
		}

		foreach( $offline as $key => $value )
		{
			if ( $key && !isset( $dept_hash[$key] ) )
				unset( $offline[$key] ) ;
		}
		$offline[$deptid] = ( $option == "redirect" ) ? "$url" : $option ;
		Util_Vals_WriteToFile( "OFFLINE", serialize( $offline ) ) ;
		$jump = "settings" ;
	}
	else if ( $action === "update_online" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

		$dept_hash = Array() ; $departments = Depts_get_AllDepts( $dbh ) ;
		for ( $c = 0; $c < count( $departments ); ++$c )
		{
			$department = $departments[$c] ;
			$dept_hash[$department["deptID"]] = 1 ; 
		}

		foreach( $online as $key => $value )
		{
			if ( $key && !isset( $dept_hash[$key] ) )
				unset( $online[$key] ) ;
		}
		$online[$deptid] = $option ;
		Util_Vals_WriteToFile( "ONLINE", serialize( $online ) ) ;
		$jump = "settings" ;
	}
	else if ( $action === "reset" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

		if ( $option == "online" )
		{
			foreach( $online as $key => $value )
			{
				if ( $key && ( $key == $deptid ) )
					unset( $online[$key] ) ;
			} Util_Vals_WriteToFile( "ONLINE", serialize( $online ) ) ;
		}
		else if ( $option == "offline" )
		{
			foreach( $offline as $key => $value )
			{
				if ( $key && ( $key == $deptid ) )
					unset( $offline[$key] ) ;
			} Util_Vals_WriteToFile( "OFFLINE", serialize( $offline ) ) ;
		}
		else if ( ( $option == "icon_online" ) || ( $option == "icon_offline" ) )
		{
			if ( $deptid )
			{
				$dir_files = glob( $CONF["CONF_ROOT"]."/$option"."_$deptid.*", GLOB_NOSORT ) ;
				$total_dir_files = count( $dir_files ) ;
				if ( $total_dir_files )
				{
					for ( $c = 0; $c < $total_dir_files; ++$c )
					{
						if ( $dir_files[$c] && is_file( $dir_files[$c] ) ) { unlink( $dir_files[$c] ) ; }
					}
				}
			}
		}
	}

	if ( !isset( $departments ) ) { $departments = Depts_get_AllDepts( $dbh ) ; }
	if ( $deptid ) { $deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ; }

	$online_option = "embed" ;
	if ( isset( $online[$deptid] ) ) { $online_option = $online[$deptid] ; }
	else
	{
		if ( isset( $online[0] ) ) { $online_option = $online[0] ; }
	}

	$offline_option = "embed" ; $redirect_url = "" ;
	if ( isset( $offline[$deptid] ) )
	{
		if ( !preg_match( "/^(icon|hide|embed|tab)$/", $offline[$deptid] ) ) { $offline_option = "redirect" ; $redirect_url = $offline[$deptid] ; }
		else{ $offline_option = $offline[$deptid] ; }
	}
	else
	{
		if ( isset( $offline[0] ) )
		{
			if ( !preg_match( "/^(icon|hide|embed|tab)$/", $offline[0] ) ) { $offline_option = "redirect" ; $redirect_url = $offline[0] ; }
			else{ $offline_option = $offline[0] ; }
		}
	}

	$mobile_newwin = ( isset( $VALS["MOBILE_NEWWIN"] ) && is_numeric( $VALS["MOBILE_NEWWIN"] ) ) ? intval( $VALS["MOBILE_NEWWIN"] ) : 0 ;
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

<script data-cfasync="false" type="text/javascript">
<!--
	var global_mobilenewwin = <?php echo $mobile_newwin ?> ;
	var global_jump = "<?php echo $jump ?>" ;

	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		init_menu() ;
		toggle_menu_setup( "icons" ) ;
		
		<?php if ( $jump == "settings" ): ?>
		show_div_behavior( 'online', 'options' ) ; show_div_behavior( 'offline', 'options' ) ;
		<?php else: ?>
		show_div_behavior( 'online', 'icon' ) ; show_div_behavior( 'offline', 'icon' ) ;
		<?php endif ; ?>

		<?php if ( $jump == "iconsettings" ): ?>
			show_div('iconsettings') ;
		<?php endif ; ?>

		<?php if ( $action === "ob" ): ?>
			toggle_ob() ;
		<?php elseif ( $action && !$error ): ?>
			do_alert( 1, "Success" ) ;
			if ( "<?php echo $action ?>" == "update_ob_clean" ) { toggle_ob() ; }
		<?php endif ; ?>

		<?php if ( $action && $error ): ?>do_alert_div( "..", 0, "<?php echo $error ?>" ) ;<?php endif ; ?>
		<?php if ( $deptid ): ?>$('#div_notice_html').show() ;<?php endif ; ?>

	});

	function switch_dept( theobject )
	{
		location.href = "icons.php?deptid="+theobject.value+"&jump="+global_jump+"&"+unixtime() ;
	}

	function show_div( thediv )
	{
		$('#div_alert').hide() ;
	
		var divs = Array( "chaticons", "iconsettings" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#div_'+divs[c]).hide() ;
			$('#menu_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('#div_'+thediv).show() ;
		$('#menu_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}

	function show_div_behavior( theicon, thediv )
	{
		$('#div_alert').hide() ;

		var divs = Array( "icon", "options" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#'+theicon+'_'+divs[c]).hide() ;
			$('#menu_'+theicon+'_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('#'+theicon+'_'+thediv).show() ;
		$('#menu_'+theicon+'_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;

		if ( thediv == "options" ) { global_jump = "settings" ; }
		else { global_jump = "" ; }
	}

	function check_url()
	{
		var url = $('#offline_url').val() ;
		var url_ok = ( url.match( /(http:\/\/)|(https:\/\/)/i ) ) ? 1 : 0 ;

		if ( !url )
			return "Please provide the webpage URL." ;
		else if ( !url_ok )
			return "URL should begin with http:// or https:// protocol." ;
		else
			return false ;
	}

	function open_url()
	{
		var unique = unixtime() ;
		var url = $('#offline_url').val() ;
		var error = check_url() ;

		if ( error )
			do_alert( 0, error ) ;
		else
			window.open(url, unique, 'scrollbars=yes,menubar=yes,resizable=1,location=yes,toolbar=yes,status=1') ;
	}

	function update_online()
	{
		var unique = unixtime() ;
		var option = $("input[name='online_option']:checked").val() ;

		location.href = "./icons.php?action=update_online&deptid=<?php echo $deptid ?>&option="+option+"&"+unique ;
	}

	function update_offline()
	{
		var unique = unixtime() ;
		var url = $('#offline_url').val().replace( /http/ig, "hphp" ) ;
		var option = $("input[name='offline_option']:checked").val() ;
		var error = check_url() ;

		if ( error && ( option == "redirect" ) )
			do_alert( 0, error ) ;
		else
			location.href = "./icons.php?action=update_offline&deptid=<?php echo $deptid ?>&option="+option+"&url="+url+"&"+unique ;
	}

	function reset_doit( theicon, thedeptid )
	{
		if ( confirm( "Reset to Global Default settings?" ) )
			location.href = "./icons.php?action=reset&option="+theicon+"&deptid="+thedeptid ;
	}

	function reset_icon( theicon, thedeptid )
	{
		if ( confirm( "Reset to Global Default icon?" ) )
			location.href = "./icons.php?action=reset&option="+theicon+"&deptid="+thedeptid ;
	}

	function confirm_change( theflag )
	{
		if ( global_mobilenewwin != theflag )
		{
			var json_data = new Object ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "action=update_mobile_newwin&value="+theflag+"&"+unixtime(),
				success: function(data){
					global_mobilenewwin = theflag ;
					do_alert( 1, "Success" ) ;
				}
			});
		}
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu_focus" style="margin-left: 0px;" onClick="show_div('chaticons')" id="menu_chaticons">Chat Icons</div>
			<div class="op_submenu" onClick="show_div('iconsettings')" id="menu_iconsettings">Mobile Behavior</div>
			<div style="clear: both"></div>
		</div>

		<div style="margin-top: 25px;" id="div_chaticons">
			<div>
				<form method="POST" action="manager_canned.php" id="form_theform">
				<select name="deptid" id="deptid" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_dept( this )">
				<option value="0">Global Default</option>
				<?php
					if ( count( $departments ) > 1 )
					{
						for ( $c = 0; $c < count( $departments ); ++$c )
						{
							$department = $departments[$c] ;

							if ( $department["name"] != "Archive" )
							{
								$selected = ( $deptid == $department["deptID"] ) ? "selected" : "" ;
								print "<option value=\"$department[deptID]\" $selected>$department[name]</option>" ;
							}
						}
					}
				?>
				</select>
				</form>
			</div>
			<div id="div_notice_html" style="display: none; margin-top: 25px;"><span class="info_warning">The chat icon for this department will display when utilizing the <a href="code.php?deptid=<?php echo $deptid ?>">Department Specific HTML Code</a>.</span></div>

			<div id="div_alert" style="display: none; margin-top: 25px;"></div>

			<div style="margin-top: 25px;">
			
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td>
						<div style="padding-bottom: 15px;">
							<div class="op_submenu" onClick="show_div_behavior('online', 'icon')" id="menu_online_icon">Online Icon</div>
							<div class="op_submenu" onClick="show_div_behavior('online', 'options')" id="menu_online_options">Behavior</div>
							<div style="clear: both"></div>
						</div>
					</td>
					<td>
						<div style="padding-bottom: 15px;">
							<div class="op_submenu" onClick="show_div_behavior('offline', 'icon')" id="menu_offline_icon">Offline Icon</div>
							<div class="op_submenu" onClick="show_div_behavior('offline', 'options')" id="menu_offline_options">Behavior</div>
							<div style="clear: both"></div>
						</div>
					</td>
				</tr>
				<tr>
					<td valign="top" width="50%" style="padding-right: 10px;">
						<form method="POST" action="icons.php" enctype="multipart/form-data" id="form_online" name="form_online">
						<input type="hidden" name="action" value="upload">
						<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
						<input type="hidden" name="MAX_FILE_SIZE" value="200000">
						<div class="edit_title"><?php echo ( isset( $deptinfo["name"] ) ) ? $deptinfo["name"] : "Global Default" ; ?> <span class="info_good">ONLINE</span> Chat Icon</div>
						<div id="online_icon" style="display: none;">
							<div style="margin-top: 10px;">
								<div><input type="file" name="icon_online" size="30"></div>
								<div style="margin-top: 5px;"><input type="submit" value="Upload Image" style="margin-top: 10px;" class="btn"></div>
							</div>
							
							<?php $online_image = Util_Upload_GetChatIcon( "icon_online", $deptid ) ; ?>
							<div style="margin-top: 15px;"><img src="<?php print $online_image ?>" border="0" alt=""></div>
							<?php if ( $deptid && preg_match( "/_$deptid\.[a-z]/i", $online_image ) ): ?>
							<div style="margin-top: 15px;">&bull; reset to use <a href="JavaScript:void(0)" onClick="reset_icon( 'icon_online', <?php echo $deptid ?> )">Global Default</a></div>
							<?php endif ; ?>
						</div>
						<div id="online_options" style="display: none; margin-top: 10px;" class="info_info">
							<table cellspacing=1 cellpadding=5 border=0 width="100%">
							<tr>
								<td colspan=2><div style="font-size: 14px; font-weight: bold;">When live chat is <span class="info_good">ONLINE</span></div></td>
							</tr>
							<tr>
								<td width="25" align="center"><input type="radio" name="online_option" value="popup" <?php echo ( $online_option == "popup" ) ? "checked" : "" ; ?>></td>
								<td>Open the chat request in a new popup window when the online icon is clicked.</td>
							</tr>
							<tr>
								<td width="25" align="center"><input type="radio" name="online_option" value="tab" <?php echo ( $online_option == "tab" ) ? "checked" : "" ; ?>></td>
								<td>Open the chat request in a new tabbed window when the online icon is clicked.</td>
							</tr>
							<tr>
								<td width="25" align="center"><input type="radio" name="online_option" value="embed" <?php echo ( $online_option == "embed" ) ? "checked" : "" ; ?>></td>
								<td><b>Embed</b> the chat request on the webpage when the online icon is clicked.</td>
							</tr>
							<tr>
								<td></td>
								<td><div style="padding-top: 5px;"><button type="button" onClick="update_online()" class="btn">Update</button>
								&nbsp; &nbsp; <a href="JavaScript:void(0)" onClick="$('#form_online').get(0).reset(); show_div_behavior('online', 'icon');">cancel</a> &nbsp; 
								<?php
									if ( $deptid && !isset( $online[$deptid] ) ):
										print " &bull; currently using Global Default settings" ;
									elseif ( $deptid ):
										print " &bull; reset to use <a href=\"JavaScript:void(0)\" onClick=\"reset_doit( 'online', $deptid )\">Global Default</a>" ;
									endif ;
								?>
								</div></td>
							</tr>
							</table>
						</div>
						</form>
					</td>
					<td valign="top" width="50%" style="padding-left: 10px;">
						<form method="POST" action="icons.php" enctype="multipart/form-data" id="form_offline" name="form_offline">
						<input type="hidden" name="action" value="upload">
						<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
						<input type="hidden" name="MAX_FILE_SIZE" value="200000">
						<div class="edit_title"><?php echo ( isset( $deptinfo["name"] ) ) ? $deptinfo["name"] : "Global Default" ; ?> <span class="info_error">OFFLINE</span> Chat Icon</div>
						<div id="offline_icon" style="display: none;">
							<div style="margin-top: 10px;">
								<div><input type="file" name="icon_offline" size="30"></div>
								<div style="margin-top: 5px;"><input type="submit" value="Upload Image" style="margin-top: 10px;" class="btn"></div>
							</div>
							
							<?php $offline_image = Util_Upload_GetChatIcon( "icon_offline", $deptid ) ; ?>
							<div style="margin-top: 15px;"><img src="<?php print $offline_image ?>" border="0" alt=""></div>
							<?php if ( $deptid && preg_match( "/_$deptid\.[a-z]/i", $offline_image ) ): ?>
							<div style="margin-top: 15px;">&bull; reset to use <a href="JavaScript:void(0)" onClick="reset_icon( 'icon_offline', <?php echo $deptid ?> )">Global Default</a></div>
							<?php endif ; ?>
						</div>
						<div id="offline_options" style="display: none; margin-top: 10px;" class="info_info">
							<table cellspacing=1 cellpadding=5 border=0 width="100%">
							<tr>
								<td colspan=2><div style="font-size: 14px; font-weight: bold;">When live chat is <span class="info_error">OFFLINE</span></div></td>
							</tr>
							<tr>
								<td width="25" align="center"><input type="radio" name="offline_option" value="icon" <?php echo ( $offline_option == "icon" ) ? "checked" : "" ; ?>></td>
								<td>Display the offline chat icon and open the leave a message in a new popup window when the offline icon is clicked.</td>
							</tr>
							<tr>
								<td width="25" align="center"><input type="radio" name="offline_option" value="tab" <?php echo ( $offline_option == "tab" ) ? "checked" : "" ; ?>></td>
								<td>Display the offline chat icon and open the leave a message in a new tabbed window when the offline icon is clicked.</td>
							</tr>
							<tr>
								<td width="25" align="center"><input type="radio" name="offline_option" value="embed" <?php echo ( $offline_option == "embed" ) ? "checked" : "" ; ?>></td>
								<td>Display the offline chat icon and <b>embed</b> the leave a message on the webpage when the offline icon is clicked.</td>
							</tr>
							<tr>
								<td width="25" align="center"><input type="radio" name="offline_option" id="option_redirect" value="redirect" <?php echo ( $offline_option == "redirect" ) ? "checked" : "" ; ?> onClick="$('#offline_url').focus()"></td>
								<td>
									Display the offline chat icon and redirect the visitor to a webpage when the offline icon is clicked. Provide the redirect URL below:
									<div style="margin-top: 5px;">
										<input type="text" class="input" style="width: 80%;" maxlength="255" name="offline_url" id="offline_url" value="<?php echo $redirect_url ?>" onFocus="$('#option_redirect').prop('checked', true)"> &nbsp; <span style="">&middot; <a href="JavaScript:void(0)" onClick="open_url()">visit</a></span>
									</div>
								</td>
							</tr>
							<tr>
								<td width="25" align="center"><input type="radio" name="offline_option" value="hide" <?php echo ( $offline_option == "hide" ) ? "checked" : "" ; ?>></td>
								<td>
									Do not display the offline chat icon.
								</td>
							</tr>
							<tr>
								<td></td>
								<td><div style="padding-top: 5px;"><button type="button" onClick="update_offline()" class="btn">Update</button>
								&nbsp; &nbsp; <a href="JavaScript:void(0)" onClick="$('#form_offline').get(0).reset(); show_div_behavior('offline', 'icon');">cancel</a> &nbsp; 
								<?php
									if ( $deptid && !isset( $offline[$deptid] ) ):
										print " &bull; currently using Global Default settings" ;
									elseif ( $deptid ):
										print " &bull; reset to use <a href=\"JavaScript:void(0)\" onClick=\"reset_doit( 'offline', $deptid )\">Global Default</a>" ;
									endif ;
								?>
								</div></td>
							</tr>
							</table>
						</div>
						</form>
					</td>
				</tr>
				</table>

			</div>
			<div style="margin-top: 45px;"><img src="../pics/icons/comp.png" width="16" height="16" border="0" alt=""> Download different chat icons at the <a href="http://www.phplivesupport.com/r.php?r=icons" target="_blank">chat icons download page</a>.</div>
		</div>

		<div style="display: none; margin-top: 25px;" id="div_iconsettings">
			<img src="../pics/icons/mobile_big.png" width="48" height="48" border="0" alt=""> <b>Mobile behavior:</b> This setting overrides the <a href="JavaScript:void(0)" onClick="show_div_behavior( 'online', 'options' ) ; show_div_behavior( 'offline', 'options' ) ; show_div('chaticons');">Online/Offline behavior</a>.

			<div style="margin-top: 25px;">
				<div class="info_neutral" style="cursor: pointer;" onclick="$('#mobile_newwin_0').prop('checked', true);confirm_change(0);"><input type="radio" name="mobile_newwin" id="mobile_newwin_0" value="0" <?php echo ( $mobile_newwin === 0 ) ? "checked" : "" ; ?>> Use Online/Offline behavior</div>
				<div class="info_neutral" style="margin-top: 15px; cursor: pointer;" onclick="$('#mobile_newwin_1').prop('checked', true);confirm_change(1);"><input type="radio" name="mobile_newwin" id="mobile_newwin_1" value="1" <?php echo ( $mobile_newwin === 1 ) ? "checked" : "" ; ?>> Always open the chat request in a new window for mobile visitors (not including iPad visitors).  This setting will override the Online/Offline behavior.</div>
				<div class="info_neutral" style="margin-top: 15px; cursor: pointer;" onclick="$('#mobile_newwin_2').prop('checked', true);confirm_change(2);"><input type="radio" name="mobile_newwin" id="mobile_newwin_2" value="2" <?php echo ( $mobile_newwin === 2 ) ? "checked" : "" ; ?>> Always open the chat request in a new window for mobile visitors (including iPad visitors).  This setting will override the Online/Offline behavior.</div>
			</div>
		</div>

<?php include_once( "./inc_footer.php" ) ?>

