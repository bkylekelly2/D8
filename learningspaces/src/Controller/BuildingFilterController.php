<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\learningspaces\Service\DBService;

class BuildingFilterController extends ControllerBase {

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
	
public function getBuildingFilter() {

$nids = $this->DBService->getBuildings();
//print_r($nids); exit;
foreach ($nids as $key => $buildingID) {

	$building = \Drupal::entityTypeManager()->getStorage('node')->load($buildingID);

	$building_filter = $building->field_filter->getValue()[0]['value'];

	$title_building = $building->getTitle();

		$response_array[] = [
				 'buildingID' => $buildingID,				 
		         'title' => $title_building,
		         'filter' => $building_filter,
			   ];
	}

//return new Response(json_encode($response_array));
return new Response(json_encode($response_array));

}

	
}
?>