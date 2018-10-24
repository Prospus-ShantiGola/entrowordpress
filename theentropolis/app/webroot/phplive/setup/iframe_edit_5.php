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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;

	$page = Util_Format_Sanatize( Util_Format_GetVar( "page" ), "n" ) ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$option = Util_Format_Sanatize( Util_Format_GetVar( "option" ), "n" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$bgcolor = Util_Format_Sanatize( Util_Format_GetVar( "bgcolor" ), "ln" ) ;

	$copy_all = Util_Format_Sanatize( Util_Format_GetVar( "copy_all" ), "n" ) ;

	$est = Util_Format_Sanatize( Util_Format_GetVar( "est" ), "n" ) ;
	$qpos = Util_Format_Sanatize( Util_Format_GetVar( "qpos" ), "n" ) ;
	$qlimit = Util_Format_Sanatize( Util_Format_GetVar( "qlimit" ), "n" ) ;

	$departments = Depts_get_AllDepts( $dbh ) ;
	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	$deptvars = Depts_get_DeptVars( $dbh, $deptid ) ;
	$qtexts = ( isset( $deptvars["qtexts"] ) ) ? unserialize( $deptvars["qtexts"] ) : Array() ;

	if ( $action === "update" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/update.php" ) ;

		$queue = Util_Format_Sanatize( Util_Format_GetVar( "queue" ), "n" ) ;
		$qtype = Util_Format_Sanatize( Util_Format_GetVar( "qtype" ), "n" ) ; if ( $queue && ( $qtype == 2 ) ) { $queue = 2 ; }
		$CHAT_QUEUE_EST = Util_Format_Sanatize( Util_Format_GetVar( "CHAT_QUEUE_EST" ), "notags" ) ;
		$CHAT_QUEUE_EST_MIN = Util_Format_Sanatize( Util_Format_GetVar( "CHAT_QUEUE_EST_MIN" ), "notags" ) ;
		$CHAT_QUEUE_POS = Util_Format_Sanatize( Util_Format_GetVar( "CHAT_QUEUE_POS" ), "notags" ) ;

		$qtexts = Array() ;
		$qtexts["CHAT_QUEUE_EST"] = Util_Format_ConvertQuotes( $CHAT_QUEUE_EST ) ;
		$qtexts["CHAT_QUEUE_EST_MIN"] = Util_Format_ConvertQuotes( $CHAT_QUEUE_EST_MIN ) ;
		$qtexts["CHAT_QUEUE_POS"] = Util_Format_ConvertQuotes( $CHAT_QUEUE_POS ) ;

		if ( $copy_all )
		{
			for( $c = 0; $c < count( $departments ); ++$c )
			{
				$temp_deptid = $departments[$c]["deptID"] ;
				Depts_update_DeptVarsValues( $dbh, $temp_deptid, "qest", $est, "qpos", $qpos ) ;
				Depts_update_DeptVarsValues( $dbh, $temp_deptid, "qlimit", $qlimit, "qtexts", serialize( $qtexts ) ) ;
				Depts_update_DeptValue( $dbh, $temp_deptid, "queue", $queue ) ;
			}
		}
		else
		{
			Depts_update_DeptVarsValues( $dbh, $deptid, "qest", $est, "qpos", $qpos ) ;
			Depts_update_DeptVarsValues( $dbh, $deptid, "qlimit", $qlimit, "qtexts", serialize( $qtexts ) ) ;
			Depts_update_DeptValue( $dbh, $deptid, "queue", $queue ) ;
		}
		$deptinfo["queue"] = $queue ;
		$deptvars["qest"] = $est ; $deptvars["qpos"] = $qpos ; $deptvars["qlimit"] = $qlimit ;
	}
	if ( !isset( $deptvars["deptID"] ) ) { $deptvars = Array() ; $deptvars["deptID"] = $deptid ; $deptvars["qest"] = $est ; $deptvars["qpos"] = $qpos ; $deptvars["qlimit"] = 5 ; }

	// make hash for quick refrence
	$dept_hash = Array() ;
	for ( $c = 0; $c < count( $departments ); ++$c )
	{
		$department = $departments[$c] ;
		$dept_hash[$department["deptID"]] = $department["name"] ;
	}
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($deptinfo["lang"], "ln").".php" ) ;
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
		$("html, body").css({'background-color': '#<?php echo $bgcolor ?>'}) ;

		<?php if ( $action && !$error ): ?>
			do_alert(1, "Success") ;

			var queue_string = ( <?php echo $queue ?> ) ? " <span class=\"info_good\" style=\"padding: 2px;\">On</span> " : " <span class=\"info_error\" style=\"padding: 2px;\">Off</span> " ;
			<?php if ( $copy_all ): ?>
			$('*[id*=span_queue_]', parent.document).each(function() {
				$(this).html(queue_string) ;
			}) ;
			<?php else: ?>
			$('#span_queue_<?php echo $deptid ?>', parent.document).html(queue_string) ;
			<?php endif ; ?>
		<?php endif ; ?>

		<?php if ( isset( $deptinfo["deptID"] ) ): ?>
			<?php if ( $deptinfo["queue"] == 1 ): ?>
				toggle_queue(1) ;
				$('#queue_1').prop('checked', true) ; $('#qtype_1').prop('checked', true) ;
			<?php elseif ( $deptinfo["queue"] == 2 ): ?>
				toggle_queue(1) ;
				$('#queue_1').prop('checked', true) ; $('#qtype_2').prop('checked', true) ;
			<?php else: ?>
				toggle_queue(0) ;
				$('#queue_0').prop('checked', true) ;
			<?php endif ; ?>
		<?php else: ?>
			toggle_queue(0) ;
			$('#queue_0').prop('checked', true) ;
		<?php endif ; ?>

		<?php if ( isset( $deptvars["deptID"] ) ): ?>
			toggle_est(<?php echo $deptvars["qest"] ?>) ;
			toggle_qpos(<?php echo $deptvars["qpos"] ?>) ;
		<?php else: ?>
			toggle_est(0) ;
			toggle_qpos(0) ;
		<?php endif ; ?>

		<?php if ( isset( $deptinfo["deptID"] ) && ( $deptinfo["rtype"] == 3 ) ): ?>
			$('#div_radio_select').hide() ;
			toggle_queue(0) ;	
		<?php endif ; ?>
	});

	function toggle_queue( thevalue )
	{
		if( thevalue && <?php echo ( $deptinfo["rtype"] == 3 ) ? 0 : 1 ; ?> )
		{
			$('#div_queue_settings').show();
		}
		else
		{
			$('#div_queue_settings').hide();
		}
	}

	function toggle_est( thevalue )
	{
		if( thevalue )
		{
			$('#div_text_est').show() ;
			$('#est_1').prop('checked', true)
		}
		else
		{
			$('#div_text_est').hide() ;
			$('#est_0').prop('checked', true)
		}
	}

	function toggle_qpos( thevalue )
	{
		if( thevalue )
		{
			$('#div_text_qpos').show() ;
			$('#qpos_1').prop('checked', true)
		}
		else
		{
			$('#div_text_qpos').hide() ;
			$('#qpos_0').prop('checked', true)
		}
	}

	function switch_dept( theobject )
	{
		location.href = "reports_chat_queue.php?deptid="+theobject.value+"&jump="+jump+"&"+unixtime() ;
	}

	function do_submit()
	{
		$('#form_theform').submit() ;
	}
