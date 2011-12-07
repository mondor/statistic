<?php

namespace Model;

class User_Company extends \Orm\Model {

 protected static $_table_name = 'user_company';
 protected static $_properties = array(
     'id',
     'user_id',
     'company_id'
 );
 protected static $_belongs_to = array(
     'user' => array(
         'model_to' => '\\Model\\User',
     ),
     'company' => array(
         'model_to' => '\\Model\\Company'
     )
 );

}
