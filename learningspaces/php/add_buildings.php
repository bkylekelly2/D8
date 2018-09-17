<?php
include("/home/library/www/html/modules/learningspaces/php/classroom.php");

foreach ($buildings as $building){
	
//print_r($building); exit;
	
$data = array(
  'type' => 'building', 
  'title' => $building['name'], 
  'field_building_id' => $building['id'],   
  'field_name' => $building['name'],   
  'field_address' => $building['address'], 
  'field_hide' => $building['hideflag'],   
  'field_campus_id' => $building['campus_id'], 
  'uid' => 1
);
	
	try{
	$node = Drupal::entityManager()
	->getStorage('node')
	->create($data);
	$node->save();
	echo $building['name'];
	echo "<BR>";
	}
	
	
	catch (Exception $e) {
		echo $e.'<BR>';
	}
	
$data = "";
$node = "";
	
    
	
}

?>