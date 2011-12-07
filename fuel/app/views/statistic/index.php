<?php

 
$opts = \Woopra\Woopra::$options;


?>

<form method="POST" id="search-form">
<div class="info-box clearfix">   
    <div class="info-left">
    <div class="fields"> 
    <div class="field_name">Event ID:</div>
    <div class="field_value"><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></div>
    </div>
    
    <div class="fields"> 
    <div class="field_name">Report:</div> 
    <div class="field_value">
    <select name="option"  class="report_options">
      <?php foreach($opts as $opt => $name){ ?>      
        <option value="<?php echo $opt; ?>" <?php if($opt==$option) echo 'selected'; ?>><?php echo $name; ?></option>
      <?php } ?>
      </select>
    </div>
    </div>
 
    <div class="fields report_by" <?php if($option != "" && $option != "overview") echo 'style="display:none;"'; ?>> 
    <div class="field_name">
     By:
    </div> 
    <div class="field_value">
     Daily <input type="radio" name="group_by" value="visit.day" <?php if($group_by == "visit.day" || $group_by == "") echo 'checked'; ?> style="width:20px" />      
     Monthly <input type="radio" name="group_by" value="visit.month" <?php if($group_by == "visit.month") echo 'checked'; ?> style="width:20px" />
    </div>  
    </div>
    </div>
 
    <div class="info-right">
    <div class="fields"> 
    <div class="field_name"> 
      Start: 
    </div>
    <div class="field_value">
      <input type="text" name="start_day" value="<?php echo $start_day; ?>" class="datepicker" />
    </div>
    </div>
 
    <div class="fields"> 
    <div class="field_name">
      End: 
    </div>
    <div class="field_value">
      <input type="text" name="end_day" value="<?php echo $end_day; ?>" class="datepicker" />
    </div> 
    </div>
    </div>
</div>
</form>

<div class="search-box clearfix"><a class="fire_search search_button" href="javascript:void(0)">Search</a></div>
    
    
  <div class="stat_result clearfix">
  <?php echo $stat_result; ?>                 
  </div>
  
  