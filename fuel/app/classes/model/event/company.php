<?php

namespace Model;

class Event_Company extends \Orm\Model {

 protected static $_table_name = 'event_company';
 protected static $_properties = array(
     'id',
     'event_id',
     'company_id'
 );
 protected static $_belongs_to = array(
     'event' => array(
         'model_to' => '\\Model\\Event',
     ),
     'company' => array(
         'model_to' => '\\Model\\Company'
     )
 );

}
