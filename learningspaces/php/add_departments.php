<?php
include("/home/library/www/html/modules/learningspaces/php/classroom.php");

foreach ($departments as $building){
	
//print_r($building); exit;
	
$data = array(
  'type' => 'building', 
  'title' => $building['name'], 
  'field_department_id' => $building['id'],   
  'field_name' => $building['name'],  
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