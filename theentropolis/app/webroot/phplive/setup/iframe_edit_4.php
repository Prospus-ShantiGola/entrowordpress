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
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ; if ( !$action ) { $action = "email" ; }
	$option = Util_Format_Sanatize( Util_Format_GetVar( "option" ), "n" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$bgcolor = Util_Format_Sanatize( Util_Format_GetVar( "bgcolor" ), "ln" ) ;

	$copy_all = Util_Format_Sanatize( Util_Format_GetVar( "copy_all" ), "n" ) ;

	$departments = Depts_get_AllDepts( $dbh ) ;

	if ( $action === "update_email" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/update.php" ) ;

		$temail = Util_Format_Sanatize( Util_Format_GetVar( "temail" ), "n" ) ;
		$temaild = Util_Format_Sanatize( Util_Format_GetVar( "temaild" ), "n" ) ;
		$emailt = Util_Format_Sanatize( Util_Format_GetVar( "emailt" ), "e" ) ;
		$emailt_bcc = Util_Format_Sanatize( Util_Format_GetVar( "emailt_bcc" ), "n" ) ;

		if ( $copy_all )
		{
			for( $c = 0; $c < count( $departments ); ++$c )
			{
				Depts_update_DeptValues( $dbh, $departments[$c]["deptID"], "temail", $temail, "temaild", $temaild ) ;
				Depts_update_DeptValues( $dbh, $departments[$c]["deptID"], "emailt", $emailt, "emailt_bcc", $emailt_bcc ) ;
			}
		}
		else
		{
			Depts_update_DeptValues( $dbh, $deptid, "temail", $temail, "temaild", $temaild ) ;
			Depts_update_DeptValues( $dbh, $deptid, "emailt", $emailt, "emailt_bcc", $emailt_bcc ) ;
		}
	}
	else if ( $action == "update_msg" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/update.php" ) ;

		$femail = Util_Format_Sanatize( Util_Format_GetVar( "femail" ), "n" ) ;
		$message = preg_replace( "/<script(.*?)<\/script>/i", "", Util_Format_Sanatize( Util_Format_GetVar( "message" ), "" ) ) ;

		$table_name = "msg_email" ;

		if ( $copy_all )
		{
			for( $c = 0; $c < count( $departments ); ++$c )
			{
				Depts_update_DeptValue( $dbh, $departments[$c]["deptID"], $table_name, $message ) ;
				Depts_update_DeptVarsValue( $dbh, $departments[$c]["deptID"], "trans_f_dept", $femail ) ;
			}
		}
		else
		{
			Depts_update_DeptValue( $dbh, $deptid, $table_name, $message ) ;
			Depts_update_DeptVarsValue( $dbh, $deptid, "trans_f_dept", $femail ) ;
		}
	}

	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	$deptvars = Depts_get_DeptVars( $dbh, $deptid ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($deptinfo["lang"], "ln").".php" ) ;
	$deptname = $deptinfo["name"] ;

	$message = $deptinfo["msg_email"] ;
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

		<?php if ( ( ( $action === "update_email" ) || ( $action === "update_msg" ) ) && !$error ): ?>
		parent.do_alert( 1, "Success" ) ;
		<?php elseif ( $error ): ?>
		parent.do_alert( 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>

		show_div_trans( "<?php echo ( $action == "update_msg" ) ? "msg" : $action ; ?>" ) ;
	});

	function do_submit_settings()
	{
		var emailt = $('#emailt').val().replace(/\s/g,'') ;
		$('#emailt').val(emailt) ;

		if ( emailt && !check_email( emailt ) )
			parent.do_alert( 0, "Email format is invalid. (example: you@domain.com)" ) ;
		else if ( emailt && ( "<?php echo $deptinfo["email"] ?>" == emailt ) )
			parent.do_alert( 0, "Email address must be different then the department email." ) ;
		else
			$('#form_settings').submit() ;
	}

	function show_div_trans( thediv )
	{
		if ( thediv == "msg" )
		{
			$('#action').val("update_msg") ;
			$('#menu2_trans_email').removeClass("op_submenu_focus").addClass("op_submenu2") ;
			$('#menu2_trans_msg').removeClass("op_submenu2").addClass("op_submenu_focus") ;
			$('#div_email').hide() ; $('#div_msg').show() ;
		}
		else
		{
			$('#action').val("update_email") ;
			$('#menu2_trans_msg').removeClass("op_submenu_focus").addClass("op_submenu2") ;
			$('#menu2_trans_email').removeClass("op_submenu2").addClass("op_submenu_focus") ;
			$('#div_msg').hide() ; $('#div_email').show() ;
		}
	}
//-->
</script>
</head>
<body style="overflow: hidden;">

