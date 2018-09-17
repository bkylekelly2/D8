<?php

include("/home/library/www/html/modules/learningspaces/php/classroom.php");


foreach ($softwares as $software){
	
$data = array(
  'type' => 'software', 
  'title' => $software['name'], 
  'field_name' => $software['name'], 
  'field_operating_system' => $software['os'], 
  'field_software_id' => $software['id'], 
  'field_department_id' => $software['department_id'], 
  'uid' => 1
);
	
	try{
	$node = Drupal::entityManager()
	->getStorage('node')
	->create($data);
	$node->save();
	echo $software['name'];
	echo "<BR>";
	}
	
	
	catch (Exception $e) {
		echo $e.'<BR>';
	}
	
	
$data = "";
$node = "";
	
}


?>