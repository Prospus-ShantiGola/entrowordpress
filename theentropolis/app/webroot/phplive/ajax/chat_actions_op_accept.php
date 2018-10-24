<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$opid = isset( $_COOKIE["cO"] ) ? Util_Format_Sanatize( $_COOKIE["cO"], "n" ) : "" ;
	$ses = isset( $_COOKIE["cS"] ) ? Util_Format_Sanatize( $_COOKIE["cS"], "ln" ) : "" ;
	$ws = Util_Format_Sanatize( Util_Format_GetVar( "ws" ), "n" ) ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ; $now = time() ;

	if ( !$opid || !is_file( "$CONF[TYPE_IO_DIR]/$opid"."_ses_$ses.ses" ) )
		$json_data = "json_data = { \"status\": -1 };" ;
	else if ( $action === "accept" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_itr.php" ) ;

		$requestid = Util_Format_Sanatize( Util_Format_GetVar( "requestid" ), "n" ) ;
		$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "lns" ) ;
		$op_now = Util_Format_Sanatize( Util_Format_GetVar( "now" ), "n" ) ;
		$t_vses = Util_Format_Sanatize( Util_Format_GetVar( "t_vses" ), "n" ) ;
		$tooslow = 0 ; $ws_bypass = 0 ;

		$requestinfo = Chat_get_itr_RequestCesInfo( $dbh, $ces ) ;
		if ( !isset( $requestinfo["status"] ) || ( $requestinfo["vupdated"] == 1 ) || ( ( $requestinfo["vupdated"] < ( $now - $VARS_EXPIRED_REQS ) ) && !$requestinfo["op2op"] ) || ( $requestinfo["status"] && ( $requestinfo["opID"] != $opid ) ) )
			$tooslow = 1 ;
		else if ( $ws && ( $requestinfo["status"] == 1 ) )
			$ws_bypass = 1 ;
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;

			$opinfo = ( $requestinfo["opID"] != 1111111111 ) ? Ops_get_OpInfoByID( $dbh, $requestinfo["opID"] ) : Ops_get_OpInfoByID( $dbh, $opid ) ;
			Ops_update_OpValue( $dbh, $opid, "lastrequest", $now ) ;
			Chat_update_AcceptChat( $dbh, $requestinfo["requestID"], $opid, $requestinfo["status"], $requestinfo["op2op"] ) ;

			$lang = $CONF["lang"] ;
			$deptinfo = Depts_get_DeptInfo( $dbh, $requestinfo["deptID"] ) ;
			if ( $deptinfo["lang"] ) { $lang = $deptinfo["lang"] ; }
			include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($lang, "ln").".php" ) ;

			// delete the transfer flag file (created at ops/inc_chat_transfer.php)
			$filename_declined = $ces."-de" ;
			if ( is_file( "$CONF[CHAT_IO_DIR]/$filename_declined.text" ) )
				unlink( "$CONF[CHAT_IO_DIR]/$filename_declined.text" ) ;

			// if transferred, keep the same created time (status 2 is transferred)
			if ( $requestinfo["status"] != 2 )
			{
				if ( ( $opid != $requestinfo["opID"] ) && ( $requestinfo["opID"] != 1111111111 ) )
					$tooslow = 1 ;
				else
				{
					if ( $requestinfo["opID"] == 1111111111 )
					{
						Chat_update_RequestValue( $dbh, $requestid, "opID", $opid ) ;
						Chat_update_RequestLogValue( $dbh, $ces, "opID", $opid ) ;
					}
					if ( !$requestinfo["initiated"] )
					{
						Chat_update_RstatsLogValue( $dbh, $ces, $opid, "status", 1 ) ;
						Ops_put_itr_OpReqStat( $dbh, $requestinfo["deptID"], $opid, "taken", 1 ) ;
					}

					if ( !$requestinfo["initiated"] && !$requestinfo["op2op"] )
					{
						include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;
						$requestinfo_log = Chat_get_RequestHistCesInfo( $dbh, $ces ) ; // due to queue need to fetch log value

						$accepted_dept = $now-$requestinfo_log["created"] ; if ( $accepted_dept <= 0 ) { $accepted_dept = 1 ; }
						$accepted_op = $now-$op_now ; if ( $accepted_op <= 0 ) { $accepted_op = 1 ; }
						Chat_update_RequestLogValues( $dbh, $ces, "accepted", $accepted_dept, "accepted_op", $accepted_op ) ;
					}
					Chat_update_RequestValues( $dbh, $requestid, "created", $now, "tloop", 0 ) ; // update request created for chat timer
	
					$text = "<div class='ca'><b>$opinfo[name]</b> ".$LANG["CHAT_NOTIFY_JOINED"]."</div>" ;
					UtilChat_AppendToChatfile( "$ces.txt", $text ) ;

					if ( $requestinfo["op2op"] && ( $requestinfo["status"] != 2 ) )
					{
						$filename = $ces."-".$requestinfo["op2op"];
						UtilChat_AppendToChatfile( "$filename.text", $text ) ;

						$filename = $ces."-".$requestinfo["opID"] ;
						UtilChat_AppendToChatfile( "$filename.text", $text ) ;
					}
					else if ( $requestinfo["opID"] && ( $requestinfo["opID"] != 1111111111 ) )
					{
						// when the chat transcript was transferred back to original operator
						$filename = $ces."-0_".$requestinfo["opID"] ;
						UtilChat_AppendToChatfile( "$filename.text", "<idle_restart>".$text."<idle_restart>" ) ;
					}
					include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/update.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/remove.php" ) ;
					Queue_update_QueueLogValueByCes( $dbh, $ces, "status", 1, 0 ) ;
					Queue_remove_Queue( $dbh, $ces ) ;
				}
			}
			else
			{
				// reset the op2op as it was used for the original opID for transfer back
				Chat_update_RequestValue( $dbh, $requestid, "op2op", 0 ) ;

				$text = "<idle_restart><div class='ca'><b>$opinfo[name]</b> ".$LANG["CHAT_NOTIFY_JOINED"]."</div></idle_restart>" ;
				UtilChat_AppendToChatfile( "$ces.txt", $text ) ;
				$max_vses = ( $t_vses > $VARS_MAX_EMBED_SESSIONS ) ? $VARS_MAX_EMBED_SESSIONS : $t_vses ;
				for ( $c = 1; $c <= $max_vses; ++$c )
				{
					$filename = $ces."-0"."_".$c ;
					UtilChat_AppendToChatfile( "$filename.text", $text ) ;
				}
			}
			Chat_update_RequestLogValue( $dbh, $ces, "status", 1 ) ;
		}
		if ( $tooslow ) { $json_data = "json_data = { \"status\": 1, \"tooslow\": 1 };" ; }
		else if ( $ws_bypass ) { $json_data = "json_data = { \"status\": 1, \"tooslow\": 0 };" ; }
		else { $json_data = "json_data = { \"status\": 1, \"tooslow\": 0 };" ; }
	}
	else { $json_data = "json_data = { \"status\": 0 };" ; }

	if ( isset( $dbh ) && $dbh['con'] ) { database_mysql_close( $dbh ) ; }
	print $json_data ; exit ;
?>