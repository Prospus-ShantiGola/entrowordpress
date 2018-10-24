<?php
	function SMTP_API_Send( $to, $to_name, $from, $from_name, $subject, $body )
	{
		global $CONF ;
		$error = "" ; $phpversion = phpversion() ;

		if ( !function_exists( "curl_init" ) || !function_exists( "curl_exec" ) )
			$error = "Server PHP does not support <a href='http://php.net/manual/en/book.curl.php' target='_blank' style='color: #FFFFFF;'>cURL</a>.  Contact your server admin to enable the PHP cURL support to utilize the API.  Also check the 'curl_exec' function is not disabled in the php.ini file." ;
		else
		{
			$params = array(
			'api_user'  => $CONF["SMTP_LOGIN"],
			'api_key'   => $CONF["SMTP_PASS"],
			'to'        => $to,
			'toname'	=> $to,
			'subject'   => $subject,
			'html'      => "",
			'text'      => $body,
			'from'      => $from,
			);

			$request = curl_init( "https://api.sendgrid.com/api/mail.send.json" ) ;
			curl_setopt( $request, CURLOPT_POST, true ) ;
			curl_setopt( $request, CURLOPT_POSTFIELDS, $params ) ;
			curl_setopt( $request, CURLOPT_HEADER, false ) ;
			curl_setopt( $request, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2 ) ;
			curl_setopt( $request, CURLOPT_RETURNTRANSFER, true ) ;

			$response = curl_exec( $request ) ;
			curl_close( $request ) ;

			if ( preg_match( "/(success)/i", $response ) ) { $error = "NONE" ; }
			else { $error = "SendGrid login or password is incorrect or the server PHP version ($phpversion) is not compatible with the Sendgrid API.  Double check the values and try again.  If you are continuously seeing this error message, consider the Port Connect method or upgrading the <a href='http://php.net/' target='_blank' style='color: #FFFFFF;'>server PHP</a>.  For more information, please visit the <a href='http://www.phplivesupport.com/r.php?r=smtp' target='_blank' style='color: #FFFFFF;'>SMTP addon documentation</a>." ; }
		}

		return $error ;
	}
?>