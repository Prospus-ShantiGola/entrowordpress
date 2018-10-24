<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	/****************************************/
	// STANDARD header for Setup
	if ( !is_file( "../web/config.php" ) ){ HEADER("location: install.php") ; exit ; }
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/".Util_Format_Sanatize($CONF["SQLTYPE"], "ln") ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Security.php" ) ;
	if ( !$admininfo = Util_Security_AuthSetup( $dbh ) ){ ErrorHandler( 608, "Invalid setup session or session has expired.", $PHPLIVE_FULLURL, 0, Array() ) ; exit ; }
	// STANDARD header end
	/****************************************/

	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Functions.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Chat/get_ext.php" ) ;

	$error = "" ; $now = time() ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$jump = ( Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) ) ? Util_Format_Sanatize( Util_Format_GetVar( "jump" ), "ln" ) : "report" ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$opid = Util_Format_Sanatize( Util_Format_GetVar( "opid" ), "n" ) ;
	$page = Util_Format_Sanatize( Util_Format_GetVar( "page" ), "n" ) ;
	$index = Util_Format_Sanatize( Util_Format_GetVar( "index" ), "n" ) ;

	$m = Util_Format_Sanatize( Util_Format_GetVar( "m" ), "n" ) ;
	$d = Util_Format_Sanatize( Util_Format_GetVar( "d" ), "n" ) ;
	$y = Util_Format_Sanatize( Util_Format_GetVar( "y" ), "n" ) ;
	if ( !$m ) { $m = date( "m", $now ) ; }
	if ( !$d ) { $d = date( "j", $now ) ; }
	if ( !$y ) { $y = date( "Y", $now ) ; }

	$today = mktime( 0, 0, 1, $m, $d, $y ) ;
	$stat_start = mktime( 0, 0, 1, $m, 1, $y ) ;
	$stat_end = mktime( 23, 59, 59, $m, date('t', $stat_start), $y ) ;
	$stat_end_day = date( "j", $stat_end ) ;

	$y_start = 2017 ;

	$tags = isset( $VALS['TAGS'] ) ? unserialize( $VALS['TAGS'] ) : Array() ;
	$tags_js_hash = "" ;
	foreach( $tags as $index => $value )
	{
		if ( $index != "c" )
		{
			LIST( $status, $color, $tag ) = explode( ",", $value ) ;
			$tag = rawurldecode( $tag ) ;
			if ( $status )
				$tags_js_hash .= "tags_hash.push($index) ; " ;
		}
	}
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> PHP Live! Support </title>

