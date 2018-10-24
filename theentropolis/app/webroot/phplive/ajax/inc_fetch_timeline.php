<?php
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
	$timeline = Chat_ext_get_RequestTimeline( $dbh, $deptid, $opid, $stat_start, $stat_end ) ;

	$dept_average_string = $ops_average_string = $depts_average_dur_string = $ops_average_dur_string = "" ;
	if ( $setup_admin )
	{
		$accepted_hash_depts = Chat_get_ext_AcceptedDeptsHash( $dbh, $deptid, $stat_start, $stat_end ) ;
		$accepted_hash_ops = Chat_get_ext_AcceptedOpsHash( $dbh, $opid, $stat_start, $stat_end ) ;
		$duration_hash_depts = Chat_get_ext_TransDurDeptsHash( $dbh, $deptid, $stat_start, $stat_end ) ;
		$duration_hash_ops = Chat_get_ext_TransDurOpsHash( $dbh, $opid, $stat_start, $stat_end ) ;

		$dept_average_string = "\"depts_average\": [ " ;
		foreach ( $accepted_hash_depts as $key => $value )
		{
			$value = Util_Format_Duration( $value ) ;
			$dept_average_string .= "{ \"deptid\": \"$key\", \"average\": \"$value\" }," ;
		}
		$dept_average_string = substr_replace( $dept_average_string, "", -1 ) ;
		$dept_average_string .= " ], " ;

		$ops_average_string = "\"ops_average\": [ " ;
		foreach ( $accepted_hash_ops as $key => $value )
		{
			$value = Util_Format_Duration( $value ) ;
			$ops_average_string .= "{ \"opid\": \"$key\", \"average\": \"$value\" }," ;
		}
		$ops_average_string = substr_replace( $ops_average_string, "", -1 ) ;
		$ops_average_string .= " ], " ;

		$depts_average_dur_string = "\"depts_average_dur\": [ " ;
		foreach ( $duration_hash_depts as $key => $value )
		{
			$value = Util_Format_Duration( $value ) ;
			$depts_average_dur_string .= "{ \"deptid\": \"$key\", \"average\": \"$value\" }," ;
		}
		$depts_average_dur_string = substr_replace( $depts_average_dur_string, "", -1 ) ;
		$depts_average_dur_string .= " ], " ;

		$ops_average_dur_string = "\"ops_average_dur\": [ " ;
		foreach ( $duration_hash_ops as $key => $value )
		{
			$value = Util_Format_Duration( $value ) ;
			$ops_average_dur_string .= "{ \"opid\": \"$key\", \"average\": \"$value\" }," ;
		}
		$ops_average_dur_string = substr_replace( $ops_average_dur_string, "", -1 ) ;
		$ops_average_dur_string .= " ], " ;
	}

	$hours = Array() ;
	for ( $c = 0; $c < count( $timeline ); ++$c )
	{
		$data = $timeline[$c] ;

		$hour = date( "G", $data["created"] ) ;
		if ( isset( $hours[$hour] ) )
		{
			++$hours[$hour]["requests"] ;
			$status = ( !$data["status"] ) ? 0 : 1 ;
			$hours[$hour]["accepted"] += $status ;
		}
		else
		{
			$hours[$hour] = Array() ;
			$hours[$hour]["requests"] = 1 ;
			$status = ( !$data["status"] ) ? 0 : 1 ;
			$hours[$hour]["accepted"] = $status ;
		}
	}

	$now = time() ; $total_overall = $max = $total_accepted = 0 ;
	$json_data = "json_data = { \"status\": 1, $dept_average_string $ops_average_string $depts_average_dur_string $ops_average_dur_string \"timeline\": [ " ;
	for ( $c = 0; $c <= 23; ++$c )
	{
		$now_ = mktime( $c, 0, 1, date( "m", $now ), date( "j", $now ), date( "Y", $now ) ) ;
		$ampm = ( !$VARS_24H ) ? date( "a", $now_ ) : "" ;
		$hour_ = ( !$VARS_24H ) ? date( "g", $now_ ) : date( "G", $now_ ) ;
		$hour_display = "%span%$hour_:00$ampm - $hour_:59$ampm%span_%" ;

		$unixtime = $now_ ;
		if ( isset( $hours[$c] ) )
		{
			$total_overall += $hours[$c]["requests"] ;
			$total_accepted += $hours[$c]["accepted"] ;
			if ( $hours[$c]["requests"] > $max ) { $max = $hours[$c]["requests"] ; }
			$json_data .= "{ \"hour\": \"$c\", \"timestamp\": \"$unixtime\", \"hour_display\": \"$hour_display\", \"ampm\": \"$ampm\", \"hour_\": \"$hour_\", \"total\": \"".$hours[$c]["requests"]."\", \"accepted\": \"".$hours[$c]["accepted"]."\" }," ;
		}
		else { $json_data .= "{ \"hour\": \"$c\", \"timestamp\": \"$unixtime\", \"hour_display\": \"$hour_display\", \"ampm\": \"$ampm\", \"hour_\": \"$hour_\", \"total\": \"0\", \"accepted\": \"0\" }," ; }
	}

	$json_data = substr_replace( $json_data, "", -1 ) ;
	$json_data .= "	], \"hour_max\": \"$max\", \"total_overall\": \"$total_overall\", \"total_accepted\": \"$total_accepted\" };" ;
?>