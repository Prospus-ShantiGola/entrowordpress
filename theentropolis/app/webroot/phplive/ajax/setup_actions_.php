<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	if ( !$setupinfo = Util_Security_AuthSetup( $dbh ) ){ $json_data = "json_data = { \"status\": 0, \"error\": \"Authentication error.\" };" ; exit ; }
	// STANDARD header end
	/****************************************/

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	if ( $action === "update_profile_pic_onoff" )
	{
		$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
		$value = Util_Format_Sanatize( Util_Format_GetVar( "value" ), "n" ) ;

		if ( $opid )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;
			Ops_update_OpValue( $dbh, $opid, "pic", $value ) ;
		}
		$json_data = "json_data = { \"status\": 1 };" ;
	}
	if ( $action === "update_pic_edit" )
	{
		$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
		$value = Util_Format_Sanatize( Util_Format_GetVar( "value" ), "n" ) ;
		$flag = Util_Format_Sanatize( Util_Format_GetVar( "flag" ), "n" ) ;

		if ( $opid )
		{
			if ( $flag )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;
				Ops_update_OpVarValue( $dbh, $opid, "pic_edit", $value ) ;
			}
			else
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put.php" ) ;
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;
				Ops_put_OpVars( $dbh, $opid ) ;
				Ops_update_OpVarValue( $dbh, $opid, "pic_edit", $value ) ;
			}
		}
		$json_data = "json_data = { \"status\": 1 };" ;
	}
	else if ( $action === "save_mapp_key" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

		$mkey = Util_Format_Sanatize( Util_Format_GetVar( "mkey" ), "ln" ) ;

		Util_Vals_WriteToConfFile( "MAPP_KEY", $mkey ) ;
		$json_data = "json_data = { \"status\": 1 };" ;
	}
	else if ( $action === "tag" )
	{
		$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "ln" ) ;
		$tagid = Util_Format_Sanatize( Util_Format_GetVar( "tagid" ), "n" ) ;

		$tags = isset( $VALS['TAGS'] ) ? unserialize( $VALS['TAGS'] ) : Array() ;
		if ( $ces && ( isset( $tags[$tagid] ) || !$tagid ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;

			Chat_update_RequestLogValue( $dbh, $ces, "tag", $tagid ) ;
			Chat_update_TranscriptValue( $dbh, $ces, "tag", $tagid ) ;
			$json_data = "json_data = { \"status\": 1 }; " ;
		}
		else
			$json_data = "json_data = { \"status\": 0, \"error\": \"A chat session must be active.\" }; " ;
	}
	else if ( $action == "update_upmax" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
		$upmax_days = Util_Format_Sanatize( Util_Format_GetVar( "days" ), "n" ) ;
		$upmax_bytes = Util_Format_Sanatize( Util_Format_GetVar( "bytes" ), "n" ) ;

		$upload_max_filesize = ini_get( "upload_max_filesize" ) ;
		$upload_max_post = ini_get( "post_max_size" ) ;

		if ( $upload_max_filesize && preg_match( "/k/i", $upload_max_filesize ) )
		{
			$temp = Util_Format_Sanatize( $upload_max_filesize, "n" ) ;
			$max_bytes = $temp * 1000 ;
		}
		else if ( $upload_max_filesize && preg_match( "/m/i", $upload_max_filesize ) )
		{
			$temp = Util_Format_Sanatize( $upload_max_filesize, "n" ) ;
			$max_bytes = $temp * 1000000 ;
		}
		else if ( $upload_max_filesize && preg_match( "/g/i", $upload_max_filesize ) )
		{
			$temp = Util_Format_Sanatize( $upload_max_filesize, "n" ) ;
			$max_bytes = $temp * 1000000000 ;
		}
		else { $max_bytes = 500000 ; }

		if ( $upload_max_post && preg_match( "/k/i", $upload_max_post ) )
		{
			$temp = Util_Format_Sanatize( $upload_max_post, "n" ) ;
			$max_post_bytes = $temp * 1000 ;
		}
		else if ( $upload_max_post && preg_match( "/m/i", $upload_max_post ) )
		{
			$temp = Util_Format_Sanatize( $upload_max_post, "n" ) ;
			$max_post_bytes = $temp * 1000000 ;
		}
		else if ( $upload_max_post && preg_match( "/g/i", $upload_max_post ) )
		{
			$temp = Util_Format_Sanatize( $upload_max_post, "n" ) ;
			$max_post_bytes = $temp * 1000000000 ;
		}
		else if ( $upload_max_post ) { $max_post_bytes = $upload_max_post ; }

		$upmax_array = Array() ;
		$upmax_array['days'] = $upmax_days ;
		$temp = ( $upmax_bytes > $max_bytes ) ? $max_bytes : $upmax_bytes ;
		$upmax_array['bytes'] = ( $upload_max_post && ( $temp > $max_post_bytes ) ) ? $max_post_bytes : $temp ;

		Util_Vals_WriteToFile( "UPLOAD_MAX", serialize( $upmax_array ) ) ;
		$json_data = "json_data = { \"status\": 1 }; " ;
	}
	else
		$json_data = "json_data = { \"status\": 0, \"error\": \"Invalid action. [a2]\" };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print $json_data ; exit ;
?>