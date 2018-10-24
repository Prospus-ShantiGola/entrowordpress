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
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;

	$error = "" ;
	$theme = "default" ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
	$page = Util_Format_Sanatize( Util_Format_GetVar( "page" ), "n" ) ;
	$index = Util_Format_Sanatize( Util_Format_GetVar( "index" ), "n" ) ;
	$tid = Util_Format_Sanatize( Util_Format_GetVar( "tid" ), "n" ) ;

	$departments = Depts_get_AllDepts( $dbh ) ;
	$operators = Ops_get_AllOps( $dbh ) ;

	// make hash for quick refrence
	$operators_hash = Array() ;
	for ( $c = 0; $c < count( $operators ); ++$c )
	{
		$operator = $operators[$c] ;
		$operators_hash[$operator["opID"]] = $operator["name"] ;
	}

	$dept_hash = Array() ; $dept_customs = Array() ;
	for ( $c = 0; $c < count( $departments ); ++$c )
	{
		$department = $departments[$c] ;
		$dept_hash[$department["deptID"]] = $department["name"] ;
		if ( $department["custom"] )
		{
			$custom = unserialize( $department["custom"] ) ;
			$dept_customs = array_merge( $dept_customs, $custom ) ;
		}
	}

	$custom_search_options = "" ; $custom_search_field_hash = Array() ;
	for ( $c = 0; $c < count( $dept_customs ); ++$c )
	{
		$custom = $dept_customs[$c] ;
		if ( $custom && !isset( $custom_search_field_hash[$custom] ) )
		{ $custom_search_field_hash[$custom] = 1 ; $custom_search_options .= "<option value='cus_$c'>$custom</option>" ; }
		++$c ;
	}

	if ( $action === "delete" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove.php" ) ;
		$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "ln" ) ;

		if ( !Chat_remove_Transcript( $dbh, $ces ) )
			$error = "Transcript delete error: $dbh[error]" ;
	}

	// fetch starting year of installation (admin created)
	if ( $admininfo["adminID"] == 1 ) { $y_start = date( "Y", $admininfo["created"] ) ; }
	else
	{
		$query = "SELECT adminID, created FROM p_admins WHERE adminID = 1 LIMIT 1" ;
		database_mysql_query( $dbh, $query ) ;
		$super_admin = database_mysql_fetchrow( $dbh ) ;
		if ( isset( $super_admin["created"] ) ) { $y_start = date( "Y", $super_admin["created"] ) ; }
		else { $y_start = 2011 ; }
	}
	$text = Util_Format_Sanatize( Util_Format_GetVar( "text" ), "" ) ; $text = ( $text ) ? $text : "" ; $text_query = urlencode( $text ) ;
	$s_as = Util_Format_Sanatize( Util_Format_GetVar( "s_as" ), "ln" ) ;
	$year = Util_Format_Sanatize( Util_Format_GetVar( "y" ), "n" ) ; if ( !$year ) { $year = date( "Y", time() ) ; }
	$stat_start = mktime( 0, 0, 1, 1, 1, $year ) ;
	$stat_end = mktime( 23, 59, 59, 12, date( "t", mktime( 23, 59, 59, 12, 1, $year ) ), $year ) ;
	$transcripts = Chat_ext_get_RefinedTranscripts( $dbh, $deptid, $opid, $tid, $s_as, $text, $stat_start, $stat_end, $page, 15 ) ;

	$total_index = count($transcripts) - 1 ;
	$pages = Util_Functions_Page( $page, $index, 15, $transcripts[$total_index], "transcripts.php", "s_as=$s_as&text=$text_query&deptid=$deptid&opid=$opid&tid=$tid" ) ;

	$tags = isset( $VALS['TAGS'] ) ? unserialize( $VALS['TAGS'] ) : Array() ;
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

