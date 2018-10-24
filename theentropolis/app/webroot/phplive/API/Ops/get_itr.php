<?php
	if ( defined( 'API_Ops_get_itr' ) ) { return ; }
	define( 'API_Ops_get_itr', true ) ;

	FUNCTION Ops_get_itr_AnyOpsOnline( &$dbh,
					$deptid )
	{
		$dept_query = $visible_string = "" ;
		if ( $deptid )
		{
			LIST( $deptid ) = database_mysql_quote( $dbh, $deptid ) ;
			$dept_query = "AND deptID = $deptid" ;
		}
		else
			$visible_string = "visible = 1 AND" ;

		$query = "SELECT count(*) AS total FROM p_dept_ops WHERE $visible_string status = 1 $dept_query" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$data = database_mysql_fetchrow( $dbh ) ;
			return $data["total"] ;
		}
		return false ;
	}

	FUNCTION Ops_get_itr_OpsOnlineIDs( &$dbh,
					$deptid )
	{
		if ( $deptid == "" )
			return false ;

		LIST( $deptid ) = database_mysql_quote( $dbh, $deptid ) ;

		$query = "SELECT opID FROM p_dept_ops WHERE status = 1 AND deptID = $deptid" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$output = Array() ;
			while( $data = database_mysql_fetchrow( $dbh ) )
				$output[] = $data["opID"] ;
			return $output ;
		}
		return false ;
	}
?>