		<script data-cfasync="false" type="text/javascript">
		<!--
		function show_div( thediv )
		{
			var divs = Array( "marketing", "external", "apis", "smtp", "emoticons", "helpscout", "autotask", "slack" ) ;
			for ( var c = 0; c < divs.length; ++c )
			{
				$('#extras_'+divs[c]).hide() ;
				$('#menu_'+divs[c]).removeClass('op_submenu_focus').addClass('op_submenu') ;
			}

			$('input#jump').val( thediv ) ;
			$('#extras_'+thediv).show() ;
			$('#menu_'+thediv).removeClass('op_submenu').addClass('op_submenu_focus') ;
		}
		//-->
		</script>
		<?php $addon_smtp = ( is_file( "$CONF[DOCUMENT_ROOT]/addons/smtp/smtp.php" ) ) ? 1 : 0 ; ?>
		<?php $addon_helpscout = ( is_file( "$CONF[DOCUMENT_ROOT]/addons/helpscout/helpscout.php" ) ) ? 1 : 0 ; ?>
		<?php $addon_autotask = ( is_file( "$CONF[CONF_ROOT]/autotask_config.php" ) ) ? 1 : 0 ; ?>
		<?php $addon_slack = ( is_file( "$CONF[DOCUMENT_ROOT]/addons/slack/slack.php" ) ) ? 1 : 0 ; ?>
		<div class="op_submenu_wrapper">
			<div class="op_submenu" style="margin-left: 0px;" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/marketing_click.php'" id="menu_marketing">Marketing</div>
			<div class="op_submenu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/extras.php?jump=apis'" id="menu_apis">Dev APIs</div>
			<div class="op_submenu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/extras_geo.php'" id="menu_geoip">GeoIP</div>
			<div class="op_submenu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/extras_geo.php?jump=geomap'" id="menu_geomap">Google Maps</div>
			<div class="op_submenu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/setup/extras.php?jump=external'" id="menu_external">External URLs</div>
			<?php if ( $addon_smtp ): ?><div class="op_submenu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/addons/smtp/smtp.php'" id="menu_smtp">SMTP</div><?php endif ; ?>
			<div class="op_submenu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/emo.php'" id="menu_emoticons">Emoticons</div>
			<?php if ( $addon_helpscout ): ?><div class="op_submenu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/addons/helpscout/helpscout.php'" id="menu_helpscout">Help Scout</div><?php endif ; ?>
			<?php if ( $addon_autotask ): ?><div class="op_submenu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/addons/autotask/autotask.php'" id="menu_autotask">AutoTask</div><?php endif ; ?>
			<?php if ( $addon_slack ): ?><div class="op_submenu" onClick="location.href='<?php echo $CONF["BASE_URL"] ?>/addons/slack/slack.php'" id="menu_slack">Slack</div><?php endif ; ?>
			<div style="clear: both"></div>
		</div>