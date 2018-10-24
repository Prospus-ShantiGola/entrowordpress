<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;

	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$accept_decline = Util_Format_Sanatize( Util_Format_GetVar( "flag" ), "ln" ) ;

	if ( $action === "submit" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;

		$token = Util_Format_Sanatize( Util_Format_GetVar( "token" ), "ln" ) ;

		$now = time() ;
		LIST( $ip, $vis_token ) = Util_IP_GetIP( $token ) ;

		// reset auto initiate timer since visitor took action on the invite image
		$initiate_array = ( isset( $VALS["auto_initiate"] ) && $VALS["auto_initiate"] ) ? unserialize( html_entity_decode( $VALS["auto_initiate"] ) ) : Array() ;
		$auto_initiate_reset = ( isset( $initiate_array["reset"] ) ) ? $initiate_array["reset"] : 0 ;
		if ( !$accept_decline && is_file( "$CONF[TYPE_IO_DIR]/$vis_token.txt" ) )
		{
			unlink( "$CONF[TYPE_IO_DIR]/$vis_token.txt" ) ;
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_itr.php" ) ;

			$requestinfo = Chat_get_itr_RequestGetInfo( $dbh, 0, "", $vis_token ) ;
			if ( isset( $requestinfo["ces"] ) )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/Util.php" ) ;
				include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
				include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

				$ces = $requestinfo["ces"] ;
				$deptinfo = Depts_get_DeptInfo( $dbh, $requestinfo["deptID"] ) ;

				$lang = ( isset( $CONF["lang"] ) ) ? $CONF["lang"] : "english" ;
				if ( $deptinfo["lang"] ) { $CONF["lang"] = $deptinfo["lang"] ; }
				include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize( $CONF["lang"], "ln" ).".php" ) ;

				$text_declined = isset( $LANG["CHAT_INVITE_DECLINED"] ) ? $LANG["CHAT_INVITE_DECLINED"] : "Visitor has declined the chat invite." ;
				$text = "<div class='cl'><disconnected><d2>$text_declined</div>" ;
				$opinfo = Ops_get_OpInfoByID( $dbh, $requestinfo["opID"] ) ;
				$filename = $ces."-".$opinfo["opID"] ;
				UtilChat_AppendToChatfile( "$filename.text", $text ) ;

				$query = "DELETE FROM p_requests WHERE ces = '$ces'" ;
				database_mysql_query( $dbh, $query ) ;
			}
		}
		else if ( $auto_initiate_reset )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/IPs/update.php" ) ;
			$reset = 60*60*$auto_initiate_reset ;
			IPs_update_IpValue( $dbh, $vis_token, "i_footprints", $now + $reset ) ;
		}
		database_mysql_close( $dbh ) ;

		$image_path = "$CONF[DOCUMENT_ROOT]/pics/icons/pixels/1x1.gif" ;
		Header( "Content-type: image/GIF" ) ;
		Header( "Content-Transfer-Encoding: binary" ) ;
		if ( !isset( $VALS['OB_CLEAN'] ) || ( $VALS['OB_CLEAN'] == 'on' ) ) { ob_clean(); flush(); }
		readfile( $image_path ) ; exit ;
	} else { print "Invalid action." ; }
?>