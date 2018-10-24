<?php
	include_once( "../web/config.php" ) ;
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> Mobile App Settings </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 
<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height" />

<link rel="Stylesheet" href="../css/setup.css?<?php echo $VERSION ?>">
<link rel="Stylesheet" href="../mapp/css/mapp.css?<?php echo $VERSION ?>">

<script data-cfasync="false" type="text/javascript">
<!--
	var mapp_settings = 1 ;
	setTimeout(function(){
		document.getElementById('div_notice').style.display = "block" ;
	}, 1400) ;
//-->
</script>
</head>
<body>
	<div id="div_notice" style="display: none; padding: 25px;">
		Please login from the Mobile App.
		<div style="margin-top: 15px;">or login as the <a href="../index.php?menu=sa">Setup Admin</a></div>
	</div>
</body>
</html>
