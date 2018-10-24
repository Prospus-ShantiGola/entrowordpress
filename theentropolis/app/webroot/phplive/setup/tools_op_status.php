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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$error = "" ;
	$traffic = 1 ;
	$theme = "default" ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$sort_by = Util_Format_Sanatize( Util_Format_GetVar( "sort_by" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;

	if ( !isset( $CONF['foot_log'] ) ) { $CONF['foot_log'] = "on" ; }
	if ( !isset( $CONF["icon_check"] ) ) { $CONF["icon_check"] = "on" ; }

	if ( $action == "fetch_ops" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_itr.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove_itr.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_itr.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/remove_itr.php" ) ;
		if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
		else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }

		Footprints_remove_itr_Expired_U( $dbh ) ;
		Chat_remove_itr_ExpiredOp2OpRequests( $dbh ) ;
		Ops_update_itr_IdleOps( $dbh ) ;
		Chat_remove_itr_OldRequests( $dbh ) ;
		$total_visitors = ( $traffic ) ? Footprints_get_itr_TotalFootprints_U( $dbh ) : -1 ;

		$dept_ops = Array() ;
		if ( $deptid )
		{
			$query = "SELECT opID FROM p_dept_ops WHERE deptID = $deptid" ;
			database_mysql_query( $dbh, $query ) ;
			while( $data = database_mysql_fetchrow( $dbh ) )
			{
				$opid = $data["opID"] ;
				$dept_ops[$opid] = 1 ;
			}
		}

		$operators = Array() ;
		if ( $sort_by == "status" )
			$query = "SELECT p_operators.*, COUNT(p_requests.requestID) AS total FROM p_operators LEFT JOIN p_requests ON p_operators.opID = p_requests.opID GROUP BY p_operators.opID ORDER BY status DESC, name ASC" ;
		else if ( $sort_by == "chats" )
			$query = "SELECT p_operators.*, COUNT(p_requests.requestID) AS total FROM p_operators LEFT JOIN p_requests ON p_operators.opID = p_requests.opID GROUP BY p_operators.opID ORDER BY total DESC, name ASC" ;
		else
			$query = "SELECT p_operators.*, COUNT(p_requests.requestID) AS total FROM p_operators LEFT JOIN p_requests ON p_operators.opID = p_requests.opID GROUP BY p_operators.opID ORDER BY name ASC" ;
		database_mysql_query( $dbh, $query ) ;

		while ( $data = database_mysql_fetchrow( $dbh ) )
			$operators[] = $data ;

		$json_data = "json_data = { \"status\": 1, \"tv\": $total_visitors, \"ops\": [  " ;
		for ( $c = 0; $c < count( $operators ); ++$c )
		{
			$operator = $operators[$c] ;

			$opid = $operator["opID"] ;
			$login = $operator["login"] ;
			$name = Util_Format_ConvertQuotes( $operator["name"] ) ;
			$status = ( $operator["status"] ) ? 1 : 0 ;
			$mapp_status = ( $operator["mapp"] && $operator["status"] ) ? 1 : 0 ;
			$lastactive = ( $operator["lastactive"] ) ? date( "M j, Y $VARS_TIMEFORMAT", $operator["lastactive"] ) : "" ;

			$profile_image = Util_Upload_GetLogo( "profile", $operator["opID"] ) ;
			$requests = $operator["total"] ;
			$rating = $operator["rating"] ;
			$ces = $operator["ces"] ;

			if ( !$deptid || ( $deptid && isset( $dept_ops[$opid] ) ) )
			{
				$json_data .= "{ \"opid\": $opid, \"login\": \"$login\", \"name\": \"$name\", \"status\": $status, \"mapp\": $mapp_status, \"lastactive\": \"$lastactive\", \"profile_image\": \"$profile_image\", \"requests\": $requests, \"ces\": \"$ces\", \"rating\": $rating }," ;
			}
		}
		$json_data = substr_replace( $json_data, "", -1 ) ;
		$json_data .= "	] };" ;

		if ( isset( $dbh ) && isset( $dbh['con'] ) )
			database_mysql_close( $dbh ) ;

		$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
		$json_data = preg_replace( "/\t/", "", $json_data ) ;
		print $json_data ; exit ;
	}
	$departments = Depts_get_AllDepts( $dbh ) ;
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> Online Status Monitor </title>

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

<script data-cfasync="false" type="text/javascript">
<!--
	var newwin ;
	var refresh_counter = 25 ;
	var si_refresh, st_rd ;
	var sort_by = "<?php echo $sort_by ?>" ;
	var deptid = <?php echo $deptid ?> ;

	var stars = new Object ;
	stars[5] = "<?php echo Util_Functions_Stars( "..", 5 ) ; ?>" ;
	stars[4] = "<?php echo Util_Functions_Stars( "..", 4 ) ; ?>" ;
	stars[3] = "<?php echo Util_Functions_Stars( "..", 3 ) ; ?>" ;
	stars[2] = "<?php echo Util_Functions_Stars( "..", 2 ) ; ?>" ;
	stars[1] = "<?php echo Util_Functions_Stars( "..", 1 ) ; ?>" ;
	stars[0] = "<?php echo Util_Functions_Stars( "..", 0 ) ; ?>" ;

	$(document).ready(function()
	{
		$("body").css({'background': '#F1F1F1'}) ;
		//$('#table_trs tr:nth-child(2n+3)').addClass('td_dept_td2') ;

		fetch_ops() ;
		init_timer() ;
	});
	$(window).resize(function() { });

	function init_timer()
	{
		var refresh_counter_temp = refresh_counter ;
		si_refresh = setInterval(function(){
			if ( refresh_counter_temp <= 0 )
			{
				fetch_ops() ;
				refresh_counter_temp = refresh_counter ;
			}
			else
			{
				$('#refresh_counter').html( pad( refresh_counter_temp, 2 ) ) ;
				--refresh_counter_temp ;
			}
		}, 1000) ;
	}

	function open_window( theurl )
	{
		window.open( theurl, "PHP Live! Setup", "scrollbars=yes,menubar=yes,titlebar=1,toolbar=1,resizable=1,location=yes,status=1" ) ;
	}

	function open_transcript( theces, theopid )
	{
		var url = "../ops/op_trans_view.php?ces="+theces+"&id="+theopid+"&auth=setup&"+unixtime() ;
		
		newwin = window.open( url, theces, "scrollbars=yes,menubar=no,resizable=1,location=no,width=<?php echo $VARS_CHAT_WIDTH+100 ?>,height=<?php echo $VARS_CHAT_HEIGHT+50 ?>,status=0" ) ;
		if ( newwin )
			newwin.focus() ;
	}

	function remote_disconnect( theopid, thelogin )
	{
		if ( confirm( "Remote disconnect operator console ("+thelogin+")?" ) )
		{
			var unique = unixtime() ;
			var json_data = new Object ;

			clearInterval( si_refresh ) ;
			$('#op_login').html( thelogin ) ;
			$('#remote_disconnect_notice').show() ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "action=remote_disconnect&opid="+theopid+"&"+unixtime(),
				success: function(data){
					eval( data ) ;

					if ( json_data.status )
						check_op_status( theopid ) ;
					else
					{
						$('#remote_disconnect_notice').hide() ;
						do_alert( 0, "Could not remote disconnect console.  Please try again." ) ;
					}
				}
			});
		}
	}

	function check_op_status( theopid )
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		if ( typeof( st_rd ) != "undefined" ) { clearTimeout( st_rd ) ; }

		$.ajax({
		type: "POST",
		url: "../wapis/status_op.php",
		data: "opid="+theopid+"&jkey=<?php echo md5( $CONF['API_KEY'] ) ?>&"+unique,
		success: function(data){
			eval( data ) ;

			if ( !parseInt( json_data.status ) )
			{
				if ( window.opener != null && !window.opener.closed )
					window.opener.location.href = 'index.php' ;

				location.href = 'tools_op_status.php' ;
			}
			else
				st_rd = setTimeout( function(){ check_op_status( theopid ) ; }, 2000 ) ;
		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Lost connection to server.  Please refresh the page and try again." ) ;
		} });
	}

	function fetch_ops()
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		$('#image_loading').show() ;

		$.ajax({
		type: "POST",
		url: "tools_op_status.php",
		data: "action=fetch_ops&sort_by="+sort_by+"&deptid="+deptid+"&"+unique,
		success: function(data){
			eval( data ) ;

			if ( json_data.status )
			{
				setTimeout(function(){ $('#image_loading').hide() ; }, 1000) ;

				var operator ;
				var status, status_img, status_text, status_bulb, tr_style, cur_style, js, mapp_online_icon, lastactive, rating, rating_string, op_td, op_tr ;

				var table_output = "" ;
				for ( var c = 0; c < json_data.ops.length; ++c )
				{
					operator = json_data.ops[c] ;

					status = ( operator["status"] ) ? "<b>Online</b>" : "Offline" ;
					status_text = ( operator["status"] ) ? "online" : "offline" ;
					status_bulb = ( operator["status"] ) ? "bulb.png" : "bulb_off.png" ;
					status_img = "<img src=\"../pics/icons/"+status_bulb+"\" width=\"16\" height=\"16\" border=\"0\" alt=\""+status_text+"\" title=\""+status_text+"\">" ;
					tr_style = ( operator["status"] ) ? "background: #AFFF9F;" : "" ;
					cur_style = ( operator["status"] ) ? "cursor: pointer" : "" ;
					js = ( operator["status"] ) ? "onClick=\"remote_disconnect("+operator["opid"]+", '"+operator["login"]+"')\"" : "" ;
					mapp_online_icon = ( operator["mapp"] && operator["status"] ) ? " &nbsp; <img src=\"../pics/icons/mobile.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"logged in on mobile\" title=\"logged in on mobile\" style=\"cursor: help;\">" : "" ;

					lastactive = operator["lastactive"] ;

					rating = stars[operator["rating"]] ;
					rating_string = ( operator["ces"] ) ? "<div>"+rating+"</div><div style=\"margin-top: 5px; font-size: 10px; cursor: pointer;\" class=\"info_neutral\" onClick=\"open_transcript('"+operator["ces"]+"', "+operator['opid']+")\">Chat ID: "+operator["ces"]+"</div>" : rating ;

					var op_td_check = encodeURIComponent( operator["name"]+","+operator["status"]+","+operator["requests"]+","+operator["ces"]+","+operator["rating"] ) ;
					op_td = "<td class=\"td_dept_td\" width=\"180\"><table cellspacing=0 cellpadding-0 border=0><tr><td><img src=\""+operator["profile_image"]+"\" width=\"35\" height=\"35\" border=\"0\" alt=\"\" style=\"border: 1px solid #DFDFDF;\" class=\"round\"></td><td style=\"padding-left: 5px;\">"+operator["name"]+"</td></tr></table></td><td class=\"td_dept_td\" width=\"50\" style=\""+cur_style+"\" nowrap "+js+">"+status_img+mapp_online_icon+"</td><td class=\"td_dept_td\" width=\"30\"><a href=\"JavaScript:void(0)\" onClick=\"open_window('reports_chat_active.php')\">"+operator["requests"]+"</a></td><td class=\"td_dept_td\">"+rating_string+"<div id=\"td_check_string_"+operator["opid"]+"\" style=\"display: none;\">"+op_td_check+"</div></td>" ;
					table_output += "<tr style=\""+tr_style+"\" id=\"tr_"+operator["opid"]+"\">"+op_td+"</tr>" ;
				}

				$('#table_tbody').empty().html( table_output ) ;
				if ( json_data["tv"] == -1 )
				{
					if ( $('#span_total_visitors').html().length < 5 ) { $('#span_total_visitors').html( "<a href=\"JavaScript:void(0)\" onClick=\"open_window('reports_traffic.php?jump=settings')\">Switch On the Chat Icon Status Check to enable the traffic counter.</a>" ) ; }
				}
				else if ( json_data["tv"] != parseInt( $('#span_total_visitors').html() ) ) { $('#span_total_visitors').html( json_data["tv"] ) ; }
			}
			else
			{
				clearInterval( si_refresh ) ;
				do_alert_div( "..", 0, "Error processing request.  Please try again." ) ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			clearInterval( si_refresh ) ;
			do_alert_div( "..", 0, "Request error.  Please refresh the console and try again." ) ;
		} });
	}

	function switch_sort( thesort )
	{
		sort_by = thesort ;

		clearInterval( si_refresh ) ;
		init_timer() ;
		fetch_ops() ;
	}

	function switch_dept( thedeptid )
	{
		deptid = thedeptid ;

		clearInterval( si_refresh ) ;
		init_timer() ;
		fetch_ops() ;
	}
