<?php

namespace Woopra;

class Woopra {

  protected $url;
  protected $domain;
  protected $api_key;
  protected $format;
  protected $date_format;
  protected $limit;
  protected $offset;
  
  public static $options = array(
      "overview" => "Overview",
      "partners" => "Partners",
      "durations" => "Durations",
      "referrer_type" => "Referrers",
      "regions" => "Regions",
      "queries" => "Queries",
      "realtime" => "Live"
  );

  public function __construct($config) {
    $this->url = $config["url"];
    $this->domain = $config["domain"];
    $this->api_key = $config["api_key"];
    $this->format = $config["format"];
    $this->date_format = $config["date_format"];
    $this->limit = $config["limit"];
    $this->offset = $config["offset"];
  }

  private function connect($url) {
    //echo urldecode($url);
    $c = curl_init();    
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($c);
    curl_close($c);
    return $res;
  }

  public function query($option, $keyword, $dates) {
    $link = "";
    switch ($option) {
      case "overview":
        $link = $this->get("visit.day", $keyword, $dates);
        break;
      case "referrer_type":
        $link = $this->get("visit.referrertype", $keyword, $dates);
        break;
      case "partners":
        $link = $this->get("action.partnerurl", $keyword, $dates);
        break;
      case "durations":
        $link = $this->getdurations($keyword, $dates);
        break;
      case "regions":
        $link = $this->getregions($keyword, $dates);
        break;
      case "companies":
        $link = $this->get("info.org", $keyword, $dates);
        break;
      case "queries":
        $link = $this->getqueries($keyword, $dates);
        break;

      default:
        $link = $this->get("visit.day", $keyword, $dates);
    }

    return $this->connect($link);
  }

  //parameters for specific woopra data request

  private function get($option, $keyword, $dates) {
    $where = "";
    if (is_numeric($keyword)) {
      $where = "\"action.eventid='$keyword'\"";
    } else if (!empty($keyword)) {
      $where = "\"action.title='$keyword*'\"";
    } else {
      $where = "true";
    }

    $parameters = array(
        "action" => "get",
        "params" => array(
            "website" => $this->domain,
            "api_key" => $this->api_key,
            "format" => $this->format,
            "date_format" => $this->date_format,
            "start_day" => $dates["start_day"],
            "end_day" => $dates["end_day"],
            "limit" => $this->limit,
            "offset" => $this->offset,
            "query" => "SELECT visitors.count(*) as 'Visitors', visits.count(*) as 'Visits', actions.count(*) as 'Actions' FROM cloud where $where group by '$option' limit 10000 offset 0"
        )
    );
    return $this->buildurl($parameters);
  }

  //get durations

  private function getdurations($keyword, $dates) {
    $filters = "";
    if (is_numeric($keyword)) {
      $filters = "actions.any.eventid='$keyword'";
    } else {
      $filters = "actions.any.title='{$keyword}*'";
    }

    $parameters = array(
        "action" => "getvisitdurations",
        "params" => array(
            "website" => $this->domain,
            "api_key" => $this->api_key,
            "format" => $this->format,
            "date_format" => $this->date_format,
            "start_day" => $dates["start_day"],
            "end_day" => $dates["end_day"],
            "limit" => $this->limit,
            "offset" => $this->offset,
            "filters" => $filters
        )
    );
    return $this->buildurl($parameters);
  }

  
//get queries

  private function getqueries($keyword, $dates) {
    $filters = "";
    if (is_numeric($keyword)) {
      $filters = "actions.any.eventid='$keyword'";
    } else {
      $filters = "actions.any.title='{$keyword}*'";
    }

    $parameters = array(
        "action" => "getqueries",
        "params" => array(
            "website" => $this->domain,
            "api_key" => $this->api_key,
            "format" => $this->format,
            "date_format" => $this->date_format,
            "start_day" => $dates["start_day"],
            "end_day" => $dates["end_day"],
            "limit" => 30,
            "offset" => 0,
            "filters" => $filters
        )
    );
    return $this->buildurl($parameters);
  }
  
  
  
  //get regions

  private function getregions($keyword, $dates) {
    $filters = "";
    if (is_numeric($keyword)) {
      $filters = "actions.any.eventid='$keyword'";
    } else {
      $filters = "actions.any.title='{$keyword}*'";
    }

    $parameters = array(
        "action" => "getcountries",
        "params" => array(
            "website" => $this->domain,
            "api_key" => $this->api_key,
            "format" => $this->format,
            "date_format" => $this->date_format,
            "start_day" => $dates["start_day"],
            "end_day" => $dates["end_day"],
            "limit" => 8,
            "offset" => 0,
            "filters" => $filters
        )
    );
    return $this->buildurl($parameters);
  }

