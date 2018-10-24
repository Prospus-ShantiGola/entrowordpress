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
	else if ( $action === "initiate" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_itr.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/put.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/get_itr.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/IPs/put.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

		$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
		$vis_token = Util_Format_Sanatize( Util_Format_GetVar( "vis_token" ), "ln" ) ;
		$question = Util_Format_Sanatize( Util_Format_GetVar( "question" ), "" ) ;

		if ( $question && $deptid && $vis_token )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_ext.php" ) ;
			$ces = Util_Functions_ext_GenerateCes( $dbh ) ;
			$query = "SELECT * FROM p_footprints_u WHERE md5_vis = '$vis_token' LIMIT 1" ;
			database_mysql_query( $dbh, $query ) ; $footprintinfo = database_mysql_fetchrow( $dbh ) ;
			$opinfo = Ops_get_OpInfoByID( $dbh, $opid ) ;

			if ( isset( $opinfo["opID"] ) && isset( $footprintinfo["ip"] ) )
			{
				$requestinfo = Chat_get_itr_RequestGetInfo( $dbh, 0, "", $vis_token ) ;
				if ( !isset( $requestinfo["requestID"] ) )
				{
					if ( $requestid = Chat_put_Request( $dbh, $deptid, $opinfo["opID"], 0, 1, 0, 1, $footprintinfo["os"], $footprintinfo["browser"], $ces, $footprintinfo["resolution"], "Visitor", "null", $footprintinfo["ip"], "", $vis_token, $footprintinfo["onpage"], $footprintinfo["title"], $question, 0, $footprintinfo["refer"], "", "" ) )
					{
						include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;
						include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/update.php" ) ;

						$lang = $CONF["lang"] ;
						$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
						if ( $deptinfo["lang"] )
							$lang = $deptinfo["lang"] ;
						include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($lang, "ln").".php" ) ;

						IPs_put_IP( $dbh, $footprintinfo["ip"], $vis_token, $deptid, 0, 0, 1, 1, 0, 0, true ) ;
						Ops_put_itr_OpReqStat( $dbh, $deptid, $opinfo["opID"], "initiated", 1 ) ;
						Chat_put_ReqLog( $dbh, $requestid ) ;
						Footprints_update_FootprintUniqueValue( $dbh, $vis_token, "initiates", "initiates + 1" ) ;
						UtilChat_AppendToChatfile( "$ces.txt", "<div class='ca'><b>".$LANG["CHAT_WELCOME"]."</b></div><div class='co'><b>$opinfo[name]<timestamp_".time()."_co>:</b> $question</div>" ) ;

						if ( !is_file( "$CONF[TYPE_IO_DIR]/$vis_token.txt" ) ) { touch( "$CONF[TYPE_IO_DIR]/$vis_token.txt" ) ; }
						$json_data = "json_data = { \"status\": 1, \"ces\": \"$ces\" };" ;
					}
					else
						$json_data = "json_data = { \"status\": 0, \"error\": \"Could not initiate: $dbh[error]\" };" ;
				}
				else
					$json_data = "json_data = { \"status\": 0, \"error\": \"Chat session already in progress with the visitor.\" };" ;
			}
			else
				$json_data = "json_data = { \"status\": 0, \"error\": \"Visitor has left the website.  Request was not processed.\" };" ;
		}
		else
			$json_data = "json_data = { \"status\": 0, \"error\": \"Blank initiate message or department is invalid.\" };" ;
	}
	else
		$json_data = "json_data = { \"status\": 0 };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	$json_data = preg_replace( "/\r\n/", "", $json_data ) ;
	$json_data = preg_replace( "/\t/", "", $json_data ) ;
	print $json_data ; exit ;
?>