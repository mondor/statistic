<?php
foreach($res as $r){
?>
 <div class="list-row" ref="/company/<?php echo $r->id; ?>">
 <div><?php echo $r->name; ?></div>
 <div><?php echo $r->collection_code; ?></div>
 <div><?php echo $r->state; ?></div>
 </div>
<?php
}
?>
