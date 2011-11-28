<?php

namespace Fuel\Tasks;


class Statistics {

	public static function realtime(){    
  $name = "Woopra\Woopra";

  $w = new $name(array(
      "url" => "http://api.woopra.com/rest/analytics",
      "domain" => "brr.com.au",
      "api_key" => "9LMSCGMKTL",
      "format" => "xml",
      "date_format" => "dd/MM/yyyy",
      "limit" => 10000,
      "offset" => 0
      ));
  $w->cron();
     
 
 }
 
}





?>