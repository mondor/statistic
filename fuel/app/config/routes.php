<?php
return array(
	'_root_'  => 'homepage/companies',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	
 'company/events/:company_id' => "company/events",
 'company/getevents/:company_id' => "company/getevents",
 'company/:company_id' => "company/index",
  
 'event/group' => "event/group",   
 'event/:event_id' => "event/index",   
   
);