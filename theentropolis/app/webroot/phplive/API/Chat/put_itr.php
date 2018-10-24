<?php
	if ( defined( 'API_Chat_put_itr' ) ) { return ; }
	define( 'API_Chat_put_itr', true ) ;

	FUNCTION Chat_put_itr_Transcript( &$dbh,
					$ces,
					$status,
					$created,
					$ended,
					$deptid,
					$opid,
					$initiated,
					$op2op,
					$rating,
					$fsize,
					$vname,
					$vemail,
					$ip,
					$vis_token,
					$custom,
					$question,
					$formatted,
					$plain,
					$deptinfo,
					$deptvars )
	{
		if ( ( $ces == "" ) || ( $deptid == "" ) || ( $opid == "" ) || ( $fsize == "" )
			|| ( $ended == "" ) || ( $vname == "" ) || ( $ip == "" )
			|| ( $vis_token == "" ) || ( $formatted == "" ) || ( $plain == "" ) )
			return false ;

		global $CONF ; global $VALS ; global $VARS_OS ; global $VARS_BROWSER ;
		global $VARS_EXPIRED_TFOOT ; global $smtp_array ;
		if ( !defined( 'API_Util_Email' ) )
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Email.php" ) ;
		if ( !defined( 'API_Chat_get' ) )
			include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get.php" ) ;

		LIST( $ces, $status, $created, $ended, $deptid, $opid, $initiated, $op2op, $rating, $fsize, $vname, $vemail, $ip, $vis_token, $custom, $question, $formatted, $plain ) = database_mysql_quote( $dbh, $ces, $status, $created, $ended, $deptid, $opid, $initiated, $op2op, $rating, $fsize, $vname, $vemail, $ip, $vis_token, $custom, $question, $formatted, $plain ) ;

		// get initiated value from log because during transfer it resets the initiate flag
		$requestinfo_log = Chat_get_RequestHistCesInfo( $dbh, $ces ) ;

		$query = "SELECT * FROM p_transcripts WHERE ces = '$ces' LIMIT 1" ;
		database_mysql_query( $dbh, $query ) ;
		$transcript = database_mysql_fetchrow( $dbh ) ;

		$trans_exists = 1 ;
		if ( !isset( $transcript["ces"] ) && ( $created != "null" ) )
		{
			$trans_exists = 0 ;
			$initiated = ( isset( $requestinfo_log["initiated"] ) ) ? $requestinfo_log["initiated"] : $initiated ;
			$tag = ( isset( $requestinfo_log["tag"] ) ) ? $requestinfo_log["tag"] : 0 ;
			$accepted_op = ( isset( $requestinfo_log["accepted_op"] ) ) ? $requestinfo_log["accepted_op"] : 0 ;
			$duration = $ended - $created ;

			if ( is_file("$CONF[DOCUMENT_ROOT]/addons/helpscout/helpscout.php") && isset( $VALS["HELPSCOUT"] ) && $VALS["HELPSCOUT"] )
			{
				include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions_itr.php" ) ;
				include_once( "$CONF[DOCUMENT_ROOT]/addons/helpscout/API/Util_HelpScout.php" ) ;

				$helpscout_array = Array() ;
				$settings_hashed = unserialize( Util_Functions_itr_Decrypt( $CONF["SALT"], $VALS["HELPSCOUT"] ) ) ;
				if ( isset( $settings_hashed[$deptid] ) ) { $helpscout_array = $settings_hashed[$deptid] ; }
				else if ( isset( $settings_hashed[0] ) ) { $helpscout_array = $settings_hashed[0] ; }

				if ( isset( $helpscout_array["ak"] ) && $helpscout_array["ak"] && $opid && isset( $deptinfo["name"] ) && isset( $requestinfo_log["ces"] ) )
				{
					$helpscout_vemail = ( $vemail == "null" ) ? "no_email_provided@somewhere_com.com" : $vemail ; // email must be valid format to post
					$vname_array = explode( " ", $vname ) ;
					if ( count( $vname_array ) > 1 ) { LIST( $fname, $lname ) = explode( " ", $vname ) ; }
					else { $fname = $vname ; $lname = "" ; }

					$query = "SELECT * FROM p_operators WHERE opID = '$opid' LIMIT 1" ;
					database_mysql_query( $dbh, $query ) ;
					$opinfo = database_mysql_fetchrow( $dbh ) ;

					$duration_ = Util_Format_Duration( $duration ) ;
					$os = $VARS_OS[$requestinfo_log["os"]] ; $browser = $VARS_BROWSER[$requestinfo_log["browser"]] ;
					$json_data = Util_HelpScout_CreateConversation( $deptinfo["name"], $fname, $lname, $helpscout_vemail, $opinfo["name"], $opinfo["email"], strip_tags( $question ), $duration_, $requestinfo_log["resolution"], $os, $browser, $requestinfo_log["title"], $requestinfo_log["onpage"], stripslashes( $formatted ), $helpscout_array["ak"], $helpscout_array["s"], $helpscout_array["u"], $helpscout_array["a"], $helpscout_array["m"], $helpscout_array["t"], "" ) ;
				}
			}
			$atid = 0 ; // AT Time Entry ID result
			if ( is_file( "$CONF[CONF_ROOT]/autotask_config.php" ) && isset( $VALS["AUTOTASK"] ) && $VALS["AUTOTASK"] ) { include_once( "$CONF[DOCUMENT_ROOT]/addons/autotask/API/Chat_put_itr.php" ) ; }

			$query = "UPDATE p_requests SET ended = $ended WHERE ces = '$ces'" ;
			database_mysql_query( $dbh, $query ) ;
			$query = "UPDATE p_req_log SET duration = $duration, ended = $ended WHERE ces = '$ces'" ;
			database_mysql_query( $dbh, $query ) ;
			$query = "INSERT INTO p_transcripts VALUES ( '$ces', $created, $ended, $deptid, $opid, $accepted_op, $initiated, $op2op, $rating, 0, $fsize, 0, $atid, $tag, '$vname', '$vemail', '$ip', '$vis_token', '$requestinfo_log[custom]', '$question', '$formatted', '$plain' )" ;
			database_mysql_query( $dbh, $query ) ;
			if ( is_file( "$CONF[CHAT_IO_DIR]/$ces.txt" ) ) { unlink( "$CONF[CHAT_IO_DIR]/$ces.txt" ) ; }

			// clear istyping files
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

		/***** unregister autoloaders for SMTP autoloader *****/
		if ( function_exists( "spl_autoload_functions" ) )
		{
			$autoloader_functions = spl_autoload_functions() ;
			if ( is_array( $autoloader_functions ) )
			{
				foreach( $autoloader_functions as $autoloader_function ) { spl_autoload_unregister( $autoloader_function ) ; }
			}
		}
		/******************************************************/

		if ( $formatted && isset( $deptinfo["temail"] ) )
		{
			if ( $status )
			{
				$vemail_display = "$vemail" ;
				if ( $vemail == "null" ) { $vemail = "" ; $vemail_display = "" ; }

				if ( !isset( $opinfo ) )
				{
					$query = "SELECT * FROM p_operators WHERE opID = '$opid' LIMIT 1" ;
					database_mysql_query( $dbh, $query ) ;
					$opinfo = database_mysql_fetchrow( $dbh ) ;
				}

				$lang = $CONF["lang"] ;
				if ( $deptinfo["lang"] ) { $lang = $deptinfo["lang"] ; }
				include( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($lang, "ln").".php" ) ;

				$subject_visitor = $LANG["TRANSCRIPT_SUBJECT"]." $opinfo[name]" ;
				$subject_department = $LANG["TRANSCRIPT_SUBJECT"]." $vname" ;

				// override for emailing transcript
				if ( isset( $deptvars["trans_f_dept"] ) && $deptvars["trans_f_dept"] )
				{
					$from_name = $deptinfo["name"] ;
					$from_email = $deptinfo["email"] ;
				}
				else
				{
					$from_name = $opinfo["name"] ;
					$from_email = $opinfo["email"] ;
				}

				$message_trans = Util_Email_FormatTranscript( $ces, $deptinfo["msg_email"], $vname, $vemail, $opinfo["name"], $opinfo["email"], $requestinfo_log["custom"], $formatted ) ;
				if ( ( $created == "null" ) && $vemail )
				{
					Util_Email_SendEmail( $from_name, $from_email, $vname, $vemail, $subject_visitor, $message_trans, "trans" ) ;
					$query = "UPDATE p_req_log SET vemail = '$vemail' WHERE ces = '$ces' AND vemail = 'null'" ;
					database_mysql_query( $dbh, $query ) ;
					$query = "UPDATE p_transcripts SET vemail = '$vemail' WHERE ces = '$ces' AND vemail = 'null'" ;
					database_mysql_query( $dbh, $query ) ;
				}
				if ( !$trans_exists )
				{
					$mapp_array = ( isset( $VALS["MAPP"] ) && $VALS["MAPP"] ) ? unserialize( $VALS["MAPP"] ) : Array() ;
					if ( $opinfo["mapp"] && is_file( "$CONF[TYPE_IO_DIR]/$opid.mapp" ) )
					{
						include_once( "$CONF[DOCUMENT_ROOT]/mapp/API/Util_MAPP.php" ) ;
						if ( isset( $mapp_array[$opid] ) ) { $arn = $mapp_array[$opid]["a"] ; $platform = $mapp_array[$opid]["p"] ; }
						if ( isset( $arn ) && $arn ) { Util_MAPP_Publish( $opid, "new_text", $platform, $arn, "$vname [".$LANG["TXT_DISCONNECT"]."]" ) ; }
					}

					if ( $deptinfo["emailt"] && $deptinfo["emailt_bcc"] )
					{
						if ( !$vemail ) { $vname = $from_name ; $vemail = $from_email ; }
						Util_Email_SendEmail( $from_name, $from_email, $vname, $vemail, $subject_visitor, $message_trans, "trans", Array($deptinfo["emailt"]) ) ;
					}
					else if ( $deptinfo["emailt"] )
					{
						Util_Email_SendEmail( $from_name, $from_email, $deptinfo["name"], $deptinfo["emailt"], $subject_department, $message_trans, "trans" ) ;
					}

					if ( $deptinfo["temaild"] )
					{
						Util_Email_SendEmail( $from_name, $from_email, $deptinfo["name"], $deptinfo["email"], $subject_department, $message_trans, "trans" ) ;
					}
				}
			}
			return true ;
		}
		else if ( $trans_exists ) { return true ; }
		return false ;
	}
?>