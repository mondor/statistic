<div id="<?php echo $option; ?>" style="width: 800px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">
		
			
 Highcharts.setOptions({
  global: {
   useUTC: false
  }
 });
				

 $(document).ready(function() {
  new Highcharts.Chart({
   chart: {
    renderTo: '<?php echo $option; ?>',
    defaultSeriesType: 'spline',
    marginRight: 10,
    events: {
     load: function() {
				
      // set up the updating of the chart each second
      var series = this.series[0];
      setInterval(function() {       
       $.ajax({
        url: '/statistic/getvisitors/?eventid=<?php echo $keyword; ?>', 
        success: function(data) {
         x = (new Date()).getTime();
         y = parseInt(data);
         series.addPoint([x, y], true, true);
        }
       });       
      }, 4000);
     }
    }
   },
   title: {
    text: 'Live Visitors'
   },
   xAxis: {
    type: 'datetime',
    tickPixelInterval: 150
   },
   yAxis: {
    allowDecimals: false,
    title: {
     text: 'Taffic'
    },
    plotLines: [{
      value: 0,
      width: 1,
      color: '#808080'
     }]
   },
   tooltip: {
    enabled:false
   },
   legend: {
    enabled: false
   },
   exporting: {
    enabled: false
   },
   credits: {
    enabled: false
   },
   series: [{
     name: 'Taffics',
     data: (function() {
      // generate an array of random data
      var data = [],
      time = (new Date()).getTime(),
      i;
							
      for (i = -19; i <= 0; i++) {
       data.push({
        x: time + i * 4000,
        y: parseInt(0)
       });
      }
      return data;
     })()
    }]
  });
				
				
 });
				
</script>