<?php


foreach ($software_messages as $software_messages){
	
$data = array(
  'type' => 'message', 
  'title' => $software_messages['name'], 
  'field_name' => $software_messages['name'],
  'body' => $software_messages['message'],
  'field_message_type' => 'software',
  'uid' => 1
);
	
$node = Drupal::entityManager()
  ->getStorage('node')
  ->create($data);
$node->save();
	
$data = "";
$node = "";
	
}


?>