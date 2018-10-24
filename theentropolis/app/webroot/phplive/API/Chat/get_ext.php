<?php
	if ( defined( 'API_Chat_get_ext' ) ) { return ; }
	define( 'API_Chat_get_ext', true ) ;

	FUNCTION Chat_get_ext_RequestsRangeHash( &$dbh,
								$stat_start,
								$stat_end,
								$operators,
								$opid )
	{
		if ( ( $stat_start == "" ) || ( $stat_end == "" ) )
			return false ;

		$ops_query = "" ;
		for ( $c = 0; $c < count( $operators ); ++$c )
		{
			$operator = $operators[$c] ;
			$ops_query .= " AND opID <> $operator[opID] " ;
		}
		if ( count( $operators ) && $ops_query )
		{
			$query = "DELETE FROM p_rstats_ops WHERE (opID <> 0 $ops_query)" ;
			database_mysql_query( $dbh, $query ) ;
		}

		LIST( $stat_start, $stat_end ) = database_mysql_quote( $dbh, $stat_start, $stat_end ) ;

		$output = Array() ;

		if ( !$opid )
		{
			$stats = Array() ;
			$query = "SELECT * FROM p_rstats_depts WHERE sdate >= $stat_start AND sdate <= $stat_end" ;
			database_mysql_query( $dbh, $query ) ;
			while( $data = database_mysql_fetchrow( $dbh ) )
				$stats[] = $data ;

			for ( $c = 0; $c < count( $stats ); ++$c )
			{
				$data = $stats[$c] ;
				$sdate = $data["sdate"] ;
				$deptid = $data["deptID"] ;

				if ( !isset( $output[$sdate] ) )
				{
					$output[$sdate] = Array() ;
					$output[$sdate]["depts"] = Array() ;
				}

				if ( !isset( $output[$sdate]["depts"][$deptid] ) )
				{
					$output[$sdate]["depts"][$deptid] = Array() ;
					$output[$sdate]["depts"][$deptid]["requests"] = 0 ;
					$output[$sdate]["depts"][$deptid]["taken"] = 0 ;
					$output[$sdate]["depts"][$deptid]["declined"] = 0 ;
					$output[$sdate]["depts"][$deptid]["message"] = 0 ;
					$output[$sdate]["depts"][$deptid]["initiated"] = 0 ;
					$output[$sdate]["depts"][$deptid]["rateit"] = 0 ;
					$output[$sdate]["depts"][$deptid]["ratings"] = 0 ;
				}

				$output[$sdate]["depts"][$deptid]["requests"] += $data["requests"] ;
				$output[$sdate]["depts"][$deptid]["taken"] += $data["taken"] ;
				$output[$sdate]["depts"][$deptid]["declined"] += $data["declined"] ;
				$output[$sdate]["depts"][$deptid]["message"] += $data["message"] ;
				$output[$sdate]["depts"][$deptid]["initiated"] += $data["initiated"] ;
				$output[$sdate]["depts"][$deptid]["rateit"] += $data["rateit"] ;
				$output[$sdate]["depts"][$deptid]["ratings"] += $data["ratings"] ;
			}
		}

		$ops_string = "" ;
		if ( $opid )
		{
			LIST( $opid ) = database_mysql_quote( $dbh, $opid ) ;
			$ops_string = " AND opID = $opid" ;
		}

		$stats = Array() ;
		$query = "SELECT * FROM p_rstats_ops WHERE sdate >= $stat_start AND sdate <= $stat_end $ops_string" ;
		database_mysql_query( $dbh, $query ) ;
		while( $data = database_mysql_fetchrow( $dbh ) )
			$stats[] = $data ;

		for ( $c = 0; $c < count( $stats ); ++$c )
		{
			$data = $stats[$c] ;
			$sdate = $data["sdate"] ;
			$opid = $data["opID"] ;

			if ( !isset( $output[$sdate] ) ) { $output[$sdate] = Array() ; }

			if ( !isset( $output[$sdate]["ops"] ) )
				$output[$sdate]["ops"] = Array() ;

			if ( !isset( $output[$sdate]["ops"][$opid] ) )
			{
				$output[$sdate]["ops"][$opid] = Array() ;
				$output[$sdate]["ops"][$opid]["requests"] = 0 ;
				$output[$sdate]["ops"][$opid]["taken"] = 0 ;
				$output[$sdate]["ops"][$opid]["declined"] = 0 ;
				$output[$sdate]["ops"][$opid]["message"] = 0 ;
				$output[$sdate]["ops"][$opid]["initiated"] = 0 ;
				$output[$sdate]["ops"][$opid]["rateit"] = 0 ;
				$output[$sdate]["ops"][$opid]["ratings"] = 0 ;
			}

			$output[$sdate]["ops"][$opid]["requests"] += $data["requests"] ;
			$output[$sdate]["ops"][$opid]["taken"] += $data["taken"] ;
			$output[$sdate]["ops"][$opid]["declined"] += $data["declined"] ;
			$output[$sdate]["ops"][$opid]["message"] += $data["message"] ;
			$output[$sdate]["ops"][$opid]["initiated"] += $data["initiated"] ;
			$output[$sdate]["ops"][$opid]["rateit"] += $data["rateit"] ;
			$output[$sdate]["ops"][$opid]["ratings"] += $data["ratings"] ;
		}

		return $output ;
	}

	FUNCTION Chat_get_ext_AcceptedDeptsHash( &$dbh,
								$deptid,
								$stat_start,
								$stat_end )
	{
		global $VARS_JS_REQUESTING ;
		if ( ( $stat_start == "" ) || ( $stat_end == "" ) )
			return false ;

		LIST( $deptid, $stat_start, $stat_end ) = database_mysql_quote( $dbh, $deptid, $stat_start, $stat_end ) ;

		if ( !$deptid )
			$query = "SELECT deptID, AVG(accepted) AS accepted, count(*) AS total FROM p_req_log WHERE created >= $stat_start AND created <= $stat_end AND accepted <> 0 GROUP BY deptID" ;
		else
			$query = "SELECT deptID, AVG(accepted) AS accepted, count(*) AS total FROM p_req_log WHERE deptID = $deptid AND created >= $stat_start AND created <= $stat_end AND accepted <> 0" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ; $stats = Array() ; $total = 0 ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$stats[] = $data ;

			for ( $c = 0; $c < count( $stats ); ++$c )
			{
				$data = $stats[$c] ;
				$deptid = $data["deptID"] ;

				$total_count = $data["total"] ;
				$accepted = floor( $data["accepted"] ) ;
				
				// subtract the network 1-$VARS_JS_REQUESTING seconds to
				// average it out due to 1-$VARS_JS_REQUESTING seconds network communication
				for ( $c2 = $VARS_JS_REQUESTING; $c2 > 0; --$c2 )
				{
					$network_buffer = $c2 * $total_count ;
					$diff = $accepted - $network_buffer ;

					if ( $diff > 0 )
					{
						$accepted = $accepted - round($network_buffer/2) ;
						break ;
					}
				}

				$output[$deptid] = $accepted ;
				$total += $accepted ;
			}
			$output[0] = ( count( $stats ) ) ? floor( $total/count( $stats ) ) : 0 ;
		}
		return $output ;
	}

	FUNCTION Chat_get_ext_AcceptedOpsHash( &$dbh,
								$opid,
								$stat_start,
								$stat_end )
	{
		if ( ( $stat_start == "" ) || ( $stat_end == "" ) )
			return false ;

		LIST( $opid, $stat_start, $stat_end ) = database_mysql_quote( $dbh, $opid, $stat_start, $stat_end ) ;

		if ( !$opid )
			$query = "SELECT opID, AVG(accepted_op) AS accepted FROM p_req_log WHERE created >= $stat_start AND created <= $stat_end AND accepted_op <> 0 GROUP BY opID" ;
		else
			$query = "SELECT opID, AVG(accepted_op) AS accepted FROM p_req_log WHERE opID = $opid AND created >= $stat_start AND created <= $stat_end AND accepted_op <> 0" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ; $stats = Array() ; $total = 0 ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$stats[] = $data ;

			for ( $c = 0; $c < count( $stats ); ++$c )
			{
				$data = $stats[$c] ;
				$opid = $data["opID"] ;
				$output[$opid] = floor( $data["accepted"] ) ;
				$total += $output[$opid] ;
			}
			$output[0] = ( count( $stats ) ) ? floor( $total/count( $stats ) ) : 0 ;
		}
		return $output ;
	}

	FUNCTION Chat_get_ext_TransDurDeptsHash( &$dbh,
								$deptid,
								$stat_start,
								$stat_end )
	{
		if ( ( $stat_start == "" ) || ( $stat_end == "" ) )
			return false ;

		LIST( $deptid, $stat_start, $stat_end ) = database_mysql_quote( $dbh, $deptid, $stat_start, $stat_end ) ;

		if ( !$deptid )
			$query = "SELECT deptID, AVG(duration) AS duration FROM p_req_log WHERE created >= $stat_start AND created <= $stat_end AND duration <> 0 GROUP BY deptID" ;
		else
			$query = "SELECT deptID, AVG(duration) AS duration FROM p_req_log WHERE deptID = $deptid AND created >= $stat_start AND created <= $stat_end AND duration <> 0" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ; $stats = Array() ; $total = 0 ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$stats[] = $data ;

			for ( $c = 0; $c < count( $stats ); ++$c )
			{
				$data = $stats[$c] ;
				$deptid = $data["deptID"] ;
				$output[$deptid] = floor( $data["duration"] ) ;
				$total += $output[$deptid] ;
			}
			$output[0] = ( count( $stats ) ) ? floor( $total/count( $stats ) ) : 0 ;
		}
		return $output ;
	}

	FUNCTION Chat_get_ext_TransDurOpsHash( &$dbh,
								$opid,
								$stat_start,
								$stat_end )
	{
		if ( ( $stat_start == "" ) || ( $stat_end == "" ) )
			return false ;

		LIST( $opid, $stat_start, $stat_end ) = database_mysql_quote( $dbh, $opid, $stat_start, $stat_end ) ;

		if ( !$opid )
			$query = "SELECT opID, AVG(duration) AS duration FROM p_req_log WHERE created >= $stat_start AND created <= $stat_end AND duration <> 0 GROUP BY opID" ;
		else
			$query = "SELECT opID, AVG(duration) AS duration FROM p_req_log WHERE opID = $opid AND created >= $stat_start AND created <= $stat_end AND duration <> 0" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ; $stats = Array() ; $total = 0 ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$stats[] = $data ;

			for ( $c = 0; $c < count( $stats ); ++$c )
			{
				$data = $stats[$c] ;
				$opid = $data["opID"] ;
				$output[$opid] = floor( $data["duration"] ) ;
				$total += $output[$opid] ;
			}
			$output[0] = ( count( $stats ) ) ? floor( $total/count( $stats ) ) : 0 ;
		}
		return $output ;
	}

	FUNCTION Chat_ext_get_VisTranscripts( &$dbh,
						$vis_token )
	{
		if ( $vis_token == "" )
			return false ;

		LIST( $vis_token ) = database_mysql_quote( $dbh, $vis_token ) ;

		$query = "SELECT * FROM p_transcripts WHERE md5_vis = '$vis_token' ORDER BY created DESC LIMIT 100" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$output[] = $data ;
		}
		return $output ;
	}

	FUNCTION Chat_ext_get_RefinedTranscripts( &$dbh,
								$deptid,
								$opid,
								$tid,
								$s_as,
								$text,
								$stat_start,
								$stat_end,
								$page,
								$limit )
	{
		if ( $limit == "" )
			return false ;

		LIST( $deptid, $opid, $tid, $text, $stat_start, $stat_end, $page, $limit ) = database_mysql_quote( $dbh, $deptid, $opid, $tid, $text, $stat_start, $stat_end, $page, $limit ) ;
		$start = ( $page * $limit ) ;

		$search_string = "" ;
		if ( $s_as == "ces" ) { $search_string = " AND created >= $stat_start AND created <= $stat_end AND ( ces = '$text' ) " ; }
		else if ( $s_as == "vid" ) { $search_string = " AND created >= $stat_start AND created <= $stat_end AND ( md5_vis = '$text' ) " ; }
		else if ( preg_match( "/^cus_/i", $s_as ) ) { $search_string = " AND created >= $stat_start AND created <= $stat_end AND ( custom LIKE '%$text%' ) " ; }
		else if ( $text ) { $search_string = " AND created >= $stat_start AND created <= $stat_end AND ( plain LIKE '%$text%' ) " ; }

		if ( $tid ) { $search_string = $search_string . " AND ( tag = $tid ) " ; }
		if ( $deptid && $opid )
		{
			$query = "SELECT * FROM p_transcripts WHERE deptID = $deptid AND opID = $opid $search_string ORDER BY created DESC LIMIT $start, $limit" ;
			$query2 = "SELECT count(*) AS total FROM p_transcripts WHERE deptID = $deptid AND opID = $opid $search_string" ;
		}
		else if ( $deptid )
		{
			$query = "SELECT * FROM p_transcripts WHERE deptID = $deptid $search_string ORDER BY created DESC LIMIT $start, $limit" ;
			$query2 = "SELECT count(*) AS total FROM p_transcripts WHERE deptID = $deptid $search_string" ;
		}
		else if ( $opid )
		{
			$query = "SELECT * FROM p_transcripts WHERE opID = $opid $search_string ORDER BY created DESC LIMIT $start, $limit" ;
			$query2 = "SELECT count(*) AS total FROM p_transcripts WHERE opID = $opid $search_string" ;
		}
		else
		{
			$query = "SELECT * FROM p_transcripts WHERE created > 0 $search_string ORDER BY created DESC LIMIT $start, $limit" ;
			$query2 = "SELECT count(*) AS total FROM p_transcripts WHERE created > 0 $search_string" ;
		}
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$output[] = $data ;
		}

		database_mysql_query( $dbh, $query2 ) ;
		$data = database_mysql_fetchrow( $dbh ) ;
		$output[] = $data["total"] ;

		return $output ;
	}

	FUNCTION Chat_ext_get_Transcript( &$dbh,
								$ces )
	{
		if ( $ces == "" )
			return false ;

		LIST( $ces ) = database_mysql_quote( $dbh, $ces ) ;

		$query = "SELECT * FROM p_transcripts WHERE ces = '$ces'" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$data = database_mysql_fetchrow( $dbh ) ;
			return $data ;
		}
		return false ;
	}

	FUNCTION Chat_ext_get_TotalTranscript( &$dbh )
	{
		$query = "SELECT count(*) AS total FROM p_transcripts" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$data = database_mysql_fetchrow( $dbh ) ;
			return $data["total"] ;
		}
		return false ;
	}

	FUNCTION Chat_ext_get_OpDeptTrans( &$dbh,
								$opid,
								$s_as,
								$text,
								$stat_start,
								$stat_end,
								$tid,
								$page,
								$limit )
	{
		if ( ( $opid == "" ) || ( $limit == "" ) )
			return false ;

		global $CONF ;
		if ( !defined( 'API_Depts_get' ) )
			include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

		LIST( $opid, $text, $stat_start, $stat_end, $tid, $page, $limit ) = database_mysql_quote( $dbh, $opid, $text, $stat_start, $stat_end, $tid, $page, $limit ) ;
		$start = ( $page * $limit ) ;

		$departments = Depts_get_OpDepts( $dbh, $opid ) ;
		$dept_string = " ( opID = $opid OR op2op = $opid " ;
		for ( $c = 0; $c < count( $departments ); ++$c )
		{
			if ( $departments[$c]["tshare"] )
				$dept_string .= " OR deptID = " . $departments[$c]["deptID"] ;
		}
		$dept_string .= " ) " ;

		$search_string = "" ;
		if ( is_numeric( $tid ) && $tid ) { $search_string = " ( tag = $tid ) AND " ; }
		else if ( $s_as == "ces" ) { $search_string = " created >= $stat_start AND created <= $stat_end AND ( ces = '$text' ) AND " ; }
		else if ( $s_as == "vid" ) { $search_string = " created >= $stat_start AND created <= $stat_end AND ( md5_vis = '$text' ) AND " ; }
		else if ( preg_match( "/^cus_/i", $s_as ) ) { $search_string = " created >= $stat_start AND created <= $stat_end AND ( custom LIKE '%$text%' ) AND " ; }
		else if ( $text ) { $search_string = " created >= $stat_start AND created <= $stat_end AND ( plain LIKE '%$text%' ) AND " ; }
		$query = "SELECT * FROM p_transcripts WHERE $search_string $dept_string ORDER BY created DESC LIMIT $start, $limit" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$output[] = $data ;
		}
		$query = "SELECT count(*) AS total FROM p_transcripts WHERE $search_string $dept_string" ;
		database_mysql_query( $dbh, $query ) ;
		$data = database_mysql_fetchrow( $dbh ) ;
		$output[] = $data["total"] ;

		return $output ;
	}

	FUNCTION Chat_ext_get_AllRequests( &$dbh,
					$deptid )
	{
		LIST( $deptid ) = database_mysql_quote( $dbh, $deptid ) ;

		$dept_string = "" ;
		if ( $deptid )
			$dept_string = " AND deptID = $deptid " ;

		// created > 0 flag is placeholder for the AND condition above
		$query = "SELECT * FROM p_requests WHERE created > 0 $dept_string ORDER BY created ASC" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$output[] = $data ;
			return $output ;
		}
		return false ;
	}

	FUNCTION Chat_ext_get_OpRequestLogTags( &$dbh,
					$opid,
					$stat_start,
					$stat_end )
	{
		if ( !$opid || !$stat_start || !$stat_end )
			return Array() ;

		LIST( $opid ) = database_mysql_quote( $dbh, $opid ) ;

		$query = "SELECT count(*) AS total, tag FROM p_req_log WHERE opID = $opid AND tag <> 0 AND created >= $stat_start AND created <= $stat_end GROUP BY tag" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$output[] = $data ;
			return $output ;
		}
		return $output ;
	}

	FUNCTION Chat_ext_get_OpStatusLog( &$dbh,
								$opid,
								$stat_start,
								$stat_end )
	{
		if ( !$opid || !$stat_start || !$stat_end )
			return Array() ;

		LIST( $opid, $stat_start, $stat_end ) = database_mysql_quote( $dbh, $opid, $stat_start, $stat_end ) ;

		$query = "SELECT * FROM p_opstatus_log WHERE opID = $opid AND created >= $stat_start AND created <= $stat_end ORDER BY created ASC" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$output[] = $data ;
		}
		return $output ;
	}

	FUNCTION Chat_ext_get_OpStatusPrevOne( &$dbh,
								$opid,
								$stat_start )
	{
		if ( !$opid || !$stat_start )
			return Array() ;

		LIST( $opid, $stat_start ) = database_mysql_quote( $dbh, $opid, $stat_start ) ;

		$query = "SELECT * FROM p_opstatus_log WHERE opID = $opid AND created < $stat_start ORDER BY created ASC LIMIT 1" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ;
		if ( $dbh[ 'ok' ] )
		{
			$data = database_mysql_fetchrow( $dbh ) ;
			return $data ;
		}
		return $output ;
	}

	FUNCTION Chat_ext_get_Chats_Missed( &$dbh,
								$deptid,
								$page,
								$limit )
	{
		if ( $limit == "" )
			return false ;

		LIST( $deptid, $page, $limit ) = database_mysql_quote( $dbh, $deptid, $page, $limit ) ;
		$start = ( $page * $limit ) ;

		// 1429689962 is the unixtime the new feature was added.  prior data has invalid "ended" value that is
		// not compatible with the new feature of "Missed Chats"
		if ( $deptid )
			$query = "SELECT * FROM p_req_log WHERE status = 0 AND deptID = $deptid AND ended = 0 AND created > 1429689962 AND op2op = 0 AND archive = 0 ORDER BY created DESC LIMIT $start, $limit" ;
		else
			$query = "SELECT * FROM p_req_log WHERE status = 0 AND ended = 0 AND created > 1429689962 AND op2op = 0 AND archive = 0 ORDER BY created DESC LIMIT $start, $limit" ;
		database_mysql_query( $dbh, $query ) ;

		$output = Array() ;
		if ( $dbh[ 'ok' ] )
		{
			while( $data = database_mysql_fetchrow( $dbh ) )
				$output[] = $data ;
		}
		return $output ;
	}

	FUNCTION Chat_ext_get_Total_Chats_Missed( &$dbh,
								$deptid )
	{
		LIST( $deptid ) = database_mysql_quote( $dbh, $deptid ) ;

		if ( $deptid )
			$query = "SELECT count(*) AS total FROM p_req_log WHERE status = 0 AND deptID = $deptid AND ended = 0 AND created > 1429689962 AND op2op = 0" ;
		else
			$query = "SELECT count(*) AS total FROM p_req_log WHERE status = 0 AND ended = 0 AND created > 1429689962 AND op2op = 0" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$data = database_mysql_fetchrow( $dbh ) ;
			return $data["total"] ;
		}
		return false ;
	}

	FUNCTION Chat_ext_get_RequestURLs( &$dbh,
								$stat_start,
								$stat_end )
	{
		if ( ( $stat_start == "" ) || ( $stat_end == "" ) )
			return false ;

		LIST( $stat_start, $stat_end ) = database_mysql_quote( $dbh, $stat_start, $stat_end ) ;

		$query = "SELECT onpage, count(*) AS total FROM p_req_log WHERE created >= $stat_start AND created <= $stat_end AND op2op = 0 AND initiated = 0 AND archive = 0 GROUP BY onpage ORDER BY total DESC" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$output = Array() ;
			while( $data = database_mysql_fetchrow( $dbh ) )
				$output[] = $data ;

			return $output ;
		}
		return false ;
	}

	FUNCTION Chat_ext_get_RequestTimeline( &$dbh,
								$deptid,
								$opid,
								$stat_start,
								$stat_end )
	{
		if ( ( $stat_start == "" ) || ( $stat_end == "" ) )
			return false ;

		LIST( $deptid, $opid, $stat_start, $stat_end ) = database_mysql_quote( $dbh, $deptid, $opid, $stat_start, $stat_end ) ;

		$dept_string = "" ;
		if ( !$deptid && !$opid )
			$dept_string = "GROUP BY ces" ;
		else if ( $deptid )
			$dept_string = "AND deptID = $deptid" ;

		$op_string = ( $opid ) ? "AND opID = $opid" : "" ;

		if ( preg_match( "/GROUP BY ces/", $dept_string ) )
			$query = "SELECT created, SUM(status) AS status FROM p_rstats_log WHERE created >= $stat_start AND created <= $stat_end $dept_string" ;
		else
			$query = "SELECT created, status FROM p_rstats_log WHERE created >= $stat_start AND created <= $stat_end $op_string $dept_string" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$output = Array() ;
			while( $data = database_mysql_fetchrow( $dbh ) )
				$output[] = $data ;

			return $output ;
		}
		return false ;
	}
?>