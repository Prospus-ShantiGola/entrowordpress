<?php
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;

	$requestinfo_log = Chat_get_RequestHistCesInfo( $dbh, $requestinfo["ces"] ) ;
	$filename_declined = $requestinfo["ces"]."-de" ; // flag to limit duplicate transfer timeout message

	if ( !is_file( "$CONF[CHAT_IO_DIR]/$filename_declined.text" ) )
	{
		UtilChat_AppendToChatfile( "$filename_declined.text", $ces ) ;
		$opinfo = Ops_get_OpInfoByID( $dbh, $requestinfo["op2op"] ) ; $profile_src = "" ;

		$lang = $CONF["lang"] ;
		$deptinfo = Depts_get_DeptInfo( $dbh, $requestinfo["deptID"] ) ;
		if ( $deptinfo["lang"] ) { $lang = $deptinfo["lang"] ; }
		$lang = Util_Format_Sanatize($lang, "ln") ;
		if ( is_file( "$CONF[DOCUMENT_ROOT]/lang_packs/$lang.php" ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/$lang.php" ) ;

			$text = "<c615><restart_router><d4><div class='ca'>".$LANG["CHAT_TRANSFER_TIMEOUT"]." $LANG[CHAT_TRANSFER] <b>$opinfo[name] ($deptinfo[name])</b>.</div></c615>" ;
		} else { $text = "<c615><restart_router><d4><div class='ca'>Transfer chat not available at this time.  Connecting to the previous operator... Transferring chat to <b>$opinfo[name] ($deptinfo[name])</b>.</div></c615>" ; }

		if ( $opinfo["pic"] )
		{
			if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
			else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
			$profile_src = Util_Upload_GetLogo( "profile", $opinfo["opID"] ) ;
		}

		$text .= "<top><!--opid:$opinfo[opID]--><!--mapp:$opinfo[mapp]--><!--name:$opinfo[name]--><!--profile_pic:$profile_src--><!--department:$deptinfo[name]--></top>" ;
		UtilChat_AppendToChatfile( "$requestinfo[ces].txt", $text ) ;

		$max_vses = ( $requestinfo["t_vses"] > $VARS_MAX_EMBED_SESSIONS ) ? $VARS_MAX_EMBED_SESSIONS : $requestinfo["t_vses"] ;
		for ( $c = 1; $c <= $max_vses; ++$c )
		{
			$filename = $requestinfo["ces"]."-0"."_".$c ;
			UtilChat_AppendToChatfile( "$filename.text", $text ) ;
		}
		$mapp_array = ( isset( $VALS["MAPP"] ) && $VALS["MAPP"] ) ? unserialize( $VALS["MAPP"] ) : Array() ;
		$mapp_opid = $opinfo["opID"] ;
		if ( $opinfo["mapp"] && is_file( "$CONF[TYPE_IO_DIR]/$mapp_opid.mapp" ) )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/mapp/API/Util_MAPP.php" ) ;
			if ( isset( $mapp_array[$mapp_opid] ) ) { $arn = $mapp_array[$mapp_opid]["a"] ; $platform = $mapp_array[$mapp_opid]["p"] ; }
			if ( isset( $arn ) && $arn ) { Util_MAPP_Publish( $mapp_opid, "new_request", $platform, $arn, "[ Transfer Chat ]" ) ; }
		}
	}
	$now_v = time() ;
	$query = "UPDATE p_requests SET deptID = $requestinfo_log[deptID], tupdated = 0, status = 2, vupdated = $now_v WHERE ces = '$requestinfo[ces]'" ;
	database_mysql_query( $dbh, $query ) ;
?>