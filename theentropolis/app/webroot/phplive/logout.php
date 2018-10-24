<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	if ( !is_file( "./web/config.php" ) ){ HEADER("location: ./setup/install.php") ; exit ; }
	include_once( "./web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ; 
	/* AUTO PATCH */
	$query = isset( $_SERVER["QUERY_STRING"] ) ? Util_Format_Sanatize( $_SERVER["QUERY_STRING"], "query" ) : "" ;
	if ( !is_file( "$CONF[CONF_ROOT]/patches/$patch_v" ) )
	{
		HEADER( "location: patch.php?from=index&".$query ) ; exit ;
	}
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($CONF["lang"], "ln").".php" ) ;
	/////////////////////////////////////////////
	if ( defined( "LANG_CHAT_WELCOME" ) || !isset( $LANG["CHAT_JS_CUSTOM_BLANK"] ) )
	{ ErrorHandler( 611, "Update to your custom language file is required ($CONF[lang]).  Copy an existing language file and create a new custom language file.", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$ao = Util_Format_Sanatize( Util_Format_GetVar( "ao" ), "n" ) ;
	$rd = Util_Format_Sanatize( Util_Format_GetVar( "rd" ), "n" ) ;
	$dup = Util_Format_Sanatize( Util_Format_GetVar( "dup" ), "n" ) ;
	$mi = Util_Format_Sanatize( Util_Format_GetVar( "mi" ), "n" ) ;
	$wid = Util_Format_Sanatize( Util_Format_GetVar( "wid" ), "n" ) ;
	$auto = Util_Format_Sanatize( Util_Format_GetVar( "auto" ), "n" ) ;
	$mapp = Util_Format_Sanatize( Util_Format_GetVar( "mapp" ), "n" ) ;
	$pop = Util_Format_Sanatize( Util_Format_GetVar( "pop" ), "n" ) ;
	$wp = Util_Format_Sanatize( Util_Format_GetVar( "wp" ), "n" ) ;
	$menu = ( Util_Format_Sanatize( Util_Format_GetVar( "menu" ), "ln" ) == "sa" ) ? "sa" : "operator" ;
	$wpress = Util_Format_Sanatize( Util_Format_GetVar( "wpress" ), "n" ) ;
	$now = time() ;
	$dn = 0 ;

	$agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : "&nbsp;" ;
	LIST( $os, $browser ) = Util_Format_GetOS( $agent ) ;
	$mobile = ( $os == 5 ) ? 1 : 0 ;

	if ( $action === "logout" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_itr.php" ) ;

		if ( $menu == "sa" )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_ext.php" ) ;

			if ( isset( $_COOKIE["phplive_adminID"] ) && $_COOKIE["phplive_adminID"] )
			{
				Ops_update_ext_AdminValue( $dbh, Util_Format_Sanatize( $_COOKIE["phplive_adminID"], "n" ), "ses", "" ) ;
				setcookie( "phplive_adminID", FALSE, -1, "/" ) ;
				setcookie( "phplive_adminSES", FALSE, -1, "/" ) ;
			}
			else
			{
				HEADER( "location: ./index.php?menu=sa&$now" ) ; exit ;
			}
		}
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;

			if ( isset( $_COOKIE["cO"] ) )
			{
				$opid = $_COOKIE["cO"] ;
				$opinfo = Ops_get_OpInfoByID( $dbh, $opid ) ;
				$opvars = Ops_get_OpVars( $dbh, $opid ) ;
				Ops_update_OpValue( $dbh, $opinfo["opID"], "signall", 0 ) ;

				if ( isset( $opvars["dn_response"] ) && ( $opvars["dn_response"] || $opvars["dn_request"] || $opvars["dn_always"] ) && ( $ao || $rd || $dup || $wid ) ) { $dn = 1 ; }
				if ( $rd )
				{
					Ops_update_OpValue( $dbh, Util_Format_Sanatize( $opid, "n" ), "ses", "" ) ;
					Ops_update_OpValue( $dbh, $opid, "mapp", 0 ) ;
				}
				if ( !$dup )
				{
					Ops_update_PutOpStatus( $dbh, Util_Format_Sanatize( $opid, "n" ), 0, 0 ) ;
					Ops_update_OpValue( $dbh, Util_Format_Sanatize( $opid, "n" ), "status", 0 ) ;
					Ops_update_OpValue( $dbh, $opid, "mapp", 0 ) ;
				}
				if ( $dup || $rd ) { setcookie( "cAT", FALSE, -1, "/" ) ; }
				// there may be cases of duplicate login.  check current mapp first before delete mapp file
				// - mapp => web
				// - web => mapp
				if ( !$opinfo["mapp"] && is_file( "$CONF[TYPE_IO_DIR]/$opid.mapp" ) ) { unlink( "$CONF[TYPE_IO_DIR]/$opid.mapp" ) ; }
				setcookie( "cO", FALSE, -1, "/" ) ;
			}
		}

		if ( !Ops_get_itr_AnyOpsOnline( $dbh, 0 ) )
		{
			$dir_files = glob( $CONF["TYPE_IO_DIR"]."/*", GLOB_NOSORT ) ;
			$total_dir_files = count( $dir_files ) ;
			if ( $total_dir_files )
			{
				for ( $c = 0; $c < $total_dir_files; ++$c )
				{
					if ( $dir_files[$c] && is_file( $dir_files[$c] ) && !preg_match( "/\.ses$/", $dir_files[$c] ) && !preg_match( "/index\.php$/", $dir_files[$c] ) ) { unlink( $dir_files[$c] ) ; }
				}
			}
		}
	}
