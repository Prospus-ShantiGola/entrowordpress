<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	include_once( "./web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/addons/file_attach/API/Util_Upload_File.php" ) ;

	$error = 0 ;
	$filename = "" ;

	$filename = Util_Format_Sanatize( Util_Format_GetVar( "file" ), "ln" ) ;
	$filename_ = $filename ;

	if ( is_file( "$CONF[DOCUMENT_ROOT]/web/file_attach/$filename" ) )
		$filename = "$CONF[BASE_URL]/web/file_attach/$filename" ;
	else if ( isset( $CONF_EXTEND ) && is_file( "$CONF[DOCUMENT_ROOT]/web/$CONF_EXTEND/file_attach/$filename" ) )
		$filename = "$CONF[BASE_URL]/web/$CONF_EXTEND/file_attach/$filename" ;
	else
	{
		if ( is_file( "$CONF[ATTACH_DIR]/$filename" ) )
		{
			$image_path = "$CONF[ATTACH_DIR]/$filename" ;
			if ( preg_match( "/\.pdf$/i", $filename ) )
				$image_type = 20 ;
			else if ( preg_match( "/((\.txt)|(\.text))$/i", $filename ) )
				$image_type = 21 ;
			else if ( preg_match( "/\.conf$/i", $filename ) )
				$image_type = 22 ;
			else if ( preg_match( "/\.zip$/i", $filename ) )
				$image_type = 23 ;
			else if ( preg_match( "/\.tar$/i", $filename ) )
				$image_type = 24 ;
			else
				$image_type = exif_imagetype( $image_path ) ;

			$filename = Util_Upload_Output( $image_path, $image_type ) ;
			if ( !$filename )
				$error = 1 ;
		}
		else
			$error = 1;
	}

	if ( !$error && preg_match( "/\.pdf/i", $filename_ ) && !preg_match( "/data:application/i", $filename ) )
	{
		HEADER( "location: $filename" ) ;
		exit ;
	}
?>
<?php include_once( "$CONF[DOCUMENT_ROOT]/inc_doctype.php" ) ?>
<head>
<title> File Upload </title>
<meta name="author" content="osicodesinc">
<meta name="mapp" content="active">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 
<?php include_once( "$CONF[DOCUMENT_ROOT]/inc_meta_dev.php" ) ; ?>
<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height" />

<link rel="Stylesheet" href="./css/setup.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript">
<!--
	$(document).ready(function()
	{
		resize_object_height() ;
	});
	$(window).resize(function( ) {
		resize_object_height() ;
	});

	function resize_object_height()
	{
		var height = $( window ).height() ;
		var object_height = height - 155 ;
		$('#div_pdf_object').css({'height': object_height}) ;
	}
//-->
</script>

</head>
<body style="font-family: Arial; font-size: 12px; background: #F0F0F0; padding: 50px; text-align: center;">

<?php if ( $error ): ?>
	<div style="display: inline-block;">
		<div class="info_error">File not found.</div>

		<div style="margin-top: 15px; font-size: 16px;"><?php echo $filename_ ?></div>
		<div style="margin-top: 25px;">The file has been deleted or does not exist.</div>
	</div>
<?php else: ?>
	<div style="font-size: 14px; font-face: arial;"><?php echo $filename_ ?></div>

	<?php if ( !$error && preg_match( "/\.pdf$/i", $filename_ ) && preg_match( "/data:application/i", $filename ) ): ?>
		<div style="margin-top: 15px;"><object id="div_pdf_object" data="<?php echo $filename ?>" type="application/pdf" style="width: 100%; height: 500px;"></object></div>
	<?php elseif ( !$error && preg_match( "/((\.txt)|(\.text))$/i", $filename_ ) ): ?>
		<div style="margin-top: 15px;"><a href="<?php echo $filename ?>" target="_blank" download><img src="./pics/icons/txt.gif" width="50" height="50" border="0" alt="" class="round"></a></div>
	<?php elseif ( !$error && preg_match( "/\.zip$/i", $filename_ ) ): ?>
		<div style="margin-top: 15px;"><a href="<?php echo $filename ?>" target="_blank" download><img src="./pics/icons/zip.gif" width="50" height="50" border="0" alt="" class="round"></a></div>
	<?php elseif ( !$error && preg_match( "/\.tar$/i", $filename_ ) ): ?>
		<div style="margin-top: 15px;"><a href="<?php echo $filename ?>" target="_blank" download><img src="./pics/icons/tar.gif" width="50" height="50" border="0" alt="" class="round"></a></div>
	<?php elseif ( !$error && preg_match( "/\.conf$/i", $filename_ ) ): ?>
		<div style="margin-top: 15px;"><a href="<?php echo $filename ?>" target="_blank" download><img src="./pics/icons/conf.gif" width="50" height="50" border="0" alt="" class="round"></a></div>
	<?php else: ?>
		<div style="margin-top: 15px;"><img src="<?php echo $filename ?>" style="max-width: 100%;" border=0></div>
	<?php endif ; ?>
<?php endif ; ?>

</body>
</html>