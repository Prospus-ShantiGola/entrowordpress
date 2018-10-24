<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;

	$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;

	$theme = $CONF["THEME"] ;

	$requestinfo = Chat_get_RequestHistCesInfo( $dbh, $ces ) ;
	$operator = Ops_get_OpInfoByID( $dbh, $requestinfo["opID"] ) ;
	$department = Depts_get_DeptInfo( $dbh, $deptid ) ;

	$os = "" ; $browser = "" ;
	if ( isset( $requestinfo["ces"] ) )
	{
		$os = "(".$VARS_OS[$requestinfo["os"]].")" ;
		$browser = "(".$VARS_BROWSER[$requestinfo["browser"]].")" ;
		$duration = $requestinfo["ended"] - $requestinfo["created"] ;
		if ( $duration < 60 )
			$duration = 60 ;
		if ( !$requestinfo["ended"] ) { $duration = "" ; }
		else { $duration = Util_Format_Duration( $duration ) ; }

		$tags = isset( $VALS['TAGS'] ) ? unserialize( $VALS['TAGS'] ) : Array() ;
		$tag_string = "" ;
		if ( isset( $requestinfo["tag"] ) && isset( $tags[$requestinfo["tag"]] ) )
		{
			LIST( $status, $color, $tag ) = explode( ",", $tags[$requestinfo["tag"]] ) ;
			$tag_string = rawurldecode( $tag ) ;
		}
	}
	else
	{
		database_mysql_close( $dbh ) ;
		print "Invalid action;" ; exit ;
	}

	if ( isset( $department["lang"] ) && $department["lang"] )
		$CONF["lang"] = $department["lang"] ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($CONF["lang"], "ln").".php" ) ;

	$output = UtilChat_ExportChat( "$ces.txt" ) ;
	if ( count( $output ) <= 0 )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;

		$transcript = Chat_ext_get_Transcript( $dbh, $ces ) ;
		$output[] = $transcript["formatted"] ;
		$output[] = $transcript["plain"] ;
	}

	if ( isset( $output[0] ) )
		$output[0] = preg_replace( "/\"/", "&quot;", preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", $output[0] ) ) ;

	$dept_emo = ( isset( $VALS["EMOS"] ) ) ? unserialize( $VALS["EMOS"] ) : Array() ;
	$addon_emo = 0 ;
	if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/emoticons/emoticons.php" ) )
	{
		if ( !isset( $dept_emo[$deptid] ) || ( isset( $dept_emo[$deptid] ) && $dept_emo[$deptid] ) ) { $addon_emo = 1 ; }
		else if ( isset( $dept_emo[$deptid] ) && !$dept_emo[$deptid] ) { $addon_emo = 0 ; }
		else if ( !isset( $dept_emo[0] ) || ( isset( $dept_emo[0] ) && $dept_emo[0] ) ) { $addon_emo = 1 ; }
	}

	$custom_string = "" ;
	if ( $requestinfo["custom"] )
	{
		$customs = explode( "-cus-", $requestinfo["custom"] ) ;
		for ( $c = 0; $c < count( $customs ); ++$c )
		{
			$custom_var = $customs[$c] ;
			if ( $custom_var && preg_match( "/-_-/", $custom_var ) )
			{
				LIST( $cus_name, $cus_val ) = explode( "-_-", rawurldecode( $custom_var ) ) ;
				if ( $cus_val )
				{
					$custom_string .= "<div>$cus_name: <b>$cus_val</b></div>" ;
				}
			}
		}
	}
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> Print Chat Transcript </title>

<meta name="description" content="PHP Live! Support <?php echo $VERSION ?>">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=<?php echo $LANG["CHARSET"] ?>"> 
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../themes/initiate/transcript.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/global_chat.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	var base_url = ".." ;
	var widget ;

	var addon_emo = <?php echo $addon_emo ?> ;

	$(document).ready(function()
	{
		var transcript = init_timestamps( "<?php echo $output[0] ?>" ) ;
		$('#chat_transcript').html( transcript.emos() ) ;
		window.focus() ;
	});

	function do_print()
	{
		$('#chat_body').focus() ;
		window.print() ;
	}
//-->
</script>
</head>
<body id="chat_body" style="overflow: auto; padding: 0px;">
<div id="chat_options">
	<div style="margin-bottonm: 10px;" class="info_box">
		<div id="options_print" style="cursor: pointer; font-size: 16px; font-weight: bold;" onClick="do_print()"><img src="../themes/initiate/printer.png" width="16" height="16" border="0" alt=""> <?php echo $LANG["CHAT_PRINT"] ?></div>
	</div>
	<div class="cn">
		<table cellspacing=0 cellpadding=2 border=0>
		<tr>
			<td nowrap><?php echo $LANG["CHAT_CHAT_WITH"] ?></td>
			<td><span class="text_operator" style="font-weight: bold;"><?php echo $operator["name"] ?></span> - <span class="text_department" style="font-weight: bold;"><?php echo $department["name"] ?></span></td>
		</tr>
		<tr>
			<td style="padding-top: 15px;">Chat ID:</td>
			<td style="padding-top: 15px;"><?php echo $ces ?></td>
		</tr>
		<tr>
			<td>Created:</td>
			<td><?php echo date( "M j, Y, $VARS_TIMEFORMAT", $requestinfo["created"] ) ; ?></td>
		</tr>
		<tr>
			<td>Visitor:</td>
			<td><?php echo $requestinfo["vname"] ?> <?php echo ( $requestinfo["vemail"] && ( ( $requestinfo["vemail"] != "null" ) && ( $requestinfo["vemail"] != "invalid" ) ) ) ? "&lt;$requestinfo[vemail]&gt;" : "" ; ?></td>
		</tr>
		<tr>
			<td>Operator:</td>
			<td><?php echo $operator["name"] ?> &lt;<?php echo $operator["email"] ?>&gt;</td>
		</tr>
		<tr>
			<td>Duration:</td>
			<td><?php echo $duration ?></td>
		</tr>
		<?php if ( $tag_string ): ?>
		<tr>
			<td>Tag:</td>
			<td><?php echo $tag_string ?></td>
		</tr>
		<?php endif ; ?>
		<?php if ( $custom_string ): ?>
		<tr>
			<td>Custom Vars:</td>
			<td>
				<div><?php echo $custom_string ?></div>
			</td>
		</tr>
		<?php endif ; ?>
		</table>
	</div>
</div>
<div id="chat_transcript"></div>

</body>
</html>
<?php database_mysql_close( $dbh ) ; ?>