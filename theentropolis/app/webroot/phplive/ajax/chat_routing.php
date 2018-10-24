<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/*
	// status json route: -1 no request, 0 same op route, 1 request accepted, 2 new op route, 10 leave a message
	*/
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "a" ), "ln" ) ;

	if ( $action === "routing" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_itr.php" ) ;

		$ces = Util_Format_Sanatize( Util_Format_GetVar( "c" ), "ln" ) ;
		$opid_direct = Util_Format_Sanatize( Util_Format_GetVar( "o" ), "n" ) ;
		$deptid = Util_Format_Sanatize( Util_Format_GetVar( "d" ), "n" ) ;
		$c_routing = Util_Format_Sanatize( Util_Format_GetVar( "cr" ), "n" ) ;
		$rtype = Util_Format_Sanatize( Util_Format_GetVar( "r" ), "n" ) ;
		$rtime = Util_Format_Sanatize( Util_Format_GetVar( "rt" ), "n" ) ;
		$rloop = Util_Format_Sanatize( Util_Format_GetVar( "rl" ), "n" ) ;
		$loop = Util_Format_Sanatize( Util_Format_GetVar( "l" ), "n" ) ;
		$lang = Util_Format_Sanatize( Util_Format_GetVar( "lg" ), "ln" ) ;
		$queue = Util_Format_Sanatize( Util_Format_GetVar( "q" ), "n" ) ;
		$inqueue = Util_Format_Sanatize( Util_Format_GetVar( "iq" ), "n" ) ;
		$proto = Util_Format_Sanatize( Util_Format_GetVar( "pr" ), "n" ) ;
		$now = time() ; $q_ops_online = 0 ; $queueinfo = Array() ;

		$requestinfo = Chat_get_itr_RequestCesInfo( $dbh, $ces ) ;
		if ( !isset( $requestinfo["requestID"] ) )
		{
			if ( $inqueue )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_itr.php" ) ;
				// get all the ops online for comparison
				$q_ops_array = Ops_get_itr_OpsOnlineIDs( $dbh, $deptid ) ;
				$q_ops_online = ( is_array( $q_ops_array ) ) ? preg_replace( "/ /", "", implode( ",", $q_ops_array ) ) : "" ;
			}
			$json_data = "json_data = { \"status\": 10, \"q_ops\": \"$q_ops_online\" };" ;
		}
		else
		{
			if ( ( ( $requestinfo["status"] == 2 ) && !$requestinfo["tupdated"] ) || $requestinfo["tloop"] )
			{
				if ( !$requestinfo["tloop"] )
				{
					// transfer operator was not available, route to original operator
					include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

					$deptinfo = Depts_get_DeptInfo( $dbh, $requestinfo["deptID"] ) ;
					$rtime = $now+$deptinfo["rtime"] ;
					$query = "UPDATE p_requests SET tupdated = $rtime, status = 2, vupdated = $now, opID = $requestinfo[op2op], op2op = $requestinfo[opID], tloop = 1 WHERE ces = '$requestinfo[ces]'" ;
					database_mysql_query( $dbh, $query ) ;
					$json_data = "json_data = { \"status\": 2, \"opid\": $requestinfo[op2op], \"rtime\": $deptinfo[rtime] };" ;
				}
				else if ( $requestinfo["tloop"] && ( $requestinfo["tupdated"] > $now ) )
				{
					$json_data = "json_data = { \"status\": 2, \"opid\": $requestinfo[op2op] };" ;
				}
				else
				{
					$query = "DELETE FROM p_requests WHERE ces = '$ces'" ;
					database_mysql_query( $dbh, $query ) ;
					$json_data = "json_data = { \"status\": 11 };" ;
				}
			}
			else if ( $requestinfo["status"] && ( $requestinfo["opID"] != 1111111111 ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
				$opinfo = Ops_get_OpInfoByID( $dbh, $requestinfo["opID"] ) ; $profile_src = "" ;
				if ( $opinfo["pic"] )
				{
					if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
					else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
					$profile_src = Util_Upload_GetLogo( "profile", $opinfo["opID"] ) ;
				}
				$json_data = "json_data = { \"status\": 1, \"status_request\": $requestinfo[status], \"requestid\": $requestinfo[requestID], \"initiated\": $requestinfo[initiated], \"name\": \"$opinfo[name]\", \"rate\": $opinfo[rate], \"deptid\": $deptid, \"opid\": $opinfo[opID], \"email\": \"$opinfo[email]\", \"profile\": \"$profile_src\", \"mapp\": \"$opinfo[mapp]\" };" ;
			}
			else
			{
				if ( $inqueue )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/update.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/get.php" ) ;

					$queueinfo = Queue_get_InfoByCes( $dbh, $ces ) ;
					Queue_update_QueueValueByCes( $dbh, $ces, "updated", $now ) ;
				}

				// vupdated is used for routing UNTIL chat is accepted then it is used
				// for visitor's callback updated time
				if ( !$requestinfo["opID"] )
					$rupdated = $requestinfo["vupdated"] - ($rtime * 2) ; // new chat start routing immediately
				else
					$rupdated = $requestinfo["vupdated"] + $rtime ;

				if ( $now <= $rupdated )
					$json_data = "json_data = { \"status\": 0 };" ;
				else
				{
					// no looping or queue for simultaneous routing
					if ( $requestinfo["opID"] == 1111111111 )
					{
						include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;

						$sim_ops = Util_Format_ExplodeString( "-", $requestinfo["sim_ops"] ) ;
						$sim_ops_ = Util_Format_ExplodeString( "-", $requestinfo["sim_ops_"] ) ;
						for ( $c = 0; $c < count( $sim_ops ); ++$c )
						{
							$found = 0 ;
							for ( $c2 = 0; $c2 < count( $sim_ops_ ); ++$c2 )
							{
								if ( $sim_ops[$c] == $sim_ops_[$c2] )
									$found = 1 ;
							}
							if ( !$found )
								Ops_put_itr_OpReqStat( $dbh, $requestinfo["deptID"], $sim_ops[$c], "declined", 1 ) ;
						}

						// leave a message
						LIST( $ces ) = database_mysql_quote( $dbh, $requestinfo["ces"] ) ;
						$query = "DELETE FROM p_requests WHERE ces = '$ces'" ;
						database_mysql_query( $dbh, $query ) ;
						$json_data = "json_data = { \"status\": 10 };" ;
					}
					else
					{
						include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update_itr.php" ) ;
						include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
						include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;

						if ( ( $requestinfo["status"] != 2 ) && !$requestinfo["op2op"] && ( $loop == 1 ) && $requestinfo["opID"] )
						{
							if ( !$inqueue ) { Ops_put_itr_OpReqStat( $dbh, $deptid, $requestinfo["opID"], "declined", 1 ) ; }
							else if ( isset( $queueinfo["ces"] ) )
							{
								$ops_d = $queueinfo["ops_d"] ;
								$temp = $requestinfo["opID"]."," ;
								if ( !preg_match( "/$temp/", $ops_d ) )
									Ops_put_itr_OpReqStat( $dbh, $deptid, $requestinfo["opID"], "declined", 1 ) ;
							}
						}

						$opinfo_next = Ops_get_NextRequestOp( $dbh, $opid_direct, $deptid, $rtype, $requestinfo["rstring"] ) ;
						if ( isset( $opinfo_next["opID"] ) )
						{
							$opid = $opinfo_next["opID"] ;
							Chat_update_itr_RouteChat( $dbh, $requestinfo["requestID"], $requestinfo["ces"], $opinfo_next["opID"], $opinfo_next["sms"],  "$opinfo_next[opID],$requestinfo[rstring]" ) ;

							if ( ( $opinfo_next["sms"] == 1 ) || is_file( "$CONF[TYPE_IO_DIR]/$opid.mapp" ) )
							{
								$inc_question = $requestinfo["question"] ;
								$mapp_opid = $opid ;
								$sms_oname = $opinfo_next["name"] ; $sms_oemail = $opinfo_next["email"] ;
								$sms_vname = $requestinfo["vname"] ; $sms_num = $opinfo_next["smsnum"] ;
								include_once( "$CONF[DOCUMENT_ROOT]/ajax/inc_request_sms.php" ) ;
							}

							/***** Slack Addon *****/
							if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/slack/slack.php" ) && ( !$requestinfo["status"] || ( $requestinfo["status"] == 2 ) ) && !$requestinfo["slack"] )
							{
								include_once( "$CONF[DOCUMENT_ROOT]/addons/slack/API/Util_Slack.php" ) ;
								Util_Slack_NewChatNotification( $dbh, $proto, $requestinfo, $opid, $opinfo_next ) ;
							}
							/***********************/

							// don't log trasfer chats on total stats of requests
							if ( ( $requestinfo["status"] != 2 ) && !$requestinfo["op2op"] && ( $loop == 1 ) )
							{
								include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/put.php" ) ;
								if ( !$inqueue )
								{
									if ( !$c_routing ) { Ops_put_itr_OpReqStat( $dbh, $deptid, $opinfo_next["opID"], "requests", 1 ) ; }
									else
									{
										Ops_put_itr_OpReqStat( $dbh, 0, $opinfo_next["opID"], "requests", 1 ) ;
									}
									Chat_put_RstatsLog( $dbh, $requestinfo["ces"], 0, $deptid, $opinfo_next["opID"] ) ;
								}
								else if ( isset( $queueinfo["ces"] ) )
								{
									$ops_d = $queueinfo["ops_d"] ;
									$temp = $opinfo_next["opID"]."," ;
									if ( !preg_match( "/$temp/", $ops_d ) )
									{
										Ops_put_itr_OpReqStat( $dbh, 0, $opinfo_next["opID"], "requests", 1 ) ;
										Chat_put_RstatsLog( $dbh, $requestinfo["ces"], 0, $deptid, $opinfo_next["opID"] ) ;
									}
								}
							}
							else if ( ( $requestinfo["status"] != 2 ) && !$requestinfo["op2op"] && $loop && $inqueue )
							{
								include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/put.php" ) ;

								Ops_put_itr_OpReqStat( $dbh, 0, $opinfo_next["opID"], "requests", 1 ) ;
								Chat_put_RstatsLog( $dbh, $requestinfo["ces"], 0, $deptid, $opinfo_next["opID"] ) ;
							} $json_data = "json_data = { \"status\": 2, \"opid\": $opinfo_next[opID], \"q_ops\": \"$opinfo_next[q_ops]\" };" ;
						}
						else
						{
							// if $inqueue no looping because it looped already
							if ( ( $requestinfo["status"] != 2 ) && !$requestinfo["op2op"] && ( $loop < $rloop ) && !$inqueue )
							{
								Chat_update_itr_ResetChat( $dbh, $requestinfo["requestID"] ) ;
								$json_data = "json_data = { \"status\": 2, \"opid\": 0, \"reset\": 1 };" ;
							}
							else
							{
								include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/put.php" ) ;
								include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/update.php" ) ;
								include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_itr.php" ) ;

								// get all the ops online for comparison
								$q_ops_array = Ops_get_itr_OpsOnlineIDs( $dbh, $deptid ) ; $total_ops = count( $q_ops_array ) ;
								$q_ops_online = ( is_array( $q_ops_array ) ) ? preg_replace( "/ /", "", implode( ",", $q_ops_array ) ) : "" ;

								if ( ( $requestinfo["status"] != 2 ) && !$requestinfo["op2op"] && $inqueue && ( $loop > 1 ) )
								{
									include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;
									Ops_put_itr_OpReqStat( $dbh, $requestinfo["deptID"], $requestinfo["opID"], "declined", 1 ) ;
								}

								LIST( $ces ) = database_mysql_quote( $dbh, $requestinfo["ces"] ) ;
								$query = "DELETE FROM p_requests WHERE ces = '$ces'" ;
								database_mysql_query( $dbh, $query ) ;
								Queue_update_OpDeclined( $dbh, $requestinfo["ces"], $requestinfo["opID"] ) ;
								$json_data = "json_data = { \"status\": 10, \"q_ops\": \"$q_ops_online\" };" ;
							}
						}
					}
				}
			}
		}
	}

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	print $json_data ; exit ;
?>