//-->
</script>
</head>
<body style="">

<div id="ops_list" style="padding: 10px; padding-bottom: 65px;">
	<div id="div_alert" style="display: none; margin-bottom: 15px;"></div>
	<div style="padding: 5px; color: #A5A5A5; text-shadow: 1px 1px #FFFFFF;">Operator list will refresh in <span id="refresh_counter">25</span> seconds. <span id="image_loading" style="opacity:0.2; filter:alpha(opacity=20);"><img src="../pics/loading_fb.gif" width="16" height="11" border="0" alt=""></span></div>

	<div style="margin-top: 10px;">
		<select name="deptid" id="deptid" style="padding: 3px; font-size: 12px; background: #D4FFD4; color: #009000;" OnChange="switch_dept( this.value )">
		<option value="0">All Departments</option>
		<?php
			for ( $c = 0; $c < count( $departments ); ++$c )
			{
				$department = $departments[$c] ;
				if ( $department["name"] != "Archive" )
				{
					$selected = ( $deptid == $department["deptID"] ) ? "selected" : "" ;
					print "<option value=\"$department[deptID]\" $selected>$department[name]</option>" ;
				}
			}
		?>
		</select>
	</div>
	
	<div class="info_error" style="display: none; margin-top: 10px;" id="div_error_dc">Could not connect to server.  Try refreshing the window to re-establish connection.</div>
	<div style="margin-top: 10px;">
		<table cellspacing=0 cellpadding=0 border=0 width="100%" id="table_trs">
		<tr>
			<td class="td_dept_header"><a href="JavaScript:void(0)" onClick="open_window('<?php echo $CONF["BASE_URL"] ?>/setup/ops.php')">Operator</a> &nbsp; <input type="radio" name="sort_by" onClick="switch_sort('name')" <?php echo ( !$sort_by || ( $sort_by == "name" ) ) ? "checked" : "" ; ?>></td>
			<td width="80" class="td_dept_header">Status &nbsp; <input type="radio" name="sort_by" onClick="switch_sort('status')" <?php echo ( $sort_by == "status" ) ? "checked" : "" ; ?>></td>
			<td width="80" class="td_dept_header">Chats &nbsp; <input type="radio" name="sort_by" onClick="switch_sort('chats')" <?php echo ( $sort_by == "chats" ) ? "checked" : "" ; ?>></td>
			<td width="110" class="td_dept_header" style="">Recent Rating</td>
		</tr>
		<tbody id="table_tbody">
		</tbody>
		</table>
	</div>
</div>


<div id="remote_disconnect_notice" style="display: none; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: url( ../pics/bg_trans_white.png ) repeat; overflow: hidden; z-index: 20;">
	<div style="padding-top: 150px; text-align: center;"><span class="info_error" style="">Disconnecting console [ <span id="op_login"></span> ].  Just a moment... <img src="../pics/loading_fb.gif" width="16" height="11" border="0" alt=""></span></div>
</div>


<div style="position: fixed; bottom: 0px; width: 100%; background: #FFFFFF; border-top: 1px solid #D6D6D6; color: #6D6D71;">
	<div id="total_visitors" style="padding: 10px; text-align: right;">
		Website visitors: <span class="info_box" id="span_total_visitors"></span>
	</div>
</div>

</body>
</html>
<?php
	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;
?>
