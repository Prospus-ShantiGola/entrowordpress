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

	function toggle_nativation()
	{
		if ( $('#div_menu_expand').is(':visible') )
		{
			$('#div_menu_expand').show().animate({'top': -390}, {
				duration: 300,
				complete: function() {
					$('#div_menu_expand').hide() ;
				}
			});
		}
		else
		{
			$('#div_menu_expand').show().animate({'top': 0}, {
				duration: 300,
				complete: function() {
					//
				}
			});
		}
	}
//-->
</script>

<div id="div_scrolltop" style="display: none; position: fixed; top: 25%; right: 0px; z-index: 1000;">
	<div style="padding: 5px; background: #DFDFDF; border: 1px solid #B9B9B9; border-right: 0px; text-shadow: 1px 1px #FFFFFF; border-top-left-radius: 5px 5px; -moz-border-radius-topleft: 5px 5px; border-bottom-left-radius: 5px 5px; -moz-border-radius-bottomleft: 5px 5px; cursor: pointer;" onClick="scroll_top()"><img src="<?php echo $CONF["BASE_URL"] ?>/pics/icons/arrow_top.png" width="15" height="16" border="0" alt=""> top</div>
</div>

<div id="header_wrapper" style="background: #465C74;">
	<div style="border-bottom: 1px solid #2D3B4A;">
		<div style="width: 970px; margin: 0 auto; padding-top: 15px; padding-bottom: 15px;">
			<div id="menu_wrapper" style="">
				<div id="menu_home" class="menu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/'">Home</div>
				<div id="menu_depts" class="menu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/depts.php'">Departments</div>
				<div id="menu_ops" class="menu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/ops.php'">Operators</div>
				<div id="menu_interface" class="menu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/interface_themes.php'">Interface</div>
				<div id="menu_icons" class="menu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/icons.php'">Chat Icons</div>
				<div id="menu_html" class="menu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/code.php'">HTML Code</div>
				<div id="menu_rchats" class="menu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/reports_chat.php'">Reports</div>
				<div id="menu_trans" class="menu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/transcripts.php'">Transcripts</div>
				<div id="menu_rtraffic" class="menu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/reports_traffic.php'">Traffic</div>
				<div id="menu_extras" class="menu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/marketing_click.php'">Extras</div>
				<div id="menu_settings" class="menu" style="margin-right: 0px;" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/settings.php'">Settings</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</div>
</div>

