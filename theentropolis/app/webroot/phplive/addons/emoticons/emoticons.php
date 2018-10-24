<div style="display: none; position: absolute; top: 0px; left: 0px; padding: 2px; width: 210px; box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2); z-Index: 1000;" class="info_content" id="emo_box">
	<div style="text-align: center; cursor: pointer;" class="info_error" onClick="close_misc('all')"><img src="<?php echo $CONF["BASE_URL"] ?>/themes/<?php echo $theme ?>/close_extra.png" width="16" height="16" border="0"> <?php echo ( isset( $LANG["CHAT_CLOSE"] ) ) ? $LANG["CHAT_CLOSE"] : "Close window" ; ?></div>
	<div style="margin-top: 5px;">
		<table cellspacing=0 cellpadding=0 border=0 id="table_emos" width="100%">
		<tr>
			<td width="25%" align="center"><div id="smiley_smile" onMouseOver="toggle_emo('smile', 1)" onMouseOut="toggle_emo('smile', 0)" onClick="select_emo(':)')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/smile.png" width="23" height="23" border="0"></div></td>
			<td width="25%" align="center"><div id="smiley_sad" onMouseOver="toggle_emo('sad', 1)" onMouseOut="toggle_emo('sad', 0)" onClick="select_emo(':(')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/sad.png" width="23" height="23" border="0"></div></td>
			<td width="25%" align="center"><div id="smiley_confused" onMouseOver="toggle_emo('confused', 1)" onMouseOut="toggle_emo('confused', 0)" onClick="select_emo(':\\')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/confused.png" width="23" height="23" border="0"></div></td>
			<td width="25%" align="center"><div id="smiley_cry" onMouseOver="toggle_emo('cry', 1)" onMouseOut="toggle_emo('cry', 0)" onClick="select_emo(':\'(')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/cry.png" width="23" height="23" border="0"></div></td>
		</tr>
		<tr>
			<td width="25%" align="center"><div id="smiley_embarrassed" onMouseOver="toggle_emo('embarrassed', 1)" onMouseOut="toggle_emo('embarrassed', 0)" onClick="select_emo(':\$')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/embarrassed.png" width="23" height="23" border="0"></div></td>
			<td width="25%" align="center"><div id="smiley_angry" onMouseOver="toggle_emo('angry', 1)" onMouseOut="toggle_emo('angry', 0)" onClick="select_emo('>:(')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/angry.png" width="23" height="23" border="0"></div></td>
			<td width="25%" align="center"><div id="smiley_ecstatic" onMouseOver="toggle_emo('ecstatic', 1)" onMouseOut="toggle_emo('ecstatic', 0)" onClick="select_emo(':D')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/ecstatic.png" width="23" height="23" border="0"></div></td>
			<td width="25%" align="center"><div id="smiley_heart" onMouseOver="toggle_emo('heart', 1)" onMouseOut="toggle_emo('heart', 0)" onClick="select_emo('<3')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/heart.png" width="23" height="23" border="0"></div></td>
		</tr>
		<tr>
			<td width="25%" align="center"><div id="smiley_neutral" onMouseOver="toggle_emo('neutral', 1)" onMouseOut="toggle_emo('neutral', 0)" onClick="select_emo(':|')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/neutral.png" width="23" height="23" border="0"></div></td>
			<td width="25%" align="center"><div id="smiley_thumbs_up" onMouseOver="toggle_emo('thumbs_up', 1)" onMouseOut="toggle_emo('thumbs_up', 0)" onClick="select_emo('|_')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/thumbs_up.png" width="23" height="23" border="0"></div></td>
			<td width="25%" align="center"><div id="smiley_wink" onMouseOver="toggle_emo('wink', 1)" onMouseOut="toggle_emo('wink', 0)" onClick="select_emo(';)')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/wink.png" width="23" height="23" border="0"></div></td>
			<td width="25%" align="center"><div id="smiley_omg" onMouseOver="toggle_emo('omg', 1)" onMouseOut="toggle_emo('omg', 0)" onClick="select_emo(':O')" class="info_clear" style="cursor: pointer;"><img src="<?php echo $CONF["BASE_URL"] ?>/addons/emoticons/omg.png" width="23" height="23" border="0"></div></td>
		</tr>
		</table>
	</div>
</div>

<script data-cfasync="false" type="text/javascript">
<!--
	function toggle_emo_box( theforce_close )
	{
		if ( $('#emo_box').is(':visible') || theforce_close )
		{
			$('#emo_box').fadeOut("fast") ;
		}
		else
		{
			position_emo() ;
			if ( !isop || mapp )
			{
				$('#emo_box').center().fadeIn("fast") ;
			}
			else
				$('#emo_box').fadeIn("fast") ;
		}
	}

	function toggle_emo( theemo, theflag )
	{
		if ( theflag )
		{
			$('#smiley_'+theemo).removeClass("info_clear") ;
			$('#smiley_'+theemo).addClass("info_content") ;
			$('#smiley_'+theemo).css({ 'opacity': '1' }) ;
		}
		else
		{
			$('#smiley_'+theemo).removeClass("info_content") ;
			$('#smiley_'+theemo).addClass("info_clear") ;
			$('#smiley_'+theemo).css({ 'opacity': '0.5' }) ;
		}
	}

	function position_emo()
	{
		var emo_pos = $("#chat_emoticons").position() ;
		var height_emo_box = parseInt( $('#emo_box').outerHeight() ) ;
		var emo_top = emo_pos.top - height_emo_box - 10 ;
		var emo_left = emo_pos.left ;
		if ( !isop || mapp )
		{
			// center position
		}
		else
			$("#emo_box").css({'top': emo_top, 'left': emo_left}) ;
	}

	function select_emo( theemo )
	{
		var temp = $('#input_text').val() ;

		if ( chats[ces]["disconnected"] )
			do_alert( 0, "<?php echo $LANG["CHAT_NOTIFY_DISCONNECT"] ?>" ) ;
		else
		{
			$('#input_text').val( temp+theemo ) ;
			toggle_input_btn_enable( false ) ;
		}
		$('#emo_box').hide() ;
	}

	function reset_emo_opacity()
	{
		$("#emo_box").find('*').each( function(){
			var div_name = this.id ;
			if ( div_name.indexOf("smiley_") != -1 )
				$(this).css({ 'opacity': '0.5' }) ;
		} );
	}

	reset_emo_opacity() ;
//-->
</script>
