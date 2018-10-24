<?php
	if ( defined( 'API_Util_Functions_itr' ) ) { return ; }	
	define( 'API_Util_Functions_itr', true ) ;

	FUNCTION Util_Functions_itr_GetHostname( $ip )
	{
		if ( $ip ) { return gethostbyaddr( $ip ) ; }
		else { return $ip ; }
	}

	FUNCTION Util_Functions_itr_Encrypt( $salt, $string )
	{
		return base64_encode( $string ) ;
	}

	FUNCTION Util_Functions_itr_Decrypt( $salt, $encrypted )
	{
		$decoded = base64_decode( $encrypted ) ;
		if ( $encrypted && Util_Functions_itr_is_serialized( $decoded ) ) { return $decoded ; }
		else { return "" ; }
	}

	FUNCTION Util_Functions_itr_is_serialized( $value, &$result = null )
	{
		// FUNCTION SOURCE:
		// https://gist.github.com/cs278/217091
		if (!is_string($value)) { return false; } if ($value === 'b:0;') { $result = false; return true; } $length = strlen($value); $end = ''; switch ($value[0]) { case 's': if ($value[$length - 2] !== '"') { return false; } case 'b': case 'i': case 'd': $end .= ';'; case 'a': case 'O': $end .= '}'; if ($value[1] !== ':') { return false; } switch ($value[2]) { case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7: case 8: case 9: break; default: return false; } case 'N': $end .= ';'; if ($value[$length - 1] !== $end[0]) { return false; } break; default: return false; } if (($result = @unserialize($value)) === false) { $result = null; return false; } return true;
	}

	FUNCTION Util_Functions_itr_Orig_Encrypt( $salt, $string )
	{
		return base64_encode( mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($salt), $string, MCRYPT_MODE_CBC, md5(md5($salt))) ) ;
	}

	FUNCTION Util_Functions_itr_Orig_Decrypt( $salt, $encrypted )
	{
		return rtrim( mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($salt), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($salt))), "\0" ) ;
	}
?>