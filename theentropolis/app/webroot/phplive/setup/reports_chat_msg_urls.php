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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Messages/get.php" ) ;

	$error = "" ;

	$urls = Messages_get_MessageURLs( $dbh, 0 ) ;
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
	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		init_menu() ;
		toggle_menu_setup( "rchats" ) ;
	});
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" style="margin-left: 0px;" onClick="location.href='reports_chat.php'">Chat Reports</div>
			<div class="op_submenu" onClick="location.href='reports_chat_active.php'">Active Chats (<?php echo count( $t_requests ) ?>)</div>
			<div class="op_submenu" onClick="location.href='reports_chat_missed.php'">Missed Chats</div>
			<div class="op_submenu_focus">Offline Messages</div>
			<!-- <div class="op_submenu" onClick="location.href='reports_chat_queue.php'">Waiting Queue</div> -->
			<div style="clear: both"></div>
		</div>

		<div style="margin-top: 25px;">
				<div class="op_submenu2" style="margin-left: 0px;" onClick="location.href='reports_chat_msg.php'">Offline Messages</div>
				<div class="op_submenu_focus">Message URLs</div>
				<div style="clear: both"></div>
		</div>

		<div style="margin-top: 25px; max-height: 400px; overflow: auto;">
			<table cellspacing=0 cellpadding=0 border=0 width="100%"><tr><td width="16"><div class="td_dept_header">Total</div></td><td width="100%"><div class="td_dept_header">URL the visitor was viewing when they sent the offline message</div></td></tr>
			<?php
				for ( $c = 0; $c < count( $urls ); ++$c )
				{
					$url = $urls[$c] ;
					print "<tr><td class=\"td_dept_td\" width=\"16\">$url[total]</td><td class=\"td_dept_td\" width=\"100%\"><a href=\"$url[onpage]\" target=_blank>$url[onpage]</a></td></tr>" ;
				}
			
				if ( !count( $urls ) )
					print "<tr><td class=\"td_dept_td\" colspan=2>Blank results.</td></tr>" ;
			?>
			</table>
		</div>

<?php include_once( "./inc_footer.php" ) ?>
