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

	$error = "" ;

	include_once( "$CONF[DOCUMENT_ROOT]/API/Ops/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Depts/get.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/get.php" ) ;

	$page = Util_Format_Sanatize( Util_Format_GetVar( "page" ), "n" ) ;
	$action = Util_Format_Sanatize( Util_Format_GetVar( "action" ), "ln" ) ;
	$option = Util_Format_Sanatize( Util_Format_GetVar( "option" ), "n" ) ;
	$deptid = Util_Format_Sanatize( Util_Format_GetVar( "deptid" ), "n" ) ;
	$canid = Util_Format_Sanatize( Util_Format_GetVar( "canid" ), "n" ) ;
	$bgcolor = Util_Format_Sanatize( Util_Format_GetVar( "bgcolor" ), "ln" ) ;

	$departments = Depts_get_AllDepts( $dbh ) ;
	$operators = Ops_get_AllOps( $dbh ) ;

	if ( $action === "update" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/put.php" ) ;

		$title = Util_Format_Sanatize( Util_Format_GetVar( "title" ), "ln" ) ;
		$message = Util_Format_ConvertQuotes( Util_Format_Sanatize( Util_Format_GetVar( "message" ), "htmltags" ) ) ;
		$sub_deptid = Util_Format_Sanatize( Util_Format_GetVar( "sub_deptid" ), "n" ) ;

		$caninfo = Canned_get_CanInfo( $dbh, $canid ) ;
		if ( isset( $caninfo["opID"] ) )
			$opid = $caninfo["opID"] ;
		else
			$opid = 1111111111 ;

		if ( !$canid = Canned_put_Canned( $dbh, $canid, $opid, $deptid, $title, $message ) )
			$error = "Error processing canned message." ;
		$deptid = $sub_deptid ;
	}
	else if ( $action === "delete" )
	{
		include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/get.php" ) ;
		include_once( "$CONF[DOCUMENT_ROOT]/API/Canned/remove.php" ) ;

		$canid = Util_Format_Sanatize( Util_Format_GetVar( "canid" ), "n" ) ;

		$caninfo = Canned_get_CanInfo( $dbh, $canid ) ;
		Canned_remove_Canned( $dbh, $caninfo["opID"], $canid ) ;
		$canid = 0 ;
	}

	$deptinfo = Depts_get_DeptInfo( $dbh, $deptid ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/".Util_Format_Sanatize($deptinfo["lang"], "ln").".php" ) ;
	$deptname = $deptinfo["name"] ;

	// make hash for quick refrence
	$operators_hash = Array() ;
	$operators_hash[1111111111] = "<img src=\"../pics/icons/lock.png\" width=\"16\" height=\"16\" border=\"0\" title=\"created by Setup Admin\" title=\"created by Setup Admin\">" ;
	for ( $c = 0; $c < count( $operators ); ++$c )
	{
		$operator = $operators[$c] ;
		$operators_hash[$operator["opID"]] = $operator["name"] ;
	}

	// make hash for quick refrence
	$dept_hash = Array() ;
	$dept_hash[1111111111] = "All Departments" ;
	for ( $c = 0; $c < count( $departments ); ++$c )
	{
		$department = $departments[$c] ;
		$dept_hash[$department["deptID"]] = $department["name"] ;
	}

	$cans = Canned_get_DeptCanned( $dbh, $deptid, $page, 100 ) ;
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> PHP Live! Support </title>

<meta name="description" content="PHP Live! Support <?php echo $VERSION ?>">
<meta name="keywords" content="powered by: PHP Live!  www.phplivesupport.com">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=<?php echo $LANG["CHARSET"] ?>">
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../css/setup.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/setup.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	var winname = unixtime() ;
	var option = <?php echo $option ?> ; // used to communicate with depts.php to toggle iframe

	$(document).ready(function()
	{
		$.ajaxSetup({ cache: false }) ;
		$("body").css({'background-color': '#FFFFFF'}) ;

		<?php if ( ( $action === "update" ) && !$error ): ?>
		parent.do_alert( 1, "Success" ) ;
		<?php elseif ( $error ): ?>
		parent.do_alert( 0, "<?php echo $error ?>" ) ;
		<?php endif ; ?>

		if ( <?php echo $canid ?> )
		{
			var div_pos = $('#tr_div_'+<?php echo $canid ?>).position() ;
			var div_height = $('#tr_div_'+<?php echo $canid ?>).height() ;
			var scroll_to = div_pos.top + div_height - 200 ;

			$('html, body').animate({
				scrollTop: scroll_to
			}, 200) ;
			$('#tr_div_'+<?php echo $canid ?>).fadeOut("fast").fadeIn("fast").fadeOut("fast").fadeIn("fast").fadeOut("fast").fadeIn("fast") ;
		}
	});

	function do_submit()
	{
		var canid = $('#canid').val() ;
		var title = $('#title').val() ;
		var deptid = $('#deptid').val() ;
		var message = $('#message').val() ;
		var emailt = $('#emailt').val() ;

		if ( title == "" )
			parent.do_alert( 0, "Please provide a Reference title." ) ;
		else if ( message == "" )
			parent.do_alert( 0, "Please provide a Message." ) ;
		else
			$('#theform').submit() ;
	}

	function do_delete( thecanid )
	{
		var unique = unixtime() ;

		if ( confirm( "Really delete this canned response?" ) )
			location.href = "iframe_edit_3.php?action=delete&sub=canned&deptid=<?php echo $deptid ?>&canid="+thecanid+"&bgcolor=<?php echo $bgcolor ?>&"+unique ;
	}

	function toggle_new( theflag )
	{
		// theflag = 1 means force show, not toggle
		if ( $('#canned_box_new').is(':visible') && !theflag )
		{
			$( "input#canid" ).val( "0" ) ;
			$( "input#title" ).val( "" ) ;
			$( "#deptid" ).val( <?php echo $deptid ?> ) ;
			$( "#message" ).val( "" ) ;

			$('body').css({ 'overflow': 'auto' }) ;
			$('#canned_box_new').hide() ;
		}
		else
		{
			$('body').css({ 'overflow': 'hidden' }) ;
			$('#canned_box_new').show() ;
		}

		$('#title').focus() ;
	}

	function do_edit( thecanid, thetitle, thedeptid, themessage )
	{
		$( "input#canid" ).val( thecanid ) ;
		$( "input#title" ).val( thetitle.replace( /&-#39;/g, "'" ) ) ;
		$( "#deptid" ).val( thedeptid ) ;
		$( "#message" ).val( themessage.replace(/<br>/g, "\r\n").replace( /&-#39;/g, "'" ) ) ;
		
		toggle_new(0) ;
	}
//-->
</script>
</head>
<body style="">

<div id="iframe_body" style="height: 390px; <?php echo ( $bgcolor ) ? "background: #$bgcolor;" : "" ?>">
	<div id="canned_list" style="overflow: auto;">
		<div>Canned responses created here will be available to all operators assigned to this department.</div>
		<div id="div_new_canned_<?php echo $deptid ?>" class="info_box" style="margin-top: 15px; width: 80px; padding-left: 25px; background: url( ../pics/icons/add.png ) no-repeat #FAFAA6; background-position: 5px 5px; border-bottom: 0px solid; cursor: pointer; border-bottom-left-radius: 0px; -moz-border-radius-bottomleft: 0px; border-bottom-right-radius: 0px; -moz-border-radius-bottomright: 0px;" onClick="parent.new_canned( <?php echo $deptid ?> )">new canned</div>

		<table cellspacing=0 cellpadding=0 border=0 width="100%">
		<tr>
			<td width="55" nowrap><div class="td_dept_header">&nbsp;</div></td>
			<td width="120" nowrap><div class="td_dept_header">Title</div></td>
			<td width="80" nowrap><div class="td_dept_header">Creator</div></td>
			<td width="180"><div class="td_dept_header">Department</div></td>
			<td><div class="td_dept_header">Message</div></td>
		</tr>
		<?php
			for ( $c = 0; $c < count( $cans )-1; ++$c )
			{
				$can = $cans[$c] ;
				$title = preg_replace( "/\"/", "&quot;", preg_replace( "/'/", "&-#39;", $can["title"] ) ) ;
				$title_display = preg_replace( "/\"/", "&quot;", $can["title"] ) ;

				$op_name = $operators_hash[$can["opID"]] ;
				$dept_name = $dept_hash[$can["deptID"]] ;
				$message = preg_replace( "/\"/", "&quot;", preg_replace( "/'/", "&-#39;", preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", $can["message"] ) ) ) ;
				$message_display = preg_replace( "/\"/", "&quot;", preg_replace( "/(\r\n)|(\n)|(\r)/", "<br>", Util_Format_ConvertTags( $can["message"] ) ) ) ;

				$td1 = "td_dept_td" ;

				print "
					<tr id=\"tr_div_$can[canID]\">
						<td class=\"$td1\" width=\"55\">
							<div onClick=\"do_edit($can[canID], '$title', '$can[deptID]', '$message')\" style=\"cursor: pointer;\"><img src=\"../pics/btn_edit.png\" width=\"55\" height=\"20\" border=\"0\" alt=\"\"></div>
							<div onClick=\"do_delete($can[canID])\" style=\"margin-top: 5px; cursor: pointer;\"><img src=\"../pics/btn_delete.png\" width=\"55\" height=\"20\" border=\"0\" alt=\"\"></div>
						</td>
						<td class=\"$td1\"><b>$title_display</b></td>
						<td class=\"$td1\">$op_name</td>
						<td class=\"$td1\">$dept_name</td><td class=\"$td1\">$message_display</td>
					</tr>" ;
			}
			if ( $c == 0 )
				print "<tr><td colspan=7 class=\"td_dept_td\">Blank results.</td></tr>" ;
		?>
		</table>
		<div class="chat_info_end"></div>
	</div>

	<div id="canned_box_new" style="display: none; position: fixed; top: 0px; left: 0px; background: #<?php echo $bgcolor ?>; height: 100%; padding: 5px; z-Index: 5;">
		<form method="POST" action="iframe_edit_3.php?<?php echo time() ?>" id="theform" accept-charset="<?php echo $LANG["CHARSET"] ?>">
		<table cellspacing=0 cellpadding=0 border=0 width="100%">
		<tr>
			<td width="380" style="padding: 5px;" nowrap>
				<input type="hidden" name="action" value="update">
				<input type="hidden" name="sub" value="<?php echo $action ?>">
				<input type="hidden" name="sub_deptid" value="<?php echo $deptid ?>">
				<input type="hidden" name="option" value="<?php echo $option ?>">
				<input type="hidden" name="canid" id="canid" value="0">
				<input type="hidden" name="bgcolor" value="<?php echo $bgcolor ?>">
				<div>
					Reference (example: "Welcome greeting", "Just a moment")<br>
					<input type="text" name="title" id="title" class="input" style="width: 98%; margin-bottom: 10px;" maxlength="35"><br>
					Set this canned response available to Department:<br>
					<select name="deptid" id="deptid" style="width: 99%; margin-bottom: 10px;">
					<option value="1111111111">All Departments</option>
					<?php
						for ( $c = 0; $c < count( $departments ); ++$c )
						{
							$department = $departments[$c] ;
							if ( $department["deptID"] == $deptid )
							{
								$selected = ( $department["deptID"] == $deptid ) ? "selected" : "" ;
								print "<option value=\"$department[deptID]\" $selected>$department[name]</option>" ;
							}
						}
					?>
					</select><br>
					Canned Message<br>
					<textarea name="message" id="message" class="input" rows="5" style="width: 98%; margin-bottom: 10px;" wrap="virtual"></textarea><br>

					<button type="button" onClick="do_submit()" class="btn">Submit</button> &nbsp; &nbsp; &nbsp; <a href="JavaScript:void(0)" onClick="toggle_new(0)">cancel</a>
				</div>
			</td>
			<td><img src="../pics/space.gif" width="55" height=1></td>
			<td width="100%">
				<ul>
					<li> HTML will be converted to raw code.
					<li style="margin-top: 5px;"> Dynamically populated variables:
						<ul style="margin-top: 10px;">
							<li> <b>%%visitor%%</b> = visitor's name
							<li> <b>%%operator%%</b> = your name
							<li> <b>%%op_email%%</b> = your email
						</ul>
					<li style="margin-top: 10px;"> To display an image on chat, use the <b>image:</b> prefix
						<ul style="margin-top: 10px;">
							example:
							<li style=""> <b>image:</b><i>http://www.phplivesupport.com/pics/logo_small.png</i>
						</ul>
				</ul>
			</td>
		</tr>
		</table>
		</form>
	</div>
</div>

</body>
</html>