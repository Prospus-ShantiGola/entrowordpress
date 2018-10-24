<?php
	if ( defined( 'API_Util_Email' ) ) { return ; }	
	define( 'API_Util_Email', true ) ;

	$ERROR_EMAIL = "" ;
	FUNCTION eMailErrorHandler($errno, $errstr, $errfile, $errline) { global $ERROR_EMAIL ; $ERROR_EMAIL = $errstr ; }
	FUNCTION Util_Email_SendEmail( $from_name, $from_email, $to_name, $to_email, $subject, $message, $extra, $bcc = Array() )
	{
		global $CONF ;
		global $smtp_array ;
		global $ERROR_EMAIL ;
		global $DMARC_DOMAINS ;

		if ( $extra == "trans" )
			$message = stripslashes( preg_replace( "/-dollar-/", "\$", $message ) ) ;

		if ( $extra == "sms" )
		{
			$headers = "From: $from_name <$from_email>" . "\r\n" ;
			$subject_new = $subject ;
			$headers .= "MIME-Version: 1.0" . "\n" ;
			$headers .= "Content-type: text/plain; charset=UTF-8" . "\r\n" ;
		}
		else
		{
			LIST( $null, $domain ) = explode( "@", $from_email ) ; $dmarc = 0 ;
			if ( !isset( $DMARC_DOMAINS ) ) { $DMARC_DOMAINS = Array( "yahoo"=>1, "hotmail"=>1, "aol.com"=>1 ) ; }
			foreach( $DMARC_DOMAINS as $thisdomain => $null ) { if ( preg_match( "/$thisdomain/i", $domain ) ) { $dmarc = 1 ; break ; } }
			if ( is_array( $DMARC_DOMAINS ) && $dmarc )
			{
				$headers = "From: ".'=?UTF-8?B?'.base64_encode( $to_name ).'?='." <$to_email>" . "\r\n" ;
				$message = "=======\r\nDMARC email policy for domain $domain.  To be able to deliver the email to your inbox, the reply-to (sender) is the same as your email address.  If wanting to reply to this message, please forward this message to $from_email ]\r\n=======\r\n\r\n$message" ;

				$from_name = $to_name ;
				$from_email = $to_email ;
			}
			else { $headers = "From: ".'=?UTF-8?B?'.base64_encode( $from_name ).'?='." <$from_email>" . "\r\n" ; }
			$headers .= "MIME-Version: 1.0" . "\n" ;
			$headers .= "Content-type: text/plain; charset=UTF-8" . "\r\n" ;
			for ( $c = 0; $c < count( $bcc ); ++$c ) { $headers .= "Bcc: $bcc[$c]\r\n" ; }
			$subject_new = '=?UTF-8?B?'.base64_encode( $subject ).'?=' ;
		}

		// SMTP
		//ini_set( SMTP, "localhost" ) ;

		if ( $to_email )
		{
			if ( isset( $smtp_array ) && isset( $smtp_array["host"] ) )
			{
				$CONF["SMTP_HOST"] = $smtp_array["host"] ;
				$CONF["SMTP_LOGIN"] = $smtp_array["login"] ;
				$CONF["SMTP_PASS"] = $smtp_array["pass"] ;
				$CONF["SMTP_PORT"] = $smtp_array["port"] ;
				$CONF["SMTP_CRYPT"] = ( isset( $smtp_array["crypt"] ) ) ? $smtp_array["crypt"] : "" ;
				$CONF["SMTP_API"] = isset( $smtp_array["api"] ) ? $smtp_array["api"] : "" ;
				$CONF["SMTP_DOMAIN"] = isset( $smtp_array["domain"] ) ? $smtp_array["domain"] : "" ;
			}

			set_error_handler('eMailErrorHandler') ;
			if ( !isset( $CONF["SMTP_PASS"] ) && is_file( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/Util_Extra.php" ) ) { include_once( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/Util_Extra.php" ) ; }
			if ( isset( $CONF["SMTP_PASS"] ) )
			{
				if ( is_file( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/Util_Email_SMTP.php" ) )
				{
					include_once( "$CONF[DOCUMENT_ROOT]/addons/smtp/API/Util_Email_SMTP.php" ) ;

					$error = Util_Email_SMTP_SwiftMailer( $to_email, $to_name, $from_email, $from_name, $subject_new, $message, $bcc ) ;
					if ( defined( 'API_Util_Error' ) ) { set_error_handler( "ErrorHandler" ) ; }

					if ( $error == "NONE" ) { return false ; }
					else { return $error ; }
				}
				else
					return "SMTP addon not found or addon upgrade is needed. [e1]" ;
			}
			else
			{
				if ( mail( $to_email, $subject_new, $message, $headers ) ) { if ( defined( 'API_Util_Error' ) ) { set_error_handler( "ErrorHandler" ) ; } return false ; }
				else
				{
					if ( defined( 'API_Util_Error' ) ) { set_error_handler( "ErrorHandler" ) ; }

					if ( preg_match( "/failed to connect/i", $ERROR_EMAIL ) )
						return "Could not connect to local mail server or mail server is not installed." ;
					else
						return "Email error: $ERROR_EMAIL" ;
				}
			}
		}
		else
			return "Recipient is invalid." ;
	}

	function Util_Email_FormatTranscript( $ces, $transcript_template, $vis_name, $vis_email, $op_name, $op_email, $custom_vars, $transcript_formatted )
	{
		$custom_vars_string = "" ;
		$customs = explode( "-cus-", $custom_vars ) ;
		for ( $c = 0; $c < count( $customs ); ++$c )
		{
			$custom_var = $customs[$c] ;
			if ( $custom_var && preg_match( "/-_-/", $custom_var ) )
			{
				LIST( $cus_name, $cus_val ) = explode( "-_-", preg_replace( "/%20/", " ", $custom_var ) ) ;
				$cus_name = preg_replace( "/\\$/", "-dollar-", $cus_name ) ;
				$cus_val = preg_replace( "/\\$/", "-dollar-", $cus_val ) ;
				if ( $cus_val )
				{
					$custom_vars_string .= "$cus_name: $cus_val\r\n" ;
				}
			}
		}
		if ( $vis_email == "null" ) { $vis_email = "" ; }

		$message = preg_replace( "/<>/", "\r\n", stripslashes( preg_replace( "/(\r\n)|(\n)|(\r)/", "", $transcript_formatted ) ) ) ;
		$message = preg_replace( "/<a href='(.*?)'(.*?)a>/i", "$1", $message ) ;
		$message = preg_replace( "/\\$/", "-dollar-", $message ) ; // to limit variable confusion.  will revert before sending
		$message = preg_replace( "/<div class='ca'><i>(.*?)<\/i><\/div>/i", "-------------------------------------\r\n$vis_name $vis_email\r\n$custom_vars_string\r\n$1\r\n-------------------------------------", $message ) ;
		$message = preg_replace( "/<disconnected><d(\d)>(.*?)<\/div>/i", "\r\n-------------------------------------\r\n$2\r\n-------------------------------------\r\n", $message ) ;
		$message = preg_replace( "/===\r\n===/", "-------------------------------------", $message ) ;
		$message = preg_replace( "/<div class='co'><b>(.*?)<timestamp_(\d+)_co>:<\/b> /i", "\r\n$1:\r\n", $message ) ;
		$message = preg_replace( "/<v>/", "", $message ) ; // old chat transcript format clean
		$message = preg_replace( "/<div class='cv'><b>(.*?)<timestamp_(\d+)_cv>:<\/b> /i", "\r\n$1:\r\n", $message ) ;
		$message = preg_replace( "/<br>/i", "\r\n", $message ) ;
		$message = preg_replace( "/<(.*?)>/", "", strip_tags( $message ) ) ; // double check
		$message = preg_replace( "/[\n]+/", "\r\n", $message ) ; $message = preg_replace( "/[\r]+/", "\r\n", $message ) ;
		$message = preg_replace( "/[\r\n]+/", "\r\n\r\n", $message ) ;

		$message = preg_replace( "/%%transcript%%/", "$message", $transcript_template ) ;
		$message = preg_replace( "/%%visitor%%/", $vis_name, $message ) ;
		$message = preg_replace( "/%%operator%%/", $op_name, $message ) ;
		$message = preg_replace( "/%%op_email%%/", $op_email, $message ) ;

		$message .= "\r\n\r\n\r\n==\r\nChat ID: $ces\r\n" ;

		return $message ;
	}
?>