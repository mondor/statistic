<?php
$options = array(
     "overview" => "Overview",
     "partners" => "Partners",
     "durations" => "Durations",     
     "regions" => "Regions",     
     //"realtime" => "Live"
 );

?>

<form method="POST" id="search-form">
 
 <div class="info-box clearfix">
 <div class="info-left"> 
  <div class="fields">
  <div class="field_name">Name:</div>
  <div class="field_value"><?php echo $event->name; ?></div>
  </div>
  
  <div class="fields">
  <div class="field_name">Code:</div>
  <div class="field_value"><?php echo $event->collection_code; ?></div>
  </div>
  
  <div class="fields">
  <div class="field_name">Created at:</div>
  <div class="field_value"><?php echo Helper::date_s($event->created_at); ?></div>
  </div>
 </div>
  
 <div class="info-right" style="border-left:1px dashed #cccccc">
  <div class="fields">
  <div class="field_name">Report:</div>
  <div class="field_value">
   <select name="option" class="report_options">    
   <?php foreach($options as $opt => $name){ ?>
    <option value="<?php echo $opt; ?>" <?php if(isset($option) && $option == $opt) echo 'selected'; ?>><?php echo $name; ?></option>
   <?php } ?> 
   </select>
  </div>
  </div>
  
  <div class="fields report_by" <?php if($option != "" && $option != "overview") echo 'style="display:none;"'; ?>>
  <div class="field_name">By:</div>
  <div class="field_value">
  Daily <input type="radio" name="group_by" value="visit.day" <?php if($group_by == "visit.day" || $group_by == "") echo 'checked'; ?> style="width:20px" />      
  Monthly <input type="radio" name="group_by" value="visit.month" <?php if($group_by == "visit.month") echo 'checked'; ?>  style="width:20px" />
  </div>
  </div>
  
  
  <div class="fields">
  <div class="field_name">From:</div>
  <div class="field_value">
   <input type="text" name="start_day" value="<?php if(isset($start_day)) echo $start_day; ?>" class="datepicker" />
  </div>
  </div>
  
  
  <div class="fields">
  <div class="field_name">To:</div>
  <div class="field_value">
   <input type="text" name="end_day" value="<?php if(isset($end_day)) echo $end_day; ?>" class="datepicker" />
  </div>
  </div>
  
  </div>
 </div>
 
 
  <div class="search-box clearfix"><a class="fire_search search_button" href="javascript:void(0)">Search</a></div>
 </form> 



<div class="statistic clearfix"> 
<?php echo $content; ?>
</div> 




