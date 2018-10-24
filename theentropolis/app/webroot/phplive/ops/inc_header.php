<body style="">

<script data-cfasync="false" type="text/javascript">
<!--
	$(init_inview) ;
	$(window).scroll( init_inview ) ;

	function check_inview( theobject )
	{
		var scroll_top = $(window).scrollTop() ;
		var scroll_view = scroll_top + $(window).height() ;

		var pos_top = $(theobject).offset().top ;
		var pos_bottom = pos_top + $(theobject).height() ;

		return ((pos_bottom <= scroll_view) && (pos_top >= scroll_top) ) ;
	}

	function init_inview() {
		if ( check_inview( $('#menu_wrapper') ) )
			$('#div_scrolltop').fadeOut("fast") ;
		else
			$('#div_scrolltop').fadeIn("fast") ;
	}

	function scroll_top()
	{
		$('html, body').animate({
			scrollTop: 0
		}, 200);
	}

//-->
</script>

<div id="div_scrolltop" style="display: none; position: fixed; top: 25%; right: 0px; z-index: 1000;">
	<div style="padding: 5px; background: #DFDFDF; border: 1px solid #B9B9B9; border-right: 0px; text-shadow: 1px 1px #FFFFFF; border-top-left-radius: 5px 5px; -moz-border-radius-topleft: 5px 5px; border-bottom-left-radius: 5px 5px; -moz-border-radius-bottomleft: 5px 5px; cursor: pointer;" onClick="scroll_top()"><img src="../pics/icons/arrow_top.png" width="15" height="16" border="0" alt=""> top</div>
</div>

<div id="header_wrapper" style="background: #465C74;">
	<div style="">
		<div style="width: 970px; margin: 0 auto;">
			<div id="menu_wrapper" style="padding-top: 15px; padding-bottom: 15px;">
				<?php if ( !$console ): ?><div id="menu_go" class="menu" onClick="<?php echo ( preg_match( "/(cans)|(notifications)|(transcript)|(activity)|(report)|(settings)/", $menu ) ) ? "location.href='./index.php?console=$console&auto=$auto'" : "toggle_menu_op('go')" ; ?>">Go ONLINE!</div><?php endif ; ?>
				<div id="menu_themes" class="menu" onClick="<?php echo ( preg_match( "/(cans)|(notifications)|(transcript)|(activity)|(report)|(settings)/", $menu ) ) ? "location.href='./index.php?menu=themes&console=$console&auto=$auto'" : "toggle_menu_op('themes')" ; ?>">Themes</div>
				<div id="menu_notifications" class="menu" onClick="location.href='./notifications.php?console=<?php echo $console ?>&auto=<?php echo $auto ?>'">Notifications</div>
				<?php if ( !$console ): ?>
				<div id="menu_cans" class="menu" onClick="location.href='./cans.php?console=<?php echo $console ?>&auto=<?php echo $auto ?>'">Canned Responses</div>
				<?php endif ; ?>
				<div id="menu_reports" class="menu" onClick="location.href='./reports.php?console=<?php echo $console ?>&auto=<?php echo $auto ?>'">Reports</div>
				<?php if ( !$console ): ?>
				<div id="menu_trans" class="menu" onClick="location.href='transcripts.php?console=<?php echo $console ?>&auto=<?php echo $auto ?>'">Transcripts</div>
				<?php endif ; ?>
				<div id="menu_activity" class="menu" onClick="location.href='./activity.php?console=<?php echo $console ?>&auto=<?php echo $auto ?>'">Online Activity</div>
				<div id="menu_settings" class="menu" onClick="location.href='./settings.php?console=<?php echo $console ?>&auto=<?php echo $auto ?>'">Settings</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</div>
</div>

<div style="width: 100%; padding-top: 100px; background: #E4EBF3;" id="div_body_container">
	<div style="width: 970px; margin: 0 auto; text-align: right;">
		<table cellspacing=0 cellpadding=0 border=0 width="100%">
		<tr>
			<td width="100%">&nbsp;</td>
			<?php if ( !$console ): ?>
			<td width="160" nowrap>
				<div style="padding: 10px; text-align: center; background: #8BCF92; border: 1px solid #7FBD85; border-bottom: 0px;" class="round_top"><img src="<?php echo $CONF["BASE_URL"] ?>/pics/icons/bulb_big.png" width="24" height="24" border="0" alt="" id="img_bulb"> <a href="index.php?jump=online" style="color: #FFFFFF;">Go <span style="">ONLINE!</span></a></div>
			</td>
			<?php endif ; ?>
			<td align="right" style="padding-left: 15px;" nowrap>
				<div style="padding: 10px; text-align: center;" class="round_top"><img src="../pics/icons/user_big.png" width="24" height="24" border="0" alt=""> Chat Operator: <span style="font-size: 14px;"><a href="./settings.php?console=<?php echo $console ?>&auto=<?php echo $auto ?>"><?php echo $opinfo["login"] ?></a></span> <?php if ( !$console ): ?>&nbsp; &bull; &nbsp; <a href="JavaScript:void(0)" onClick="logout_op()">logout</a><?php endif ; ?></div>
			</td>
		</tr>
		</table>
	</div>
	<div style="width: 970px; margin: 0 auto; padding: 25px; padding-bottom: 100px; background: #FFFFFF; border: 1px solid #DBDFE0; box-shadow: 0 3px 2px -2px #D5D8D9;" class="round">
