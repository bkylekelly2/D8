<?php


foreach ($feature_messages as $feature_messages){
	
$data = array(
  'type' => 'message', 
  'title' => $feature_messages['name'], 
  'field_name' => $feature_messages['name'],
  'body' => $feature_messages['message'],
  'field_message_type' => 'feature',
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