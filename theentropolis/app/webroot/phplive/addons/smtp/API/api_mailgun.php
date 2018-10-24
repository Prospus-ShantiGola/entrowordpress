<?php
	function SMTP_API_Send( $to, $to_name, $from, $from_name, $subject, $body )
	{
		global $CONF ;

		$error = "" ;
		if ( !isset( $CONF["SMTP_DOMAIN"] ) )
			$error = "SMTP domain has not been set." ;
		else if ( !function_exists( "curl_init" ) || !function_exists( "curl_exec" ) )
			$error = "Server PHP does not support <a href='http://php.net/manual/en/book.curl.php' target='new' style='color: #FFFFFF;'>cURL</a>.  Contact your server admin to enable the PHP cURL support to utilize the API.  Also check the 'curl_exec' function is not disabled in the php.ini file." ;
		else
		{
			$request = curl_init( "https://api.mailgun.net/v3/$CONF[SMTP_DOMAIN]/messages" ) ;

			curl_setopt( $request, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
			curl_setopt( $request, CURLOPT_USERPWD, "api:$CONF[SMTP_PASS]" ) ;
			curl_setopt( $request, CURLOPT_RETURNTRANSFER, 1 ) ;

			curl_setopt( $request, CURLOPT_CUSTOMREQUEST, "POST") ;
			curl_setopt( $request, CURLOPT_POSTFIELDS, array( "from" => "$from",
			"to" => $to,
			"subject" => $subject,
			"text" => $body ) ) ;

			if ( !isset( $VARS_SET_VERIFYPEER ) || ( $VARS_SET_VERIFYPEER == 1 ) )
			{
				curl_setopt( $request, CURLOPT_SSL_VERIFYPEER, true ) ;
				curl_setopt( $request, CURLOPT_CAINFO, "$CONF[DOCUMENT_ROOT]/addons/smtp/API/cacert.pem" ) ;
			}
			else { curl_setopt( $request, CURLOPT_SSL_VERIFYPEER, 0 ) ; }

			$response = curl_exec( $request ) ;
			$curl_errno = curl_errno( $request ) ;
			$status = curl_getinfo( $request, CURLINFO_HTTP_CODE ) ; 
			curl_close( $request ) ;

			if ( $curl_errno == 35 )
				$error = "OpenSSL upgrade is required.  <a href='https://www.openssl.org' target='_blank' style='color: #FFFFFF;'>Open SSL</a> must be v.0.9.8o or greater." ;
			else if ( preg_match( "/(thank you)/i", $response ) )
				$error = "NONE" ;
			else if ( preg_match( "/(Domain not found)/i", $response ) )
				$error = "Mailgun account domain is invalid." ;
			else
				$error = "Mailgun API key is invalid. [$status-$curl_errno]";
		}

		return $error ;
	}
?>