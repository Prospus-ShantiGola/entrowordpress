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
		$offline_form = Util_Format_Sanatize( Util_Format_GetVar( "offline_form" ), "n" ) ;
		$emailm_cc = Util_Format_Sanatize( Util_Format_GetVar( "emailm_cc" ), "e" ) ;

		$table_name = "msg_offline" ;

		if ( !$message )
			$error = "Blank input is invalid.  Message has been reset." ;
		else
		{
			if ( $copy_all )
			{
				for( $c = 0; $c < count( $departments ); ++$c )
				{
					Depts_update_DeptValue( $dbh, $departments[$c]["deptID"], $table_name, $message ) ;
					Depts_update_DeptValues( $dbh, $departments[$c]["deptID"], "emailm_cc", $emailm_cc, "msg_busy", $message_busy ) ;
					Depts_update_DeptVarsValue( $dbh, $departments[$c]["deptID"], "offline_form", $offline_form ) ;
				}
			}
			else
			{
				Depts_update_DeptValue( $dbh, $deptid, $table_name, $message ) ;
				Depts_update_DeptValues( $dbh, $deptid, "emailm_cc", $emailm_cc, "msg_busy", $message_busy ) ;
				Depts_update_DeptVarsValue( $dbh, $deptid, "offline_form", $offline_form ) ;
			}
		}
	}

	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	$deptvars = Depts_get_DeptVars( $dbh, $deptid ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($deptinfo["lang"], "ln").".php" ) ;
	$deptname = $deptinfo["name"] ;

	$message = $deptinfo["msg_offline"] ;
	$offline_form = ( isset( $deptvars["offline_form"] ) ) ? $deptvars["offline_form"] : 1 ;
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

		<?php if ( ( $action === "update" ) && !$error ): ?>
		parent.do_alert( 1, "Success" ) ;
		<?php elseif ( $error ): ?>
		parent.do_alert( 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>
	});

	function do_submit_settings()
	{
		var emailm_cc = $('#emailm_cc').val().replace(/\s/g,'') ;
		$('#emailm_cc').val(emailm_cc) ;

		if ( emailm_cc && !check_email( emailm_cc ) )
			parent.do_alert( 0, "Email format is invalid. (example: you@domain.com)" ) ;
		else if ( emailm_cc && ( "<?php echo $deptinfo["email"] ?>" == emailm_cc ) )
			parent.do_alert( 0, "Email address must be different then the department email." ) ;
		else
			$('#form_settings').submit() ;
	}

	function toggle_offlineform( theobject )
	{
		if ( theobject.value == 1 )
			$('#div_cc').show() ;
		else
			$('#div_cc').hide() ;
	}
//-->
</script>
</head>
<body style="overflow: hidden;">

<div id="iframe_body" style="height: 390px; overflow: hidden; <?php echo ( $bgcolor ) ? "background: #$bgcolor;" : "" ?>">
	<form action="iframe_edit_2.php" id="form_settings" method="POST" accept-charset="<?php echo $LANG["CHARSET"] ?>">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
	<input type="hidden" name="option" value="<?php echo $option ?>">
	<input type="hidden" name="bgcolor" value="<?php echo $bgcolor ?>">
	<div style="">
		<div>
			<div style="font-weight: bold; font-size: 14px;">Standard Offline Message:</div>
			<div style="margin-top: 5px;">Display the following Offline Message on the chat request window when department operators are offline.</div>
		</div>
		<div style="margin-top: 5px; padding-bottom: 15px;"><input type="text" style="width: 95%" id="message" name="message" maxlength="955" value="<?php echo preg_replace( "/\"/", "&quot;", $message ) ?>"></div>

		<div>
			<div style="font-weight: bold; font-size: 14px;">"Busy" Offline Message:</div>
			<div style="margin-top: 5px;">Display the following Offline Message when operators are online but were unable to accept the chat request.</div>
			<div style="margin-top: 5px; padding-bottom: 15px;"><input type="text" style="width: 95%" id="message_busy" name="message_busy" maxlength="955" value="<?php echo preg_replace( "/\"/", "&quot;", $deptinfo["msg_busy"] ) ?>"></div>
		</div>
		<div style="margin-top: 5px; padding-bottom: 15px;">
			<table cellspacing=0 cellpadding=0 border=0 width="100%">
			<tr>
				<td>
					<select name="offline_form" style="width: 98%;" onChange="toggle_offlineform(this)">
						<option value="1" <?php echo ( $offline_form ) ? "selected" : "" ; ?>>When Offline or Busy: Allow visitors to "leave a message" by filling out the email form.</option>
						<option value="0" <?php echo ( !$offline_form ) ? "selected" : "" ; ?>>When Offline or Busy: Do not display the "leave a message" email form.  Only display the above Offline Message.</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="padding-top: 5px;">
					<div id="div_cc" style="<?php echo ( !$offline_form ) ? "display: none;" : "" ?>"><img src="../pics/icons/email.png" width="16" height="16" border="0" alt=""> Email the "leave a message" to the department email address and also send a copy to: <input type="text" size="20" maxlength="160" style="padding: 5px;" name="emailm_cc" id="emailm_cc" value="<?php echo $deptinfo["emailm_cc"] ?>"> (leave blank to inactivate)</div>
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