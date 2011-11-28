$(document).ready(function(){

 window.showspinner = function (){
  $(".spinner").show();
 }
  
 window.hidespinner = function (){
  $(".spinner").hide();
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
  
 $('.datepicker').datepicker({
  inline: true,
  dateFormat: 'dd/mm/yy',
  changeYear: true,
  changeMonth: true,
  duration: 0
 });

});