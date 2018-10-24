<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	if ( !$opinfo = Util_Security_AuthOp( $dbh ) ){ ErrorHandler( 602, "Invalid operator session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	// STANDARD header end
	/****************************************/

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;

	$error = "" ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$page = Util_Format_Sanatize( Util_Format_GetVar( "page" ), "n" ) ;
	$index = Util_Format_Sanatize( Util_Format_GetVar( "index" ), "n" ) ;
	$tid = Util_Format_Sanatize( Util_Format_GetVar( "tid" ), "n" ) ;
	$theme = $opinfo["theme"] ;

	$operators = Ops_get_AllOps( $dbh ) ;
	$departments = Depts_get_OpDepts( $dbh, $opinfo["opID"] ) ;

	// make hash for quick refrence
	$operators_hash = Array() ;
	for ( $c = 0; $c < count( $operators ); ++$c )
	{
		$operator = $operators[$c] ;
		$operators_hash[$operator["opID"]] = $operator["name"] ;
	}

	$dept_hash = Array() ; $dept_customs = Array() ;
	for ( $c = 0; $c < count( $departments ); ++$c )
	{
		$department = $departments[$c] ;
		$dept_hash[$department["deptID"]] = $department["name"] ;
		if ( $department["custom"] )
		{
			$custom = unserialize( $department["custom"] ) ;
			$dept_customs = array_merge( $dept_customs, $custom ) ;
		}
	}

	$custom_search_options = "" ; $custom_search_field_hash = Array() ;
	for ( $c = 0; $c < count( $dept_customs ); ++$c )
	{
		$custom = $dept_customs[$c] ;
		if ( $custom && !isset( $custom_search_field_hash[$custom] ) )
		{ $custom_search_field_hash[$custom] = 1 ; $custom_search_options .= "<option value='cus_$c'>$custom</option>" ; }
		++$c ;
	}

	// fetch starting year of installation (admin created)
	$query = "SELECT adminID, created FROM p_admins WHERE adminID = 1 LIMIT 1" ;
	database_mysql_query( $dbh, $query ) ;
	$super_admin = database_mysql_fetchrow( $dbh ) ;
	if ( isset( $super_admin["created"] ) ) { $y_start = date( "Y", $super_admin["created"] ) ; }
	else { $y_start = 2011 ; }

	$text = Util_Format_Sanatize( Util_Format_GetVar( "text" ), "" ) ; $text = ( $text ) ? $text : "" ; $text_query = urlencode( $text ) ;
	$s_as = Util_Format_Sanatize( Util_Format_GetVar( "s_as" ), "ln" ) ;
	$year = Util_Format_Sanatize( Util_Format_GetVar( "y" ), "n" ) ; if ( !$year ) { $year = date( "Y", time() ) ; }
	$stat_start = mktime( 0, 0, 1, 1, 1, $year ) ;
	$stat_end = mktime( 23, 59, 59, 12, date( "t", mktime( 23, 59, 59, 12, 1, $year ) ), $year ) ;
	$transcripts = Chat_ext_get_OpDeptTrans( $dbh, $opinfo["opID"], $s_as, $text, $stat_start, $stat_end, $tid, $page, 20 ) ;
	
	$total_index = count($transcripts) - 1 ;
	$pages = Util_Functions_Page( $page, $index, 20, $transcripts[$total_index], "op_trans.php", "&tid=$tid&s_as=$s_as&text=$text_query" ) ;

	$tags = isset( $VALS['TAGS'] ) ? unserialize( $VALS['TAGS'] ) : Array() ;

	$addon_autotask = 0 ;
	if ( is_file( "$CONF[CONF_ROOT]/autotask_config.php" ) && isset( $VALS["AUTOTASK"] ) && $VALS["AUTOTASK"] )
	{
		include_once( "$CONF[CONF_ROOT]/autotask_config.php" ) ; // include it here for global reference in function Util_AutoTask_ParseCustom()
		include_once( "$CONF[DOCUMENT_ROOT]/addons/autotask/API/Util_AutoTask.php" ) ;
		$addon_autotask = 1 ;
	}
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> transcripts </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../themes/<?php echo $opinfo["theme"] ?>/style.css?<?php echo filemtime ( "../themes/$opinfo[theme]/style.css" ) ; ?>">
<script data-cfasync="false" type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/global_chat.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	var reset_url = "op_trans.php" ;
	var ces, newwin ;
	var widget ;

	$(document).ready(function()
	{
		init_trs() ;
		if ( !parent.mobile ) { }

		$('#input_search').focus() ;
		$('#form_search').bind("submit", function() { return false ; }) ;

		var div_height = parent.extra_wrapper_height - 45 ;
		$('#canned_container').css({'min-height': div_height}) ;

		//$(document).dblclick(function() {
		//	parent.close_extra( "trans" ) ;
		//});

		parent.init_extra_loaded() ;

		<?php if ( $error ): ?>do_alert( 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>
	});

	function init_trs()
	{
		$('#table_trs tr:nth-child(1n+1)').addClass('chat_info_tr_traffic_row') ;
	}

	function open_transcript( theces )
	{
		if ( typeof( ces ) != "undefined" )
			$('#img_'+ces).removeClass('chat_info_td_traffic_img') ;

		ces = theces ;
		$('#img_'+ces).addClass('chat_info_td_traffic_img') ;

		//$('#transcript_'+theces).html( "<img src=\"../themes/<?php echo $theme ?>/loading_fb.gif\" border=\"0\" alt=\"\">" ) ;
		parent.open_transcript( theces ) ;
	}

	function input_text_listen_search( e )
	{
		var key = -1 ;
		var shift ;

		key = e.keyCode ;
		shift = e.shiftKey ;

		if ( !shift && ( ( key == 13 ) || ( key == 10 ) ) )
			$('#btn_page_search').click() ;
	}

	function switch_tag( thevalue )
	{
		location.href = "op_trans.php?tid="+thevalue+"&"+unixtime() ;
	}
//-->
</script>
</head>
<body>

<div id="canned_container" style="padding: 15px; height: 200px; overflow: auto;">
	<div class="page_top_wrapper"><?php echo $pages ?></div>
	<div style="padding-bottom: 45px;">
		<table cellspacing=0 cellpadding=0 border=0 width="98%" id="table_trs">
		<tr>
			<td width="28"><div class="chat_info_td_t">&nbsp;<select style="padding: 2px; font-size: 10px; opacity:0.0; filter:alpha(opacity=0); width: 1px;"><option value="">&nbsp;</option></select></div></td>
			<td width="110"><div class="chat_info_td_t">Operator<select style="padding: 2px; font-size: 10px; opacity:0.0; filter:alpha(opacity=0); width: 1px;"><option value="">&nbsp;</option></select></div></td>
			<td width="110"><div class="chat_info_td_t">Visitor<select style="padding: 2px; font-size: 10px; opacity:0.0; filter:alpha(opacity=0); width: 1px;"><option value="">&nbsp;</option></select></div></td>
			<td width="150"><div class="chat_info_td_t">Created<select style="padding: 2px; font-size: 10px; opacity:0.0; filter:alpha(opacity=0); width: 1px;"><option value="">&nbsp;</option></select></div></td>
			<td width="80"><div class="chat_info_td_t">Duration<select style="padding: 2px; font-size: 10px; opacity:0.0; filter:alpha(opacity=0); width: 1px;"><option value="">&nbsp;</option></select></div></td>
			<td width=""><div class="chat_info_td_t">Question &nbsp; 
				<select id="select_tags" style="<?php echo ( !count( $tags ) ) ? "opacity:0.0; filter:alpha(opacity=0);" : "" ; ?> padding: 2px; font-size: 10px;" onChange="switch_tag(this.value)"><option value="0">All Tags</option>
				<?php
					foreach( $tags as $index => $value )
					{
						if ( $index != "c" )
						{
							LIST( $status, $color, $tag ) = explode( ",", $value ) ;
							$tag = rawurldecode( $tag ) ;
							if ( $status )
							{
								$selected = ( $index == $tid ) ? "selected" : "" ;
								print "<option value=\"$index\" $selected>$tag</option>" ;
							}
						}
					}
				?>
				</select>
			</div></td>
		</tr>
		<?php
			for ( $c = 0; $c < count( $transcripts )-1; ++$c )
			{
				$transcript = $transcripts[$c] ;

				// filter out random bugs of no operator data
				if ( $transcript["opID"] )
				{
					// intercept nulled operator accounts that have been deleted
					if ( !isset( $operators_hash[$transcript["op2op"]] ) ) { $operators_hash[$transcript["op2op"]] = "&nbsp;" ; }
					if ( !isset( $operators_hash[$transcript["opID"]] ) ) { $operators_hash[$transcript["opID"]] = "&nbsp;" ; }

					$operator = ( $transcript["op2op"] ) ? $operators_hash[$transcript["op2op"]] : $operators_hash[$transcript["opID"]] ;
					$created = date( "M j ($VARS_TIMEFORMAT)", $transcript["created"] ) ;
					$duration = $transcript["ended"] - $transcript["created"] ;
					$duration = Util_Format_Duration( $duration ) ;
					$question = preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", $transcript["question"] ) ;
					$vname = ( $transcript["op2op"] ) ? $operators_hash[$transcript["opID"]] : $transcript["vname"] ;
					$rating = Util_Functions_Stars( "..", $transcript["rating"] ) ;
					$initiated = ( $transcript["initiated"] ) ?  "<img src=\"../themes/$theme/info_initiate.gif\" width=\"10\" height=\"10\" border=\"0\" title=\"Operator Initiated Chat\" alt=\"Operator Initiated Chat\" style=\"cursor: help;\"> " : "" ;

					$autotask = "" ;
					if ( $addon_autotask && $transcript["atID"] )
					{
						$autotask_dlink_ticketid = Util_AutoTask_ParseCustom( $transcript["custom"] ) ;

						if ( $autotask_dlink_ticketid )
							$autotask = "<a href=\"$autotask_dlink_ticketid\" target=\"_blank\"><img src=\"../pics/icons/autotask.png\" width=\"20\" height=\"16\" border=\"0\" alt=\"\" title=\"Saved to AutoTask\" alt=\"Saved to AutoTask\" style=\"cursor: pointer;\" class=\"round\"></a> " ;
					}

					$note = ( $transcript["noteID"] ) ?  "<span><img src=\"../themes/$theme/info_flag.gif\" width=\"10\" height=\"10\" border=\"0\" title=\"includes visitor comment\" alt=\"includes visitor comment\" style=\"cursor: pointer;\" onClick=\"open_transcript('$transcript[ces]')\"></span>" : "" ;
					$tag_string = "" ;
					if ( isset( $tags[$transcript["tag"]] ) )
					{
						LIST( $sthistatus, $thiscolor, $thistag ) = explode( ",", $tags[$transcript["tag"]] ) ;
						$tag_string = "<span class=\"info_neutral\" style=\"padding: 4px; background: #$thiscolor; border: 1px solid #C2C2C2; color: #474747; text-shadow: none;\">".rawurldecode( preg_replace( "/(.*?),/", "", $tags[$transcript["tag"]] ) )."</span> " ;
					}

					if ( $transcript["op2op"] )
						$question = " <img src=\"../themes/$theme/agent.png\" width=\"16\" height=\"16\" border=\"0\" title=\"Operator to Operator Chat\" alt=\"Operator to Operator Chat\" style=\"cursor: help;\"> " ;

					print "<tr>
						<td class=\"chat_info_td_traffic\" id=\"img_$transcript[ces]\" style=\"text-align: center; -moz-border-radius: 5px; border-radius: 5px; cursor: pointer;\"><img src=\"../themes/$theme/view.png\" onClick=\"open_transcript('$transcript[ces]')\" width=\"16\" height=\"16\" title=\"view transcript\" alt=\"view transcript\"></td>
						<td class=\"chat_info_td_traffic\" nowrap><div id=\"transcript_$transcript[ces]\">$initiated $operator</div></td>
						<td class=\"chat_info_td_traffic\">$vname $note<div>$rating</div></td>
						<td class=\"chat_info_td_traffic\" nowrap>$created</td>
						<td class=\"chat_info_td_traffic\">$duration</td>
						<td class=\"chat_info_td_traffic\">$tag_string $autotask $question</td>
					</tr>" ;
				}
			}
			if ( $c == 0 )
				print "<tr><td colspan=8 class=\"chat_info_td_traffic\">Blank results.</td></tr>" ;
		?>
		</table>
		<div class="chat_info_end"></div>
		<?php if ( $total_index > 10 ): ?><div class="page_bottom_wrapper"><?php echo $pages ?></div><?php endif ; ?>
	</div>
</div>

</body>
</html>
<?php database_mysql_close( $dbh ) ; ?>