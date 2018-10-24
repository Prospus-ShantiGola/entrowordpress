<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$opid = isset( $_COOKIE["cO"] ) ? Util_Format_Sanatize( $_COOKIE["cO"], "n" ) : "" ;
	$ses = isset( $_COOKIE["cS"] ) ? Util_Format_Sanatize( $_COOKIE["cS"], "ln" ) : "" ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;

	if ( !$opid || !is_file( "$CONF[TYPE_IO_DIR]/$opid"."_ses_$ses.ses" ) )
		$json_data = "json_data = { \"status\": -1 };" ;
	else if ( $action === "decline" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_itr.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;

		$requestid = Util_Format_Sanatize( Util_Format_GetVar( "requestid" ), "n" ) ;
		$isop = Util_Format_Sanatize( Util_Format_GetVar( "isop" ), "n" ) ;
		$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "lns" ) ;
		$op2op = Util_Format_Sanatize( Util_Format_GetVar( "op2op" ), "n" ) ;
		$status = Util_Format_Sanatize( Util_Format_GetVar( "status" ), "n" ) ;

		$requestinfo = Chat_get_itr_RequestCesInfo( $dbh, $ces ) ;
		if ( isset( $requestinfo["opID"] ) )
		{
			if ( ( $op2op || ( $status == 2 ) ) && ( ( $requestinfo["opID"] == $isop ) || ( $requestinfo["op2op"] == $isop ) ) && ( $status == $requestinfo["status"] ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
				include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove.php" ) ;

				if ( !$status )
				{
					$text = "<c615><disconnected><d4><div class='cl'>Operator was not available for op2op chat.  Chat session has ended.</div></c615>" ;
					$filename = $ces."-".$requestinfo["opID"] ;
					UtilChat_AppendToChatfile( "$ces.txt", $text ) ;
					UtilChat_AppendToChatfile( "$filename.text", $text ) ;
					Chat_remove_Request( $dbh, $requestinfo["requestID"] ) ;
				}
				else
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
					include_once( "$CONF[DOCUMENT_ROOT]/ops/inc_chat_transfer.php" ) ;
				}
			}
			else if ( $requestinfo["opID"] == $isop )
			{
				// not a transfer, a standard request
				Chat_update_RequestValue( $dbh, $requestid, "vupdated", 615 ) ;
			}
			else if ( $requestinfo["opID"] == 1111111111 )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;
				include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/update.php" ) ;

				$sim_ops = Util_Format_ExplodeString( "-", $requestinfo["sim_ops"] ) ;
				Ops_put_itr_OpReqStat( $dbh, $requestinfo["deptID"], $isop, "declined", 1 ) ;
				Queue_update_OpDeclined( $dbh, $ces, $isop ) ;

				$sim_string = "$isop-" . $requestinfo["sim_ops_"] ;
				Chat_update_RequestValue( $dbh, $requestid, "sim_ops_", $sim_string ) ;
				$sim_ops_ = Util_Format_ExplodeString( "-", $sim_string ) ;

				if ( count( $sim_ops_ ) == count( $sim_ops ) )
					Chat_update_RequestValue( $dbh, $requestid, "vupdated", 615 ) ;
			}
			$json_data = "json_data = { \"status\": 1, \"ces\": \"$ces\" };" ;
		}
		else { $json_data = "json_data = { \"status\": 1, \"ces\": \"$ces\" };" ; } // output success, chat doesn't exist anyway
	}
	else
		$json_data = "json_data = { \"status\": 0 };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print $json_data ; exit ;
?>