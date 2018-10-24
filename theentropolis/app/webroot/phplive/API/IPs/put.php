<?php
	if ( defined( 'API_IPs_put' ) ) { return ; }
	define( 'API_IPs_put', true ) ;

	FUNCTION IPs_put_IP( &$dbh, $ip, $vis_token, $deptid, $t_footprints, $t_requests, $t_initiate, $request, $initiate, $i_footprints, $i_timestamp, $onpage = "" )
	{
		if ( ( $ip == "" ) || ( $vis_token == "" ) )
			return false ;
		global $CONF ; global $VALS ; global $ipinfo ;
		$now = time() ; $process = true ;
		if ( !isset( $ipinfo ) )
		{
			if ( !defined( 'API_IPs_get' ) )
			include_once( "$CONF[DOCUMENT_ROOT]/API/IPs/get.php" ) ;
			$ipinfo = IPs_get_IPInfo( $dbh, $vis_token, $ip ) ;
		}
		if ( !isset( $ipinfo["ip"] ) ) { $ipinfo = Array() ; $ipinfo["t_footprints"] = 0 ; $ipinfo["t_requests"] = 0 ; $ipinfo["t_initiate"] = 0 ; $ipinfo["i_footprints"] = 0 ; }
		$t_footprints_sum = $ipinfo["t_footprints"] + $t_footprints ; $t_requests_sum = $ipinfo["t_requests"] + $t_requests ; $t_initiates = $ipinfo["t_initiate"] + $t_initiate ;
		$i_query = " " ; // need a space for marker purposes

		$initiate_array = ( isset( $VALS["auto_initiate"] ) && $VALS["auto_initiate"] ) ? unserialize( html_entity_decode( $VALS["auto_initiate"] ) ) : Array() ;
		$auto_initiate_footprints = ( isset( $initiate_array["footprints"] ) && $initiate_array["footprints"] ) ? $initiate_array["footprints"] : 0 ;
		$auto_initiate_reset = ( isset( $initiate_array["reset"] ) ) ? $initiate_array["reset"] : 0 ;
		$reset = $now+(60*60*$auto_initiate_reset) ;

		if ( $auto_initiate_reset )
		{
			$temp_footprints = $ipinfo["i_footprints"] + $t_footprints ;
			if ( $temp_footprints >= $auto_initiate_footprints )
			{
				// i_footprints used for both the footprint counter and the reset time (<10000000 indicates footprint data)
				if ( $ipinfo["i_footprints"] < 10000000 )
				{
					if ( preg_match( "/$ip/", $VALS["CHAT_SPAM_IPS"] ) ) { $isonline = 0 ; }
					else if ( file_exists( "$CONF[TYPE_IO_DIR]/$vis_token.txt" ) ) { $isonline = 1 ; }
					else { $isonline = 1 ; }

					if ( $vis_token && $isonline )
					{
						$i_footprints = $temp_footprints ;
						$i_query = " i_footprints = $i_footprints" ;
						$process = 1 ;
					}
				}
				else if ( $ipinfo["i_footprints"] <= $now )
				{
					// reset criteria
					$i_query = " i_footprints = 1" ;
				}
				else
				{
					// don't process but send flag for indication for JS
					$process = 2 ;
				}
			}
			else
			{ $i_footprints = $ipinfo["i_footprints"] + $t_footprints ; if ( !$i_footprints ) { $i_footprints = 1 ; } $i_query = " i_footprints = $i_footprints" ; }

			if ( $temp_footprints == $ipinfo["i_footprints"] ) { $i_query = " " ; }
			if ( $i_timestamp ) { $i_query = " i_footprints = $reset" ; }
		}
		$t_footprints_query = ( $t_footprints ) ? "t_footprints = $t_footprints_sum" : " " ;
		$t_requests_query = ( $t_requests ) ? "t_requests = $t_requests_sum" : " " ;
		$t_initiate_query = ( $t_initiate ) ? "t_initiate = $t_initiates" : " " ;
		$t_query = "$t_footprints_query,$t_requests_query,$t_initiate_query,$i_query," ;
		$t_query = preg_replace( "/ ,/", "", $t_query ) ; $t_query = preg_replace( "/,$/", "", $t_query ) ; if ( $t_query ) { $t_query = ",$t_query" ; }

		LIST( $vis_token, $t_footprints_sum, $t_requests, $t_initiate, $i_footprints ) = database_mysql_quote( $dbh, $vis_token, $t_footprints_sum, $t_requests, $t_initiate, $i_footprints ) ;
		if ( isset( $ipinfo["ip"] ) )
			$query = "UPDATE p_ips SET created = $now $t_query WHERE md5_vis = '$vis_token'" ;
		else
			$query = "INSERT INTO p_ips VALUES ( '$vis_token', '$ip', $now, $t_footprints_sum, $t_requests, $t_initiate, $i_footprints )" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] ) { return $process ; }
		return false ;
	}

?>