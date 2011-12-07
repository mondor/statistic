<?php

namespace Model;

class Role_Type extends \Orm\Model {

 protected static $_table_name = 'role_type';
 protected static $_properties = array(
     'id',
     'name'
 );
 protected static $_has_one = array('user' => array(
         'model_to' => '\\Model\\User'
         ));

}
