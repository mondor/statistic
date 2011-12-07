<?php


use Woopra\Woopra;

class Controller_Statistic extends Controller_Common {

 public function action_index() {
  
 
  $stat_result = $keyword = $option = $start_day = $end_day = $hash = $group_by = null;

  if (Input::method() == "POST") {

   $keyword = Input::post("keyword");
   $option = Input::post("option");
   $group_by = Input::post("group_by");
   $start_day = (Input::post("start_day")) ? Input::post("start_day") : date("d/m/Y", mktime(0, 0, 0, date("m"), date("d") - 6, date("Y")));
   $end_day = (Input::post("end_day")) ? Input::post("end_day") : date("d/m/Y");


   $res = null;
   switch ($option) {
    case 'realtime' :
     $this->prepare_realtime($keyword);
     break;
    default:
     $res = $this->stat_xml($option, $keyword, $start_day, $end_day, $group_by);
   }

   
   //render stat result

   $stat_result = View::factory("statistic/$option", array(
               "title" => Woopra::$options[$option],
               "res" => $res,
               "option" => $option,
               "keyword" => $keyword
               ), false);


   // generate a hash file
   $hash = md5(time());
  } 

  $view = View::factory("statistic/index", array(
              "stat_result" => $stat_result,
              "start_day" => $start_day,
              "end_day" => $end_day,
              "keyword" => $keyword,
              "option" => $option,
              "hash" => $hash,
              "group_by" => $group_by 
                  ), false);

  $menu = View::factory("menu", array("from" => "statistic-index"), false);
  
  $template =  View::factory("template", array(
              "menu" => $menu,
              "content" => $view,
              "title" => "Search"), false);

  $this->response->body = $template;
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

 public function stat_xml($option, $keyword, $start_day, $end_day, $group_by) {
  
  $config = Config::load("woopra");
  
  $w = new Woopra($config["woopra"]);

  $xml = null;
  $res = null;

  try {
   $str = $w->query($option, $keyword, $start_day, $end_day, $group_by);
   $res = $w->xml_to_array($str);
  } catch (Exception $e) {}

  return $res;
 }

 //prepare - set event id in the memcache

 public function prepare_realtime($keyword) {
  Woopra::seteventids($keyword);
 }

 public function action_getvisitors() {
  $eventid = Input::get("eventid");
  echo Woopra::getvisitors_realtime($eventid);
  die();
 }

}
