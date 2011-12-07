<?php

use Model\User;
use Model\Role_Type;



class Controller_Index extends Controller_Common {
 
 
 public function action_companies(){
  die();
  $template = View::factory('template');
  
  
  if (Input::method() == "POST"){
   $key = Input::post("keyword");
   
   $res = Company::query()->where("name", "like", "$key%")->get();
           
 }else{
  
 }
  die(); 
   //$view =  View::factory("indexes/companies", array("res" => $res), false);
   //$template->content = $view;
   $this->response->body = $template;
 } 
 
 
 
 }
 
 ?>