<script data-cfasync="false" type="text/javascript">
<!--
	var global_ces ; var global_created ; var global_noteid ;
	var reset_url = "transcripts.php" ;

	$(document).ready(function()
	{
		init_menu() ;
		toggle_menu_setup( "trans" ) ;

		show_div( "export" ) ;

		$('#form_search').bind("submit", function() { return false ; }) ;

		<?php if ( $action && ( $action != "search" ) && !$error ): ?>do_alert( 1, "Delete Success" ) ;
		<?php elseif ( $error ): ?>do_alert( 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>
	});

	function open_transcript( theces, theopname )
	{
		var url = "../ops/op_trans_view.php?ces="+theces+"&id=<?php echo $admininfo["adminID"] ?>&auth=setup&"+unixtime() ;

		$( '#transcripts' ).find('*').each( function(){
			var div_name = this.id ;
			if ( div_name.indexOf("img_") != -1 )
				$(this).css({ 'opacity': 1 }) ;
		} );

		$('#img_'+theces).css({ 'opacity': '0.4' }) ;

		External_lib_PopupCenter( url, theces, <?php echo $VARS_CHAT_WIDTH+100 ?>, <?php echo $VARS_CHAT_HEIGHT+50 ?>, "scrollbars=yes,menubar=no,resizable=1,location=no,width=<?php echo $VARS_CHAT_WIDTH+100 ?>,height=<?php echo $VARS_CHAT_HEIGHT+50 ?>,status=0" ) ;
	}

	function switch_dept( theobject )
	{
		location.href = "transcripts.php?opid=<?php echo $opid ?>&deptid="+theobject.value+"&tid=<?php echo $tid ?>" ;
	}

	function switch_op( theobject )
	{
		location.href = "transcripts.php?deptid=<?php echo $deptid ?>&opid="+theobject.value+"&tid=<?php echo $tid ?>" ;
	}

	function switch_tag( thevalue )
	{
		location.href = "transcripts.php?deptid=<?php echo $deptid ?>&opid=<?php echo $opid ?>&tid="+thevalue ;
	}

	function input_text_listen_search( e )
	{
		var key = -1 ;
		var shift ;

		key = e.keyCode ;
		shift = e.shiftKey ;

		if ( !shift && ( ( key == 13 ) || ( key == 10 ) ) )
			$('#btn_page_search').click() ;
	}

	function show_div( thediv )
	{
		var divs = Array( "list", "encr", "export" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#transcripts_'+divs[c]).hide() ;
			$('#menu_trans_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
		}

		$('#transcripts_'+thediv).show() ;
		$('#menu_trans_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
	}

	function do_notice( thediv, theces, thecreated )
	{
		var pos = $('#tr_'+theces).position() ;
		var width = $('#tr_'+theces).outerWidth() ;
		var height = $('#tr_'+theces).outerHeight() - 8 ;

		global_ces = theces ; global_created = thecreated ;

		if ( $('#div_notice_'+thediv).is(':visible') )
			$('#div_notice_'+thediv).fadeOut( "fast", function() { show_div_notice(thediv, pos, width, height) ; }) ;
		else
			show_div_notice(thediv, pos, width, height) ;
	}

	function do_delete_doit()
	{
		if ( global_ces && global_created )
			location.href = "transcripts.php?tid=<?php echo $tid ?>&ces="+global_ces+"&created="+global_created+"&action=delete&index=<?php echo $index ?>&page=<?php echo $page ?>&deptid=<?php echo $deptid ?>&opid=<?php echo $opid ?>" ;
	}

	function show_div_notice( thediv, thepos, thewidth, theheight )
	{
		$('#div_notice_'+thediv).css({'top': thepos.top, 'left': thepos.left, 'width': thewidth, 'height': theheight}).fadeIn("fast") ;
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" onClick="location.href='transcripts.php'" id="menu_trans_list">Transcripts</div>
			<div class="op_submenu" onClick="location.href='transcripts_tags.php'" id="menu_trans_tags">Tags</div>
			<!-- <div class="op_submenu" onClick="show_div('encr')" id="menu_trans_encr">Encryption</div> -->
			<div class="op_submenu" id="menu_trans_export">Export</div>
			<div style="clear: both"></div>
		</div>

		<div id="transcripts_export" style="margin-top: 25px;">
			<div style="">
				<form method="POST" action="report_trans.php" id="form_theform" style="">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td>
						<select name="deptid" id="deptid" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_dept( this )">
						<option value="0">All Departments</option>
						<?php
							for ( $c = 0; $c < count( $departments ); ++$c )
							{
								$department = $departments[$c] ;
								$selected = ( $deptid == $department["deptID"] ) ? "selected" : "" ;
								print "<option value=\"$department[deptID]\" $selected>$department[name]</option>" ;
							}
						?>
						</select>
					</td> 
					<td><img src="../pics/space.gif" width="10" height=1></td>
					<td>
						<select name="opid" id="opid" style="font-size: 16px; background: #D4FFD4; color: #009000;" OnChange="switch_op( this )">
						<option value="0">All Operators</option>
						<?php
							for ( $c = 0; $c < count( $operators ); ++$c )
							{
								$operator = $operators[$c] ;
								$selected = ( $opid == $operator["opID"] ) ? "selected" : "" ;
								print "<option value=\"$operator[opID]\" $selected>$operator[name]</option>" ;
							}
						?>
						</select>
					</td>
				</tr>
				</table>
				</form>
			</div>

			<div style="margin-top: 15px;">Export transcripts</div>

			<div style="margin-top: 25px;"></div>
		</div>

<?php include_once( "./inc_footer.php" ) ?>
