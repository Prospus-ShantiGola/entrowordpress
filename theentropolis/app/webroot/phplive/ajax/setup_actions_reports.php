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

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;

	if ( $action === "footprints" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_ext.php" ) ;
		$sdate_start = Util_Format_Sanatize( Util_Format_GetVar( "sdate" ), "n" ) ;

		$stat_start = mktime( 0, 0, 1, date( "m", $sdate_start ), date( "j", $sdate_start ), date( "Y", $sdate_start ) ) ;
		$stat_end = mktime( 23, 59, 59, date( "m", $sdate_start ), date( "j", $sdate_start ), date( "Y", $sdate_start ) ) ;
		$footprints = Footprints_get_FootStatsData( $dbh, $stat_start, $stat_end ) ;

		usort( $footprints, 'Util_Functions_Sort_Compare' ) ;

		$json_data = "json_data = { \"status\": 1, \"footprints\": [ " ;
		for ( $c = 0; $c < count( $footprints ); ++$c )
		{
			$footprint = $footprints[$c] ;
			if ( $footprint["onpage"] != "null" )
			{
				$url = Util_Format_ConvertQuotes( preg_replace( "/hphp/i", "http", $footprint["onpage"] ) ) ;
				$url_snap = ( strlen( $url ) > 130 ) ? substr( $url, 0, 130 ) . "..." : $url ;
				$json_data .= "{ \"total\": $footprint[total], \"url_snap\": \"$url_snap\", \"url_raw\": \"$url\" }," ;
			}
		}

		$json_data = substr_replace( $json_data, "", -1 ) ;
		$json_data .= "	] };" ;
	}
	else if ( $action === "refers" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_ext.php" ) ;
		$sdate_start = Util_Format_Sanatize( Util_Format_GetVar( "sdate" ), "n" ) ;

		$stat_start = mktime( 0, 0, 1, date( "m", $sdate_start ), date( "j", $sdate_start ), date( "Y", $sdate_start ) ) ;
		$stat_end = mktime( 23, 59, 59, date( "m", $sdate_start ), date( "j", $sdate_start ), date( "Y", $sdate_start ) ) ;
		$refers = Footprints_get_ReferStatsData( $dbh, $stat_start, $stat_end ) ;

		$json_data = "json_data = { \"status\": 1, \"footprints\": [ " ;
		for ( $c = 0; $c < count( $refers ); ++$c )
		{
			$footprint = $refers[$c] ;
			if ( ( $footprint["refer"] != "null" ) && $footprint["refer"] )
			{
				$url = preg_replace( "/hphp/i", "http", Util_Format_ConvertQuotes( $footprint["refer"] ) ) ;
				$url_snap = ( strlen( $url ) > 130 ) ? substr( $url, 0, 130 ) . "..." : $url ;
				$json_data .= "{ \"total\": $footprint[total], \"url_snap\": \"$url_snap\", \"url_raw\": \"$url\" }," ;
			}
		}

		$json_data = substr_replace( $json_data, "", -1 ) ;
		$json_data .= "	] };" ;
	}
	else if ( $action === "fetch_request_urls" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;
		$sdate_start = Util_Format_Sanatize( Util_Format_GetVar( "sdate" ), "n" ) ;

		if ( $sdate_start )
		{
			$stat_start = mktime( 0, 0, 1, date( "m", $sdate_start ), date( "j", $sdate_start ), date( "Y", $sdate_start ) ) ;
			$stat_end = mktime( 23, 59, 59, date( "m", $sdate_start ), date( "j", $sdate_start ), date( "Y", $sdate_start ) ) ;
		}
		else
		{
			$stat_start = Util_Format_Sanatize( Util_Format_GetVar( "stat_start" ), "n" ) ;
			$stat_end = Util_Format_Sanatize( Util_Format_GetVar( "stat_end" ), "n" ) ;
		}

		$urls = Chat_ext_get_RequestURLs( $dbh, $stat_start, $stat_end ) ;

		$json_data = "json_data = { \"status\": 1, \"urls\": [ " ;
		for ( $c = 0; $c < count( $urls ); ++$c )
		{
			$data = $urls[$c] ;
			$url = htmlentities( $data["onpage"] ) ;
			$json_data .= "{ \"url\": \"$url\", \"total\": \"$data[total]\" }," ;
		}

		$json_data = substr_replace( $json_data, "", -1 ) ;
		$json_data .= "	] };" ;
	}
	else if ( $action === "fetch_request_timeline" )
	{
		$setup_admin = 1 ;
		include_once( "$CONF[DOCUMENT_ROOT]/ajax/inc_fetch_timeline.php" ) ;
	}
	else if ( $action === "fetch_tag_stats" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;
		$sdate_start = Util_Format_Sanatize( Util_Format_GetVar( "sdate" ), "n" ) ;
		$now = time() ;

		if ( $sdate_start )
		{
			$stat_start = mktime( 0, 0, 1, date( "m", $sdate_start ), date( "j", $sdate_start ), date( "Y", $sdate_start ) ) ;
			$stat_end = mktime( 23, 59, 59, date( "m", $sdate_start ), date( "j", $sdate_start ), date( "Y", $sdate_start ) ) ;
		}
		else
		{
			$month = Util_Format_Sanatize( Util_Format_GetVar( "m" ), "n" ) ;
			$year = Util_Format_Sanatize( Util_Format_GetVar( "y" ), "n" ) ;

			if ( $month && $year )
			{
				$stat_start = mktime( 0, 0, 1, $month, 1, $year ) ;
				$stat_end = mktime( 23, 59, 59, $month, date('t', $stat_start), $year ) ;
			}
			else
			{
				$stat_start = mktime( 0, 0, 1, date( "m", $now ), 1, date( "Y", $now ) ) ;
				$stat_end = mktime( 23, 59, 59, date( "m", $now ), date( "t", $now ), date( "Y", $now ) ) ;
			}
		}

		$operators = Ops_get_AllOps( $dbh ) ;
		$tags = isset( $VALS['TAGS'] ) ? unserialize( $VALS['TAGS'] ) : Array() ;

		$json_data = "json_data = { \"status\": 1, \"operators\": [ " ;
		for ( $c = 0; $c < count( $operators ); ++$c )
		{
			$operator = $operators[$c] ;
			$opid = $operator["opID"] ;
			$name = rawurlencode( $operator["name"] ) ;

			$tag_stats = Chat_ext_get_OpRequestLogTags( $dbh, $opid, $stat_start, $stat_end ) ;

			$tids_string = "" ;
			for ( $c2 = 0; $c2 < count( $tag_stats ); ++$c2 )
			{
				$data = $tag_stats[$c2] ;
				$tid = $data["tag"] ;
				$total = $data["total"] ;
				$tids_string .= " { \"tid\": \"$tid\", \"total\": $total }, " ;
			}
			if ( $tids_string ) { $tids_string = substr_replace( $tids_string, "", -2 ) ; }

			$json_data .= "{ \"opid\": \"$operator[opID]\", \"name\": \"$name\", \"tids\": [ $tids_string ] }," ;
		}

		$json_data = substr_replace( $json_data, "", -1 ) ;
		$json_data .= "	] };" ;
	}
	else
		$json_data = "json_data = { \"status\": 0, \"error\": \"Invalid action.\" };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print $json_data ; exit ;
?>
