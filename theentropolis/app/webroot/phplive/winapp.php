<?php
	include_once( "./web/config.php" ) ;
	include_once( "./inc_doctype.php" )
?>
<!--
********************************************************************
* PHP Live! (c) OSI Codes Inc.
* www.phplivesupport.com
********************************************************************
-->
<head>
<title> PHP Live! WinApp </title>

<meta name="author" content="osicodesinc">
<meta name="description" content="PHP Live! Support WinApp">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8">
<?php include_once( "./inc_meta_dev.php" ) ; ?>

<script data-cfasync="false" type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/winapp.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	$(document).ready(function()
	{
		if ( ( typeof( window.external ) != "undefined" ) && ( typeof( window.external.wp_save_history ) == "unknown" ) )
		{
			window.external.wp_save_history( location.href.replace( /index.php.+/i, "winapp.php" ) ) ;
			wp_total_visitors( 0 ) ;

			location.href = "index.php?wp=1" ;
		}
		else
			$('#error').show() ;
	});
//-->
</script>
</head>
<body style="background: #FFFFFF; padding: 25px; font-size: 12px; font-family: arial;">

<div style="display: none;"> [winapp=4] [winapp=5x] [winapp=5xx] </div>
<div id="error" style="display: none;">The URL should be accessed from the WinApp application.  <a href="./index.php">Continue to standard login screen.</a></div>

</body>
</html>