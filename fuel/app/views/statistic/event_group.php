<?php

$total = $res["total"];

$items = $res["items"];

if (count($items) > 0) {
 usort($items, "Helper::cmp");
 $items = array_slice($items, 0, 20);
}



//format items

$rows = array();

$bars = array();

$visits = array();


foreach ($events as $event) {

 $row = array();
 $name = $event->name;
 $name = (strlen($name) > 16) ? substr($name, 0, 16) . "..." : $name;

 foreach ($items as $item) {
  if ($item[0] == $event->id) {

   $row[] = $name;
   $bars[] = $name;

   $visits[] = floatval($item[1]);

   //calculate percentage
   $percentage = round(floatval($item[1]) / floatval($total[0]) * 100, 2);

   $row[] = number_format($item[1]) . "<br /><span class='percentage'>$percentage%</span>";
  }
 }

 if (count($row) == 0) {
  $row[] = $name;
  $bars[] = $name;
  $visits[] = 0;
  $row[] = "0<br /><span class='percentage'>0%</span>";
 }
 
 $rows[] = $row;
}
?>



<div class="statistic-chart">  
<div id="event_group_chart" style="width:99%"></div>
</div>


<div class="statistic-data">
<div class="stat_table">
<div class="header">
  <div class="header-element"><?php echo $title; ?></div>    
  <div class="header-element">Visits</div>  
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
  <div class="total-element"><b>Total:</b> <?php echo number_format($total[0]); ?></div>
  
</div>
  
</div>  
</div>






<script type="text/javascript">
  

  $(document).ready(function() {
    new Highcharts.Chart({
      chart: {
        renderTo: 'event_group_chart',
        defaultSeriesType: 'column',
        margin: [ 50, 50, 100, 80],
        events: {
         load:function(){window.array.push(this);}
        }
      },
      title: {
        text: '<?php echo str_replace("'","", $title); ?>'
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
          return '<b>'+ this.x +'</b><br/>' + Highcharts.numberFormat(this.y, 0);
        }
      },
      credits: {enabled: false},
      series: [{
          name: 'Visits',
          data: [<?php echo implode(",", $visits); ?>],
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


<?php

$json = serialize($res); 

?>

<script>window.jsons.push('<?php echo $json; ?>')</script>




<!-- PARTNER -->
<?php

$partners = array();

if(count($res2["items"]) > 0){ 
 foreach($res2["items"] as $k => $item){  
  $partners[$item[0]] = floatval($item[1]);
 }
}

?>

<div class="statistic-chart">  
<div id="event_group_partners" style="width:99%"></div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    new Highcharts.Chart({
      chart: {
        renderTo: 'event_group_partners',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        events: {
         load:function(){window.array.push(this);}
        }
      },
      title: {
        text: 'Partners'
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
          data: [<?php echo Helper::pie($partners); ?>]
        }]
    });
  });
  
</script>



<?php

$json = serialize($partners); 

?>

<script>window.jsons.push('<?php echo $json; ?>')</script>



