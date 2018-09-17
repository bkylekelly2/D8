<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\learningspaces\Service\FormService;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;


class FormController extends ControllerBase {
	
protected $FormService;
protected $ContentService;
  

public static function create(ContainerInterface $container){
     $ContentService = $container->get('learningspaces.content_service');
     $FormService = $container->get('learningspaces.form_service');
     return new static($ContentService,$FormService);
}
	
public function __construct($ContentService, $FormService){
    $this->ContentService = $ContentService;
    $this->FormService = $FormService;
}
	
public function displayForm(){

	$output = '';	
	$spaceTypes = $this->ContentService->svcStudySpaceTypes();
	$studyTypes = $this->ContentService->svcSpaceTypes();
	$noiseExpectations = $this->ContentService->svcNoiseExpectations();
	$Amenities = $this->ContentService->svcAmenities();
	$Technology = $this->ContentService->svcTechnology();
	$Furniture = $this->ContentService->svcFurniture();
	$Campus = $this->ContentService->svcCampus();
	$AccessType = $this->ContentService->svcAccessType();
	
	include($_SERVER['DOCUMENT_ROOT']."/modules/learningspaces/php/addSpace.php");
	
	return new Response($output);

}
	
public function processForm(){
$error = false;	
$request = Request::createFromGlobals();
$request->getPathInfo();
$nodeID = $request->request->get('nodeID');
$title = $request->request->get('title');
if ($title==''){
$error = true;
$errors .= '<BR>Title is required.';
}
	
$access = $request->request->get('access');

if ($access==''){
$error = true;
$errors .= '<BR>Access Type is required.';
}
	
$capacity = $request->request->get('capacity');

if ($capacity==''){
$error = true;
$errors .= '<BR>Capacity is required.';
}
	
$floor = $request->request->get('floor');

if ($floor==''){
$error = true;
$errors .= '<BR>Floor is required.';
}
	
$room = $request->request->get('room');

if ($room==''){
$error = true;
$errors .= '<BR>Room is required.';
}
	
$buildingID = $request->request->get('building');

if ($buildingID==''){
$error = true;
$errors .= '<BR>Building is required.';
}
	
$campusID = $request->request->get('campus');

if ($campusID==''){
$error = true;
$errors .= '<BR>Campus is required.';
}
	
$amenity = $request->request->get('amenity');

if ($amenity==''){
$error = true;
$errors .= '<BR>Amenity is required.';
}
	
$furniture = $request->request->get('furniture');

if ($furniture==''){
$error = true;
$errors .= '<BR>Furniture is required.';
}
	
$space = $request->request->get('space');

if ($space==''){
$error = true;
$errors .= '<BR>Space is required.';
}
	
$study = $request->request->get('study');

if ($study==''){
$error = true;
$errors .= '<BR>Study is required.';
}
	
$technology = $request->request->get('technology');

if ($technology==''){
$error = true;
$errors .= '<BR>Technology is required.';
}
	
$noise = $request->request->get('noise');

if ($noise==''){
$error = true;
$errors .= '<BR>Noise is required.';
}
	
$reservation = $request->request->get('reservation');
	
if ($reservation==''){
$error = true;
$errors .= '<BR>Reservation is required.';
}
	
$notes = $request->request->get('notes');

if ($notes==''){
$error = true;
$errors .= '<BR>Notes is required.';
}
	
$interior = $request->request->get('interior');
	
if ($interior==''){
$error = true;
$errors .= '<BR>Interior is required.';
}
	
$image = $request->request->get('image');
	
//if ($image==''){
//$error = true;
//$errors = '<BR>Image is required.';
//}
	
$publish = $request->request->get('spacepublish');

//do validation and error checking
if ($error){
	header('Location: /form?errors='.$errors);
	exit;
	return new Response($e='');
}

// Create file object from remote URL.
if ($nodeID==''){
	
$data = file_get_contents('/core/themes/bartik/logo.svg');
$file = file_save_data($data, 'public://druplicon.png', FILE_EXISTS_REPLACE);
$uid = \Drupal::currentUser()->id();

	$node = Node::create([
		'type'        => 'room',
		'title'       => $title,
		'field_capacity' => $capacity, 
		'field_floor' => $floor, 
		'field_room_number' => $room, 
		'field_reservation_information' => $reservation, 
		'field_notes' => $notes, 
		'field_interior_location' => $interior, 
		'field_access_type' => $access, 
	    'field_image' => [
		'target_id' => $file->id(),
		'alt' => 'Hello world',
		'title' => 'Goodbye world',
		'height' => '4000',
		'width' => '6000'
		],
		'status' => $publish, 
		'uid' => $uid, 
	  ]);
	
		try {
  		// Create node object with attached file.

  		$node->save();
		$nodeID = $node->id();

		}
		catch (Exception $e) {
		return new Response($e);	
		}
	/*
		$updatenode = \Drupal::entityManager()->getStorage('node')->load($nodeID); 

		$furniture_values = explode(",",$furniture);
		$furniture_count = count($furniture_values);
		foreach($furniture_values as $furniture_value){
			$title = str_replace("_"," ",$furniture_value);
			$query = \Drupal::entityQuery('node')
				->condition('type', 'furniture') 
				->condition('status', 1)
				->condition('title', $title, '=');
				$results = $query->execute();

			foreach ($results as $key => $val) {
				$updatenode->field_furniture_reference[] = $val; //add an element to the furniture reference
			}
		}

		$amenity_values = explode(",",$amenity);
		$amenity_count = count($amenity_values);
		foreach($amenity_values as $amenity_value){
			$title = str_replace("_"," ",$amenity_value);
			$query = \Drupal::entityQuery('node')
				->condition('type', 'amenities') 
				->condition('status', 1)
				->condition('title', $title, '=');
				$results = $query->execute();

			foreach ($results as $key => $val) {
				$updatenode->field_amenities_reference[] = $val; 
			}
		}

		$noise_values = explode(",",$noise);
		$noise_count = count($noise_values);
		foreach($noise_values as $noise_value){
			$title = str_replace("_"," ",$nosie_value);
			$query = \Drupal::entityQuery('node')
				->condition('type', 'noise_expectation') 
				->condition('status', 1)
				->condition('title', $title, '=');
				$results = $query->execute();

			foreach ($results as $key => $val) {
				$updatenode->field_noise_expectation_ref[] = $val; 
			}
		}

		$technology_values = explode(",",$technology);
		$technology_count = count($technology_values);
		foreach($technology_values as $technology_value){
			$title = str_replace("_"," ",$technology_value);
			$query = \Drupal::entityQuery('node')
				->condition('type', 'technology') 
				->condition('status', $publish)
				->condition('title', $title, '=');
				$results = $query->execute();

			foreach ($results as $key => $val) {
				$updatenode->field_technology_reference[] = $val; //add an element to the technology reference
			}
		}
	
		$updatenode->field_noise_expectation_ref[] = $noise; 
		$updatenode->field_building_reference[] = $building; 
		$updatenode->field_campus_reference[] = $campus; 
		$updatenode->field_type_of_space_reference[] = $space;
		$updatenode->field_type_of_study_space_ref[] = $study; 
		$updatenode->save();
	*/
	//header('Location: /list');
	header('Location: /form?nodeID'.$nodeID);
	exit;
	return new Response($e='');
	//return new Response($nodeID);	
} else {
	
	$node = Node::load($nodeID);
	//set value for field
	$node->title = $title;
	$node->field_department = $department;
	$node->field_event_session_type = $session;
	$node->field_course_number = $courseNumber;
	$node->field_recurring_event = $isRecurring;
	$node->field_dow = $dow;
	$node->unpublish_on = $date_unpublish;
	
	$node->field_date_regular = $date_regular;
	$node->field_date_exception = $date_exception;
	$node->field_date_exception_2 = $date_exception_2;
	
	$node->field_date_regular_2 = $date_regular_2;
	$node->field_regular_location_2 = $regular_location_2;
	
	$node->field_time_start_regular = $time_start_regular;
	$node->field_time_end_regular = $time_end_regular;
	
	$node->field_time_start_exception = $time_start_exception;
	$node->field_time_end_exception = $time_end_exception;
	
	$node->field_exception_location = $exception_location;
	$node->field_regular_location = $regular_location;
	
	$node->field_exception_location_2 = $exception_location_2;
	$node->field_regular_location_2 = $regular_location_2;

	if ($status==1){
		$node->setPublished(TRUE);
	} else {
		$node->setPublished(FALSE);
	}

	try {
	$node->save();
	//drupal_set_message(t('You have updated Peer Coaching Event '.$title), 'status');
	header('Location: /list?message=You have updated '.$title);
	exit;
	return new Response($e='');	
	
	}

	catch (Exception $e) {
	return new Response($e);	
	}
	
	
	
	
}
		
}
	
	

	
}
?>
