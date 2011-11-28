<?php

$opts = Woopra\Woopra::$options;
$options = array_flip($opts);


$total = $res["total"];

$items = $res["items"];

if(count($items)>0){
  usort($items, "Helper::cmp");
  $items = array_slice($items,0,10);  
}



//format items

$rows = array();


$bars = array();
$visitors = array();
$visits = array();


foreach($items as $item){  
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
  
<div id="<?php echo $option; ?>-queries" style="width:100%"></div>

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
        renderTo: '<?php echo $option; ?>-queries',
        defaultSeriesType: 'column',
        margin: [ 50, 50, 100, 80]
      },
      title: {
        text: '<?php echo $title; ?>'
      },
      xAxis: {
        categories: [<?php echo implode(",", array_map("Helper::quote", $bars)); ?>],
        labels: {
          rotation: -45,
          align: 'right',
          style: {
            font: 'normal 10px'
          }
        }
      },
      yAxis: {
        min: 0,
        title: {
          text: 'Traffic'
        }
      },
      legend: {
        enabled: false
      },
      tooltip: {
        formatter: function() {
          return '<b>'+ this.x +'</b><br/>' + Highcharts.numberFormat(this.y, 1);
        }
      },
      credits: {enabled: false},
      series: [{
          name: 'Visitors',
          data: [<?php echo implode(",", $visitors); ?>],
          dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            x: -3,
            y: 10,
            formatter: function() {
              return this.y;
            },
            style: {
              font: 'normal 10px'
            }
          }			
        }]
    });
    
    
  });
  
</script>

