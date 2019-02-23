<?php
namespace Drupal\nhttac_interactive_map\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Drupal\nhttac_interactive_map\Service\MapService;

class MapController extends ControllerBase {

  protected $MapService;

  /**
   * @var MapService
   */
  public function __construct(MapService $MapService) {
    $this->MapService = $MapService;
  }

  public static function create(ContainerInterface $container) {
    $MapService = $container->get('nhttac_interactive_map.map_service');
    return new static($MapService);
  }

  public function getMap() {
    $consultants =json_encode($this->MapService->getRequestArray());
    //$response = $this->MapService->getResults();
    $key = $this->MapService->getKey();

    include($_SERVER['DOCUMENT_ROOT']."/modules/custom/nhttac_interactive_map/php/map.php");

    $output = '';
    return new Response(($output));


  }

}
