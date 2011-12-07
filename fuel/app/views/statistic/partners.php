<?php

$opts = Woopra\Woopra::$options;
$options = array_flip($opts);


$total = $res["total"];


//format items

$rows = array();


$visits = array();


foreach($res["items"] as $item){  
  $i=0;  
  $row = array();
  $name = "";
  
  
  foreach($item as $v){    
    
    if($i == 0){      
      
      $row[] = $v;
      $name = $v;
      
    }else{

      $visits[$name] = floatval($v);
      
      //calculate percentage
      $percentage = round(floatval($v) / floatval($total[$i-1]) * 100, 2);      
      
      $row[] = number_format($v) . "<br /><span class='percentage'>$percentage%</span>";
                  
    } 
    
    
    $i++;
  }

  
  $rows[] = $row;
}




?>

<div class="statistic-chart">
<div id="partners" style="width:99%"></div>
</div>

<div class="statistic-data">
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
  <div class="total-element"></div>  
  <?php   
  foreach($res["total"] as $t){ ?>
  <div class="total-element"><b>Total:</b> <?php echo number_format($t); ?></div>
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
        renderTo: 'partners',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        events: {
         load:function(){window.array.push(this);}
        }
      },
      title: {
        text: '<?php echo str_replace("'","", $title); ?>'
      },
      tooltip: {
        formatter: function() {
          return '<b>'+ this.point.name +'</b>:<br />'+ this.percentage.toFixed(1) +' %';
        }
      },
      credits:{enabled: false},
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            color: '#000000',
            connectorColor: '#000000',
            formatter: function() {
              return '<b>'+ this.point.name +'</b>:<br />'+ this.percentage.toFixed(1) +' %';
            }
          }
        }
      },
      series: [{
          type: 'pie',
          name: 'Visits',
          data: [<?php echo Helper::pie($visits); ?>]
        }]
    });
  });
  
</script>



<?php

$json = serialize($res); 

?>

<script>window.jsons.push('<?php echo $json; ?>')</script>


