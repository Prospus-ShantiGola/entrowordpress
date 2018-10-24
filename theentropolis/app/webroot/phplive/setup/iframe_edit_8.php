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

	$copy_all = Util_Format_Sanatize( Util_Format_GetVar( "copy_all" ), "n" ) ;

	$departments = Depts_get_AllDepts( $dbh ) ;
	$auto_offline = ( isset( $VALS["AUTO_OFFLINE"] ) && $VALS["AUTO_OFFLINE"] ) ? unserialize( $VALS["AUTO_OFFLINE"] ) : Array() ;

	if ( $action === "update" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

		$offline_hours_onoff = Util_Format_Sanatize( Util_Format_GetVar( "offline_hours_onoff" ), "n" ) ;
		$offline_hour = Util_Format_Sanatize( Util_Format_GetVar( "offline_hour" ), "n" ) ;
		$offline_min = Util_Format_Sanatize( Util_Format_GetVar( "offline_min" ), "n" ) ;
		$offline_ampm = Util_Format_Sanatize( Util_Format_GetVar( "offline_ampm" ), "ln" ) ;
		$offline_duration = Util_Format_Sanatize( Util_Format_GetVar( "offline_duration" ), "n" ) ;
		$offline_rewind = 0 ;

		if ( $offline_hours_onoff )
		{
			if ( ( $offline_ampm == "pm" ) && ( $offline_hour < 12 ) ) { $offline_hour += 12 ; }
			else if ( ( $offline_ampm == "am" ) && ( $offline_hour == 12 ) ) { $offline_hour = 0 ; }
			$hour_max = $offline_hour + $offline_duration ;
			if ( $hour_max >= 24 ) { $offline_rewind = $hour_max - 24 ; }
			if ( $copy_all )
			{
				for( $c = 0; $c < count( $departments ); ++$c )
				{
					$temp_deptid = $departments[$c]["deptID"] ;
					$auto_offline[$temp_deptid] = "$offline_hour,$offline_min,$offline_duration,$offline_rewind" ;
				}
			}
			else { $auto_offline[$deptid] = "$offline_hour,$offline_min,$offline_duration,$offline_rewind" ; }
		}
		else
		{
			if ( $copy_all )
			{
				for( $c = 0; $c < count( $departments ); ++$c )
				{
					$temp_deptid = $departments[$c]["deptID"] ;
					if ( isset( $auto_offline[$temp_deptid] ) ) { unset( $auto_offline[$temp_deptid] ) ; }
				}
			}
			else { unset( $auto_offline[$deptid] ) ; }
		}
		$error = ( Util_Vals_WriteToFile( "AUTO_OFFLINE", serialize( $auto_offline ) ) ) ? "" : "Could not write to vals file." ;
	}

	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($deptinfo["lang"], "ln").".php" ) ;
	$deptname = $deptinfo["name"] ;

	$offline_hours_hour = 6 ; $offline_hours_min = 30 ; $offline_hours_ampm = "pm" ; $offline_hours_duration = 12 ;
	if ( isset( $auto_offline[$deptid] ) )
	{
		LIST( $offline_hour, $offline_min, $offline_duration ) = explode( ",", $auto_offline[$deptid] ) ;
		if ( $offline_hour >= 12 )
		{
			$offline_hours_ampm = "pm" ;
			if ( $offline_hour > 12 ) { $offline_hour -= 12 ; }
		}
		else { $offline_hours_ampm = "am" ; }
		if ( !$offline_hour ) { $offline_hour = 12 ; }
		$offline_hours_hour = $offline_hour ; $offline_hours_min = $offline_min ; $offline_hours_duration = $offline_duration ;
	}
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

		<?php if ( $offline_hours_onoff ): ?>
			<?php if ( $copy_all ): ?>
			$('*[id*=span_class_]', parent.document).each(function() {
				$(this).html( "<span class=\"info_good\" style=\"padding: 2px;\">On</span>" ) ;
			}) ;
			<?php else: ?>
			$('#span_class_<?php echo $deptid ?>', parent.document).html( "<span class=\"info_good\" style=\"padding: 2px;\">On</span>" ) ;
			<?php endif ; ?>
		<?php else: ?>
			<?php if ( $copy_all ): ?>
			$('*[id*=span_class_]', parent.document).each(function() {
				$(this).html( "<span class=\"info_error\" style=\"padding: 2px;\">Off</span>" ) ;
			}) ;
			<?php else: ?>
			$('#span_class_<?php echo $deptid ?>', parent.document).html( "<span class=\"info_error\" style=\"padding: 2px;\">Off</span>" ) ;
			<?php endif ; ?>
		<?php endif ; ?>

		<?php elseif ( $error ): ?>
		parent.do_alert( 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>

		<?php if ( $action === "hours" ): ?>setInterval(function(){ fetch_systime() ; }, 10000) ;<?php endif ; ?>
		<?php if ( isset( $auto_offline[$deptid] ) ): ?>
			$('#offline_hours_onoff_on').prop('checked', true) ;
			toggle_offline_hours( 1 ) ;
		<?php else: ?>
			$('#offline_hours_onoff_off').prop('checked', true) ;
			toggle_offline_hours( 0 ) ;
		<?php endif ; ?>
	});

	function fetch_systime()
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		$.ajax({
		type: "POST",
		url: "../ajax/setup_actions_itr.php",
		data: " action=systime&unique="+unique,
		success: function(data){
			eval( data ) ;

			if ( json_data.status )
				$('#span_system_time').html( json_data.systime ) ;
			else
				$('#span_system_time').html( json_data.error ) ;
		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Error loading requested page.  Please refresh the console and try again." ) ;
			$('#span_system_time').html( "systime error [e2]" ) ;
		} });
	}

	function do_submit_settings()
	{
		$('#form_settings').submit() ;
	}

	function toggle_offline_hours( theflag )
	{
		if ( theflag )
		{
			var offline_hour_select = <?php echo $offline_hours_hour ?> ;
			var offline_min_select = "<?php echo $offline_hours_min ?>" ;
			var offline_ampm_select = "<?php echo $offline_hours_ampm ?>" ;
			var offline_duration_select = <?php echo $offline_hours_duration ?> ;
			$('#offline_hour').attr("disabled", false) ; $("#offline_hour option[value='-']").remove() ; $('#offline_hour').val( offline_hour_select ) ;
			$("#offline_min option[value='-']").remove() ; $('#offline_min').val( offline_min_select ).attr("disabled", false) ;
			$("#offline_ampm option[value='-']").remove() ; $('#offline_ampm').val( offline_ampm_select ).attr("disabled", false) ;
			$("#offline_duration option[value='-']").remove() ; $('#offline_duration').val( offline_duration_select ).attr("disabled", false) ;
		}
		else
		{
			$('#offline_hour').attr("disabled", true) ; $("#offline_hour").append("<option value='-'></option>") ; $("#offline_hour").val("-") ;
			$("#offline_min").append("<option value='-'></option>") ; $("#offline_min").val("-").attr("disabled", true) ;
			$("#offline_ampm").append("<option value='-'></option>") ; $("#offline_ampm").val("-").attr("disabled", true) ;
			$("#offline_duration").append("<option value='-'></option>") ; $("#offline_duration").val("-").attr("disabled", true) ;
		}
	}
