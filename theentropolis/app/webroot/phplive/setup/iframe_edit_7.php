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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$page = Util_Format_Sanatize( Util_Format_GetVar( "page" ), "n" ) ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$option = Util_Format_Sanatize( Util_Format_GetVar( "option" ), "n" ) ;
	$sub = Util_Format_Sanatize( Util_Format_GetVar( "sub" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$bgcolor = Util_Format_Sanatize( Util_Format_GetVar( "bgcolor" ), "ln" ) ;

	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
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
		$("body").css({'background-color': '#FFFFFF'}) ;

		<?php if ( ( $action === "update" ) && !$error ): ?>
		parent.do_alert( 1, "Success" ) ;
		<?php elseif ( $error ): ?>
		parent.do_alert( 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>
	});
//-->
</script>
</head>
<body style="overflow: hidden;">

<div id="iframe_body" style="height: 390px; overflow: hidden; <?php echo ( $bgcolor ) ? "background: #$bgcolor;" : "" ?>">
	<div style="">As a default, the system will utilize the standard PHP mail() function using the web server mail settings to send out emails (transcripts, offline messages, etc).  However, if the department SMTP values are provided, emails will be sent using the external SMTP provider.</div>

	<div style="margin-top: 15px;">
	<?php if ( is_file( "../addons/smtp/smtp.php" ) ): ?>
		<img src="../pics/icons/info.png" width="12" height="12" border="0" alt="enabled"> SMTP settings can be updated from the <a href="../addons/smtp/smtp.php?deptid=<?php echo $deptid ?>" target="_parent">Extras-&gt;SMTP</a> area.
	<?php else: ?>
		<img src="../pics/icons/info.png" width="12" height="12" border="0" alt=""> Currently, the chat transcripts, offline messages and other system email messages are sent using the standard PHP mail() function with the web server mail settings.  To send emails using an external SMTP server, visit the <a href="http://www.phplivesupport.com/r.php?r=smtp" target="_blank">SMTP documentations</a> page for more information about the SMTP addon.
	<?php endif ; ?>
	</div>
</div>

</body>
</html>