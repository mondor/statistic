<form method="POST" id="search-form">

  <div class="search clearfix">
    <div class="search-text">Please enter the event ID:</div>
    <div class="search-input"><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></div>
    <div class="search-text">Dates:</div>
    <div class="search-options">     
     <div class="search-dates">
      <input type="text" name="start_day" value="<?php echo $start_day; ?>" class="datepicker" />      
      <input type="text" name="end_day" value="<?php echo $end_day; ?>" class="datepicker" />
     </div>
     
     <div class="search-button"><a href="javascript:void(0)" class="fire_search">Search</a></div>
    </div>
    
    
    <?php if(!empty($hash)){ ?>
    <a href="<?php echo Config::get('base_url'); ?>history/<?php echo $hash; ?>.html" target="_blank">
    <?php echo $hash; ?>.html
    </a>
    <?php } ?>
  </div>  
  
</form>  