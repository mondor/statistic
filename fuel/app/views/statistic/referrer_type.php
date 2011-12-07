<?php

$opts = Woopra\Woopra::$options;
$options = array_flip($opts);


$total = $res["total"];


//format items

$rows = array();


$bars = array();


$visits = array();


foreach($res["items"] as $item){  
  $i=0;  
  $row = array();
  
  foreach($item as $v){    
    
    if($i == 0){      
      
      $row[] = $v;
      $bars[] = $v;
      
    }else{
      $visits[] = floatval($v);
      
      //calculate percentage
      $percentage = round(floatval($v) / floatval($total[$i-1]) * 100, 2);      
      
      $row[] = number_format($v) . "<br /><span class='percentage'>$percentage%</span>";
      
      
            
    } 
    
    
    $i++;
  }
  
  $rows[] = $row;
}




?>

  
<div id="referrer" style="width:100%"></div>


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
  
<div class="row <?php echo $class; ?> <?php echo $item[0]; ?>">
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








<script type="text/javascript">
  
$(document).ready(function() {
     new Highcharts.Chart({
      chart: {
        renderTo: 'referrer',
        defaultSeriesType: 'bar',
        events: {
         load:function(){window.array.push(this);}
        }
      },
      title: {
        text: '<?php echo str_replace("'","", $title); ?>'
      },
      subtitle: {
        text: ''
      },
      xAxis: {
        allowDecimals: false,
        categories: [<?php echo implode(",", array_map("Helper::quote", $bars)); ?>],
        title: {
          text: null
        }
      },
      yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
          text: 'Traffic',
          align: 'high'
        }
      },
      tooltip: {
        formatter: function() {
          return ''+
            this.series.name +': '+ Highcharts.numberFormat(this.y, 0);
        }
      },
      plotOptions: {
        bar: {
          dataLabels: {
            enabled: true
          }
        }
      },
      
      credits: {enabled: false},
      series: [{
          name: 'Visits',
          data: [<?php echo implode(",", $visits); ?>]
        }]
    });
    
    
  });  
  
  
</script>



<?php

$json = serialize($res); 

?>

<script>window.jsons.push('<?php echo $json; ?>')</script>



