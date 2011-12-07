<?php

class Helper {
 
  public static function date_s($s){
    $res = null;
    $parts = explode("-", substr($s,0,10));
    if (count($parts) == 3 && checkdate($parts[1], $parts[2], $parts[0])) {
      $res = $parts[2] . "/" . $parts[1] . "/" . $parts[0];
    }
    return $res;      
  }
  
  public static function s_date($s){
    $res = null;
    $parts = explode("/", $s);
    if (count($parts) == 3 && checkdate($parts[1], $parts[0], $parts[2])) {
      $res = $parts[2] . "-" . $parts[1] . "-" . $parts[0];
    }
    return $res;      
  }
  
  public static function str_to_time($date) {
    $res = null;
    $parts = explode("/", $date);
    if (count($parts) == 3 && checkdate($parts[1], $parts[0], $parts[2])) {
      $res = mktime(0, 0, 0, $parts[1], $parts[0], $parts[2]);
    }
    return $res;
  }

  public static function quote($s="") {
    return "'" . str_replace("'", "", $s) . "'";
  }

  //generates high chart js code, given an array

  public static function pie($shares) {
   //print_r($shares);die();
    $total_hits = 0;
    $max = null;

    if (count($shares) > 0) {
      foreach ($shares as $k => $v) {
        if ($max === null) {
          $max = $v;
        } else if ($v > $max) {
          $max = $v;
        }

        $total_hits += $v;
      }
    }
    
    if($total_hits == 0) return;
    
    $js = array();
    if (count($shares) > 0) {
      foreach ($shares as $k => $v) {
        $y = 0;
        $y = round($v * 100 / $total_hits, 1, PHP_ROUND_HALF_UP);
        if ($v == $max) {
          $js[] = "{name: '$k', y: $y, sliced: true, selected: true}";
        } else {
          $js[] = "['$k',   $y]";
        }
      }
    }
    
    return implode(",", $js);
  }

  
  
  // generate x and y for line charts
  
  public static function xy($items){
    $res = array();
    if(count($items) > 0){
      $num = count($items[0]);
              
        $i = 0;
      
        while($i < $num){
          
          $vals = array();
          foreach($items as $item){
            $vals[] = $item[$i];
          }
          
          $res[] = $vals;
        
          $i++;
        }

      
    }
    return $res;
  }
  
  
  //format the dates for overview table

  public static function format_overview_dates($str, $format="D, jS M, Y") {
    $text = "";
    $parts = explode(",", $str);

    if (count($parts) > 0) {
      if ($parts[0] == $parts[1]) {

        $text = date($format, self::str_to_time($parts[0]));
        
      } else {

        $text = date("M", self::str_to_time($parts[0]));
        //$text .= " - ";
        //$text .= date($format, self::str_to_time($parts[1]));
        
      }
    } else {
      
      $text = date($format, self::str_to_time($str));
      
    }
    
    return $text;
  }
  
  public static function cmp($a, $b){
    if($a[1] == $b[1]){
      return 0;
    }
    
    return ($a[1] < $b[1]) ? 1 : -1;
    
  }
  
   
}

?>   