<?php

function p($a) {
 echo "<pre>";
 print_r($a);
 echo "</pre>";
}

class Controller_Statistic extends Controller {

 public function action_index() {
  $template = View::factory('template');
  $keyword = $option = $start_day = $end_day = $hash = null;

  if (Input::method() == "POST") {

   $keyword = Input::post("keyword");
   $option = Input::post("option");
   $start_day = (Input::post("start_day")) ? Input::post("start_day") : date("d/m/Y", mktime(0, 0, 0, date("m"), date("d") - 6, date("Y")));
   $end_day = (Input::post("end_day")) ? Input::post("end_day") : date("d/m/Y");


   //date range     
   $dates = array("start_day" => $start_day, "end_day" => $end_day);

   $res = null;
   switch ($option) {
    case 'durations':
    case 'regions' :
    case 'queries' :
     $res = $this->stat_xml($option, $keyword, $dates, array("vtrs", "vts"));
     break;
    case 'realtime' :
     $this->prepare_realtime($keyword);
     break;
    default:
     $res = $this->stat_xml($option, $keyword, $dates, array("column0", "column1"));
   }

   //render stat result

   $stat_result = View::factory("statistics/$option", array(
               "title" => Woopra\Woopra::$options[$option],
               "res" => $res,
               "option" => $option,
               "keyword" => $keyword
                   ), false);


   // generate a hash file
   $hash = md5(time());
  } else {

   $stat_result = "";
  }

  $index = View::factory("statistics/index", array(
              "stat_result" => $stat_result,
              "start_day" => $start_day,
              "end_day" => $end_day,
              "keyword" => $keyword,
              "option" => $option,
              "hash" => $hash
                  ), false);

  $template->content = $index;

  $this->response->body = $template;
 }
 
 
 //analytic template

 public function action_analytic() {
  $keyword = $start_day = $end_day = $hash = null;

  $contents = array();

  if (Input::method() == "POST") {

   $keyword = Input::post("keyword");
   $start_day = (Input::post("start_day")) ? Input::post("start_day") : date("d/m/Y", mktime(0, 0, 0, date("m"), date("d") - 6, date("Y")));
   $end_day = (Input::post("end_day")) ? Input::post("end_day") : date("d/m/Y");


   //date range     

   $dates = array("start_day" => $start_day, "end_day" => $end_day);


   //query all      
   $res = array();


   $options = array(
       "overview" => "Overview",
       "partners" => "Partners",
       "durations" => "Durations",
       "regions" => "Regions",
       "queries" => "Queries"
   );

   foreach ($options as $option => $value) {

    switch ($option) {
     case 'durations':
     case 'regions' :
     case 'queries' :
      $res[$option] = $this->stat_xml($option, $keyword, $dates, array("vtrs", "vts"));
      break;
     default:
      $res[$option] = $this->stat_xml($option, $keyword, $dates, array("column0", "column1"));
    }


    //render stat result

    $contents[$option] = View::factory("statistics/$option", array(
                "title" => $options[$option],
                "res" => $res[$option],
                "option" => $option), false);
   }



   // generate a hash file
   $hash = md5(time());
  }

  //the search view
  $search = View::factory("_search", array(
              "start_day" => $start_day,
              "end_day" => $end_day,
              "keyword" => $keyword,
              "hash" => $hash), false);

  $analytic = View::factory("analytic", array(
              "search" => $search,
              "contents" => $contents,
              "title" => "",
              "eventid" => $keyword
                  ), false);


  if (Input::method() == "POST") {
   $this->savereport($hash, $contents, "", $keyword);
  }

  $this->response->body = $analytic;
 }

 
 
 //save the report
 
 private function savereport($hash, $contents, $title, $eventid) {
  $analytic = View::factory("analytic", array(
              "search" => "",
              "contents" => $contents,
              "title" => $title,
              "eventid" => $eventid), false);

  //save search result in html format

  if (Input::method() == "POST") {
   file_put_contents(DOCROOT . "/history/" . $hash . ".html", $analytic->render());
  }
 }

 //get stat in xml format

 public function stat_xml($option, $keyword, $dates, $columns) {
  $name = "Woopra\Woopra";

  $w = new $name(array(
              "url" => "http://api.woopra.com/rest/analytics",
              "domain" => "brr.com.au",
              "api_key" => "9LMSCGMKTL",
              "format" => "xml",
              "date_format" => "dd/MM/yyyy",
              "limit" => "10000",
              "offset" => "0"
          ));



  $xml = null;
  $res = null;

  try {
   $str = $w->query($option, $keyword, $dates);
   $res = $w->xml_to_array($str, $columns);
  } catch (Exception $e) {
   
  }

  return $res;
 }

 //prepare - set event id in the memcache

 public function prepare_realtime($keyword) {
  Woopra\Woopra::seteventids($keyword);
 }

 public function action_getvisitors() {
  $eventid = Input::get("eventid");
  echo Woopra\Woopra::getvisitors_realtime($eventid);
  die();
 }

}