<div id="div_menu_expand" style="display: none; position: absolute; top: -390px; left: 0px; width: 100%; background: #465C74; border-bottom: 1px solid #2D3B4A; color: #FFFFFF;  text-shadow: none; height: 400px; z-Index: 10;">
	<div style="width: 970px; margin: 0 auto; padding-top: 40px;">
		<table cellspacing=0 cellpadding=1 border=0>
		<tr>
			<td valign="top"><a href="<?php echo $CONF["BASE_URL"] ?>/setup/" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">Home</a></td>
			<td valign="top" style="padding-left: 15px;"><a href="<?php echo $CONF["BASE_URL"] ?>/setup/depts.php" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">Departments</a></td>
			<td valign="top" style="padding-left: 15px;" nowrap>
				<a href="<?php echo $CONF["BASE_URL"] ?>/setup/ops.php" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">Operators</a>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/ops.php?jump=assign" style="color: #FFFFFF; text-decoration: none;">Assign Operator</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/interface_op_pics.php" style="color: #FFFFFF; text-decoration: none;">Profile Picture</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/ops_reports.php" style="color: #FFFFFF; text-decoration: none;">Online Activity</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/ops.php?jump=monitor" style="color: #FFFFFF; text-decoration: none;">Status Monitor</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/ops.php?jump=online" style="color: #FFFFFF; text-decoration: none;">Go ONLINE</a></div>
			</td>
			<td valign="top" style="padding-left: 15px;" nowrap>
				<a href="<?php echo $CONF["BASE_URL"] ?>/setup/interface_themes.php" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">Interface</a>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/interface_themes.php" style="color: #FFFFFF; text-decoration: none;">Themes</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/interface.php?jump=logo" style="color: #FFFFFF; text-decoration: none;">Company Logo</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/interface.php?jump=charset" style="color: #FFFFFF; text-decoration: none;">Character Set</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/interface.php?jump=time" style="color: #FFFFFF; text-decoration: none;">Timezone</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/interface_lang.php" style="color: #FFFFFF; text-decoration: none;">Language Text</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/interface_chat_msg.php" style="color: #FFFFFF; text-decoration: none;">Chat End Msg</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/interface.php?jump=screen" style="color: #FFFFFF; text-decoration: none;">Login Screen</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/interface.php?jump=props" style="color: #FFFFFF; text-decoration: none;">Properties</a></div>
			</td>
			<td valign="top" style="padding-left: 15px;" nowrap>
				<a href="<?php echo $CONF["BASE_URL"] ?>/setup/icons.php" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">Chat Icons</a>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/icons.php?jump=iconsettings" style="color: #FFFFFF; text-decoration: none;">Mobile Behavior</a></div>
			</td>
			<td valign="top" style="padding-left: 15px;" nowrap>
				<a href="<?php echo $CONF["BASE_URL"] ?>/setup/code.php" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">HTML Code</a>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/code_settings.php" style="color: #FFFFFF; text-decoration: none;">Settings</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/code_invite.php" style="color: #FFFFFF; text-decoration: none;">Automatic Invite</a></div>
			</td>
			<td valign="top" style="padding-left: 15px;" nowrap>
				<a href="<?php echo $CONF["BASE_URL"] ?>/setup/reports_chat.php" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">Reports</a>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/reports_chat_active.php" style="color: #FFFFFF; text-decoration: none;">Active Chats</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/reports_chat_missed.php" style="color: #FFFFFF; text-decoration: none;">Missed Chats</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/reports_chat_msg.php" style="color: #FFFFFF; text-decoration: none;">Offline Msg</a></div>
			</td>
			<td valign="top" style="padding-left: 15px;" nowrap>
				<a href="<?php echo $CONF["BASE_URL"] ?>/setup/transcripts.php" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">Transcripts</a>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/transcripts_tags.php" style="color: #FFFFFF; text-decoration: none;">Tags</a></div>
			</td>
			<td valign="top" style="padding-left: 15px;" nowrap>
				<a href="<?php echo $CONF["BASE_URL"] ?>/setup/reports_traffic.php" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">Traffic</a>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/reports_traffic.php" style="color: #FFFFFF; text-decoration: none;">Footprints</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/reports_refer.php" style="color: #FFFFFF; text-decoration: none;">Refer URLs</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/reports_traffic.php?jump=settings" style="color: #FFFFFF; text-decoration: none;">Settings</a></div>
			</td>
			<td valign="top" style="padding-left: 15px;" nowrap>
				<a href="<?php echo $CONF["BASE_URL"] ?>/setup/marketing_click.php" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">Extras</a>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/extras.php?jump=apis" style="color: #FFFFFF; text-decoration: none;">Dev APIs</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/extras_geo.php" style="color: #FFFFFF; text-decoration: none;">GeoIP</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/extras_geo.php?jump=geomap" style="color: #FFFFFF; text-decoration: none;">Google Maps</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/extras.php?jump=external" style="color: #FFFFFF; text-decoration: none;">External URLs</a></div>
				<?php if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/smtp/smtp.php" ) ): ?><div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/addons/smtp/smtp.php" style="color: #FFFFFF; text-decoration: none;">SMTP</a></div><?php endif ; ?>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/emo.php" style="color: #FFFFFF; text-decoration: none;">Emoticons</a></div>
				<?php if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/helpscout/helpscout.php" ) ): ?><div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/addons/helpscout/helpscout.php" style="color: #FFFFFF; text-decoration: none;">Help Scout</a></div><?php endif ; ?>
				<?php if ( is_file( "$CONF[CONF_ROOT]/autotask_config.php" ) ): ?><div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/addons/autotask/autotask.php" style="color: #FFFFFF; text-decoration: none;">AutoTask</a></div><?php endif ; ?>
			</td>
			<td valign="top" style="padding-left: 15px;" nowrap>
				<a href="<?php echo $CONF["BASE_URL"] ?>/setup/settings.php" style="font-weight: bold; color: #FFFFFF; text-decoration: none;">Settings</a>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/settings.php" style="color: #FFFFFF; text-decoration: none;">Exclude IPs</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/settings.php?jump=sips" style="color: #FFFFFF; text-decoration: none;">Blocked IPs</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/settings.php?jump=cookie" style="color: #FFFFFF; text-decoration: none;">Cookies</a></div>
				<?php if ( $VARS_INI_UPLOAD && is_file( "$CONF[DOCUMENT_ROOT]/addons/file_attach/file_attach.php" ) ): ?><div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/settings.php?jump=upload" style="color: #FFFFFF; text-decoration: none;">File Upload</a></div><?php endif ; ?>
				<?php if ( is_file( "$CONF[DOCUMENT_ROOT]/mapp/settings.php" ) && ( $admininfo["adminID"] == 1 ) ): ?><div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/mapp/settings.php" style="color: #FFFFFF; text-decoration: none;">Mobile App</a></div><?php endif ; ?>
				<?php if ( is_file( "$CONF[DOCUMENT_ROOT]/mapp/settings.php" ) && ( $admininfo["adminID"] == 1 ) ): ?><div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/settings.php?jump=profile" style="color: #FFFFFF; text-decoration: none;">Setup Profile</a></div><?php endif ; ?>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/system.php" style="color: #FFFFFF; text-decoration: none;">System</a></div>
				<div style="margin-top: 15px;"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/db.php" style="color: #FFFFFF; text-decoration: none;">DB Stats</a></div>
			</td>
		</tr>
		<tr>
			<td colspan=3 style="padding-top: 15px;"><div style="display: inline-block; background: #FFFFFF; border: 1px solid #2D3B4A; color: #596369; padding: 5px; text-shadow: none; cursor: pointer;" class="round" onClick="toggle_nativation();">[-] minimize navigation menu</div></td>
			<td colspan=8>&nbsp;</td>
		</tr>
		</table>
	</div>
