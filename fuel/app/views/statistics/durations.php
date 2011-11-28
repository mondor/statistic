<?php

$opts = Woopra\Woopra::$options;
$options = array_flip($opts);



$total = $res["total"];


//format items

$rows = array();


$visitors = array();
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
      
      if($i == 1){
          $visitors[$name] = floatval($v);
      }else if($i == 2){
          $visits[$name] = floatval($v);
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
<div id="<?php echo $option; ?>-visitors" style="width:45%; height:200px; margin: 0 0 20px 2%; float:left;"></div>
<div id="<?php echo $option; ?>-visits" style="width:45%; height:200px; margin: 0 0 20px 2%; float:left;"></div>
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
    chart = new Highcharts.Chart({
      chart: {
        renderTo: '<?php echo $option; ?>-visitors',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false
      },
      title: {
        text: 'Visitors'
      },
      tooltip: {
        formatter: function() {
          return '<b>'+ this.point.name +'</b>:<br />'+ this.percentage.toFixed(1) +' %';
        }
      },
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
          name: 'Visitors',
          data: [<?php echo Helper::pie($visitors); ?>]
        }]
    });
  });
  
  $(document).ready(function() {
    chart = new Highcharts.Chart({
      chart: {
        renderTo: '<?php echo $option; ?>-visits',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false
      },
      title: {
        text: 'Visits'
      },
      tooltip: {
        formatter: function() {
          return '<b>'+ this.point.name +'</b>:<br />'+ this.percentage.toFixed(1) +' %';
        }
      },
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
      credits: {enabled: false},
      series: [{
          type: 'pie',
          name: 'Visits',
          data: [<?php echo Helper::pie($visits); ?>]
        }]
    });
  });  
  
</script>

