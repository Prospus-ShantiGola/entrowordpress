var chat_http_error ; var st_http ; var process_throttle ;
function add_text( theces, thetext )
{
	if ( ( thetext != "" ) && ( typeof( chats[theces] ) != "undefined" ) )
	{
		thetext = init_timestamps( thetext.nl2br() ) ;
		chats[theces]["trans"] += thetext ;

		if ( theces == ces )
		{
			$('#chat_body').append( thetext.emos() ) ; if ( isop && mapp ) { init_external_url() ; }

			// on IE 8 (standard view) it's not remembering the srollTop... when any div takes focus away
			// scrolling goes back to ZERO... effects are minimal

			if ( thetext.match( /img src/i ) ) { setTimeout( function(){ init_scrolling() ; }, 600 ) ; }
			else { init_scrolling() ; }
		}
	}
}

function add_text_prepare( theflag, thestring )
{
	var thetext = ( typeof( thestring ) != "undefined" ) ? thestring : $( "textarea#input_text" ).val() ;
	thetext = thetext.replace( /▒~@▒/g, "" ) ;

	if ( ( ( typeof( chats[ces] ) == "undefined" ) || ( chats[ces]["status"] !== 1 )  || chats[ces]["disconnected"] ) && ( !thetext.match( /^\// ) || thetext.match( /^\/nolink / ) || !shortcut_enabled ) )
	{ if ( isop ) { do_alert( 0, "A chat session must be active." ) ; } return false ; }
	var process_start = get_microtime() ;
	if ( typeof( process_throttle ) == "undefined" ) { process_throttle = process_start ; }
	else
	{
		var process_diff = process_start - process_throttle ;
		process_throttle = process_start ;

		// throttle check don't send but keep it in textarea
		if ( process_diff <= 500 )
			return true ;
	}

	if ( isop )
		thetext = thetext.trimreturn().noreturns().tags().vars().vars_global() ;
	else
		thetext = thetext.trimreturn().noreturns().tags().vars_global() ;

	if ( isop && shortcut_enabled ) {
		if ( thetext.match( /^\// ) && !thetext.match( /^\/nolink / ) ) { process_shortcuts( thetext ) ; return true ; }
	}
	thetext = autolink_it( thetext ) ;

	if ( ( thetext != "" ) && ( typeof( chats[ces] ) != "undefined" ) )
	{
		var cdiv ;
		var now = unixtime() ;

		if ( isop )
		{
			if ( chats[ces]["op2op"] )
			{
				if ( parseInt( chats[ces]["op2op"] ) == parseInt( isop ) )
					cdiv = "co" ;
				else
					cdiv = "cv" ;
			}
			else
				cdiv = "co" ;
		}
		else
		{
			cdiv = "cv" ;
			if ( chats[ces]["processed"] <= ( unixtime() - 25 ) )
			{
				document.getElementById('iframe_chat_engine').contentWindow.chatting() ;
			}
		}

		thetext = "<div class='"+cdiv+"'><span class='notranslate'><b>"+cname+"<timestamp_"+now+"_"+cdiv+">:</b></span> "+thetext+"</div>" ;

		idle_reset( ces ) ; $('#idle_timer_notice').hide() ;
		if ( theflag ) { add_text( ces, thetext ) ; }

		if ( addon_ws )
		{
			var ws_text = "{ \"a\": \"chwr\", \"c\": \""+ces+"\", \"o\": \""+isop+"\", \"o_\": \""+isop_+"\", \"o__\": \""+isop__+"\", \"tx\": \""+thetext+"\" }" ;
			ws_init_message_send( ws_text ) ;
		}
		else
		{
			if ( typeof( st_http ) != "undefined" ) { clearTimeout( st_http ) ; st_http = undeefined ; }
			st_http = setTimeout( function(){ $('#chat_processing').show() ; }, 5000 ) ;
			http_text( thetext ) ;
		}
	}

	toggle_input_btn_enable( true ) ;
	if ( typeof( thestring ) == "undefined" ) { $('textarea#input_text').val( "" ) ; }

	if ( !mapp && !mobile ) { $('textarea#input_text').focus() ; }
}

function toggle_input_btn_enable( thevalue )
{
	return true ;
}

function http_text( thetext )
{
	var json_data = new Object ;
	var unique = unixtime() ;

	var thesalt = ( typeof( salt ) != "undefined" ) ? salt : "nosalt" ;

	if ( typeof( chats[ces] ) != "undefined" )
	{
		$.ajax({
		type: "POST",
		url: base_url+"/ajax/chat_submit.php",
		data: "requestid="+chats[ces]["requestid"]+"&t_vses="+chats[ces]["t_ses"]+"&isop="+isop+"&isop_="+isop_+"&isop__="+isop__+"&op2op="+chats[ces]["op2op"]+"&opc="+opc+"&ces="+ces+"&text="+encodeURIComponent( thetext )+"&salt="+thesalt+"&unique="+unique+"&",
		success: function(data){
			try {
				if ( chat_http_error ) { do_alert( 1, "Reconnect success!" ) ; chat_http_error = 0 ; }
				eval(data) ;
			} catch(err) {
				do_alert( 0, "Disconnected. Reconnecting..." ) ; chat_http_error = 1 ;
				setTimeout( function(){ http_text( thetext ) ; }, 6000 ) ;
				return false ;
			}
			if ( json_data.status ) {
				if ( typeof( st_http ) != "undefined" ) { clearTimeout( st_http ) ; st_http = undeefined ; }
				$('#chat_processing').hide() ;
				clearTimeout( st_typing ) ; st_typing = undeefined ;
			}
			else { do_alert( 0, "Error sending message.  Please refresh the page and try again." ) ; }
		},
		error:function (xhr, ajaxOptions, thrownError){
			// keep trying and don't track timeout so it processes all dropped requests
			setTimeout( function(){ http_text( thetext ) ; }, 6000 ) ;
		} });
	}
}

function get_microtime()
{
	return new Date().getTime() ;
}

function input_text_listen( e )
{
	var key = e.keyCode ;
	var shift = e.shiftKey ;

	if ( !shift && ( ( key == 13 ) || ( key == 10 ) ) )
	{
		add_text_prepare(1) ;
	}
	else if ( ( key == 8 ) || ( key == 46 ) )
	{
		if ( $( "textarea#input_text" ).val() == "" )
			toggle_input_btn_enable( true ) ;
	}
	else if ( $( "textarea#input_text" ).val() == "" )
		toggle_input_btn_enable( true ) ;
	else
		toggle_input_btn_enable( false ) ;
}

function input_text_typing( e )
{
	input_focus() ;
	if ( isop && shortcut_enabled )
	{
		var thetext = $( "textarea#input_text" ).val() ;
		if ( thetext.match( /^\// ) ) { return true ; }
	}

	if ( $( "textarea#input_text" ).val() )
	{
		if ( typeof( st_typing ) == "undefined" )
		{
			send_istyping() ;
			st_typing = setTimeout( function(){ clear_istyping() ; }, 5000 ) ;
		}
	}
}

function init_typing()
{
	si_typing = setInterval(function(){
		if ( typeof( chats[ces] ) != "undefined" )
		{
			if ( chats[ces]["istyping"] )
			{
				$('#chat_vistyping_wrapper').show() ;
				$('#chat_vistyping').fadeIn("fast").animate({
				'padding-left': 15
				}, 500, function() {
					$('#chat_vistyping').animate({
					'padding-left': 0
					}, 500, function() {
						//
					});
				});
			}
			else
			{
				$('#chat_vistyping_wrapper').hide() ;
				$('#chat_vistyping').fadeOut("fast") ;
			}
		}
	}, 1000) ;
}

function init_idle( theces )
{
	// if op2op chat skip idle (status 2 is transfer chat and op2op value is temp storage of original opID)
	if ( parseInt( chats[theces]["op2op"] ) && ( parseInt( chats[theces]["status"] ) != 2 ) ) { return true ; }
	if ( ( typeof( chats[theces] ) != "undefined" ) && ( typeof( chats[theces]["idle_counter"] ) != "undefined" ) && ( typeof( chats[theces]["idle_si"] ) == "undefined" ) && parseInt( chats[theces]["idle"] ) )
	{
		chats[theces]["idle_si"] = setInterval(function(){
			if ( typeof( chats[theces] ) != "undefined" )
			{
				if ( parseInt( chats[theces]["idle_counter_pause"] ) ) { idle_reset( theces ) ; }
				if ( parseInt( chats[theces]["idle_counter"] ) != -1 ) { ++chats[theces]["idle_counter"] ; }
				idle_check( theces, parseInt( chats[theces]["idle"] ) - 60 ) ;
			}
		}, 1000) ;
	}
}

function idle_check( theces, thecounter )
{
	return true ; // feature deprecated
	if ( ( typeof( chats[theces] ) != "undefined" ) && chats[theces]["idle"] )
	{
		if ( parseInt( chats[theces]["idle_counter"] ) == parseInt( thecounter ) )
		{
			idle_alert( theces, 0 ) ;
		}
		else if ( parseInt( chats[theces]["idle_counter"] ) >= parseInt( chats[theces]["idle"] ) )
		{
			idle_disconnect( theces ) ;
		}
	}
}

function idle_alert( theces, theskip )
{
	return true ; // feature deprecated
	if ( ( typeof( chats[theces] ) != "undefined" ) )
	{
		if ( !theskip )
		{
			if ( !chats[theces]["idle_alert"] )
			{
				chats[theces]["idle_alert"] = setInterval(function(){
					if ( ces == theces )
					{
						var idle_countdown = parseInt( chats[ces]["idle"] ) - parseInt( chats[ces]["idle_counter"] ) ;
						if ( ( idle_countdown > 0 ) && ( parseInt( chats[ces]["idle_counter"] ) != -1 ) ) { $('#idle_countdown').html( idle_countdown ) ; }
						else { $('#idle_countdown').html( "0" ) ; }
					}
				}, 1000) ;
			}

			if ( ces != theces ) { menu_blink( "green", theces ) ; }
			else { $('#idle_timer_notice').show() ; }

			if ( chats[theces]["status"] )
			{
				if ( chat_sound ) { play_sound( 0, "new_text", "new_text_"+sound_new_text ) ; }
				if ( !isop )
				{
					if ( embed && win_minimized ) { flash_console(0) ; }
					else if ( console_blink_r ) { flash_console(0) ; }
				}
				title_blink_init() ;
			}
		}
		else
		{
			if ( parseInt( chats[theces]["idle_alert"] ) && ( parseInt( chats[theces]["idle_counter"] ) != -1 ) ) { $('#idle_timer_notice').show() ; }
			else { $('#idle_timer_notice').hide() ; }
		}
	}
}

function idle_reset( theces )
{
	if ( chats[theces]["idle_alert"] ) { clearInterval( chats[theces]["idle_alert"] ) ; }
	chats[theces]["idle_alert"] = 0 ;
	chats[theces]["idle_counter"] = 0 ;
}

function idle_disconnect( theces )
{
	chats[theces]["idle_counter"] = -1 ; // flag to indicate idle disconnect processed
	if ( typeof( chats[theces]["idle_si"] ) != "undefined" ) { clearInterval( chats[theces]["idle_si"] ) ; chats[theces]["idle_si"] = undeefined ; }
	if ( typeof( chats[theces]["timer_si"] ) != "undefined" ) { clearInterval( chats[theces]["timer_si"] ) ; chats[theces]["timer_si"] = undeefined ; }
	if ( isop )
	{
		add_text( theces, "<div class=\"cn\">Operator chat is idle.  Session automatically disconnected.</div>" ) ;
		disconnect( 0, theces) ;
	} else { disconnect( 1, theces) ; }
}

function send_istyping()
{
	var json_data = new Object ;
	var unique = unixtime() ;

	if ( typeof( chats[ces] ) != "undefined" )
	{
		if ( addon_ws )
		{
			var ws_text = "{ \"a\": \"ty\", \"o\": \""+isop+"\", \"c\": \""+ces+"\", \"ty\": 1 }" ;
			ws_init_message_send( ws_text ) ;
		}
		else
		{
			$.ajax({
			type: "GET",
			url: base_url+"/ajax/chat_actions_istyping.php",
			data: "a=t&isop="+isop+"&isop_="+isop_+"&c="+ces+"&f=1&"+unique+"&",
			success: function(data){
				try {
					eval(data) ;
				} catch(err) {
					do_alert( 0, err ) ;
					return false ;
				}

				if ( json_data.status ) {
					return true ;
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				// suppress error to limit confusion... if error here, there will be error reporting in more crucial areas
			} });
		}
	}
}

function clear_istyping()
{
	var json_data = new Object ;
	var unique = unixtime() ;

	if ( typeof( chats[ces] ) != "undefined" )
	{
		if ( addon_ws )
		{
			var ws_text = "{ \"a\": \"ty\", \"c\": \""+ces+"\", \"ty\": 0 }" ;
			ws_init_message_send( ws_text ) ;
			st_typing = undeefined ;
		}
		else
		{
			$.ajax({
			type: "GET",
			url: base_url+"/ajax/chat_actions_istyping.php",
			data: "a=t&isop="+isop+"&isop_="+isop_+"&c="+ces+"&f=0&"+unique+"&",
			success: function(data){
				try {
					eval(data) ;
				} catch(err) {
					do_alert( 0, err ) ;
					return false ;
				}

				if ( json_data.status ) {
					clearTimeout( st_typing ) ;
					st_typing = undeefined ;
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				// suppress error to limit confusion... if error here, there will be error reporting in more crucial areas
			} });
		}
	}
}

function init_scrolling()
{
	if ( ( typeof( chats ) != "undefined" ) && ( typeof( chats[ces] ) != "undefined" ) && ( parseInt( chats[ces]["status"] ) != 2 ) )
	{
		// slight delay for chat end custom message content
		if ( chats[ces]["disconnected"] )
			setTimeout( function(){ $('#chat_body').prop( "scrollTop", $('#chat_body').prop( "scrollHeight" ) ) ; }, 500 ) ;
		else
			$('#chat_body').prop( "scrollTop", $('#chat_body').prop( "scrollHeight" ) ) ;
	}
}

function init_textarea()
{
	return true ;
}

function init_divs( theresize )
{
	phplive_init_orientation_set() ;
	if ( theresize > 1 ) { mapp = theresize ; theresize = 0 ; } // mapp intercept, mapp=1 emulate

	var chat_footer_height = ( $('#chat_footer').height() ) ? $('#chat_footer').height() : 0 ;

	var chat_body_padding = $('#chat_body').css('padding-left') ;
	var chat_body_padding_diff = ( typeof( chat_body_padding ) != "undefined" ) ? 20 - ( chat_body_padding.replace( /px/, "" ) * 2 ) : 0 ;

	var browser_height = ( mapp && mobile && ( mapp != 1 ) ) ? mapp : $(window).height() ;
	var browser_width = ( mapp && mobile && ( mapp != 1 ) ) ? screen.width : $(window).width() ;

	var body_height = browser_height ;
	var body_width = ( ( typeof( isop ) != "undefined" ) && parseInt( isop ) ) ? browser_width - 450 : browser_width - 42 ;

	if ( embed )
	{
		var top_disconnect = $('#chat_embed_header').height() ;

		$('#chat_embed_header').show( ) ;
		body_height = body_height - $('#chat_embed_header').height() ;
		$('#info_disconnect').css({'top': top_disconnect}) ;
	}

	var chat_body_width = body_width ;
	var chat_body_height = body_height ;

	if ( ( typeof( isop ) != "undefined" ) && parseInt( isop ) )
	{
		var chat_panel_top;
		var intro_height = browser_height - 153 ;
		if ( mobile )
			chat_panel_top = intro_height + 55 ;
		else
		{
			chat_panel_top = intro_height + 30 ;
		}

		var data_top = 30 ;
		var intro_left = body_width + 40 ;
		var chat_status_offline_top = intro_height - 55 ;
		var chat_data_height = intro_height ;
		var chat_extra_wrapper_height = browser_height - 90 ;

		var chat_info_body_height = intro_height - ( $('#chat_info_header').height() + $('#chat_info_menu_list').height() ) - 24 ;
		var chat_info_network_height = chat_info_body_height - 55 ;

		var intro_top = 30 ;
		var intro_left = body_width + 40 ;
		var chat_btn_left = intro_left + 5;
		var chat_btn_top = chat_panel_top - 5 ;

		var chat_panel_left = intro_left + $('#chat_btn').outerWidth() ;
		var chat_status_offline_left = chat_panel_left ;

		var textarea_padding = ( typeof( $('#input_text').css('padding-top') ) != "undefined" ) ? parseInt( $('#input_text').css('padding-top').replace( /px/, "" ) ) : 0 ;

		if ( mapp == 1 )
		{
			chat_body_height = chat_body_height - chat_footer_height - 205 ;
		}
		else
		{ 
			chat_body_height = chat_body_height - chat_footer_height - 215 ;
		}
		chat_body_width = body_width + chat_body_padding_diff ;

		var input_text_width = body_width + 17 ;
		if ( mapp )
		{
			chat_body_height += 45 ;
			if ( mobile == 2 )
			{
				chat_body_height -= 25 ;
			}
			else
			{
				chat_body_height -= $('#chat_options').outerHeight() ;
			}

			input_text_width = browser_width - $('#chat_btn').width() - 50 ;

			$('#chat_btn').css({'bottom': '85px', 'right': '5px'}) ;
		}
		else
		{
			input_text_width -= 70 ;
			if ( theresize && ( textarea_padding > 5 ) ) { input_text_width -= input_padding+5 ; }

			$('#chat_btn').css({'top': chat_btn_top, 'left': chat_btn_left}) ;
		}

		if ( mapp && ( textarea_padding > 5 ) ) { $('#input_text').css({'padding': '5px'}) ; }
		else if ( !theresize && ( textarea_padding > 5 ) )
		{
			input_text_width = input_text_width - ( ( textarea_padding - 5 ) * 2 ) ;
			var input_text_height = parseInt( $('#input_text').css('height').replace( /px/, "" ) ) ;
			input_text_height = input_text_height - ( ( textarea_padding - 5 ) * 2 ) ;
			$('#input_text').css({'height': input_text_height}) ;
		}

		$("#chat_input").css({'bottom': "auto"}) ;
		$('#input_text').css({'width': input_text_width}) ;
		$('#chat_body').css({'height': chat_body_height, 'width': chat_body_width}) ;
		$('#chat_data').css({'top': intro_top, 'left': intro_left, 'height': chat_data_height, 'width': 410}) ;
		$('#chat_info_body').css({'max-height': chat_info_network_height}) ;
		$('#chat_info_wrapper_network').css({'height': chat_info_network_height}) ;
		$('#chat_panel').css({'bottom': 55, 'left': chat_panel_left}) ;

		if ( mapp && prev_status ) { $('#chat_status_offline').css({'bottom': 200, 'left': 15}).show() ; }
		else { $('#chat_status_offline').css({'top': chat_status_offline_top, 'left': chat_status_offline_left}) ; }

		$('#chat_extra_wrapper').css({'height': chat_extra_wrapper_height}).hide() ;

		if ( theresize )
		{
			clearTimeout( st_resize ) ;
			st_resize = setTimeout( function(){ close_extra( extra ) ; }, 800 ) ;
		}
		else { close_extra( extra ) ; }
	}
	else
	{
		chat_body_width = body_width + chat_body_padding_diff ;
		if ( typeof( view ) != "undefined" )
		{
			chat_body_height -= $('#table_info').height() ;
			chat_body_height -= 90 ; // lift it up so more stats show
		}
		else
		{
			chat_body_height = chat_body_height - $('#chat_profile_pic').height() - $('#chat_options').outerHeight() - $('#chat_input_wrapper').height() - 75 ;

			if ( chat_body_height < 50 )
			{
				chat_body_height = chat_body_height + $('#chat_profile_pic').height() ;

				$('#chat_profile_pic').hide() ;
			}
			else
			{
				$('#chat_profile_pic').show() ;
			}
		}

		if ( ( mobile && !phplive_orientation_isportrait ) && ( mobile != 3 ) )
			chat_body_height = chat_body_height + 35 ;

		if ( typeof( view ) != "undefined" )
		{
			$('#chat_body').css({'height': chat_body_height, 'width': chat_body_width}) ;
		}
		else
		{
			var input_text_width = $('#input_text').width() ;
			$('#chat_body').css({'height': chat_body_height}) ;
		}
	}
}

function update_ces( thejson_data )
{
	var thisces = thejson_data["ces"] ;
	var orig_text = thejson_data["text"] ;
	var append_text = init_timestamps( thejson_data["text"] ) ;

	if ( ( typeof( chats[thisces] ) != "undefined" ) && orig_text )
	{
		chats[thisces]["chatting"] = 1 ;
		chats[thisces]["trans"] += append_text ;

		// parse for flags before doing functions
		if ( ( append_text.indexOf("</top>") != -1 ) && !parseInt( isop ) )
		{
			var regex_trans = /<top>(.*?)</ ;
			var regex_trans_match = regex_trans.exec( append_text ) ;
			
			chats[ces]["oname"] = regex_trans_match[1] ;
			$('#chat_vname').empty().html( regex_trans_match[1] ) ;

			var regex_opid = /<!--opid:(.*?)-->/ ;
			var regex_opid_match = regex_opid.exec( append_text ) ;
			isop_ = regex_opid_match[1] ;

			var regex_mapp = /<!--mapp:(.*?)-->/ ;
			var regex_mapp_match = regex_mapp.exec( append_text ) ;
			chats[ces]["mapp"] = regex_mapp_match[1] ;

			var regex_mapp = /<!--name:(.*?)-->/ ;
			var regex_mapp_match = regex_mapp.exec( append_text ) ;
			$('#chat_profile_name').html( regex_mapp_match[1] ) ;

			var regex_mapp = /<!--department:(.*?)-->/ ;
			var regex_mapp_match = regex_mapp.exec( append_text ) ;
			$('#chat_department_name').html( regex_mapp_match[1] ) ;

			var regex_mapp = /<!--profile_pic:(.*?)-->/ ;
			var regex_mapp_match = regex_mapp.exec( append_text ) ;
			if ( regex_mapp_match[1] )
			{
				$('#td_chat_profile_pic_img').fadeOut("fast").promise( ).done(function( ) {
					$('#chat_profile_pic_img').html( "<img src='"+regex_mapp_match[1]+"' width='55' height='55' border='0' alt='' class='profile_pic_img'>" ) ;
					$('#td_chat_profile_pic_img').fadeIn("fast") ;
				}) ;
			}
			else
				$('#td_chat_profile_pic_img').fadeOut("fast") ;
		}

		if ( ( thejson_data["text"].indexOf( "<disconnected>" ) != -1 ) && !chats[thisces]["disconnected"] )
		{
			chats[thisces]["disconnected"] = unixtime() ;
			if ( thisces == ces ) { $('#idle_timer_notice').hide() ; }
			if ( typeof( chats[thisces]["idle_si"] ) != "undefined" ) { clearInterval( chats[thisces]["idle_si"] ) ; chats[thisces]["idle_si"] = undeefined ; }
			if ( isop )
			{
				var btn_close_chat = "<c615><div style='margin-top: 5px; margin-bottom: 15px;'><button onClick='cleanup_disconnect(ces)' style='padding: 10px;'>close chat</button></div></c615>" ;
				append_text += btn_close_chat ; chats[thisces]["trans"] += btn_close_chat ;
				clearInterval( chats[thisces]["timer_si"] ) ; chats[thisces]["timer_si"] = undeefined ;
			}
			else
			{
				document.getElementById('iframe_chat_engine').contentWindow.stopit(0) ;
				if ( addon_ws )
				{
					ws_connection.close() ;
				}
			}
		}
		if ( ( thejson_data["text"].indexOf( "<restart_router>" ) != -1 ) && !isop )
		{
			chats[thisces]["status"] = 2 ;
			document.getElementById('iframe_chat_engine').contentWindow.routing(0) ;
		}
		if ( ( thejson_data["text"].indexOf( "<idle_start>" ) != -1 ) && parseInt( isop ) ) { init_idle( thisces ) ; }
		if ( ( thejson_data["text"].indexOf( "<idle_pause>" ) != -1 ) && !parseInt( isop ) ) { chats[thisces]["idle_counter_pause"] = 1 ; }
		if ( ( thejson_data["text"].indexOf( "<idle_restart>" ) != -1 ) && !parseInt( isop ) ) { chats[thisces]["idle_counter_pause"] = 0 ; }

		if ( ces == thisces )
		{
			if ( !isop && addon_ws && chats[ces]["disconnect_click"] )
			{
				// skip redundant duplicate message
			}
			else
				$('#chat_body').append( append_text.emos() ) ;
			
			if ( isop && mapp ) { init_external_url() ; }

			if ( append_text.match( /img src/i ) ) { setTimeout( function(){ init_scrolling() ; }, 600 ) ; }
			else { init_scrolling() ; }

			init_textarea() ;

			$('#chat_vistyping_wrapper').hide() ; // wrapper just incase fadeIn quirk at chat_vistyping
			$('#chat_vistyping').hide() ;
			chats[ces]["istyping"] = 0 ;

			if ( document.getElementById('iframe_chat_engine').contentWindow.stopped )
			{
				$('#idle_timer_notice').hide() ;
				chat_survey() ;
			}
		}

		var flash_console_on = 0 ;
		if ( isop )
		{
			chats[thisces]["recent_res"] = unixtime() ;
			if ( ces != thisces )
			{
				menu_blink( "green", thisces ) ;
			}
			else
			{
				toggle_last_response(1) ;
			}

			var reg = RegExp( chats[thisces]["vname"]+": ", "g" ) ;
			if ( ( typeof( dn_enabled_response ) != "undefined" ) && dn_enabled_response && chats[thisces]["status"] )
			{
				dn_show( 'new_response', thisces, "Response: " + chats[thisces]["vname"], orig_text.replace( /<(.*?)>/g, '' ).replace( reg, ' ' ).replace( /\s+/g, ' ' ), 900000 ) ;
			}
		}
		if ( console_blink_r ) { flash_console_on = 1 ; }

		if ( chats[thisces]["status"] || chats[thisces]["initiated"] )
		{
			if ( chat_sound )
			{
				if ( addon_ws && chats[ces]["disconnect_click"] )
				{
					// skip sound due to instant notify
				}
				else
					play_sound( 0, "new_text", "new_text_"+sound_new_text ) ;
			}
			if ( !isop && embed )
			{
				if ( win_minimized ) { flash_console_on = 1 ; }
			}
			title_blink_init() ;
		}

		if ( flash_console_on ) { flash_console(0) ; }
	}
	if ( isop && !mapp ) { init_maxc() ; }
}

function disconnect( theclick, theces, thevclick )
{
	if ( typeof( theces ) == "undefined" ) { theces = ces ; }
	if ( typeof( thevclick ) == "undefined" ) { thevclick = 0 ; }
	vclick = thevclick ;
	
	if ( theclick )
	{
		document.getElementById('info_disconnect')._onclick = document.getElementById('info_disconnect').onclick ;
		$('#info_disconnect').prop( "onclick", null ).html('<img src="'+base_url+'/pics/loading_fb.gif" width="16" height="11" border="0" alt="">') ;
		if ( mapp ) { $('#info_disconnect_mapp').prop( "onclick", null ).html('<img src="'+base_url+'/pics/loading_fb.gif" width="16" height="11" border="0" alt="">') ; }
	}

	if ( ( theces == ces ) && isop ) { $('#idle_timer_notice').hide() ; }
	else if ( theces == ces ) { $('#chat_vistyping_wrapper').hide() ; $('#chat_vistyping').hide() ; }

	if ( ( ( typeof( theces ) != "undefined" ) && ( typeof( chats[theces] ) != "undefined" ) ) )
	{
		var json_data = new Object ;
		var unique = unixtime() ;

		// limit multiple clicks during internet lag
		if ( !chats[theces]["disconnect_click"] )
		{
			chats[theces]["disconnect_click"] = theclick ;

			$.ajax({
			type: "POST",
			url: base_url+"/ajax/chat_actions_disconnect.php",
			data: "action=disconnect&isop="+isop+"&isop_="+isop_+"&isop__="+isop__+"&ces="+theces+"&vis_token="+chats[ces]["vis_token"]+"&ip="+chats[theces]["ip"]+"&t_vses="+chats[theces]["t_ses"]+"&idle="+chats[theces]["idle_counter"]+"&vclick="+thevclick+"&ws="+addon_ws+"&unique="+unique+"&",
			success: function(data){
				try {
					eval(data) ;
				} catch(err) {
					do_alert( 0, "Error processing disconnect.  Please refresh the page and try again. [e1]" ) ;
					return false ;
				}

				if ( theclick )
				{
					document.getElementById('info_disconnect').onclick = document.getElementById('info_disconnect')._onclick ;
					if ( mapp ) { document.getElementById('info_disconnect_mapp').onclick = document.getElementById('info_disconnect')._onclick ; }
				}
				if ( json_data.status )
				{
					if ( parseInt( isop ) && ( parseInt( chats[theces]["idle_counter"] ) == -1 ) && !theclick )
					{
						// automatic process the idle disconnect but don't close the chat unless clicked disconnect
						chats[theces]["disconnect_click"] = 0 ;
						chats[theces]["disconnected"] = unixtime() ;
						if ( !$('textarea#input_text').is(':disabled') ) { $('textarea#input_text').val( "" ).attr("disabled", true) ; }
					}
					else
						cleanup_disconnect( json_data.ces ) ;

					if ( isop && !mapp ) { init_maxc() ; }
				}
				else { do_alert( 0, "Error processing disconnect.  Please refresh the page and try again. [e2]" ) ; }
			},
			statusCode: {
				500: function() {
					do_alert( 0, "Error processing disconnect.  Please refresh the page and try again. [e500]" ) ;
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				do_alert( 0, "Error processing disconnect.  Please refresh the page and try again. [e3 - "+xhr.status+"]" ) ;
			} });
		}
	}
}

function init_disconnect()
{
	$('#info_disconnect').hover(
		function () {
			$(this).removeClass('info_disconnect').addClass('info_disconnect_hover') ;
		}, 
		function () {
			$(this).removeClass('info_disconnect_hover').addClass('info_disconnect') ;
		}
	);
}

function init_timer()
{
	if ( typeof( chats[ces] ) != "undefined" )
	{
		start_timer( chats[ces]["timer"] ) ;
		if ( ( ( parseInt( chats[ces]["status"] ) == 1 ) && !parseInt( chats[ces]["disconnected"] ) ) || ( parseInt( chats[ces]["initiated"] ) && !parseInt( chats[ces]["disconnected"] ) ) )
		{
			if ( typeof( chats[ces]["timer_si"] ) != "undefined" ) { clearInterval( chats[ces]["timer_si"] ) ; chats[ces]["timer_si"] = undeefined ; }
			chats[ces]["timer_si"] = setInterval(function(){ if ( typeof( chats[ces] ) != "undefined" ) { start_timer( chats[ces]["timer"] ) ; } }, 1000) ;
		}
	}
}

function start_timer( thetimer )
{
	var diff ; var now = unixtime() ;
	if ( chats[ces]["disconnected"] )
		diff = chats[ces]["disconnected"] - thetimer ;
	else
		diff = now - thetimer ;

	var hours = Math.floor( diff/3600 ) ;
	var mins =  Math.floor( ( diff - ( hours * 3600 ) )/60 ) ;
	var secs = diff - ( hours * 3600 ) - ( mins * 60 ) ;

	var display = pad( mins, 2 )+":"+pad( secs, 2 ) ;
	if ( hours ) { display = pad( hours, 2 )+":"+display ; }

	if ( chats[ces]["status"] || chats[ces]["initiated"] )
	{
		$('#chat_vtimer').html(display) ;
		if ( !isop && !( diff % 10 ) && ( chats[ces]["processed"] <= ( now - 25 ) ) )
		{
			document.getElementById('iframe_chat_engine').contentWindow.chatting() ;
		}
	}
	else
		$('#chat_vtimer').html("00:00") ;
}

function chat_survey()
{
	if ( !isop && !chats[ces]["survey"] )
	{
		chats[ces]["survey"] = 1 ;
		close_misc("all") ;

		add_text( ces, chat_end_message+"<div style='margin-top: 15px; height: 1px;'></div>" ) ;
		if ( chats[ces]["rate"] && !win_minimized )
		{
			$('#chat_survey_wrapper').show() ;
		}
	}
	window.onbeforeunload = null ;

	if ( embed && !win_minimized ) { $('#embed_win_close').show() ; }
	$('#info_disconnect').hide() ;
}

function submit_survey( thevalue, thetexts )
{
	var json_data = new Object ;
	var unique = unixtime() ;

	if ( parseInt( thevalue ) )
	{
		$.ajax({
		type: "POST",
		url: base_url+"/ajax/chat_actions_rating.php",
		data: "action=rating&requestid="+chats[ces]["requestid"]+"&ces="+ces+"&opid="+chats[ces]["opid"]+"&deptid="+chats[ces]["deptid"]+"&rating="+thevalue+"&unique="+unique+"&",
		success: function(data){
			try {
				eval(data) ;
			} catch(err) {
				do_alert( 0, err ) ;
				return false ;
			}

			if ( json_data.status )
			{
				chats[ces]["survey"] = 2 ;
				//do_alert( 1, thetexts[0] ) ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			// suppress error to limit confusion... if error here, there will be error reporting in more crucial areas
		} });
	}
}

function do_print( theces, thedeptid, theopid, thewidth, theheight )
{
	var winname = "Print_"+theces ;
	var deptid = ( typeof( chats[theces]["deptid"] ) != "undefined" ) ? parseInt( chats[theces]["deptid"] ) : parseInt( thedeptid ) ;
	var opid = ( typeof( chats[theces]["opid"] ) != "undefined" ) ? parseInt( chats[theces]["opid"] ) : parseInt( theopid ) ;

	var url = base_url_full+"/ops/op_print.php?ces="+theces+"&deptid="+deptid+"&opid="+theopid+"&"+unixtime()+"&" ;

	if ( !wp ) { newwin_print = window.open( url, winname, "scrollbars=yes,menubar=no,resizable=1,location=no,width="+thewidth+",height="+theheight+",status=0" ) ; }
	else
	{
		if ( typeof( isop ) != "undefined" ) { wp_new_win( url, winname, thewidth, theheight ) ; }
		else { location.href = url ; }
	}
}

function init_timestamps( thetranscript )
{
	var lines = thetranscript.split( "<>" ) ;

	var transcript = "" ;
	for ( var c = 0; c < lines.length; ++c )
	{
		var line = lines[c] ;
		var matches = line.match( /timestamp_(\d+)_/ ) ;
		
		var timestamp = "" ;
		if ( matches != null )
		{
			var time = extract_time( matches[1] ) ;
			timestamp = " (<span class='ct'>"+time+"</span>) " ;
			transcript += line.replace( /<timestamp_(\d+)_((co)|(cv))>/, timestamp ) ;
		}
		else { transcript += line ; }
	}
	return transcript ;
}

function extract_time( theunixtime )
{
	var time_expanded = new Date( parseInt( theunixtime ) * 1000) ;
	var hours = time_expanded.getHours() ;
	if( hours >= 13 ) hours -= 12 ;
	var output = pad(hours,2)+":"+pad(time_expanded.getMinutes(), 2)+":"+pad(time_expanded.getSeconds(), 2) ;
	return output ;
}

function input_focus() { if ( !focused ) { focused = 1 ; } }

function play_sound( theloop, thediv, thesound )
{
	var unique = unixtime() ;
	var this_mobile = 0 ; // for now loop on mobile as well

	var div_content = $('#div_sounds_'+thediv).html() ;
	if ( mp3_support )
	{
		var audio_obj = $("#div_sounds_audio_"+thediv) ;
		if ( ( ( thediv == "new_request" ) && !div_content && audio_obj[0].paused ) || ( thediv != "new_request" ) )
		{
			$('#div_sounds_'+thediv).html( "on" ) ;
			$("#div_sounds_audio_"+thediv).attr("src", base_url+"/media/"+thesound+'.mp3') ;
			if ( theloop && !this_mobile ) { audio_obj[0].loop = true ; }
			audio_obj[0].volume = sound_volume ;
			audio_obj[0].play() ;
		}
	}
	else
	{
		if ( ( ( thediv == "new_request" ) && !div_content ) || ( thediv != "new_request" ) )
			flashembed( "div_sounds_"+thediv, base_url+'/media/'+thesound+'.swf' ) ;
	}
}

function clear_sound( thediv )
{
	if ( mp3_support )
	{
		var audio_obj = $("#div_sounds_audio_"+thediv) ;
		audio_obj[0].pause() ;
	}
	$('#div_sounds_'+thediv).html("") ;
}

function title_blink_init()
{
	if ( mapp ) { return true ; }
	if ( ( typeof( title_orig ) != "undefined" ) && !parseInt( focused ) )
	{
		if ( typeof( si_title ) != "undefined" )
			clearInterval( si_title ) ;

		if ( ( typeof( embed ) != "undefined" ) && parseInt( embed ) ) {  }
		else { si_title = setInterval(function(){ title_blink( 1, title_orig, "Alert __________________ " ) ; }, 800) ; }
	}
}

function title_blink( theflag, theorig, thenew )
{
	if ( mapp ) { return true ; }
	if( !parseInt( focused ) && ( thenew != "reset" ) )
	{
		if ( ( si_counter % 2 ) && theflag ) { document.title = thenew ; }
		else { document.title = theorig ; }

		++si_counter ;
	}
	else
	{
		if ( typeof( si_title ) != "undefined" )
		{
			clearInterval( si_title ) ; si_title = undeefined ;
			document.title = theorig ;
		}
	}
}

function print_chat_sound_image( thetheme )
{
	if ( chat_sound )
		$('#chat_sound').attr('src', base_url+'/themes/'+thetheme+'/sound_on.png') ;
	else
		$('#chat_sound').attr('src', base_url+'/themes/'+thetheme+'/sound_off.png') ;
}

function flash_console( thecounter )
{
	if ( ( typeof( mapp ) != "undefined" ) && mapp ) { return true ; }
	++thecounter ;
	if ( ( thecounter % 2 ) )
		$('#chat_canvas').addClass('chat_canvas_alert') ;
	else
		$('#chat_canvas').removeClass('chat_canvas_alert') ;

	if ( typeof( st_flash_console ) != "undefined" )
		clearTimeout( st_flash_console ) ;
	st_flash_console = setTimeout( function(){ flash_console( thecounter ) ; }, 1000 ) ;
}

function clear_flash_console()
{
	if ( ( typeof( mapp ) != "undefined" ) && mapp ) { return true ; }
	$('#chat_canvas').removeClass('chat_canvas_alert') ;
	if ( typeof( st_flash_console ) != "undefined" )
	{
		clearTimeout( st_flash_console ) ;
		st_flash_console = undeefined ;
	}
	if ( typeof( title_orig ) != "undefined" ) { title_blink( 0, title_orig, "reset" ) ; }
}

function close_misc( thediv )
{
	if ( isop )
	{
		clear_flash_console() ;
		toggle_last_response(1) ;
		//clear_sound( "new_request" ) ;
	}

	var divs = Array() ;
	if ( thediv == "all" )
	{
		divs.push( "toggle_emo_box") ;
		divs.push( "toggle_file_attach" ) ;
		divs.push( "toggle_send_trans" ) ;
		divs.push( "toggle_rating" ) ;
	}
	else if ( thediv == "emo" ) { divs.push( "toggle_emo_box" ) ; }
	else if ( thediv == "attach" ) { divs.push( "toggle_file_attach" ) ; }
	else if ( thediv == "trans" ) { divs.push( "toggle_send_trans" ) ; }
	else if ( thediv == "rating" ) { divs.push( "toggle_rating" ) ; }

	for ( var c = 0; c < divs.length; ++c )
	{
		var thisdiv = divs[c] ;
		if ( ( thisdiv == "toggle_emo_box" ) && ( typeof( toggle_emo_box ) == "function" ) ) { toggle_emo_box(1) ; }
		else if ( ( thisdiv == "toggle_file_attach" ) && ( typeof( toggle_file_attach ) == "function" ) ) { toggle_file_attach(1) ; }
		else if ( ( thisdiv == "toggle_send_trans" ) && ( typeof( toggle_send_trans ) == "function" ) ) { toggle_send_trans(1) ; }
		else if ( ( thisdiv == "toggle_rating" ) && ( typeof( toggle_rating ) == "function" ) ) { toggle_rating(1) ; }
	}
}

function textarea_listen()
{
	if ( typeof( si_textarea ) != "undefined" ) { clearInterval( si_textarea ) ; si_textarea == undeefined ; }
	si_textarea = setInterval(function(){
		var temp = $('textarea#input_text').val() ;
		temp = temp.replace( / /g, "" ) ;
		if ( temp ) { toggle_input_btn_enable( false ) ; }
		else { toggle_input_btn_enable( true ) ; }
	}, 200) ;
}

function start_win_status_listener()
{
	if ( typeof( si_win_status ) != "undefined" ) { clearInterval( si_win_status ) ; }
	si_win_status = setInterval(function( ){
		var this_win_width = $(document).width( ) ;
		if ( this_win_width < 300 )
		{
			if ( !win_minimized )
			{
				$('#embed_win_minimize').hide() ;
				$('#embed_win_popout').hide() ;
				$('#embed_win_close').hide() ;
				$('#embed_win_maximize').show() ;
				$('#info_disconnect').hide() ;
				$('#chat_input_wrapper').hide() ;

				if ( typeof( chats ) == "undefined" ) { $("#request_body").animate({ scrollTop: '3' }, "fast") ; }
				
				if ( ( typeof( chats ) != "undefined" ) && ( typeof( chats[ces] ) != "undefined" ) && !isop && chats[ces]["survey"] )
					$('#chat_survey_wrapper').hide() ;
			}
			win_minimized = 1 ;
		}
		else
		{
			if ( win_minimized || ( typeof( win_minimized ) == "undefined" ) )
			{
				$('#embed_win_maximize').hide() ;
				$('#embed_win_minimize').show() ;
				$('#chat_input_wrapper').show() ;
				if ( !mobile && popout ) { $('#embed_win_popout').show() ; } // hide on mobile for now since embed revamp

				if ( ( typeof( chats ) != "undefined" ) && !chats[ces]["disconnected"] )
					$('#info_disconnect').show() ;

				if ( ( typeof( chats ) == "undefined" ) || chats[ces]["disconnected"] )
					$('#embed_win_close').show() ;

				if ( ( typeof( chats ) != "undefined" ) && ( typeof( chats[ces] ) != "undefined" ) && !isop && chats[ces]["rate"] && chats[ces]["survey"] )
					$('#chat_survey_wrapper').show() ;

				clear_flash_console() ;
			}
			win_minimized = 0 ;
		}
	}, 100) ;
}

function start_new_response_listner()
{
	var new_response = 0 ;
	if ( typeof( si_new_response ) != "undefined" ) { clearInterval( si_new_response ) ; }
	si_new_response = setInterval(function( ){
		if ( win_minimized )
		{
			if ( ( typeof( st_flash_console ) != "undefined" ) && !new_response )
			{
				new_response = 1 ;
				// IE7 slight delay to fix quirk on some situations
				setTimeout( function(){ $('#embed_win_maximize_img').attr('src', './themes/initiate/new_response.png') ; }, 200 ) ;
			}
		}
		else
		{
			new_response = 0 ;
			$('#embed_win_maximize_img').attr('src', './themes/'+theme+'/win_max.png') ;
		}
	}, 150) ;
}

function phplive_init_orientation_set()
{
	var width = $(window).width() ;
	var height = $(window).height() ;
	if ( phplive_mobile === 2 )
	{
		// Android keyboard resize must use screen instead of window
		width = screen.width ;
		height = screen.height ;
	}
	if ( height > width ) { phplive_orientation_isportrait = 1 ; }
	else { phplive_orientation_isportrait = 0 ; }
}

function webkit_version()
{
	// for browser webkit, not significant
	// but for iOS mapp webkit:
	// * <= 537.36 (iOS 9.2.1) var device_height = $(window).height() ;
	var result = /AppleWebKit\/([\d.]+)/.exec(navigator.userAgent) ;
	if ( result ) { return parseFloat(result[1]) ; }
	return 0 ;
}
