<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$ip = Util_Format_Sanatize( Util_Format_GetVar( "ip" ), "ln" ) ;

	if ( $action === "disconnect" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_itr.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/update.php" ) ;

		$isop = Util_Format_Sanatize( Util_Format_GetVar( "isop" ), "n" ) ;
		$isop_ = Util_Format_Sanatize( Util_Format_GetVar( "isop_" ), "n" ) ;
		$isop__ = Util_Format_Sanatize( Util_Format_GetVar( "isop__" ), "n" ) ;
		$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "lns" ) ;
		$t_vses = Util_Format_Sanatize( Util_Format_GetVar( "t_vses" ), "n" ) ;
		$token = Util_Format_Sanatize( Util_Format_GetVar( "token" ), "ln" ) ;
		$vis_token = Util_Format_Sanatize( Util_Format_GetVar( "vis_token" ), "ln" ) ;
		$vclick = Util_Format_Sanatize( Util_Format_GetVar( "vclick" ), "n" ) ;
		$ws = Util_Format_Sanatize( Util_Format_GetVar( "ws" ), "n" ) ;
		$idle = Util_Format_Sanatize( Util_Format_GetVar( "idle" ), "ln" ) ; $idle = ( is_numeric( $idle ) && ( $idle == -1 ) ) ? 1 : 0 ;

		$now = time() ;
		if ( !$vis_token ) { LIST( $ip, $vis_token ) = Util_IP_GetIP( $token ) ; }

		$requestinfo = Chat_get_itr_RequestCesInfo( $dbh, $ces ) ;
		if ( isset( $requestinfo["requestID"] ) && ( $requestinfo["status"] || $requestinfo["initiated"] ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/put_itr.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/remove.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

			$lang = $CONF["lang"] ;
			$deptinfo = Depts_get_DeptInfo( $dbh, $requestinfo["deptID"] ) ;
			$deptvars = Depts_get_DeptVars( $dbh, $requestinfo["deptID"] ) ;
			if ( $deptinfo["lang"] ) { $lang = $deptinfo["lang"] ; }
			include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($lang, "ln").".php" ) ;
			if ( isset( $deptinfo["smtp"] ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;
				$smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $deptinfo["smtp"] ) ) ;
			}

			$filename_ws = $ces."-ws" ;
			if ( $isop )
			{
				$text = "<div class='cl'><disconnected><d1>".$LANG["CHAT_NOTIFY_ODISCONNECT"]."</div>" ;
				if ( $requestinfo["op2op"] )
				{
					if ( ( $isop && $isop_ ) && ( $isop == $isop_ ) ) { $wid = $isop_ ; }
					else if ( $isop && $isop_ ) { $wid = $isop__ ; }
					else { $wid = $isop_ ; }
					$filename = $ces."-$wid" ;
					UtilChat_AppendToChatfile( "$filename.text", $text ) ;
					if ( $ws )
					{
						UtilChat_AppendToChatfile( "$filename_ws.text", $text ) ;
					}
				}
				else
				{
					$max_vses = ( $requestinfo["t_vses"] > $VARS_MAX_EMBED_SESSIONS ) ? $VARS_MAX_EMBED_SESSIONS : $requestinfo["t_vses"] ;
					for ( $c = 1; $c <= $max_vses; ++$c )
					{
						$filename = $ces."-0"."_".$c ;
						UtilChat_AppendToChatfile( "$filename.text", $text ) ;
					}
					if ( $ws )
					{
						UtilChat_AppendToChatfile( "$filename_ws.text", $text ) ;
					}
				}
				UtilChat_AppendToChatfile( "$ces.txt", $text ) ;
			}
			else
			{
				if ( $requestinfo["initiated"] && !$requestinfo["status"] )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;

					$text = "<div class='cl'><disconnected><d2>Visitor has declined the chat invite.</div>" ;
					$opinfo = Ops_get_OpInfoByID( $dbh, $requestinfo["opID"] ) ;
					$filename = $ces."-".$opinfo["opID"] ;
					UtilChat_AppendToChatfile( "$filename.text", $text ) ;
				}
				else
				{
					$text = "<div class='cl'><disconnected><d2>".$LANG["CHAT_NOTIFY_VDISCONNECT"]."</div>" ;
					$filename = $ces."-".$isop_ ;
					UtilChat_AppendToChatfile( "$filename.text", $text ) ;

					// check all sessions to indicate disconnect for notification
					$max_vses = ( $requestinfo["t_vses"] > $VARS_MAX_EMBED_SESSIONS ) ? $VARS_MAX_EMBED_SESSIONS : $requestinfo["t_vses"] ;
					for ( $c = 1; $c <= $max_vses; ++$c )
					{
						if ( $c != $t_vses )
						{
							$filename = $ces."-0"."_".$c ;
							UtilChat_AppendToChatfile( "$filename.text", $text ) ;
						}
					}
					if ( $ws )
					{
						UtilChat_AppendToChatfile( "$filename_ws.text", $text ) ;
					}
				}
				UtilChat_AppendToChatfile( "$ces.txt", $text ) ;
			}

			if ( !$requestinfo["initiated"] || ( $requestinfo["initiated"] && $requestinfo["status"] ) )
			{
				$output = UtilChat_ExportChat( "$ces.txt" ) ;
				if ( isset( $output[0] ) )
				{
					$formatted = $output[0] ; $plain = $output[1] ;
					$fsize = strlen( $formatted ) ;
					$vis_token = ( $requestinfo["md5_vis"] ) ? $requestinfo["md5_vis"] : $vis_token ;
					
					$custom_string = "" ;
					$customs = explode( "-cus-", rawurldecode( $requestinfo["custom"] ) ) ;
					for ( $c = 0; $c < count( $customs ); ++$c )
					{
						$custom_var = $customs[$c] ;
						if ( $custom_var && preg_match( "/-_-/", $custom_var ) )
						{
							LIST( $cus_name, $cus_var ) = explode( "-_-", $custom_var ) ;
							if ( $cus_var ) { $custom_string .= $cus_name.": ".$cus_var."\r\n" ; }
						}
					}
					if ( Chat_put_itr_Transcript( $dbh, $ces, $requestinfo["status"], $requestinfo["created"], $now, $requestinfo["deptID"], $requestinfo["opID"], $requestinfo["initiated"], $requestinfo["op2op"], 0, $fsize, $requestinfo["vname"], $requestinfo["vemail"], $requestinfo["ip"], $vis_token, $custom_string, $requestinfo["question"], $formatted, $plain, $deptinfo, $deptvars ) )
					{
						if ( $idle ) { Chat_update_RequestLogValue( $dbh, $ces, "idle_disconnect", 1 ) ; }
						Chat_remove_Request( $dbh, $requestinfo["requestID"] ) ;
						Chat_update_RecentChat( $dbh, $requestinfo["opID"], $ces, 0 ) ;
					}
				}
			}
			else if ( $requestinfo["initiated"] || $requestinfo["status"] )
				Chat_remove_Request( $dbh, $requestinfo["requestID"] ) ;
		}
		else if ( isset( $requestinfo["requestID"] ) && !$requestinfo["status"] )
		{
			if ( $isop && ( $requestinfo["opID"] != $isop ) )
			{
				if ( $requestinfo["op2op"] )
				{
					LIST( $ces ) = database_mysql_quote( $dbh, $requestinfo["ces"] ) ;
					$query = "DELETE FROM p_requests WHERE ces = '$ces'" ;
					database_mysql_query( $dbh, $query ) ;
				}
			}
			else
			{
				LIST( $ces ) = database_mysql_quote( $dbh, $requestinfo["ces"] ) ;
				$query = "DELETE FROM p_requests WHERE ces = '$ces'" ;
				database_mysql_query( $dbh, $query ) ;
			}
		}
		else
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/get.php" ) ;

			$queueinfo = Queue_get_InfoByCes( $dbh, $ces ) ;
			if ( isset( $queueinfo["ces"] ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/remove.php" ) ;
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/put_itr.php" ) ;
				include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/update.php" ) ;

				Queue_remove_Queue( $dbh, $requestinfo["ces"] ) ;
			}
		}

		if ( $ces ) { clear_istyping( $ces ) ; }
		Footprints_update_FootprintUniqueValue( $dbh, $vis_token, "chatting", 0 ) ;

		$json_data = "json_data = { \"status\": 1, \"ces\": \"$ces\" };" ;
	}
	else
		$json_data = "json_data = { \"status\": 0 };" ;

	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;

	print $json_data ; exit ;

	function clear_istyping( $ces )
	{
		global $CONF ;
		if ( $ces )
		{
			$dir_files = glob( $CONF["TYPE_IO_DIR"]."/$ces"."*", GLOB_NOSORT ) ;
			$total_dir_files = count( $dir_files ) ;
			if ( $total_dir_files )
			{
				for ( $c = 0; $c < $total_dir_files; ++$c )
				{
					if ( $dir_files[$c] && is_file( $dir_files[$c] ) ) { unlink( $dir_files[$c] ) ; }
				}
			}
		}
	}
?>
