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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }

	$https = "" ; $error = "" ;
	if ( isset( $_SERVER["HTTP_CF_VISITOR"] ) && preg_match( "/(https)/i", $_SERVER["HTTP_CF_VISITOR"] ) ) { $https = "s" ; }
	else if ( isset( $_SERVER["HTTP_X_FORWARDED_PROTO"] ) && preg_match( "/(https)/i", $_SERVER["HTTP_X_FORWARDED_PROTO"] ) ) { $https = "s" ; }
	else if ( isset( $_SERVER["HTTPS"] ) && preg_match( "/(on)/i", $_SERVER["HTTPS"] ) ) { $https = "s" ; }

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$jump = Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ; if ( !$jump ) { $jump = "main" ; }
	$ftab = Util_Format_Sanatize( Util_Format_GetVar( "ftab" ), "ln" ) ;
	if ( !isset( $CONF['icon_check'] ) ) { $CONF['icon_check'] = "on" ; }

	if ( $action === "submit" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_ext.php" ) ;

		$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
		$rate = Util_Format_Sanatize( Util_Format_GetVar( "rate" ), "n" ) ;
		$sms = Util_Format_Sanatize( Util_Format_GetVar( "sms" ), "n" ) ;
		$op2op = Util_Format_Sanatize( Util_Format_GetVar( "op2op" ), "n" ) ;
		$traffic = Util_Format_Sanatize( Util_Format_GetVar( "traffic" ), "n" ) ;
		$viewip = Util_Format_Sanatize( Util_Format_GetVar( "viewip" ), "n" ) ;
		$maxc = Util_Format_Sanatize( Util_Format_GetVar( "maxc" ), "n" ) ;
		$maxco = Util_Format_Sanatize( Util_Format_GetVar( "maxco" ), "n" ) ;
		$login = Util_Format_Sanatize( Util_Format_GetVar( "login" ), "ln" ) ;
		$password = Util_Format_Sanatize( Util_Format_GetVar( "password" ), "ln" ) ;
		$name = Util_Format_Sanatize( Util_Format_GetVar( "name" ), "ln" ) ;
		$email = Util_Format_Sanatize( Util_Format_GetVar( "email" ), "e" ) ;
		$mapper = Util_Format_Sanatize( Util_Format_GetVar( "mapper" ), "n" ) ;
		$nchats = Util_Format_Sanatize( Util_Format_GetVar( "nchats" ), "n" ) ;
		$tag = Util_Format_Sanatize( Util_Format_GetVar( "tag" ), "n" ) ;
		$vupload = Util_Format_Sanatize( Util_Format_GetVar( "vupload" ), "a" ) ;

		$total_ops = Ops_get_TotalOps( $dbh ) ;
	
		if ( isset( $VARS_MAX_OPS ) && ( $total_ops >= $VARS_MAX_OPS ) && !$opid )
			$error = "Max allowed operators have been reached." ;
		else
		{
			$vupload_val = "" ;
			if ( !count( $vupload ) ) { $vupload_val = "0," ; }
			else
			{
				for ( $c = 0; $c < count( $vupload ); ++$c )
				{
					if ( $vupload[$c] == 1 ) { $vupload_val = "1," ; break ; }
					$vupload_val .= $vupload[$c]."," ;
				}
			} if ( $vupload_val ) { $vupload_val = substr_replace( $vupload_val, "", -1 ) ; }
			$error = Ops_put_Op( $dbh, $opid, 1, $mapper, $rate, $sms, $op2op, $traffic, $viewip, $nchats, $maxc, $maxco, $login, $password, $name, $email, $tag, strtoupper( $vupload_val ) ) ;
			if ( is_numeric( $error ) ) { $error = "" ; }
		}
	}
	else if ( $action === "delete" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/remove.php" ) ;

		$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
		$opinfo = Ops_get_OpInfoByID( $dbh, $opid ) ;

		if ( isset( $opinfo["opID"] ) )
		{
			$mapp_array = ( isset( $VALS["MAPP"] ) && $VALS["MAPP"] ) ? unserialize( $VALS["MAPP"] ) : Array() ;
			if ( $opinfo["mapp"] && is_file( "$CONF[TYPE_IO_DIR]/$opid.mapp" ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/mapp/API/Util_MAPP.php" ) ;
				if ( isset( $mapp_array[$opid] ) ) { $arn = $mapp_array[$opid]["a"] ; $platform = $mapp_array[$opid]["p"] ; }
				if ( isset( $arn ) && $arn ) { Util_MAPP_Publish( $opid, "new_request", $platform, $arn, "Account not found.  You are Offline." ) ; }
			}
			Ops_remove_Op( $dbh, $opid ) ;
		}
	}
	else if ( $action === "submit_assign" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put.php" ) ;

		$opids = Util_Format_GetVar( "opids" ) ;
		$deptids = Util_Format_GetVar( "deptids" ) ;

		for ( $c = 0; $c < count( $opids ); ++$c )
		{
			$opid = Util_Format_Sanatize( $opids[$c], "n" ) ;
			for ( $c2 = 0; $c2 < count( $deptids ); ++$c2 )
			{
				$deptid = Util_Format_Sanatize( $deptids[$c2], "n" ) ;
				$opinfo = Ops_get_OpInfoByID( $dbh, $opid ) ;
				$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
				Ops_put_OpDept( $dbh, $opid, $deptid, $deptinfo["visible"], $opinfo["status"] ) ;
			}
		}
	}

	Ops_update_itr_IdleOps( $dbh ) ;
	$operators = Ops_get_AllOps( $dbh ) ;
	$departments = Depts_get_AllDepts( $dbh ) ;

	$login_url = $CONF['BASE_URL'] ;
	if ( !preg_match( "/\/\//", $login_url ) ) { $login_url = "//$PHPLIVE_HOST$login_url" ; }
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
	var global_div_list_height ;
	var global_div_form_height ;
	var global_opid ;
	var st_rd ;

	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		$("body").show() ;

		init_menu() ;
		toggle_menu_setup( "ops" ) ;
		init_divs() ;
		init_op_dept_list() ;

		show_div( "<?php echo $jump ?>" ) ;

		<?php if ( $action && !$error ): ?>
		do_alert( 1, "Success" ) ;
		<?php elseif ( $error ): ?>
		do_alert( 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>

		$('#login').bind("paste",function(e) {
			e.preventDefault() ;
		});

		<?php if ( $ftab == "max" ): ?>
			$('#div_td_max').fadeTo("fast", .1).fadeTo("fast", 1).fadeTo("fast", .1).fadeTo("fast", 1).fadeTo("fast", .1).fadeTo("fast", 1).fadeTo("fast", .1).fadeTo("fast", 1).fadeTo("fast", .1).fadeTo("fast", 1).fadeTo("fast", .1).fadeTo("fast", 1) ;
		<?php endif ; ?>
	});

	function init_divs()
	{
		global_div_list_height = $('#div_list').outerHeight() ;
		global_div_form_height = $('#div_form').outerHeight() ;
	}

	function init_op_dept_list() { <?php for ( $c = 0; $c < count( $departments ); ++$c ) { $department = $departments[$c] ; if ( $department["name"] != "Archive" ) { print "op_dept_moveup( $department[deptID], 0 ) ;" ; } } ?> }

	function do_edit( theopid, thename, theemail, thelogin, therate, thesms, theop2op, thetraffic, theviewip, themaxc, themaxco, themapper, thenchats, thetag, theupload )
	{
		show_form() ;
		$( "input#opid" ).val( theopid ) ;
		$( "input#name" ).val( thename ) ;
		$( "input#email" ).val( theemail ) ;
		$( "input#login" ).val( thelogin ) ;
		$( "input#password_temp" ).val( "php-live-support" ) ;
		$( "select#maxc" ).val( themaxc ) ;
		$( "input#maxco_"+themaxco ).prop( "checked", true ) ;
		$( "input#rate_"+therate ).prop( "checked", true ) ;
		$( "input#sms_"+thesms ).prop( "checked", true ) ;
		$( "input#op2op_"+theop2op ).prop( "checked", true ) ;
		$( "input#traffic_"+thetraffic ).prop( "checked", true ) ;
		$( "input#viewip_"+theviewip ).prop( "checked", true ) ;
		$( "input#mapper_"+themapper ).prop( "checked", true ) ;
		$( "input#nchats_"+thenchats ).prop( "checked", true ) ;
		$( "input#tag_"+thetag ).prop( "checked", true ) ;
		$('#div_op_online').show() ;

		do_upload_checked( theupload ) ;
	}

	function do_notice( thediv, theopid, thelogin )
	{
		if ( ( thediv == "disconnect" ) && ( typeof( st_rd ) != "undefined" ) ) { do_alert( 0, "Another disconnect in progress." ) ; return false ; }

		var pos = $('#div_tr_'+theopid).position() ;
		var width = $('#div_tr_'+theopid).outerWidth() ;
		var height = $('#div_tr_'+theopid).outerHeight() - 8 ;

		global_opid = theopid ;

		if ( $('#div_notice_'+thediv).is(':visible') )
			$('#div_notice_'+thediv).fadeOut( "fast", function() { show_div_notice(thediv, thelogin, pos, width, height) ; }) ;
		else
			show_div_notice(thediv, thelogin, pos, width, height) ;
	}

	function do_delete_doit()
	{
		location.href = "ops.php?action=delete&opid="+global_opid ;
	}

	function show_div_notice( thediv, thelogin, thepos, thewidth, theheight )
	{
		$('#span_login_'+thediv).html( thelogin ) ;
		$('#div_notice_'+thediv).css({'top': thepos.top, 'left': thepos.left, 'width': thewidth, 'height': theheight}).fadeIn("fast") ;
	}

	function do_submit()
	{
		var name = encodeURIComponent( $( "input#name" ).val() ) ;
		var email = $( "input#email" ).val() ;
		var login = encodeURIComponent( $( "input#login" ).val() ) ;
		var password = phplive_md5( $( "input#password_temp" ).val() ) ; $( "input#password" ).val( password ) ;

		if ( name == "" )
			do_alert( 0, "Please provide a name." ) ;
		else if ( !check_email( email ) )
			do_alert( 0, "Please provide a valid email address." ) ;
		else if ( login == "" )
			do_alert( 0, "Please provide a login." ) ;
		else if ( password == "" )
			do_alert( 0, "Please provide a password." ) ;
		else if ( login == "<?php echo $admininfo["login"] ?>" )
			do_alert( 0, "Operator login cannot be the same as the setup admin login." ) ;
		else
		{
			email = encodeURIComponent( email ) ;
			$('#theform').submit() ;
		}
	}

	function show_div( thediv )
	{
		var divs = Array( "main", "assign", "report", "monitor", "online" ) ;

		if ( $('#div_form').is(':visible') )
			do_reset() ;

		for ( var c = 0; c < divs.length; ++c )
		{
			$('#edit').hide() ;

			$('#ops_'+divs[c]).hide() ;
			$('#menu_ops_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		if ( thediv == "main" )
			$('#edit').show() ;

		$('input#jump').val( thediv ) ;
		$('#ops_'+thediv).show() ;
		$('#menu_ops_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}

	function op_dept_moveup( thedeptid, theopid )
	{
		var json_data = new Object ;
		$('#dept_ops_'+thedeptid).css({'opacity': 1, 'z-Index': -10}) ;

		$.ajax({
			type: "POST",
			url: "../ajax/setup_actions.php",
			data: "action=moveup&deptid="+thedeptid+"&opid="+theopid+"&"+unixtime(),
			success: function(data){
				eval( data ) ;

				if ( json_data.ops != undefined )
				{
					var ops_string = "<table cellspacing=0 cellpadding=0 border=0 width=\"92%\">" ;
					for ( var c = 0; c < json_data.ops.length; ++c )
					{
						var name = json_data.ops[c]["name"] ;
						var opid = json_data.ops[c]["opid"] ;
						var move_up = ( c ) ? "&nbsp; <a href=\"JavaScript:void(0)\" onClick=\"op_dept_moveup( "+thedeptid+", "+opid+" )\">move up</a>" : "&nbsp;" ;

						ops_string += "<tr><td class=\"td_dept_td\" nowrap><a href=\"JavaScript:void(0)\" onClick=\"op_dept_remove( "+thedeptid+", "+opid+" )\"><img src=\"../pics/icons/delete.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"delete\" title=\"delete\"></a> "+move_up+"</td><td class=\"td_dept_td\">"+name+"</td></tr>" ;
					}
					if ( c == 0 )
						ops_string += "<tr><td colspan=7 class=\"td_dept_td\">Blank results.</td></tr>" ;
				}
				ops_string += "</table>" ;
				$('#dept_ops_'+thedeptid).html( ops_string ) ;
				setTimeout(function(){ $('#dept_ops_'+thedeptid).css({'opacity': 1, 'z-Index': 10}) ; }, 500) ;
			}
		});
	}

	function op_dept_remove( thedeptid, theopid )
	{
		var json_data = new Object ;
		$('#dept_ops_'+thedeptid).css({'opacity': 1, 'z-Index': -10}) ;

		$.ajax({
			type: "POST",
			url: "../ajax/setup_actions.php",
			data: "action=op_dept_remove&deptid="+thedeptid+"&opid="+theopid+"&"+unixtime(),
			success: function(data){
				eval( data ) ;

				if ( json_data.status )
					op_dept_moveup( thedeptid, 0 ) ;
			}
		});
	}

	function remote_disconnect()
	{
		var json_data = new Object ;
		$('#remote_disconnect_button').hide() ;
		$('#remote_disconnect_notice').show() ;

		$.ajax({
			type: "POST",
			url: "../ajax/setup_actions.php",
			data: "action=remote_disconnect&opid="+global_opid+"&"+unixtime(),
			success: function(data){
				eval( data ) ;

				if ( json_data.status )
					check_op_status( global_opid ) ;
				else
				{
					$('#remote_disconnect_notice').hide() ;
					do_alert( 0, "Could not remote disconnect console.  Please try again." ) ;
				}
			}
		});
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
				location.href = 'ops.php?action=success' ;
			else
				st_rd = setTimeout( function(){ check_op_status( theopid ) ; }, 2000 ) ;
		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Lost connection to server.  Please refresh the page and try again." ) ;
		} });
	}

	function launch_tools_op_status()
	{
		var url = "tools_op_status.php" ;

		if ( <?php echo count( $operators ) ?> > 0 )
			window.open( url, "Operators", "scrollbars=yes,menubar=no,resizable=1,location=no,width=550,height=550,status=0" ) ;
		else
		{
			if ( confirm( "Operator account does not exist.  Create an operator?" ) )
				location.href = "ops.php" ;
		}
	}

	function check_all_ops( theobject )
	{
		if ( ( typeof( theobject ) != "undefined" ) && ( theobject.checked ) )
		{
			$( '#div_list_ops' ).find('*').each( function () {
				var div_name = this.id ;
				if ( div_name.indexOf( "ck_op_" ) == 0 )
					this.checked = true ;
			}) ;
		}
		else
		{
			$( '#div_list_ops' ).find('*').each( function () {
				var div_name = this.id ;
				if ( div_name.indexOf( "ck_op_" ) == 0 )
					this.checked = false ;
			}) ;
		}
	}

	function check_all_depts( theobject )
	{
		if ( ( typeof( theobject ) != "undefined" ) && ( theobject.checked ) )
		{
			$( '#div_list_depts' ).find('*').each( function () {
				var div_name = this.id ;
				if ( div_name.indexOf( "ck_dept_" ) == 0 )
					this.checked = true ;
			}) ;
		}
		else
		{
			$( '#div_list_depts' ).find('*').each( function () {
				var div_name = this.id ;
				if ( div_name.indexOf( "ck_dept_" ) == 0 )
					this.checked = false ;
			}) ;
		}
	}

	function do_assign()
	{
		var ok_ops = 0 ;
		var ok_depts = 0 ;

		$( '#div_list_ops' ).find('*').each( function () {
			var div_name = this.id ;
			if ( ( div_name.indexOf( "ck_op_" ) == 0 ) && this.checked )
				ok_ops = 1 ;
		}) ;
		$( '#div_list_depts' ).find('*').each( function () {
			var div_name = this.id ;
			if ( ( div_name.indexOf( "ck_dept_" ) == 0 ) && this.checked )
				ok_depts = 1 ;
		}) ;

		if ( !ok_ops )
			do_alert( 0, "An operator must be selected." ) ;
		else if ( !ok_depts )
			do_alert( 0, "A department must be selected." ) ;
		else
			$('#form_assign').submit() ;
	}

	function show_form()
	{
		$(window).scrollTop(0) ;
		$('#div_list').hide() ;
		$('#div_btn_add').hide() ;
		$('#div_form').show() ;
	}

	function do_reset()
	{
		$('#opid').val(0) ;
		$('#theform').each(function(){
			this.reset();
		});

		$('#div_form').hide() ;
		$('#div_btn_add').show() ;
		$('#div_list').show() ;
		$('#div_op_online').hide() ;

		$(window).scrollTop(0) ;
	}

	function toggle_upload( thevalue )
	{
		var total_checked = 0 ;
		$( '#theform' ).find('*').each( function () {
			var div_name = this.id ;
			if ( div_name.indexOf( "upload_" ) == 0 )
			{
				if ( this.checked ) { ++total_checked ; }
			}
		}) ;

		if ( $('#upload_'+thevalue).is(':checked') )
		{
			$('#upload_'+thevalue).prop('checked', false) ;
			if ( thevalue != 1 ) { $('#upload_1').prop('checked', false) ; }
			else if ( thevalue == 1 ) { check_all(0) ; }
		}
		else
		{
			++total_checked ;
			$('#upload_'+thevalue).prop('checked', true) ;
			if ( thevalue == 0 ) { check_all(0) ; }
			else if ( thevalue == 1 ) { check_all(1) ; }
			else if ( total_checked == 8 ) { $('#upload_1').prop('checked', true) ; }
			else { $('#upload_0').prop('checked', false) ; }
		}
	}

	function check_all( theflag )
	{
		if ( theflag )
		{
			$( '#theform' ).find('*').each( function () {
				var div_name = this.id ;
				if ( div_name.indexOf( "upload_" ) == 0 )
				{
					if ( div_name == "upload_0" )
						this.checked = false ;
					else
						this.checked = true ;
				}
			}) ;
		}
		else
		{
			$( '#theform' ).find('*').each( function () {
				var div_name = this.id ;
				if ( div_name.indexOf( "upload_" ) == 0 )
				{
					if ( div_name != "upload_0" )
						this.checked = false ;
				}
			}) ;
		}
	}

	function do_upload_checked( thevalue )
	{
		var uploads = thevalue.split( "," ) ;

		if ( uploads.length >= 8 ) { check_all(1) ; }
		else
		{
			for ( var c = 0; c < uploads.length; ++c )
			{
				var value = uploads[c] ;

				if ( value )
				{
					if ( value == 1 ) { check_all(1) ; break ; }
					else { $('#upload_'+value).prop('checked', true) ; }
				}
			}
		}
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu_focus" style="margin-left: 0px;" onClick="show_div('main')" id="menu_ops_main">Chat Operators</div>
			<div class="op_submenu" onClick="show_div('assign')" id="menu_ops_assign">Assign Operator to Department</div>
			<div class="op_submenu" onClick="location.href='interface_op_pics.php'">Profile Picture</div>
			<div class="op_submenu" onClick="location.href='ops_reports.php'" id="menu_ops_report">Online Activity</div>
			<div class="op_submenu" onClick="show_div('monitor')" id="menu_ops_monitor">Status Monitor</div>
			<div class="op_submenu" onClick="location.href='ops.php?jump=online'" id="menu_ops_online"><img src="../pics/icons/bulb.png" width="12" height="12" border="0" alt=""> Go ONLINE!</div>
			<div style="clear: both"></div>
		</div>

		<div id="ops_main">
			<div id="div_btn_add" class="edit_focus" style="margin-top: 25px;" onClick="show_form()">Add Chat Operator</div>

			<div id="div_list" style="margin-top: 55px; max-height: 600px; overflow: auto;">
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td width="40"><div class="td_dept_header">&nbsp;</div></td>
					<td><div class="td_dept_header">Name</div></td>
					<td><div class="td_dept_header">Login</div></td>
					<td><div class="td_dept_header">Email</div></td>
					<td width="50" nowrap align="center"><div class="td_dept_header" id="div_td_max" style="cursor: help;" title="maximum concurrent chat sessions" alt="maximum concurrent chat sessions">Max</div></td>
					<td width="60" nowrap align="center"><div class="td_dept_header">Rate</div></td>
					<td width="80" nowrap align="center"><div class="td_dept_header" alt="Operator to Operator Chat" title="Operator to Operator Chat">Op2Op</div></td>
					<td width="60" nowrap align="center"><div class="td_dept_header">Traffic</div></td>
					<td width="80" nowrap align="center"><div class="td_dept_header">View IP</div></td>
					<td width="60" nowrap align="center"><div class="td_dept_header">Status</div></td>
				</tr>
				<?php
					$image_empty = "<img src=\"../pics/space.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"\">" ;
					$image_checked = "<img src=\"../pics/icons/check.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\">";
					for ( $c = 0; $c < count( $operators ); ++$c )
					{
						$operator = $operators[$c] ;

						$login = $operator["login"] ;
						$email = $operator["email"] ;
						$maxc = ( $operator["maxc"] != -1 ) ? $operator["maxc"] : "&nbsp;" ;
						$rate = ( $operator["rate"] ) ? $image_checked : $image_empty ;
						$sms = ( $operator["sms"] ) ? $image_checked : $image_empty ;
						$op2op = ( $operator["op2op"] ) ? $image_checked : $image_empty ;
						$traffic = ( $operator["traffic"] ) ? $image_checked : $image_empty ;
						$viewip = ( $operator["viewip"] ) ? $image_checked : $image_empty ;
						$status = ( $operator["status"] ) ? "<b>Operator is Online</b><br>Click to disconnect console." : "Offline" ;
						$style = ( $operator["status"] ) ? "cursor: pointer" : "" ;
						$td_style = ( $operator["status"] ) ? "background: #AFFF9F; $style" : "" ;
						$js = ( $operator["status"] ) ? "onClick=\"do_notice('disconnect', $operator[opID], '$login')\"" : "" ;
						$sms_edit = ( $operator["sms"] ) ? 1 : 0 ;
						$profile_image = Util_Upload_GetLogo( "profile", $operator["opID"] ) ;
						$mapp_icon = ( $operator["mapper"] ) ? " <img src=\"../pics/icons/mobile.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"mobile app access\" title=\"mobile app access\" style=\"cursor: help;\"> " : "" ;
						$mapp_online_icon = ( $operator["mapp"] ) ? " &nbsp; <img src=\"../pics/icons/mobile.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"logged in on mobile\" title=\"logged in on mobile\" style=\"cursor: help;\">" : "" ;
						$tag_icon = ( $operator["tag"] ) ? " <img src=\"../pics/icons/pin.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"can tag chats\" title=\"can tag chats\" style=\"cursor: pointer;\" onClick=\"location.href='transcripts_tags.php'\"> " : "" ;
						$upload_icon = ( $VARS_INI_UPLOAD && $operator["upload"] ) ? "<img src=\"../pics/icons/attach.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"can upload files during chat\" title=\"can upload files during chat\" style=\"cursor: pointer;\" onClick=\"location.href='settings.php?jump=upload'\">" : "" ;

						$bg_color = ( ($c+1) % 2 ) ? "FFFFFF" : "F6F7F8" ;

						$status_img = ( $operator["status"] ) ? "<img src=\"../pics/icons/bulb.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"online\" title=\"online\">$mapp_online_icon<br>close" : "<img src=\"../pics/icons/bulb_off.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"offline\" title=\"offline\">" ;

						$edit_delete = "<div style=\"cursor: pointer;\" onClick=\"do_edit( $operator[opID], '$operator[name]', '$operator[email]', '$operator[login]', $operator[rate], $sms_edit, $operator[op2op], $operator[traffic], $operator[viewip], $operator[maxc], $operator[maxco], $operator[mapper], $operator[nchats], $operator[tag], '$operator[upload]' )\"><img src=\"../pics/btn_edit.png\" width=\"64\" height=\"23\" border=\"0\" alt=\"\"></div><div onClick=\"do_notice('delete', $operator[opID], '$login')\" style=\"margin-top: 10px; cursor: pointer;\"><img src=\"../pics/btn_delete.png\" width=\"64\" height=\"23\" border=\"0\" alt=\"\"></div>" ;

						$td1 = "td_dept_td" ;

						print "
						<tr id=\"div_tr_$operator[opID]\" style=\"background: #$bg_color\">
							<td class=\"$td1\" nowrap>$edit_delete</td>
							<td class=\"$td1\">
								<table cellspacing=0 cellpadding=2 border=0>
								<tr>
									<td align=\"center\" style=\"font-size: 10px;\"><a href=\"interface_op_pics.php?opid=$operator[opID]\"><img src=\"$profile_image\" width=\"55\" height=\"55\" border=\"0\" alt=\"\" style=\"border: 1px solid #DFDFDF;\" class=\"round\"></a></td>
									<td>$operator[name]<div>$mapp_icon $tag_icon $upload_icon</div></td>
								</tr>
								</table>
							</td>
							<td class=\"$td1\" nowrap>$login</td>
							<td class=\"$td1\">$email</td>
							<td class=\"$td1\" align=\"center\">$maxc</td>
							<td class=\"$td1\" align=\"center\">$rate</td>
							<td class=\"$td1\" align=\"center\">$op2op</td>
							<td class=\"$td1\" align=\"center\">$traffic</td>
							<td class=\"$td1\" align=\"center\">$viewip</td>
							<td class=\"$td1\" align=\"center\" style=\"$td_style\" $js nowrap>$status_img</td>
						</tr>
						" ;
					}
					if ( $c == 0 )
						print "<tr><td colspan=11 class=\"td_dept_td\">Blank results.</td></tr>" ;
				?>
				</table>
			</div>
		</div>

		<div style="display: none;" id="ops_assign">

			<div style="margin-top: 25px;">
				<?php if ( !count( $departments ) ): ?>
				<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Add a <a href="depts.php" style="color: #FFFFFF;">Department</a> to continue.</span>
				<?php elseif ( !count( $operators ) ):  ?>
				<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Add an <a href="ops.php" style="color: #FFFFFF;">Operator</a> to continue.</span>

				<?php else: ?>
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td valign="top">
						<form method="POST" action="ops.php" id="form_assign">
						<input type="hidden" name="action" value="submit_assign">
						<input type="hidden" name="jump" value="assign">
						
						<div style="max-height: 300px; overflow: auto;" id="div_list_ops">
							<table cellspacing=0 cellpadding=0 border=0 width="100%">
							<tr>
								<td width="20"><div class="td_dept_header"><input type="checkbox" onClick="check_all_ops(this)" id="ck_op_all"></div></td>
								<td width="10"><div class="td_dept_header">ID</div></td>
								<td><div class="td_dept_header">Operator Name</div></td>
								<td width="20"><div class="td_dept_header">Status</div></td>
								<td><div class="td_dept_header">Email</div></td>
							</tr>
							<?php
								for ( $c = 0; $c < count( $operators ); ++$c )
								{
									$operator = $operators[$c] ;

									$td1 = "td_dept_td" ;
									$status_text = ( $operator["status"] ) ? "online" : "offline" ;
									$status_bulb = ( $operator["status"] ) ? "bulb.png" : "bulb_off.png" ;
									$status_img = "<img src=\"../pics/icons/$status_bulb\" width=\"16\" height=\"16\" border=\"0\" alt=\"$status_text\" title=\"$status_text\">" ;

									$bg_color = ( ($c+1) % 2 ) ? "FFFFFF" : "F6F7F8" ;

									print "
									<tr style=\"background: #$bg_color\">
										<td class=\"$td1\"><input type=\"checkbox\" id=\"ck_op_$operator[opID]\" name=\"opids[]\" value=\"$operator[opID]\"></td>
										<td class=\"$td1\">$operator[opID]</td>
										<td class=\"$td1\" nowrap>
											<div style=\"\">$operator[name]</div>
										</td>
										<td class=\"$td1\">$status_img</td>
										<td class=\"$td1\">$operator[email]</td>
									</tr>
									" ;
								}
							?>
							</table>
						</div>
						<div style="margin-top: 15px;" id="div_list_depts">
							<div class=""><img src="../pics/icons/arrow_top.png" width="15" height="16" border="0" alt=""> Assign the above checked operator(s) to the following department(s) <img src="../pics/icons/arrow_down.png" width="15" height="16" border="0" alt=""></div>
							<div style="margin-top: 15px; max-height: 300px; overflow: auto;">
								<table cellspacing=0 cellpadding=0 border=0 width="100%">
								<tr>
									<td width="20"><div class="td_dept_header"><input type="checkbox" onClick="check_all_depts(this)" id="ck_dept_all"></div></td>
									<td width="10"><div class="td_dept_header">ID</div></td>
									<td><div class="td_dept_header">Department Name</div></td>
								</tr>
								<?php
									$ops_assigned = 0 ;
									for ( $c = 0; $c < count( $departments ); ++$c )
									{
										$department = $departments[$c] ;
										$ops = Depts_get_DeptOps( $dbh, $department["deptID"] ) ;
										if ( count( $ops ) )
											$ops_assigned = 1 ;

										$td1 = "td_dept_td" ;
										$bg_color = ( ($c+1) % 2 ) ? "FFFFFF" : "F6F7F8" ;

										if ( $department["name"] != "Archive" )
										{
											print "
											<tr style=\"background: #$bg_color\">
												<td class=\"$td1\"><input type=\"checkbox\" id=\"ck_dept_$department[deptID]\" name=\"deptids[]\" value=\"$department[deptID]\"></td>
												<td class=\"$td1\">$department[deptID]</td>
												<td class=\"$td1\" nowrap>
													<div style=\"\">$department[name]</div>
												</td>
											</tr>
											" ;
										}
									}
								?>
								</table>
							</div>

							<div style="margin-top: 25px;" class="info_box"><table cellspacing=0 cellpadding=0 border=0><tr><td><img src="../pics/icons/info.png" width="16" height="16" border="0" alt=""></td><td style="padding-left: 5px;">If the operator is Online <img src="../pics/icons/bulb.png" width="16" height="16" border="0" alt=""> and is assigned to a new department, they will need to logout and login again to receive chat requests from the new assigned department.</td></tr></table></div>

							<div style="margin-top: 10px;">
								<button type="button" style="padding: 10px;" onClick="do_assign()">Assign</button>
							</div>
						</div>
						</form>
					</td>
					<td valign="top" style="padding-left: 25px;" width="350">
						<div style="max-height: 600px; overflow: auto;">
							<div style="padding-bottom: 15px;"><img src="../pics/icons/user_chat_big.png" width="48" height="48" border="0" alt=""> Department assignment and <span class="info_box">Defined Order</span></div>
							<div style="">
								<?php
									for ( $c = 0; $c < count( $departments ); ++$c )
									{
										$department = $departments[$c] ;

										if ( $department["name"] != "Archive" )
										{
											print "
												<div class=\"info_info\" style=\"margin-bottom: 5px;\">
													<div class=\"td_dept_header\">$department[name]</div>
													<div id=\"dept_ops_$department[deptID]\" style=\"min-height: 25px; max-height: 200px; overflow: auto;\"></div>
												</div>
											" ;
										}
									}
								?>
							</div>
						</div>
					</td>
				</tr>
				</table>
				<?php endif ; ?>
			</div>
		</div>


		<div style="display: none;" id="ops_monitor">
			<div style="margin-top: 25px;">
				View operator online/offline status in a widget window.
			</div>

			<div style="margin-top: 25px;">
				<?php if ( !count( $operators ) ): ?>
				<div style="margin-top: 25px;"><span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Add an <a href="ops.php" style="color: #FFFFFF;">Operator</a> to continue.</span></div>
				<?php else: ?>
				<button type="button" onClick="launch_tools_op_status()" class="btn">Open Operator Status Monitor</button>
				<?php endif ; ?>
			</div>
		</div>

		<div style="display: none;" id="ops_online">
			<div style="margin-top: 25px;">
				<?php if ( !count( $departments ) ): ?>
				<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Add a <a href="depts.php" style="color: #FFFFFF;">Department</a> to continue.</span>
				<?php elseif ( !count( $operators ) ): ?>
				<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> Add an <a href="ops.php" style="color: #FFFFFF;">Operator</a> to continue.</span>
				<?php elseif ( !$ops_assigned ): ?>
				<span class="info_error"><img src="../pics/icons/warning.png" width="12" height="12" border="0" alt=""> <a href="ops.php?jump=assign" style="color: #FFFFFF;">Assign an operator to a department</a> to continue.</span>
				<?php else: ?>

				<div style="">
					<div style="margin-top: 5px;">Provide the following Operator Login URL to your <a href="ops.php?jump=">Chat Operators</a>.  The chat operators will need to login at this URL to go online and to receive visitor chat requests.</div>
					<div style="margin-top: 15px;">
						<div class="edit_title"><img src="../pics/icons/bulb_big.png" width="48" height="48" border="0" alt=""> Chat Operator Login URL:</div>
						<div style="margin-top: 15px;">
							<table cellspacing=0 cellspacing=0 border=0>
							<tr>
								<td><div style="font-size: 32px; font-weight: bold; text-shadow: 1px 1px #FFFFFF;"><a href="<?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?>" target="_blank" style="color: #1DA1F2;" class="nounder"><?php echo ( !preg_match( "/^(http)/", $login_url ) ) ? "http$https:$login_url" : $login_url ; ?></a></div></td>
							</tr>
							</table>
						</div>
					</div>
				</div>

				<div style="margin-top: 25px;"><img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> Don't forget to copy/paste the chat icon <a href="./code.php">HTML Code</a> onto your webpages.</div>
				<?php endif ; ?>
			</div>
		</div>

		<div id="div_form" style="display: none; margin-top: 25px;" id="a_edit">
			<form method="POST" action="ops.php" id="theform">
			<input type="hidden" name="action" value="submit">
			<input type="hidden" name="jump" id="jump" value="">
			<input type="hidden" name="opid" id="opid" value="0">
			<input type="hidden" name="password" id="password" value="">

			<div>
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td colspan=2 style="padding: 10px;" align="left"><img src="../pics/icons/arrow_left.png" width="16" height="15" border="0" alt=""> <a href="JavaScript:void(0)" onClick="do_reset()">back</a></td>
				</tr>
				<tr>
					<td nowrap class="tab_form_title">Operator Name</td>
					<td style="padding-left: 10px;"><input type="text" name="name" id="name" size="30" maxlength="40" value="" onKeyPress="return noquotes(event)"></td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title">Operator Email</td>
					<td style="padding-left: 10px;"><input type="text" name="email" id="email" size="30" maxlength="160" value="" onKeyPress="return justemails(event)"></td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title">Login<div style="font-size: 10px; font-weight: normal;">* letters and numbers only</div></td>
					<td style="padding-left: 10px;"><input type="text" name="login" id="login" size="30" maxlength="15" value="" onKeyPress="return logins(event)"></td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title">Password</td>
					<td style="padding-left: 10px;"><input type="password" name="password_temp" id="password_temp" class="input" size="30" maxlength="15" value="" onKeyPress="return noquotes(event)"></td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title">Max Concurrent Chats<div style="font-size: 10px; font-weight: normal;">Does not apply to department <a href="./depts.php?ftab=route">simultaneous routing type</a>.</div></td>
					<td style="padding-left: 10px;">Maximum number of <span class="info_box">concurrent chat sessions</span> at the same time: 
						<select id="maxc" name="maxc">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10" selected>10</option>
						</select>

						<div style="margin-top: 5px;">
							When the operator reaches the max concurrent chat sessions:
							<div style="margin-top: 5px;">
								<div><input type="radio" name="maxco" id="maxco_0" value=0 checked> skip the operator for all new chat requests until the operator's concurrent chats total is below the max.</div>
								<div style="margin-top: 5px;"><input type="radio" name="maxco" id="maxco_1" value=1> switch the operator to OFFLINE status and automatically resume ONLINE when the operator's concurrent chats total is below the max.</div>
							</div>
						</div>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title">Chat Rating Survey</td>
					<td style="padding-left: 10px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="li_op round" style="background: #7BD869; border: 1px solid #65CB55; color: #FFFFFF; cursor: pointer;" onclick="$('#rate_1').prop('checked', true);"><input type="radio" name="rate" id="rate_1" value="1" checked> On</div><div class="li_op round" style="background: #FD7D7F; border: 1px solid #E16F71; color: #FFFFFF; cursor: pointer;" onclick="$('#rate_0').prop('checked', true);"><input type="radio" name="rate" id="rate_0" value="0"> Off</div><div style="clear:both;"></div></td>
							<td style="padding-left: 5px;">Enable visitors to provide operator performance rating (rating star and comment) after the chat session ends.</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title">Operator to Operator Chat</td>
					<td style="padding-left: 10px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="li_op round" style="background: #7BD869; border: 1px solid #65CB55; color: #FFFFFF; cursor: pointer;" onclick="$('#op2op_1').prop('checked', true);"><input type="radio" name="op2op" id="op2op_1" value="1" checked> On</div><div class="li_op round" style="background: #FD7D7F; border: 1px solid #E16F71; color: #FFFFFF; cursor: pointer;" onclick="$('#op2op_0').prop('checked', true);"><input type="radio" name="op2op" id="op2op_0" value="0"> Off</div><div style="clear:both;"></div></td>
							<td style="padding-left: 5px;">Enable the operator to chat with other online operators from the console ("Off" will hide the "Operators" footer menu).</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title">Traffic Monitor</td>
					<td style="padding-left: 10px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="li_op round" style="background: #7BD869; border: 1px solid #65CB55; color: #FFFFFF; cursor: pointer;" onclick="$('#traffic_1').prop('checked', true);"><input type="radio" name="traffic" id="traffic_1" value="1" checked> On</div><div class="li_op round" style="background: #FD7D7F; border: 1px solid #E16F71; color: #FFFFFF; cursor: pointer;" onclick="$('#traffic_0').prop('checked', true);"><input type="radio" name="traffic" id="traffic_0" value="0"> Off</div><div style="clear:both;"></div></td>
							<td style="padding-left: 5px;">
								View website traffic information (can perform chat invites and other traffic related features).
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title"><img src="../pics/icons/pin.png" width="16" height="16" border="0" alt=""> Can <a href="transcripts_tags.php">Tag</a> Chats</td>
					<td style="padding-left: 10px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="li_op round" style="background: #7BD869; border: 1px solid #65CB55; color: #FFFFFF; cursor: pointer;" onclick="$('#tag_1').prop('checked', true);"><input type="radio" name="tag" id="tag_1" value="1" checked> On</div><div class="li_op round" style="background: #FD7D7F; border: 1px solid #E16F71; color: #FFFFFF; cursor: pointer;" onclick="$('#tag_0').prop('checked', true);"><input type="radio" name="tag" id="tag_0" value="0"> Off</div><div style="clear:both;"></div></td>
							<td style="padding-left: 5px;">Can "tag" a chat during a chat session.</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title"><img src="../pics/icons/attach.png" width="16" height="16" border="0" alt=""> File Upload
					<td style="padding-left: 10px;">
						<?php if ( $VARS_INI_UPLOAD ): ?>
						<div>Can upload files during a chat session?</div>
						<div style="margin-top: 10px;">
							<span class="info_neutral" style="cursor: pointer;" onclick="toggle_upload(0)"><input type="checkbox" name="vupload[]" value="0" id="upload_0" onclick="toggle_upload(0)"> Off</span>
							<span class="info_neutral" style="cursor: pointer;" onclick="toggle_upload(1)"><input type="checkbox" name="vupload[]" value="1" id="upload_1" onclick="toggle_upload(1)"> All</span>
							<span class="info_neutral" style="cursor: pointer;" onclick="toggle_upload('GIF')"><input type="checkbox" name="vupload[]" value="GIF" id="upload_GIF" onclick="toggle_upload('GIF')"> GIF</span>
							<span class="info_neutral" style="cursor: pointer;" onclick="toggle_upload('PNG')"><input type="checkbox" name="vupload[]" value="PNG" id="upload_PNG" onclick="toggle_upload('PNG')"> PNG</span>
							<span class="info_neutral" style="cursor: pointer;" onclick="toggle_upload('JPG')"><input type="checkbox" name="vupload[]" value="JPG" id="upload_JPG" onclick="toggle_upload('JPG')"> JPG, JPEG</span>
							<span class="info_neutral" style="cursor: pointer;" onclick="toggle_upload('PDF')"><input type="checkbox" name="vupload[]" value="PDF" id="upload_PDF" onclick="toggle_upload('PDF')"> PDF</span>
							<span class="info_neutral" style="cursor: pointer;" onclick="toggle_upload('ZIP')"><input type="checkbox" name="vupload[]" value="ZIP" id="upload_ZIP" onclick="toggle_upload('ZIP')"> ZIP</span>
							<span class="info_neutral" style="cursor: pointer;" onclick="toggle_upload('TAR')"><input type="checkbox" name="vupload[]" value="TAR" id="upload_TAR" onclick="toggle_upload('TAR')"> TAR</span>
							<span class="info_neutral" style="cursor: pointer;" onclick="toggle_upload('TXT')"><input type="checkbox" name="vupload[]" value="TXT" id="upload_TXT" onclick="toggle_upload('TXT')"> TXT</span>
							<span class="info_neutral" style="cursor: pointer;" onclick="toggle_upload('CONF')"><input type="checkbox" name="vupload[]" value="CONF" id="upload_CONF" onclick="toggle_upload('CONF')"> CONF</span>
						</div>
						<?php else: ?>
						<img src="../pics/icons/alert.png" width="16" height="16" border="0" alt=""> File upload is not enabled for this server ('<a href="http://php.net/manual/en/ini.core.php#ini.file-uploads" target="_blank">file_uploads</a>' directive).  Please contact the server admin for more information.
						<?php endif ; ?>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title">View IP</td>
					<td style="padding-left: 10px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="li_op round" style="background: #7BD869; border: 1px solid #65CB55; color: #FFFFFF; cursor: pointer;" onclick="$('#viewip_1').prop('checked', true);"><input type="radio" name="viewip" id="viewip_1" value="1"> On</div><div class="li_op round" style="background: #FD7D7F; border: 1px solid #E16F71; color: #FFFFFF; cursor: pointer;" onclick="$('#viewip_0').prop('checked', true);"><input type="radio" name="viewip" id="viewip_0" value="0" checked> Off</div><div style="clear:both;"></div></td>
							<td style="padding-left: 5px;">View website visitor's IP and the <a href="extras_geo.php">GeoIP</a> information.</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title">View Chatting Number</td>
					<td style="padding-left: 10px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="li_op round" style="background: #7BD869; border: 1px solid #65CB55; color: #FFFFFF; cursor: pointer;" onclick="$('#nchats_1').prop('checked', true);"><input type="radio" name="nchats" id="nchats_1" value="1"> On</div><div class="li_op round" style="background: #FD7D7F; border: 1px solid #E16F71; color: #FFFFFF; cursor: pointer;" onclick="$('#nchats_0').prop('checked', true);"><input type="radio" name="nchats" id="nchats_0" value="0" checked> Off</div><div style="clear:both;"></div></td>
							<td style="padding-left: 5px;">View the total number of <span class="info_box">active chats of other operators</span>. (example: Jacob is chatting with 2 visitors)</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title">SMS Alerts</td>
					<td style="padding-left: 10px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="li_op round" style="background: #7BD869; border: 1px solid #65CB55; color: #FFFFFF; cursor: pointer;" onclick="$('#sms_1').prop('checked', true);"><input type="radio" name="sms" id="sms_1" value="1"> On</div><div class="li_op round" style="background: #FD7D7F; border: 1px solid #E16F71; color: #FFFFFF; cursor: pointer;" onclick="$('#sms_0').prop('checked', true);"><input type="radio" name="sms" id="sms_0" value="0" checked> Off</div><div style="clear:both;"></div></td>
							<td style="padding-left: 5px;">Receive new chat request mobile SMS alert. (configured by the operator at their operator area)</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 15px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td class="tab_form_title"><img src="../pics/icons/mobile.png" width="16" height="16" border="0" alt=""> <a href="../mapp/settings.php">Mobile App Access</a></td>
					<td style="padding-left: 10px;">
						<table cellspacing=0 cellpadding=0 border=0>
						<tr>
							<td><div class="li_op round" style="background: #7BD869; border: 1px solid #65CB55; color: #FFFFFF; cursor: pointer;" onclick="$('#mapper_1').prop('checked', true);"><input type="radio" name="mapper" id="mapper_1" value="1"> On</div><div class="li_op round" style="background: #FD7D7F; border: 1px solid #E16F71; color: #FFFFFF; cursor: pointer;" onclick="$('#mapper_0').prop('checked', true);"><input type="radio" name="mapper" id="mapper_0" value="0" checked> Off</div><div style="clear:both;"></div></td>
							<td style="padding-left: 5px;">Enable the operator to login from the Mobile Application.</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<div style="margin-top: 25px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td><div class="tab_form_title" style="background: #F0F0F2; border: 1px solid #F0F0F2; text-align: left; font-weight: normal;"><img src="../pics/icons/arrow_left.png" width="16" height="15" border="0" alt=""> <a href="JavaScript:void(0)" onClick="do_reset()">back</a></div></td>
					<td style="padding-left: 10px;">
						<div id="div_op_online" style="display: none; padding-bottom: 25px;"><img src="../pics/icons/info.png" width="16" height="16" border="0" alt=""> If the operator is Online, they will need to logout and login again for the changes to take effect.</div>
						<div style=""><button type="button" onClick="do_submit()" class="btn">Submit</button></div>
					</td>
				</tr>
				</table>
			</div>

			</form>
		</div>

		<div id="div_notice_disconnect" style="display: none; position: absolute; text-align: right;" class="info_error">
			<div style="padding: 10px;">
				<div class="edit_title">Operator <span id="span_login_disconnect"></span> is <span class="info_good">ONLINE</span>.  Remote disconnect operator console and go offline?</div>

				<div style="margin-top: 15px;" id="remote_disconnect_button"><button type="button" onClick="remote_disconnect()">Yes. Disconnect</button> &nbsp; <a href="JavaScript:void(0)" style="color: #FFFFFF" onClick="$('#div_notice_disconnect').fadeOut('fast')">cancel</a></div>
				<div id="remote_disconnect_notice" style="display: none; margin-top: 15px;">Disconnecting console.  Just a moment... <img src="../pics/loading_fb.gif" width="16" height="11" border="0" alt=""></div>
			</div>
		</div>

		<div id="div_notice_delete" style="display: none; position: absolute;" class="info_error">
			<div style="padding: 10px;">
				<div class="edit_title">Really delete operator account (<span id="span_login_delete"></span>)?</div>
				<div style="margin-top: 5px;">Deleting the operator account will also delete the operator's chat transcripts.</div>

				<div style="margin-top: 15px;"><button type="button" onClick="$(this).attr('disabled', true);do_delete_doit();">Delete</button> &nbsp; &nbsp; &nbsp; <a href="JavaScript:void(0)" style="color: #FFFFFF" onClick="$('#div_notice_delete').fadeOut('fast')">cancel</a></div>
			</div>
		</div>

<?php include_once( "./inc_footer.php" ) ?>
