// WinApp Integration
function wp_decline_chat() { chat_decline() ; }

function wp_total_visitors( thecounter )
{
	// 0 = logo icon
	if ( ( typeof( window.external ) != "undefined" ) && ('wp_total_visitors' in window.external) )
		window.external.wp_total_visitors( thecounter ) ;
}

function wp_init()
{
	if ( ( typeof( window.external ) != "undefined" ) && ('wp_v5' in window.external) )
	{
		window.external.wp_init() ;
	}
	else
	{
		document.write("<div class='info_error'>WinApp upgrade required.  Please upgrade your WinApp to the latest version.  The latest WinApp can be downloaded at the <a href='http://www.phplivesupport.com/r.php?r=login' target='_blank' style='color: #FFFFFF;'>PHP Live! client area</a>.</div>") ;
		return false ;
	}
}
function wp_hide_tray( theces ) { window.external.wp_hide_tray( theces ) ; }
function wp_new_win( theurl, thetitle, thew, theh)
{
	if ( location.href.indexOf("op_trans_view") == -1 )
		window.external.wp_new_win( theurl, thetitle, thew, theh ) ;
	else
		parent.window.open( theurl, thetitle, "scrollbars=yes,menubar=no,resizable=1,location=no,width="+thew+",height="+theh+",status=0" ) ;
}

function wp_pre_go_offline()
{
	// do pre logout, call functions to go offline
	toggle_status(4) ;
}

function wp_activate_chat( theces )
{
	activate_chat( theces ) ;
}


function wp_logout()
{
	wp_total_visitors(0) ;
	if ( ( typeof( window.external ) != "undefined" ) && ('wp_logout' in window.external) )
		window.external.wp_logout() ;
}

function wp_idle_offline()
{
	if ( ( typeof( isop ) != "undefined" ) && isop && ( typeof( current_status ) != "undefined" ) && current_status )
	{
		wid = 1 ;
		toggle_status(1) ;
	}
}

function wp_idle_online()
{
	if ( ( typeof( isop ) != "undefined" ) && isop && ( typeof( current_status ) != "undefined" ) && !current_status && wid )
	{
		wid = 0 ;
		toggle_status(0) ;
	}
}

function wp_idle_online_init()
{
	if ( ( typeof( isop ) != "undefined" ) && isop && ( typeof( current_status ) != "undefined" ) && !current_status && wid )
	{
		// this function is called during the 5 seconds (once every second) before the wp_idle_online() is called
		// - some computers triggers a wake up state when the computer monitor beings sleep mode. to work around this
		// - there is 5 seconds of pause to verify the wake up state is done by the user, not a computer process

		// no action for now
	}
}