  //building the woopra url  

  private function buildurl($params) {
    $q = array();
    foreach ($params["params"] as $k => $v) {
      $q[] = $k . "=" . urlencode($v);
    }
    return $this->url . "/" . $params["action"] . ".jsp?" . implode("&", $q);
  }

  
  
  
  
  
  // set the eventids in the memcache
  
  public static function setEventIDs($eventid){
   if(is_numeric($eventid)){
    
    $memcache = new \Memcache;
    $memcache->connect("127.0.0.1", "11211") or die("Could not connect to memcache to set eventids.");
    $eventids = $memcache->get("eventids");

    $event_ids = explode(",", $eventids);

    $new_event_ids = array();
    foreach($event_ids as $e){
     if(is_numeric($e) && $e != $eventid){
      $new_event_ids[] = $e;
     }
    } 
    $new_event_ids[] = $eventid;
    $memcache->set("eventids", implode(",", $new_event_ids), false, 0);
    //echo $memcache->get("eventids");
   }
  }
  
  
  //THIS METHOD IS FOR THE CRON JOBS
    
  public function cron() {

  $memcache = new \Memcache;
  $memcache->connect("127.0.0.1", "11211") or die("Could not connect to memcache to run the task.");

  //get eventids

  $eventids = $memcache->get("eventids");

  if (!empty($eventids)) {
   
   $event_ids = explode(",", $eventids);
   
   $where = array();
   if (count($event_ids) > 0) {
    foreach ($event_ids as $e) {
     $where[] = "action.eventid='$e'";
    }
   }

   $where_cond = (count($where) > 0) ? '"' . implode(" or ", $where) . '"' : "true";

   $query = "SELECT visitors.count(*) as 'Visitors', visits.count(*) as 'Visits', actions.count(*) as 'Actions' FROM cloud where $where_cond group by 'action.eventid'";

   $parameters = array(
       "action" => "get",
       "params" => array(
           "website" => $this->domain,
           "api_key" => $this->api_key,
           "format" => $this->format,
           "date_format" => $this->date_format,
           "start_day" => "09/11/2011",
           "end_day" => date("d/m/Y"),
           "query" => $query
       )
   );

   $link = $this->buildurl($parameters);
   $str = $this->connect($link);
   $array = $this->xml_to_array($str, array("column0", "column1"));
   //print_r($array);
   if(isset($array["items"]) && count($array["items"]) > 0){
    foreach($array["items"] as $item){  
     
     
     $memcache->set("visitors{$item[0]}", $item[1], false, 0);
     $memcache->set("visits{$item[0]}", $item[2], false, 0);     
     echo "{$item[0]}:{$item[1]}:{$item[2]}\n";
     
    }
   }
  }
 }

 //Real time queries, use memcache to retrieve datas
  
  public static function getvisitors_realtime($keyword){
   $res = null;
   if(is_numeric($keyword)){
    $memcache = new \Memcache;
    $memcache->connect("127.0.0.1", "11211") or die("Could not connect to memcache.");
   
    $key = "visits$keyword";

    $res = $memcache->get($key);
    
   }
   
   return ($res === null)? 0 : $res;
  }
  
  
  
  
  
 //xml to array
  
 public function xml_to_array($str, $column_names=array("column0", "column1", "column2")) {
  $xml = new \SimpleXMLElement($str);

  $count = 0;
  $total = array();
  $columns = array();
  $items = array();


  if (isset($xml) && (string) $xml->attributes()->success == "true") {

   if (isset($xml->header->total)) {
    foreach ($xml->header->total->attributes() as $k => $v) {
     if (in_array($k, $column_names)) {
      $total[] = (string) $v;
     } else if ($k == "count") {
      $count = (string) $v;
     }
    }
   }



   if (isset($xml->header->columns->column)) {
    foreach ($xml->header->columns->column as $k => $v) {
     if (in_array($v->name, $column_names)) {
      $columns[] = (string) $v->title;
     }
    }
   }


   if (isset($xml->items) && count($xml->items->item) > 0) {
    foreach ($xml->items->item as $v) {
     $item = array();

     $item[] = (string) $v->name;

     foreach ($column_names as $n) {
      $item[] = (string) $v->$n;
     }

     $items[] = $item;
    }
   }
  }
  return array(
      "count" => $count,
      "total" => $total,
      "columns" => $columns,
      "items" => $items
  );
 }
  
  
}

?>