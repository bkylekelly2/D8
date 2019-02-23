<?php
// src/Service/ConsultantTypeListService.php
/**
 * @file
 * Contains Drupal\nhttac_consultant_type_list\Service\NHTTACService.
 */
namespace  Drupal\nhttac_consultant_type_list\Service;


class ConsultantTypeListService {

  protected $Results;

  public function __construct() {
    $this->Results = $this->returnResults();
  }

  public function  getResults(){
    return $this->Results;
  }


  private function returnResults(){

//first get requests that are approved or completed
//next get events per request
//next get assigned consultants - paragraph nodID
//next get uid associated with paragraph nodeID
//last get consultant types - consultant application nodeIDs associated with UID



$connection = \Drupal::database();

//first get requests that are approved or completed
$sql="
SELECT node_field_data.type AS node_field_data_type, node__field_tta_training_event.field_tta_training_event_target_id AS node__field_tta_training_event_field_tta_training_event_targ
FROM node_field_data node_field_data
LEFT JOIN content_moderation_state_field_revision content_moderation_state ON node_field_data.vid = content_moderation_state.content_entity_revision_id AND (content_moderation_state.content_entity_type_id = 'node' AND content_moderation_state.langcode = node_field_data.langcode)
LEFT JOIN node__field_tta_training_event node__field_tta_training_event ON node_field_data.nid = node__field_tta_training_event.entity_id AND node__field_tta_training_event.deleted = '0'
WHERE (node_field_data.type IN ('tta_request')) AND ( (content_moderation_state.workflow = 'tta_request') OR (content_moderation_state.moderation_state = 'completed') )
";

    $query = $connection->query($sql);
    $request_array = $query->fetchAll();
    // Iterate results

    $title= '';

    foreach ($request_array as $request) {
      if ($request->node__field_tta_training_event_field_tta_training_event_targ<>null) {
        $event_array[] = $request->node__field_tta_training_event_field_tta_training_event_targ;
      }
    }


        //next get assigned consultants (paragraph nodeID)
        foreach ($event_array as $eventID) {
          if ($eventID <> null) {

            $node = \Drupal::entityTypeManager()->getStorage('node')->load($eventID);

            if ( (isset($node)) && ($node<>null)  ) {

              $nCount = count($node->field_tta_assgnd_consltnts->getValue())-1;

              for ($x = 0; $x <= $nCount; $x++) {
                $consultant_array[] = $node->field_tta_assgnd_consltnts->getValue()[$x]['target_id'];
              }


            }
          }
        }



            //next get consultantid associated with paragraph nodeID
            foreach ($consultant_array as $cID) {
              $sql = 'SELECT `field_tta_consultant_target_id` as nid FROM `paragraph__field_tta_consultant` WHERE `entity_id` = ' . $cID . ' ';
              $query = $connection->query($sql);
              $results = $query->fetchAll();
              // Iterate results
              foreach ($results as $uID) {
                $uid_array[] = $uID->nid;
              }
            }




            //next get nid associated with paragraph uid of type consultant application
            foreach ($uid_array as $uID) {
              $sql = 'SELECT `nid`, `type` FROM `node_field_data` WHERE `uid` = ' . $uID . ' ';
              $query = $connection->query($sql);
              $results = $query->fetchAll();
              // Iterate results
              foreach ($results as $typeID) {
                if ($typeID->type=='consultant_application') {
                  $nid_array[] = $typeID->nid;
                }
              }
            }


    $sCount = 0;
    $eCount = 0;
    $seCount = 0;

            //next get consultant types
            foreach ($nid_array as $nID) {

              $node = \Drupal::entityTypeManager()->getStorage('node')->load($nID);

              if ( (isset($node)) && ($node<>null)  ) {

                $nCount = count($node->field_ca_type_of_con_app->getValue())-1;

                for ($x = 0; $x <= $nCount; $x++) {

                  if ($node->field_ca_type_of_con_app->getValue()[$x]['value']=='Survivor Consultant'){
                    $sCount++;
                  }
                  if ($node->field_ca_type_of_con_app->getValue()[$x]['value']=='Expert Consultant'){
                    $eCount++;
                  }
                  if ($node->field_ca_type_of_con_app->getValue()[$x]['value']=='Survivor Expert Consultant'){
                    $seCount++;
                  }
                }

              }

            }

$output = '<section class="col-lg-12 col-sm-9">
  
  
  <a id="main-content"></a>
  <div class="region region-content">
  
  <div class="row bs-1col-stacked">
  
  
  
  <div class="col-lg-12 bs-region bs-region--main"
  <div class="block-region-main"><section class="views-element-container contextual-region block block-views block-views-blockmyotip-block-3 clearfix">
  
  
  <div class="form-group"><div class="contextual-region ">
  
   <div class="view-content">
  <div class="table-responsive">
  <table class="table table-hover table-striped">
  <thead>
  <tr>
  <th id="view-moderation-state-table-column" class="views-field views-field-moderation-state" scope="col"><div id="type" style="cursor:pointer;">Type of Consultant</div></th>
  <th id="view-field-consultant-active-table-column" class="views-field views-field-field-consultant-active" scope="col"><div id="active" class="" style="cursor:pointer;"># of Consultants</div></th>
  </tr>
  </thead>
  <tbody>';

$output .= '
  <tr>
  <td headers="view-moderation-state-table-column" class="views-field views-field-moderation-state">Survivor</td>
  <td headers="view-field-consultant-active-table-column" class="views-field views-field-field-consultant-active">'.$sCount.'</td>
  </tr>
  <tr>
  <td headers="view-moderation-state-table-column" class="views-field views-field-moderation-state">Expert</td>
  <td headers="view-field-consultant-active-table-column" class="views-field views-field-field-consultant-active">'.$eCount.'</td>
  </tr>
  <tr>
  <td headers="view-moderation-state-table-column" class="views-field views-field-moderation-state">Survivor Expert</td>
  <td headers="view-field-consultant-active-table-column" class="views-field views-field-field-consultant-active">'.$seCount.'</td>
  </tr>
';


$output.='
</tbody>
</table>
</div>

</div>

<div class="pager-bottom">

</div>
</div>
</div>

</section>';



    return $output;

  }



}