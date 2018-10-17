<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Drupal\image\Entity\ImageStyle;


class RoomController extends ControllerBase {
	
public function getRoom() {
	 
	 //retreive form values
//$request->isXmlHttpRequest(); // is it an Ajax request?

    //$request->getPreferredLanguage(array('en'));
$request = Request::createFromGlobals();

// the URI being requested (e.g. /about) minus any query parameters
$request->getPathInfo();

if ($request->request->get('roomID')<>"") {
$roomID = $request->request->get('roomID');	
}
	
// Iterate results

   
$node = \Drupal::entityTypeManager()->getStorage('node')->load($roomID);
$title = $node->getTitle();
$imageURL = ImageStyle::load('large')->buildUrl($node->field_image->entity->getFileUri());;
	
$output = '<div><img src="'.$imageURL.'" alt="'.$title.'" height="10%" width="10%">';
$output .= $title;
$output .= '</div>';

	
$output .= '<div onClick="closeModal();" style="cursor:pointer;">CloseMe</div>';


//return new Response($output);
return new Response($output);
	
	
}



}
?>