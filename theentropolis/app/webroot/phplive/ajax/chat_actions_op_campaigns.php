<?php
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$opid = isset( $_COOKIE["cO"] ) ? Util_Format_Sanatize( $_COOKIE["cO"], "n" ) : "" ;
	$ses = isset( $_COOKIE["cS"] ) ? Util_Format_Sanatize( $_COOKIE["cS"], "ln" ) : "" ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;

	if ( !$opid || !is_file( "$CONF[TYPE_IO_DIR]/$opid"."_ses_$ses.ses" ) )
		$json_data = "json_data = { \"status\": -1 };" ;
	else if ( $action === "campaigns" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Marketing/get.php" ) ;

		$markets = Marketing_get_AllMarketing( $dbh ) ;
		$json_data = "json_data = { \"status\": 1, \"markets\": [  " ;
		for ( $c = 0; $c < count( $markets ); ++$c )
		{
			$market = $markets[$c] ;

			$json_data .= "{ \"marketid\": $market[marketID], \"name\": \"$market[name]\", \"color\": \"$market[color]\" }," ;
		}
		$json_data = substr_replace( $json_data, "", -1 ) ;
		$json_data .= "	] };" ;
	}
	else
		$json_data = "json_data = { \"status\": 0 };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print $json_data ; exit ;
?>