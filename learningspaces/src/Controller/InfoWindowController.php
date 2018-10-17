<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\learningspaces\Service\DBService;

class InfoWindowController extends ControllerBase {

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
	
public function getRoomsList() {

	
$nids = $this->DBService->getResults();
	
foreach ($nids as $nid) {
   
	
		$node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
		$title = $node->getTitle();
		
		$buildingID = 	$node->field_building_reference->getValue()[0]['target_id'];

			$response_array[] = [
				 'roomID' => $nid,
				 'buildingID' => $buildingID,
				 'title' => $title
			   ];
}
	


//return new Response(json_encode($response_array));
return new Response(json_encode($response_array));

}

	
}
?>