//-->
</script>
</head>
<body style="">

<div id="iframe_body" style="height: 390px; background: #<?php echo $bgcolor ?>;">
	<form method="POST" action="iframe_edit_5.php" id="form_theform">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="option" value="<?php echo $option ?>">
	<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
	<input type="hidden" name="bgcolor" value="<?php echo $bgcolor ?>">
	<div style="margin-top: 15px;" id="">
		<table cellspacing=0 cellpadding=0 border=0>
		<tr>
			<td>
				<?php if ( isset( $deptinfo["deptID"] ) ): ?>
				<div style="" id="div_radio_select">Place new chat requests in the "Waiting Queue" if all department operators are chatting at their <b><a href="ops.php?ftab=max" target="_parent">max concurrent chats</a></b>. &nbsp;
					<span class="info_good" style="cursor: pointer;" onclick="$('#queue_1').prop('checked', true);toggle_queue(1);"><input type="radio" name="queue" id="queue_1" value="1" onClick="toggle_queue(1)"> On</span>
					<span class="info_error" style="cursor: pointer;" onclick="$('#queue_0').prop('checked', true);toggle_queue(0);"><input type="radio" name="queue" id="queue_0" value="0" onClick="toggle_queue(0)"> Off</span>
				</div>
				<?php endif ; ?>
			</td>
		</tr>
		</table>
	</div>
	<div id="div_queue_settings" style="display: none; margin-top: 25px;">
		<div style="">
			<table cellspacing=0 cellpadding=0 border=0>
			<tr>
				<td><div class="tab_form_title">Behavior</div></td>
				<td style="padding-left: 10px;">
					<div style="">When the operator declines the first-in-line queued chat request:</div>
					<div style="margin-top: 5px;">
						<div><input type="radio" name="qtype" id="qtype_2" value="2"> route the chat request to the "Leave a Message".</div>
						<div style="margin-top: 5px;"><input type="radio" name="qtype" id="qtype_1" value="1" checked> place the chat request back in the "Waiting Queue" (first-in-line) until another operator is available.  if the chat request is declined by every available department operators, route the chat request to the "Leave a Message".</div>
					</div>
				</td>
			</tr>
			</table>
		</div>
		<div style="margin-top: 25px;">
			<table cellspacing=0 cellpadding=0 border=0>
			<tr>
				<td><div class="tab_form_title">Estimated Waiting Time</div></td>
				<td style="padding-left: 10px;">
					<div>
						<div class="info_good" style="float: left; width: 100px; padding: 3px; cursor: pointer;" onClick="$('#est_1').prop('checked', true);toggle_est(1);"><input type="radio" name="est" id="est_1" value="1" onClick="toggle_est(1)"> Display</div>
						<div class="info_error" style="float: left; margin-left: 10px; width: 100px; padding: 3px; cursor: pointer;"  onClick="$('#est_0').prop('checked', true);toggle_est(0);"><input type="radio" name="est" id="est_0" value="0" onClick="toggle_est(0)"> Off</div>
						<div style="clear: both;"></div>
					</div>
				</td>
			</tr>
			</table>
		</div>
		<div style="display: none; margin-top: 25px;" id="div_text_est">
			<table cellspacing=0 cellpadding=0 border=0>
			<tr>
				<td><div class="tab_form_title" style="background: #<?php echo $bgcolor ?>; border: 1px solid #<?php echo $bgcolor ?>;">&nbsp;</div></td>
				<td style="padding-left: 10px;">
					<div>Message to display: (example <i>"Estimated wait time is about" 3 "minutes"</i>)</div>
					<div style="margin-top: 5px;">
						<input type="text" name="CHAT_QUEUE_EST" id="CHAT_QUEUE_EST" size="30" maxlength="155" onKeyPress="return notags(event)" value="<?php echo ( !isset( $qtexts["CHAT_QUEUE_EST"] ) || !$qtexts["CHAT_QUEUE_EST"] ) ? "Estimated wait time is about" : $qtexts["CHAT_QUEUE_EST"] ; ?>"> &nbsp; <span style="font-size: 16px; font-weight: bold;">..</span> &nbsp; <input type="text" name="CHAT_QUEUE_EST_MIN" id="CHAT_QUEUE_EST_MIN" size="10" maxlength="45" onKeyPress="return notags(event)" value="<?php echo ( !isset( $qtexts["CHAT_QUEUE_EST_MIN"] ) || !$qtexts["CHAT_QUEUE_EST_MIN"] ) ? "minutes." : $qtexts["CHAT_QUEUE_EST_MIN"] ; ?>">
					</div>
					<div style="margin-top: 15px;">Estimated wait time based on the most recent <select id="qlimit" name="qlimit">
					<?php for ( $c = 2; $c <= 10; ++$c )
					{
						$selected = ( $c == $deptvars["qlimit"] ) ? "selected" : "" ;
						print "<option value=$c $selected>$c</option>" ;
					}
					?>
					</select> queued visitors that were <span class="info_box">successfully routed to an operator</span>.</div>
				</td>
			</tr>
			</table>
		</div>
		<div style="margin-top: 25px;">
			<table cellspacing=0 cellpadding=0 border=0>
			<tr>
				<td><div class="tab_form_title">Queue Position</div></td>
				<td style="padding-left: 10px;">
					<div>
						<div class="info_good" style="float: left; width: 100px; padding: 3px; cursor: pointer;" onClick="$('#qpos_1').prop('checked', true);toggle_qpos(1);"><input type="radio" name="qpos" id="qpos_1" value="1" onClick="toggle_qpos(1)"> Display</div>
						<div class="info_error" style="float: left; margin-left: 10px; width: 100px; padding: 3px; cursor: pointer;"  onClick="$('#qpos_0').prop('checked', true);toggle_qpos(0);"><input type="radio" name="qpos" id="qpos_0" value="0" onClick="toggle_qpos(0)"> Off</div>
						<div style="clear: both;"></div>
					</div>
				</td>
			</tr>
			</table>
		</div>
		<div style="display: none; margin-top: 25px;" id="div_text_qpos">
			<table cellspacing=0 cellpadding=0 border=0>
			<tr>
				<td><div class="tab_form_title" style="background: #<?php echo $bgcolor ?>; border: 1px solid #<?php echo $bgcolor ?>;">&nbsp;</div></td>
				<td style="padding-left: 10px;">
					<div>Message to display: (example <i>"Queue Position:" 3</i>)</div>
					<div style="margin-top: 5px;">
						<input type="text" name="CHAT_QUEUE_POS" id="CHAT_QUEUE_POS" size="15" maxlength="55" onKeyPress="return notags(event)" value="<?php echo ( !isset( $qtexts["CHAT_QUEUE_POS"] ) || !$qtexts["CHAT_QUEUE_POS"] ) ? "Queue Position: " : $qtexts["CHAT_QUEUE_POS"] ; ?>">
					</div>
				</td>
			</tr>
			</table>
		</div>
	</div>
	<?php if ( isset( $deptinfo["deptID"] ) && ( $deptinfo["rtype"] != 3 ) ): ?>
	<div style="margin-top: 25px;">
		<table cellspacing=0 cellpadding=0 border=0>
		<tr>
			<td><div class="tab_form_title" style="background: #<?php echo $bgcolor ?>; border: 1px solid #<?php echo $bgcolor ?>;">&nbsp;</div></td>
			<td style="padding-left: 10px;">
				<div>
					<?php if ( count( $departments ) > 1 ) : ?>
					<div style=""><input type="checkbox" id="copy_all" name="copy_all" value=1> copy this update to all departments</div>
					<?php endif ; ?>

					<div style="margin-top: 15px;"><input type="button" value="Update" class="btn" onClick="do_submit()"> &nbsp; &nbsp; <a href="JavaScript:void(0)" onClick="parent.do_options( <?php echo $option ?>, <?php echo $deptid ?> );">cancel</a></div>
				</div>
			</td>
		</tr>
		</table>
	</div>
	<?php elseif ( isset( $deptinfo["deptID"] ) && ( $deptinfo["rtype"] == 3 ) ): ?>
	<div style="margin-top: 25px;">
		<table cellspacing=0 cellpadding=0 border=0>
		<tr>
			<td><div class="tab_form_title" style="background: #<?php echo $bgcolor ?>; border: 1px solid #<?php echo $bgcolor ?>;">&nbsp;</div></td>
			<td style="padding-left: 10px;">
				<div>
					<div style="display: inline-block;" class="info_error">Department routing type is set to Simultaneous.  "Waiting Queue" is not available for Simultaneous routing type.</div>
				</div>
			</td>
		</tr>
		</table>
	</div>
	<?php endif ; ?>

	</form>
</div>

</body>
</html>