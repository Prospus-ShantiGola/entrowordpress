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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$page = Util_Format_Sanatize( Util_Format_GetVar( "page" ), "n" ) ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$option = Util_Format_Sanatize( Util_Format_GetVar( "option" ), "n" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$bgcolor = Util_Format_Sanatize( Util_Format_GetVar( "bgcolor" ), "ln" ) ;

	$departments = Depts_get_AllDepts( $dbh ) ;

	if ( $action === "update" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/update.php" ) ;

		$copy_all = Util_Format_Sanatize( Util_Format_GetVar( "copy_all" ), "n" ) ;
		$message = preg_replace( "/<script(.*?)<\/script>/i", "", Util_Format_Sanatize( Util_Format_GetVar( "message" ), "" ) ) ;
		$message_busy = preg_replace( "/<script(.*?)<\/script>/i", "", Util_Format_Sanatize( Util_Format_GetVar( "message_busy" ), "" ) ) ;

		$table_name = "msg_greet" ;
		$idle_disconnect_minutes_o = Util_Format_Sanatize( Util_Format_GetVar( "idle_disconnect_minutes_o" ), "n" ) ;
		$idle_disconnect_minutes_v = Util_Format_Sanatize( Util_Format_GetVar( "idle_disconnect_minutes_v" ), "n" ) ;

		if ( !$message )
			$error = "Blank input is invalid.  Message has been reset." ;
		else
		{
			if ( $copy_all )
			{
				for( $c = 0; $c < count( $departments ); ++$c )
				{
					Depts_update_DeptValue( $dbh, $departments[$c]["deptID"], $table_name, $message ) ;
					Depts_update_DeptVarsValues( $dbh, $departments[$c]["deptID"], "idle_o", $idle_disconnect_minutes_o, "idle_v", $idle_disconnect_minutes_v ) ;
				}
			}
			else
			{
				Depts_update_DeptValue( $dbh, $deptid, $table_name, $message ) ;
				Depts_update_DeptVarsValues( $dbh, $deptid, "idle_o", $idle_disconnect_minutes_o, "idle_v", $idle_disconnect_minutes_v ) ;
			}
		}
	}

	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	$deptvars = Depts_get_DeptVars( $dbh, $deptid ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($deptinfo["lang"], "ln").".php" ) ;
	$deptname = $deptinfo["name"] ;

	$message = $deptinfo["msg_greet"] ;
	$idle_disconnect_o = ( isset( $deptvars["idle_o"] ) ) ? $deptvars["idle_o"] : 0 ;
	$idle_disconnect_v = ( isset( $deptvars["idle_v"] ) ) ? $deptvars["idle_v"] : 0 ;
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> PHP Live! Support </title>

<meta name="description" content="PHP Live! Support <?php echo $VERSION ?>">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=<?php echo $LANG["CHARSET"] ?>">
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../css/setup.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	var winname = unixtime() ;
	var option = <?php echo $option ?> ; // used to communicate with depts.php to toggle iframe

	$(document).ready(function()
	{
		$.ajaxSetup({ cache: false }) ;
		$("body").css({'background-color': '#FFFFFF'}) ;

		<?php if ( $idle_disconnect_o ): ?>
			$('#idle_disconnect_o_onoff_on').prop('checked', true) ;
			toggle_idle_minutes_o( 1 ) ;
		<?php else: ?>
			$('#idle_disconnect_o_onoff_off').prop('checked', true) ;
			toggle_idle_minutes_o( 0 ) ;
		<?php endif ; ?>

		<?php if ( $idle_disconnect_v ): ?>
			$('#idle_disconnect_v_onoff_on').prop('checked', true) ;
			toggle_idle_minutes_v( 1 ) ;
		<?php else: ?>
			$('#idle_disconnect_v_onoff_off').prop('checked', true) ;
			toggle_idle_minutes_v( 0 ) ;
		<?php endif ; ?>

		<?php if ( ( $action === "update" ) && !$error ): ?>
		parent.do_alert( 1, "Success" ) ;
		<?php elseif ( $error ): ?>
		parent.do_alert( 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>
	});

	function do_submit_settings()
	{
		var emailt = $('#emailt').val() ;

		if ( emailt && !check_email( emailt ) )
			parent.do_alert( 0, "Email format is invalid. (example: you@domain.com)" ) ;
		else
			$('#form_settings').submit() ;
	}

	function toggle_idle_minutes_o( theflag )
	{
		if ( theflag )
		{
			var idle_disconnect_minutes_select = <?php echo ( $idle_disconnect_o ) ? $idle_disconnect_o : 15 ; ?> ;
			$('#idle_disconnect_minutes_o').attr("disabled", false) ;
			$("#idle_disconnect_minutes_o option[value='-']").remove() ;
			$('#idle_disconnect_minutes_o').val( idle_disconnect_minutes_select ) ;
		}
		else
		{
			$('#idle_disconnect_minutes_o').attr("disabled", true) ;
			$("#idle_disconnect_minutes_o").append("<option value='-'></option>") ;
			$("#idle_disconnect_minutes_o").val("-") ;
		}
	}

	function toggle_idle_minutes_v( theflag )
	{
		if ( theflag )
		{
			var idle_disconnect_minutes_select = <?php echo ( $idle_disconnect_v ) ? $idle_disconnect_v : 15 ; ?> ;
			$('#idle_disconnect_minutes_v').attr("disabled", false) ;
			$("#idle_disconnect_minutes_v option[value='-']").remove() ;
			$('#idle_disconnect_minutes_v').val( idle_disconnect_minutes_select ) ;
		}
		else
		{
			$('#idle_disconnect_minutes_v').attr("disabled", true) ;
			$("#idle_disconnect_minutes_v").append("<option value='-'></option>") ;
			$("#idle_disconnect_minutes_v").val("-") ;
		}
	}
//-->
</script>
</head>
<body style="overflow: hidden;">

<div id="iframe_body" style="height: 390px; overflow: hidden; <?php echo ( $bgcolor ) ? "background: #$bgcolor;" : "" ?>">
	<form action="iframe_edit_1.php" id="form_settings" method="POST" accept-charset="<?php echo $LANG["CHARSET"] ?>">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
	<input type="hidden" name="option" value="<?php echo $option ?>">
	<input type="hidden" name="bgcolor" value="<?php echo $bgcolor ?>">
	<div style="">
		<div style="text-align: justify;">
			<div style="">The following message will be displayed to the visitor while being connected with an operator.</div>
			<div style="margin-top: 10px;"><b>%%visitor%%</b> = visitor's name</div>
		</div>
		<div style="margin-top: 5px; padding-bottom: 15px;"><input type="text" style="width: 95%" id="message" name="message" maxlength="455" value="<?php echo preg_replace( "/\"/", "&quot;", $message ) ?>"></div>

		<div style="display: none; margin-bottom: 15px;">
			<table cellspacing=0 cellpadding=0 border=0 width="100%">
			<tr>
				<td width="50%" style="padding-right: 1px;">
					<div style="height: 160px;" class="info_neutral">
						<div style="font-size: 14px; font-weight: bold;">Operator Idle Chat Disconnect</div>
						<div style="margin-top: 5px;">
							<table cellspacing=0 cellpadding=2 border=0>
							<tr>
								<td valign="top" width="150">
									<div>
										<div class="info_error" style="float: left; width: 60px; padding: 3px; cursor: pointer;" onclick="$('#idle_disconnect_o_onoff_off').prop('checked', true);toggle_idle_minutes_o(0);"><input type="radio" name="idle_disconnect_o_onoff" id="idle_disconnect_o_onoff_off" value=0> Off</div>
										<div class="info_good" style="float: left; margin-left: 10px; width: 60px; padding: 3px; cursor: pointer;" onclick="$('#idle_disconnect_o_onoff_on').prop('checked', true);toggle_idle_minutes_o(1);"><input type="radio" name="idle_disconnect_o_onoff" id="idle_disconnect_o_onoff_on" value=1> On</div>
										<div style="clear: both;"></div>
									</div>
								</td>
								<td style="padding-left: 15px;">
									<div>Automatically disconnect the chat session if the <b>operator</b> has not sent a chat response within:</div>
									<div style="margin-top: 5px;"><select id="idle_disconnect_minutes_o" name="idle_disconnect_minutes_o">
									<?php for( $c = 10; $c <= 30; ++$c ) { print "<option value=\"$c\">$c</option>" ; } ?>
									</select>
									minutes.</div>
								</td>
							</tr>
							</table>
						</div>
					</div>
				</td>
				<td width="50%" style="padding-left: 1px;">
					<div style="height: 160px;" class="info_neutral">
						<div style="font-size: 14px; font-weight: bold;">Visitor Idle Chat Disconnect</div>
						<div style="margin-top: 5px;">
							<table cellspacing=0 cellpadding=2 border=0>
							<tr>
								<td valign="top" width="150">
									<div>
										<div class="info_error" style="float: left; width: 60px; padding: 3px; cursor: pointer;" onclick="$('#idle_disconnect_v_onoff_off').prop('checked', true);toggle_idle_minutes_v(0);"><input type="radio" name="idle_disconnect_v_onoff" id="idle_disconnect_v_onoff_off" value=0> Off</div>
										<div class="info_good" style="float: left; margin-left: 10px; width: 60px; padding: 3px; cursor: pointer;" onclick="$('#idle_disconnect_v_onoff_on').prop('checked', true);toggle_idle_minutes_v(1);"><input type="radio" name="idle_disconnect_v_onoff" id="idle_disconnect_v_onoff_on" value=1> On</div>
										<div style="clear: both;"></div>
									</div>
									<div style="margin-top: 15px;"><img src="../pics/icons/mobile.png" width="16" height="16" border="0" alt=""> There is an automatic idle disconnect of <?php echo $VARS_MOBILE_CHAT_IDLE_DISCONNECT ?> minutes for mobile visitors, always enabled.  The value set here will override the default 60 minutes.</div>
								</td>
								<td style="padding-left: 15px;">
									<div>Automatically disconnect the chat session if the <b>visitor</b> has not sent a chat response within:</div>
									<div style="margin-top: 5px;"><select id="idle_disconnect_minutes_v" name="idle_disconnect_minutes_v">
									<?php for( $c = 10; $c <= 30; ++$c ) { print "<option value=\"$c\">$c</option>" ; } ?>
									</select>
									minutes.</div>
								</td>
							</tr>
							</table>
						</div>
					</div>
				</td>
			</tr>
			</table>
		</div>

		<?php if ( count( $departments ) > 1 ) : ?>
		<div style=""><input type="checkbox" id="copy_all" name="copy_all" value=1> copy this update to all departments</div>
		<?php endif ; ?>

		<div style="margin-top: 15px;"><input type="button" value="Update" class="btn" onClick="do_submit_settings()"> &nbsp; &nbsp; <a href="JavaScript:void(0)" onClick="parent.do_options( <?php echo $option ?>, <?php echo $deptid ?> );">cancel</a></div>
	</div>
	</form>
</div>

</body>
</html>