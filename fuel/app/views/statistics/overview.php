<?php
 
$opts = Woopra\Woopra::$options;
$options = array_flip($opts);


$total = $res["total"];


//format items

$rows = array();

$items = array_reverse($res["items"]);

if (count($items) > 0) {
  

 
 foreach ($items as $item) {
   
  $i = 0;
  $row = array();
  foreach ($item as $v) {

   if ($i == 0) {

    $str = Helper::format_overview_dates($v);
    $row[] = $str;
    
    
   } else {

     
    //calculate percentage
    $percentage = round(floatval($v) / floatval($total[$i-1]) * 100, 2);

    $row[] = number_format($v) . "<br /><span class='percentage'>$percentage%</span>";
   }


   $i++;
  }

  $rows[] = $row;
 }
 
}




?>

<div class="right"><div id="<?php echo $option; ?>-area" style="width: 100%; height: 400px;"></div></div>


<div class="left">
<div class="stat_table">
<div class="header">
  <div class="header-element"><?php echo $title; ?></div>  
  <?php foreach($res["columns"] as $c){ ?>
  <div class="header-element"><?php echo $c; ?></div>
  <?php } ?>
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
  <div class="total-element">Total: <?php echo number_format($t); ?></div>
  <?php 
  } 
  ?>
  
</div>
  
</div>  

</div>





<div style="clear:both"></div>
<?php

$xy = Helper::xy($items);

$xs = array();
if(isset($xy[0]) && count($xy[0]) > 0){
foreach($xy[0] as $v){
  $xs[] = Helper::format_overview_dates($v, "dS M");
}
}
?>


<script type="text/javascript">
  
$(document).ready(function() {
  
    
    
    new Highcharts.Chart({
      chart: {
        renderTo: '<?php echo $option; ?>-area',
        defaultSeriesType: 'area'
      },
      title: {
        text: '<?php echo $title; ?>'
      },
      subtitle: {
        text: ''
      },
      xAxis: {
        categories: [<?php  if(isset($xy[0])) echo implode(",", array_map("Helper::quote", $xs)); ?>],
        tickmarkPlacement: 'on',
        title: {
          enabled: false
        }
      },
      yAxis: {
        title: {
          text: 'Traffic'
        },
        labels: {
          formatter: function() {
            return this.value;
          }
        }
      },
      tooltip: {
        formatter: function() {
          return ''+
            this.x +': '+ Highcharts.numberFormat(this.y, 0, ',');
        }
      },
      plotOptions: {
        area: {
          stacking: null,
          lineColor: '#666666',
          lineWidth: 1,
          marker: {
            lineWidth: 1,
            lineColor: '#666666'
          }
        }
      },
      credits: {enabled: false},
      series: [{
          name: 'Visits',
          data: [<?php if(isset($xy[2])) echo implode(",", $xy[2]); ?>]
        }, {
          name: 'Visitors',
          data: [<?php if(isset($xy[1])) echo implode(",", $xy[1]); ?>]
        }]
    });
    
    
  });
  
  

</script>