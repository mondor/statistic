<?php
$options = array(
    "company_overview" => "Overview",
    "company_pageview" => "Pageview duration",
    "company_events" => "Popular events",
);

?>



<div class="info-box clearfix">
 <div class="company-logo"><img src="<?php echo $company->logo; ?>" /></div> 
 <form method="POST" id="search-form"> 
 
 <div class="info-left"> 
  <div class="fields">
  <div class="field_name">Name:</div>
  <div class="field_value"><?php echo $company->name; ?></div>
  </div>
  
  <div class="fields">
  <div class="field_name">Collection Code:</div>
  <div class="field_value"><?php echo $company->collection_code; ?></div>
  </div>
  
  <div class="fields">
  <div class="field_name">State:</div>
  <div class="field_value"><?php echo $company->state; ?></div>
  </div>
 </div>
  
 <div class="info-right">
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

  <div class="fields report_by" <?php if($option != "" && $option != "company_overview") echo 'style="display:none;"'; ?>>
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
 
 

 </form> 
 </div>

<div class="search-box clearfix"><a class="fire_search search_button" href="javascript:void(0)">Search</a></div>


 


 
<div class="statistic clearfix">
<?php if(isset($stats["company_chart"])) echo $stats["company_chart"]; ?> 
</div> 
 
 