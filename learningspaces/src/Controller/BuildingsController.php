<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\learningspaces\Service\DBService;

class BuildingsController extends ControllerBase {

  protected $DBService;
  
    /**
     * @var DBService
     */
    public function __construct(DBService $DBService){
        $this->DBService = $DBService;
    }
	
    public static function create(ContainerInterface $container){
        $DBService = $container->get('learningspaces.db_service');
        return new static($DBService);
    }
	
public function getBuildings() {
$response_array=[];
$theresults = $this->DBService->getResults();
//print_r($theresults); exit;

foreach ($theresults as $key => $roomID) {

	$room = \Drupal::entityTypeManager()->getStorage('node')->load($roomID);
	$buildingID = $room->field_building_reference->getValue()[0]['target_id'];
	$buildings=[];

			
	if (!in_array($buildingID,$buildings)){
		$campusID = $room->field_campus_reference->getValue()[0]['target_id'];
		$building = \Drupal::entityTypeManager()->getStorage('node')->load($buildingID);
		if (!empty($building->field_address) && (isset($building->field_address->getValue()[0])) ){
		$address = $building->field_address->getValue()[0]['value'];
		} else{
			$address='';
		}
		if (!empty($building->field_lattitude) && (isset($building->field_lattitude->getValue()[0])) ) {
		$lattitude = $building->field_lattitude->getValue()[0]['value'];
		} else {
			$lattitude = '';
		}
		if (!empty($building->field_longitude) && (isset($building->field_longitude->getValue()[0]))){
		$longitude = $building->field_longitude->getValue()[0]['value'];
		} else {
			$longitude = '';
		}
		if (!empty($building->title)){
		$title_building = $building->getTitle();
		}
		//now iterate through the rooms and get an array of unique buildings
		$buildings[]=$buildingID;
		$response_array[] = [
				 'buildingID' => $buildingID,				 
				 'campusID' => $campusID,				 
		         'title_building' => $title_building,
		         'address' => $address,
		         'lattitude' => $lattitude,
		         'longitude' => $longitude,
		         'address' => $address,
			   ];
		}
	}

//return new Response(json_encode($response_array));
return new Response(json_encode($response_array));

}

	
}
?>