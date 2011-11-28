<?php

$opts = Woopra\Woopra::$options;
$options = array_flip($opts);


$total = $res["total"];


//format items

$rows = array();


$bars = array();
$visitors = array();
$visits = array();


foreach($res["items"] as $item){  
  $i=0;  
  $row = array();


  
  
  foreach($item as $v){    
    
    if($i == 0){      
      
      $row[] = $v;
      $bars[] = $v;
      
    }else{
      
      if($i == 1){
        $visitors[] = floatval($v);
      }else if($i == 2){
        $visits[] = floatval($v);
      } 
      
      //calculate percentage
      $percentage = round(floatval($v) / floatval($total[$i-1]) * 100, 2);      
      
      $row[] = number_format($v) . "<br /><span class='percentage'>$percentage%</span>";
      
      
            
    } 
    
    
    $i++;
  }
  
  $rows[] = $row;
}




?>

<div class="right">
  
<div id="<?php echo $option; ?>" style="width:100%"></div>

</div>

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

</div>







<script type="text/javascript">
  
$(document).ready(function() {
      new Highcharts.Chart({
      chart: {
        renderTo: '<?php echo $option; ?>',
        defaultSeriesType: 'bar'
      },
      title: {
        text: '<?php echo $title; ?>'
      },
      subtitle: {
        text: ''
      },
      xAxis: {
        categories: [<?php echo implode(",", array_map("Helper::quote", $bars)); ?>],
        title: {
          text: null
        }
      },
      yAxis: {
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
      legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -100,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor: '#FFFFFF',
        shadow: true
      },
      credits: {enabled: false},
      series: [{
          name: 'Visitors',
          data: [<?php echo implode(",", $visitors); ?>]
        }, {
          name: 'Visits',
          data: [<?php echo implode(",", $visits); ?>]
        }]
    });
    
    
  });  
  
  
</script>

