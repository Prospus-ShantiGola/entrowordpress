<?php
	if ( defined( 'API_Util_Functions' ) ) { return ; }	
	define( 'API_Util_Functions', true ) ;

	FUNCTION Util_Functions_Sort_Compare($a, $b){ return strnatcmp($b['total'], $a['total']) ; }

	FUNCTION Util_Functions_Bytes( $bytes, $precision = 1 )
	{
		$units = array( 'bytes', 'KB', 'MB', 'GB', 'TB' ) ; 
		$bytes = max( $bytes, 0 ) ; 
		$pow = floor( ($bytes ? log($bytes) : 0) / log(1000) ) ; 
		$pow = min( $pow, count($units) - 1 ) ; 

		$bytes /= pow( 1000, $pow ) ;
		// $bytes /= ( 1 << (10 * $pow) ) ; 
		return round( $bytes, $precision ) . ' ' . $units[$pow] ; 
	}

	FUNCTION Util_Functions_Page( $page, $index, $page_per, $total, $url, $query )
	{
		global $text ; global $s_as ; global $custom_search_options ; global $year ; global $y_start ;
		if ( !isset( $text ) ) { $text = "" ; }
		if ( !isset( $s_as ) || !$s_as ) { $s_as = "text" ; }
		if ( !isset( $custom_search_options ) ) { $custom_search_options = "" ; }
		if ( !isset( $year ) ) { $year = date( "Y", time() ) ; }
		if ( !isset( $y_start ) ) { $y_start = 2011 ; }

		$string = "" ;
		$pages = $remainder = 0 ;

		$remainder = ( $total % $page_per ) ;
		$pages = floor( $total/$page_per ) ;
		$pages = ( $remainder ) ? $pages + 1 : $pages ;

		$span = 10 ;
		$remainder = ( $pages % $span ) ;
		$groups = floor( $pages/$span ) ;
		$groups = ( $remainder ) ? $groups + 1 : $groups ;
		$start = ( $index * $span ) ;
		$end = $start + $span ;

		$group_prev = "" ;
		if ( $index > 0 )
		{
			$c = $start - $span ;
			$new_index = $index - 1 ;
			$group_prev = "<div class=\"page\" onClick=\"location.href='$url?page=$c&y=$year&index=$new_index&$query'\">...prev</div>" ;
		}

		$group_next = "" ;
		if ( $index < ( $groups - 1 ) )
		{
			$c = $end ;
			$new_index = $index + 1 ;
			$group_next = "<div class=\"page\" onClick=\"location.href='$url?page=$c&y=$year&index=$new_index&$query'\">next...</div>" ;
		}

		$string .= $group_prev ;
		for ( $c = $start; $c < $end; ++$c )
		{
			if ( $c < $pages )
			{
				$this_page = $c + 1 ;

				if ( $c == $page )
					$string .= "<div class=\"page_focus\">$this_page</div>" ;
				else
					$string .= "<div class=\"page\" onClick=\"location.href='$url?page=$c&y=$year&index=$index&$query'\">$this_page</div>" ;
			}
		}
		$string .= $group_next ;

		if ( preg_match( "/(op_trans.php)|(transcripts.php)/", $url ) )
		{
			$y = date( "Y", time() ) ;
			$year_string = "<select name='year' id='year' style='font-size: 10px;'>" ;
			for ( $c = $y; $c >= $y_start; --$c ) { $selected = "" ; if ( $year == $c ) { $selected = "selected" ; } $year_string .= "<option value=$c $selected>$c</option>" ; } $year_string .= "</select>" ;
			$reset_string = ( isset( $text ) && $text ) ? "<button type='button' onClick='location.href=reset_url' style='font-size: 10px;'>reset</button>" : "" ;
			$string .= "<div style=\"float: left; padding-left: 10px;\"><form method=\"POST\" onSubmit=\"return false;\" id=\"form_search\">Search: <input type=\"text\" class=\"input_text_search\" size=\"15\" maxlength=\"55\" style=\"font-size: 10px;\" id=\"input_search\" value=\"$text\" onKeydown=\"input_text_listen_search(event);\"> &nbsp; <select name=\"s_as\" id=\"s_as\" style=\"font-size: 10px;\"><option value=\"text\">text</option><option value=\"ces\">chat ID</option><option value=\"vid\">visitor ID</option> $custom_search_options</select> &nbsp; $year_string &nbsp; &nbsp; <input type=\"button\" id=\"btn_page_search\" style=\"\" class=\"input_op_button\" value=\"submit\" onClick=\"do_search('$url?$query')\"> &nbsp; &nbsp; &nbsp; $reset_string</form></div><script type=\"text/javascript\">$('#s_as').val('$s_as')</script>" ;
		}

		$string .= "<div style=\"clear: both;\"></div>" ;

		return $string ;
	}

	FUNCTION Util_Functions_Stars( $directory, $rating )
	{
		global $theme ;
		$star_img = "$directory/themes/$theme/stars.png" ;

		$output = "<div style=''>" ;
		for ( $c = 1; $c <= $rating; ++$c )
			$output .= "<div style='float: left; width: 12px; height: 12px; background: url( $star_img ) no-repeat; background-position: 0px -12px;'></div>" ;
		for ( $c2 = $c; $c2 <= 5; ++$c2 )
			$output .= "<div style='float: left; width: 12px; height: 12px; background: url( $star_img ) no-repeat;'></div>" ;
		$output .= "<div style='clear: both;'></div></div>" ;
		
		return $output ;
	}

?>