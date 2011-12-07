<?php
$eventids = array();

$i = 0;
foreach($res as $r){
 
 $eventids[] = $r->id;
 $class = ($i % 2 == 0)? "even":"odd";
?>
 <div class="list-row eventid <?php echo $class; ?>" id="<?php echo $r->id; ?>" ref="/event/<?php echo $r->id; ?>">
 <div><?php echo $r->name; ?></div>
 <div><?php echo $r->collection_code; ?></div>
 <div><?php echo $r->short_name; ?></div>
 <div><?php echo $r->summary; ?></div>
 <div><?php echo $r->presenter; ?></div>
 <div><?php echo Helper::date_s($r->created_at); ?></div>
 <div><?php echo $r->tags; ?></div>
 </div>

<?php
$i++;
}
?>

