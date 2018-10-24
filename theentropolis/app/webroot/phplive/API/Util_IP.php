<?php
	if ( defined( 'API_Util_IP' ) ) { return ; }	
	define( 'API_Util_IP', true ) ;

	FUNCTION Util_IP_GetIP( $token )
	{
		global $CONF ; global $VARS_IP_CAPTURE ; $ip = "0.0.0.0" ; $cookie_vid = "" ;
		if ( ( !isset( $CONF['cookie'] ) || ( isset( $CONF['cookie'] ) && ( $CONF['cookie'] == "on" ) ) ) ) { if ( !isset( $_COOKIE["phplive_vid"] ) ) { $cookie_vid = "vid_".time() ; $_COOKIE["phplive_vid"] = $cookie_vid ; setcookie( "phplive_vid", $cookie_vid, time()+(60*60*24*360), "/" ) ; } else { $cookie_vid = $_COOKIE["phplive_vid"] ; } }
		$headers = function_exists( "apache_request_headers" ) ? apache_request_headers() : Array() ;
		if ( !isset( $cookie_vid ) ) { $cookie_vid = "" ; }
		for ( $c = 0; $c < count( $VARS_IP_CAPTURE ); ++$c )
		{
			$env_var = $VARS_IP_CAPTURE[$c] ;
			if ( isset( $_SERVER[$env_var] ) && $_SERVER[$env_var] ) {
				if ( $env_var == "HTTP_X_FORWARDED_FOR" ) {
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ;
					if ( preg_match( "/,/", $ip ) ) { LIST( $ip, $ip_ ) = explode( ",", preg_replace( "/ +/", "", $ip ) ) ; }
				} else { $ip = $_SERVER[$env_var] ; } break 1 ;
			}
			else if ( isset( $headers[$env_var] ) && $headers[$env_var] )
			{ $ip = $headers[$env_var] ; break 1 ; }
		} if ( !$token ) { $token = $ip ; }
		$http_agent = isset( $_SERVER["HTTP_USER_AGENT"] ) ? $_SERVER["HTTP_USER_AGENT"] : $ip ;
		$http_token = "$ip$http_agent$cookie_vid" ; $vis_token = md5($http_token) ;
		$ip_output = Array( $ip, $vis_token ) ; return $ip_output ;
	}
?>