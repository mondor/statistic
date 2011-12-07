<?php

namespace Model;

class User extends \Orm\Model {

 protected static $_table_name = 'user';
 protected static $_properties = array(
     'id',
     'username',
     'password',
     'email',
     'last_login',
     'created_at',
     'updated_at',
     'role_type_id'
 );
 protected static $_belongs_to = array(
     'role_type' => array(
         'model_to' => '\\Model\\Role_Type',
         ));
 
 protected static $_has_one = array('user_company' => array(
         'model_to' => '\\Model\\User_Company'
         ));

}
