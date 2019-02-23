<?php
namespace Drupal\nhttac_consultant_type_list\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\nhttac_consultant_type_list\Service\ConsultantTypeListService;

class ConsultantTypeListController extends ControllerBase {

  protected $ConsultantTypeListService;

  /**
   * @var ConsultantTypeListService
   */
  public function __construct(ConsultantTypeListService $ConsultantTypeListService) {
    $this->ConsultantTypeListService = $ConsultantTypeListService;
  }

  public static function create(ContainerInterface $container) {
    $ConsultantTypeListService = $container->get('nhttac_consultant_type_list.consultant_service');
    return new static($ConsultantTypeListService);
  }

  public function getList() {
    $response = $this->ConsultantTypeListService->getResults();

    return $response;
  }

}
