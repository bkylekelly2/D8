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

	$theresults = $this->DBService->getResults();
	

foreach ($theresults as $roomID) {

	$room = \Drupal::entityTypeManager()->getStorage('node')->load($roomID);
	//$title_room = $room->getTitle();
	$buildingID = $room->field_building_reference->getValue()[0]['target_id'];
	
	$building = \Drupal::entityTypeManager()->getStorage('node')->load($buildingID);
	$address = $building->field_address->getValue()[0]['value'];
	$lattitude = $building->field_lattitude->getValue()[0]['value'];
	$longitude = $building->field_longitude->getValue()[0]['value'];
	$title_bulding = $building->getTitle();
			
	
	$response_array[$buildingID][] = [
				 'buildingID' => $buildingID,				 
		         'title_building' => $title_building,
		         'address' => $address,
		         'lattitude' => $lattitude,
		         'longitude' => $longitude,
			   ];
}

return new Response(json_encode($response_array));

}

	
}
?>