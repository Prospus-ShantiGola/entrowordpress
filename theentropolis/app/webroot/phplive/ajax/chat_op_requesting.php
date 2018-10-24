<?php
	/* status DB request: -1 ended by action taken, 0 waiting pick-up, 1 picked up, 2 transfer */
	$microtime = ( function_exists( "gettimeofday" ) ) ? 1 : 0 ;
	$process_start = ( $microtime ) ? microtime(true) : time() ; $now = time() ;
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "a" ), "ln" ) ;
	$proto = Util_Format_Sanatize( Util_Format_GetVar( "pr" ), "n" ) ;
	$q_cces = Util_Format_Sanatize( Util_Format_GetVar( "qcc" ), "a" ) ;
	$realtime = Util_Format_Sanatize( Util_Format_GetVar( "r" ), "n" ) ;
	$ws = Util_Format_Sanatize( Util_Format_GetVar( "ws" ), "n" ) ;
	if ( !isset( $CONF['foot_log'] ) ) { $CONF['foot_log'] = "on" ; } if ( !isset( $CONF['icon_check'] ) ) { $CONF['icon_check'] = "on" ; }
	$json_status = 0 ; $json_request = $json_chatting = $json_error = "" ;
	if ( $action === "rq" )
	{
		$opid = isset( $_COOKIE["cO"] ) ? Util_Format_Sanatize( $_COOKIE["cO"], "n" ) : 0 ;
		$ses = isset( $_COOKIE["cS"] ) ? Util_Format_Sanatize( $_COOKIE["cS"], "ln" ) : "invalid_ses" ;
		$cookie_cs = substr( $ses, 0, 3 ) ; $cs = Util_Format_Sanatize( Util_Format_GetVar( "cs" ), "ln" ) ;

		if ( !$opid || ( $cookie_cs != $cs ) || !is_file( "$CONF[TYPE_IO_DIR]/$opid"."_ses_$ses.ses" ) )
			$json_status = -1 ;
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_itr.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;

			$prev_status = Util_Format_Sanatize( Util_Format_GetVar( "ps" ), "n" ) ;
			$c_requesting = Util_Format_Sanatize( Util_Format_GetVar( "cr" ), "n" ) ;
			$traffic = Util_Format_Sanatize( Util_Format_GetVar( "tr" ), "n" ) ;
			$mapp = Util_Format_Sanatize( Util_Format_GetVar( "m" ), "n" ) ;
			$q_ces = Util_Format_Sanatize( Util_Format_GetVar( "qc" ), "a" ) ;
			$q_ces_hash = Array() ;

			for ( $c = 0; $c < count( $q_ces ); ++$c ) { $ces = $q_ces[$c] ; $q_ces_hash[$ces] = 1 ; }
			if ( !( $c_requesting % $VARS_CYCLE_CLEAN ) )
			{
				$vars = Util_Format_Get_Vars( $dbh ) ;
				if ( $vars["ts_clean"] <= ( $now - ( $VARS_CYCLE_CLEAN * 2 ) ) )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove_itr.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/remove_itr.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_itr.php" ) ;

					Util_Format_Update_TimeStamp( $dbh, "clean", $now ) ;
					Footprints_remove_itr_Expired_U( $dbh ) ;
					Chat_remove_itr_ExpiredOp2OpRequests( $dbh ) ;
					Chat_remove_itr_OldRequests( $dbh ) ;
					Ops_update_itr_IdleOps( $dbh ) ;
				}
			}
			else if ( !( $c_requesting % ($VARS_CYCLE_CLEAN+1) ) )
			{
				$query = "UPDATE p_operators SET lastactive = $now WHERE opID = $opid" ;
				database_mysql_query( $dbh, $query ) ;
				if ( !database_mysql_nresults( $dbh ) && 0 ) { setcookie( "cS", "invalid", -1, "/" ) ; }
				else
				{
					$query = "UPDATE p_requests SET updated = $now WHERE ( opID = $opid OR op2op = $opid OR opID = 1111111111 ) AND ( status = 0 OR status = 1 OR status = 2 )" ;
					database_mysql_query( $dbh, $query ) ;
				}
			}

			if ( !( $c_requesting % $VARS_CYCLE_CLEAN_Q ) )
			{
				if ( !isset( $vars ) ) { $vars = Util_Format_Get_Vars( $dbh ) ; }
				if ( $vars["ts_queue"] <= ( $now - ( $VARS_JS_REQUESTING * 3 ) ) )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/remove.php" ) ;

					Util_Format_Update_TimeStamp( $dbh, "queue", $now ) ;
					Queue_remove_ExpiredQueues( $dbh ) ;
				}
			}

			$total_traffics = ( $traffic ) ? Footprints_get_itr_TotalFootprints_U( $dbh ) : 0 ;
			$query = "SELECT * FROM p_requests WHERE ( opID = $opid OR op2op = $opid OR opID = 1111111111 ) AND ( status = 0 OR status = 1 OR status = 2 ) ORDER BY created ASC" ;
			database_mysql_query( $dbh, $query ) ;

			$requests_temp = Array() ;
			if ( $dbh[ 'ok' ] )
			{
				while ( $data = database_mysql_fetchrow( $dbh ) ) { $requests_temp[] = $data ; }
			} $requests = Array() ;
			for ( $c = 0; $c < count( $requests_temp ); ++$c )
			{
				$requestinfo = $requests_temp[$c] ;
				if ( ( $requestinfo["status"] == 2 ) && ( $requestinfo["op2op"] == $opid ) )
				{
					if ( $requestinfo["tupdated"] < $now )
						include_once( "$CONF[DOCUMENT_ROOT]/ops/inc_chat_transfer.php" ) ;
				}
				else
				{
					// sim ops filter for declined
					if ( !preg_match( "/(^|-)($opid-)/", $requestinfo["sim_ops_"] ) ) { $requests[] = $requestinfo ; }
				}
			}
			$json_status = 1 ;
			$json_request = "\"traffics\": $total_traffics, \"requests\": [  " ;
			for ( $c = 0; $c < count( $requests ); ++$c )
			{
				$req = $requests[$c] ;
				$os = $VARS_OS[$req["os"]] ;
				$browser = $VARS_BROWSER[$req["browser"]] ;
				$title = rawurlencode( preg_replace( "/\"/", "&quot;", $req["title"] ) ) ;
				$question = preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", preg_replace( "/\"/", "&quot;", $req["question"] ) ) ;
				$onpage = rawurlencode( preg_replace( "/hphp/i", "http", $req["onpage"] ) ) ;
				$refer_raw = ( function_exists( "mb_check_encoding" ) && mb_check_encoding( $req["refer"], "UTF-8" ) ) ? preg_replace( "/hphp/i", "http", $req["refer"] ) : "" ;
				$str_snap = ( $mapp ) ? 35 : 50 ;
				$refer_snap = ( strlen( $refer_raw ) > $str_snap ) ? substr( $refer_raw, 0, ($str_snap-5) ) . "..." : $refer_raw ;
				$refer_snap = rawurlencode( $refer_snap ) ;
				$custom = rawurlencode( $req["custom"] ) ;

				// if status is 2 then it's a transfer call... keep original visitor name
				if ( ( $req["status"] != 2 ) && $req["op2op"] )
				{
					if ( $opid == $req["op2op"] ) { $opinfo = Ops_get_OpInfoByID( $dbh, $req["opID"] ) ; }
					else { $opinfo = Ops_get_OpInfoByID( $dbh, $req["op2op"] ) ; }
					$vname = $opinfo["name"] ; $vemail = $opinfo["email"] ;
				}
				else { $vname = $req["vname"] ; $vemail = $req["vemail"] ; }

				if ( ( $req["status"] == 1 ) && ( $req["opID"] == 1111111111 ) )
				{
					$req["status"] = 0 ;
					$query = "UPDATE p_requests SET status = 0 WHERE requestID = $req[requestID]" ;
					database_mysql_query( $dbh, $query ) ;
				}

				if ( isset( $q_ces_hash[$req["ces"]] ) )
					$json_request .= "{ \"rid\": $req[requestID], \"ces\": \"$req[ces]\", \"did\": $req[deptID], \"tv\": $req[t_vses], \"status\": $req[status], \"vup\": \"$req[vupdated]\" }," ;
				else
				{
					$country = strtolower( $req["country"] ) ;
					$json_request .= "{ \"rid\": $req[requestID], \"ces\": \"$req[ces]\", \"created\": \"$req[created]\", \"now\": \"$now\", \"did\": $req[deptID], \"opid\": $req[opID], \"op2op\": $req[op2op], \"tv\": $req[t_vses], \"vname\": \"$vname\", \"status\": $req[status], \"auto_pop\": $req[auto_pop], \"initiated\": $req[initiated], \"os\": \"$os\", \"browser\": \"$browser\", \"requests\": \"$req[requests]\", \"resolution\": \"$req[resolution]\", \"vemail\": \"$vemail\", \"ip\": \"$req[ip]\", \"vis_token\": \"$req[md5_vis_]\", \"onpage\": \"$onpage\", \"title\": \"$title\", \"question\": \"$question\", \"marketid\": \"$req[marketID]\", \"refer_raw\": \"$refer_raw\", \"refer_snap\": \"$refer_snap\", \"custom\": \"$custom\", \"vup\": \"$req[vupdated]\", \"country\": \"$country\" }," ;
				}
			} $json_request = substr_replace( $json_request, "", -1 ) ;
			$json_request .= "	] " ;
		}
	}
	if ( count( $q_cces ) )
	{
		if ( $ws )
			$json_chatting = " \"status\": 1, \"istyping\": 0, \"chats\": [  ] " ;
		else
		{
			$ces = Util_Format_Sanatize( Util_Format_GetVar( "c" ), "ln" ) ;
			$isop = Util_Format_Sanatize( Util_Format_GetVar( "o" ), "n" ) ;
			$isop_ = Util_Format_Sanatize( Util_Format_GetVar( "o_" ), "n" ) ;
			$isop__ = Util_Format_Sanatize( Util_Format_GetVar( "o__" ), "n" ) ;
			$c_chatting = Util_Format_Sanatize( Util_Format_GetVar( "ch" ), "n" ) ;
			$q_chattings = Util_Format_Sanatize( Util_Format_GetVar( "qch" ), "a" ) ;
			$q_isop_ = Util_Format_Sanatize( Util_Format_GetVar( "qo_" ), "a" ) ;
			$q_isop__ = Util_Format_Sanatize( Util_Format_GetVar( "qo__" ), "a" ) ;
			$mapp = Util_Format_Sanatize( Util_Format_GetVar( "mp" ), "n" ) ;
			$fline = Util_Format_Sanatize( Util_Format_GetVar( "f" ), "n" ) ;
			$t_vses = Util_Format_Sanatize( Util_Format_GetVar( "t" ), "n" ) ;

			if ( ( $isop && $isop_ ) && ( $isop == $isop_ ) ) { $iid = $isop__ ; }
			else if ( $isop && $isop_ ) { $iid = $isop_ ; }
			else { $iid = $isop_ ; }
			$filename = $ces.$iid ;
			$istyping = ( is_file( "$CONF[TYPE_IO_DIR]/$filename.txt" ) && !$realtime ) ? 1 : 0 ;
			$json_status = ( $json_status == -1 ) ? -1 : 1 ;
			$json_chatting = " \"istyping\": $istyping, \"chats\": [  " ;

			// if .mapp file, pause fetching of data because of iOS prolonged background situations
			if ( !$isop || ( $isop && !is_file( "$CONF[TYPE_IO_DIR]/$isop.mapp" ) ) )
			{
				for ( $c = 0; $c < count( $q_cces ); ++$c )
				{
					$ces = Util_Format_Sanatize( $q_cces[$c], "lns" ) ;
					$chatting = Util_Format_Sanatize( $q_chattings[$c], "n" ) ;

					if ( ( $isop && $q_isop_[$c] ) && ( $isop == $q_isop_[$c] ) ) { $rid = $q_isop__[$c] ; }
					else if ( $isop && $q_isop_[$c] ) { $rid = $q_isop_[$c] ; }
					else
					{
						if ( $isop ) { $rid = $isop ; }
						else { $rid = $isop."_".$t_vses ; }
					}
					$filename = $ces."-".$rid ;
					if ( !$chatting )
						$chat_file = "$CONF[CHAT_IO_DIR]/$ces.txt" ;
					else
						$chat_file = "$CONF[CHAT_IO_DIR]/$filename.text" ;

					if ( is_file( $chat_file ) )
					{
						$trans_raw = file( $chat_file ) ;
						$trans = explode( "<>", implode( "", $trans_raw ) ) ;
						$file_lines = 0 ;
						if ( !$chatting )
						{
							$file_lines = count( $trans ) - 1 ;
							$text = preg_replace( "/\"/", "&quot;", implode( "<>", array_slice( $trans, $fline, $file_lines-$fline ) ) ) ;
						}
						else
							$text = addslashes( preg_replace( "/\"/", "&quot;", implode( "<>", $trans ) ) ) ;
						$text = preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", $text ) ;

						$json_chatting .= "{ \"ces\": \"$ces\", \"fline\": $file_lines, \"text\": \"$text\" }," ;

						if ( is_file( "$CONF[CHAT_IO_DIR]/$filename.text" ) )
							unlink( "$CONF[CHAT_IO_DIR]/$filename.text" ) ;
					}
					else if ( !is_file( "$CONF[CHAT_IO_DIR]/$ces.txt" ) )
					{
						// Duplicate in WS
						include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
						include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;
						include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

						LIST( $ces ) = database_mysql_quote( $dbh, $ces ) ;
						$query = "DELETE FROM p_requests WHERE ces = '$ces'" ;
						database_mysql_query( $dbh, $query ) ;

						$lang = $CONF["lang"] ;
						$requestinfo_log = Chat_get_RequestHistCesInfo( $dbh, $ces ) ;
						$deptinfo = Depts_get_DeptInfo( $dbh, $requestinfo_log["deptID"] ) ;
						if ( $deptinfo["lang"] ) { $lang = $deptinfo["lang"] ; }
						include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($lang, "ln").".php" ) ;
						$json_chatting .= "{ \"ces\": \"$ces\", \"text\": \"<div class='cl'><disconnected><d5>".$LANG["CHAT_NOTIFY_DISCONNECT"]."</div>\" }," ;
					}

					if ( !$isop && ( !( $c_chatting % $VARS_CYCLE_VUPDATE ) ) && !$realtime )
					{
						// Duplicate in WS
						include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
						include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;
						$requestid = Util_Format_Sanatize( Util_Format_GetVar( "rq" ), "n" ) ;
						$mobile = Util_Format_Sanatize( Util_Format_GetVar( "mo" ), "n" ) ;

						$vupdated = ( $mobile ) ? $now + $VARS_MOBILE_CHAT_BUFFER : $now ;
						Chat_update_RequestValue( $dbh, $requestid, "vupdated", $vupdated ) ;
						if ( $mapp && is_file( "$CONF[TYPE_IO_DIR]/$isop_".".mapp" ) ) { Chat_update_RequestValue( $dbh, $requestid, "updated", $vupdated ) ; }
					}
					else if ( !$isop && ( !( $c_chatting % $VARS_CYCLE_CLEAN ) ) && !$realtime )
					{
						// Duplicate in WS
						include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;

						if ( !isset( $vars ) ) { $vars = Util_Format_Get_Vars( $dbh ) ; }
						if ( $vars["ts_clean"] <= ( $now - ( $VARS_CYCLE_CLEAN * 2 ) ) )
						{
							include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove_itr.php" ) ;
							Util_Format_Update_TimeStamp( $dbh, "clean", $now ) ;
							Chat_remove_itr_OldRequests( $dbh ) ;
						}
					}
				}
			} $json_chatting = substr_replace( $json_chatting, "", -1 ) ; $json_chatting .= "	] " ;
		}
	}
	if ( isset( $dbh ) && isset( $dbh['con'] ) ) { database_mysql_close( $dbh ) ; }

	$process_end = ( $microtime ) ? microtime(true) : time() ;
	$pd = $process_end - $process_start ; if ( !$pd ) { $pd = 0.001 ; }
	$pd = str_replace( ",", ".", $pd ) ; if ( is_numeric( $pd ) ) { $pd = number_format( $pd, 5 ) ; }

	if ( $json_request ) { $json_request .= ", " ; }
	if ( $json_chatting ) { $json_chatting .= ", " ; }
	$json_data = "json_data = { \"status\": $json_status, $json_request $json_chatting pd: $pd, \"e\": \"$json_error\" };" ;
	$json_data = preg_replace( "/\r\n/", "", $json_data ) ; $json_data = preg_replace( "/\t/", "", $json_data ) ; print $json_data ; exit ;
?>