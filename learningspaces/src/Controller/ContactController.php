<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;


class ContactController extends ControllerBase {
	
public function getContact(){
$output = '';	
	
include($_SERVER['DOCUMENT_ROOT']."/modules/learningspaces/php/contact.php");
	
	return new Response($output);

}
	

	

	
}
?>
