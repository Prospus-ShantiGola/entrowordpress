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
	else if ( $action === "requestinfo" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_itr.php" ) ;
	
		$ip = Util_Format_Sanatize( Util_Format_GetVar( "ip" ), "ln" ) ;
		$vis_token = Util_Format_Sanatize( Util_Format_GetVar( "vis_token" ), "ln" ) ;

		$requestinfo = Chat_get_itr_RequestGetInfo( $dbh, 0, "", $vis_token ) ;
		$total_trans = Chat_get_TotalIPTranscripts( $dbh, $vis_token ) ;

		if ( isset( $requestinfo["requestID"] ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;

			$opinfo = Ops_get_OpInfoByID( $dbh, $requestinfo["opID"] ) ;
			$json_data = "json_data = { \"status\": 1, \"name\": \"$opinfo[name]\", \"total_trans\": \"$total_trans\" }; " ;
		}
		else { $json_data = "json_data = { \"status\": 0, \"total_trans\": \"$total_trans\" }; " ; }
	}
	else { $json_data = "json_data = { \"status\": 0 };" ; }

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print $json_data ; exit ;
?>