<div id="iframe_body" style="height: 390px; overflow: hidden; <?php echo ( $bgcolor ) ? "background: #$bgcolor;" : "" ?>">
	<form action="iframe_edit_4.php" id="form_settings" method="POST" accept-charset="<?php echo $LANG["CHARSET"] ?>">
	<input type="hidden" name="action" id="action" value="update_msg">
	<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
	<input type="hidden" name="option" value="<?php echo $option ?>">
	<input type="hidden" name="bgcolor" value="<?php echo $bgcolor ?>">
	<div id="">
		<div class="op_submenu2" onClick="show_div_trans('email')" id="menu2_trans_email" style="padding: 4px;"><img src="../pics/icons/email.png" width="16" height="16" border="0" alt=""> Email Transcript</div>
		<div class="op_submenu_focus" onClick="show_div_trans('msg')" id="menu2_trans_msg" style="padding: 4px;"><img src="../pics/icons/view.png" width="16" height="16" border="0" alt=""> Transcript Message</div>
		<div style="clear: both"></div>
	</div>
	<div style="">
		<div id="div_msg" style="display: none; margin-top: 15px; padding-bottom: 15px;">
			<div>
				<img src="../pics/icons/email.png" width="16" height="16" border="0" alt=""> From: 
				<span class="info_neutral" style="cursor: pointer;" onclick="$('#femail_op').prop('checked', true)"><input type="radio" name="femail" id="femail_op" value="0" <?php echo ( !isset( $deptvars["trans_f_dept"] ) || !$deptvars["trans_f_dept"] ) ? "checked" : "" ; ?>> Operator Email Address</span>
				<span class="info_neutral" style="margin-left: 5px; cursor: pointer;" onclick="$('#femail_dept').prop('checked', true)"><input type="radio" name="femail" id="femail_dept" value="1" <?php echo ( isset( $deptvars["trans_f_dept"] ) && $deptvars["trans_f_dept"] ) ? "checked" : "" ; ?>> Department Email Address</span>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td valign="top" width="300" nowrap>
						<textarea type="text" cols="50" rows="8" id="message" name="message"><?php echo preg_replace( "/\"/", "&quot;", $message ) ?></textarea>
					</td>
					<td><img src="../pics/space.gif" width="55" height=1></td>
					<td valign="top" width="100%">
						<div class="info_box">
						<ul>
							<li style="margin-top: 5px;"> Dynamically populated variables:
								<ul style="margin-top: 10px;">
									<li> <b>%%transcript%%</b> = the chat transcript
									<li> <b>%%visitor%%</b> = visitor's name
									<li> <b>%%operator%%</b> = operator name
									<li> <b>%%op_email%%</b> = operator email
									<li style="margin-top: 15px;"> <a href="JavaScript:void(0)" onClick="parent.do_options( 6, 1, 'FFFFFF' )">custom field values</a> (if provided) will be placed right after the %%transcript%%
								</ul>
						</ul>
						</div>
					</td>
				</tr>
				</table>
			</div>
		</div>
		<div id="div_email" style="display: none; margin-top: 15px;">
			<div style="padding-bottom: 15px; text-align: justify;">
				<div style="float: left; height: 160px; width: 370px" class="info_info">
					<div style="font-weight: bold; font-size: 14px;">Visitor Email Transcript</div>
					<div style="margin-top: 5px;">Provide visitors an option to receive the chat transcript by email when chat session ends.</div>
					<div style="margin-top: 10px;">
						<div class="li_op round" style="cursor: pointer;" onclick="$('#temail_1').prop('checked', true)"><input type="radio" name="temail" id="temail_1" value="1" checked> Yes </div>
						<div class="li_op round" style="cursor: pointer;" onclick="$('#temail_0').prop('checked', true)"><input type="radio" name="temail" id="temail_0" value="0"> No</div>
						<div style="clear: both;"></div>
					</div>
				</div>
				<div style="float: left; margin-left: 2px; height: 160px; width: 370px;" class="info_info">
					<div style="">Send a copy of the chat transcript to the department email address (<span style="color: #4285F4; font-weight: bold;"><?php echo $deptinfo["email"] ?></span>) when chat session ends?</div>
					<div style="margin-top: 10px;">
						<div class="li_op round" style="cursor: pointer;" onclick="$('#temaild_1').prop('checked', true)"><input type="radio" name="temaild" id="temaild_1" value="1" checked> Yes</div>
						<div class="li_op round" style="cursor: pointer;" onclick="$('#temaild_0').prop('checked', true)"><input type="radio" name="temaild" id="temaild_0" value="0"> No</div>
						<div style="clear: both;"></div>
					</div>

					<div style="margin-top: 15px;">Send a copy of the chat transcript to the following email address when chat session ends. (leave blank to inactivate)</div>
					<div style="margin-top: 10px;">
						<input type="text" style="width: 50%" id="emailt" name="emailt" maxlength="160" value="<?php echo $deptinfo["emailt"] ?>" onKeyPress="return justemails(event)">
					</div>
					<div style="display: none; margin-top: 10px;">
						<input type="checkbox" name="emailt_bcc" id="emailt_bcc" value=1 class="select" <?php echo ( $deptinfo["emailt_bcc"] ) ? "checked" : "" ; ?>> send as BCC
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<script data-cfasync="false" type="text/javascript">
			<!--
				$( "input#temail_"+<?php echo $deptinfo["temail"] ?> ).prop( "checked", true ) ;
				$( "input#temaild_"+<?php echo $deptinfo["temaild"] ?> ).prop( "checked", true ) ;
			//-->
			</script>
		</div>
	</div>

	<?php if ( count( $departments ) > 1 ) : ?>
	<div style=""><input type="checkbox" id="copy_all" name="copy_all" value=1> copy this update to all departments</div>
	<?php endif ; ?>

	<div style="margin-top: 15px;"><input type="button" value="Update" class="btn" onClick="do_submit_settings()"> &nbsp; &nbsp; <a href="JavaScript:void(0)" onClick="parent.do_options( <?php echo $option ?>, <?php echo $deptid ?> );">cancel</a></div>
	</form>
</div>

</body>
</html>