<meta name="description" content="PHP Live! Support <?php echo $VERSION ?>">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8">
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../css/setup.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	var tags_hash = new Array ;
	<?php echo $tags_js_hash ?>

	$(document).ready(function()
	{
		$("body").css({'background': '#E4EBF3'}) ;
		init_menu() ;
		toggle_menu_setup( "trans" ) ;

		show_div_tags( "<?php echo $jump ?>" ) ;

		fetch_tags() ;
		populate_report(0) ;
	});

	function switch_tag( thevalue )
	{
		location.href = "transcripts.php?deptid=<?php echo $deptid ?>&opid=<?php echo $opid ?>&tid="+thevalue ;
	}

	function show_div_tags( thediv )
	{
		var divs = Array( "tags", "report" ) ;
		for ( var c = 0; c < divs.length; ++c )
		{
			$('#tags_'+divs[c]).hide() ;
			$('#menu_tags_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu2') ;
		}

		$('#tags_'+thediv).show() ;
		$('#menu_tags_'+thediv).removeClass('op_submenu2').addClass('op_submenu_focus') ;
	}

	function populate_report( theunix )
	{
		if ( !"<?php echo $tags_js_hash ?>" ) { $('#tags_loading').hide() ; return true ; }
		var json_data = new Object ;

		$('#tbody_tag_stats').hide() ;
		$('#tags_loading').show() ;

		$.ajax({
			type: "POST",
			url: "../ajax/setup_actions_reports.php",
			data: "action=fetch_tag_stats&sdate="+theunix+"&m=<?php echo $m ?>&y=<?php echo $y ?>&"+unixtime(),
			success: function(data){
				eval( data ) ;

				var tags_string = "" ;
				for ( var c = 0; c < json_data.operators.length; ++c )
				{
					var operator = json_data.operators[c] ;
					var tids = operator.tids ;

					tags_string += "<tr><td class=\"td_dept_td\">"+decodeURIComponent( operator["name"] )+"</td>" ;
					for ( var c2 = 0; c2 < tags_hash.length; ++c2 )
					{
						var tid = tags_hash[c2] ;
						var total = 0 ;
						for ( var c3 = 0; c3 < tids.length; ++c3 )
						{
							var thistid = tids[c3] ;
							if ( thistid["tid"] == tid ) { total = thistid["total"] ; break ; }
						}
						var link = ( total ) ? "<a href=\"transcripts.php?opid="+operator["opid"]+"&tid="+tid+"\">"+total+"</a>" :  total ;
						tags_string += "<td class=\"td_dept_td\">"+link+"</td>" ;
					}
					tags_string += "</tr>" ;
				}
				$('#tags_loading').hide() ;
				$('#tbody_tag_stats').html( tags_string ).show() ;
			}
		});
	}

	function fetch_tags()
	{
		var json_data = new Object ;

		$.ajax({
			type: "POST",
			url: "../ajax/setup_actions.php",
			data: "action=tags&"+unixtime(),
			success: function(data){
				eval( data ) ;

				if ( typeof( json_data.tags ) != "undefined" )
				{
					var tags_string = "<table cellspacing=0 cellpadding=0 border=0 width=\"100%\">" ;
					for ( var c = 0; c < json_data.tags.length; ++c )
					{
						var id = json_data.tags[c]["id"] ;
						var tag = decodeURIComponent( json_data.tags[c]["tag"] ) ;
						var tag_color = ( json_data.tags[c]["color"] ) ? json_data.tags[c]["color"] : "" ;
						var tag_color_string = ( tag_color ) ? "<div class=\"info_neutral\" style=\"display: inline-block; height: 15px; border: 1px solid #C2C2C2; background: #"+json_data.tags[c]["color"]+"; color: #474747; text-shadow: none; -moz-border-radius: 0px; border-radius: 0px;\">"+tag+"</div>" : "" ;

						tags_string += "<tr id=\"tr_tag_"+id+"\"><td class=\"td_dept_td\" width=\"14\"><div id=\"tag_"+id+"\"><a href=\"JavaScript:void(0)\" onClick=\"remove_tag( '"+id+"' )\"><img src=\"../pics/icons/delete.png\" width=\"14\" height=\"14\" border=\"0\" alt=\"delete\" title=\"delete\"></a></div></td><td class=\"td_dept_td\" width=\"14\"><div id=\"tag_"+id+"\"><a href=\"JavaScript:void(0)\" onClick=\"edit_tag( '"+id+"', '"+tag_color+"', '"+json_data.tags[c]["tag"]+"' )\"><img src=\"../pics/icons/edit.png\" width=\"14\" height=\"14\" border=\"0\" alt=\"edit\" title=\"edit\"></a></div></td><td class=\"td_dept_td\">"+tag_color_string+"</td></tr>" ;
					}
					if ( !c )
						tags_string += "<tr><td class=\"td_dept_td\" colspan=3>Blank results.</td></tr>" ;
				}
				tags_string += "</table>" ;
				$('#tags').html( tags_string ) ;
			}
		});
	}

	function create_tag()
	{
		var tid = $('#tid').val() ;
		var tag = $('#tag').val() ;
		var color = $( "#color" ).val() ;

		if ( !tag )
			do_alert( 0, "Blank Tag is invalid." ) ;
		else if ( color == "" )
			do_alert( 0, "Please select a reference color." ) ;
		else
		{
			var json_data = new Object ;

			$('#btn_tag').attr( "disabled", true ) ;
			$('#img_loading_tag').show() ;
			$( "#color" ).val("") ; $( "#tcolor_li_"+color ).css( { "border": "1px solid #C2C2C2" } ) ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "action=add_tag&tid="+tid+"&tag="+tag+"&color="+color+"&"+unixtime(),
				success: function(data){
					eval(data) ;
					if ( json_data.status )
					{
						// timeout is due to possible server cache settings
						setTimeout( function(){
							$('#img_loading_tag').hide() ;
							$('#btn_tag').attr( "disabled", false ) ;
							fetch_tags() ;
							do_alert( 1, "Success" ) ;
						}, 3000 ) ;
					}
					else
					{
						$('#img_loading_tag').hide() ;
						$('#btn_tag').attr( "disabled", false ) ;
						$('#a_cancel').hide() ;
						do_alert( 0, "Tag already exists." ) ;
					}
					$('#tag').val('') ;
				}
			});
		}
	}

	function remove_tag( theid )
	{
		if ( confirm( "Delete this tag?" ) )
		{
			$('#tags').hide() ;
			$('#img_loading_tag').show() ;

			$.ajax({
				type: "POST",
				url: "../ajax/setup_actions.php",
				data: "action=remove_tag&id="+theid+"&"+unixtime(),
				success: function(data){
					// timeout is due to possible server cache settings
					setTimeout( function(){
						$('#tr_tag_'+theid).remove() ;
						$('#tags').show() ;
						$('#img_loading_tag').hide() ;
						do_alert( 1, "Success" ) ;
					}, 3000 ) ;
				}
			});
		}
	}

	function edit_tag( thetagid, thecolor, thetag )
	{
		$('#tid').val( thetagid ) ;
		$('#color').val( thecolor ) ; tcolor_focus( thecolor ) ;
		$('#tag').val( decodeURIComponent( thetag ) ) ;

		$('#a_cancel').show() ;
	}

	function cancel_tag()
	{
		$('#tid').val(0) ;
		$('#color').val('') ; tcolor_focus('') ;
		$('#tag').val('') ;

		$('#a_cancel').hide() ;
	}

	function tcolor_focus( thediv )
	{
		$( '#theform' ).find('*').each( function(){
			var div_name = this.id ;
			if ( div_name.indexOf( "tcolor_li_" ) != -1 )
				$(this).css( { "border": "1px solid #C2C2C2" } ) ;
		} );

		if ( thediv != undefined )
		{
			$( "#color" ).val( thediv ) ;
			$( "#tcolor_li_"+thediv ).css( { "border": "1px solid #444444" } ) ;
		}
	}
