<?php

$colors = array(
'#b345e0',
'#f84f13',
'#f7b9a4',
'#ffae11',
'#ffeea0',
'#fffdcf'     
);


$opts = Woopra\Woopra::$options;
$options = array_flip($opts);


$total = $res["total"];


//format items

$rows = array();
$countries = array();
$legends = array();

$items = array_slice($res["items"], 0, 6);
foreach($items as $item){
  $i=0;  
  $row = array();
  $country = "";
  
  foreach($item as $v){    
    
    if($i == 0){
     
      $row[] = $v;
      $countries[] = $v;
      $country = $v;
      
    }else{
      if($i == 2) $legends[$country] = number_format($v);
      
      //calculate percentage
      $percentage = round(floatval($v) / floatval($total[$i-1]) * 100, 2);
      
      $row[] = number_format($v) . "<br /><span class='percentage'>$percentage%</span>";
    } 
    
    
    $i++;
  }
  
  $rows[] = $row;
}




?>

<div class="map-box clearfix">
<div id="map"></div>

<div class="map-legend">
<?php 
$i = 0;
foreach($legends as $k=>$v){
?>
  <div class="clearfix">
  <div class="country-color" style="background:<?php echo $colors[$i]; ?>"></div>
  <div class="country-name"><?php echo $k; ?></div>    
  </div>
<?php  
$i++;  
}
?>
</div>
</div>


<div class="left">
<div class="stat_table">
<div class="header">
  <div class="header-element"><?php echo $title; ?></div>  

  <div class="header-element">Visitors</div>
  <div class="header-element">Visits</div>

</div>



<?php 
$j = 0;
foreach($rows as $item){ ?>

<?php 
  $class = ($j % 2 == 0)? "odd":"even";    
?>  
  
<div class="row <?php echo $class; ?>">
  <?php foreach($item as $v){ ?>
  <div class="row-element"><?php echo $v; ?></div>  
  <?php } ?>
</div>


<?php

$j++;

} 

?>


<div class="total">
  <div class="total-element"><?php echo $res["count"]; ?> rows</div>
  
  <?php   
  foreach($res["total"] as $t){ ?>
  <div class="total-element"><?php echo number_format($t); ?></div>
  <?php   
  } 
  ?>
  
</div>
  
</div>  

</div>





<?php
$js = array();
if (count($countries) > 0) {
  $i = 0;
  foreach ($countries as $c) {
    $js[] = Helper::quote(strtolower($c)) . ":" . Helper::quote($colors[$i]);
    $i++;
  }  
}
?>

<script type="text/javascript">
$(document).ready(function(){
 
    $('#map').vectorMap({
    color:'#d7ffb0',
    backgroundColor:'#ffffff',
    hoverOpacity: 0.5,
    hoverColor: false,
    colors: <?php echo "{" . implode(",", $js) . "}"; ?>
 
    
    });
});
</script>