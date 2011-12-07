<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />

    <?php
    echo Asset::css(array(
        'screen_v1.css',
        '../js/jquery-ui/css/ui-lightness/jquery-ui-1.8.16.custom.css',
        '../js/jquery.vector-map/jquery.vector-map.css'
    ));
    ?>

    
    <?php
    echo Asset::js(array(
        'jquery.min.js',
        'highcharts/js/highcharts.js',
        'jquery-ui/js/jquery-ui-1.8.16.custom.min.js',
        'jquery.vector-map/jquery.vector-map.js',
        'jquery.vector-map/world-en.js',
        'script.js'        
    ));
    ?>
    
    
    <title>Statistics</title>
  </head>
  <body>
    <div class="spinner"></div>
    <div id="wrapper">
      
      
      <!-- HEADER -->
      <div id="header">
        <h1><a href="/">BRR Media</a><span class="tagline">Analytics</span></h1>
      </div>
      <!-- /HEADER -->

      
      <!-- NAV -->
      <div id="nav">
        <ul>
          <li><a class="current" href="/">Login</a></li>
        </ul>
      </div>
      <!-- /NAV -->
      
      
      <!-- MAIN -->
      <div id="main">
        <?php echo $content; ?>
      </div>
      <!-- /MAIN -->
      
      
      <!-- FOOTER -->
      <div id="footer">
        <p>
          &copy; Copyright 2011 <a href="http://www.brr.com.au/" title="brr">www.brr.com.au</a><br />     
        </p>
      </div>
      <!-- /FOOTER -->
      
      
    </div>
  </body>
</html>

