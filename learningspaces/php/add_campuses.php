<?php
include("/home/library/www/html/modules/learningspaces/php/classroom.php");

//print_r($campuses); exit;
foreach ($campuses as $room){
	
$data = array(
  'type' => 'campus', 
  'title' => $room['name'], 
  'field_name' => $room['name'], 
  'field_campus_id' => $room['id'], 
  'field_short_name' => $room['shortname'], 
  'uid' => 1
);
	
$node = Drupal::entityManager()
  ->getStorage('node')
  ->create($data);
$node->save();
	
$data = "";
$node = "";
	
	echo $room['name'];
	echo "<BR>";
	
}
?>