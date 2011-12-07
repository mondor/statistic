<?php

class Controller_Common extends Controller {

 public function before() {
  parent::before();
  
  $user_id = Session::get("user_id");
  $role_type_id = Session::get("role_type_id");
  
  if(!isset($user_id) || empty($user_id)){
   Response::redirect('/user/login');
  } 

 }

}
