<?php
//exit;
include("/home/library/www/html/modules/learningspaces/php/classroom.php");
//use Drupal\node\Entity\Node;

//print_r($rooms); exit;

foreach ($rooms as $room){
	
	$buildingID = $room['building_id'];
	$quickcodeID = $room['quickcode_id'];
//echo $buildingID; exit;
	
	$query = \Drupal::entityQuery('node')
	->condition('type', 'building') 
    ->condition('status', 1)
    ->condition('field_building_id', $buildingID, '=');
	$nid = $query->execute();
	
	foreach ($nid as $key2 => $val) {
		$bID = $val;
	}
	
	
//echo $bID; exit;
$node = \Drupal::entityManager()->getStorage('node')->load($bID); 
//	print_r($node);
//	exit;
 
$building = $node->field_name->getValue();
	//print_r($building); exit;
	
	$title = "Building: ". $building[0]['value'] ." - Rm: " .$room['name'];

	
$data = array(
  'type' => 'room', 
  'title' => $title, 
  'field_name' => $room['name'], 
  'field_contracted' => $room['contracted'], 
  'field_capacity' => $room['capacity'], 
  'field_room_id' => $room['id'], 
  'field_building_id' => $room['building_id'], 
  'field_quick_code_id' => $room['quickcode_id'], 
  'field_documentation' => $room['documentation_link'],   
  'field_room_id' => $room['id'], 
  'field_hide' => $room['hideflag'], 
  'field_building_reference' => $bID, 
  'uid' => 1
);



try {
	$node = Drupal::entityManager()
	->getStorage('node')
	->create($data);
	$node->save();
	echo "save successful for: name ". $room['name']. '<BR>';
	echo "save successful for: contracted ". $room['contracted']. '<BR>';
	echo "save successful for: capacity ". $room['capacity']. '<BR>';
	echo "save successful for: id ". $room['id']. '<BR>';
	echo "save successful for: building_id ". $room['building_id']. '<BR>';
	echo "save successful for: quickcode_id ". $room['quickcode_id']. '<BR>';
	echo "save successful for: documentation_link ". $room['documentation_link']. '<BR>';
	print_r($sIDs)."<BR>";
	print "<HR>";
}
catch (Exception $e) {
	echo "problem". '<BR>';
}
	
$data = "";
$node = "";
	
	
	
	
	//break;
	
}

/*
	$node = Node::load($nid);     
    $node->field_campus_reference[] = $user_id;
    $node->save();
	
$data = "";
*/

?>