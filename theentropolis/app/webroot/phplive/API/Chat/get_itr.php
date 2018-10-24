<?php
	if ( defined( 'API_Chat_get_itr' ) ) { return ; }
	define( 'API_Chat_get_itr', true ) ;

	FUNCTION Chat_get_itr_RequestCesInfo( &$dbh,
					$ces )
	{
		if ( $ces == "" )
			return false ;

		LIST( $ces ) = database_mysql_quote( $dbh, $ces ) ;

		$query = "SELECT * FROM p_requests WHERE ces = '$ces' LIMIT 1" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$data = database_mysql_fetchrow( $dbh ) ;
			return $data ;
		}
		return false ;
	}

	FUNCTION Chat_get_itr_RequestGetInfo( &$dbh,
					$embed,
					$ces,
					$vis_token )
	{
		if ( $vis_token == "" )
			return false ;

		LIST( $ces, $vis_token ) = database_mysql_quote( $dbh, $ces, $vis_token ) ;

		$data = Array() ;
		if ( $ces )
		{
			$query = "SELECT * FROM p_requests WHERE ces = '$ces' LIMIT 1" ;
			database_mysql_query( $dbh, $query ) ;
			$data = database_mysql_fetchrow( $dbh ) ;
		}
		if ( !isset( $data["ces"] ) )
		{
			if ( $embed )
			{
				$query = "SELECT * FROM p_requests WHERE md5_vis = '$vis_token' LIMIT 1" ;
				database_mysql_query( $dbh, $query ) ;
				$data = database_mysql_fetchrow( $dbh ) ;
			}
			else
			{
				$query = "SELECT * FROM p_requests WHERE md5_vis_ = '$vis_token' LIMIT 1" ;
				database_mysql_query( $dbh, $query ) ;
				$data = database_mysql_fetchrow( $dbh ) ;
			}
		} return $data ;
	}
?>