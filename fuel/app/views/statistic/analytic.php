<?php

 
$opts = Woopra\Woopra::$options;


?>


<form method="POST" id="search-form">

  <div class="search clearfix">
    <div class="search-text">Please enter the event ID or event name:</div>
    <div class="search-input"><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></div>
    <div class="search-options">
      <select name="option">
      <?php foreach($opts as $opt => $name){ ?>      
        <option value="<?php echo $opt; ?>" <?php if($opt==$option) echo 'selected'; ?>><?php echo $name; ?></option>
      <?php } ?>
      </select>
     
     <div class="search-dates">
      Start: <input type="text" name="start_day" value="<?php echo $start_day; ?>" class="datepicker" />
      
      End: <input type="text" name="end_day" value="<?php echo $end_day; ?>" class="datepicker" />
     </div>
    </div>
    <div class="search-button"><a href="javascript:void(0)" class="fire_search">Search</a></div>
    
    <?php if(!empty($hash)){ ?>
    <a href="<?php echo Config::get('base_url'); ?>history/<?php echo $hash; ?>.html" target="_blank">
    <?php echo $hash; ?>.html
    </a>
    <?php } ?>
  </div>

    
  <div class="stat_result clearfix">
  <?php echo $stat_result; ?>                 
  </div>
  </div>
  
</form>  

