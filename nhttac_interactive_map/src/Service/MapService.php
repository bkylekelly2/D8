<?php
// src/Service/MapService.php
/**
 * @file
 * Contains Drupal\nhttac_interactive_map\Service\MapService.
 */
namespace  Drupal\nhttac_interactive_map\Service;


class MapService {

  protected $Results;
  protected $Key;
  protected $RequestArray;
  protected $Locations;

  public function __construct() {
    $this->Results = $this->returnResults();
    $this->Key = $this->returnKey();
    $this->RequestArray = $this->returnRequestArray();
    $this->Locations = $this->returnLocations();
  }

  public function getResults() {
    return $this->Results;
  }

  public function getKey() {
    return $this->Key;
  }

  public function getRequestArray() {
    return $this->RequestArray;
  }

  public function getLocations() {
    return $this->Locations;
  }


  private function returnKey(){
    $key = '';
    return $key;
  }

private function getLongLat($address){

  $key = $this->returnKey();
  $stub = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address."&key=".$key;
  $payload = file_get_contents($stub);
  $payload = json_decode($payload);
  $lng =  ($payload->results[0]->geometry->location->lng);
  $lat =  ($payload->results[0]->geometry->location->lat);

  $longlat[]=$lng;
  $longlat[]=$lat;

  return $longlat;

}

private function returnResults(){

$connection = \Drupal::database();

$sql="SELECT node__field_ca_address.field_ca_address_locality AS city, node__field_ca_address.field_ca_address_administrative_area AS state, node__field_ca_address.field_ca_address_address_line1 AS address, node__field_ca_address.field_ca_address_postal_code AS zipcode, node_field_data.nid AS nid
FROM
node_field_data node_field_data
LEFT JOIN content_moderation_state_field_revision content_moderation_state ON node_field_data.vid = content_moderation_state.content_entity_revision_id AND (content_moderation_state.content_entity_type_id = 'node' AND content_moderation_state.langcode = node_field_data.langcode)
LEFT JOIN node__field_consultant_active node__field_consultant_active ON node_field_data.nid = node__field_consultant_active.entity_id AND node__field_consultant_active.deleted = '0'
LEFT JOIN node__field_ca_address node__field_ca_address ON node_field_data.nid = node__field_ca_address.entity_id AND node__field_ca_address.deleted = '0'
LEFT JOIN content_moderation_state_field_revision content_moderation_state_1 ON node_field_data.vid = content_moderation_state_1.content_entity_revision_id AND (content_moderation_state_1.content_entity_type_id = 'node' AND content_moderation_state_1.langcode = node_field_data.langcode)
WHERE (node_field_data.type IN ('consultant_application')) AND (node_field_data.type IN ('consultant_application')) AND ((content_moderation_state.workflow = 'consultant_application_moderation') AND (content_moderation_state.moderation_state = 'approved')) AND (node__field_consultant_active.field_consultant_active_value = '1')
";

  $query = $connection->query($sql);
  $results = $query->fetchAll();
  return $results;
}

private function returnRequestArray(){

$results = $this->returnResults();

    foreach ($results as $result) {

      $node = \Drupal::entityTypeManager()->getStorage('node')->load($result->nid);
      $title = $node->getTitle();

      if ( !$node->field_ca_type_of_con_app == null ){
        $toc = $node->field_ca_type_of_con_app->getValue()[0]['value'];
      }


      if ( !$node->field_ca_top_area_con_app_tta == null ){

        $aoe_count = count($node->field_ca_top_area_con_app_tta->getValue());

        for ($x = 0; $x <= ($aoe_count-1); $x++) {
          $ID = $node->field_ca_top_area_con_app_tta->getValue()[$x]['target_id'];
          $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($ID);
          $term = $term->getName();
          $aoe .= $term.", ";
        }
        $aoe = rtrim($aoe,", ");
      }




      $address = str_replace(" ","+", $result->address);
      $city = str_replace(" ","+", $result->city);
      $state = $result->state;

      $addressToreturn = $address.",+".$city.",+".$state;

      $longlat = $this->getLongLat($addressToreturn);

      $alias = $node->toUrl()->toString();

      $request_array[] = [
        'nodeID' => $result->nid,
        'title' => $title,
        'city' => $result->city,
        'state' => $result->state,
        'address' => $result->address,
        'zipcode' => $result->zipcode,
        'lng' => $longlat[0],
        'lat' => $longlat[1],
        'type_of_consultant' => $toc,
        'url' => $alias,
        'areas' => $aoe,
      ];

    }

    return $request_array;


  }

//[{lat: -31.563910, lng: 147.154312}]

  private function returnLocations() {

    $requestArray = $this->returnRequestArray();


    $output = '[';

    foreach ($requestArray as $request){

      $output .= '{';
      $output .= 'lat: '.$request['lattitude'];
      $output .= ', lng: '.$request['longitude'];
      $output .= '},';


    }


    $output = rtrim($output,",");

    $output .= ']';

    return $output;


  }



}
