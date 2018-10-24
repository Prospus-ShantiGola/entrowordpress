<?php
	if ( defined( 'API_Setup_put' ) ) { return ; }
	define( 'API_Setup_put', true ) ;

	FUNCTION Setup_put_Account( &$dbh,
					$created,
					$login,
					$password,
					$email )
	{
		if ( ( $created == "" ) || ( $login == "" ) || ( $password == "" )
			|| ( $email == "" ) )
			return false ;

		LIST( $login, $password, $email ) = database_mysql_quote( $dbh, $login, md5( $password ), $email ) ;

		$query = "INSERT INTO p_admins VALUES ( 0, $created, 0, -1, '', '$login', '$password', '$email' )" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
			return true ;

		return false ;
	}

?>
