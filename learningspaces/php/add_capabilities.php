<?php
include("/home/library/www/html/modules/learningspaces/php/classroom.php");

//print_r($room_capabilities); exit;
foreach ($capabilities as $room){
	
$data = array(
  'type' => 'capability', 
  'title' => $room['name'], 
  'field_name' => $room['name'], 
  'field_capability_id' => $room['id'], 
  'uid' => 1
);
	
	try {
	$node = Drupal::entityManager()
	->getStorage('node')
	->create($data);
	$node->save();
	echo $room['name'];
	echo "<BR>";
	}
	catch (Exception $e) {
			echo $e. '<BR>';
		}
	
$data = "";
$node = "";
	
}
?>