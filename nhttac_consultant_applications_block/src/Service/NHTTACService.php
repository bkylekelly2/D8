<?php
// src/Service/NHTTACService.php
/**
 * @file
 * Contains Drupal\nhttac_consultant_applications_block\Service\NHTTACService.
 */
namespace  Drupal\nhttac_consultant_applications_block\Service;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;


class NHTTACService {

  protected $Results;

  public function __construct() {
    $this->Results = $this->returnResults();
  }

  public function  getResults(){
    return $this->Results;
  }


  private function returnResults(){

    $request = Request::createFromGlobals();
    // the URI being requested (e.g. /about) minus any query parameters
    $request->getPathInfo();

    if ($request->request->get('order')<>"") {
      $f_values = $request->request->get('input_facilities');
      $pos = strpos($f_values, ",");
    }

    $x=0;


    $query = \Drupal::entityQuery('node')
      ->condition('type', 'myotip');
    $nids = $query->execute();

    $nodes = entity_load_multiple('node', $nids);
    foreach($nodes as $node) {
      //do something
    }


    return $nodes;

  }



}
?>