<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "a" ), "ln" ) ;

	if ( $action === "queueing" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/get.php" ) ;

		$ces = Util_Format_Sanatize( Util_Format_GetVar( "c" ), "ln" ) ;
		$queue = Util_Format_Sanatize( Util_Format_GetVar( "q" ), "n" ) ;
		$qlimit = Util_Format_Sanatize( Util_Format_GetVar( "ql" ), "n" ) ; if ( !$qlimit ) { $qlimit = 5 ; }
		$deptid = Util_Format_Sanatize( Util_Format_GetVar( "d" ), "n" ) ;
		$embed = Util_Format_Sanatize( Util_Format_GetVar( "e" ), "n" ) ;
		$rtype = Util_Format_Sanatize( Util_Format_GetVar( "r" ), "n" ) ;
		$rstring = Util_Format_Sanatize( Util_Format_GetVar( "rs" ), "ln" ) ;
		$token = Util_Format_Sanatize( Util_Format_GetVar( "t" ), "ln" ) ;
		$now = time() ;

		$queueinfo = Queue_get_InfoByCes( $dbh, $ces ) ;
		if ( !isset( $queueinfo["ces"] ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/put.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;

			LIST( $ip, $vis_token ) = Util_IP_GetIP( $token ) ;
			if ( Queue_put_Queue( $dbh, $deptid, $embed, $ces, $vis_token, $rstring ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;

				$queuehash = Queue_get_DeptQueueOrderHash( $dbh, $deptid ) ;
				$position = ( isset( $queuehash[$ces] ) && $queuehash[$ces]["pos"] ) ? $queuehash[$ces]["pos"] : 1 ;
				$json_data = "json_data = { \"status\": 1, \"qpos\": $position };" ;
			}
			else { $json_data = "json_data = { \"status\": 0, \"error\": \"Could not process queue.  Please close chat window and try again.\" };" ; }
		}
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/update.php" ) ;

			$opinfo_next = Ops_get_NextRequestOp( $dbh, 0, $deptid, $rtype, $rstring ) ;
			$queuehash = Queue_get_DeptQueueOrderHash( $dbh, $deptid ) ;
			$position = ( isset( $queuehash[$ces] ) && $queuehash[$ces]["pos"] ) ? $queuehash[$ces]["pos"] : 1 ;
			if ( isset( $opinfo_next["opID"] ) )
			{
				$ops_d = "" ;
				$opid_next = $opinfo_next["opID"] ;
				$queue_sorted = $queuehash["sorted"] ;

				$total_queue = count( $queue_sorted ) ;
				$first_in_line_ces = ( $total_queue ) ? $queue_sorted[0] : "" ;
				for ( $c = 0; $c < $total_queue; ++$c )
				{
					$thisces = $queue_sorted[$c] ;

					$declined = 0 ;
					$ops_d_eclined = ( isset( $queuehash[$thisces] ) && $queuehash[$thisces]["ops_d"] ) ? explode( ",", $queuehash[$thisces]["ops_d"] ) : Array() ;
					for ( $c2 = 0; $c2 < count( $ops_d_eclined ); ++$c2 )
					{
						if ( trim( $ops_d_eclined[$c2] ) == $opid_next ) { $declined = 1 ; break 1 ; }
					}
					if ( !$declined )
					{
						$first_in_line_ces = $thisces ; break 1 ;
					}
				}
				Queue_update_QueueValue( $dbh, $queueinfo["queueID"], "updated", $now ) ;
				$estimated_wait = Queue_get_EstimatedTime( $dbh, $deptid, $qlimit ) ;
				$ops_d = ( isset( $queuehash[$first_in_line_ces] ) && $queuehash[$first_in_line_ces]["ops_d"] ) ? trim( $queuehash[$first_in_line_ces]["ops_d"] ) : "" ;
				$json_data = "json_data = { \"status\": 2, \"ces\": \"$first_in_line_ces\", \"qpos\": $position, \"ops_d\": \"$ops_d\", \"created\": $queueinfo[created], \"est\": \"$estimated_wait\" };" ;
			}
			else
			{
				$rstring_array = explode( ",", trim( $rstring ) ) ; $rstring_hash = Array() ;
				for ( $c = 0; $c < count( $rstring_array ); ++$c )
				{
					if ( trim( $rstring_array[$c] ) )
					{
						$this_opid = $rstring_array[$c] ;
						$rstring_hash[$this_opid] = 1 ;
					}
				}
				$total_ops_online = 0 ; $ops_already_declined = 0 ;
				$query = "SELECT opID FROM p_dept_ops WHERE status = 1 AND deptID = $deptid" ;
				database_mysql_query( $dbh, $query ) ;
				while( $data = database_mysql_fetchrow( $dbh ) )
				{
					$this_opid = $data["opID"] ;
					if ( isset( $rstring_hash[$this_opid] ) ) { ++$ops_already_declined ; }
					++$total_ops_online ;
				}
				if ( $ops_already_declined < $total_ops_online )
				{
					Queue_update_QueueValue( $dbh, $queueinfo["queueID"], "updated", $now ) ;
					$estimated_wait = Queue_get_EstimatedTime( $dbh, $deptid, $qlimit ) ;
					$json_data = "json_data = { \"status\": 1, \"qpos\": $position, \"total_ops_online\": \"$total_ops_online\", \"created\": $queueinfo[created], \"est\": \"$estimated_wait\" };" ;
				}
				else
					$json_data = "json_data = { \"status\": 1, \"qpos\": $position, \"total_ops_online\": \"0\", \"est\": \"0\" };" ;
			}
		}
	}
	else
		$json_data = "json_data = { \"status\": 0, \"error\": \"Could not process queue.\" };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	print $json_data ; exit ;
?>