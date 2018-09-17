<?php

namespace Drupal\learningspaces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\learningspaces\Service\ContentService;


class FrontPageController extends ControllerBase {
	
  protected $ContentService;
  
    /**
     * @var ContentService
     */
    public function __construct(ContentService $ContentService){
        $this->ContentService = $ContentService;
    }
	
    public static function create(ContainerInterface $container){
        $ContentService = $container->get('learningspaces.content_service');
        return new static($ContentService);
    }
	
	
public function getFrontPage(){
$output = '';	
$spaceTypes = $this->ContentService->svcStudySpaceTypes();
$noiseExpectations = $this->ContentService->svcNoiseExpectations();
$Amenities = $this->ContentService->svcAmenities();
$Technology = $this->ContentService->svcTechnology();
$Furniture = $this->ContentService->svcFurniture();
//$Software = $this->ContentService->svcSoftware();
	
include($_SERVER['DOCUMENT_ROOT']."/modules/learningspaces/php/frontPage.php");
	
	return new Response($output);

}
	
public function getFrontPageTest(){
$output = '';	
$spaceTypes = $this->ContentService->svcStudySpaceTypes();
$noiseExpectations = $this->ContentService->svcNoiseExpectations();
$Amenities = $this->ContentService->svcAmenities();
$Technology = $this->ContentService->svcTechnology();
$Furniture = $this->ContentService->svcFurniture();
//$Software = $this->ContentService->svcSoftware();
	
include($_SERVER['DOCUMENT_ROOT']."/modules/learningspaces/php/frontPageTest.php");
	
	return new Response($output);

}
	
public function getCategoryTitles(){

$spaceTypes = $this->ContentService->svcStudySpaceTypes();
$noiseExpectations = $this->ContentService->svcNoiseExpectations();
$Amenities = $this->ContentService->svcAmenities();
$Technology = $this->ContentService->svcTechnology();
$Furniture = $this->ContentService->svcFurniture();
	
	$response_array[] = [
				 'spaceTypes' => $spaceTypes,				 
				 'noiseExpectations' => $noiseExpectations,				 
		         'amenities' => $Amenities,
		         'technology' => $Technology,
		         'furniture' => $Furniture,
			   ];
	

	return new Response(json_encode($response_array));

}
	
}
?>
