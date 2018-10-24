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
	else if ( $action === "status" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_itr.php" ) ;
	
		$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
		$status = Util_Format_Sanatize( Util_Format_GetVar( "status" ), "n" ) ;
		$mapp = Util_Format_Sanatize( Util_Format_GetVar( "mapp" ), "n" ) ;

		Ops_update_PutOpStatus( $dbh, $opid, $status, $mapp ) ;
		Ops_update_OpValue( $dbh, $opid, "status", $status ) ;
		Ops_update_OpValue( $dbh, $opid, "lastactive", time() ) ;

		if ( !$status && !Ops_get_itr_AnyOpsOnline( $dbh, 0 ) )
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

		$json_data = "json_data = { \"status\": 1 }; " ;
	}
	else
		$json_data = "json_data = { \"status\": 0 };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	print $json_data ; exit ;
?>