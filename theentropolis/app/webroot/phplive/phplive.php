<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	if ( !is_file( "./web/config.php" ) ){ HEADER("location: setup/install.php") ; exit ; }
	include_once( "./web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_IP.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	$query = isset( $_SERVER["QUERY_STRING"] ) ? preg_replace( "/&&/", "&", Util_Format_Sanatize( $_SERVER["QUERY_STRING"], "query" ) ) : "" ;
	/* AUTO PATCH */
	if ( !is_file( "$CONF[CONF_ROOT]/patches/$patch_v" ) )
	{
		HEADER( "location: patch.php?from=chat&".$query."&" ) ; exit ;
	}
	if ( is_file( "$CONF[DOCUMENT_ROOT]/API/Util_Extra_Pre.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload_.php" ) ; }
	else { include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Upload.php" ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_itr.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Lang/get.php" ) ;

	$onpage = Util_Format_Sanatize( base64_decode( Util_Format_GetVar( "pg" ) ), "url" ) ;
	$title = Util_Format_Sanatize( base64_decode( Util_Format_GetVar( "tl" ) ), "title" ) ;
	if ( !$onpage )
	{
		$onpage = Util_Format_Sanatize( Util_Format_GetVar( "onpage" ), "url" ) ;
		$title = Util_Format_Sanatize( Util_Format_GetVar( "title" ), "title" ) ;
	}
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "d" ), "n" ) ; $deptid_ = $deptid ; // retain original
	$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
	$theme = Util_Format_Sanatize( Util_Format_GetVar( "theme" ), "ln" ) ;
	$vquestion = rawurldecode( Util_Format_Sanatize( Util_Format_GetVar( "vquestion" ), "htmltags" ) ) ; if ( !$vquestion ) { $vquestion = "" ; }
	$embed = Util_Format_Sanatize( Util_Format_GetVar( "embed" ), "n" ) ;
	$popout = Util_Format_Sanatize( Util_Format_GetVar( "popout" ), "n" ) ;
	$js_name = base64_decode( Util_Format_Sanatize( Util_Format_GetVar( "js_name" ), "ln" ) ) ;
	$js_email = base64_decode( Util_Format_Sanatize( Util_Format_GetVar( "js_email" ), "e" ) ) ;
	$custom = Util_Format_Sanatize( Util_Format_GetVar( "custom" ), "htmltags" ) ;
	$lang = Util_Format_Sanatize( Util_Format_GetVar( "lang" ), "ln" ) ;
	$token = Util_Format_Sanatize( Util_Format_GetVar( "token" ), "ln" ) ;
	$preview = Util_Format_Sanatize( Util_Format_GetVar( "preview" ), "n" ) ;
	$dept_themes = ( isset( $VALS["THEMES"] ) ) ? unserialize( $VALS["THEMES"] ) : Array() ;
	if ( !$theme && isset( $dept_themes[$deptid] ) && $deptid ) { $theme = $dept_themes[$deptid] ; }
	else if ( !$theme ) { $theme = $CONF["THEME"] ; }
	else if ( $theme && !is_file( "$CONF[DOCUMENT_ROOT]/themes/$theme/style.css" ) ) { $theme = $CONF["THEME"] ; }
	if ( !$token ) { $query = preg_replace( "/token=0/", "", $query ) ; HEADER( "location: ./fetch_token.php?$query" ) ; exit ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	if ( $theme == "default_v2" ) { $theme = "default" ; }
	else if ( !is_file( "$CONF[DOCUMENT_ROOT]/themes/$theme/style.css" ) ) { $theme = "default" ; }

	$agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : "&nbsp;" ;
	LIST( $ip, $vis_token ) = Util_IP_GetIP( $token ) ;
	LIST( $os, $browser ) = Util_Format_GetOS( $agent ) ;
	$mobile = ( $os == 5 ) ? 1 : 0 ;
	$cookie = ( !isset( $CONF["cookie"] ) || ( $CONF["cookie"] == "on" ) ) ? 1 : 0 ;
	$js_custom_hash = "" ;
	if ( $custom )
	{
		$custom_pairs = explode( "-cus-", $custom ) ;
		for ( $c = 0; $c < count( $custom_pairs ); ++$c )
		{
			if ( $custom_pairs[$c] ) { LIST( $custom_var_name, $custom_var_val ) = explode( "-_-", $custom_pairs[$c] ) ; $js_custom_hash .= "custom_hash['$custom_var_name'] = '$custom_var_val' ; " ; }
		}
		preg_match( "/vquestion-_-(.*?)-cus-/i", $custom, $matches ) ;
		if ( isset( $matches[1] ) ) { $custom = preg_replace( "/vquestion-_-(.*?)-cus-/i", "", $custom ) ; $vquestion = $matches[1] ; }
	}

	$dept_name_vis = ( !isset( $VALS['DEPT_NAME_VIS'] ) || ( $VALS['DEPT_NAME_VIS'] == "off" ) ) ? 0 : 1 ;
	$temp_vname = ( !$js_name && ( isset( $_COOKIE["phplive_vname"] ) && ( $_COOKIE["phplive_vname"] != "null" ) && $cookie ) ) ? Util_Format_Sanatize( $_COOKIE["phplive_vname"], "ln" ) : $js_name ;
	$temp_vemail = ( !$js_email && ( isset( $_COOKIE["phplive_vemail"] ) && ( $_COOKIE["phplive_vemail"] != "null" ) && $cookie ) ) ? Util_Format_Sanatize( $_COOKIE["phplive_vemail"], "e" ) : $js_email ;
	$vname = ( $temp_vname ) ? $temp_vname : "" ;
	$vemail = ( $temp_vemail ) ? $temp_vemail : "" ;
	$dept_offline = $dept_settings = $dept_customs = "" ;
	$now = time() ;

	if ( preg_match( "/$ip/", $VALS["CHAT_SPAM_IPS"] ) ) { $spam_exist = 1 ; }
	else { $spam_exist = 0 ; }

	$queue_embed_query = ( $embed || $popout ) ? " AND embed = 1 " : " AND embed = 0 " ;
	$query_db = "SELECT queueID, ces, deptID FROM p_queue WHERE md5_vis = '$vis_token' $queue_embed_query LIMIT 1" ;
	database_mysql_query( $dbh, $query_db ) ; $queueinfo = database_mysql_fetchrow( $dbh ) ;
	if ( isset( $queueinfo["ces"] ) )
	{
		if ( $popout )
		{
			include_once( "$CONF[DOCUMENT_ROOT]/API/Queue/update.php" ) ;
			Queue_update_QueueValue( $dbh, $queueinfo["queueID"], "embed", 0 ) ;
		}
		$deptid = $queueinfo["deptID"] ;
		$requestinfo_onpage = isset( $requestinfo["onpage"] ) ? urlencode( Util_Format_URL( $requestinfo["onpage"] ) ) : "" ;
		database_mysql_close( $dbh ) ;
		HEADER( "location: phplive_.php?embed=$embed&popout=$popout&deptid=$deptid&token=$token&vis_token=$vis_token&theme=$theme&ces=$queueinfo[ces]&vname=null&vquestion=null&onpage=$requestinfo_onpage&queue=1&".$now ) ; exit ;
	}

	$requestinfo = Chat_get_itr_RequestGetInfo( $dbh, 0, "", $vis_token ) ;
	// popout from embed chat
	if ( isset( $requestinfo["deptID"] ) && ( $requestinfo["md5_vis"] || $requestinfo["md5_vis_"] ) )
	{
		$deptid = $requestinfo["deptID"] ;
		if ( $popout )
		{
			$query = "UPDATE p_requests SET md5_vis = '' WHERE requestID = $requestinfo[requestID]" ;
			database_mysql_query( $dbh, $query ) ;
		}
		database_mysql_close( $dbh ) ;
		HEADER( "location: phplive_.php?embed=$embed&popout=$popout&deptid=$deptid&token=$token&vis_token=$vis_token&theme=$theme&ces=$requestinfo[ces]&vname=null&vquestion=null&onpage=".urlencode( Util_Format_URL( $requestinfo["onpage"] ) )."&".$now ) ; exit ;
	}
	else if ( isset( $requestinfo["deptID"] ) && $requestinfo["md5_vis_"] && $requestinfo["initiated"] && !$requestinfo["status"] )
	{
		if ( is_file( "$CONF[TYPE_IO_DIR]/$vis_token.txt" ) ) { unlink( "$CONF[TYPE_IO_DIR]/$vis_token.txt" ) ; }

		$deptid = $requestinfo["deptID"] ;
		$embed_query = ( $embed ) ? ", md5_vis = '$vis_token' " : "" ;
		$query = "UPDATE p_requests SET status = 1 $embed_query WHERE requestID = $requestinfo[requestID]" ;
		database_mysql_query( $dbh, $query ) ;
		database_mysql_close( $dbh ) ;
		HEADER( "location: phplive_.php?embed=$embed&popout=$popout&deptid=$deptid&token=$token&vis_token=$vis_token&theme=$theme&ces=$requestinfo[ces]&vname=null&vquestion=null&onpage=".urlencode( Util_Format_URL( $requestinfo["onpage"] ) )."&".$now ) ; exit ;
	}

	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/update_itr.php" ) ;
	Ops_update_itr_IdleOps( $dbh ) ;

	$popout = 0 ;
	$vars = Util_Format_Get_Vars( $dbh ) ;
	if ( $vars["ts_clear"] <= ( $now - $VARS_CYCLE_CLEAN ) )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/remove.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Footprints/remove_itr.php" ) ;

		Util_Format_Update_TimeStamp( $dbh, "clear", $now ) ;
		Footprints_remove_itr_Expired_U( $dbh ) ;
		Footprints_remove_ExpiredStats( $dbh ) ;
	}

	$total_ops = 0 ; $dept_online = Array() ; $departments = Array() ;
	if ( $deptid )
	{
		$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
		$departments[0] = $deptinfo ;
		if ( !isset( $deptinfo["deptID"] ) )
		{
			$query = preg_replace( "/embed=(.*?)(\&|$)/", "emb=$1$2", $query ) ; // workaround for the d= situation
			$query = preg_replace( "/(d=(.*?)(&|$))/", "d=0&", $query ) ;
			$query = preg_replace( "/emb=(.*?)(\&|$)/", "embed=$1$2", $query ) ;
			database_mysql_close( $dbh ) ;
			HEADER( "location: phplive.php?$query&" ) ; exit ;
		}

		$total = Ops_get_itr_AnyOpsOnline( $dbh, $deptinfo["deptID"] ) ;
		$total_ops += $total ;
		$dept_online[$deptinfo["deptID"]] = $total ;
		$dept_offline .= "dept_offline[$deptinfo[deptID]] = '".preg_replace( "/'|&quot;/", "\"", $deptinfo["msg_offline"] )."' ; " ;
		$dept_settings .= " dept_settings[$deptinfo[deptID]] = Array( $deptinfo[remail], $deptinfo[temail], $deptinfo[rquestion] ) ; " ;
		$custom_fields = ( $deptinfo["custom"] ) ? unserialize( $deptinfo["custom"] ) : Array() ;
		if ( isset( $custom_fields[0] ) )
		{
			$dept_customs .= " dept_customs[$deptinfo[deptID]] = Array( '$custom_fields[0]', $custom_fields[1] " ;
			if ( isset( $custom_fields[2] ) ) { $dept_customs .= ", '$custom_fields[2]', $custom_fields[3] " ; }
			if ( isset( $custom_fields[4] ) ) { $dept_customs .= ", '$custom_fields[4]', $custom_fields[5] " ; }
			$dept_customs .= " ) ;" ;
		}
		
		if ( $deptinfo["lang"] ) { $CONF["lang"] = $deptinfo["lang"] ; }
	}
	else
	{
		$departments_pre = Depts_get_AllDepts( $dbh ) ;
		for ( $c = 0; $c < count( $departments_pre ); ++$c )
		{
			$department = $departments_pre[$c] ;
			if ( $department["visible"] ) { $departments[] = $department ; }
		}

		for ( $c = 0; $c < count( $departments ); ++$c )
		{
			$department = $departments[$c] ;
			if ( $spam_exist )
				$total = 0 ;
			else
				$total = Ops_get_itr_AnyOpsOnline( $dbh, $department["deptID"] ) ;
			$total_ops += $total ;

			$dept_online[$department["deptID"]] = $total ;
			$dept_offline .= "dept_offline[$department[deptID]] = '".preg_replace( "/'|&quot;/", "\"", $department["msg_offline"] )."' ; " ;
			$dept_settings .= " dept_settings[$department[deptID]] = Array( $department[remail], $department[temail], $department[rquestion] ) ; " ;
			$custom_fields = ( $department["custom"] ) ? unserialize( $department["custom"] ) : Array( ) ;
			if ( isset( $custom_fields[0] ) )
			{
				$dept_customs .= " dept_customs[$department[deptID]] = Array( '$custom_fields[0]', $custom_fields[1] " ;
				if ( isset( $custom_fields[2] ) ) { $dept_customs .= ", '$custom_fields[2]', $custom_fields[3] " ; }
				if ( isset( $custom_fields[4] ) ) { $dept_customs .= ", '$custom_fields[4]', $custom_fields[5] " ; }
				$dept_customs .= " ) ;" ;
			}
		}

		if ( count( $departments ) == 1 )
			$deptid = $departments[0]["deptID"] ;
	}

	$deptvars_all = Depts_get_AllDeptsVars( $dbh ) ; $dept_offline_form = "" ; $dept_offline_hasform = 0 ; $dept_prechat_form = "" ;
	foreach ( $deptvars_all as $deptid_temp => $deptvar )
	{
		if ( isset( $deptvar["offline_form"] ) )
		{
			$dept_offline_form .= "dept_offline_form[$deptid_temp] = $deptvar[offline_form] ; " ;
			$dept_prechat_form .= "dept_prechat_form[$deptid_temp] = $deptvar[prechat_form] ; " ;
			if ( $deptvar["offline_form"] ) { $dept_offline_hasform = 1 ; }
		}
	}
	if ( !count( $deptvars_all ) ) { $dept_offline_hasform = 1 ; }
	else if ( $total_ops ) { $dept_offline_hasform = 1 ; }
	else if ( isset( $deptvars_all[$deptid] ) ) { $dept_offline_hasform = $deptvars_all[$deptid]["offline_form"] ; }
	else if ( count( $deptvars_all ) == 1 )
	{
		if ( $deptid && !isset( $deptvars_all[$deptid] ) ) { $dept_offline_hasform = 1 ; }
		else if ( !$deptid && ( count( $departments ) > 1 ) ) { $dept_offline_hasform = 1 ; }
	}
	$deptvars = isset( $deptvars_all[$deptid] ) ? $deptvars_all[$deptid] : Array() ;

	$emlogos_hash = ( isset( $VALS["EMLOGOS"] ) ) ? unserialize( $VALS["EMLOGOS"] ) : Array() ;
	include_once( "$CONF[DOCUMENT_ROOT]/setup/KEY.php" ) ;

	if ( $lang ) { $CONF["lang"] = $lang ; }
	$CONF["lang"] = ( isset( $CONF["lang"] ) && $CONF["lang"] && is_file( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($CONF["lang"], "ln").".php" ) ) ? $CONF["lang"] : "english" ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($CONF["lang"], "ln").".php" ) ;
	$lang_db = Lang_get_Lang( $dbh, $CONF["lang"] ) ;
	if ( isset( $lang_db["lang"] ) )
	{
		$db_lang_hash = unserialize( $lang_db["lang_vars"] ) ;
		$LANG = array_merge( $LANG, $db_lang_hash ) ;
	}
	/////////////////////////////////////////////
	if ( defined( "LANG_CHAT_WELCOME" ) || !isset( $LANG["CHAT_JS_CUSTOM_BLANK"] ) )
	{ ErrorHandler( 611, "Update to your custom language file is required ($CONF[lang]).  Copy an existing language file and create a new custom language file.", $PHPLIVE_FULLURL, 0, Array( ) ) ; exit ; }
