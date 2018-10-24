<?php
	if ( defined( 'API_Queue_get' ) ) { return ; }
	define( 'API_Queue_get', true ) ;

	FUNCTION Queue_get_InfoByCes( &$dbh,
						$ces )
	{
		if ( $ces == "" )
			return false ;

		LIST( $ces ) = database_mysql_quote( $dbh, $ces ) ;

		$query = "SELECT * FROM p_queue WHERE ces = '$ces' LIMIT 1" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$data = database_mysql_fetchrow( $dbh ) ;
			return $data ;
		} return false ;
	}

	FUNCTION Queue_get_InfoByToken( &$dbh,
						$vis_token )
	{
		if ( $vis_token == "" )
			return false ;

		LIST( $vis_token ) = database_mysql_quote( $dbh, $vis_token ) ;

		$query = "SELECT * FROM p_queue WHERE md5_vis = '$vis_token'" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$data = database_mysql_fetchrow( $dbh ) ;
			return $data ;
		} return false ;
	}

	FUNCTION Queue_get_DeptQueueOrderHash( &$dbh,
						$deptid )
	{
		if ( $deptid == "" )
			return false ;

		LIST( $deptid ) = database_mysql_quote( $dbh, $deptid ) ;

		$queue = Array() ;
		$query = "SELECT queueID, ces, ops_d FROM p_queue WHERE deptid = '$deptid' ORDER BY queueID ASC" ;
		database_mysql_query( $dbh, $query ) ;
		while( $data = database_mysql_fetchrow( $dbh ) )
			$queue[] = $data ;

		$output = Array() ; $sorted = Array() ;
		$total_queue = count( $queue ) ;
		for ( $c = 0; $c < $total_queue; ++$c )
		{
			$queueinfo = $queue[$c] ;
			$thisces = $queueinfo["ces"] ;
			$sorted[] = $thisces ;
			$output[$thisces]["pos"] = $c+1 ;
			$output[$thisces]["ops_d"] = trim( $queueinfo["ops_d"] ) ;
		}
		$output["sorted"] = $sorted ;
		return $output ;
	}

	FUNCTION Queue_get_EstimatedTime( &$dbh,
						$deptid,
						$limit )
	{
		if ( ( $deptid == "" ) || ( $limit == "" ) )
			return -1 ;

		LIST( $deptid, $limit ) = database_mysql_quote( $dbh, $deptid, $limit ) ;

		$query = "SELECT created, ended FROM p_queue_log WHERE deptID = $deptid AND ended <> 0 ORDER BY ended DESC LIMIT $limit" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$queues = Array() ;
			while ( $data = database_mysql_fetchrow( $dbh ) )
				$queues[] = $data ;

			$total_duration = 0 ; $est = 0 ; $total_q = count( $queues ) ;
			if ( $total_q == $limit )
			{
				for ( $c = 0; $c < $total_q; ++$c )
				{
					$queue = $queues[$c] ;
					$diff = $queue["ended"] - $queue["created"] ;
					$total_duration += $diff ;
				}
				$est = round( round( $total_duration/$total_q )/60 ) ;
				if ( !$est ) { $est = 1 ; }
			}
			else
				$est = 0 ;

			return $est ;
		} return -1 ;
	}
?>