window.array = [];
window.jsons = [];

$(document).ready(function(){

 window.showspinner = function (){
  $(".spinner").show();
  $(".overlay").show();
 }
  
 window.hidespinner = function (){
  $(".spinner").hide();
  $(".overlay").hide();
 } 
   
  
 $(".fire_search").live("click", function(e){
  window.showspinner();
  $("#search-form").submit();   
 });
  
 $("input[name=keyword]").keypress(function(event){
  if ( event.which == 13 ) {
   return false;
  }  
 });
  
  
 var delay = (function(){
  var timer = 0;
  return function(callback, ms){
   clearTimeout (timer);
   timer = setTimeout(callback, ms);
  };
 })();

 
 $(".list-search input:not(.datepicker)").keyup(function(){
  delay(function(){
   window.showspinner();
   url = $("#search-form input[name=url]").val();  
   $.ajax({
    url: url,
    type: "POST",
    data: $("#search-form").serialize(),
    success: function(data){
     $(".list-res").html(data);
     window.hidespinner();
    }
   });
  }, 1000 );
 }); 
 
 $(".list-search .datepicker").change(function(){
  go = 1;
  $(".list-search .datepicker").each(function(){
   if($(this).val() == ""){
    go = 0;
   }
  });
  
  if(go == 1){
   delay(function(){
    window.showspinner();
    url = $("#search-form input[name=url]").val();  
    $.ajax({
     url: url,
     type: "POST",
     data: $("#search-form").serialize(),
     success: function(data){
      $(".list-res").html(data);
      window.hidespinner();
     }
    });
   }, 1000 );
  }
 }); 
 
  
 $('.datepicker').datepicker({
  inline: true,
  dateFormat: 'dd/mm/yy',
  changeYear: true,
  changeMonth: true,
  duration: 0
 });

 $(".list-row").live("click", function(){
  window.showspinner();
  location.href = $(this).attr("ref");
 });
 
 
 
 window.exportChart = function () {
  var svgs = [];
    
  $.each(window.array, function(i, chart) {   
   svg = chart.getSVG(); 
   svgs.push(svg);        
  }); 
   
  if($("#map").length){ 
   html = $("#map").html();  
   begin = html.indexOf("<g transform=");
   end = html.indexOf("</svg>");  
   content = html.substring(begin, end);  
   content = '<svg xmlns:xlink="http://www.w3.org/1999/xlink" height="400" width="800" version="1.1" xmlns="http://www.w3.org/2000/svg">' + content + '</svg>';  
   svgs.push(content);
  }
    
  
  $.ajax({
   url: "http://statistic.local/assets/js/highcharts/exporting-server/",
   type: "POST",
   async: false,
   data: {
    svgs:svgs, 
    jsons:window.jsons
   }    
  });
  
 }


 $(".report_options").change(function(){
  if($(".report_options option:selected").val().match(/overview/)){
   $(".report_by").show();
  }else{
   $(".report_by").hide();
  }
 });
 
 
 $("#fire_event_group").live("click", function(){
  window.showspinner();
  
  
  eventids = [];
  $(".eventid").each(function(){
   id = $(this).attr("id");
   eventids.push(id);
  });
  
  $.ajax({
   url:"/event/group",
   type:"POST",
   data:{ eventids: eventids, start_day:$("input[name=created_at_from]").val(), end_day:$("input[name=created_at_to]").val() },
   success:function(data){
    $(".event_group_result").html(data);
    window.hidespinner();
   }
  });
  
 });

});