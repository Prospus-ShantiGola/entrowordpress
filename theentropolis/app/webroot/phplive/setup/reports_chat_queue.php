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

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$jump = Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ; if ( !$jump ) { $jump = "main" ; }

	$departments = Depts_get_AllDepts( $dbh ) ;

	if ( $action === "update" )
	{
	}

	// make hash for quick refrence
	$dept_hash = Array() ;
	for ( $c = 0; $c < count( $departments ); ++$c )
	{
		$department = $departments[$c] ;
		$dept_hash[$department["deptID"]] = $department["name"] ;
	}

	$t_requests = Chat_ext_get_AllRequests( $dbh, 0 ) ;
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
	var jump = "<?php echo $jump ?>" ;

	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		init_menu() ;
		toggle_menu_setup( "rchats" ) ;

		<?php if ( $action && !$error ): ?>do_alert(1, "Success") ;<?php endif ; ?>
	});
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" onClick="location.href='reports_chat.php'">Chat Reports</div>
			<div class="op_submenu" onClick="location.href='reports_chat_active.php'">Active Chats (<?php echo count( $t_requests ) ?>)</div>
			<div class="op_submenu" onClick="location.href='reports_chat_missed.php'">Missed Chats</div>
			<div class="op_submenu" onClick="location.href='reports_chat_msg.php'">Offline Messages</div>
			<div class="op_submenu_focus">Waiting Queue</div>
			<div style="clear: both"></div>
		</div>

		<div id="queue_main" style="margin-top: 25px;">
			<div class="info_error" style="display: inline-block; margin-bottom: 25px;">Queue reports feature coming soon.</div>
			<table cellspacing=0 cellpadding=0 border=0 width="100%">
			<tr>
				<td width="100%"><div class="td_dept_header">Department</div></td>
				<td width="200" nowrap><div class="td_dept_header">Visitors Stayed in Queue</div></td>
				<td width="200" nowrap><div class="td_dept_header">Visitors Abandoned Queue</div></td>
				<td width="200" nowrap><div class="td_dept_header">Visitors in Queue (average)</div></td>
			</tr>
			<?php
				for( $c = 0; $c < count( $departments ); ++$c )
				{
					$department = $departments[$c] ;
					print "<tr>
						<td class=\"td_dept_td\"><b>$department[name]</b></td>
						<td class=\"td_dept_td\" style=\"text-align: center;\">-</td>
						<td class=\"td_dept_td\" style=\"text-align: center;\">-</td>
						<td class=\"td_dept_td\" style=\"text-align: center;\">-</td>
					</tr>" ;
				}
			?>
			</table>
		</div>

<?php include_once( "./inc_footer.php" ) ?>