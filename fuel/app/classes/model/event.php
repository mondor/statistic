<?php

namespace Model;

class Event extends \Orm\Model {

 protected static $_table_name = 'event';
 protected static $_properties = array(
     'id',
     'name',
     'collection_code',
     'short_name',
     'summary',
     'presenter',
     'presenter_image',
     'created_at',
     'tags',
     'enabled_ind'
 );
 protected static $_has_many = array('event_company' => array(
         'model_to' => '\\Model\\Event_Company',
         ));

}
