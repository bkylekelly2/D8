<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\learningspaces\Service\DBService;

class RoomsController extends ControllerBase {

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

public function getRooms() {
	 
$nids = $this->DBService->getResults();

// Iterate results

	
	//$nids = array_unique($nids);
	$output = '<div style="overflow-y: scroll;">';
	
foreach ($nids as $nid) {
   
	
		$node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
		$title = $node->getTitle();
	
	   $output .= '<div class="showModal" onClick="getRoom('.$nid.')"  style="">'. $title ."</div>";

	$response_array[] = [
		         'roomID' => $nid,
		         'title' => $title,
			   ];
	
}

   $output .= "</div>";

//return new Response($output);
return new Response(json_encode($response_array));
	
	
}

	
}
?>