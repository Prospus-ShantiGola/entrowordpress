<?php
	if ( defined( 'API_Chat_update_itr' ) ) { return ; }
	define( 'API_Chat_update_itr', true ) ;

	FUNCTION Chat_update_itr_ResetChat( &$dbh,
					$requestid )
	{
		if ( $requestid == "" )
			return false ;

		$now = time() ;
		LIST( $requestid ) = database_mysql_quote( $dbh, $requestid ) ;

		$query = "UPDATE p_requests SET vupdated = $now, opID = 0, rloop = rloop + 1, sim_ops_ = '', rstring = '' WHERE requestID = $requestid" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
			return true ;

		return false ;
	}

	FUNCTION Chat_update_itr_RouteChat( &$dbh,
					$requestid,
					$ces,
					$opid,
					$sms,
					$rstring )
	{
		if ( ( $requestid == "" ) || ( $ces == "" ) || ( $opid == "" ) )
			return false ;

		$now = time() ;
		LIST( $requestid, $ces, $opid, $rstring ) = database_mysql_quote( $dbh, $requestid, $ces, $opid, $rstring ) ;

		$query = "UPDATE p_requests SET vupdated = $now, opID = $opid, rstring = '$rstring' WHERE requestID = $requestid" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$query = "UPDATE p_req_log SET opID = $opid WHERE ces = '$ces'" ;
			database_mysql_query( $dbh, $query ) ;

			return true ;
		}
		return false ;
	}
?>