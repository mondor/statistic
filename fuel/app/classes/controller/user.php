<?php

use Model\User;
use \Model\Role_Type;

class Controller_User extends Controller {

 public function action_logout() {
  Session::destroy();
  Response::redirect('/');
 }
 
 
 

 public function action_login() {
  $template = View::factory('login');
  if (Input::method() == "GET") {
   
  } else if (Input::method() == "POST") {
   $username = Input::post("username");
   $password = Input::post("password");

   $res = User::query()->related('role_type')
   ->where("username", $username)
   ->where("password", $password)
   ->get();
   
   
   if(count($res) > 0){
    $user = array_pop($res);
    Session::set("user_id", $user->id);
    Session::set("role_type_id", $user->role_type_id);
    Response::redirect("/");
   }
  }

  $view = View::factory("users/login", array(
      "errors"=>array()
      ), false);
  
  $template->content = $view;
  $this->response->body = $template;
 }

 
 
 
 public function action_index() {
  $data['users'] = User::find_all();
  $this->template->title = "Users";
  $this->template->content = View::forge('users/index', $data);
 }

 public function action_view($id = null) {
  $data['user'] = User::find_one_by_id($id);

  $this->template->title = "User";
  $this->template->content = View::forge('users/view', $data);
 }

 public function action_create($id = null) {
  if (Input::method() == 'POST') {
   $user = User::forge(array(
               'username' => Input::post('username'),
               'password' => Input::post('password'),
               'email' => Input::post('email'),
               'last_login' => Input::post('last_login'),
           ));

   if ($user and $user->save()) {
    Session::set_flash('notice', 'Added user #' . $user->id . '.');

    Response::redirect('users');
   } else {
    Session::set_flash('notice', 'Could not save user.');
   }
  }

  $this->template->title = "Users";
  $this->template->content = View::forge('users/create');
 }

 public function action_edit($id = null) {
  $user = User::find_one_by_id($id);

  if (Input::method() == 'POST') {
   $user->username = Input::post('username');
   $user->password = Input::post('password');
   $user->email = Input::post('email');
   $user->last_login = Input::post('last_login');

   if ($user->save()) {
    Session::set_flash('notice', 'Updated user #' . $id);

    Response::redirect('users');
   } else {
    Session::set_flash('notice', 'Could not update user #' . $id);
   }
  } else {
   $this->template->set_global('user', $user, false);
  }

  $this->template->title = "Users";
  $this->template->content = View::forge('users/edit');
 }

 public function action_delete($id = null) {
  if ($user = User::find_one_by_id($id)) {
   $user->delete();

   Session::set_flash('notice', 'Deleted user #' . $id);
  } else {
   Session::set_flash('notice', 'Could not delete user #' . $id);
  }

  Response::redirect('users');
 }

}
