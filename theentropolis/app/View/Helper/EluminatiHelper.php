<?php

class EluminatiHelper extends AppHelper{
   var $helpers = array('Html');

   /**
    * Function get all eluminati
    */
   function getAllEluminati($start_limit, $end_limit, $user_name=null)
   {
   	    App::import("Model", "Eluminati");
        $eluminati_obj = new Eluminati();
        $res =  $eluminati_obj->getAllEluminatiData($start_limit, $end_limit, $user_name);
        return $res ;
       
   }
    public function text_cut($text, $length =100, $dots = true) {
    $text = trim(preg_replace('#[\r\t]{2,}#', ' ', $text));
    $text_temp = strip_tags($text);

    while (substr($text, $length, 1) != " ") { $length++; if ($length > strlen($text)) { break; } }
    $text = substr($text, 0, $length);
    return $text . ( ( $dots == true && $text != '' && strlen($text_temp) > $length ) ? '...' : ''); 
  }



  function getEluminatiCount()
  {
     App::import("Model", "Eluminati");
        $eluminati_obj = new Eluminati();
        $res =  $eluminati_obj->getEluminatiCountData();
        return $res ;
  }

  function getEluminatiDetailCount()
  {
     App::import("Model", "EluminatiDetail");
        $eluminati_obj = new EluminatiDetail();
        $res =  $eluminati_obj->TotalEluminatiDetail();
        return $res ;
  }
  function getEluminatiDetailById($eluminati_detail_id)
  {
  
      App::import("Model", "EluminatiDetail");
      $eluminati_obj = new EluminatiDetail();
      $res =  $eluminati_obj->eluminatiDetailById($eluminati_detail_id);
      return $res ;
  }

  function  getEluminatiUser($eluminati_id)
  {
       App::import("Model", "Eluminati");
      $eluminati_obj = new Eluminati();
      $res =  $eluminati_obj-> getEluminatiById($eluminati_id);
      return $res ;
  }

/**
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string
 */
//NOT IN USE 
function trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }
  
    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }
  echo strlen($input);
  echo "<br/>";
    //find last space within length
  echo   $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);
  
    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }
  
    return $trimmed_text;
}


  function Cut($string, $max_length){
      if (strlen($string) > $max_length){
          $string = substr($string, 0, $max_length);
          $pos = strrpos($string, " ");
          if($pos === false) {
                  return substr($string, 0, $max_length)."...";
          }
              return substr($string, 0, $pos)."...";
      }else{
          return $string;
      }
  }



  }