<?php
//exit;
$type = "room";
$types = array('room');

$nids_query = db_select('node', 'n')
->fields('n', array('nid'))
->condition('n.type', $types, 'IN')
//->range(0, 500)
->execute();

$nids = $nids_query->fetchCol();

try{
	entity_delete_multiple('node', $nids);
	echo "successfully deleted nodes of type: " ;
	print_r($types);
}

catch (Exception $e) {
	echo "problem". '<BR>';
}
?>