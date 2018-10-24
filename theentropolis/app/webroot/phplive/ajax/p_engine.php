<?php
	/* (c) OSI Codes Inc. */
	/* http://www.osicodesinc.com */
	include_once( "../web/config.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Format.php" ) ;
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Error.php" ) ;

	$ces = Util_Format_Sanatize( Util_Format_GetVar( "ces" ), "ln" ) ;
	$cs = Util_Format_Sanatize( Util_Format_GetVar( "cs" ), "ln" ) ;
	$lang = Util_Format_Sanatize( Util_Format_GetVar( "lang" ), "ln" ) ; if ( !$lang ) { $lang = "english" ; }
	$charset = Util_Format_Sanatize( Util_Format_GetVar( "charset" ), "ln" ) ;
	if ( !$charset ) { $charset = "UTF-8" ; }

	include_once( "$CONF[DOCUMENT_ROOT]/lang_packs/$lang.php" ) ;
?>
<?php include_once( "../inc_doctype.php" ) ?>
<head>
<title> [ chat engine ] </title>

<meta name="description" content="v.<?php echo $VERSION ?>">
<meta name="keywords" content="<?php echo md5( $KEY ) ?>">
<meta name="robots" content="all,index,follow">
<meta http-equiv="content-type" content="text/html; CHARSET=<?php echo $charset ?>"> 
<?php include_once( "../inc_meta_dev.php" ) ; ?>

<link rel="Stylesheet" href="../themes/default/style.css?<?php echo $VERSION ?>">
<script data-cfasync="false" type="text/javascript" src="../js/global.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/global_chat.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript" src="../js/framework_cnt.js?<?php echo $VERSION ?>"></script>

