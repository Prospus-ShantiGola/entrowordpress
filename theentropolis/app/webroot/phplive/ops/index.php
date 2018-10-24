<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	if ( !is_file( "../web/config.php" ) ){ HEADER("location: ../setup/install.php") ; exit ; }
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	if ( !$opinfo = Util_Security_AuthOp( $dbh ) ){ ErrorHandler( 602, "Invalid operator session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	// STANDARD header end
	/****************************************/

	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/remove.php" ) ;

	/***** [ BEGIN ] BASIC CLEANUP *****/
	$now = time() ;
	$dir_files = glob( $CONF["CHAT_IO_DIR"].'/*.t*', GLOB_NOSORT ) ;
	$total_dir_files = count( $dir_files ) ;
	if ( $total_dir_files )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/put_itr.php" ) ;

		for ( $c = 0; $c < $total_dir_files; ++$c )
		{
			$file = $dir_files[$c] ;
			$modtime = filemtime( $file ) ;
			if ( $modtime < ( $now - (60*60*14) ) )
			{
				if ( is_file( $file ) )
				{
					preg_match( "/(.*?)\.txt/", $file, $matches ) ;
					if ( isset( $matches[1] ) )
					{
						$ces = $matches[1] ;
						$requestinfo = Chat_get_RequestHistCesInfo( $dbh, $ces ) ;

						if ( isset( $requestinfo["ces"] ) && !$requestinfo["ended"] )
						{
							$deptinfo = Depts_get_DeptInfo( $dbh, $requestinfo["deptID"] ) ;
							$deptvars = Depts_get_DeptVars( $dbh, $requestinfo["deptID"] ) ;

							LIST( $ces ) = database_mysql_quote( $dbh, $requestinfo["ces"] ) ;
							$query = "DELETE FROM p_requests WHERE ces = '$ces'" ;
							database_mysql_query( $dbh, $query ) ;

							$CONF["lang"] = ( isset( $CONF["lang"] ) && $CONF["lang"] ) ? $CONF["lang"] : "english" ;
							include( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($CONF["lang"], "ln").".php" ) ;
							$string_disconnect = "<div class='cl'><disconnected><d6>".$LANG["CHAT_NOTIFY_DISCONNECT"]."</div>" ;
							UtilChat_AppendToChatfile( $ces.".txt", $string_disconnect ) ;

							$output = UtilChat_ExportChat( $ces.".txt" ) ;
							if ( isset( $output[0] ) )
							{
								$formatted = $output[0] ; $plain = $output[1] ;
								$fsize = strlen( $formatted ) ;
								if ( $requestinfo["status"] )
								{
									$custom_string = "" ;
									$customs = explode( "-cus-", rawurldecode( $requestinfo["custom"] ) ) ;
									for ( $c = 0; $c < count( $customs ); ++$c )
									{
										$custom_var = $customs[$c] ;
										if ( $custom_var && preg_match( "/-_-/", $custom_var ) )
										{
											LIST( $cus_name, $cus_var ) = explode( "-_-", $custom_var ) ;
											if ( $cus_var ) { $custom_string .= $cus_name.": ".$cus_var."\r\n" ; }
										}
									}
									Chat_put_itr_Transcript( $dbh, $ces, $requestinfo["status"], $requestinfo["created"], $modtime, $requestinfo["deptID"], $requestinfo["opID"], $requestinfo["initiated"], $requestinfo["op2op"], 0, $fsize, $requestinfo["vname"], $requestinfo["vemail"], $requestinfo["ip"], $requestinfo["md5_vis"], $custom_string, $requestinfo["question"], $formatted, $plain, $deptinfo, $deptvars ) ;
								}
							}
						}
					} unlink( $file ) ;
				}
			}
		}
	}
	Ops_remove_CleanStats( $dbh ) ;
	/***** [ END ] BASIC CLEANUP *****/

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$jump = Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ;
	$console = Util_Format_Sanatize( Util_Format_GetVar( "console" ), "n" ) ;
	$menu = Util_Format_Sanatize( Util_Format_GetVar( "menu" ), "ln" ) ;
	$wp = Util_Format_Sanatize( Util_Format_GetVar( "wp" ), "n" ) ;
	$auto = Util_Format_Sanatize( Util_Format_GetVar( "auto" ), "n" ) ;
	$menu = ( $menu ) ? $menu : "go" ;
	$error = "" ;
	$theme = "default" ;

	$op_depts = Ops_get_OpDepts( $dbh, $opinfo["opID"] ) ;
	$opvars = Ops_get_OpVars( $dbh, $opinfo["opID"] ) ;

	if ( $action === "update_theme" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;
		$theme = Util_Format_Sanatize( Util_Format_GetVar( "theme" ), "ln" ) ;

		if ( !Ops_update_OpValue( $dbh, $opinfo["opID"], "theme", $theme ) )
			$error = "Error in updating theme." ;
		else
			$opinfo["theme"] = $theme ;
		
		$menu = "themes" ;
	}
	else if ( $action === "success" )
	{
		// sucess action is an indicator to show the success alert as well
		// as bypass the refreshing of the operator console
	}
	else
		$error = "invalid action" ;

	$query = "SELECT SUM(rateit) AS rateit, SUM(ratings) AS ratings FROM p_rstats_ops WHERE opID = '$opinfo[opID]'" ;
	database_mysql_query( $dbh, $query ) ; $data = database_mysql_fetchrow( $dbh ) ;
	$overall = ( isset( $data["rateit"] ) && $data["rateit"] ) ? round( $data["ratings"]/$data["rateit"] ) : 0 ;

	$query = "SELECT SUM(taken) AS total FROM p_rstats_ops WHERE opID = '$opinfo[opID]'" ;
	database_mysql_query( $dbh, $query ) ; $data = database_mysql_fetchrow( $dbh ) ;
	$chats_accepted = ( isset( $data["total"] ) ) ? $data["total"] : 0 ;

	$dept_string = " ( opID = $opinfo[opID] OR op2op = $opinfo[opID] " ;
	for ( $c = 0; $c < count( $op_depts ); ++$c )
	{
		if ( $op_depts[$c]["tshare"] )
			$dept_string .= " OR deptID = " . $op_depts[$c]["deptID"] ;
	}
	$dept_string .= " ) " ;

	$query = "SELECT count(*) AS total FROM p_transcripts WHERE $dept_string" ;
	database_mysql_query( $dbh, $query ) ; $data = database_mysql_fetchrow( $dbh ) ;
	$chat_transcripts = ( isset( $data["total"] ) ) ? $data["total"] : 0 ;

	$auto_login_enabled = ( isset( $_COOKIE["cAT"] ) && $_COOKIE["cAT"] ) ? 1 : 0 ;
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> Operator </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../css/setup.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/global_chat.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/jquery.tools.min.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/jquery_md5.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/dn.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/modernizr.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	var opwin ;
	var menu ;
	var theme = "<?php echo $opinfo["theme"] ?>" ;
	var base_url = ".." ; // needed for function play_sound()
	var embed = 0 ;
	var wp = ( ( typeof( window.external ) != "undefined" ) && ('wp_total_visitors' in window.external) ) ? 1 : 0 ;

	var audio_supported = HTML5_audio_support() ;
	var mp3_support = ( typeof( audio_supported["mp3"] ) != "undefined" ) ? 1 : 0 ;

	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;

		$('#op_launch_btn_popup').on('mouseover mouseout', function(event) {
			$('#op_launch_btn_popup').toggleClass('op_launch_btn_focus') ;
		});
		$('#op_launch_btn_tab').on('mouseover mouseout', function(event) {
			$('#op_launch_btn_tab').toggleClass('op_launch_btn_focus') ;
		});

		init_menu_op() ;
		init_div_confirm() ;
		toggle_menu_op( "<?php echo $menu ?>" ) ;

		if ( !<?php echo count( $op_depts ) ?> ) { $('#no_dept').show() ; }

		<?php if ( $action && !$error ): ?>do_alert( 1, "Update Success" ) ; setTimeout( function(){ $('#div_alert_wrapper').fadeOut("slow") ; }, 3000 ) ;<?php endif ; ?>

		if ( "<?php echo $jump ?>" == "online" )
		{
			$('#op_launch_btn_popup').fadeOut("fast").fadeIn("fast").fadeOut("fast").fadeIn("fast") ;
		}
		else
			$('#div_thumb_'+theme).fadeOut("fast").fadeIn("fast").fadeOut("fast").fadeIn("fast") ;

		if ( ( typeof( parent.isop ) != "undefined" ) && parent.dn_status == 1 )
		{
			parent.dn_status = undeefined ; // need to unset so it redirect once
			location.href = "notifications.php?console=1&jump=dn" ;
		}
		else if ( ( typeof( parent.isop ) != "undefined" ) && ( "<?php echo $action ?>" == "update_theme" ) )
			parent.refresh_console(0) ;

		toggle_status(0) ;
		if ( typeof( parent.isop ) != "undefined" ) { parent.init_extra_loaded() ; }
		if ( wp ) { $('#chat_text_powered').hide() ; }
	});

	function init_div_confirm()
	{
	}

	function launchit()
	{
		var open_status = $('#open_status').val() ;
		var open_win_popup = 1 ;
		var screen_width = screen.width ;
		var screen_height = screen.height ;
		var url = "operator.php?wp="+wp+"&auto=<?php echo $auto ?>&console=<?php echo $console ?>&open_status="+open_status+"&"+unixtime() ;

		var console_width ;
		if ( screen_width > 1200 ) { console_width = 1100 }
		else if ( screen_width > 1000 ) { console_width = 1000 ; }
		else if ( screen_width > 800 ) { console_width = 940 ; }
		else { console_width = 700 ; }
		var console_height = ( screen_height > 1000 ) ? 690 : 560 ;

		if ( !<?php echo count( $op_depts ) ?> )
			$('#no_dept').fadeOut("fast").fadeIn("fast").fadeOut("fast").fadeIn("fast") ;
		else
		{
			if ( typeof( opwin ) == "undefined" )
			{
				if ( open_win_popup )
					opwin = window.open( url, "operator_console", "scrollbars=yes,menubar=no,resizable=1,location=no,width="+console_width+",height="+console_height+",status=0" ) ;
				else
					opwin = window.open( url, "operator_console" ) ;
			}
			else if ( opwin.closed )
			{
				if ( open_win_popup )
					opwin = window.open( url, "operator_console", "scrollbars=yes,menubar=no,resizable=1,location=no,width="+console_width+",height="+console_height+",status=0" ) ;
				else
					opwin = window.open( url, "operator_console" ) ;
			}

			if ( opwin )
			{
				opwin.focus() ;
			}
		}

		return true ;
	}

	function confirm_theme( thetheme, thethumb )
	{
		if ( theme != thetheme )
		{
			var height = $(document).height() ;

			$('#theme_'+thetheme).prop('checked', true) ;
			$('#div_theme_thumb').html( "<div style=\"background: url( "+thethumb+" ); background-position: top left; width: 85px; height: 54px; -moz-border-radius: 5px; border-radius: 5px;\">&nbsp;</div>") ;

			$('body').css({'overflow': 'hidden'}) ;
			$('#div_confirm').css({'height': height+'px'}).show() ;
			$('#div_confirm_body').center().show() ;
		}
	}

	function update_theme( thetheme )
	{
		location.href = 'index.php?console=<?php echo $console ?>&wp='+wp+'&auto=<?php echo $auto ?>&action=update_theme&theme='+thetheme ;
	}

	function update_theme_pre( theflag )
	{
		if ( theflag )
		{
			var theme = $('input:radio[name=theme]:checked').val() ;
			update_theme( theme ) ;
		}
		else
		{
			$('#theme_<?php echo $opinfo["theme"] ?>').prop('checked', true) ;

			$('#div_confirm').hide() ;
			$('#div_confirm_body').hide() ;
			$('body').css({'overflow': 'visible'}) ;
		}
	}

	function toggle_win_option( theflag )
	{
		if ( theflag == "popup" )
		{
			$('#open_win_popup').prop('checked', true) ;
			$('#op_launch_btn_tab').hide() ;
			$('#op_launch_btn_popup').show() ;
		}
		else
		{
			$('#open_win_tab').prop('checked', true) ;
			$('#op_launch_btn_popup').hide() ;
			$('#op_launch_btn_tab').show() ;
		}
	}

	function toggle_status( thestatus )
	{
		$('#open_status').val( thestatus ) ;
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ); ?>

		<div id="op_go" style="margin: 0 auto;">
			<div id="no_dept" class="info_error" style="display: none; margin-bottom: 15px;"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Contact the Setup Admin to assign this account to a department.  Once assigned, <a href="./index.php?<?php echo time() ?>" style="color: #FFFFFF;">refresh</a> this page to continue.</div>

			<div>
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td width="55"><a href="settings.php"><img src="<?php print Util_Upload_GetLogo( "profile", $opinfo["opID"] ) ?>" width="55" height="55" border=0 style="border: 1px solid #DFDFDF;" class="round"></a></td>
					<td style="padding-left: 15px;">
						<div class="info_clear">
							<div style="text-shadow: 1px 1px #FFFFFF;"><span class="edit_title">Chat Operator: <span style="font-weight: bold; font-size: 22px;"><?php echo $opinfo["name"] ?></span></span> <span style="font-size: 12px;">&lt;<?php echo $opinfo["email"] ?>&gt;</span></div>

							<div style="margin-top: 15px;">
								<div style="float: left;">
									<table cellspacing=0 cellpadding=0 border=0>
									<tr>
										<td nowrap>
											<div style="display: inline-block; padding: 10px;" class="info_neutral"><a href="settings.php?jump=auto">Automatic Login</a>: <?php echo ( $auto_login_enabled ) ? "<span class=\"info_good\" style=\"padding: 2px;\">On</span>" : "Off" ; ?></div>
										</td>
										<td style="padding-left: 15px;" nowrap><div style="display: inline-block; padding: 10px;" class="info_neutral"><a href="reports.php">Total Chats Accepted</a>: <?php echo $chats_accepted ?></div></td>
										<td style="padding-left: 15px;" nowrap><div style="display: inline-block; padding: 10px;" class="info_neutral">
											<table cellspacing=0 cellpadding=0 border=0>
											<tr>
												<td nowrap><a href="transcripts.php"> Overall Rating</a>: </td>
												<td width="65"> <?php echo Util_Functions_Stars( "..", $overall ) ; ?></td>
											</tr></table>
										</div></td>
									</tr>
									</table>
								</div>
								<div style="float: right;">
									<table cellspacing=0 cellpadding=0 border=0>
									<tr>
										<td align="center">Launch console with status</td>
										<td style="padding-left: 10px;">
											<div style="">
												<div class="info_good" style="float: left; width: 60px; padding: 3px; cursor: pointer;" onclick="$('#status_0').prop('checked', true);toggle_status(0);"><input type="radio" name="status" id="status_0" value=0 checked> Online</div>
												<div class="info_error" style="float: left; margin-left: 10px; width: 60px; padding: 3px; cursor: pointer;" onclick="$('#status_1').prop('checked', true);toggle_status(1);"><input type="radio" name="status" id="status_1" value=1> Offline</div>
												<div style="clear: both;"></div>
											</div>
										</td>
									</tr>
									</table>
								</div>
								<div style="clear: both;"></div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="padding-top: 25px; padding-left: 20px;">
						<div id="div_status" style="text-shadow: none;">
							<div id="op_launch_btn_popup" style="border: 1px solid #049BD8; padding: 10px; font-size: 18px; font-weight: bold; color: #FFFFFF; text-shadow: 1px 1px #049BD8; text-align: center; cursor: pointer; box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);" onClick="launchit()" class="op_launch_btn round"><img src="../pics/icons/pointer.png" width="16" height="16" border="0" alt=""> Click to Launch Operator Console And To Go Online!</div>
						</div>
					</td>
				</tr>
				</table>
			</div>
		</div>

		<div id="op_themes" style="display: none; margin: 0 auto;">
			<?php if ( !$console ): ?><div style="margin-bottom: 25px;"><img src="../pics/icons/themes_big.png" width="48" height="48" border="0" alt=""> If the operator chat console is open, you will need to logout of the console and login again to see the changes.</div><?php endif ; ?>

			<div id="div_alert_wrapper" style=""><span id="div_alert"></span></div>
			<form>
			<input type="hidden" name="open_status" id="open_status" value="0">
			<table cellspacing=0 cellpadding=2 border=0 width="100%" style="margin-top: 25px;">
			<tr>
				<td>
					<?php
						$dir_themes = opendir( "$CONF[DOCUMENT_ROOT]/themes/" ) ;

						$themes = Array() ;
						while ( $theme = readdir( $dir_themes ) )
							$themes[] = $theme ;
						closedir( $dir_themes ) ;

						sort( $themes, SORT_STRING ) ;
						for ( $c = 0; $c < count( $themes ); ++$c )
						{
							$theme = $themes[$c] ;
							$checked = ( $opinfo["theme"] == $theme ) ? "checked" : "" ;
							$class = ( $checked ) ? "info_box" : "info_neutral" ;
							$path_thumb = ( is_file( "../themes/$theme/thumb.png" ) ) ? "../themes/$theme/thumb.png" : "../pics/screens/thumb_theme_blank.png" ;

							if ( preg_match( "/[a-z]/i", $theme ) && !preg_match( "/^\./", $theme ) && ( $theme != "initiate" ) )
								print "<div class=\"li_op round\" style=\"padding: 5px; width: 130px; margin-bottom: 15px;\"><div id=\"div_thumb_$theme\" style=\"background: url( $path_thumb ); background-position: top left; height: 100px; -moz-border-radius: 5px; border-radius: 5px;\"><span class=\"$class\" style=\"cursor: pointer;\" onClick=\"confirm_theme('$theme', '$path_thumb')\" id=\"span_$theme\"><input type=\"radio\" name=\"theme\" id=\"theme_$theme\" value=\"$theme\" $checked> $theme</span></div></div>" ;
						}
					?>
					<div style="clear: both;"></div>
				</td>
			</tr>
			</table>
			</form>
		</div>

<div id="div_confirm" style="display: none; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: url( ../pics/bg_trans_white.png ) repeat; overflow: hidden; z-index: 20;">&nbsp;</div>
<div id="div_confirm_body" class="info_info" style="display: none; position: absolute; width: 350px; margin: 0 auto; top: 100px; z-index: 21;">
	<div class="info_box" style="padding: 25px;">
		<table cellspacing=0 cellpadding=0 border=0>
		<tr>
			<td><div id="div_theme_thumb" class="li_mapp round" style="width: 85px; height: 54px;"></div><div class="clear:both;"></div></td>
			<td style="padding-left: 15px;">
				<div id="confirm_title">Select this theme?</div>
				<div style="margin-top: 15px;"><button type="button" onClick="update_theme_pre(1)" class="input_op_button" class="btn">Yes</button> &nbsp; &nbsp; <span style="text-decoration: underline; cursor: pointer;" onClick="update_theme_pre(0)">cancel</span></div>
			</td>
		</tr>
		</table>
	</div>
</div>

<?php include_once( "./inc_footer.php" ); ?>
