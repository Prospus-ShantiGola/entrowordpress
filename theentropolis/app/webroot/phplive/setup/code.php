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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Vars/get.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$jump = ( Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ) ? Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) : "main" ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$proto = Util_Format_Sanatize( Util_Format_GetVar( "proto" ), "n" ) ;
	$position = Util_Format_Sanatize( Util_Format_GetVar( "position" ), "n" ) ;
	$now = time() ; $error = "" ; $display = 0 ;

	if ( !isset( $VALS["OB_CLEAN"] ) ) { $VALS["OB_CLEAN"] = "on" ; }

	$departments = Depts_get_AllDepts( $dbh ) ;
	$ops_assigned = 0 ;
	for ( $c = 0; $c < count( $departments ); ++$c )
	{
		$department = $departments[$c] ;
		$ops = Depts_get_DeptOps( $dbh, $department["deptID"] ) ;
		if ( count( $ops ) )
			$ops_assigned = 1 ;
	}
	$deptinfo = Array() ;
	if ( $deptid )
		$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;

	$total_ops = Ops_get_TotalOps( $dbh ) ;
	$total_ops_online = Ops_get_itr_AnyOpsOnline( $dbh, $deptid ) ;

	$dept_query = $deptid ;
	if ( $action === "update_proto" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Vars/update.php" ) ;

		$vars = Util_Format_Get_Vars( $dbh ) ;
		if ( ( $proto != $vars["code"] ) || !is_numeric( $vars["code"] ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

			$error = "" ;
			if ( !$proto )
			{
				$error = ( Util_Vals_WriteToConfFile( "BASE_URL", preg_replace( "/^(http:\/\/)|(https:\/\/)/i", "//", $CONF["BASE_URL"] ) ) ) ? "" : "Could not write to config file." ;
			}
			else if ( $proto == 1 )
				$error = ( Util_Vals_WriteToConfFile( "BASE_URL", preg_replace( "/^(https:\/\/)|(http:\/\/)|(\/\/)/i", "http://", $CONF["BASE_URL"] ) ) ) ? "" : "Could not write to config file." ;
			else if ( $proto == 2 )
			{
				$error = ( Util_Vals_WriteToConfFile( "BASE_URL", preg_replace( "/^(https:\/\/)|(http:\/\/)|(\/\/)/i", "https://", $CONF["BASE_URL"] ) ) ) ? "" : "Could not write to config file." ;
			}
			if ( !$error ) { Vars_update_Var( $dbh, "code", $proto ) ; }
		}
		Vars_update_Var( $dbh, "position", $position ) ;
	}
	else if ( $action === "add_extra_departments" )
	{
		$deptids = Util_Format_Sanatize( Util_Format_GetVar( "deptids" ), "a" ) ;

		$dept_query = "" ;
		for ( $c = 0; $c < count( $deptids ); ++$c )
			$dept_query .= $deptids[$c]."010" ;
	}
	else if ( $action === "proto_error" )
	{
		$error = "Could not detect HTTPS (SSL) support on this server." ;
	}
	else if ( $action === "update_ob_clean" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

		$value = Util_Format_Sanatize( Util_Format_GetVar( "value" ), "ln" ) ;

		if ( $value && Util_Vals_WriteToFile( "OB_CLEAN", Util_Format_Trim( $value ) ) )
			$VALS["OB_CLEAN"] = $value ;
		else
			$error = "Could not write to vals file [OB: $value]." ;
	}

	/*************/
	/* HTML Code */
	$position_css = "" ;
	$vars = Util_Format_Get_Vars( $dbh ) ;
	if ( isset( $vars["code"] ) )
	{
		$proto = $vars["code"] ;
		if ( !is_numeric( $proto ) ) { $proto = 0 ; }
		switch ( $vars["position"] )
		{
			case 2:
				$position_css = " position: fixed; bottom: 0px; right: 0px; z-index: 1000000;" ;
				break ;
			case 3:
				$position_css = " position: fixed; bottom: 0px; left: 0px; z-index: 1000000;" ;
				break ;
			case 4:
				$position_css = " position: fixed; top: 0px; right: 0px; z-index: 1000000;" ;
				break ;
			case 5:
				$position_css = " position: fixed; top: 0px; left: 0px; z-index: 1000000;" ;
				break ;
			case 6:
				$position_css = " position: fixed; top: 50%; left: 0px; z-index: 1000000;" ;
				break ;
			case 7:
				$position_css = " position: fixed; top: 50%; right: 0px; z-index: 1000000;" ;
				break ;
			default:
				$position_css = "" ;
		}

		// automatic fix for toggle
		if ( !$proto && preg_match( "/^http:/", $CONF["BASE_URL"] ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Vars/update.php" ) ;
			$error = ( Util_Vals_WriteToConfFile( "BASE_URL", preg_replace( "/^(http:)/i", "", $CONF["BASE_URL"] ) ) ) ? "" : "Could not write to config file." ;
		}
	}

	$base_url = $CONF["BASE_URL"] ;
	$source_url = "$base_url/js/phplive_v2.js.php?v=$deptid|$now|$proto|" ;
	$code = "&lt;!-- BEGIN PHP Live! HTML Code --&gt;-nl-&lt;span style=\"color: #0000FF; text-decoration: underline; cursor: pointer;$position_css\" id=\"phplive_btn_$now\" onclick=\"phplive_launch_chat_$deptid()\"&gt;&lt;/span&gt;-nl-&lt;script data-cfasync=\"false\" type=\"text/javascript\"&gt;-nl--nl-(function() {-nl-var phplive_e_$now = document.createElement(\"script\") ;-nl-phplive_e_$now.type = \"text/javascript\" ;-nl-phplive_e_$now.async = true ;-nl-phplive_e_$now.src = \"$source_url%%text_string%%\" ;-nl-document.getElementById(\"phplive_btn_$now\").appendChild( phplive_e_$now ) ;-nl-})() ;-nl--nl-&lt;/script&gt;-nl-&lt;!-- END PHP Live! HTML Code --&gt;" ;

	if ( $proto == 1 ) { $base_url = preg_replace( "/(http:)|(https:)/", "http:", $base_url ) ; }
	else if ( $proto == 2 ) { $base_url = preg_replace( "/(http:)|(https:)/", "https:", $base_url ) ; }
	else { $base_url = preg_replace( "/(http:)|(https:)/", "", $base_url ) ; }

	$thecode = preg_replace( "/%%base_url%%/", $base_url, $code ) ;
	$code_html = preg_replace( "/&lt;/", "<", $thecode ) ;
	$code_html = preg_replace( "/&gt;/", ">", $code_html ) ;
	$code_html = preg_replace( "/-nl-/", "\r\n", $code_html ) ;
	/* HTML Code */
	/*************/
	
	$online = ( isset( $VALS['ONLINE'] ) && $VALS['ONLINE'] ) ? unserialize( $VALS['ONLINE'] ) : Array( ) ;
	$offline = ( isset( $VALS['OFFLINE'] ) ) ? unserialize( $VALS['OFFLINE'] ) : Array() ;
	$offline_option = "icon" ;
	if ( isset( $offline[$deptid] ) )
	{
		if ( !preg_match( "/^(icon|hide)$/", $offline[$deptid] ) ) { $offline_option = "redirect" ; }
		else{ $offline_option = $offline[$deptid] ; }
	}
	else
	{
		if ( isset( $offline[0] ) )
		{
			if ( !preg_match( "/^(icon|hide)$/", $offline[0] ) ) { $offline_option = "redirect" ; }
			else{ $offline_option = $offline[0] ; }
		}
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
	var global_ob_clean = "<?php echo $VALS["OB_CLEAN"] ?>" ;
	var st_proto_verify ;
	var thecode = '<?php echo $thecode ?>' ;
	thecode = thecode.replace( /-nl-/g, "\r\n" ) ;
	thecode = thecode.replace( /&lt;/g, "<" ) ;
	thecode = thecode.replace( /&gt;/g, ">" ) ;
	var phplive_browser = navigator.appVersion ; var phplive_mime_types = "" ;
	var phplive_display_width = screen.availWidth ; var phplive_display_height = screen.availHeight ; var phplive_display_color = screen.colorDepth ; var phplive_timezone = new Date().getTimezoneOffset() ;
	if ( navigator.mimeTypes.length > 0 ) { for (var x=0; x < navigator.mimeTypes.length; x++) { phplive_mime_types += navigator.mimeTypes[x].description ; } }
	var phplive_browser_token = phplive_md5( phplive_display_width+phplive_display_height+phplive_display_color+phplive_timezone+phplive_browser+phplive_mime_types ) ;

	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		check_protocol() ;
		init_menu() ;
		toggle_menu_setup( "html" ) ;

		populate_code( "standard" ) ;
		show_div( "<?php echo $jump ?>" ) ;

		<?php if ( ( ( $action === "switch" ) || ( $action === "update_proto" ) ) && !$error ): ?>do_alert(1, "<img src=\"../pics/icons/flag_blue.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\"> New HTML Code Generated", 6) ;
		<?php elseif ( ( $action === "update_proto" ) && $error ): ?>do_alert(0, "<?php echo $error ?>") ;
		<?php elseif ( ( $action === "proto_error" ) && $error ): ?>do_alert( 0, "<?php echo $error ?>" ) ;
		<?php elseif ( $action && !$error ): ?>do_alert( 1, "Success" ) ;
		<?php endif ; ?>
	});

	function switch_dept( theobject )
	{
		location.href = "code.php?deptid="+theobject.value+"&action=switch&proto=<?php echo $proto ?>&"+unixtime() ;
	}

	function populate_code( thetextarea )
	{
		if ( thetextarea == "standard" )
		{
			var code = thecode.replace( /%%text_string%%/g, "" ) ;
			$('#textarea_code_'+thetextarea).val( code ) ;
		}
		else if ( thetextarea == "text" )
		{
			var text = encodeURI( $('#code_text').val() ) ;
			var code = thecode.replace( /%%text_string%%/g, text ) ;

			if ( text == "" )
				do_alert( 0, "Please provide the text." ) ;
			else
			{
				$('#code_text_code').show() ;
				$('#html_code_text_output').html("<span onClick=\"phplive_launch_chat_<?php echo $deptid ?>(0)\" style=\"cursor: pointer;\">"+$('#code_text').val()+"</span>") ;
				$('#textarea_code_'+thetextarea).val( code ) ;
				$('#html_code_text_output_tip').show() ;
				do_alert(1, "<img src=\"../pics/icons/flag_blue.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\"> New HTML Code Generated", 3) ;
			}
		}
		$('#div_textarea_text_wrapper').show() ;
	}

	function input_text_listen_text( e )
	{
		var key = -1 ;
		var shift ;

		key = e.keyCode ;
		shift = e.shiftKey ;

		if ( !shift && ( ( key == 13 ) || ( key == 10 ) ) )
			$('#btn_generate').click() ;
	}

	function toggle_code( theproto )
	{
		var unique = unixtime() ;
		var proto = $('input[name=proto]:checked', '#form_proto').val() ;

		var url = "<?php echo $CONF["BASE_URL"] ?>" ;
		var url_https = ( proto == 2 ) ? url.replace( /^(http:\/\/)|(\/\/)/i, "https://" ) : url ;

		$('#proto_verify').show() ;
		$('#iframe_proto_verify').attr('src', url_https+"/blank.php").ready(function() {
			toggle_code_doit() ;
		});
		if ( typeof( st_proto_verify ) != "undefined" ) { clearTimeout( st_proto_verify ) ; }
		st_proto_verify = setTimeout( function(){ location.href = "./code.php?action=proto_error" }, 10000 ) ;
	}

	function toggle_code_doit()
	{
		var unique = unixtime() ;
		var proto = $('input[name=proto]:checked', '#form_proto').val() ;
		var position = $('#position').val() ;

		var url = "<?php echo $CONF["BASE_URL"] ?>" ;
		var url_https = ( proto == 2 ) ? url.replace( /^((http:\/\/)|(\/\/))/i, "https://" ) : url ;

		location.href = url_https+"/setup/code.php?action=update_proto&deptid=<?php echo $deptid ?>&proto="+proto+"&position="+position+"&"+unique ;
	}

	function show_div( thediv )
	{
		var divs = Array( "main" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#code_'+divs[c]).hide() ;
			$('#menu_code_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('#code_'+thediv).show() ;
		$('#menu_code_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}

	function show_html_code()
	{
		$('#btn_show').hide() ;
		$('#div_html_code').show() ;
	}

	function open_departments( thedeptid )
	{
		var pos = $('#department_add_btn').position() ;
		var top = pos.top - 45 ;
		var left = pos.left + $('#department_add_btn').outerWidth() + 25 ;

		$('#div_departments').css({'top': top, 'left': left}).fadeIn("fast") ;
	}

	function check_protocol()
	{
		var url = window.location.href ;
		var url_https = ( url.match( /^https:/i ) ) ? 1 : 0 ;

		// check for situations where the server always redirects http to https
		if ( url_https && ( <?php echo $proto ?> == 1 ) )
		{
			$('#div_always_https').show() ;
			$('#proto_radio_https').prop("checked", true) ;

			setTimeout( function(){ toggle_code() ; }, 3000 ) ;
		} return true ;
	}

	function do_redirect()
	{
		location.href = "code_invite.php?token="+phplive_browser_token ;
	}

	function toggle_html_code( thediv )
	{
		var divs = Array( "standard", "text", "noj", "direct" ) ;

		for ( var c = 0; c < divs.length; ++c )
		{
			$('#menu_html_code_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
			$('#div_code_'+divs[c]).hide() ;
		}

		$('#menu_html_code_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
		$('#div_code_'+thediv).show() ;
	}

	function toggle_ob()
	{
		if ( $('#settings_ob').is(':visible') )
			$('#settings_ob').hide() ;
		else
		{
			$('#settings_ob').show() ;
			$("html, body").animate( { scrollTop: $(document).height() }, "slow" ) ;
		}
	}

	function confirm_ob_clean( theob_clean )
	{
		if ( global_ob_clean != theob_clean )
		{
			location.href = "code.php?action=update_ob_clean&value="+theob_clean+"&deptid=<?php echo $deptid ?>&proto=<?php echo $proto ?>&position=<?php echo isset( $vars["position"] ) ? $vars["position"] : 1 ; ?>&"+unixtime() ;
		}
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<?php if ( !count( $departments ) ): ?>
		<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Add a <a href="depts.php" style="color: #FFFFFF;">Department</a> to continue.</span>
		<?php elseif ( !$total_ops ): ?>
		<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Add an <a href="ops.php" style="color: #FFFFFF;">Operator</a> to continue.</span>
		<?php elseif ( !$ops_assigned ): ?>
		<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> <a href="ops.php?jump=assign" style="color: #FFFFFF;">Assign an operator to a department</a> to continue.</span>
		<?php
			else:
			$display = 1 ; $select_depts = 1 ;
			if ( count( $departments ) == 1 )
			{
				$department = $departments[0] ;
				if ( $department["visible"] )
					$select_depts = 0 ;
			}
		?>
		<?php endif ; ?>

		<?php if ( $display ): ?>
		<div class="op_submenu_wrapper">
			<div class="op_submenu" style="margin-left: 0px;" onClick="show_div('main')" id="menu_code_main">HTML Code</div>
			<div class="op_submenu" onClick="location.href='code_settings.php'">Settings</div>
			<div class="op_submenu" onClick="do_redirect()" id="menu_code_auto">Automatic Chat Invite</div>
			<div style="clear: both"></div>
		</div>

		<div style="margin-top: 25px;">

			<div style="">
				<form method="POST" action="manager_canned.php" id="form_theform">
				<div>Department:</div>
				<div style="margin-top: 5px;"><select name="deptid" id="deptid" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_dept( this )">
					<option value="0">ALL Departments</option>
					<?php
						if ( $select_depts )
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
					&nbsp; &nbsp; <?php if ( $deptid ): ?><span id="div_dept_specific"><img src="../pics/icons/agent.png" width="16" height="16" border="0" alt="" style="padding: 4px;" class="info_misc"> <b>Department Specific HTML Code:</b> Automatically route the visitor to this department.</span><?php endif ; ?>
				</div>
				</form>
			</div>
			<div style="margin-top: 15px;">
				<form id="proto_pos">
				<div>Chat Icon Position: </div>
				<div style="margin-top: 5px;"><select name="position" id="position" onChange="toggle_code()" style="background: #D5E6FD;">
					<option value="1" <?php echo ( $vars["position"] == 1 ) ? "selected" : "" ; ?>>Display the chat icon where the HTML code is placed on the page.</option>
					<option value="2" <?php echo ( $vars["position"] == 2 ) ? "selected" : "" ; ?>>Bottom Right</option>
					<option value="3" <?php echo ( $vars["position"] == 3 ) ? "selected" : "" ; ?>>Bottom Left</option>
					<option value="4" <?php echo ( $vars["position"] == 4 ) ? "selected" : "" ; ?>>Top Right</option>
					<option value="5" <?php echo ( $vars["position"] == 5 ) ? "selected" : "" ; ?>>Top Left</option>
					<option value="6" <?php echo ( $vars["position"] == 6 ) ? "selected" : "" ; ?>>Center Left</option>
					<option value="7" <?php echo ( $vars["position"] == 7 ) ? "selected" : "" ; ?>>Center Right</option>
				</select> &nbsp; <img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> the <a href="code_settings.php">Embed Chat Window Position</a> can also be updated</div>
				</form>
			</div>
			<div style="margin-top: 15px;">
				<form id="form_proto">
				<div style="display: none; margin-top: 5px;" class="info_error" id="div_always_https">System has detected an Always HTTPS environment.</div>
				<div style=""><input type="radio" name="proto" value="0" <?php echo ( !isset( $vars["code"] ) || !$vars["code"] ) ? "checked" : "" ?> onClick="toggle_code()"> Toggle <b><i>HTTP and HTTPS</i></b> based on the URL</div>
				<div style="margin-top: 5px;"><input type="radio" name="proto" value="1" <?php echo ( $vars["code"] == 1 ) ? "checked" : "" ?> onClick="toggle_code()"> Always <b><i>HTTP</i></b></div>
				<div style="margin-top: 5px;"><input type="radio" id="proto_radio_https" name="proto" value="2" <?php echo ( $vars["code"] == 2 ) ? "checked" : "" ?> onClick="toggle_code()"> Always <b><i>HTTPS</i></b> <img src="../pics/icons/lock.png" width="16" height="16" border="0" alt=""> secure chats (SSL enabled servers)</div>
				</form>
			</div>
			<div style="margin-top: 15px;">

				<div style="margin-bottom: 5px;">
					<div style="margin-left: 0px; margin-top: 5px; font-size: 12px; font-weight: normal; cursor: pointer;" class="op_submenu_focus" onClick="toggle_html_code('standard')" id="menu_html_code_standard">&bull; Standard HTML Code (recommended)</div>
					<div style="margin-top: 5px; font-size: 12px; font-weight: normal; cursor: pointer;" class="op_submenu" onClick="toggle_html_code('text')" id="menu_html_code_text">&bull; Text Link</div>
					<div style="margin-top: 5px; font-size: 12px; font-weight: normal; cursor: pointer;" class="op_submenu" onClick="toggle_html_code('noj')" id="menu_html_code_noj">&bull; No JavaScript</div>
					<div style="margin-top: 5px; font-size: 12px; font-weight: normal; cursor: pointer;" class="op_submenu" onClick="toggle_html_code('direct')" id="menu_html_code_direct">&bull; URL Link</div>
					<div style="clear: both;"></div>
				</div>

				<div class="info_info">
					<div style="font-size: 16px; font-weight: bold;"><img src="../pics/icons/code.png" width="16" height="16" border="0" alt=""> Copy/paste the following HTML Code onto your webpages.</div>
					<div style="margin-top: 5px; margin-bottom: 15px;">For best results, it is recommended to paste the HTML Code onto all of your webpages, anywhere after the &lt;body&gt; tag and before the closing &lt/body&gt; tag.  For multiple chat icons on the same page, please reference the <a href="http://www.phplivesupport.com/r.php?r=multi" target="new">documentation</a>.</div>

					<div id="div_code_standard">
						<div><textarea wrap="virtual" id="textarea_code_standard" style="font-size: 10px; padding: 20px; width: 860px; height: 180px; resize: none;" onMouseDown="setTimeout(function(){ $('#textarea_code_standard').select(); }, 200);" readonly></textarea></div>

						<?php if ( isset( $deptinfo["deptID"] ) && !$deptinfo["visible"] ): ?>
						<div class="info_error" style="margin-top: 15px;"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> This department is <a href="depts.php?ftab=vis" style="color: #FFFFFF;">not visible for selection</a> but visitors can still reach this department with the above Department Specific HTML Code.</div>
						<?php endif ; ?>

						<div style="margin-top: 10px;">The above HTML Code will produce the following status icon.</div>

						<?php if ( !$total_ops_online && ( $offline_option == "hide" ) ): ?>
						<div class="info_error" style="margin-top: 5px;">Reminder: Offline chat icon is not displayed based on the current <a href="icons.php?deptid=<?php echo $deptid ?>&jump=settings" style="color: #FFFFFF;">offline setting</a>.</div>
						<?php else: ?>
						<div style="margin-top: 5px;" id="output_code"><?php echo preg_replace( "/%%text_string%%/", "", $code_html ) ?></div>
						<?php endif; ?>


						<div style="margin-top: 15px;"><b>Note:</b> If the chat icon is not visible, try switching Off the <a href="JavaScript:void(0)" onClick="toggle_ob()">Image Output OB Clean Setting</a></div>
						<div style="display: none; margin-top: 5px;" class="info_info" id="settings_ob">
							<div style="font-size: 14px; font-weight: bold;">Image Output "OB Clean"</div>

							<div style="margin-top: 15px;">(default is On) If the chat icons are not displaying, it may be due to server settings.  In these situations, simply switch the <b>OB Clean</b> setting to <b>Off</b> to correct the issue.</div>
							<div style="margin-top: 15px;">
								<div class="info_good" style="float: left; width: 60px; padding: 3px; cursor: pointer;" onclick="$('#ob_clean_on').prop('checked', true);confirm_ob_clean('on');"><input type="radio" name="ob_clean" id="ob_clean_on" value="on" <?php echo ( $VALS["OB_CLEAN"] != "off" ) ? "checked" : "" ?>> On</div>
								<div class="info_error" style="float: left; margin-left: 10px; width: 60px; padding: 3px; cursor: pointer;" onclick="$('#ob_clean_off').prop('checked', true);confirm_ob_clean('off');"><input type="radio" name="ob_clean" id="ob_clean_off" value="off" <?php echo ( $VALS["OB_CLEAN"] == "off" ) ? "checked" : "" ?>> Off</div>
								<div style="clear: both;"></div>
							</div>
						</div>
					</div>

					<div id="div_code_text" style="display: none;">
						<?php if ( $offline_option == "hide" ): ?>
							<div style="margin-bottom: 15px;">Not available for current <a href="icons.php?deptid=<?php echo $deptid ?>&jump=settings">offline setting</a>.</div>
						<?php else: ?>
							<div id="div_textarea_text_wrapper" style="display: none;"><textarea wrap="virtual" id="textarea_code_text" style="font-size: 10px; padding: 20px; width: 860px; height: 180px; resize: none;" onMouseDown="setTimeout(function(){ $('#textarea_code_text').select(); }, 200);" readonly></textarea></div>

							<div style="margin-top: 10px;"><input type="text" class="input" size="25" maxlength="155" id="code_text" onKeydown="input_text_listen_text(event);" value="Click for Live Support"> <input type="button" value="Generate" onClick="populate_code('text')" id="btn_generate"></div>
							<div style="margin-top: 10px;">Example: <i>"Click for Live Support"</i></div>
							<div id="code_text_code" style="display: none; margin-top: 10px;">The above code will produce the following text link.</div>
							<div id="html_code_text_output" style="margin-top: 5px; color: #0000FF; text-decoration: underline;"></div>
							<div class="info_box" style="display: none; margin-top: 15px;" id="html_code_text_output_tip">
								To achieve design consistency with your website, modify the &lt;span&gt; style portion of the above code.
							</div>
						<?php endif ; ?>
					</div>

					<div id="div_code_noj" style="display: none;">
						<textarea wrap="virtual" id="textarea_code_plain" style="padding: 20px; width: 860px; height: 85px; resize: none;" onMouseDown="setTimeout(function(){ $('#textarea_code_plain').select(); }, 200);" readonly>&lt;!-- BEGIN PHP Live! HTML Code --&gt;
<a href="<?php echo $base_url ?>/phplive.php?d=<?php echo $dept_query ?>&onpage=livechatimagelink&title=Live+Chat+Image+Link" target="_blank"><img src="<?php echo $base_url ?>/ajax/image.php?d=<?php echo $dept_query ?>" border=0 alt="Live Chat" title="Live Chat"></a>
&lt;!-- END PHP Live! HTML Code --&gt;</textarea>

						<div style="margin-top: 10px;">
							<img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Plain HTML is for publishing software with strict HTML guidelines.  Simply paste the above JavaScript code as HTML Code.
						</div>
						<div style="margin-top: 10px;">
							<img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Automatic chat invite, operator chat invite and real-time visitor footprint monitor/tracking will not be available for this code option due to the lack of JavaScript.
						</div>
						<div style="margin-top: 15px;">The above HTML Code will produce the following status icon.</div>
						<div style="margin-top: 5px;"><a href="<?php echo $base_url ?>/phplive.php?d=<?php echo $dept_query ?>&onpage=livechatimagelink&title=Live+Chat+Image+Link" target="_blank"><img src="<?php echo $base_url ?>/ajax/image.php?d=<?php echo $dept_query ?>" border=0 alt="Live Chat" title="Live Chat"></a></div>
					</div>

					<div id="div_code_direct" style="display: none;">
						<div style=""><textarea wrap="virtual" id="textarea_code_direct" style="padding: 20px; width: 860px; height: 55px; resize: none;" onMouseDown="setTimeout(function(){ $('#textarea_code_direct').select(); }, 200);" readonly><?php echo $base_url ?>/phplive.php?d=<?php echo $dept_query ?>&onpage=livechatimagelink&title=Live+Chat+Direct+Link</textarea></div>

						<div style="margin-top: 10px;">URL link to request a chat.</div>
					</div>
				</div>

			</div>

		</div>
		<?php endif ; ?>

		<div style="display: none;"><iframe id='iframe_proto_verify' src='about:blank' scrolling='no' border=0 frameborder=0></iframe></div>
<?php include_once( "./inc_footer.php" ) ?>
