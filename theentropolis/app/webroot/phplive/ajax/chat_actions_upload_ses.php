<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$opid = isset( $_COOKIE["cO"] ) ? Util_Format_Sanatize( $_COOKIE["cO"], "n" ) : "" ;
	$ses = isset( $_COOKIE["cS"] ) ? Util_Format_Sanatize( $_COOKIE["cS"], "ln" ) : "" ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;

	if ( !$opid || !is_file( "$CONF[TYPE_IO_DIR]/$opid"."_ses_$ses.ses" ) )
		$json_data = "json_data = { \"status\": -1 };" ;
	else if ( $action === "ses" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;

		$opinfo = Ops_get_OpInfoByID( $dbh, $opid ) ;
		if ( isset( $opinfo["opID"] ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;

			$now = time() ;
			$upload_ses = md5( $now.$ses ) ;
			Ops_update_OpVarValue( $dbh, $opid, "upload_ses", $now ) ;
			$json_data = "json_data = { \"status\": 1, \"ses\": \"$upload_ses\", \"token\": $now };" ;
		}
		else
			$json_data = "json_data = { \"status\": 0 };" ;
	}
	else
		$json_data = "json_data = { \"status\": 0 };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print $json_data ; exit ;
?>