//-->
</script>
</head>
<body style="overflow: hidden;">

<div id="iframe_body" style="height: 390px; overflow: hidden; <?php echo ( $bgcolor ) ? "background: #$bgcolor;" : "" ?>">
	<form action="iframe_edit_8.php" id="form_settings" method="POST" accept-charset="<?php echo $LANG["CHARSET"] ?>">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
	<input type="hidden" name="option" value="<?php echo $option ?>">
	<input type="hidden" name="bgcolor" value="<?php echo $bgcolor ?>">
	<div style="">
		<div style="">Automatically set department to go OFFLINE at a specific time.  The online operators will be automatically logged off and to limit accidental online status during offline hours, the system will also prevent the operator from going online during the "Offline Duration".</div>
		<div class="info_box" style="margin-top: 10px;"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> This feature is mainly to prevent an operator from leaving the console open during offline hours.  It's to ensure a global offline and logout time.</div>

		<div style="padding-top: 15px; padding-bottom: 15px;">
			<div class="info_info">
				<table cellspacing=0 cellpadding=2 border=0>
				<tr>
					<td valign="top">
						<div style="font-size: 14px; font-weight: bold; text-align: center;">Automatic Offline</div>
						<div style="margin-top: 10px;">
							<div class="info_error" style="float: left; width: 60px; padding: 3px; cursor: pointer;" onClick="$('#offline_hours_onoff_off').prop('checked',true);toggle_offline_hours(0);"><input type="radio" name="offline_hours_onoff" id="offline_hours_onoff_off" value=0 onClick=""> Off</div>
							<div class="info_good" style="float: left; margin-left: 10px; width: 60px; padding: 3px; cursor: pointer;" onClick="$('#offline_hours_onoff_on').prop('checked',true);toggle_offline_hours(1);"><input type="radio" name="offline_hours_onoff" id="offline_hours_onoff_on" value=1> On</div>
							<div style="clear: both;"></div>
						</div>
					</td>
					<td style="padding-left: 15px;">
						<div id="auto_offline_settings">
						<table cellspacing=0 cellpadding=2 border=0>
						<tr>
							<td>Offline Time</td>
							<td>
								<table cellspacing=0 cellpadding=0 border=0>
								<tr>
									<td>
										<select name="offline_hour" id="offline_hour">
										<?php for( $c = 1; $c <= 12; ++$c ) { print "<option value='$c'>$c</option>" ; } ?>
										</select>
									</td><td> : </td>
									<td>
										<select name="offline_min" id="offline_min">
										<?php $mins = Array( "00", "15", "30", "45" ) ; for( $c = 0; $c < count( $mins ); ++$c ) { $c_out = $mins[$c] ; print "<option value='$c_out'>$c_out</option>" ; } ?>
										</select>
									</td><td> &nbsp; </td>
									<td>
										<select name="offline_ampm" id="offline_ampm">
										<option value="pm">pm</option><option value="am">am</option>
										</select> everyday
									</td><td> &nbsp; </td>
									<td style="padding-left: 25px;">
										<div class="info_neutral" style="display: inline-block;"><img src="../pics/icons/clock.png" width="16" height="16" border="0" alt=""> <a href="interface.php?jump=time" target="_parent">current system time</a> is <span id="span_system_time" style="color: #3A89D1; font-weight: bold;"><?php echo date( "M j ($VARS_TIMEFORMAT)", time() ) ; ?></span></div>
									</td>
								</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>Offline Duration</td>
							<td>
								<select name="offline_duration" id="offline_duration">
								<?php for( $c = 2; $c <= 17; ++$c ) { print "<option value='$c'>$c</option>" ; } ?>
								</select> hours
							</td>
						</tr>
						</table>
						</div>
					</td>
				</tr>
				</table>
			</div>
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