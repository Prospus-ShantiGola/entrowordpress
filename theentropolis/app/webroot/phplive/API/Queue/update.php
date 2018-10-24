<?php
	if ( defined( 'API_Queue_update' ) ) { return ; }
	define( 'API_Queue_update', true ) ;

	FUNCTION Queue_update_QueueValue( &$dbh,
					$queueid,
					$tbl_name,
					$value )
	{
		if ( ( $queueid == "" ) || ( $tbl_name == "" ) )
			return false ;
		
		LIST( $queueid, $tbl_name, $value ) = database_mysql_quote( $dbh, $queueid, $tbl_name, $value ) ;

		$query = "UPDATE p_queue SET $tbl_name = '$value' WHERE queueID = '$queueid'" ;
		database_mysql_query( $dbh, $query ) ;
		
		if ( $dbh[ 'ok' ] )
			return true ;
		return false ;
	}

	FUNCTION Queue_update_QueueValueByCes( &$dbh,
					$ces,
					$tbl_name,
					$value )
	{
		if ( ( $ces == "" ) || ( $tbl_name == "" ) )
			return false ;
		
		LIST( $ces, $tbl_name, $value ) = database_mysql_quote( $dbh, $ces, $tbl_name, $value ) ;

		$query = "UPDATE p_queue SET $tbl_name = '$value' WHERE ces = '$ces'" ;
		database_mysql_query( $dbh, $query ) ;
		
		if ( $dbh[ 'ok' ] )
			return true ;
		return false ;
	}

	FUNCTION Queue_update_QueueLogValueByCes( &$dbh,
					$ces,
					$tbl_name,
					$value,
					$check_ended )
	{
		if ( ( $ces == "" ) || ( $tbl_name == "" ) )
			return false ;

		LIST( $ces, $tbl_name, $value ) = database_mysql_quote( $dbh, $ces, $tbl_name, $value ) ;
		$ended_query = ( $check_ended ) ? "AND ended = 0" : "" ;

		$query = "UPDATE p_queue_log SET $tbl_name = '$value' WHERE ces = '$ces' $ended_query" ;
		database_mysql_query( $dbh, $query ) ;
		
		if ( $dbh[ 'ok' ] )
			return true ;
		return false ;
	}

	FUNCTION Queue_update_OpDeclined( &$dbh,
					$ces,
					$opid )
	{
		if ( ( $ces == "" ) || ( $opid == "" ) )
			return false ;
		
		LIST( $ces, $opid ) = database_mysql_quote( $dbh, $ces, $opid ) ;

		$query = "UPDATE p_queue SET ops_d = concat(ifnull(ops_d,''), '$opid,') WHERE ces = '$ces'" ;
		database_mysql_query( $dbh, $query ) ;
		
		if ( $dbh[ 'ok' ] )
			return true ;
		return false ;
	}
?>