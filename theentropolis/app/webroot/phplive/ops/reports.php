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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;

	$now = time() ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$console = Util_Format_Sanatize( Util_Format_GetVar( "console" ), "n" ) ;
	$menu = Util_Format_Sanatize( Util_Format_GetVar( "menu" ), "ln" ) ;
	$wp = Util_Format_Sanatize( Util_Format_GetVar( "wp" ), "n" ) ;
	$auto = Util_Format_Sanatize( Util_Format_GetVar( "auto" ), "n" ) ;
	$menu = ( $menu ) ? $menu : "reports" ;
	$error = "" ; $theme = "default" ;

	$m = Util_Format_Sanatize( Util_Format_GetVar( "m" ), "n" ) ;
	$d = Util_Format_Sanatize( Util_Format_GetVar( "d" ), "n" ) ;
	$y = Util_Format_Sanatize( Util_Format_GetVar( "y" ), "n" ) ; $y_ = $y ; // query indication flag
	if ( !$m ) { $m = date( "m", $now ) ; }
	if ( !$d ) { $d = date( "j", $now ) ; }
	if ( !$y ) { $y = date( "Y", $now ) ; }

	$today = mktime( 0, 0, 1, $m, $d, $y ) ;
	$stat_start = mktime( 0, 0, 1, $m, 1, $y ) ;
	$stat_end = mktime( 23, 59, 59, $m, date('t', $stat_start), $y ) ;
	$stat_end_day = date( "j", $stat_end ) ;

	$departments = Depts_get_AllDepts( $dbh ) ;
	$operators = Ops_get_AllOps( $dbh ) ;
	$rating_none = Util_Functions_Stars( "..", 0 ) ;

	$requests_timespan = Chat_get_ext_RequestsRangeHash( $dbh, $stat_start, $stat_end, $operators, $opinfo["opID"] ) ;
	$month_stats = Array() ;
	$month_total_requests = $month_total_taken = $month_total_declined = $month_total_message = $month_total_initiated = 0 ;
	$month_max = 0 ;
	foreach ( $requests_timespan as $sdate => $deptop )
	{
		if ( isset( $deptop["ops"] ) )
		{
			foreach ( $deptop["ops"] as $key => $value )
			{
				if ( !isset( $month_stats[$sdate] ) )
				{
					$month_stats[$sdate] = Array() ;
					$month_stats[$sdate]["requests"] = $month_stats[$sdate]["taken"] = $month_stats[$sdate]["declined"] = $month_stats[$sdate]["message"] = $month_stats[$sdate]["initiated"] = 0 ;
				}

				$month_stats[$sdate]["requests"] += $value["requests"] ;
				$month_stats[$sdate]["taken"] += $value["taken"] ;
				$month_stats[$sdate]["declined"] += $value["declined"] ;
				$month_stats[$sdate]["message"] += $value["message"] ;
				$month_stats[$sdate]["initiated"] += $value["initiated"] ;

				if ( $sdate )
				{
					$month_total_requests += $value["requests"] ;
					$month_total_taken += $value["taken"] ;
					$month_total_declined += $value["declined"] ;
					$month_total_initiated += $value["initiated"] ;
					$month_total_message += $value["message"] ;
				}
			}
		}

		if ( isset( $month_stats[$sdate]["requests"] ) && ( $month_stats[$sdate]["requests"] > $month_max ) && $sdate )
			$month_max = $month_stats[$sdate]["requests"] ;
	}

	$opvars = Ops_get_OpVars( $dbh, $opinfo["opID"] ) ;
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
<script data-cfasync="false" type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	"use strict"
	var stat_depts = new Object ;
	var stat_ops = new Object ;
	var stat_start = <?php echo $stat_start ?> ;
	var global_stat_time = 0 ;
	var global_div = "ops" ;
	var global_timeline_unix = 0 ;
	var global_deptid = 0 ;
	var global_total = 0 ;
	var global_overall_c ;
	var global_timeline_c ;
	var global_accepted = 0 ;
	var wp = ( ( typeof( window.external ) != "undefined" ) && ('wp_total_visitors' in window.external) ) ? 1 : 0 ;

	var did_click = 0 ; // if the specific date is clicked, an ajax load flag

	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		init_menu() ;
		toggle_menu_op( "reports" ) ;

		<?php if ( $y_ && $console ): ?>
			var scroll_to_top = $('#div_body_container').offset().top + 55 ;
			$('html, body').animate( {
				scrollTop: scroll_to_top
			}, 500) ;
		<?php endif ; ?>

		reset_date(did_click) ;
		populate_timeline( 0, 0 ) ;
	});

	function close_iframe()
	{
		$('#iframe_wrapper').hide() ;
	}

	function reset_date( thedid_click )
	{
		select_date( 0, "<?php echo date( "M j, Y", $stat_start ) ?> - <?php echo date( "M j, Y", $stat_end ) ?>", thedid_click ) ;
	}

	function select_date( theunix, thedayexpand, thec, thedid_click )
	{
		var stat_total_requests = 0, stat_total_taken = 0, stat_total_declined = 0, stat_total_message = 0, stat_total_initiated = 0 ;

		if ( !did_click && thedid_click ) { did_click = 1 ; }
		global_timeline_unix = theunix ;
		global_timeline_c = undeefined ;
		$('#stat_day_expand').html( thedayexpand ) ;

		$( '#div_timeline' ).find('*').each( function(){
			var div_name = this.id ;
			if ( div_name.indexOf("bar_v_overall_") != -1 )
				$(this).css({'border': '1px solid #4FD25B'}) ;
		} );

		if ( did_click ) { populate_timeline( theunix, 0 ) ; }
		if ( theunix )
		{
			if ( global_overall_c == thec )
			{
				global_overall_c = undeefined ;
				reset_date(did_click) ;
				if ( global_div == "timeline" )
				{
					global_stat_time = 0 ; global_div = undeefined ;
					show_div('timeline') ;
				}
				else if ( global_div == "urls" )
				{
					global_stat_time = 0 ; global_div = undeefined ;
					show_div('urls') ;
				}
				else
				{
					if ( global_div != "info" ) { $('#reports_'+global_div).hide().fadeIn("fast") ; }
				}
			}
			else
			{
				global_overall_c = thec ;
				if ( global_div != "info" ) { $('#reports_'+global_div).hide() ; }

				if ( global_div != "info" ) { $('#reports_'+global_div).fadeIn("fast") ; }
				if ( typeof( thec ) != "undefined" ) { $('#bar_v_overall_'+thec).css({'border': '1px solid #235D28'}) ; }
			}
		}
		else
		{
			var depts = new Object ;
			var ops = new Object ;
		}
	}

	function populate_timeline( theunix, theopid )
	{
		var json_data = new Object ;
		if ( typeof( theunix ) == "undefined" ) { theunix = global_timeline_unix ; }
		var stat_start = <?php echo $stat_start ?> ;
		var stat_end = <?php echo $stat_end ?> ;

		$('#reports_timeline_body').empty().html( "<img src=\"../pics/loading_fb.gif\" width=\"16\" height=\"11\" border=\"0\" alt=\"\">" ) ;
		$.ajax({
			type: "POST",
			url: "../ajax/op_actions_reports.php",
			data: "action=fetch_request_timeline&deptid="+global_deptid+"&opid="+theopid+"&sdate="+theunix+"&stat_start="+stat_start+"&stat_end="+stat_end+"&"+unixtime(),
			success: function(data){
				eval( data ) ;

				var string_hours = "<table cellspacing=0 cellpadding=0 border=0 style=\"height: 100px; width: 100%;\"><tr>" ;
				var hour, h1, meter, tooltip_display, string_cursor, string_js ;
				var hour_max = json_data.hour_max ;
				var hour_total_overall = json_data.total_overall ;
				var hour_total_accepted = json_data.total_accepted ;

				global_stat_time = theunix ;
				update_timeline_string( theunix, hour_total_overall, 0, hour_total_accepted ) ;
				global_total = hour_total_overall ;
				global_accepted = hour_total_accepted ;

				for ( var c = 0; c < json_data.timeline.length; ++c )
				{
					hour = json_data.timeline[c] ;
					tooltip_display = hour["hour_"]+":00"+hour["ampm"]+" - "+hour["hour_"]+":59"+hour["ampm"]+" ("+hour["total"]+" chat requests)" ;

					if ( !parseInt( hour["total"] ) )
					{
						h1 = "0px" ;
						meter = "meter_v_clear.gif" ;
						string_cursor = string_js = tooltip_display = "" ;
					}
					else
					{
						h1 = Math.round( ( hour["total"]/hour_max ) * 100 ) + "px" ;
						meter = "meter_v_teal.gif" ;
						string_cursor = " cursor: pointer;" ;
						string_js = "onClick=\"update_timeline_string('"+hour["hour_display"]+"', "+hour["total"]+", "+c+", "+hour["accepted"]+")\"" ;
					}

					string_hours += "<td valign=\"bottom\" width=\"2%\" style=\"height: 100px;\"><div id=\"bar_v_requests_"+c+"\" title=\""+tooltip_display+"\" alt=\""+tooltip_display+"\" style=\"height: "+h1+"; background: url( ../pics/meters/"+meter+" ) repeat; border: 1px solid #66C6E5; border-top-left-radius: 5px 5px; -moz-border-radius-topleft: 5px 5px; border-top-right-radius: 5px 5px; -moz-border-radius-topright: 5px 5px;"+string_cursor+"\" "+string_js+"></div></td><td><img src=\"../pics/space.gif\" width=\"5\" height=1></td>" ;
				}
				string_hours += "</tr><tr>" ;

				for ( var c = 0; c < json_data.timeline.length; ++c )
				{
					hour = json_data.timeline[c] ;
					tooltip_display = hour["total"]+" requests ("+hour["hour_"]+":00"+hour["ampm"]+" - "+hour["hour_"]+":59"+hour["ampm"]+")" ;
					var ampm = ( hour["ampm"] != "pm" ) ? "" : "pm" ;

					string_hours += "<td align=\"center\"><div id=\"requests_bg_day\" class=\"page_report\" style=\"margin: 0px; font-size: 10px; font-weight: bold;\" title=\""+tooltip_display+"\" id=\""+tooltip_display+"\" onClick=\"update_timeline_string('"+hour["hour_display"]+"', "+hour["total"]+", "+c+", "+hour["accepted"]+")\">"+hour["hour_"]+ampm+"</div></td><td><img src=\"../pics/space.gif\" width=\"5\" height=1></td>" ;
				}
				string_hours += "</tr><tr>" ;

				for ( var c = 0; c < json_data.timeline.length; ++c )
				{
					hour = json_data.timeline[c] ;

					string_hours += "<td align=\"center\"><div id=\"requests_bg_total\" class=\"info_clear\" style=\"margin: 0px; font-size: 10px; font-weight: bold;\">"+hour["total"]+"</div></td><td><img src=\"../pics/space.gif\" width=\"5\" height=1></td>" ;
				}

				string_hours += "</tr></table>" ;
				$('#reports_timeline_body').empty().html( string_hours ) ;
			}
		});
	}

	function update_timeline_string( theunixtime, thetotal, thec, theaccepted )
	{
		var day_string = $('#stat_day_expand').html() ;
		var percent = ( parseInt( thetotal ) ) ? Math.round( ( parseInt(theaccepted)/parseInt(thetotal) ) * 100 ) : 0 ;
		var percent_display = ( percent ) ? "("+percent+"%)" : "" ;

		$( '#reports_timeline_body' ).find('*').each( function(){
			var div_name = this.id ;
			if ( div_name.indexOf("bar_v_requests_") != -1 )
				$(this).css({'border': '1px solid #66C6E5'}) ;
		} );

		if ( typeof( theunixtime ) != "string" )
			$('#stat_timeline_expand').html( "<span class=\"info_neutral\" style=\"font-weight: bold;\"><?php echo ( !$VARS_24H ) ? "12:00am - 11:59pm" : "0:00 - 23:59" ; ?></span> &nbsp; "+thetotal+" total chat requests <span class=\"info_good\">"+theaccepted+"</span> accepted "+percent_display ) ;
		else
		{
			if ( global_timeline_c == thec )
			{
				global_timeline_c = undeefined ;
				update_timeline_string( 0, global_total, 0, global_accepted ) ;
			}
			else
			{
				global_timeline_c = thec ;
				var day_string_output = theunixtime.replace( "%span%", "<span style=\"font-weight: bold;\" class=\"info_neutral\">" ) ;
				day_string_output = day_string_output.replace( "%span_%", " &nbsp; <span style=\"font-size: 12px; font-weight: normal;\"><a href=\"JavaScript:void(0)\" onClick=\"do_reset()\">reset</a></span> &nbsp;</span>" ) ;
				$('#stat_timeline_expand').html( day_string_output+" &nbsp; "+thetotal+" total chat requests <span class=\"info_good\">"+theaccepted+"</span> accepted "+percent_display ) ;

				if ( typeof( thec ) != "undefined" ) { $('#bar_v_requests_'+thec).css({'border': '1px solid #235D28'}) ; }
			}
		}
	}

	function do_reset()
	{
		global_timeline_c = undeefined ;
		update_timeline_string( 0, global_total, 0, global_accepted ) ;
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ); ?>

		<table cellspacing=0 cellpadding=0 border=0 width="100%" style="margin-top: 25px;">
		<tr>
			<td><div class="td_dept_header" style="text-align: center;">Timeline</div></td>
			<td width="80"><div class="td_dept_header" style="text-align: center;">Requests</div></td>
			<td><div class="td_dept_header" style="text-align: center;">Accepted</div></td>
			<td width="60"><div class="td_dept_header" style="text-align: center;">Declined</div></td>
			<td nowrap><div class="td_dept_header" style="text-align: center;">Operator Chat Invite</div></td>
		</tr>
		<tr>
			<td class="td_dept_td" align="center"><?php include_once( "./inc_select_cal.php" ) ; ?></td>
			<td class="td_dept_td" align="center"><?php echo $month_total_requests ?></td>
			<td class="td_dept_td" nowrap align="center"><?php echo $month_total_taken ?></td>
			<td class="td_dept_td" align="center"><?php echo $month_total_declined ?></td>
			<td class="td_dept_td" align="center"><?php echo $month_total_initiated ?></td>
		</tr>
		</table>

		<div style="margin-top: 25px; width: 100%;" id="div_timeline">
			<table cellspacing=0 cellpadding=0 border=0 style="height: 100px; width: 100%;">
			<tr>
				<?php
					$tooltips = Array() ; $stat_day_totals = Array() ;
					for ( $c = 1; $c <= $stat_end_day; ++$c )
					{
						$stat_day = mktime( 0, 0, 1, $m, $c, $y ) ;
						$stat_day_expand = date( "l, M j, Y", $stat_day ) ;

						$h1 = "0px" ; $meter = "meter_v_green.gif" ;
						$tooltip = "$stat_day_expand" ;
						$tooltips[$stat_day] = $tooltip ;
						$tooltip_display = "" ;
						if ( isset( $month_stats[$stat_day] ) )
						{
							$stat_day_totals[$c] = $month_stats[$stat_day]["requests"] ;
							$tooltip_display = "$stat_day_expand" ;
							if ( $month_max )
								$h1 = round( ( $month_stats[$stat_day]["requests"]/$month_max ) * 100 ) . "px" ;
						}
						else if ( ( $c == $stat_end_day ) && !$month_max )
						{
							$stat_day_totals[$c] = 0 ;
							$h1 = "0px" ;
							$meter = "meter_v_clear.gif" ;
						}
						else
							$stat_day_totals[$c] = 0 ;

						print "
							<td valign=\"bottom\" width=\"2%\" style=\"height: 100px;\"><div id=\"bar_v_overall_$c\" title=\"$tooltip_display\" alt=\"$tooltip_display\" style=\"height: $h1; background: url( ../pics/meters/$meter ) repeat-y; border: 1px solid #4FD25B; border-top-left-radius: 5px 5px; -moz-border-radius-topleft: 5px 5px; border-top-right-radius: 5px 5px; -moz-border-radius-topright: 5px 5px; cursor: pointer;\" OnClick=\"select_date( $stat_day, '$stat_day_expand', $c, 1 );\"></div></td>
							<td><img src=\"../pics/space.gif\" width=\"5\" height=1 border=0></td>
						" ;
					}
				?>
			</tr>
			<tr>
				<?php
					for ( $c = 1; $c <= $stat_end_day; ++$c )
					{
						$stat_day = mktime( 0, 0, 1, $m, $c, $y ) ;
						$stat_day_expand = date( "l, M j, Y", $stat_day ) ;
						print "
							<td align=\"center\"><div id=\"requests_bg_day\" class=\"page_report\" style=\"min-width: 12px; margin: 0px; font-size: 10px; font-weight: bold;\" title=\"$tooltips[$stat_day]\" id=\"$tooltips[$stat_day]\" OnClick=\"select_date( $stat_day, '$stat_day_expand', $c, 1 );\">$c</div></td>
							<td><img src=\"../pics/space.gif\" width=\"5\" height=1 border=0></td>
						" ;
					}
				?>
			</tr>
			<tr>
				<?php
					for ( $c = 1; $c <= $stat_end_day; ++$c )
					{
						$stat_day = mktime( 0, 0, 1, $m, $c, $y ) ;
						$stat_day_expand = date( "l, M j, Y", $stat_day ) ;
						$total = $stat_day_totals[$c] ;
						if ( $total > 999 ) { $total = "+" ; }
						print "
							<td align=\"center\"><div id=\"requests_bg_total_$c\" class=\"info_clear\" style=\"margin: 0px; font-size: 10px; font-weight: bold;\">$total</div></td>
							<td><img src=\"../pics/space.gif\" width=\"5\" height=1 border=0></td>
						" ;
					}
				?>
			</tr>
			</table>
		</div>

		<div id="reports_timeline" style="margin-top: 15px; height: 190px;">
			<div>
				<img src="../pics/icons/calenar_big.png" width="48" height="48" border="0" alt=""> <span id="overview_date_title"><span id="stat_day_expand" class="info_blue" style="display: inline-block;"></span></span>
				&nbsp; <span id="overview_date_timeline" style="font-weight: normal;"><span id="stat_timeline_expand"></span></span>
			</div>
			<div style="">
				<div id="reports_timeline_body" style="margin-top: 15px;"></div>
			</div>
		</div>

<?php include_once( "./inc_footer.php" ); ?>