?>
<?php include_once( "./inc_doctype.php" ) ?>
<?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?>
<!--
********************************************************************
* PHP Live! (c) OSI Codes Inc.
* www.phplivesupport.com
********************************************************************
-->
<?php endif ; ?>
<head>
<title> <?php echo $LANG["CHAT_WELCOME"] ?> </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=<?php echo $LANG["CHARSET"] ?>">
<?php include_once( "./inc_meta_dev.php" ) ; ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

<link rel="Stylesheet" href="./themes/<?php echo $theme ?>/style.css?<?php echo filemtime ( "./themes/$theme/style.css" ) ; ?>">
<script data-cfasync="false" type="text/javascript" src="./js/global.js?<?php echo filemtime ( "./js/global.js" ) ; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/global_chat.js?<?php echo filemtime ( "./js/global_chat.js" ) ; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/setup.js?<?php echo filemtime ( "./js/setup.js" ) ; ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/framework_cnt.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/jquery_md5.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="./js/jquery.tools.min.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	var embed = <?php echo $embed ?> ;
	var mobile = ( <?php echo $mobile ?> ) ? is_mobile() : 0 ;
	var phplive_mobile = 0 ; var phplive_ios = 0 ;
	var phplive_userAgent = navigator.userAgent || navigator.vendor || window.opera ;
	if ( phplive_userAgent.match( /iPad/i ) || phplive_userAgent.match( /iPhone/i ) || phplive_userAgent.match( /iPod/i ) )
	{
		phplive_ios = 1 ;
		if ( phplive_userAgent.match( /iPad/i ) ) { phplive_mobile = 0 ; }
		else { phplive_mobile = 1 ; }
	}
	else if ( phplive_userAgent.match( /Android/i ) ) { phplive_mobile = 2 ; }

	var popout = <?php echo ( isset( $VALS["POPOUT"] ) && ( $VALS["POPOUT"] == "on" ) ) ? 1 : 0 ?> ;
	var win_width = screen.width ;
	var win_height = screen.height ;

	var dept_offline = new Object ;
	var dept_settings = new Object ;
	var dept_customs = new Object ;
	var dept_offline_form = new Object ;
	var dept_prechat_form = new Object ;
	
	var custom_hash = new Object ;

	var global_form_x ; // global var for original form top position for unset
	var global_diff_height ;

	var onoff = 0 ;
	var custom_required = 0 ; var custom_required2 = 0 ; var custom_required3 = 0 ;
	var js_email = "<?php echo $js_email ?>" ;
	var phplive_browser = navigator.appVersion ; var phplive_mime_types = "" ;
	var phplive_display_width = screen.availWidth ; var phplive_display_height = screen.availHeight ; var phplive_display_color = screen.colorDepth ; var phplive_timezone = new Date().getTimezoneOffset() ;
	if ( navigator.mimeTypes.length > 0 ) { for (var x=0; x < navigator.mimeTypes.length; x++) { phplive_mime_types += navigator.mimeTypes[x].description ; } }
	var phplive_browser_token = phplive_md5( phplive_display_width+phplive_display_height+phplive_display_color+phplive_timezone+phplive_browser+phplive_mime_types ) ;
	if ( phplive_browser_token != "<?php echo $token ?>" )
	{
		location.href = "fetch_token.php?<?php echo $query ?>" ;
	}
	var win_st_resizing ;
	var si_win_status ; var win_minimized ;

	$(document).ready(function( )
	{
		$('#win_dim').val( win_width + " x " + win_height ) ;

		<?php echo $dept_offline ?>
		<?php echo $dept_settings ?>
		<?php echo $dept_customs ?>
		<?php echo $dept_offline_form ?>
		<?php echo $js_custom_hash ?>
		<?php echo $dept_prechat_form ?>

		<?php if ( $preview ): ?>
		var pos = $('#request_body').position() ; $('#blank_cover').css({'top': pos.top, 'left': pos.left}).fadeTo( "fast" , 0.0 ) ;
		<?php endif ; ?>

		$('#chat_button_start').html( "<?php echo $LANG["CHAT_BTN_START_CHAT"] ?>" ).unbind('click').bind('click', function( ) {
			start_chat( ) ;
		}) ;

		var key_count = 0 ;
		for ( var key_ in dept_offline ) {
			key_count++ ;
		}
		if ( !key_count )
		{
			$('#pre_chat_form').hide( ) ;
			$('#pre_chat_no_depts').show( ) ;
		}

		$('#token').val( phplive_browser_token ) ;

		if ( mobile ) { $('#embed_win_popout').hide() ; }
		else if ( popout ) { $('#embed_win_popout').show() ; }

		$('#chat_submit_btn').show() ;
		$('body').show( ) ;

		select_dept( <?php echo $deptid ?> ) ;

		<?php if ( ( count( $departments ) > 1 ) || $dept_name_vis ) : ?>$('#div_vdeptids').show( ) ;<?php endif ; ?>

		if ( typeof( $('#pre_chat_form').position() ) != "undefined" )
		{
			var chat_form_pos = $('#pre_chat_form').position() ; global_form_x = chat_form_pos.top ;
			var chat_body_height = $('#request_body').height() ;
			var chat_form_height = $('#pre_chat_form').height() ;
			var diff_height = parseInt(chat_body_height) - parseInt(chat_form_height) ;

			global_diff_height = diff_height - parseInt( chat_form_height ) ;
		}
		init_divs_pre() ;
		if ( embed )
			start_win_status_listener() ;
	});
	$(window).resize(function( ) {
		init_divs_pre() ;
	});

	function init_divs_pre()
	{
		var chat_body_padding = $('#request_body').css('padding-left') ;
		chat_body_padding = ( typeof( chat_body_padding ) != "undefined" ) ? parseInt( chat_body_padding.replace( /px/, "" ) ) : 0 ;

		var browser_height = $('body').height( ) ;
		var buffer_padding = ( mobile ) ? 140 : 150 ;
		var body_height = browser_height - buffer_padding ;
		if ( embed )
		{
			body_height = body_height - 25 - $('#chat_embed_header').height() ;
		}

		body_height = body_height+"px" ;

		var submit_btn_padding_top = ( mobile ) ? 25 : 25 ;
		submit_btn_padding_top = submit_btn_padding_top+"px" ;

		var browser_width = $('body').width( ) ;
		var body_width = browser_width - (chat_body_padding*2) ;
		body_width = body_width+"px" ;

		var chat_btn_left = chat_body_padding+"px" ;

		var deptid_width = $('#request_body').width( ) ;
		var vquestion_width = deptid_width - 15 ;
		var input_width = Math.floor( deptid_width/2 ) - 25 ;

		$('#request_body').css({'height': body_height}) ;
		$('#table_pre_chat_form_table').css({'width': body_width}) ;
		$('#chat_text_powered').css({'margin-right': chat_btn_left, 'font-size': '10px'}) ;
		$('#chat_submit_btn').css({'margin-left': chat_btn_left, 'margin-top': submit_btn_padding_top}) ;
		$('#vdeptid').css({'width': deptid_width}) ;

		$('#vname').css({'width': input_width}) ;
		$('#vemail').css({'width': input_width}) ;
		$('#vsubject').css({'width': input_width}) ;
		$('#vquestion').css({'width': vquestion_width}) ;
		$('#custom_field_input_1').css({'width': input_width}) ;
		$('#custom_field_input_2').css({'width': input_width}) ;
		$('#custom_field_input_3').css({'width': input_width}) ;
		if ( mobile ) { $('#vquestion').css({'height': "45px" }) ; }
	}

	function init_divs_input( thedeptid, theonoff )
	{
		$("#table_pre_chat_form").find('*').each( function(){
			var div_name = this.id ;
			if ( div_name.indexOf("div_field_") != -1 )
				$(this).hide() ;
		} );

		var index = 1 ;
		if ( !theonoff || ( typeof( dept_prechat_form[thedeptid] ) == "undefined" ) || ( ( typeof( dept_prechat_form[thedeptid] ) != "undefined" ) && parseInt( dept_prechat_form[thedeptid] ) ) )
		{
			for ( var key in show_divs )
			{
				if ( show_divs.hasOwnProperty(key) )
				{
					var thisfield = show_divs[key] ;
					if ( typeof( thisfield["required"] ) != "undefined" )
					{
						if ( key == "vname" )
						{
							$('#div_field_'+index).html( "<div><?php echo $LANG["TXT_NAME"] ?></div><input type=\"input\" class=\"input_text\" id=\"vname\" name=\"vname\" maxlength=\"30\" value=\"<?php echo isset( $requestinfo["vname"] ) ? $requestinfo["vname"] : $vname ; ?>\" onKeyPress=\"return noquotestags(event)\" onFocus=\"check_mobile_view('vname', 1)\" onBlur=\"check_mobile_view('vname', 0)\" <?php echo ( $js_name ) ? "readonly" : "" ?> autocomplete=\"off\">" ).show() ;
							++index ;
						}
						else if ( ( key == "vemail" ) && ( !show_divs["vemail"]["optional"] || !theonoff ) && thedeptid )
						{
							var optional_string = ( !theonoff ) ? "" : show_divs["vemail"]["optional"] ;
							$('#div_field_'+index).html( "<div><?php echo $LANG["TXT_EMAIL"] ?> "+optional_string+"</div><input type=\"input\" class=\"input_text\" id=\"vemail\" name=\"vemail\" maxlength=\"160\" value=\"<?php echo isset( $requestinfo["vemail"] ) ? $requestinfo["vemail"] : $vemail ; ?>\" onFocus=\"check_mobile_view('vemail', 1)\" onBlur=\"check_mobile_view('vemail', 0)\" <?php echo ( isset( $requestinfo["vemail"] ) || $vemail ) ? "tabindex='-1'" : "" ; ?> onKeyPress=\"return justemails(event)\" <?php echo ( $js_email ) ? "readonly" : "" ?>>" ).show() ;
							++index ;
						}
						else if ( key == "custom_field_input_1" )
						{
							var disabled = ( show_divs["custom_field_input_1"]["disabled"] || show_divs["custom_field_input_1"]["value"] ) ? "readonly" : "" ;
							$('#div_field_'+index).html( "<div>"+show_divs["custom_field_input_1"]["title"]+show_divs["custom_field_input_1"]["optional"]+"</div><input type=\"input\" class=\"input_text\" id=\"custom_field_input_1\" name=\"custom_field_input_1\" maxlength=\"70\" onKeyPress=\"return noquotestags(event)\" onFocus=\"check_mobile_view('custom_field_input_1', 1)\" onBlur=\"check_mobile_view('custom_field_input_1', 0)\" value=\""+show_divs["custom_field_input_1"]["value"]+"\" "+disabled+" autocomplete=\"off\">" ).show() ;
							++index ;
						}
						else if ( key == "custom_field_input_2" )
						{
							var disabled = ( show_divs["custom_field_input_2"]["disabled"] || show_divs["custom_field_input_2"]["value"] ) ? "readonly" : "" ;
							$('#div_field_'+index).html( "<div>"+show_divs["custom_field_input_2"]["title"]+show_divs["custom_field_input_2"]["optional"]+"</div><input type=\"input\" class=\"input_text\" id=\"custom_field_input_2\" name=\"custom_field_input_2\" maxlength=\"70\" onKeyPress=\"return noquotestags(event)\" onFocus=\"check_mobile_view('custom_field_input_2', 1)\" onBlur=\"check_mobile_view('custom_field_input_2', 0)\" value=\""+show_divs["custom_field_input_2"]["value"]+"\" "+disabled+" autocomplete=\"off\">" ).show() ;
							++index ;
						}
						else if ( key == "custom_field_input_3" )
						{
							var disabled = ( show_divs["custom_field_input_3"]["disabled"] || show_divs["custom_field_input_3"]["value"] ) ? "readonly" : "" ;
							$('#div_field_'+index).html( "<div>"+show_divs["custom_field_input_3"]["title"]+show_divs["custom_field_input_3"]["optional"]+"</div><input type=\"input\" class=\"input_text\" id=\"custom_field_input_3\" name=\"custom_field_input_3\" maxlength=\"70\" onKeyPress=\"return noquotestags(event)\" onFocus=\"check_mobile_view('custom_field_input_3', 1)\" onBlur=\"check_mobile_view('custom_field_input_3', 0)\" value=\""+show_divs["custom_field_input_3"]["value"]+"\" "+disabled+" autocomplete=\"off\">" ).show() ;
							++index ;
						}
						else if ( key == "vsubject" )
						{
							$('#div_field_'+index).html( "<div><?php echo $LANG["TXT_SUBJECT"] ?></div><input type=\"input\" class=\"input_text\" id=\"vsubject\" name=\"vsubject\" maxlength=\"125\" onKeyPress=\"return noquotestags(event)\" onFocus=\"check_mobile_view('vsubject', 1)\" onBlur=\"check_mobile_view('vsubject', 0)\" autocomplete=\"off\">" ).show() ;
							++index ;
						}
						else if ( ( key == "vquestion" ) && !show_divs["vquestion"]["optional"] )
						{
							$('#div_field_9').html( "<div><?php echo $LANG["TXT_QUESTION"] ?> "+show_divs["vquestion"]["optional"]+"</div><textarea class=\"input_text\" id=\"vquestion\" name=\"vquestion\" rows=\"3\" wrap=\"virtual\" style=\"resize: vertical;\" onFocus=\"check_mobile_view('vquestion', 1)\" onBlur=\"check_mobile_view('vquestion', 0)\" <?php echo ( isset( $VALS["AUTOCORRECT_V"] ) && !$VALS["AUTOCORRECT_V"] ) ? "autocomplete='off' autocorrect='off'" : "" ; ?>><?php echo isset( $requestinfo["question"] ) ? $requestinfo["question"] : $vquestion ; ?></textarea>" ).show() ;
						}
					}
				}
			}
		}
		init_divs_pre() ;
	}

	var show_divs ;
	function select_dept( thevalue )
	{
		$('#deptid').val( thevalue ) ;
		$('#custom_field_input_1').val('') ;
		$('#custom_field_input_2').val('') ;
		$('#custom_field_input_3').val('') ;

		show_divs = new Object ;
		show_divs["vname"] = new Object ;
		show_divs["vname"]["required"] = 1 ;
		show_divs["vemail"] = new Object ;
		if ( ( ( typeof( dept_settings[thevalue] ) != "undefined" ) && dept_settings[thevalue][0] ) || !thevalue )
		{
			$('#optional_email').html( "" ) ;
			show_divs["vemail"]["required"] = 1 ;
			show_divs["vemail"]["optional"] = "" ;
		}
		else
		{
			$('#optional_email').html( " (<?php echo $LANG["TXT_OPTIONAL"] ?>)" ) ;
			show_divs["vemail"]["required"] = 0 ;
			show_divs["vemail"]["optional"] = " (<?php echo $LANG["TXT_OPTIONAL"] ?>)" ;
		}

		custom_required = 0 ; custom_required2 = 0 ; custom_required3 = 0 ;
		$('#div_customs').hide( ) ; $('#div_customs2').hide( ) ; $('#div_customs3').hide( ) ;

		if ( thevalue && ( typeof( dept_customs[thevalue] ) != "undefined" ) )
		{
			custom_required = dept_customs[thevalue][1] ;
			show_divs["custom_field_input_1"] = new Object ;
			if ( dept_customs[thevalue][0] )
			{
				if ( typeof( custom_hash[dept_customs[thevalue][0]] ) != "undefined" ) { show_divs["custom_field_input_1"]["disabled"] = 1 ; }
				else { show_divs["custom_field_input_1"]["disabled"] = 0 ; }
				show_divs["custom_field_input_1"]["required"] = custom_required ;
			}
			else { custom_required = 0 ; }
			show_divs["custom_field_input_1"]["optional"] = ( custom_required ) ? "" : " (<?php echo $LANG["TXT_OPTIONAL"] ?>)" ;
			show_divs["custom_field_input_1"]["title"] = dept_customs[thevalue][0] ;
			show_divs["custom_field_input_1"]["value"] = ( typeof( custom_hash[dept_customs[thevalue][0]] ) != "undefined" ) ? custom_hash[dept_customs[thevalue][0]] : "" ;

			custom_required2 = dept_customs[thevalue][3] ;
			show_divs["custom_field_input_2"] = new Object ;
			if ( dept_customs[thevalue][2] )
			{
				if ( typeof( custom_hash[dept_customs[thevalue][2]] ) != "undefined" ) { show_divs["custom_field_input_2"]["disabled"] = 1 ; }
				else { show_divs["custom_field_input_1"]["disabled"] = 0 ; }
				show_divs["custom_field_input_2"]["required"] = custom_required2 ;
			}
			else { custom_required2 = 0 ; }
			show_divs["custom_field_input_2"]["optional"] = ( custom_required2 ) ? "" : " (<?php echo $LANG["TXT_OPTIONAL"] ?>)" ;
			show_divs["custom_field_input_2"]["title"] = dept_customs[thevalue][2] ;
			show_divs["custom_field_input_2"]["value"] = ( typeof( custom_hash[dept_customs[thevalue][2]] ) != "undefined" ) ? custom_hash[dept_customs[thevalue][2]] : "" ;

			custom_required3 = dept_customs[thevalue][5] ;
			show_divs["custom_field_input_3"] = new Object ;
			if ( dept_customs[thevalue][4] )
			{
				if ( typeof( custom_hash[dept_customs[thevalue][4]] ) != "undefined" ) { show_divs["custom_field_input_3"]["disabled"] = 1 ; }
				else { show_divs["custom_field_input_3"]["disabled"] = 0 ; }
				show_divs["custom_field_input_3"]["required"] = custom_required3 ;
			}
			else { custom_required3 = 0 ; }
			show_divs["custom_field_input_3"]["optional"] = ( custom_required3 ) ? "" : " (<?php echo $LANG["TXT_OPTIONAL"] ?>)" ;
			show_divs["custom_field_input_3"]["title"] = dept_customs[thevalue][4] ;
			show_divs["custom_field_input_3"]["value"] = ( typeof( custom_hash[dept_customs[thevalue][4]] ) != "undefined" ) ? custom_hash[dept_customs[thevalue][4]] : "" ;
		}

		if ( ( $('#vdeptid option:selected').attr( "class" ) == "offline" ) )
		{
			onoff = 0 ;
			$('#chat_text_header').html( "<?php echo Util_Format_ConvertQuotes( $LANG["MSG_LEAVE_MESSAGE"] ) ?>" ) ;
			$('#chat_text_header_sub').html( dept_offline[thevalue] ) ;

			if ( typeof( dept_offline_form[thevalue] ) != "undefined" )
			{
				if ( parseInt( dept_offline_form[thevalue] ) ) { $('#table_pre_chat_form').show() ; $('#chat_submit_btn').css('opacity', '1') ; $('#chat_text_header').show() ; }
				else { $('#table_pre_chat_form').hide() ; $('#chat_submit_btn').css('opacity', '0.0') ; $('#chat_text_header').hide() ; }
			} else { $('#table_pre_chat_form').show() ; $('#chat_submit_btn').css('opacity', '1') ; $('#chat_text_header').show() ; }

			if ( parseInt( js_email ) ) { show_divs["vemail"]["disabled"] = 1 ; }
			show_divs["vsubject"] = new Object ;
			show_divs["vsubject"]["required"] = 1 ;
			show_divs["vquestion"] = new Object ;
			show_divs["vquestion"]["required"] = 1 ;
			show_divs["vquestion"]["optional"] = "" ;
			show_divs["vemail"]["required"] = 1 ;
			$('#chat_button_start').html( "<?php echo $LANG["CHAT_BTN_EMAIL"] ?>" ).unbind('click').bind('click', function( ) {
				send_email( ) ;
			});
		}
		else
		{
			onoff = 1 ;
			$('#chat_text_header').html( "<?php echo Util_Format_ConvertQuotes( $LANG["CHAT_WELCOME"] ) ?>" ) ;
			$('#chat_text_header_sub').html( "<?php echo preg_replace( "/\"/", "&quot;", $LANG["CHAT_WELCOME_SUBTEXT"] ) ?>" ) ;

			if ( thevalue && ( typeof( dept_settings[thevalue] ) != "undefined" ) )
			{
				if ( dept_settings[thevalue][0] )
				{
					if ( parseInt( js_email ) ) { show_divs["vemail"]["disabled"] = 1 ; }
				}
				show_divs["vquestion"] = new Object ;
				if ( dept_settings[thevalue][2] ) { show_divs["vquestion"]["required"] = 1 ; show_divs["vquestion"]["optional"] = "" ; }
				else { show_divs["vquestion"]["required"] = 0 ; show_divs["vquestion"]["optional"] = " (<?php echo $LANG["TXT_OPTIONAL"] ?>)" ; }
			}

			if ( parseInt( thevalue ) )
			{
				$('#chat_button_start').html( "<?php echo $LANG["CHAT_BTN_START_CHAT"] ?>" ).unbind('click').bind('click', function( ) {
					start_chat( ) ;
				});
			}
			else
			{
				$('#chat_button_start').html( "<?php echo $LANG["TXT_SUBMIT"] ?>" ).attr( "disabled", false ).unbind('click').bind('click', function( ) {
					start_chat( ) ;
				});
			}

			if ( <?php echo $dept_offline_hasform ?> ) { $('#table_pre_chat_form').show() ; $('#chat_submit_btn').css('opacity', '1') ; $('#chat_text_header').show() ; }
		}
		init_divs_input( thevalue, onoff ) ;
	}

	function check_form( theflag )
	{
		var error = 0 ;
		var deptid = parseInt( $('#deptid').val( ) ) ;

		if ( !theflag && ( typeof( dept_prechat_form[deptid] ) != "undefined" ) && !parseInt( dept_prechat_form[deptid] ) )
		{ $('#skp').val(1) ; return true ; }

		if ( !deptid ){
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_DEPT"] ?>" ) ;
			return false ;
		}
		if ( !$('#vsubject').val( ) ){
			if ( theflag )
			{
				$('#vsubject').addClass('input_focus') ;
				do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_SUBJECT"] ?>" ) ;
				if ( $('#div_field_3').is(':visible') || $('#div_field_5').is(':visible') ) { $("#request_body").animate({ scrollTop: $(document).height() }, "slow") ; }
				return false ;
			}
		}
		var vname_temp = $('#vname').val( ).replace(/ +/, "") ;
		if ( vname_temp == "" ) { $('#vname').val( "" ) ; }
		if ( !$('#vname').val( ) )
		{
			$('#vname').addClass('input_focus') ;
			do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_NAME"] ?>" ) ;
			return false ;
		}
		if ( !$('#vemail').val( ) ){
			if ( dept_settings[deptid][0] || theflag )
			{
				$('#vemail').addClass('input_focus') ;
				do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_EMAIL"] ?>" ) ;
				return false ;
			}
		}
		var vquestion_temp = ( $('#vquestion').val( ) ) ? $('#vquestion').val( ).replace(/ +/, "") : "" ;
		if ( vquestion_temp == "" ) { $('#vquestion').val( "" ) ; }
		if ( !$('#vquestion').val( ) ){
			if ( dept_settings[deptid][2] || theflag )
			{
				$('#vquestion').addClass('input_focus') ;
				do_alert( 0, "<?php echo $LANG["CHAT_JS_BLANK_QUESTION"] ?>" ) ;
				if ( $('#div_field_9').is(':visible') ) { $("#request_body").animate({ scrollTop: $(document).height() }, "slow") ; }
				return false ;
			}
		}
		if ( !check_email( $('#vemail').val( ) ) ){
			if ( dept_settings[deptid][0] || theflag )
			{
				$('#vemail').addClass('input_focus') ;
				do_alert( 0, "<?php echo $LANG["CHAT_JS_INVALID_EMAIL"] ?>" ) ;
				return false ;
			}
		}
		if ( custom_required && !$('#custom_field_input_1').val( ) ){
			$('#custom_field_input_1').addClass('input_focus') ;
			do_alert( 0, "<?php echo $LANG["CHAT_JS_CUSTOM_BLANK"] ?>"+" "+show_divs["custom_field_input_1"]["title"] ) ;
			if ( $('#div_field_3').is(':visible') || $('#div_field_5').is(':visible') ) { $("#request_body").animate({ scrollTop: $(document).height() }, "slow") ; }
			return false ;
		}
		if ( custom_required2 && !$('#custom_field_input_2').val( ) ){
			$('#custom_field_input_2').addClass('input_focus') ;
			do_alert( 0, "<?php echo $LANG["CHAT_JS_CUSTOM_BLANK"] ?>"+" "+show_divs["custom_field_input_2"]["title"] ) ;
			if ( $('#div_field_3').is(':visible') || $('#div_field_5').is(':visible') ) { $("#request_body").animate({ scrollTop: $(document).height() }, "slow") ; }
			return false ;
		}
		if ( custom_required3 && !$('#custom_field_input_3').val( ) ){
			$('#custom_field_input_3').addClass('input_focus') ;
			do_alert( 0, "<?php echo $LANG["CHAT_JS_CUSTOM_BLANK"] ?>"+" "+show_divs["custom_field_input_3"]["title"] ) ;
			if ( $('#div_field_3').is(':visible') || $('#div_field_5').is(':visible') ) { $("#request_body").animate({ scrollTop: $(document).height() }, "slow") ; }
			return false ;
		}
		return true ;
	}

	function start_chat()
	{
		if ( check_form(0) )
		{
			if ( !$('#div_chat_loading_img').is(':visible') )
			{
				var unique = unixtime( ) ;
				var deptid = $('#deptid').val( ) ;
				var vemail = encodeURIComponent( $('#vemail').val() ) ;
				var custom_field_value_1 = ( typeof( $('#custom_field_input_1').val( ) ) != "undefined" ) ? $('#custom_field_input_1').val( ) : "" ;
				var custom_field_value_2 = ( typeof( $('#custom_field_input_2').val( ) ) != "undefined" ) ? $('#custom_field_input_2').val( ) : "" ;
				var custom_field_value_3 = ( typeof( $('#custom_field_input_3').val( ) ) != "undefined" ) ? $('#custom_field_input_3').val( ) : "" ;
				var custom_extra = ( typeof( dept_customs[deptid] ) != "undefined" ) ? encodeURIComponent( dept_customs[deptid][0] )+"-_-"+encodeURIComponent( custom_field_value_1 )+"-cus-"+encodeURIComponent( dept_customs[deptid][2] )+"-_-"+encodeURIComponent( custom_field_value_2 )+"-cus-"+encodeURIComponent( dept_customs[deptid][4] )+"-_-"+encodeURIComponent( custom_field_value_3 )+"-cus-" : "" ;
				var custom = encodeURIComponent( "<?php echo ( $custom ) ? $custom : "" ; ?>" ) + custom_extra ;
				$('#custom').val( custom ) ;
	
				$('#div_chat_loading_img').show() ;
				$.ajax({
				type: "POST",
				url: "./ajax/validate.php",
				data: "&vemail="+vemail+"&custom="+custom+"&unique="+unique,
				success: function(jdata){
					try {
						eval(jdata) ;
					} catch(err) {
						do_alert( 0, err ) ;
						$('#div_chat_loading_img').hide() ;
						return false ;
					}

					if ( json_data.status )
					{
						$('#request_body_wrapper').fadeOut("fast").promise( ).done(function( ) {
							$('#theform').submit( ) ;
						}) ;
					}
					else
					{
						do_alert( 0, json_data.error ) ;
						$('#div_chat_loading_img').hide() ;
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					do_alert( 0, "Could not connect to server.  Please try again. [e550]" ) ;
					$('#div_chat_loading_img').hide() ;
				} });
			}
		}
	}

	function send_email()
	{
		if( check_form(1) )
		{
			var json_data = new Object ;
			var unique = unixtime( ) ;
			var deptid = $('#deptid').val( ) ;
			var vname = $('#vname').val( ) ;
			var vemail = encodeURIComponent( $('#vemail').val() ) ;
			var vsubject = encodeURIComponent( $('#vsubject').val( ) ) ;
			var vquestion = encodeURIComponent( $('#vquestion').val( ) ) ;
			var onpage = encodeURIComponent( "<?php echo $onpage ?>" ).replace( /http/g, "hphp" ) ;
			var custom_field_value_1 = ( typeof( $('#custom_field_input_1').val( ) ) != "undefined" ) ? $('#custom_field_input_1').val( ) : "" ;
			var custom_field_value_2 = ( typeof( $('#custom_field_input_2').val( ) ) != "undefined" ) ? $('#custom_field_input_2').val( ) : "" ;
			var custom_field_value_3 = ( typeof( $('#custom_field_input_3').val( ) ) != "undefined" ) ? $('#custom_field_input_3').val( ) : "" ;
			var custom_extra = ( typeof( dept_customs[deptid] ) != "undefined" ) ? encodeURIComponent( dept_customs[deptid][0] )+"-_-"+encodeURIComponent( custom_field_value_1 )+"-cus-"+encodeURIComponent( dept_customs[deptid][2] )+"-_-"+encodeURIComponent( custom_field_value_2 )+"-cus-"+encodeURIComponent( dept_customs[deptid][4] )+"-_-"+encodeURIComponent( custom_field_value_3 )+"-cus-" : "" ;
			var custom = encodeURIComponent( "<?php echo ( $custom ) ? $custom : "" ; ?>" ) + custom_extra ;

			$('#chat_button_start').attr( "disabled", true ) ;
			$.ajax({
			type: "POST",
			url: "./phplive_m.php",
			data: "action=send_email&deptid="+deptid+"&token="+phplive_browser_token+"&vname="+vname+"&vemail="+vemail+"&custom="+custom+"&vsubject="+vsubject+"&vquestion="+vquestion+"&onpage="+onpage+"&unique="+unique,
			success: function(jdata){
				try {
					eval(jdata) ;
				} catch(err) {
					do_alert( 0, err ) ;
					return false ;
				}

				if ( json_data.status )
				{
					do_alert( 1, "<?php echo $LANG["CHAT_JS_EMAIL_SENT"] ?>" ) ;
					$('#chat_button_start').attr( "disabled", true ) ;
					$('#chat_button_start').html( "<img src=\"./themes/<?php echo $theme ?>/alert_good.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\"> <?php echo $LANG["CHAT_JS_EMAIL_SENT"] ?>" ) ;
				}
				else
				{
					do_alert( 0, json_data.error ) ;
					$('#chat_button_start').html( "<?php echo $LANG["CHAT_BTN_EMAIL"] ?>" ) ;
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				do_alert( 0, "Error sending email.  Please refresh the page and try again." ) ;
			} });
		}
	}

	function preview_text( thetxt_embed, thetxt_header, thetxt_sub, thetxt_department, thetxt_select )
	{
		$('#chat_text_title').html( thetxt_embed ) ;
		$('#chat_text_header').html( thetxt_header ) ;
		$('#chat_text_header_sub').html( thetxt_sub ) ;
		$('#chat_text_department').html( thetxt_department ) ;
		$('#vdeptid option:eq(0)').text( thetxt_select ) ;
	}

	function check_mobile_view( theinput, theflag )
	{
		$('#'+theinput).removeClass('input_focus') ;
	}
//-->
</script>
</head>
<body style="display: none; overflow: hidden; -webkit-text-size-adjust: 100%;">
<div id="chat_canvas" style="min-height: 100%; width: 100%;"></div>
<div style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;">
	<?php include_once( "inc_embed_menu.php" ) ; ?>
	<div id="request_body_wrapper">
		<div id="request_body" style="overflow-y: auto; overflow-x: hidden; -webkit-overflow-scrolling: touch;">

			<?php if ( !$embed || ( $embed && isset( $emlogos_hash[0] ) && $emlogos_hash[0] ) ): ?>
			<div id="chat_logo" style="padding-bottom: 15px;"><img src="<?php echo Util_Upload_GetLogo( "logo", $deptid ) ?>" border=0 style="max-width: 100%; max-height: 100%;"></div>
			<?php endif ; ?>
			<div id="chat_text_header" style="margin-bottom: 5px;"><?php echo $LANG["CHAT_WELCOME"] ?></div>
			<div id="chat_text_header_sub" style=""><?php echo $LANG["CHAT_WELCOME_SUBTEXT"] ?></div>

			<form method="POST" action="phplive_.php" id="theform" accept-charset="<?php echo $LANG["CHARSET"] ?>">
			<input type="hidden" name="deptid" id="deptid" value="<?php echo ( isset( $requestinfo["deptID"] ) ) ? $requestinfo["deptID"] : $deptid ; ?>">
			<input type="hidden" name="ces" id="ces" value="<?php echo ( isset( $requestinfo["ces"] ) ) ? $requestinfo["ces"] : "" ; ?>">
			<input type="hidden" name="onpage" id="onpage" value="<?php echo ( isset( $requestinfo["ces"] ) ) ? urlencode( Util_Format_URL( $requestinfo["onpage"] ) ) : urlencode( Util_Format_URL( $onpage ) ) ; ?>">
			<input type="hidden" name="title" id="title" value="<?php echo ( isset( $requestinfo["ces"] ) ) ? $requestinfo["title"] : htmlentities( $title, ENT_QUOTES, "$LANG[CHARSET]" ) ; ?>">
			<input type="hidden" name="win_dim" id="win_dim" value="">
			<input type="hidden" name="token" id="token" value="">
			<input type="hidden" name="embed" id="embed" value="<?php echo $embed ?>">
			<input type="hidden" name="vis_token" value="<?php echo $vis_token ?>">
			<input type="hidden" name="skp" id="skp" value="0">
			<input type="hidden" name="theme" id="theme" value="<?php echo $theme ?>">
			<input type="hidden" name="popout" id="popout" value="<?php echo $popout ?>">
			<input type="hidden" name="custom" id="custom" value="<?php echo rawurlencode( $custom ) ?>">
			<input type="hidden" name="opid" id="opid" value="<?php echo $opid ?>">
			<input type="hidden" name="vname_" id="vname_" value="">
			<input type="hidden" name="vemail_" id="vemail_" value="">
			<input type="hidden" name="vquestion_" id="vquestion_" value="">

			<?php if ( $js_name || $js_email ): ?><input type="hidden" id="auto_pop" name="auto_pop" value="1"><?php endif ; ?>
			<?php if ( $js_name ): ?><input type="hidden" name="vname" value="<?php echo $vname ?>"><?php endif ; ?>
			<?php if ( $js_email ): ?><input type="hidden" name="vemail" value="<?php echo $vemail ?>"><?php endif ; ?>
			<div id="pre_chat_form" style="">
				<div id="div_vdeptids" style="display: none; margin-top: 15px;">
					<div><span id="chat_text_department"><?php echo $LANG["TXT_DEPARTMENT"] ?></span></div>
					<select id="vdeptid" onChange="select_dept(this.value)" style="-webkit-appearance: none;"><option value=0><?php echo $LANG["CHAT_SELECT_DEPT"] ?></option>
					<?php
						$selected = "" ;
						for ( $c = 0; $c < count( $departments ); ++$c )
						{
							$department = $departments[$c] ;
							$class = "offline" ; $text = $LANG["TXT_OFFLINE"] ;
							if ( $dept_online[$department["deptID"]] ) { $class = "online" ; $text = $LANG["TXT_ONLINE"] ; }
							if ( count( $departments ) == 1 ) { $selected = "selected" ; }
							print "<option class=\"$class\" value=\"$department[deptID]\" $selected>$department[name] - $text</option>" ;
						}
					?>
					</select>
				</div>
				<div id="table_pre_chat_form" style="display: none; margin-top: 15px;">
					<table cellspacing=0 cellpadding=0 border=0 id="table_pre_chat_form_table">
					<tr>
						<td width="50%" style="display: none; padding-right: 10px;" id="div_field_1" valign="top"></td>
						<td width="50%" style="display: none; padding-left: 10px;" id="div_field_2" valign="top"></td>
					</tr>
					<tr>
						<td width="50%" style="display: none; padding-right: 10px; padding-top: 15px;" id="div_field_3" valign="top"></td>
						<td width="50%" style="display: none; padding-left: 10px; padding-top: 15px;" id="div_field_4" valign="top"></td>
					</tr>
					<tr>
						<td width="50%" style="display: none; padding-right: 10px; padding-top: 15px;" id="div_field_5" valign="top"></td>
						<td width="50%" style="display: none; padding-left: 10px; padding-top: 15px;" id="div_field_6" valign="top"></td>
					</tr>
					<tr>
						<td width="50%" style="display: none; padding-right: 10px; padding-top: 15px;" id="div_field_7" valign="top"></td>
						<td width="50%" style="display: none; padding-left: 10px; padding-top: 15px;" id="div_field_8" valign="top"></td>
					</tr>
					<tr>
						<td colspan=2 style="display: none; padding-top: 15px;" id="div_field_9" valign="top"></td>
					</tr>
					</table>
				</div>
			</div>

			<div id="pre_chat_no_depts" style="display: none; margin-top: 10px;" class="info_error">
				There are no visible live chat departments available.  Please try back at another time.  If you are the live chat Setup Admin, enable at least one department to be "Visible for Selection".
			</div>

		</div>
		<div id="chat_submit_btn" style="display: none; padding: 0px !important; width: 160px; z-Index: 15;">
			<table cellspacing=0 cellpadding=0 border=0><tr><td><button id="chat_button_start" class="input_button" type="button" style="width: 160px; height: 45px; font-size: 14px; font-weight: bold; padding: 6px;"><?php echo $LANG["CHAT_BTN_START_CHAT"] ?></button></td><td style="padding-left: 15px;"><div id="div_chat_loading_img" style="display: none;"><img src="themes/<?php echo $theme ?>/loading_chat.gif" width="16" height="16" border="0" alt=""></div></td></tr></table>
		</div>
		<div id="chat_text_powered" style="text-align: right; font-size: 10px; z-Index: 3;"><?php if ( isset( $CONF["KEY"] ) && ( $CONF["KEY"] == md5($KEY."-c615") ) ): ?><?php else: ?>&nbsp;<br>powered by <a href="https://www.phplivesupport.com/?plk=pi-23-78m-m" target="_blank">PHP Live!</a><?php endif ; ?></div>
	</div>
</div>
</form>
<div id="blank_cover" style="display: none; position: absolute; width: 100%; height: 90%; background: url( pics/bg_trans_white.png ) repeat; z-Index: 11;" onClick="parent.close_view()">&nbsp;</div>

</body>
</html>
<?php
	if ( isset( $dbh ) && isset( $dbh['con'] ) )
		database_mysql_close( $dbh ) ;
?>
