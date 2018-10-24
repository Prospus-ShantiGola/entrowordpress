<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	if ( !is_file( "./web/config.php" ) ){ HEADER("location: ./setup/install.php") ; exit ; }
	include_once( "./web/config.php" ) ;

	if ( !isset( $CONF['SQLTYPE'] ) ) { $CONF['SQLTYPE'] = "SQL.php" ; }
	else if ( $CONF['SQLTYPE'] == "mysql" ) { $CONF['SQLTYPE'] = "SQL.php" ; }

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;

	$from = Util_Format_Sanatize( Util_Format_GetVar( "from" ), "ln" ) ;
	$patch = Util_Format_Sanatize( Util_Format_GetVar( "patch" ), "n" ) ;
	$patch_c = Util_Format_Sanatize( Util_Format_GetVar( "patch_c" ), "n" ) ;
	$patched = 0 ;
	$loopy = Util_Format_Sanatize( Util_Format_GetVar( "loopy" ), "n" ) ;

	$query = isset( $_SERVER["QUERY_STRING"] ) ? Util_Format_Sanatize( $_SERVER["QUERY_STRING"], "query" ) : "" ;

	// basic check for permissions and gather ini settings
	$ini_open_basedir = ini_get("open_basedir") ;
	$ini_safe_mode = ini_get("safe_mode") ;
	$safe_mode = preg_match( "/on/i", $ini_safe_mode ) ? 1 : 0 ;

	if ( !is_file( "$CONF[DOCUMENT_ROOT]/blank.php" ) )
	{ ErrorHandler( 612, "\$CONF[DOCUMENT_ROOT] variable in config.php is invalid.", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	else if ( !is_writeable( "$CONF[CONF_ROOT]/" ) )
	{ ErrorHandler( 609, "Permission denied on web/ directory. ($ini_open_basedir, $ini_safe_mode, $safe_mode)", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	else if ( !is_writeable( "$CONF[CONF_ROOT]/config.php" ) )
	{ ErrorHandler( 609, "Permission denied on web/config.php directory. ($ini_open_basedir, $ini_safe_mode, $safe_mode)", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	else if ( !is_writeable( "$CONF[CONF_ROOT]/patches/" ) )
	{ ErrorHandler( 609, "Permission denied on web/patches/ directory. ($ini_open_basedir, $ini_safe_mode, $safe_mode)", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	else if ( !is_writeable( $CONF["CHAT_IO_DIR"] ) )
	{ ErrorHandler( 609, "Permission denied on web/chat_sessions directory. ($ini_open_basedir, $ini_safe_mode, $safe_mode)", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	else if ( !is_writeable( $CONF["TYPE_IO_DIR"] ) )
	{ ErrorHandler( 609, "Permission denied on web/chat_initiate directory. ($ini_open_basedir, $ini_safe_mode, $safe_mode)", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	else if ( !is_writeable( "$CONF[CONF_ROOT]/vals.php" ) )
	{ ErrorHandler( 609, "Permission denied on web/vals.php file. ($ini_open_basedir, $ini_safe_mode, $safe_mode)", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	$dir_patches_perm = is_writeable( "$CONF[CONF_ROOT]/patches/" ).substr( sprintf( '%o', fileperms("$CONF[CONF_ROOT]/patches/") ), -4 )."" ;
	if ( !is_dir( "$CONF[ATTACH_DIR]" ) ) { mkdir( "$CONF[ATTACH_DIR]", 0777 ) ; }

	if ( $from == "chat" )
		$url = "phplive.php?patched=1&".$query ;
	else if ( $from == "embed" )
		$url = "phplive_embed.php?patched=1&".$query ;
	else if ( $from == "setup" )
		$url = "setup/index.php?patched=1&".$query ;
	else
		$url = "index.php?patched=1&".$query ;

	if ( !is_writeable( "$CONF[ATTACH_DIR]/" ) )
	{ ErrorHandler( 609, "Permission denied on web/file_attach/ directory. ($ini_open_basedir, $ini_safe_mode, $safe_mode)", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }

	$fast_file = ( isset( $FAST_PATCH  ) && $FAST_PATCH  ) ? "_fast" : "" ;
	if ( $patch )
	{
		if ( !is_file( "$CONF[CONF_ROOT]/patches/$patch_v" ) )
		{
			if ( $patch_c <= 51 ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Patches/Util_Patches_1".$fast_file.".php" ) ; }
			else if ( $patch_c <= 85 ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Patches/Util_Patches_2".$fast_file.".php" ) ; }
			else if ( $patch_c <= 140 ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Patches/Util_Patches_3".$fast_file.".php" ) ; }
			else { include_once( "$CONF[DOCUMENT_ROOT]/API/Patches/Util_Patches_4".$fast_file.".php" ) ; }
			$qc = isset( $dbh['qc'] ) ? $dbh['qc'] : 0 ;
			$json_data = "json_data = { \"status\": 0, \"patch_c\": $patched, \"qc\": $qc };" ;
		}
		else
		{
			$json_data = "json_data = { \"status\": 1 };" ;
		}

		if ( isset( $dbh ) && isset( $dbh['con'] ) ) { database_mysql_close( $dbh ) ; }
		print $json_data ; exit ;
	}
	else
	{
		$index_file = "$CONF[DOCUMENT_ROOT]/files/index.php" ;
		if ( !is_file( "$CONF[CONF_ROOT]/index.php" ) ) { copy( $index_file, "$CONF[CONF_ROOT]/index.php" ) ; }
		if ( !is_file( "$CONF[CHAT_IO_DIR]/index.php" ) ) { copy( $index_file, "$CONF[CHAT_IO_DIR]/index.php" ) ; }
		if ( !is_file( "$CONF[TYPE_IO_DIR]/index.php" ) ) { copy( $index_file, "$CONF[TYPE_IO_DIR]/index.php" ) ; }
		if ( !is_file( "$CONF[ATTACH_DIR]/index.php" ) ) { copy( $index_file, "$CONF[ATTACH_DIR]/index.php" ) ; }
	}
?>
<?php include_once( "./inc_doctype.php" ) ?>
<head>
<title> PHP Live! Support </title>

<meta name="description" content="PHP Live! Support <?php echo $VERSION ?>">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8">
<?php include_once( "./inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="./css/setup.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="./js/global.js?<?php echo filemtime ( "./js/global.js" ) ; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	var patch_c = 0 ;
	var loader_c ;
	var dev = 0 ; var dev_c = 0 ; var total_qc = 0 ;
	var si_loader ;

	var patch_interval = ( "$fast_file" == "_fast" ) ? 3000 : 1200 ;

	$(document).ready(function()
	{
		$.ajaxSetup({ cache: false }) ;

		auto_patch() ;
		init_loader_image() ;
	});

	function init_loader_image()
	{
		si_loader = setInterval( function(){
			loader_c_temp = Math.floor(Math.random() * 3) + 1 ;
			if ( loader_c_temp != loader_c )
			{
				loader_c = loader_c_temp ;
				if ( loader_c == 1 )
				{
					$('#image_1').show() ;
					$('#image_2').hide() ;
					$('#image_3').hide() ;
				}
				else if ( loader_c == 2 )
				{
					$('#image_2').show() ;
					$('#image_1').hide() ;
					$('#image_3').hide() ;
				}
				else
				{
					$('#image_3').show() ;
					$('#image_1').hide() ;
					$('#image_2').hide() ;
				}
			}
		}, 1000 ) ;
	}

	function auto_patch()
	{
		var json_data = new Object ;
		var unique = unixtime() ;

		$.ajax({
		type: "POST",
		url: "./patch.php",
		data: "patch=1&patch_c="+patch_c+"&unique="+unique,
		success: function(data){
			try {
				eval(data) ;
			} catch(err) {
				$('#div_error_output').html( data ).show() ;
				return false ;
			}

			patch_c = json_data.patch_c ;

			if ( json_data.status )
			{
				if ( dev && ( dev_c < 100 ) )
				{
					++dev_c ; patch_c = dev_c ;
					var percent = Math.round( ( patch_c/100 )*100 ) ;
					$('#status').html( percent ) ;
					total_qc += Math.floor(Math.random() * (4 - 1)) + 1 ;
					$('#process_id').html( pad( patch_c, 3 ) ) ; $('#process_db').html( pad( total_qc, 3 ) ) ;
					setTimeout( function(){ patch_c += 1 ; auto_patch() ; }, patch_interval ) ;
				}
				else
				{
					$('#status').html( 100 ) ;
					$('#process').html( total_qc ) ;
					$('#img_loading').hide() ;
					$('#div_stats').hide() ;
					$('#div_success').show() ;

					clearInterval( si_loader ) ;

					if ( "<?php echo $from ?>" == "chat" )
					{
						setTimeout( function(){ do_redirect() ; }, 3000 ) ;
					}
					else
					{
						setTimeout( function(){ do_redirect() ; }, 45000 ) ;
					}
				}
			}
			else
			{
				var percent = Math.round( ( patch_c/<?php echo $patch_v ?> )*100 ) ;
				$('#status').html( percent ) ;
				total_qc += parseInt( json_data.qc ) ;
				$('#process_id').html( pad( patch_c, 3 ) ) ; $('#process_db').html( pad( total_qc, 3 ) ) ;
				setTimeout( function(){ patch_c += 1 ; auto_patch() ; }, patch_interval ) ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			do_alert( 0, "Error patch "+patch_c+" process.  Please refresh the page and try again." ) ;
		} });
	}

	function do_redirect()
	{
		location.href = "<?php echo $url ?>" ;
	}
//-->
</script>
</head>
<body style="overflow: hidden;">

<div style="width: 310px; margin: 0 auto; margin-top: 25px; padding: 10px;">

	<div id="div_configure" style="text-align: center;">
		<div style=""><?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?><img src="pics/logo.png" width="160" height="39" border=0 style=""><?php endif ; ?></div>
		<div style="margin-top: 15px;">
			<div id="div_configuring" style="padding-top: 15px; padding-bottom: 15px; text-shadow: none;" class="info_box round">
				<div>Configuring and updating the system <img src="pics/loading_ci.gif" width="16" height="16" border="0" alt="" id="img_loading" style="background: #FFFFFF; padding: 4px;" class="round"></div>
				<div style="margin-top: 15px; font-size: 24px; font-weight: bold;"><span id="status">1</span>%</div>
			</div>
		</div>

		<div id="div_success" style="display: none; margin-top: 15px;">
			<button type="button" class="btn" onClick="do_redirect()" style="width: 100%;">Continue and Login</button>
		</div>
	</div>

</div>
<div id="div_stats" style="display: none; text-align: center; width: 310px; margin: 0 auto; text-shadow: none; font-size: 10px;">
	<div>pid: <span id="process_id">0</span> &nbsp; &nbsp; db: <span id="process_db">0</span> &nbsp; &nbsp; <?php echo $dir_patches_perm ?></div>
</div>

<div id="div_error_output" class="info_error" style="display: none; width: 600px; margin: 0 auto; margin-top: 25px;"></div>
</div>

<!-- [winapp=4] -->

</body>
</html>
<?php
	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;
?>