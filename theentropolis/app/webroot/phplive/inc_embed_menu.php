	<div id="chat_embed_header" style="<?php echo ( $embed ) ? "" : "display: none;" ; ?> height: 32px; padding: 5px;">
		<div id="embed_win_minimize" style='float: left; width: 50px; height: 32px;'><img src="./themes/<?php echo $theme ?>/win_min.png" width="26" height="26" border=0 style="padding: 3px;"></div>
		<div id="embed_win_maximize" style='display: none; float: left; width: 50px; height: 32px;'><img src="./themes/<?php echo $theme ?>/win_max.png" width="26" height="26" border=0 style="padding: 3px;" id="embed_win_maximize_img"></div>
		<div id="embed_win_popout" style='<?php echo ( isset( $VALS["POPOUT"] ) && ( $VALS["POPOUT"] == "on" ) ) ? "" : "display: none; " ?>float: left; width: 50px; height: 32px;'><img src="./themes/<?php echo $theme ?>/win_pop.png" width="26" height="26" border=0 style="padding: 3px;"></div>
		<div id="embed_win_close" style='display: none; float: left; width: 32px; height: 32px;'><img src="./themes/<?php echo $theme ?>/win_close.png" width="26" height="26" border=0 style="padding: 3px;"></div>
		<div id="chat_embed_title" style='float: left; display: inline-block; margin-left: 25px; margin-top: 2px;'><span id="chat_text_title" style="padding: 0px !important;"><?php echo $LANG["TXT_LIVECHAT"] ?></span></div>
		<div style='clear: both;'></div>
	</div>