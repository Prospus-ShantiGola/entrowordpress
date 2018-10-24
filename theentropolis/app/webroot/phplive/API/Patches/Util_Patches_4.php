<?php
	$charset_string = ( database_mysql_old( $dbh ) ) ? "" : "CHARACTER SET utf8 COLLATE utf8_general_ci" ;
	FUNCTION Util_Functions_itr_is_serialized( $value, &$result = null )
	{
		// FUNCTION SOURCE:
		// https://gist.github.com/cs278/217091
		if (!is_string($value)) { return false; } if ($value === 'b:0;') { $result = false; return true; } $length = strlen($value); $end = ''; switch ($value[0]) { case 's': if ($value[$length - 2] !== '"') { return false; } case 'b': case 'i': case 'd': $end .= ';'; case 'a': case 'O': $end .= '}'; if ($value[1] !== ':') { return false; } switch ($value[2]) { case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7: case 8: case 9: break; default: return false; } case 'N': $end .= ';'; if ($value[$length - 1] !== $end[0]) { return false; } break; default: return false; } if (($result = @unserialize($value)) === false) { $result = null; return false; } return true;
	}

	/* auto patch of versions and needed modifications */
	if ( !is_file( "$CONF[CONF_ROOT]/patches/141" ) )
	{ $patched = 141 ;
		// duplicate check needed for patch 3 bug on previous v.4.5.9.2 not having the query (fixed since)
		$query = "CREATE TABLE IF NOT EXISTS p_rstats_log ( ces varchar(32) NOT NULL, created int(10) unsigned NOT NULL, status tinyint(1) NOT NULL, opID int(10) unsigned NOT NULL, deptID int(10) unsigned NOT NULL, PRIMARY KEY (ces,opID), KEY created (created), KEY opID (opID), KEY deptID (deptID), KEY status (status) )" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.5.9.3" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/142" ) )
	{ $patched = 142 ;
		Util_Vals_WriteVersion( "4.5.9.4" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/143" ) )
	{ $patched = 143 ;
		$query = "SHOW INDEX FROM p_opstatus_log" ;
		database_mysql_query( $dbh, $query ) ;
		$found = 0 ; while ( $data = database_mysql_fetchrow( $dbh ) ) { if ( $data["Column_name"] == "opID" ) { $found = 1 ; } }
		if ( !$found )
		{
			$query = "ALTER TABLE p_opstatus_log ADD PRIMARY KEY (created, opID)" ;
			database_mysql_query( $dbh, $query ) ;
		}
		Util_Vals_WriteVersion( "4.5.9.5" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/144" ) )
	{ $patched = 144 ;
		Util_Vals_WriteVersion( "4.5.9.6" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/145" ) )
	{ $patched = 145 ;
		Util_Vals_WriteVersion( "4.5.9.7" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/146" ) )
	{ $patched = 146 ;
		Util_Vals_WriteVersion( "4.5.9.8" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/147" ) )
	{ $patched = 147 ;
		$query = "ALTER TABLE p_requests CHANGE custom custom TEXT $charset_string NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_req_log CHANGE custom custom TEXT $charset_string NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_departments CHANGE custom custom TEXT $charset_string NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_transcripts ADD custom TEXT $charset_string NOT NULL AFTER md5_vis" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_dept_vars ADD offline_form TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 AFTER prechat_form" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.5.9.9" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/148" ) )
	{ $patched = 148 ;
		Util_Vals_WriteVersion( "4.5.9.9-1" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/149" ) )
	{ $patched = 149 ;
		Util_Vals_WriteVersion( "4.5.9.9.2" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/150" ) )
	{ $patched = 150 ;
		Util_Vals_WriteVersion( "4.5.9.9.3" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/151" ) )
	{ $patched = 151 ;
		if ( isset( $CONF['SALT'] ) && function_exists( "mcrypt_decrypt" ) )
		{
			$query = "SELECT * FROM p_departments" ;
			database_mysql_query( $dbh, $query ) ;
			$departments = Array() ;
			while ( $data = database_mysql_fetchrow( $dbh ) )
				$departments[] = $data ;

			for ( $c = 0; $c < count( $departments ); ++$c )
			{
				$department = $departments[$c] ;
				$serialized = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5($CONF['SALT']), base64_decode($department["smtp"]), MCRYPT_MODE_CBC, md5(md5($CONF['SALT'])) ), "\0" ) ;
				if ( Util_Functions_itr_is_serialized( $serialized ) )
				{
					$smtp_encoded = base64_encode( $serialized ) ;
					$query = "UPDATE p_departments SET smtp = '$smtp_encoded' WHERE deptID = $department[deptID]" ;
					database_mysql_query( $dbh, $query ) ;
				}
			}
		}
		Util_Vals_WriteVersion( "4.5.9.9.4" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/152" ) )
	{ $patched = 152 ;
		Util_Vals_WriteVersion( "4.5.9.9.5" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/153" ) )
	{ $patched = 153 ;
		$query = "SHOW INDEX FROM p_operators" ;
		database_mysql_query( $dbh, $query ) ;
		$found = 0 ; while ( $data = database_mysql_fetchrow( $dbh ) ) { if ( $data["Column_name"] == "name" ) { $found = 1 ; } }
		if ( !$found )
		{
			$query = "ALTER TABLE p_operators ADD INDEX(name)" ;
			database_mysql_query( $dbh, $query ) ;
		}
		$query = "ALTER TABLE p_ips DROP i_timestamp" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_ips DROP i_initiate" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_footprints DROP INDEX md5_page_2" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.5.9.9.6" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/154" ) )
	{ $patched = 154 ;
		Util_Vals_WriteVersion( "4.5.9.9.7" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/155" ) )
	{ $patched = 155 ;
		$query = "ALTER TABLE p_req_log ADD tag TINYINT UNSIGNED NOT NULL AFTER idle_disconnect, ADD INDEX tag (tag)" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_transcripts ADD tag TINYINT UNSIGNED NOT NULL AFTER noteID, ADD INDEX tag (tag)" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_operators ADD tag TINYINT(1) NOT NULL DEFAULT 1 AFTER canID" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.6" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/156" ) )
	{ $patched = 156 ;
		$query = "UPDATE p_operators SET maxc = 5 WHERE maxc = -1" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_vars ADD ts_queue INT UNSIGNED NOT NULL AFTER ts_clear" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "SHOW INDEX FROM p_operators" ;
		database_mysql_query( $dbh, $query ) ;
		$found = 0 ; while ( $data = database_mysql_fetchrow( $dbh ) ) { if ( $data["Column_name"] == "maxc" ) { $found = 1 ; } }
		if ( !$found )
		{
			$query = "ALTER TABLE p_operators ADD INDEX(maxc)" ;
			database_mysql_query( $dbh, $query ) ;
			$query = "ALTER TABLE p_operators ADD INDEX(mapp)" ;
			database_mysql_query( $dbh, $query ) ;
			$query = "ALTER TABLE p_operators ADD INDEX(rate)" ;
			database_mysql_query( $dbh, $query ) ;
			$query = "ALTER TABLE p_operators ADD INDEX(sms)" ;
			database_mysql_query( $dbh, $query ) ;
			$query = "ALTER TABLE p_operators ADD INDEX(smsnum)" ;
			database_mysql_query( $dbh, $query ) ;
			$query = "ALTER TABLE p_operators ADD INDEX(email)" ;
			database_mysql_query( $dbh, $query ) ;
		}
		$query = "CREATE TABLE IF NOT EXISTS p_queue ( queueID int(10) UNSIGNED NOT NULL AUTO_INCREMENT, created int(11) NOT NULL, updated int(10) UNSIGNED NOT NULL, deptID int(10) UNSIGNED NOT NULL, ces varchar(32) NOT NULL, md5_vis varchar(32) NOT NULL, ops_d varchar(200) $charset_string NOT NULL, PRIMARY KEY (queueID), KEY ces (ces), KEY md5_vis (md5_vis), KEY deptID (deptID), KEY ops_d (ops_d) )" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "CREATE TABLE IF NOT EXISTS p_queue_log ( logID int(10) UNSIGNED NOT NULL AUTO_INCREMENT, created int(10) UNSIGNED NOT NULL, ended int(10) UNSIGNED NOT NULL, sdate int(10) UNSIGNED NOT NULL, status tinyint(1) NOT NULL, deptID int(10) UNSIGNED NOT NULL, ces varchar(32) NOT NULL, PRIMARY KEY (logID), KEY created (created), KEY ended (ended), KEY status (status), KEY ces (ces), KEY deptID (deptID), KEY sdate (sdate) )" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_dept_vars ADD qest TINYINT(1) UNSIGNED NOT NULL AFTER offline_form, ADD qpos TINYINT(1) UNSIGNED NOT NULL AFTER qest, ADD qlimit TINYINT(2) UNSIGNED NOT NULL DEFAULT 5 AFTER qpos, ADD qtexts VARCHAR(255) $charset_string NOT NULL AFTER qlimit" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.6.1" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/157" ) )
	{ $patched = 157 ;
		$query = "ALTER TABLE p_queue ADD embed TINYINT(1) UNSIGNED NOT NULL AFTER deptID, ADD INDEX (embed)" ;
		database_mysql_query( $dbh, $query ) ;
		touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/158" ) )
	{ $patched = 158 ;
		Util_Vals_WriteVersion( "4.6.2" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/159" ) )
	{ $patched = 159 ;
		$query = "ALTER TABLE p_op_vars ADD vis_idle_canned VARCHAR(90) NOT NULL AFTER pic_edit" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.6.3" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/160" ) )
	{ $patched = 160 ;
		Util_Vals_WriteVersion( "4.6.4" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/161" ) )
	{ $patched = 161 ;
		Util_Vals_WriteVersion( "4.6.5" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/162" ) )
	{ $patched = 162 ;
		Util_Vals_WriteVersion( "4.6.6" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/163" ) )
	{ $patched = 163 ;
		Util_Vals_WriteVersion( "4.6.7" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/164" ) )
	{ $patched = 164 ;
		Util_Vals_WriteVersion( "4.6.8" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/165" ) )
	{ $patched = 165 ;
		$query = "ALTER TABLE p_departments ADD vupload TINYINT(1) NOT NULL AFTER savem" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_operators ADD upload TINYINT(1) NOT NULL AFTER tag" ;
		database_mysql_query( $dbh, $query ) ;
		// reset the debug.txt file if it exists
		if ( file_exists( "$CONF[CONF_ROOT]/debug.txt" ) ) { unlink( "$CONF[CONF_ROOT]/debug.txt" ) ; }
		Util_Vals_WriteVersion( "4.6.9" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/166" ) )
	{ $patched = 166 ;
		Util_Vals_WriteVersion( "4.6.9.1" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/167" ) )
	{ $patched = 167 ;
		$query = "SHOW INDEX FROM p_req_log" ;
		database_mysql_query( $dbh, $query ) ;
		$found = 0 ; while ( $data = database_mysql_fetchrow( $dbh ) ) { if ( $data["Column_name"] == "ended" ) { $found = 1 ; } }
		if ( !$found )
		{
			$query = "ALTER TABLE p_req_log ADD INDEX(ended)" ;
			database_mysql_query( $dbh, $query ) ;
			$query = "ALTER TABLE p_req_log ADD INDEX(deptID)" ;
			database_mysql_query( $dbh, $query ) ;
			$query = "ALTER TABLE p_req_log ADD INDEX(initiated)" ;
			database_mysql_query( $dbh, $query ) ;
			$query = "ALTER TABLE p_req_log ADD INDEX(op2op)" ;
			database_mysql_query( $dbh, $query ) ;
		}
		$query = "ALTER TABLE p_req_log ADD accepted INT UNSIGNED NOT NULL AFTER created, ADD accepted_op INT UNSIGNED NOT NULL AFTER accepted, ADD duration MEDIUMINT UNSIGNED NOT NULL AFTER accepted_op, ADD INDEX (accepted), ADD INDEX (accepted_op), ADD INDEX (duration)" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_transcripts ADD accepted_op INT UNSIGNED NOT NULL AFTER opID, ADD INDEX (accepted_op)" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_departments ADD emailm_cc VARCHAR(160) NOT NULL AFTER email" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_departments ADD ctimer TINYINT(1) NOT NULL DEFAULT 1 AFTER vupload" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_dept_vars ADD end_chat_msg TEXT $charset_string NOT NULL AFTER greeting_body" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_op_vars ADD upload_ses INT UNSIGNED NOT NULL AFTER pic_edit" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "DROP TABLE IF EXISTS p_marquees" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_rstats_depts DROP initiated_" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_rstats_ops DROP initiated_" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_requests ADD rloop TINYINT UNSIGNED NOT NULL AFTER requests" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.6.9.2" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched"."_" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched"."__" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/168" ) )
	{ $patched = 168 ;
		Util_Vals_WriteVersion( "4.6.9.3" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/169" ) )
	{ $patched = 169 ;
		Util_Vals_WriteVersion( "4.6.9.4" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/170" ) )
	{ $patched = 170 ;
		Util_Vals_WriteVersion( "4.6.9.5" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/171" ) )
	{ $patched = 171 ;
		Util_Vals_WriteVersion( "4.6.9.6" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/172" ) )
	{ $patched = 172 ;
		Util_Vals_WriteVersion( "4.6.9.7" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/173" ) )
	{ $patched = 173 ;
		$query = "ALTER TABLE p_departments CHANGE vupload vupload VARCHAR(45) NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_operators CHANGE upload upload VARCHAR(45) NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.6.9.8" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/174" ) )
	{ $patched = 174 ;
		Util_Vals_WriteVersion( "4.6.9.9" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/175" ) )
	{ $patched = 175 ;
		Util_Vals_WriteVersion( "4.7" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/176" ) )
	{ $patched = 176 ;
		$query = "ALTER TABLE p_requests ADD tloop TINYINT NOT NULL AFTER rloop" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.7.1" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/177" ) )
	{ $patched = 177 ;
		Util_Vals_WriteVersion( "4.7.2" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	else if ( !is_file( "$CONF[CONF_ROOT]/patches/178" ) )
	{ $patched = 178 ;
		$query = "ALTER TABLE p_transcripts ADD atID INT UNSIGNED NOT NULL AFTER noteID, ADD INDEX (atID)" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_requests ADD slack TINYINT(1) UNSIGNED NOT NULL AFTER marketID" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.7.3" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( $patch_v == $patched )
	{
		/*******************************************/
		// Always the closing queries due to possible errors that may stop the patch
		$query = "SHOW INDEX FROM p_transcripts" ;
		database_mysql_query( $dbh, $query ) ;
		$found = 0 ; while ( $data = database_mysql_fetchrow( $dbh ) ) { if ( $data["Column_name"] == "plain" ) { $found = 1 ; } }
		if ( !$found )
		{
			$query = "ALTER TABLE p_transcripts ADD FULLTEXT plain (plain)" ;
			database_mysql_query( $dbh, $query ) ;
		}
		$query = "SHOW INDEX FROM p_transcripts" ;
		database_mysql_query( $dbh, $query ) ;
		$found = 0 ; while ( $data = database_mysql_fetchrow( $dbh ) ) { if ( $data["Column_name"] == "custom" ) { $found = 1 ; } }
		if ( !$found )
		{
			$query = "ALTER TABLE p_transcripts ADD FULLTEXT custom (custom)" ;
			database_mysql_query( $dbh, $query ) ;
		}
		/*******************************************/
	}
	/* end auto patch area */
?>
