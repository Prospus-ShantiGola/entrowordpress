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
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Hash.php" ) ;
	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_File.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$https = "" ;
	if ( isset( $_SERVER["HTTP_CF_VISITOR"] ) && preg_match( "/(https)/i", $_SERVER["HTTP_CF_VISITOR"] ) ) { $https = "s" ; }
	else if ( isset( $_SERVER["HTTP_X_FORWARDED_PROTO"] ) && preg_match( "/(https)/i", $_SERVER["HTTP_X_FORWARDED_PROTO"] ) ) { $https = "s" ; }
	else if ( isset( $_SERVER["HTTPS"] ) && preg_match( "/(on)/i", $_SERVER["HTTPS"] ) ) { $https = "s" ; }

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$jump = Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ; if ( !$jump ) { $jump = "logo" ; }
	$jump2 = Util_Format_Sanatize( Util_Format_GetVar( "jump2" ), "ln" ) ; if ( !$jump2 ) { $jump2 = "upload" ; }
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$lang = Util_Format_Sanatize( Util_Format_GetVar( "lang" ), "ln" ) ;

	if ( !isset( $CONF["screen"] ) ) { $CONF["screen"] = "same" ; }
	if ( !isset( $CONF["THEME"] ) ) { $CONF["THEME"] = "default" ; }
	if ( !isset( $CONF["lang"] ) ) { $CONF["lang"] = "english" ; } if ( !$lang ) { $lang = $CONF["lang"] ; }

	$error = "" ;

	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	LIST( $your_ip, $null ) = Util_IP_GetIP( "" ) ;

	if ( $action === "update" )
	{
		if ( $jump == "logo" )
			LIST( $error, $filename ) = Util_Upload_File( "logo", $deptid ) ;
		else if ( $jump == "time" )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove.php" ) ;

			$timezone = Util_Format_Sanatize( Util_Format_GetVar( "timezone" ), "timezone" ) ;

			if ( $timezone != $CONF["TIMEZONE"] )
				Chat_remove_ResetReports( $dbh ) ;

			$error = ( Util_Vals_WriteToConfFile( "TIMEZONE", $timezone ) ) ? "" : "Could not write to config file." ;
			if ( phpversion() >= "5.1.0" ){ date_default_timezone_set( $timezone ) ; }
		}
	}
	else if ( $action === "screen" )
	{
		$screen = Util_Format_Sanatize( Util_Format_GetVar( "screen" ), "ln" ) ;

		if ( $CONF["screen"] != $screen )
		{
			$error = ( Util_Vals_WriteToConfFile( "screen", $screen ) ) ? "" : "Could not write to config file." ;
			$CONF["screen"] = $screen ;
		}

		$jump = "screen" ;
	}
	else if ( ( $action === "clear" ) && $deptid )
	{
		$dir_files = glob( $CONF["CONF_ROOT"]."/logo_$deptid.*", GLOB_NOSORT ) ;
		$total_dir_files = count( $dir_files ) ;
		if ( $total_dir_files )
		{
			for ( $c = 0; $c < $total_dir_files; ++$c )
			{
				if ( $dir_files[$c] && is_file( $dir_files[$c] ) ) { unlink( $dir_files[$c] ) ; }
			}
		}
	}
	else if ( $action == "format" )
	{
		$value = Util_Format_Sanatize( Util_Format_GetVar( "value" ), "n" ) ;

		$timeformat = ( $value != 24 ) ? 12 : 24 ;
		if ( Util_Vals_WriteToFile( "TIMEFORMAT", $timeformat ) )
		{
			$VARS_24H = ( $value != 24 ) ? 0 : 1 ; ;
			$VARS_TIMEFORMAT = ( !$VARS_24H ) ? "g:i:s a" : "G:i:s" ;
			$action = "success" ;
		}
		else
			$error = "Error updating time format." ;
	}

	$screen_same = ( $CONF["screen"] == "same" ) ? "checked" : "" ;
	$screen_separate = ( $screen_same == "checked" ) ? "" : "checked" ;

	$departments = Depts_get_AllDepts( $dbh ) ;
	$timezones = Util_Hash_Timezones() ;
	$vars = Util_Format_Get_Vars( $dbh ) ;
	$charset = ( isset( $vars["char_set"] ) && $vars["char_set"] ) ? unserialize( $vars["char_set"] ) : Array(0=>"UTF-8") ;
	$emlogos_hash = ( isset( $VALS["EMLOGOS"] ) ) ? unserialize( $VALS["EMLOGOS"] ) : Array() ;

	$login_url = $CONF['BASE_URL'] ;
	if ( !preg_match( "/\/\//", $login_url ) ) { $login_url = "//$PHPLIVE_HOST$login_url" ; }
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
	var global_div ;
	var global_charset = "<?php echo $charset[0] ?>" ;
	var global_timeformat = <?php echo ( !isset( $VALS["TIMEFORMAT"] ) || ( isset( $VALS["TIMEFORMAT"] ) && ( $VALS["TIMEFORMAT"] != 24 ) ) ) ? 12 : 24 ; ?> ;
	var global_emlogo = <?php echo ( isset( $emlogos_hash[0] ) && $emlogos_hash[0] ) ? 1 : 0 ; ?> ;
	var global_autocorrect_v = <?php echo ( !isset( $VALS["AUTOCORRECT_V"] ) || ( isset( $VALS["AUTOCORRECT_V"] ) && $VALS["AUTOCORRECT_V"] ) ) ? 1 : 0 ; ?> ;
	var global_autocorrect_o = <?php echo ( !isset( $VALS["AUTOCORRECT_O"] ) || ( isset( $VALS["AUTOCORRECT_O"] ) && $VALS["AUTOCORRECT_O"] ) ) ? 1 : 0 ; ?> ;

	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		init_menu() ;
		toggle_menu_setup( "interface" ) ;

		show_div( "<?php echo $jump ?>" ) ;

		<?php if ( $action && !$error ): ?>do_alert( 1, "Success" ) ;<?php endif ; ?>
		<?php if ( $action && $error ): ?>do_alert_div( "..", 0, "<?php echo $error ?>" ) ;<?php endif ; ?>
		<?php if ( $deptid ): ?>$('#div_notice_html').show() ; $('#div_notice_html_settings').show() ;<?php endif ; ?>

		$('#urls_<?php echo $CONF["screen"] ?>').show() ;

		check_image_dim() ;
	});

	function show_div( thediv )
	{
		$('#div_alert').hide() ;
	
		var divs = Array( "logo", "charset", "time", "screen", "lang", "props" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#settings_'+divs[c]).hide() ;
			$('#menu_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('input#jump').val( thediv ) ;
		$('#settings_'+thediv).show() ;
		$('#menu_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;

		if ( thediv == "logo" )
			show_div_logo( "<?php echo $jump2 ?>" ) ;
		else if ( thediv == "props" )
			show_div_props( "autocorrect" ) ;
	}

	function show_div_logo( thediv )
	{
		var divs = Array( "upload", "settings" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#settings_logo_'+divs[c]).hide() ;
			$('#menu2_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu2') ;
		}

		$('#settings_logo_'+thediv).show() ;
		$('#menu2_'+thediv).removeClass('op_submenu2').addClass('op_submenu_focus') ;
	}

	function show_div_props( thediv )
	{
		var divs = Array( "autocorrect" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#settings_props_'+divs[c]).hide() ;
			$('#menu2_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu2') ;
		}

		$('#settings_props_'+thediv).show() ;
		$('#menu2_'+thediv).removeClass('op_submenu2').addClass('op_submenu_focus') ;
	}

	function switch_dept( theobject )
	{
		location.href = "interface.php?deptid="+theobject.value ;
	}

	function switch_dept_settings( theobject )
	{
		location.href = "interface.php?jump2=settings&deptid="+theobject.value ;
	}

	function update_timezone()
	{
		var timezone = $('#timezone').val() ;

		if ( confirm( "This action will reset the chat reports data.  Are you sure?" ) )
			location.href = "interface.php?action=update&jump=time&timezone="+timezone ;
	}

	function confirm_charset( thecharset )
	{
		if ( global_charset != thecharset )
		{
			var json_data = new Object ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "action=update_vars&varname=char_set&value="+thecharset+"&"+unixtime(),
				success: function(data){
					global_charset = thecharset ;
					do_alert( 1, "Success" ) ;
				}
			});
		}
	}

	function check_image_dim()
	{
		var img = new Image() ;
		img.onload = get_img_dim ;
		img.src = '<?php print Util_Upload_GetLogo( "logo", $deptid ) ?>' ;
	}

	function get_img_dim()
	{
		var img_width = this.width ;
		var img_height = this.height ;

		$('#div_logo').css({'width': img_width, 'height': img_height}) ;
	}

	function confirm_clear()
	{
		if ( confirm( "Really clear this department logo and use Global Default?" ) )
		{
			location.href = "interface.php?action=clear&deptid=<?php echo $deptid ?>" ;
		}
	}

	function toggle_emlogo( thevalue )
	{
		if ( global_emlogo != thevalue )
		{
			var json_data = new Object ;

			close_view() ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "action=update_emlogo&deptid=<?php echo $deptid ?>&value="+thevalue+"&"+unixtime(),
				success: function(data){
					global_emlogo = thevalue ;
					do_alert( 1, "Success" ) ;
				}
			});
		}
	}

	function view_embed()
	{
		if ( !$('#iframe_widget_embed').is(':visible') )
		{
			$('#iframe_widget_embed').attr( 'src', "<?php echo $CONF["BASE_URL"] ?>/phplive.php?embed=1&d=<?php echo $deptid ?>&preview=1&"+unixtime() ).load(function ( ){
				$('#phplive_widget_embed_iframe').show() ;
				$('#phplive_widget_embed_iframe').css({'bottom': 5}) ;
				$('#phplive_widget_embed_iframe').fadeIn('fast') ;
				$('#phplive_widget_embed_iframe_shadow').fadeIn('fast') ;
			});
		}
		else { close_view() ; }
	}

	function close_view()
	{
		$('#phplive_widget_embed_iframe').fadeOut('fast') ;
		$('#phplive_widget_embed_iframe_shadow').hide() ;
	}

	function toggle_autocorrect( the_vo, thevalue )
	{
		if ( ( ( the_vo == "v" ) && ( global_autocorrect_v != thevalue ) ) || ( ( the_vo == "o" ) && ( global_autocorrect_o != thevalue ) ) )
		{
			var json_data = new Object ;

			close_view() ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "action=update_autocorrect&vo="+the_vo+"&value="+thevalue+"&"+unixtime(),
				success: function(data){
					if ( the_vo == "v" ) { global_autocorrect_v = thevalue ; }
					else { global_autocorrect_o = thevalue ; }
					do_alert( 1, "Success" ) ;
				}
			});
		}
	}

	function confirm_change( theformat )
	{
		if ( parseInt( global_timeformat ) != parseInt( theformat ) )
			location.href = "interface.php?action=format&value="+theformat+"&jump=time&"+unixtime() ;
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" style="margin-left: 0px;" onClick="location.href='interface_themes.php'">Themes</div>
			<div class="op_submenu" onClick="show_div('logo')" id="menu_logo">Company Logo</div>
			<div class="op_submenu" onClick="show_div('charset')" id="menu_charset">Character Set</div>
			<?php if ( phpversion() >= "5.1.0" ): ?><div class="op_submenu" onClick="show_div('time')" id="menu_time">Timezone</div><?php endif; ?>
			<div class="op_submenu" onClick="location.href='interface_lang.php'">Language Text</div>
			<div class="op_submenu" onClick="location.href='interface_chat_msg.php'">Chat End Msg</div>
			<div class="op_submenu" onClick="show_div('screen')" id="menu_screen">Login Screen</div>
			<div class="op_submenu" onClick="show_div('props')" id="menu_props">Properties</div>
			<div style="clear: both"></div>
		</div>

		<form method="POST" action="interface.php" enctype="multipart/form-data">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="jump" id="jump" value="">
		<input type="hidden" name="MAX_FILE_SIZE" value="200000">

		<div style="display: none; margin-top: 25px;" id="settings_logo">
			<div id="op_submenu_wrapper_logo">
				<div class="op_submenu2" style="margin-left: 0px;" onClick="show_div_logo('upload')" id="menu2_upload">Upload Logo</div>
				<div class="op_submenu2" onClick="show_div_logo('settings')" id="menu2_settings">Embed Chat Logo Display</div>
				<div style="clear: both"></div>
			</div>

			<div id="settings_logo_upload" style="display: none; margin-top: 25px;">
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
				
				<div style="margin-top: 15px;">
					<div style="">
						<div id="div_notice_html" style="display: none; margin-bottom: 15px;"><span class="info_warning">The logo for this department will display when using the <a href="code.php?deptid=<?php echo $deptid ?>">Department Specific HTML Code</a>.</span></div>
						<div style=""><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> For proper display of the logo, recommended <b>maximum</b> logo size should be <b>520 pixels width</b> and <b>150 pixels height</b>.</div>
					</div>

					<table cellspacing=0 cellpadding=0 border=0 width="100%" class="edit_wrapper" style="margin-top: 15px;">
					<tr>
						<td valign="top">
							<div id="div_alert" style="display: none; margin-bottom: 25px;"></div>

							<?php if ( ( count( $departments ) == 1 ) && isset( $deptinfo["deptID"] ) ): ?>
							<div class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Because only one department is available, choose the <a href="interface.php" style="color: #FFFFFF;">"Global Default"</a> to upload your logo.</div>

							<?php else: ?>
							<div style="">
								<div><input type="file" name="logo" size="30"></div>
								<div style="margin-top: 5px;"><input type="submit" value="Upload Logo" style="margin-top: 10px;" class="btn"></div>
							</div>

							<div id="div_logo" style="border: 1px solid #DFDFDF; margin-top: 25px; background: url( <?php print Util_Upload_GetLogo( "logo", $deptid ) ?> ) no-repeat;">&nbsp;</div>

							<?php if ( $deptid && ( Util_Upload_GetLogo( "logo", 0 ) != Util_Upload_GetLogo( "logo", $deptid ) ) ): ?>
								<div style="margin-top: 15px;"><img src="../pics/icons/reset.png" width="16" height="16" border="0" alt=""> <a href="JavaScript:void(0)" onClick="confirm_clear()">clear department logo and use Global Default image</a></div>
							<?php elseif ( $deptid ): ?>
								<div style="margin-top: 15px;"><img src="../pics/icons/themes.png" width="16" height="16" border="0" alt=""> currently using <a href="interface.php">Global Default</a> image</div>
							<?php endif ; ?>

							<div style="margin-top: 25px;"><img src="../pics/icons/arrow_grey.png" width="16" height="16" border="0" alt=""> <a href="JavaScript:void(0)" onClick="preview_theme('<?php echo $CONF["THEME"] ?>', <?php echo $VARS_CHAT_WIDTH ?>, <?php echo $VARS_CHAT_HEIGHT ?>, <?php echo $deptid ?> )">view how it looks (popup)</a></div>
							<?php endif ; ?>
						</td>
					</tr>
					</table>
				</div>
			</div>
			<div id="settings_logo_settings" style="display: none; margin-top: 25px;">
				<select name="deptid" id="deptid" style="display: none; font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_dept_settings( this )">
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

				<div style="margin-top: 15px;">
					<div style=""><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> Logo is always displayed for the popup window option. Should the logo also be displayed for the <a href="icons.php?jump=settings">embed chat window option</a>?</div>
				</div>

				<div style="margin-top: 25px;">
					<div class="info_good" style="float: left; padding: 3px; cursor: pointer;" onclick="$('#emlogo_on').prop('checked', true);toggle_emlogo(1);"><input type="radio" name="emlogo" id="emlogo_on" value="1" <?php echo ( isset( $emlogos_hash[0] ) && $emlogos_hash[0] ) ? "checked" : "" ; ?>> Yes</div>
					<div class="info_error" style="float: left; margin-left: 10px; padding: 3px; cursor: pointer;" onclick="$('#emlogo_off').prop('checked', true);toggle_emlogo(0);"><input type="radio" name="emlogo" id="emlogo_off" value="0" <?php echo ( isset( $emlogos_hash[0] ) && $emlogos_hash[0] ) ? "" : "checked" ; ?>> No</div>
					<div style="clear: both;"></div>
				</div>

				<div style="margin-top: 25px;"><img src="../pics/icons/arrow_grey.png" width="16" height="16" border="0" alt=""> <a href="JavaScript:void(0)" onClick="view_embed()">view how it looks (embed)</a></div>

			</div>
		</div>

		<div style="display: none; margin-top: 25px; text-align: justify;" id="settings_themes">
			<div>Set the visitor chat window theme.  Operators will be able to set their own theme by logging into the <a href="ops.php?jump=online">Operator area</a>.</div>
			<div style="margin-top: 25px;"><img src="../pics/icons/arrow_right.png" width="16" height="15" border="0" alt=""> Visitor chat window theme can be set for each department at the <a href="depts.php">Departments area.</a></div>
		</div>

		<div style="display: none; margin-top: 25px;" id="settings_props">
			<div id="op_submenu_wrapper_logo">
				<div class="op_submenu2" style="margin-left: 0px;" onClick="show_div_props('autocorrect')" id="menu2_autocorrect">Autocorrect</div>
				<div style="clear: both"></div>
			</div>

			<div style="margin-top: 25px;">
				<div><span style="color: #0078D7; font-weight: bold;">Autocorrect</span> is a web browser feature that sometimes automatically corrects minor misspelled words during a chat session.</div>
				
				<div style="margin-top: 5px;"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> It is recommended to keep the setting to <span class="info_good">On</span> unless it is causing some issues (example: international language being autocorrected to English words).</div>
				<div style="margin-top: 15px;"><span class="info_warning"><img src="../pics/icons/warning.gif" width="16" height="16" border="0" alt=""> [ Caution ] Switching "Off" the autocorrect might also disable the automatic spellcheck on some devices.</span></div>
				<div style="margin-top: 25px;">
					<table cellspacing=0 cellpadding=0 border=0>
					<tr>
						<td>
							Visitor chat autocorrect:
						</td>
						<td style="padding-left: 15px;">
							<div style="">
								<div class="info_good" style="float: left; padding: 3px; cursor: pointer;" onclick="$('#autocorrect_v_1').prop('checked', true);toggle_autocorrect('v', 1);"><input type="radio" name="autocorrect_v" id="autocorrect_v_1" value="1" <?php echo ( !isset( $VALS["AUTOCORRECT_V"] ) || ( isset( $VALS["AUTOCORRECT_V"] ) && $VALS["AUTOCORRECT_V"] ) ) ? "checked" : "" ; ?>> On</div>
								<div class="info_error" style="float: left; margin-left: 10px; padding: 3px; cursor: pointer;" onclick="$('#autocorrect_v_0').prop('checked', true);toggle_autocorrect('v', 0);"><input type="radio" name="autocorrect_v" id="autocorrect_v_0" value="0" <?php echo ( isset( $VALS["AUTOCORRECT_V"] ) && !$VALS["AUTOCORRECT_V"] ) ? "checked" : "" ; ?>> Off</div>
								<div style="clear: both;"></div>
							</div>
						</td>
					</tr>
					<tr><td colspan=2>&nbsp;</td></tr>
					<tr>
						<td>
							Operator chat autocorrect:
						</td>
						<td style="padding-left: 15px;">
							<div style="">
								<div class="info_good" style="float: left; padding: 3px; cursor: pointer;" onclick="$('#autocorrect_o_1').prop('checked', true);toggle_autocorrect('o', 1);"><input type="radio" name="autocorrect_o" id="autocorrect_o_1" value="1" <?php echo ( !isset( $VALS["AUTOCORRECT_O"] ) || ( isset( $VALS["AUTOCORRECT_O"] ) && $VALS["AUTOCORRECT_O"] ) ) ? "checked" : "" ; ?>> On</div>
								<div class="info_error" style="float: left; margin-left: 10px; padding: 3px; cursor: pointer;" onclick="$('#autocorrect_o_0').prop('checked', true);toggle_autocorrect('o', 0);"><input type="radio" name="autocorrect_o" id="autocorrect_o_0" value="0" <?php echo ( isset( $VALS["AUTOCORRECT_O"] ) && !$VALS["AUTOCORRECT_O"] ) ? "checked" : "" ; ?>> Off</div>
								<div style="clear: both;"></div>
							</div>
						</td>
					</tr>
					</table>
				</div>
			</div>
		</div>

		<div style="display: none; margin-top: 25px;" id="settings_charset">
			If multi-language characters are not rendering properly on the operator chat window or while viewing transcripts, try updating the character set value.  UTF-8 is suggested.

			<div style="margin-top: 25px;">
				<div class="li_op round" style="cursor: pointer;" onclick="$('#charset_UTF-8').prop('checked', true); confirm_charset('UTF-8');"><input type="radio" name="charset" id="charset_UTF-8" value="UTF-8" <?php echo ( $charset[0] == "UTF-8" ) ? "checked" : "" ?>> UTF-8</div>
				<div class="li_op round" style="cursor: pointer;" onclick="$('#charset_ISO-8859-1').prop('checked', true); confirm_charset('ISO-8859-1');"><input type="radio" name="charset" id="charset_ISO-8859-1" value="ISO-8859-1" <?php echo ( $charset[0] == "ISO-8859-1" ) ? "checked" : "" ?>> ISO-8859-1</div>
				<div style="clear: both;"></div>
			</div>
		</div>

		<?php if ( phpversion() >= "5.1.0" ): ?>
		<div style="display: none; margin-top: 25px;" id="settings_time">

			<table cellspacing=0 cellpadding=0 border=0 width="100%">
			<tr>
				<td valign="top">

					<div style="">
						<select id="timezone">
						<?php
							for ( $c = 0; $c < count( $timezones ); ++$c )
							{
								$selected = "" ;
								if ( $timezones[$c] == date_default_timezone_get() )
									$selected = "selected" ;

								print "<option value=\"$timezones[$c]\" $selected>$timezones[$c]</option>" ;
							}
						?>
						</select>
					</div>
					<div style="margin-top: 15px;">
						<div style="text-align: justify;"><b>NOTE:</b> Updating the timezone will reset (clear) the <a href="reports_chat.php">chat reports data</a>.  The chat reports reset is necessary because the past data timezone will conflict with the new timezone, resulting in invalid data.  Be sure to print out the current reports data before continuing.  The chat <a href="transcripts.php">transcripts</a> will not be affected but the created timestamp may be different from the original because of the timezone change.</div>
					</div>

					<div style="margin-top: 25px;"><button type="button" onClick="update_timezone()" class="btn">Update Timezone</button></div>
				</td>
				<td width="25"><img src="../pics/space.gif" width="25" height="1" border=0></td>
				<td valign="top" width="500" class="info_info">
					<div>
						<div>System Time:</div>
						<div class="info_box" style="display: inline-block; margin-top: 15px; font-size: 18px; font-weight: bold; font-family: sans-serif;"><?php echo $CONF['TIMEZONE'] ?></div>
						<div style="margin-top: 15px; font-size: 32px; font-weight: bold; color: #3A89D1; font-family: sans-serif; text-shadow: 1px 1px #FFFFFF;"><?php echo date( "M j, Y ($VARS_TIMEFORMAT)", time() ) ; ?></div>
					</div>

					<div style="margin-top: 25px;">
						<span class="info_neutral" style="margin-left: 5px; cursor: pointer;" onclick="$('#timeformat_12').prop('checked', true);confirm_change(12);"><input type="radio" id="timeformat_12" name="timeformat_12" value="ssl" <?php echo ( !$VARS_24H ) ? "checked" : "" ; ?>> 12h</span>
						<span class="info_neutral" style="margin-left: 5px; cursor: pointer;" onclick="$('#timeformat_24').prop('checked', true);confirm_change(24);"><input type="radio" id="timeformat_24" name="timeformat_12" value="tls" <?php echo ( $VARS_24H ) ? "checked" : "" ; ?>> 24h</span>
					</div>
				</td>
			</tr>
			</table>

		</div>
		<?php endif; ?>

		<div style="display: none; margin-top: 25px;" id="settings_screen">
			Choose whether to display the operator login and the setup login screens on the same URL or separate URLs.
		
			<div style="margin-top: 25px;">
				<div class="li_op round" style="cursor: pointer;" onclick="$('#screen_one').prop('checked', true); location.href='interface.php?action=screen&screen=same';"><input type="radio" name="screen" id="screen_one" value="same" <?php echo $screen_same ?>> Same URL</div>
				<div class="li_op round" style="cursor: pointer;" onclick="$('#screen_two').prop('checked', true); location.href='interface.php?action=screen&screen=separate';"><input type="radio" name="screen" id="screen_two" value="separate" <?php echo $screen_separate ?>> Separate URLs</div>
				<div style="clear: both;"></div>
			</div>

			<div style="margin-top: 25px;">
				<div id="urls_same" style="display: none;" class="info_info">
					<div style=""><img src="../pics/icons/key.png" width="16" height="16" border="0" alt=""> <img src="../pics/icons/bulb.png" width="16" height="16" border="0" alt="">Operator and Setup Login URL</div>
					<div style="margin-top: 5px; font-size: 32px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><a href="<?php echo ( !preg_match( "/^(http)/", $CONF["BASE_URL"] ) ) ? "http$https:$login_url" : $login_url ; ?>" target="new" style="color: #1DA1F2;" class="nounder"><?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?></a></div>
				</div>
				<div id="urls_separate" style="display: none;">
					<div class="info_info">
						<div style="font-size: 14px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><img src="../pics/icons/bulb.png" width="16" height="16" border="0" alt=""> Operator Login URL</div>
						<div style="margin-top: 5px; font-size: 32px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><a href="<?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?>" target="new" style="color: #1DA1F2;" class="nounder"><?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?></a></div>
					</div>

					<div class="info_info" style="margin-top: 25px;">
						<div style="font-size: 14px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><img src="../pics/icons/key.png" width="16" height="16" border="0" alt=""> Setup Login URL</div>
						<div style="margin-top: 5px; font-size: 32px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><a href="<?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?>/setup" target="new" style="color: #1DA1F2;" class="nounder"><?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?>/setup</a></div>
					</div>
				</div>
			</div>
		</div>
		</form>

		<div id='phplive_widget_embed_iframe' style='display: none; position: fixed; width: <?php echo $VARS_CHAT_WIDTH_WIDGET ?>px; height: <?php echo $VARS_CHAT_HEIGHT_WIDGET ?>px; right: 25px; bottom: 5000px; -moz-border-radius: 5px; border-radius: 5px; z-Index: 40003;'><iframe id='iframe_widget_embed' name='iframe_widget_embed' style='width: 100%; height: 100%; -moz-border-radius: 5px; border-radius: 5px; border: 0px;' src='about:blank' scrolling='no' border=0 frameborder=0></iframe></div>

<?php include_once( "./inc_footer.php" ) ?>