<script data-cfasync="false" type="text/javascript">
<!--
	"use strict" ;
	var base_url = ".." ;
	var on = 1 ; var dev_run = 0 ;
	var isop = parent.isop ; var isop_ ; var isop__ ;
	var ces = "<?php echo $ces ?>" ;
	var stopped = 0 ;
	var reconnect = 0 ;
	var rloop = ( typeof( parent.rloop ) != "undefined" ) ? parent.rloop : 0 ;
	var loop = ( typeof( parent.loop ) != "undefined" ) ? parent.loop : 1 ;
	var chatting_err_915, chatting_err_815 ;
	var dc_c_queueing = 0 ;

	var c_routing = 0, c_chatting = 0, c_requesting = 0, c_queueing = 0 ;
	var st_routing, st_chatting, st_requesting, st_init_chatting, st_network, st_connect, st_reconnect, st_queueing ;

	$(document).ready(function()
	{
		$.ajaxSetup({ cache: false }) ;

		if ( on )
		{
			if ( isop )
			{
				if ( typeof( st_requesting ) != "undefined" ) { clearTimeout( st_requesting ) ; }
				st_requesting = setTimeout( "requesting()", 2000 ) ; // slight delay to let parent load
			}
			else if ( !parent.widget )
				st_routing = setTimeout( "routing(0)" , 1000 ) ; // take out timeout on live
		
			init_chatting() ;
		}
	});
	$( document ).ajaxError(function( event, request, settings ) {
		$( "#msg" ).append( "<li>Error requesting page " + settings.url + "</li>" );
	});

	function init_chatting()
	{
		if ( !parent.loaded )
			st_init_chatting = setTimeout(function(){ init_chatting() }, 300) ;
		else
		{
			if ( typeof( st_init_chatting ) != "undefined" )
			{
				clearTimeout( st_init_chatting ) ; st_init_chatting = undeefined ;
			}

			// only start chatting() if not operator... operators are started with requesting()
			if ( !isop )
				chatting() ;
		}
	}

	function queueing()
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		var rstring = "" ;
		for ( var this_opid in parent.chats[ces]["q_opids"] )
		{
			if ( this_opid ) { rstring = this_opid+","+rstring ; }
		} parent.rstring = rstring ;

		var minutes = Math.floor( ( c_queueing * parseInt( <?php echo $VARS_JS_REQUESTING ?> ) )/60 ) ;
		if (  minutes >= parseInt( <?php echo $VARS_EXPIRED_QUEUE_IDLE ?> ) )
		{
			parent.leave_a_mesg(0, "") ;
			return false ;
		}

		$.ajax({
		type: "GET",
		url: base_url+"/ajax/chat_queueing.php",
		data: "&a=queueing&e="+parent.embed+"&c="+ces+"&q="+parent.queue+"&ql="+parent.qlimit+"&d="+parent.deptid+"&t="+parent.phplive_browser_token+"&cq="+c_queueing+"&r="+parent.rtype+"&rs="+rstring+"&"+unique,
		success: function(data){
			try {
				eval(data) ;
			} catch(err) {
				// suppress - should never reach here unless a script error
			}

			if ( typeof( st_queueing ) != "undefined" )
			{
				clearTimeout( st_queueing ) ;
				st_queueing = undeefined ;
			}

			if ( json_data.status == 1 )
			{
				var total_ops_online = ( typeof( json_data.total_ops_online ) != "undefined" ) ? parseInt( json_data.total_ops_online ) : -1 ;

				if ( ( total_ops_online == -1 ) || total_ops_online )
				{
					parent.process_queue( false, parseInt( json_data.qpos ), parseInt( json_data.est ), parseInt( json_data.created ) ) ;
					++c_queueing ;
					st_queueing = setTimeout( "queueing()" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ;
				}
				else
				{
					parent.leave_a_mesg(0, "") ;
				}
			}
			else if ( json_data.status == 2 )
			{
				// operator is available
				if ( ces == json_data.ces ) { parent.process_queue( json_data.ces, parseInt( json_data.qpos ), 0, parseInt( json_data.created ) ) ; }
				else
				{
					parent.process_queue( false, parseInt( json_data.qpos ), 0, parseInt( json_data.created ) ) ;
					++c_queueing ;
					st_queueing = setTimeout( "queueing()" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ;
				}
			}
			else { parent.do_alert( 0, json_data.error ) ; stopit(0) ; }
		},
		error:function (xhr, ajaxOptions, thrownError){
			if ( typeof( st_queueing ) != "undefined" )
			{
				clearTimeout( st_queueing ) ;
				st_queueing = undeefined ;
			}
			st_queueing = setTimeout( "queueing()" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ;
			++dc_c_queueing ;
			if ( dc_c_queueing > 1 ) { parent.do_alert( 0, "<?php echo isset( $LANG["CHAT_ERROR_DC"] ) ? Util_Format_ConvertQuotes( $LANG["CHAT_ERROR_DC"] ) : "Connection error.  Please refresh the page and try again." ; ?>" ) ; }
		} });
	}

	function routing( theopid )
	{
		var unique = unixtime() ;
		var json_data = new Object ;

		$.ajax({
		type: "GET",
		url: base_url+"/ajax/chat_routing.php",
		data: "&a=routing&c="+ces+"&d="+parent.deptid+"&r="+parent.rtype+"&rt="+parent.rtime+"&cr="+c_routing+"&rl="+rloop+"&l="+loop+"&lg="+parent.lang+"&q="+parent.queue+"&iq="+parent.inqueue+"&o="+theopid+"&pr="+parent.proto+"&"+unique,
		success: function(data){
			try {
				eval(data) ;
			} catch(err) {
				// suppress - should never reach here unless a script error
			}

			if ( typeof( st_routing ) != "undefined" )
			{
				clearTimeout( st_routing ) ;
				st_routing = undeefined ;
			}

			if ( json_data.status == 1 )
				parent.init_connect( json_data ) ;
			else if ( json_data.status == 2 )
			{
				// routed to new operator
				var opid = parseInt( json_data.opid ) ;

				if ( typeof( json_data.reset ) != "undefined" )
				{
					++loop ;
				}
				if ( typeof( json_data.rtime ) != "undefined" )
				{
					parent.rtime = parseInt( json_data.rtime ) ;
				}
				++c_routing ;

				if ( opid ) { parent.chats[ces]["q_opids"][opid] = 1 ; }
				st_routing = setTimeout( "routing(0)" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ;
			}
			else if ( json_data.status == 10 )
			{
				stopit(0) ;

				var q_ops = ( typeof( json_data.q_ops ) != "undefined" ) ? json_data.q_ops : "" ;
				parent.leave_a_mesg(1, q_ops) ;
			}
			else if ( json_data.status == 11 )
			{
				stopit(0) ;

				var q_ops = ( typeof( json_data.q_ops ) != "undefined" ) ? json_data.q_ops : "" ;
				parent.vclick = 2 ; // 2=flag not to store stats
				parent.leave_a_mesg(1, q_ops) ;
			}
			else if ( json_data.status == 0 )
			{
				++c_routing ;
				st_routing = setTimeout( "routing(0)" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			if ( typeof( st_routing ) != "undefined" )
			{
				clearTimeout( st_routing ) ;
				st_routing = undeefined ;
			}
			st_routing = setTimeout( "routing(0)" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ;
		} });
	}

	function requesting()
	{
		var start = microtime( true ) ;
		var unique = unixtime() ;
		var json_data = new Object ; c_chatting = c_requesting ;
		var chatting_query = get_chatting_query() ; if ( chatting_query ) { chatting_query = "&"+chatting_query ; }
		var q_ces = "" ;
		var addon_ws = parent.addon_ws ;
		var addon_ws_q_ces = " \"cess\": [  " ;

		for ( var ces in parent.chats )
		{
			q_ces += "qc[]="+ces+"&" ;
			if ( !parent.chats[ces]["disconnected"] )
				addon_ws_q_ces += "{ \"c\": \""+ces+"\" }," ;
		}
		addon_ws_q_ces = addon_ws_q_ces.slice(0, -1) ;
		addon_ws_q_ces += " ] " ;

		if ( typeof( st_network ) != "undefined" ) { clearTimeout( st_network ) ; st_network = undeefined ; }
		if ( typeof( st_requesting ) != "undefined" ) { clearTimeout( st_requesting ) ; st_requesting = undeefined ; }

		if ( !reconnect )
		{ st_network = setTimeout( function(){ stopit(0) ; parent.check_network( 715, undeefined, undeefined ) }, parseInt( <?php echo $VARS_JS_OP_CONSOLE_TIMEOUT ?> ) * 1000 ) ; }
		else
		{ st_network = setTimeout( function(){ stopit(0) ; parent.check_network( 717, undeefined, undeefined ) }, parseInt( <?php echo $VARS_JS_REQUESTING ?> ) * 1000 ) ; }

		$.ajax({
		type: "GET",
		url: base_url+"/ajax/chat_op_requesting.php",
		data: "cs=<?php echo $cs ?>&m="+parent.mapp+"&a=rq&ps="+parent.prev_status+"&pr="+parent.proto+"&tr="+parent.traffic+"&cr="+c_requesting+"&"+q_ces+chatting_query+"&"+unique+"&ws="+addon_ws,
		success: function(data, textstatus, request){
			if ( typeof( st_network ) != "undefined" ) { clearTimeout( st_network ) ; st_network = undeefined ; }
			try {
				eval(data) ;
				++parent.ping_counter_req ;
			} catch(err) {
				// most likely internet disconnect or server response error will cause console to disconnect automatically
				// suppress error and let the console reconnect
				if ( !reconnect )
				{
					parent.check_network( 719, undeefined, err ) ;
					parent.show_debug( "719: "+data, err ) ;
				}
				else
				{
					stopit(0) ;
					st_reconnect = setTimeout(function(){ parent.check_network( 716, undeefined, undeefined ) ; }, 3000) ;
				} return false ;
			}
			if ( typeof( request.responseText.length ) != "undefined" )
				parent.ping_total_bytes_received += parseInt( request.responseText.length ) ;

			chatting_err_815 = undeefined ;
			if ( !stopped || ( stopped && reconnect ) )
			{
				stopped = 0 ; // reset it for disconnect situation
				reconnect = 0 ;
				parent.reconnect_success() ;

				// reset it here for network status
				unique = unixtime() ;

				if ( json_data.status == -1 )
				{
					parent.dup = 1 ; // most likely another login at another location
					parent.toggle_status( 3 ) ;
				}
				else if ( json_data.status )
				{
					var json_length = ( typeof( json_data.requests ) != "undefined" ) ? json_data.requests.length : 0 ;
					for ( var c = 0; c < json_length; ++c )
					{
						var thisces = json_data.requests[c]["ces"] ;
						var thisdeptid = json_data.requests[c]["did"] ;
						var rupdated = ( typeof( parent.depts_rtime_hash[thisdeptid] ) != "undefined" ) ? parseInt( json_data.requests[c]["vup"] ) + parseInt( parent.depts_rtime_hash[thisdeptid] ) : unique ;
						// ( unique <= rupdated ) - need to plan further

						if ( json_data.requests[c]["op2op"] || ( typeof( parent.op_depts_hash[thisdeptid] ) != "undefined" ) )
						{
							parent.new_chat( json_data.requests[c], unique ) ;
						}
					}

					parent.init_chat_list( unique ) ;
					parent.update_traffic_counter( pad( json_data.traffics, 2 ) ) ;

					if ( typeof( st_requesting ) == "undefined" )
						st_requesting = setTimeout( "requesting()" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ;

					var end = microtime( true ) ;
					var diff = end - start ;

					parent.check_network( diff, unique, json_data.pd ) ;

					// process chats, same as in chatting() function
					if ( addon_ws )
					{
						// send action to process DB updates so the connection does not timeout
						var ws_text = "{ \"o\": \""+parent.isop+"\", \"a\": \"upv\", \"cr\": \""+c_requesting+"\", "+addon_ws_q_ces+" }" ;
						parent.ws_init_message_send( ws_text ) ;
					}
					else
					{
						process_chat_messages( json_data.chats, json_data.istyping ) ;
					}
				}
				++c_requesting ;
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			if ( typeof( chatting_err_815 ) == "undefined" )
			{
				chatting_err_815 = 1 ;
				parent.update_network_log( "<tr id='div_network_his_"+parent.network_counter+"' style='display: none'><td class='chat_info_td' colspan='3'>xhr: 815: "+xhr.status+"</td></tr>" ) ;
				setTimeout(function(){ requesting() ; }, 3000) ;
				parent.show_debug( "815: "+xhr.status, xhr.responseText ) ;
			}
			else
			{
				// for Mobile Apps, some devices pauses network at pause/resume.  add some buffer so the disconnect message is only
				// displayed on actual network disconnect
				if ( parent.mapp && chatting_err_815 && ( chatting_err_815 < 3 ) ) { ++chatting_err_815 ; }
				else
				{
					stopit(0) ;
					st_reconnect = setTimeout(function(){ parent.check_network( 815+":"+xhr.status, undeefined, undeefined ) ; }, 3000) ;
				}
			}
		} });

		if ( dev_run && ( c_requesting > 1 ) )
			stopit(0) ;
	}

	function chatting()
	{
		var json_data = new Object ;
		var chatting_query = get_chatting_query() ;
		var addon_ws = parent.addon_ws ;

		if ( typeof( st_chatting ) != "undefined" )
		{
			clearTimeout( st_chatting ) ; st_chatting = undeefined ;
		}

		if ( addon_ws )
		{
			// keep the looping for fallback AJAX method
			if ( !isop && chatting_query )
			{
				var regex = /rq=(.*?)&/ ;
				var requestid = ( typeof( chatting_query.match( regex )[1] ) != "undefined" ) ? parseInt( chatting_query.match( regex )[1] ) : 0 ;

				regex = /mo=(.*?)&/ ;
				var mobile = ( typeof( chatting_query.match( regex )[1] ) != "undefined" ) ? parseInt( chatting_query.match( regex )[1] ) : 0 ;

				regex = /mp=(.*?)&/ ;
				var mapp = ( typeof( chatting_query.match( regex )[1] ) != "undefined" ) ? parseInt( chatting_query.match( regex )[1] ) : 0 ;

				regex = /o_=(.*?)&/ ;
				var isop_ = ( typeof( chatting_query.match( regex )[1] ) != "undefined" ) ? parseInt( chatting_query.match( regex )[1] ) : 0 ;

				if ( requestid )
				{
					var ws_text = "{ \"a\": \"upv\", \"cess\": [ { \"c\": \""+parent.ces+"\" } ], \"o\": \""+isop+"\", \"o_\": \""+isop_+"\", \"rq\": \""+requestid+"\", \"mo\": \""+mobile+"\", \"mp\": \""+mapp+"\", \"ch\": \""+c_chatting+"\" }" ;
					parent.ws_init_message_send( ws_text ) ;
				}
				if ( typeof( st_chatting ) == "undefined" )
					st_chatting = setTimeout( "chatting()" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ;
				++c_chatting ;
			}
		}
		else if ( chatting_query )
		{
			var unique = unixtime() ;

			$.ajax({
			type: "GET",
			url: base_url+"/ajax/chat_op_requesting.php",
			data: chatting_query+"&pr="+parent.proto+"&"+unique+"&",
			success: function(data){
				try {
					eval(data) ;
				} catch(err) {
					// if operator, the console will attempt to reconnect
					// if visitor, keep trying to send the data
					if ( !isop ) { visitor_reconnect() ; }
				}

				chatting_err_915 = undeefined ;
				if ( !stopped || ( stopped && reconnect ) )
				{
					stopped = 0 ; // reset it for disconnect situation
					reconnect = 0 ;

					if ( json_data.status )
					{
						// process chats
						process_chat_messages( json_data.chats, json_data.istyping ) ;

						// only apply to visitor... for operator requesting() calls it for disconnection detection
						if ( !isop )
						{
							if ( typeof( st_chatting ) == "undefined" )
								st_chatting = setTimeout( "chatting()" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ;
						}
					}
				}
				else
				{
					clearTimeout( st_chatting ) ; st_chatting = undeefined ;
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				if ( isop )
				{
					if ( typeof( chatting_err_915 ) == "undefined" )
					{
						chatting_err_915 = 1 ;
						parent.update_network_log( "<tr id='div_network_his_"+parent.network_counter+"' style='display: none'><td class='chat_info_td' colspan='3'>xhr: 915: "+xhr.status+"</td></tr>" ) ;
						setTimeout(function(){ chatting() ; }, 3000) ;
					}
					else
					{
						stopit(0) ;
						st_reconnect = setTimeout(function(){ parent.check_network( 915+":"+xhr.status, undeefined, undeefined ) ; }, 1000) ;
					}
				}
				else { visitor_reconnect() ; }
			} });
			++c_chatting ;
		}
		else
		{
			if ( !isop ) { st_chatting = setTimeout( "chatting()" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ; }
		}
	}

	function get_chatting_query()
	{
		var query ;
		var start = 0 ;
		var q_ces = "" ;
		var q_chattings = "" ;
		var q_isop_ = "" ;
		var q_isop__ = "" ;

		for ( var this_ces in parent.chats )
		{
			// only check chats that are in session...
			if ( ( ( parent.chats[this_ces]["status"] == 1 ) || ( !isop && ( parent.chats[this_ces]["status"] == 2 ) ) || parent.chats[this_ces]["op2op"] || parent.chats[this_ces]["initiated"] ) && !parent.chats[this_ces]["disconnected"] && !parent.chats[this_ces]["tooslow"] )
			{
				q_ces += "qcc[]="+this_ces+"&" ;
				q_chattings += "qch[]="+parent.chats[this_ces]["chatting"]+"&" ;
				q_isop_ += "qo_[]="+parent.chats[this_ces]["op2op"]+"&" ;
				q_isop__ += "qo__[]="+parent.chats[this_ces]["opid"]+"&" ;
				start = 1 ;
			}
		}

		if ( start )
		{
			isop_ = parent.isop_ ; isop__ = parent.isop__ ;
			var thisces = ( typeof( parent.ces ) != "undefined" ) ? parent.ces : "" ;
			var requestid = ( thisces && typeof( parent.chats[thisces]["requestid"] ) != "undefined" ) ? parent.chats[thisces]["requestid"] : 0 ;
			var t_vses = ( thisces ) ? parent.chats[thisces]["t_ses"] : 0 ;
			var mobile = ( typeof( parent.mobile ) != "undefined" ) ? parent.mobile : 0 ;
			var mapp = ( !parent.isop ) ? parent.chats[thisces]["mapp"] : parent.mapp ;

			query = "rq="+requestid+"&t="+t_vses+"&o="+isop+"&o_="+isop_+"&o__="+isop__+"&c="+thisces+"&ch="+c_chatting+"&"+q_ces+q_chattings+q_isop_+q_isop__+"&mo="+mobile+"&mp="+mapp+"&" ;
		}
		return query ;
	}

	function process_chat_messages( thechat_sessions, theistyping )
	{
		var thisces = ( typeof( parent.ces ) != "undefined" ) ? parent.ces : "" ;
		var json_length = ( typeof( thechat_sessions ) != "undefined" ) ? thechat_sessions.length : 0 ;
		for ( var c = 0; c < json_length; ++c )
			parent.update_ces( thechat_sessions[c] ) ;

		parent.init_chats() ;

		if ( typeof( parent.chats[thisces] ) != "undefined" )
			parent.chats[thisces]["istyping"] = theistyping ;
	}

	function reset_chatting()
	{
		stopped = 0 ; reconnect = 0 ;
	}

	function restart_requesting()
	{
		requesting() ;
	}

	function visitor_reconnect()
	{
		// keep trying to reconnect the chat engine
		// todo: maximum number of attempts before final disconnect
		if ( typeof( st_chatting ) != "undefined" )
		{
			clearTimeout( st_chatting ) ;
			st_chatting = undeefined ;
		}
		st_chatting = setTimeout( "chatting()" , <?php echo $VARS_JS_REQUESTING ?> * 1000 ) ;
	}

	function stopit( thereconnect )
	{
		reconnect = thereconnect ;
		clear_timeouts() ;
		if ( !isop ) { parent.disconnect_complete() ; }
	}

	function clear_timeouts()
	{
		if ( typeof( st_routing ) != "undefined" ) { clearTimeout( st_routing ) ; st_routing = undeefined ; }
		if ( typeof( st_chatting ) != "undefined" ) { clearTimeout( st_chatting ) ; st_chatting = undeefined ; }
		if ( typeof( st_requesting ) != "undefined" ) { clearTimeout( st_requesting ) ; st_requesting = undeefined ; }
		if ( typeof( st_queueing ) != "undefined" ) { clearTimeout( st_queueing ) ; st_queueing = undeefined ; }
		if ( typeof( st_network ) != "undefined" ) { clearTimeout( st_network ) ; st_network = undeefined ; }
		if ( typeof( st_reconnect ) != "undefined" ) { clearTimeout( st_reconnect ) ; st_reconnect = undeefined ; }
		stopped = 1 ;
	}
//-->
</script>
</head>
<body>
</body>
</html>
