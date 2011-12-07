<?php

use \Woopra\Woopra;
use \Model\Company;
use \Model\Event;

class Controller_Company extends Controller_Common {

 private function getOverview($company, $option, $start_day, $end_day, $group_by) {
  $config = Config::load("woopra");
  $w = new Woopra($config["woopra"]);

  $xml = null;
  $stats = $res = array();

  $stats["company"] = $company;

  if (Input::method() == "POST") {

   switch ($option) {
    case "company_overview":
     $str = $w->query("company_overview", $company->id, $start_day, $end_day, $group_by);
     $res = $w->xml_to_array($str);


     //get total visits
     if (isset($res) && isset($res["total"][0]))
      $stats["company_report"] = $res["total"][0];

     $stats["company_chart"] = View::factory("statistic/overview", array("title" => "{$company->name} Overview", "res" => $res), false);
     break;


    // pageviews
    case "company_pageview":

     $str = $w->query("company_pageview", $company->id, $start_day, $end_day);
     $res = $w->xml_to_array($str);

     //get max page view durations
     if (isset($res["items"])) {
      $max = 0;
      $durations = "";
      foreach ($res["items"] as $i) {
       if ($max < $i[2]) {
        $max = $i[2];
        $durations = $i[0];
       }
      }
      $stats["company_report"] = $durations;
     }


     $stats["company_chart"] = View::factory("statistic/durations", array("title" => "Overall Durations", "res" => $res), false);

     break;

    // popular events

    case "company_events":

     $str = $w->query("company_events", $company->id, $start_day, $end_day);
     $res = $w->xml_to_array($str);

     //get event name from event id

     $new_items = array();
     if (isset($res["items"])) {
      $max = 0;
      $popular_event = "";
      foreach ($res["items"] as $i) {
       $event_id = $i[0];
       $name = "";
       $event = Event::query()->where("id", "=", $event_id)->get_one();
       $name = ($event)? $event->name : $event_id;
       
       $new_items[] = array($name, $i[1]);

       if ($max < $i[1]) {
        $max = $i[1];
        $popular_event = $name;
       }
      }
      $res["items"] = $new_items;
      $stats["company_report"] = $popular_event;
     }

     $stats["company_chart"] = View::factory("statistic/company_events", array("title" => "Popular Events", "res" => $res), false);
     break;
   }
  }

  return $stats;
 }

 public function action_index() {

  $company = array();

  $menu = $view = $sub_menu = $title = $option = $start_day = $end_day = $group_by = null;

  $company_id = $this->param("company_id");

  $option = Input::post("option");
  $start_day = (Input::post("start_day")) ? Input::post("start_day") : date("d/m/Y", mktime(0, 0, 0, date("m"), date("d") - 6, date("Y")));
  $end_day = (Input::post("end_day")) ? Input::post("end_day") : date("d/m/Y");
  $group_by = Input::post("group_by");

  if ($company_id) {

   $company = Company::query()->where("id", "=", $company_id)->get_one();

   if ($company) {
    $title = $company->name;
    $view = View::factory("company/index", array(
                "company" => $company,
                "stats" => $this->getOverview($company, $option, $start_day, $end_day, $group_by),
                "option" => $option,
                "start_day" => $start_day,
                "end_day" => $end_day,
                "group_by" => $group_by
                    ), false);
    $menu = View::factory("menu", array("from" => "company-index"), false);
    $sub_menu = View::factory("company/sub_menu", array("company_id" => $company_id), false);
   }
  }


  $template = View::factory("template", array(
              "menu" => $menu,
              "sub_menu" => $sub_menu,
              "content" => $view,
              "title" => "Statistic > <span>" . $title . "</span>"), false);

  $this->response->body = $template;
 }

 public function action_events() {
  $company_id = $this->param("company_id");

  if ($company_id) {
   $company = Company::query()->where("id", "=", $company_id)->get_one();

   $events = $this->getEvents($company_id);

   if ($company) {
    $title = "Statistic > <span>{$company->name}</span>";
    $view = View::factory("company/events", array("res" => $events, "company" => $company), false);
    $menu = View::factory("menu", array("from" => "company-events"), false);
    $sub_menu = View::factory("company/sub_menu", array("company_id" => $company_id), false);
   }
  }

  $template = View::factory("template", array("menu" => $menu, "sub_menu" => $sub_menu, "content" => $view, "title" => $title), false);

  $this->response->body = $template;
 }

 public function action_getevents() {
  $company_id = $this->param("company_id");
  $res = $this->getEvents($company_id);
  $view = View::factory("company/getevents", array("res" => $res), false);
  $this->response->body = $view;
 }

 public function getEvents($company_id) {

  $res = array();

  $name = Input::post("name");
  $code = Input::post("code");
  $created_at_from = Helper::s_date(Input::post("created_at_from"));
  $created_at_to = Helper::s_date(Input::post("created_at_to"));


  $sql = Event::query()->related("event_company")
          ->where("event_company.company_id", "=", $company_id)
          ->order_by("t0.created_at", "desc");



  if ($name != "")
   $sql->where("t0.name", "like", "$name%");

  if ($code != "")
   $sql->where("t0.collection_code", "like", "$code%");


  if ($created_at_from != "" && $created_at_to != "") {
   $sql->where("t0.created_at", ">=", $created_at_from);
   $sql->where("t0.created_at", "<=", $created_at_to);
  }



  //echo $sql->get_query();
  $res = $sql->get();

  return $res;
 }

}
