<?php

use \Model\Company;
use \Model\Event;

class Controller_Homepage extends Controller_Common {

 public function action_index() {
  
 }

 public function action_companies() {

  $res = array();

  $name = $collection = null;

  if (Input::method() == "POST") {
   $res = $this->getCompanies();
  }

  $view = View::factory("homepage/companies", array("res" => $res, "name" => $name, "collection" => $collection), false);
  $menu = View::factory("menu", array("from" => "homepage-companies"), false);

  $template = View::factory("template", array(
              "menu" => $menu,
              "content" => $view,
              "title" => "Statistic"), false);

  $this->response->body = $template;
 }

 public function action_getcompanies() {
  $res = $this->getCompanies();
  $view = View::factory("homepage/getcompanies", array("res" => $res), false);
  $this->response->body = $view;
 }

 private function getCompanies() {
  if (Input::method() == "POST") {
   $res = array();

   $name = Input::post("name");

   $collection = Input::post("collection");

   if ($name != "" || $collection != "") {
    $sql = Company::query();

    if ($name != "")
     $sql->where("name", "like", "$name%");

    if ($collection != "")
     $sql->where("collection_code", "like", "$collection%");

    $res = $sql->get();
   }
   return $res;
  }
 }

}
