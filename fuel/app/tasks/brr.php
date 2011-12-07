<?php

namespace Fuel\Tasks;

use \Model\Company;
use \Model\Event;
use \Model\Event_Company;

class BRR {

 public static function sync() {

  \DB::query("set foreign_key_checks = 0")->execute();
  \DB::query("truncate event_company")->execute();
  \DB::query("truncate company")->execute();
  \DB::query("truncate event")->execute();


  $companies = file_get_contents("http://brr.local/feeds?q=getCompanies");


  $rows = json_decode($companies);
  
  

  if (count($rows) > 0) {
   foreach ($rows as $id => $obj) {
    
    $company = Company::forge(array(
                "id" => $obj->id,
                "name" => $obj->name,
                "collection_code" => $obj->code,
                "logo" => $obj->logo,
                "state" => $obj->state
            ));
    if($obj->code != "")
     $company->save();
   }
  }



  $events = file_get_contents("http://brr.local/feeds?q=getTodaysEvents");


  $rows = json_decode($events);

  if (count($rows) > 0) {
   foreach ($rows as $id => $obj) {
    $tags = implode(",", $obj->tags);
    $event = Event::forge(array(
                "id" => $obj->id,
                "name" => $obj->name,
                "short_name" => $obj->shortname,
                "collection_code" => $obj->code,
                "summary" => $obj->summary,
                "presenter" => $obj->presenter,
                "presenter_image" => $obj->thumbnail,
                "created_at" => $obj->datetime,
                "tags" => $tags,
            ));
    $event->save();
   }
  }


  $rows = \DB::query("select c.id as company_id, e.id as event_id from company c join event e on c.collection_code = e.collection_code")->execute()->as_array();
  if (count($rows) > 0) {
   foreach ($rows as $k => $a) {
    $ec = Event_Company::forge(array(
                "event_id" => $a["event_id"],
                "company_id" => $a["company_id"]
            ));
    $ec->save();
   }
  }
  
  
  \DB::query("delete from company where id not in (select company_id from event_company)")->execute();
 }

}

?>