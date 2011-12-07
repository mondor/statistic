<?php

    

if(Session::get("role_type_id") == "1"){
 $items[] = array("Statistic" => "/homepage/companies");
 $items[] = array("Search" => "/statistic/index");
}



if(Session::get("role_type_id") == "2"){
 $items[] = array("Events" => "/homepage/events");
}

$items[] = array("Logout" => "/user/logout");

?>


<ul>

 <?php if(Session::get("role_type_id") == "1"){ ?>
 <li>
  <a <?php if(in_array($from, array("company-index","homepage-companies", "company-events", "event-index"))) echo 'class="current"'; ?> href="/homepage/companies">Statistic</a>
 </li> 
 
 <li>   
  <a <?php if(in_array($from, array("statistic-index"))) echo 'class="current"'; ?> href="/statistic/index">Search</a>
 </li>  
 <?php } ?>
 
 <li>   
  <a href="/user/logout">Logout</a>
 </li>  
 
</ul>