?>
<?php include_once( "./inc_doctype.php" ) ?>
<?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?>
<!--
********************************************************************
* PHP Live! (c) OSI Codes Inc.
* www.phplivesupport.com
********************************************************************
-->
<?php endif ; ?>
<head>
<title> <?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?>Live Chat Solution<?php else: ?>PHP Live! Support<?php endif ; ?> v.<?php echo $VERSION ?> </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8">
<?php include_once( "./inc_meta_dev.php" ) ; ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link rel="Stylesheet" href="./css/setup.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="./js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/dn.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/winapp.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	"use strict" ;
	var loaded = 1 ;
	var logout = 1 ;
	var base_url = "." ;

	var dn_his ;
	var dn_status ;
	var dn_enabled_response = <?php echo $dn ?> ;
	var dn_enabled_request = <?php echo $dn ?> ;
	var dn_always = <?php echo $dn ?> ;
	var dn_counter = 0 ;
	var wp = ( ( typeof( window.external ) != "undefined" ) && ('wp_total_visitors' in window.external) ) ? 1 : 0 ;

	var focused = 0 ;

	$(document).ready(function()
	{
		$("body").show() ;

		<?php if ( $ao ): ?>$('#div_automatic_offline').show() ;
		<?php elseif ( $rd ): ?>$('#div_remote_disconnect').show() ;
		<?php elseif ( $dup ): ?>$('#div_duplicate_login').show() ;
		<?php elseif ( $mi ): ?>$('#div_mapp_idle').show() ;
		<?php elseif ( $wid ): ?>$('#div_winapp_idle').show() ;
		<?php endif ; ?>

		wp_logout();
		if ( typeof( parent.mapp ) != "undefined" )
		{
			var href = window.location.href.replace( /mapp=(\d)/, "mapp="+parent.mapp ) ;
			if ( href.match( /auto=/ ) ) { href = href.replace( /auto=(\d)/, "auto=1" ) ; }
			else { href = href+"&auto=1" ; }
			parent.location.href = href ;
		}
		else if ( wp || <?php echo $dn ?> )
		{
			// 5 hours of dn popup duration during WinApp idle logout to ensure
			// the message is seen of the automatic logout
			var dn_duration = 18000000 ;
			dn_show( 'logout', "logout", "System Alert", "You have been successfully logged out.", dn_duration ) ;
		}
	});
//-->
</script>
</head>
<body style="display: none; overflow: hidden;">

<div id="body" style="padding-bottom: 60px;">
	<div style="width: 100%; padding-top: 30px;">
		
		<div style="width: 280px; margin: 0 auto; padding: 10px; text-shadow: 1px 1px #FFFFFF;">

			<div style="display: none; text-shadow: none; margin-bottom: 15px;" class="info_error" id="div_automatic_offline">
				<img src="pics/icons/alert.png" width="16" height="16" border="0" alt=""> <span style='font-size: 14px; font-weight: bold;'>Automatic Offline</span>
				<div style="margin-top: 10px;">You have been automatically logged out because it is past regular chat support hours.</div>
			</div>
			<div style="display: none; text-shadow: none; margin-bottom: 15px;" class="info_error" id="div_remote_disconnect">
				<img src="pics/icons/alert.png" width="16" height="16" border="0" alt=""> <span style='font-size: 14px; font-weight: bold;'>Remote Disconnect</span>
				<div style="margin-top: 10px;">The Setup Admin has remote disconnected the operator console.</div>
			</div>
			<div style="display: none; text-shadow: none; margin-bottom: 15px;" class="info_error" id="div_duplicate_login">
				<img src="pics/icons/alert.png" width="16" height="16" border="0" alt=""> <span style='font-size: 14px; font-weight: bold;'>Duplicate Login</span>
				<div style="margin-top: 10px;">Operator account logged in at another location.  This session has expired.</div>
			</div>
			<div style="display: none; text-shadow: none; margin-bottom: 15px;" class="info_error" id="div_winapp_idle">
				<img src="pics/icons/alert.png" width="16" height="16" border="0" alt=""> <span style='font-size: 14px; font-weight: bold;'>Computer Idle</span>
				<div style="margin-top: 10px;">Computer is idle.  You have been automatically logged out.</div>
			</div>
			<div style="display: none; text-shadow: none; margin-bottom: 15px;" class="info_error" id="div_mapp_idle">
				<img src="pics/icons/alert.png" width="16" height="16" border="0" alt=""> <span style='font-size: 14px; font-weight: bold;'>Idle Mobile Application</span>
				<div style="margin-top: 10px;">You have been automatically logged out because the mobile application has not been accessed in <?php echo isset( $VALS["MOBILE_EXPIRED_OPS"] ) ? $VALS["MOBILE_EXPIRED_OPS"] : 10 ; ?> hours.</div>
			</div>

			<div style="font-size: 14px;" class="info_box">You have been successfully logged out.</div>

			<div id="div_back" style="margin-top: 15px; margin-bottom: 15px;"><img src="pics/icons/arrow_left.png" width="14" height="13" border="0" alt=""> <a href="./index.php?wp=<?php echo $wp ?>&auto=<?php echo $auto ?>&mapp=<?php echo $mapp ?>&menu=<?php echo $menu ?>&<?php echo $now ?>">back to login</a></div>

		</div>

	</div>
</div>

</body>
</html>
<?php
	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;
?>