//-->
</script>
</head>
<?php include_once( "./inc_header.php" ) ?>

		<div class="op_submenu_wrapper">
			<div class="op_submenu" style="margin-left: 0px;" onClick="location.href='transcripts.php'" id="menu_trans_list">Transcripts</div>
			<div class="op_submenu_focus">Tags</div>
			<!-- <div class="op_submenu" onClick="show_div('encr')" id="menu_trans_encr">Encryption</div> -->
			<!-- <div class="op_submenu" onClick="location.href='transcripts_export.php'" id="menu_trans_export">Export</div> -->
			<div style="clear: both"></div>
		</div>

		<div style="margin-top: 25px;">
			<div class="op_submenu_focus" style="margin-left: 0px;" id="menu_tags_report" onClick="location.href='transcripts_tags.php'">Reports: Tags</div>
			<div class="op_submenu2" id="menu_tags_tags" onClick="location.href='transcripts_tags.php?jump=tags'">Tags List</div>
			<div style="clear: both"></div>
		</div>

		<div style="margin-top: 15px;">Categorize chats with tags (example: "important", "sales lead", "high interest").  <a href="ops.php">Operators</a> can "tag" a chat during a chat session.</div>

		<div id="tags_tags" style="display: none; margin-top: 25px;">
			<div style="">
				<form id="theform">
				<input type="hidden" name="tid" id="tid" value="">
				<input type="hidden" name="color" id="color" value="">
				<table cellspacing=0 cellpadding=0 border=0 width="100%">
				<tr>
					<td valign="top" nowrap style="padding-right: 25px; width: 250px;">
						<div class="info_info">
							<div>New Tag <big><b></b></big></div>
							<div style="margin-top: 15px;"><input type="text" name="tag" id="tag" size="20" maxlength="25" onKeyPress="return noquotes(event)"></div>
							<div style="margin-top: 15px;">
								<div id="tcolor_li_DDFFEE" style="float: left; cursor: pointer; width: 15px; height: 15px; margin-right: 3px; border: 1px solid #C2C2C2; background: #DDFFEE;" OnClick="tcolor_focus( 'DDFFEE' )"></div>
								<div id="tcolor_li_FFE07B" style="float: left; cursor: pointer; width: 15px; height: 15px; margin-right: 3px; border: 1px solid #C2C2C2; background: #FFE07B;" OnClick="tcolor_focus( 'FFE07B' )"></div>
								<div id="tcolor_li_A4C3E3" style="float: left; cursor: pointer; width: 15px; height: 15px; margin-right: 3px; border: 1px solid #C2C2C2; background: #A4C3E3;" OnClick="tcolor_focus( 'A4C3E3' )"></div>
								<div id="tcolor_li_FADADB" style="float: left; cursor: pointer; width: 15px; height: 15px; margin-right: 3px; border: 1px solid #C2C2C2; background: #FADADB;" OnClick="tcolor_focus( 'FADADB' )"></div>
								<div id="tcolor_li_FABEFF" style="float: left; cursor: pointer; width: 15px; height: 15px; margin-right: 3px; border: 1px solid #C2C2C2; background: #FABEFF;" OnClick="tcolor_focus( 'FABEFF' )"></div>
								<div id="tcolor_li_ABE3FA" style="float: left; cursor: pointer; width: 15px; height: 15px; margin-right: 3px; border: 1px solid #C2C2C2; background: #ABE3FA;" OnClick="tcolor_focus( 'ABE3FA' )"></div>
								<div id="tcolor_li_F9FABE" style="float: left; cursor: pointer; width: 15px; height: 15px; margin-right: 3px; border: 1px solid #C2C2C2; background: #F9FABE;" OnClick="tcolor_focus( 'F9FABE' )"></div>
								<div id="tcolor_li_BDBEF9" style="float: left; cursor: pointer; width: 15px; height: 15px; margin-right: 3px; border: 1px solid #C2C2C2; background: #BDBEF9;" OnClick="tcolor_focus( 'BDBEF9' )"></div>
								<div id="tcolor_li_B7E3A3" style="float: left; cursor: pointer; width: 15px; height: 15px; margin-right: 3px; border: 1px solid #C2C2C2; background: #B7E3A3;" OnClick="tcolor_focus( 'B7E3A3' )"></div>
								<div style="clear: both"></div>
							</div>
							<div style="margin-top: 25px;"><input type="button" onClick="create_tag()" value="Create Tag" class="btn" id="btn_tag"> &nbsp; &nbsp; &nbsp; <a href="JavaScript:void(0)" onClick="cancel_tag()" id="a_cancel" style="display: none;">cancel</a></div>

							<div style="margin-top: 15px;"><img src="../pics/icons/pin.png" width="14" height="14" border="0" alt=""> After creating or deleting a tag, the chat operators will need to logout of the operator console and login again to see the changes.</div>
						</div>
					</td>
					<td valign="top" width="100%">
						<div><div class="td_dept_header">Current Tags: &nbsp; <img src="../pics/loading_ci.gif" width="14" height="14" border="0" alt="" id="img_loading_tag" style="display: none;"></div></div>
						<div id="tags" style=""></div>
					</td>
				</tr>
				</table>
				</form>
			</div>
		</div>

		<div id="tags_report" style="margin-top: 25px; min-height: 300px; max-height: 350px; overflow: auto;">
			<div><?php include_once( "./inc_select_cal.php" ) ; ?></div>
			<div style="margin-top: 25px;">
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td nowrap><div class="td_dept_header">Operator Name<div style="display: inline-block; width: 15px; height: 15px; border: 1px solid #F6F7F8; background: #F6F7F8;"></div></div></td>
					<?php
						$active_tags = 0 ;
						foreach( $tags as $index => $value )
						{
							if ( $index != "c" )
							{
								LIST( $status, $color, $tag ) = explode( ",", $value ) ;
								$tag = rawurldecode( $tag ) ;
								if ( $status )
								{
									++$active_tags ;
									$tag_color = "<div style=\"display: inline-block; width: 15px; height: 15px; border: 1px solid #C2C2C2; background: #$color;\"></div>" ;
									print "<td nowrap><div class=\"td_dept_header\">$tag_color $tag</div></td>" ;
								}
							}
						}
					?>
				</tr>
				<tbody id="tbody_tag_stats">
				</tbody>
				</table>
				<?php if ( !$active_tags ): ?><div style="margin-top: 15px;">No tags created.  <img src="../pics/icons/add.png" width="16" height="16" border="0" alt=""> <a href="transcripts_tags.php?jump=tags">create tags</a></div><?php endif ; ?>
			</div>
			<div id="tags_loading" style="margin-top: 15px;"><img src="../pics/loading_fb.gif" width="16" height="11" border="0" alt=""></div>
		</div>

<?php include_once( "./inc_footer.php" ) ?>
