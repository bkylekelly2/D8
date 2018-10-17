<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Drupal\field\Entity\FieldStorageConfig;


class FrontPageController extends ControllerBase {
	
public function getFrontPage(){

include($_SERVER['DOCUMENT_ROOT']."/modules/learningspaces/php/frontPage.php");
	
	return new Response($output);

}
	

	
}
?>