<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "ln" ) ;
	$token = Util_Format_Sanatize( Util_Format_GetVar( "token" ), "ln" ) ;
	$token_ces = Util_Format_Sanatize( Util_Format_GetVar( "token_ces" ), "ln" ) ;
	$now = time() ;

	if ( $action == "create" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;

		LIST( $ip, $vis_token ) = Util_IP_GetIP( $token ) ;
		$token_ces_ = md5( "$ces$CONF[SALT]" ) ;
		
		if ( $token_ces == $token_ces_ )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/put.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
			
			$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
			$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "lns" ) ;
			$auto_pop = Util_Format_Sanatize( Util_Format_GetVar( "auto_pop" ), "n" ) ;
			$vname = Util_Format_Sanatize( Util_Format_GetVar( "vname" ), "ln" ) ; $vname_orig = $vname ;
			$vemail = Util_Format_Sanatize( Util_Format_GetVar( "vemail" ), "e" ) ; $vemail = ( !$vemail ) ? "null" : $vemail ;
			$vsubject = rawurldecode( Util_Format_Sanatize( Util_Format_GetVar( "vsubject" ), "htmltags" ) ) ;
			$question = Util_Format_Sanatize( Util_Format_GetVar( "vquestion" ), "htmltags" ) ; $question = ( $question ) ? $question : "" ;
			$onpage = rawurldecode( Util_Format_Sanatize( Util_Format_GetVar( "onpage" ), "url" ) ) ; $onpage = ( $onpage ) ? $onpage : "" ;
			$refer = rawurldecode( Util_Format_Sanatize( Util_Format_GetVar( "refer" ), "url" ) ) ; $refer = ( $refer ) ? $refer : "" ;
			$title = Util_Format_Sanatize( Util_Format_GetVar( "title" ), "title" ) ; $title = ( $title ) ? $title : "" ;
			$resolution = Util_Format_Sanatize( Util_Format_GetVar( "win_dim" ), "ln" ) ;
			$rtype = Util_Format_Sanatize( Util_Format_GetVar( "rtype" ), "n" ) ;
			$rstring = Util_Format_Sanatize( Util_Format_GetVar( "rstring" ), "ln" ) ;
			$inqueue = Util_Format_Sanatize( Util_Format_GetVar( "iq" ), "n" ) ;
			$embed = Util_Format_Sanatize( Util_Format_GetVar( "embed" ), "n" ) ;
			$marketid = Util_Format_Sanatize( Util_Format_GetVar( "marketid" ), "n" ) ;
			$proto = Util_Format_Sanatize( Util_Format_GetVar( "proto" ), "n" ) ;
			$custom = Util_Format_Sanatize( Util_Format_GetVar( "custom" ), "htmltags" ) ;
			$sim_ops = "" ; $vis_token_embed = ( $embed ) ? $vis_token : "" ;

			$agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : "&nbsp;" ;
			LIST( $os, $browser ) = Util_Format_GetOS( $agent ) ;
			$mobile = ( $os == 5 ) ? 1 : 0 ;

			$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
			if ( isset( $deptinfo["deptID"] ) )
			{
				$opid = 0 ;
				if ( $rtype < 3 )
				{
					// just creat chat session
					// let routing script (ajax/chat_routing.php) do the processings
					include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/update.php" ) ;
					Queue_update_QueueValueByCes( $dbh, $ces, "updated", $now+($VARS_JS_REQUESTING*$VARS_CYCLE_CLEAN_Q) ) ; // extra buffer to ensure it stays in queue
					Queue_update_QueueLogValueByCes( $dbh, $ces, "ended", time(), 1 ) ; // update just the first time
				}
				else
				{
					if ( $deptinfo["lang"] ) { $CONF["lang"] = $deptinfo["lang"] ; }
					$opid = 1111111111 ;
					$opinfo_next = Array( "rate" => 0, "sms" => 0 ) ;
					$sim_operators = Depts_get_DeptOps( $dbh, $deptid, 1 ) ;
					$total_sim_ops = count( $sim_operators ) ;
					for ( $c = 0; $c < $total_sim_ops; ++$c )
					{
						$operator = $sim_operators[$c] ;
						$sim_opid = $operator["opID"] ;
						$sim_ops .= "$sim_opid-" ;
					}
				}

				$vses = 1 ; // must be at least 1 session
				$requestid = Chat_put_Request( $dbh, $deptid, $opid, 0, 0, 0, $vses, $os, $browser, $ces, $resolution, $vname, $vemail, $ip, $vis_token_embed, $vis_token, $onpage, $title, $question, $marketid, $refer, $rstring, $custom, $auto_pop, $sim_ops ) ;

				if ( $requestid )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/IPs/put.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/update.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;

					IPs_put_IP( $dbh, $ip, $vis_token, $deptid, 0, 1, 0, 1, 0, 0, true ) ;
					Chat_put_ReqLog( $dbh, $requestid ) ;
					Footprints_update_FootprintUniqueValue( $dbh, $vis_token, "requests", "requests + 1" ) ;
					Footprints_update_FootprintUniqueValue( $dbh, $vis_token, "chatting", 1 ) ;

					if ( $sim_ops )
					{
						Ops_put_itr_OpReqStat( $dbh, $deptid, 0, "requests", 1 ) ;
						for ( $c = 0; $c < $total_sim_ops; ++$c )
						{
							$operator = $sim_operators[$c] ;
							$sim_opid = $operator["opID"] ;

							Chat_put_RstatsLog( $dbh, $ces, 0, $deptid, $operator["opID"] ) ;
							Ops_put_itr_OpReqStat( $dbh, 0, $operator["opID"], "requests", 1 ) ;

							if ( ( $operator["sms"] == 1 ) || is_file( "$CONF[TYPE_IO_DIR]/$sim_opid.mapp" ) )
							{
								$inc_question = $question ;
								$mapp_opid = $sim_opid ;
								$sms_oname = $operator["name"] ; $sms_oemail = $operator["email"] ;
								$sms_vname = rawurlencode( $vname ) ; $sms_num = $operator["smsnum"] ;
								include( "$CONF[DOCUMENT_ROOT]/ajax/inc_request_sms.php" ) ;
							}
						}
					}
					else
					{
						include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
						$opinfo_next = Ops_get_NextRequestOp( $dbh, 0, $deptid, $rtype, $rstring ) ;
						if ( !isset( $opinfo_next["opID"] ) )
							Ops_put_itr_OpReqStat( $dbh, $deptid, 0, "requests", 1 ) ;
					}

					if ( !isset( $CONF["cookie"] ) || ( $CONF["cookie"] == "on" ) )
					{
						if ( $vname_orig != "null" ) { setcookie( "phplive_vname", $vname_orig, $now+60*60*24*365 ) ; }
						if ( $vemail != "null" ) { setcookie( "phplive_vemail", $vemail, $now+60*60*24*365 ) ; }
					}

					$text = ( $question ) ? "<div class='ca'><i>".$question."</i></div>" : "<div class='ca'><i></i></div>" ;
					if ( !is_file( "$CONF[CHAT_IO_DIR]/$ces.txt" ) ) { UtilChat_AppendToChatfile( "$ces.txt", $text ) ; }
					$json_data = "json_data = { \"status\": 1, \"requestid\": $requestid };" ;
				}
				else { $json_data = "json_data = { \"status\": 0, \"error\": \"System error [".Util_Format_StripQuotes( $dbh["error"] )."].  Close the chat window and please try again.\" };" ; }
			}
			else { $json_data = "json_data = { \"status\": 0, \"error\": \"Invalid request [d].  Close the chat window and please try again.\" };" ; }
		}
		else { $json_data = "json_data = { \"status\": 0, \"error\": \"Invalid request [s].  Close the chat window and please try again.\" };" ; }
	}
	else { $json_data = "json_data = { \"status\": 0, \"error\": \"Invalid action.  Close the chat window and please try again.\" };" ; }

	if ( isset( $dbh ) && $dbh['con'] ) { database_mysql_close( $dbh ) ; }
	print $json_data ; exit ;
?>
