<?php
namespace Drupal\nhttac_consultant_applications_block\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\nhttac_consultant_applications_block\Service\NHTTACService;

class NHTTACController extends ControllerBase {

  protected $NHTTACService;

  /**
   * @var NHTTACService
   */
  public function __construct(NHTTACService $NHTTACService) {
    $this->NHTTACService = $NHTTACService;
  }

  public static function create(ContainerInterface $container) {
    $NHTTACService = $container->get('nhttac_consultant_applications_block.nhttac_service');
    return new static($NHTTACService);
  }

  public function getApplications() {
    $results = $this->NHTTACService->getResults();


    return new Response(json_encode($results));
  }

}
