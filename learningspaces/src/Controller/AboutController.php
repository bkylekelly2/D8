<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;


class AboutController extends ControllerBase {
	
public function getAbout(){
$output = '';	
	
include($_SERVER['DOCUMENT_ROOT']."/modules/learningspaces/php/about.php");
	
	return new Response($output);

}
	

	

	
}
?>
