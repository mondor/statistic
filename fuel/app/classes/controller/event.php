<?php

use \Woopra\Woopra;
use \Model\Company;
use \Model\Event;



class Controller_Event extends Controller {

 public function action_index() {
  $start_day = $end_day = $group_by = $option = null;
  $res = array();
  $content = "";


  //get event info
  $event_id = $this->param("event_id");
  $event = Event::query()->related("event_company")->related("event_company.company")->where("t0.id", "=", $event_id)->get_one();
          
  
  list($id, $event_company) = each($event->event_company);
  
  if(Input::method() == "POST"){
   

  $start_day = (Input::post("start_day")) ? Input::post("start_day") : date("d/m/Y", mktime(0, 0, 0, date("m"), date("d") - 6, date("Y")));
  $end_day = (Input::post("end_day")) ? Input::post("end_day") : date("d/m/Y");
  $option = Input::post("option");
  $group_by = Input::post("group_by");

  $config = Config::load("woopra");

  $w = new Woopra($config["woopra"]);

  $options =   array("overview" => "Overview", "partners" => "Partners", "durations" => "Durations", "regions" => "Regions"); 
  
  //find all the statistic reports
  
   switch ($option) {
    case 'durations':
    case 'regions' :
    case 'queries' :
     $str = $w->query($option, $event_id, $start_day, $end_day);
     $xml = $w->xml_to_array($str);
     $res = $xml;
     break;
    default:
     $str = $w->query($option, $event_id, $start_day, $end_day, $group_by);
     $xml = $w->xml_to_array($str);
     $res = $xml;
   }


   //render stat result
   $content = View::factory("statistic/$option", array(
               "title" => $options[$option],
               "res" => $res,
               "option" => $option), false);
  

   }


  //the search view
  $view = View::factory("event/index", array(
              "start_day" => $start_day,
              "end_day" => $end_day,
              "content" => $content,
              "group_by" => $group_by,
              "option" => $option,
              "event" => $event
      ), false);

  $template = View::factory("template", array(
              "menu" => View::factory("menu", array("from" => "event-index"), false),
              "sub_menu" => View::factory("company/sub_menu", array("company_id" => $event_company->company_id), false),
              "content" => $view,
              "title" => "Statistic > {$event_company->company->name} > <span>{$event->name}</span>"), false);

  $this->response->body = $template;
 }
 
 
 
 
 public function action_group(){

  if(Input::method() == "POST"){
    $config = Config::load("woopra");
    $w = new Woopra($config["woopra"]);
    
    $eventids = Input::post("eventids");
    $start_day = Input::post("start_day");
    $end_day = Input::post("end_day");
    
    if(count($eventids) > 0){          
     $sql = Event::query();
     foreach($eventids as $id){
      $sql->or_where("id","=",$id);
     }
     
     $events = $sql->get();
     
     //woopra
     $ids = array();
     foreach($eventids as $id){
      $ids[] = "action.eventid='$id'";
     }
     
     $where_str = '"' . implode(" or ", $ids) . '"';
     
     //event total
     $str = $w->query("event_group", $where_str, $start_day, $end_day);
     $res = $w->xml_to_array($str);
     
     //event partnerurl
     $str2 = $w->query("event_group_partner", $where_str, $start_day, $end_day);
     $res2 = $w->xml_to_array($str2);
     
     $this->response->body = View::factory("statistic/event_group", array("title" => "Visits", "res" => $res, "res2" => $res2, "events" => $events), false);
    }
    
  }

 }

}