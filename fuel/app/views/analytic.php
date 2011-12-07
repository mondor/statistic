<html>
 <head>

  <?php
  echo Asset::css(array(
      'analytic.css',
      '../js/jquery-ui/css/ui-lightness/jquery-ui-1.8.16.custom.css',
      '../js/jquery.vector-map/jquery.vector-map.css'
  ));
  ?>


  <?php
  echo Asset::js(array(
      'jquery.min.js',
      'highcharts/js/highcharts.js',
      'highcharts/js/modules/exporting.js',
      'jquery-ui/js/jquery-ui-1.8.16.custom.min.js',
      'jquery.vector-map/jquery.vector-map.js',
      'jquery.vector-map/world-en.js',
      'script.js'
  ));
  ?>


  <title>Statistics</title>

 </head>
 <body>
  <div id="container">
   <div class="spinner"></div>
   <div id="report">
    <div id="header">
     <h2>Statistics</h2>
     <span class="launched">Launched: <?php echo date("D, d M Y H:ia"); ?></span>
     <span class="event">Event ID: <?php echo $eventid; ?></span>
    </div>
    


    <div class="search_form">
     <?php echo $search; ?>
    </div> 
    
    <?php if(count($contents) > 0){ ?>
    <div class="section">
     <h2>Overview</h2>
     <?php echo $contents["overview"]; ?>
    </div>

    <div class="section">
     <h2>Partners</h2>
     <?php echo $contents["partners"]; ?>
    </div>
    
    <div class="section">
     <h2>Top Search Terms</h2>
     <?php echo $contents["queries"]; ?>
    </div>    
    
    <div class="section">
     <h2>Time spent on page</h2>
     <?php echo $contents["durations"]; ?>
    </div>
    
    
    <div class="section">
     <h2>Geography</h2>
     <?php echo $contents["regions"]; ?>
    </div>    
    <?php } ?>

    

   </div>
  </div>
  <a href="javascript:void(0)" class="export">here</a>
  <script>
$(document).ready(function(){
 $(".export").click(function(){
  window.exportChart();
 });
 
}); 
</script>
 </body>
</html>
