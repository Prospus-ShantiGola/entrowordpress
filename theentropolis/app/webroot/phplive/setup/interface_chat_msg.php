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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$error = "" ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$copy_all = Util_Format_Sanatize( Util_Format_GetVar( "copy_all" ), "n" ) ;

	$text = Util_Format_Sanatize( Util_Format_GetVar( "text" ), "noscripts" ) ;
	$text = preg_replace( "/\"/", "'", $text ) ;
	$text = preg_replace( "/<html(.*?)>/i", "'", $text ) ; $text = preg_replace( "/<body(.*?)>/i", "'", $text ) ;

	$deptinfo = Array() ;
	$departments = Depts_get_AllDepts( $dbh ) ;

	for ( $c = 0; $c < count( $departments ); ++$c )
	{
		$department = $departments[$c] ;
		if ( $department["deptID"] == $deptid )
		{
			$deptinfo = $department ;
			$deptvars = Depts_get_DeptVars( $dbh, $deptid ) ;
			break ;
		}
	}

	$chat_end_message = ( isset( $deptvars["end_chat_msg"] ) && $deptvars["end_chat_msg"] ) ? $deptvars["end_chat_msg"] : "" ;
	if ( $action == "update" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/update.php" ) ;

		if ( $copy_all )
		{
			for( $c = 0; $c < count( $departments ); ++$c )
			{
				if ( !Depts_update_DeptVarsValue( $dbh, $departments[$c]["deptID"], "end_chat_msg", $text ) )
				{
					$error = "Error in processing update.  Please try again." ;
					break ;
				}
			}
		}
		else if ( !Depts_update_DeptVarsValue( $dbh, $deptid, "end_chat_msg", $text ) )
			$error = "Error in processing update.  Please try again." ;

		if ( !$error )
		{
			$chat_end_message = $text ;
			$deptvars["end_chat_msg"] = $chat_end_message ;
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
	var text = "" ;

	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		init_menu() ;
		toggle_menu_setup( "interface" ) ;

		<?php if ( $action && !$error ): ?>do_alert( 1, "Success" ) ;<?php endif ; ?>
	});

	function switch_dept( theobject )
	{
		location.href = "interface_chat_msg.php?deptid="+theobject.value+"&"+unixtime() ;
	}

	function view_preview( theflag )
	{
		if ( theflag )
		{
			//
		}
		else
		{
			text = encodeURIComponent( $('#text').val() ) ;
			$('#iframe_widget_embed').attr("src", "iframe_chat_msg.php?&preview=1&deptid=<?php echo $deptid ?>&text="+text+"&"+unixtime()) ;
			$('#phplive_survey').fadeOut("fast").fadeIn("fast") ;
		}
	}

	function do_reset()
	{
		$('#div_text').fadeTo( "fast", 0.1 ).fadeTo( "fast", 1 ) ;
		$('#form_txt').trigger("reset") ;
	}

	function do_update()
	{
		$('#form_txt').submit() ;
	}

