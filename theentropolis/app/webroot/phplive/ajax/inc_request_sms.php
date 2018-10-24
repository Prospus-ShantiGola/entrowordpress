<?php
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Email.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;

	$lang = Util_Format_Sanatize( $CONF["lang"], "ln" ) ;
	if ( is_file( "$CONF[DOCUMENT_ROOT]/lang_packs/$lang.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/$lang.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/english.php" ) ; }
	$question_mapp = ( $inc_question ) ? $inc_question : "[ $LANG[TXT_LIVECHAT] ]" ;

	if ( $mapp_opid && is_file( "$CONF[TYPE_IO_DIR]/$mapp_opid.mapp" ) )
	{
		$mapp_array = ( isset( $VALS["MAPP"] ) && $VALS["MAPP"] ) ? unserialize( $VALS["MAPP"] ) : Array() ;
		if ( isset( $mapp_array[$mapp_opid] ) ) { $arn = $mapp_array[$mapp_opid]["a"] ; $platform = $mapp_array[$mapp_opid]["p"] ; }
		if ( isset( $arn ) && $arn )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/mapp/API/Util_MAPP.php" ) ;
			Util_MAPP_Publish( $mapp_opid, "new_request", $platform, $arn, $question_mapp ) ;
		}
	}
	else
	{
		$this_deptinfo = ( !isset( $deptinfo ) ) ? Depts_get_DeptInfo( $dbh, $deptid ) : $deptinfo ;
		if ( $this_deptinfo["smtp"] ) { $smtp_array = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $this_deptinfo["smtp"] ) ) ; }

		$question_sms = preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", preg_replace( "/\"/", "&quot;", $question_mapp ) ) ;
		$question_sms = preg_replace( "/<br>/", " ", $question_sms ) ;
		$question_sms = ( strlen( $question_sms ) > 100 ) ? substr( $question_sms, 0, 100 ) . "..." : $question_sms ;
		Util_Email_SendEmail( $sms_oname, $sms_oemail, $sms_vname, base64_decode( $sms_num ), "Chat Request", $question_sms, "sms" ) ;
	}
?>