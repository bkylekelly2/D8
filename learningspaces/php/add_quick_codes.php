<?php

include("/home/library/www/html/modules/learningspaces/php/classroom.php");

foreach ($quickcodes as $code){
	
$data = array(
  'type' => 'quick_code', 
  'title' => $code['name'], 
  'field_name' => $code['name'], 
  'field_quick_code_id' => $code['id'],
  'field_software_id' => $code['software_id'],
  'uid' => 1
);
	
	try{
	$node = Drupal::entityManager()
	->getStorage('node')
	->create($data);
	$node->save();
	echo $code['name'];
	echo "<BR>";
	}
	catch (Exception $e) {
		echo $e.'<BR>';
	}
	
$data = "";
$node = "";
	
}


?>