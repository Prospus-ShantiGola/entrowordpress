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
	else if ( $action === "cans" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/get.php" ) ;

		$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;

		$cans = Canned_get_OpCanned( $dbh, $opid, $deptid ) ;
		$json_data = "json_data = { \"status\": 1, \"cans\": [  " ;
		for ( $c = 0; $c < count( $cans ); ++$c )
		{
			$can = $cans[$c] ;
			$title = Util_Format_ConvertQuotes( $can["title"] ) ;
			$message = Util_Format_ConvertQuotes( preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", $can["message"] ) ) ;
			$message = preg_replace( "/▒~@▒/", "", $message ) ;

			$json_data .= "{ \"canid\": $can[canID], \"deptid\": $can[deptID], \"title\": \"$title\", \"message\": \"$message\" }," ;
		}
		$json_data = substr_replace( $json_data, "", -1 ) ;
		$json_data .= "	] };" ;
	}
	else if ( $action === "auto_canned" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;

		$canid = Util_Format_Sanatize( Util_Format_GetVar( "canid" ), "n" ) ;
		$value = Util_Format_Sanatize( Util_Format_GetVar( "value" ), "n" ) ;
		$opid = Util_Format_Sanatize( $_COOKIE["cO"], "n" ) ;

		if ( $value ) { Ops_update_OpVarValue( $dbh, $opid, "canID", $canid ) ; }
		else { Ops_update_OpVarValue( $dbh, $opid, "canID", 0 ) ; }
		$json_data = "json_data = { \"status\": 1 };" ;
	}
	else if ( $action === "vis_idle" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;

		$canid_1 = Util_Format_Sanatize( Util_Format_GetVar( "canid_1" ), "n" ) ;
		$canid_2 = Util_Format_Sanatize( Util_Format_GetVar( "canid_2" ), "n" ) ;
		$idle = Util_Format_Sanatize( Util_Format_GetVar( "idle" ), "n" ) ;

		$vis_idle_canned = Array( "canid_1" => $canid_1, "canid_2" => $canid_2, "idle" => $idle ) ;

		if ( $canid_1 && $canid_1 )
			Ops_update_OpVarValue( $dbh, $opid, "vis_idle_canned", serialize( $vis_idle_canned ) ) ;
		else
			Ops_update_OpVarValue( $dbh, $opid, "vis_idle_canned", "" ) ;
		$json_data = "json_data = { \"status\": 1 };" ;
	}
	else
		$json_data = "json_data = { \"status\": 0 };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print $json_data ; exit ;
?>