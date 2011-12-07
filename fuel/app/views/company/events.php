
<form method="POST" id="search-form" style="width:100%">
<input type="hidden" name="url" value="/company/getevents/<?php echo $company->id; ?>" />
<div class="list">
Please search for an event :
<div class="list-search">
  <div><input type="text" name="name" value="<?php if(Input::post("name")) echo $name; ?>" /></div>
  <div><input type="text" name="code" value="<?php if(Input::post("code")) echo $code; ?>" /></div>
  <div></div>
  <div></div>
  <div></div>
  <div>
   <ul>
    <li><input type="text" name="created_at_from" value="<?php if(Input::post("created_at")) echo $created_at; ?>" class="datepicker"/></li>
    <li><input type="text" name="created_at_to" value="<?php if(Input::post("created_at")) echo $created_at; ?>" class="datepicker"/></li>
   </ul>
  </div>
  <div></div>
</div> 
 
<div class="list-header">
 <div>Name</div>
 <div>Code</div>
 <div>Short Name</div>
 <div>Summary</div>
 <div>Presenter</div>
 <div>Created At</div>
 <div>Tags</div>
</div> 


<div class="list-res"> 
<?php 

echo View::factory("company/getevents", array("res" => $res), false); 

?>
</div> 
 
</div>
</form> 

<form id="event_group_form">
<div class="search-box clearfix"><a class="search_button" id="fire_event_group" href="javascript:void(0)">Statistic for above events</a></div>
</form>

<div class="event_group_result statistic clearfix">
 
</div> 