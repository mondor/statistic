<?php

namespace Model;

class Company extends \Orm\Model {

 protected static $_table_name = 'company';
 protected static $_properties = array(
     'id',     
     'name',
     'collection_code',
     'logo',
     'state',
     'enabled_ind'
 );
 protected static $_has_many = array(
     'event_company' => array(
         'model_to' => '\\Model\\Event_Company',
     ),
     'user_company' => array(
         'model_to' => '\\Model\\User_Company',
     ),
 );

}
