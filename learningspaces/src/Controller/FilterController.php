<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\learningspaces\Service\DBService;


class FilterController extends ControllerBase {
	
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
	
	
public function getInitialCount(){
$count = $this->DBService->InitialCount();
return new Response(json_encode($count));
}	
public function getUpdateCount(){
$count = $this->DBService->UpdateCount();
return new Response(json_encode($count));
}
	

	
}
?>