</div>

<div style="width: 100%; padding-top: 100px; background: #E4EBF3;">
	<div style="width: 970px; margin: 0 auto;">
		<table cellspacing=0 cellpadding=0 border=0 width="100%">
		<tr>
			<td width="100%"><div style="display: inline-block; cursor: pointer;" class="round" onClick="toggle_nativation();"><img src="<?php echo $CONF["BASE_URL"] ?>/pics/icons/expand_big.png" width="42" height="42" border="0" alt=""></div></td>
			<td width="160" nowrap>
				<div style="padding: 10px; text-align: center; background: #8BCF92; border: 1px solid #7FBD85; border-bottom: 0px;" class="round_top"><img src="<?php echo $CONF["BASE_URL"] ?>/pics/icons/bulb_big.png" width="24" height="24" border="0" alt="" id="img_bulb"> <a href="<?php echo $CONF["BASE_URL"] ?>/setup/ops.php?jump=online" style="color: #FFFFFF;">Go <span style="">ONLINE!</span></a></div>
			</td>
			<td align="right" style="padding-left: 15px;" nowrap>
				<div style="padding: 10px; text-align: center;" class="round_top"><img src="<?php echo $CONF["BASE_URL"] ?>/pics/icons/settings_big.png" width="24" height="24" border="0" alt="">
					Setup Admin: 
					<?php if ( $admininfo["status"] != -1 ): ?><a href="<?php echo $CONF["BASE_URL"] ?>/setup/settings.php?jump=profile"><span style="font-size: 14px;"><?php echo $admininfo["login"] ?></span></a>
					<?php else: ?>
					<span style="font-size: 14px; font-weight: bold;"><?php echo $admininfo["login"] ?></span>
					<?php endif ; ?>
					&nbsp; &bull; &nbsp; <a href="<?php echo $CONF["BASE_URL"] ?>/logout.php?action=logout&menu=sa">logout</a>
				</div>
			</td>
		</tr>
		</table>
	</div>
	<div style="width: 970px; margin: 0 auto; padding: 25px; padding-bottom: 100px; background: #FFFFFF; border: 1px solid #DBDFE0; box-shadow: 0 3px 2px -2px #D5D8D9;" class="round" id="div_body_main">
