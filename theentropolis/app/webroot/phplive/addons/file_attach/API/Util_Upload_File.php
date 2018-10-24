<?php
	if ( defined( 'API_Util_Upload_File' ) ) { return ; }	
	define( 'API_Util_Upload_File', true ) ;

	FUNCTION Util_Upload_File( $upload_formats_string )
	{
		global $CONF ;
		global $max_bytes ;
		$now = time() ;
		$error = $filename = "" ;

		$upload_formats_string_temp = preg_replace( "/ /", "", $upload_formats_string ) ;
		$upload_formats_array = explode( ",", $upload_formats_string_temp ) ; $upload_formats_regex = "(placeholder)|" ; $upload_formats = Array() ;
		for ( $c = 0; $c < count( $upload_formats_array ); ++$c )
		{
			$format = $upload_formats_array[$c] ;
			if ( $format )
			{
				$upload_formats[$format] = 1 ;
				$upload_formats_regex .= "($format)|" ;
			}
		} $upload_formats_regex = substr_replace( $upload_formats_regex, "", -1 ) ;

		if ( isset( $_SERVER['CONTENT_LENGTH'] ) && ( $_SERVER['CONTENT_LENGTH'] > $max_bytes ) )
			$error = "File size must be ".Util_Functions_Bytes($max_bytes, 0)." or less." ;
		else if ( !$_FILES["the_file"]['tmp_name'] )
			$error = "Nothing to upload." ;
		else if ( isset( $_FILES["the_file"]['size'] ) )
		{
			$filename = preg_replace( "/ /", "_", basename( $_FILES["the_file"]['name'] ) ) ;
			$filetype = $_FILES["the_file"]['type'] ;

			if ( preg_match( "/image/i", $filetype ) || ( preg_match( "/text/i", $filetype ) || preg_match( "/pdf/i", $filetype ) || preg_match( "/zip/i", $filetype ) || preg_match( "/tar/i", $filetype ) || ( preg_match( "/octet-stream/i", $filetype ) && preg_match( "/\.conf/i", $filename ) ) ) )
			{
				$fileinfo = getimagesize( $_FILES["the_file"]['tmp_name'] ) ;

				$errorno = $_FILES["the_file"]['error'] ;
				$filesize = $_FILES["the_file"]['size'] ;
				// remove special characters that may cause file path issue
				$filename_parts = explode( ".", preg_replace( "/[\\\,\(\)%\${}\|*?:<>\/#!@\^+]/", "", $filename ) ) ;

				if ( !is_dir( $CONF["ATTACH_DIR"] ) )
					$error = "Could not locate the attachment directory." ;
				else if ( !is_writeable( $CONF["ATTACH_DIR"] ) )
					$error = "Upload directory permission denied." ;
				else if ( $errorno == UPLOAD_ERR_NO_FILE )
					$error = "Nothing to upload." ;
				else if ( !is_uploaded_file( $_FILES["the_file"]['tmp_name'] ) )
					$error = "Invalid file." ;
				else if ( count( $filename_parts ) == 1 )
					$error = "Could not detect the file type extension." ;
				else if ( count( $filename_parts ) > 2 )
					$error = "File name must contain only one dot.<br>* example: image.jpg" ;
				else if ( !preg_match( "/$upload_formats_regex/i", $filename_parts[1] ) )
					$error = "File Upload Formats:<br>$upload_formats_string" ;
				else if ( $errorno == UPLOAD_ERR_OK )
				{
					$validated = 0 ;
					if ( preg_match( "/gif/i", $filetype ) && ( preg_match( "/gif/i", $filename_parts[1] ) ) && $fileinfo )
						$validated = 1 ;
					else if ( preg_match( "/(jpeg)|(jpg)/i", $filetype ) && ( preg_match( "/(jpeg)|(jpg)/i", $filename_parts[1] ) ) && $fileinfo )
						$validated = 1 ;
					else if ( preg_match( "/png/i", $filetype ) && ( preg_match( "/png/i", $filename_parts[1] ) ) && $fileinfo )
						$validated = 1 ;
					else if ( preg_match( "/pdf/i", $filetype ) && ( preg_match( "/pdf/i", $filename_parts[1] ) ) )
						$validated = 1 ;
					else if ( preg_match( "/text/i", $filetype ) && ( preg_match( "/(txt)|(text)/i", $filename_parts[1] ) ) )
						$validated = 1 ;
					else if ( preg_match( "/zip/i", $filetype ) && ( preg_match( "/zip/i", $filename_parts[1] ) ) )
						$validated = 1 ;
					else if ( preg_match( "/tar/i", $filetype ) && ( preg_match( "/tar/i", $filename_parts[1] ) ) )
						$validated = 1 ;
					else if ( preg_match( "/octet-stream/i", $filetype ) && ( preg_match( "/conf/i", $filename_parts[1] ) ) )
						$validated = 1 ;

					if ( $validated )
					{
						$prefix = ( isset( $filename_parts[0] ) && $filename_parts[0] ) ? $filename_parts[0] : Util_Format_RandomString( 6 ) ;
						$filename = $prefix.".".$filename_parts[1] ;
						$dup_counter = 2 ;
						while( file_exists( "$CONF[ATTACH_DIR]/$filename" ) )
						{
							$filename = $prefix."_$dup_counter.".$filename_parts[1] ;
							++$dup_counter ;
						}

						if( move_uploaded_file( $_FILES["the_file"]['tmp_name'], "$CONF[ATTACH_DIR]/$filename" ) )
						{
							// success
						}
						else
							$error = "Could not process uploading of file." ;
					}
					else
						$error = "File Upload Formats:<br>$upload_formats_string" ;
				}
				else if ( $errorno == UPLOAD_ERR_NO_TMP_DIR )
					$error = "Upload temp dir \"upload_tmp_dir\" not set or not writeable." ;
				else if ( $errorno == UPLOAD_ERR_FORM_SIZE )
					$error = "File size must be ".Util_Functions_Bytes($max_bytes, 0)." or less." ;
				else if ( $errorno == UPLOAD_ERR_INI_SIZE )
					$error = "File size must be upload_max_filesize directive or less." ;
				else if ( $errorno )
					$error = "Error in uploading. [errorno: $errorno]" ;
				else
					$error = "Error in uploading." ;
			}
			else
				$error = "File Upload Formats:<br>$upload_formats_string" ;
		}
		else
			$error = "Nothing to upload." ;
		return Array( $error, $filename ) ;
	}

	FUNCTION Util_Upload_Output( $image_path, $image_type )
	{
		switch ( $image_type )
		{
			case ( 1 ):
				$image_type = "image/gif" ; break ;
			case ( 2 ):
				$image_type = "image/jpeg" ; break ;
			case ( 3 ):
				$image_type = "image/png" ; break ;
			case ( 20 ):
				$image_type = "application/pdf" ; break ;
			case ( 21 ):
				$image_type = "text/plain" ; break ;
			case ( 22 ):
				$image_type = "text/plain" ; break ;
			case ( 23 ):
				$image_type = "application/x-zip-compressed" ; break ;
			case ( 24 ):
				$image_type = "application/x-tar" ; break ;
			default:
				$image_type = "" ;
		}

		if ( $image_type )
		{
			$image_binary = file_get_contents( $image_path ) ;
			$image_base64 = base64_encode( $image_binary ) ;
			return ( "data:".$image_type.";base64,".$image_base64 ) ;
		}
		else
			return false ;
	}
?>