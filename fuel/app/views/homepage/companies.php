

<form method="POST" id="search-form" action="/homepage/getcompanies" style="width:100%"> 
<input type="hidden" name="url" value="/homepage/getcompanies" /> 

<div class="list">
 Search for a company :
<div class="list-search">
  <div><input type="text" name="name" value="<?php echo $name; ?>" /></div>
  <div><input type="text" name="collection" value="<?php echo $collection; ?>" /></div>
  <div></div>
</div>

 
<div class="list-header">
 <div>Company</div> 
 <div>Code</div>
 <div>State</div>
</div> 



<div class="list-res"> 
<?php 

echo View::factory("homepage/getcompanies", array("res" => $res), false); 

?>  
</div>
 
</div>

</form> 