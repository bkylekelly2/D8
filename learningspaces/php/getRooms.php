<?php

function getRooms(){
	$query = \Drupal::entityQuery('node')
	->condition('type', 'room')
	->range(0,5);
$title_nids = $query->execute();
 	foreach ($title_nids as $nid) {
		$node = \Drupal::entityManager()->getStorage('node')->load($nid);
		$title = $node->title->getValue()[0]['value'];

  		$output .= $title."<BR>"; 
	
	
	} 
	
	return $output;

}?>