//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" style="margin-left: 0px;" onClick="location.href='interface_themes.php'">Themes</div>
			<div class="op_submenu" onClick="location.href='interface.php?jump=logo'">Company Logo</div>
			<div class="op_submenu" onClick="location.href='interface.php?jump=charset'">Character Set</div>
			<?php if ( phpversion() >= "5.1.0" ): ?><div class="op_submenu" onClick="location.href='interface.php?jump=time'">Timezone</div><?php endif; ?>
			<div class="op_submenu" onClick="location.href='interface_lang.php'" id="menu_lang">Language Text</div>
			<div class="op_submenu_focus">Chat End Msg</div>
			<div class="op_submenu" onClick="location.href='interface.php?jump=screen'">Login Screen</div>
			<div class="op_submenu" onClick="location.href='interface.php?jump=props'">Properties</div>
			<div style="clear: both"></div>
		</div>

		<div style="margin-top: 25px;">
			<form method="POST" action="interface_chat_msg.php" enctype="multipart/form-data" id="form_txt">
			<input type="hidden" name="action" value="update">
			<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
			<input type="hidden" name="pos" id="pos" value="">
			<table cellspacing=0 cellpadding=0 border=0 width="100%">
			<tr>
				<td></td>
				<td style="padding-left: 25px; padding-bottom: 10px;">
					<div>
						<select name="deptid" id="deptid" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_dept( this )">
						<option value="0">Select Department</option>
						<?php
							for ( $c = 0; $c < count( $departments ); ++$c )
							{
								$department = $departments[$c] ;
								$selected = ( $deptid == $department["deptID"] ) ? "selected" : "" ;
								print "<option value=\"$department[deptID]\" $selected>$department[name]</option>" ;
							}
						?>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top" width="<?php echo $VARS_CHAT_WIDTH_WIDGET ?>">
					<div style="background: url( ../pics/icons/megaphone.png ) no-repeat; padding-left: 20px; text-align: justify;">Custom "Chat End Message" will be displayed to the visitor after the chat has ended.  The message will be visible on the visitor's chat immediately after the "chat has ended" message.</div>

					<div style="margin-top: 15px;"><?php echo isset( $deptinfo["deptID"] ) ? "<big><b>$deptinfo[name]</b></big> Chat End Message" : "" ; ?></div>
					<div id='phplive_survey' style='margin-top: 5px; width: <?php echo $VARS_CHAT_WIDTH_WIDGET ?>px; height: 200px; overflow: auto; -moz-border-radius: 5px; border-radius: 5px;'>
						<iframe id='iframe_widget_embed' name='iframe_widget_embed' style='width: 100%; height: 100%; -moz-border-radius: 5px; border-radius: 5px; border: 0px; box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);' src='iframe_chat_msg.php?deptid=<?php echo $deptid ?>' scrolling='no' border=0 frameborder=0></iframe>
					</div>
				</td>
				<td valign="top" width="100%" style="padding-left: 25px;">
					<div style="<?php echo ( !$deptid ) ? "display: none;" : "" ; ?>">

						<div>
							<div style="margin-top: 15px; background: url( ../pics/icons/warning.png ) no-repeat; padding-left: 20px;"> If linking to external URLs, be sure to include the <code>target='_blank'</code> in the <code>href</code> tag to open the link in a new window instead of inside the chat window.</div>
							<div style="margin-top: 15px; background: url( ../pics/icons/warning.png ) no-repeat; padding-left: 20px;"> Try to fit the content within the available box size to the left.  Visitors will be able to view the entire content without having to scroll.</div>
						</div>

						<div style="margin-top: 15px;">Your custom "Chat End Message" (HTML and CSS is ok. JavaScript will be omitted)</div>
						<div id="div_text"><textarea style="width: 95%; resize: vertical;" rows="8" class="input" name="text" id="text"><?php echo $chat_end_message ; ?></textarea></div>

						<div style="margin-top: 30px;"><span class="info_box"><img src="../pics/icons/arrow_left.png" width="16" height="15" border="0" alt=""> <a href="JavaScript:void(0)" onClick="view_preview(0)">view how it looks</a></span></div>

						<div style="margin-top: 35px;">
							<?php if ( count( $departments ) > 1 ) : ?>
							<div style="margin-top: 25px;"><input type="checkbox" id="copy_all" name="copy_all" value=1> copy this update to all departments</div>
							<?php endif ; ?>

							<div style="margin-top: 15px;"><button type="button" class="btn" onClick="do_update()">Update Message</button> &nbsp; &nbsp; <?php if ( $deptid && isset( $deptvars["end_chat_msg"] ) && $deptvars["end_chat_msg"] ): ?><button type="button" class="btn" onClick="do_reset()">Reset</button><?php endif ; ?></div>
						</div>
					</div>
				</td>
			</tr>
			</table>
			</form>
		</div>

<?php include_once( "./inc_footer.php" ) ?>
