<?php
// src/Service/NHTTACService.php
/**
 * @file
 * Contains Drupal\nhttac_consultant_applications_block\Service\CAService.
 */
namespace  Drupal\nhttac_consultant_applications_block\Service;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Database\Database;


class CAService {

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
    $order='';
    $nids=[];

    $status_sort="ASC";
    $active_sort="ASC";
    $title_sort="ASC";
    $location_sort="ASC";

    if ($request->request->get('query')<>"") {
      $query = $request->request->get('query');
    } else {
      $query = 'status';
    }

    if ($request->request->get('sort')<>"") {
      $sort = $request->request->get('sort');
    } else {
      $sort = 'ASC';
    }




    switch($query){
      case 'status';
          $sql = 'SELECT node__field_ca_address.field_ca_address_locality AS node__field_ca_address_field_ca_address_locality, node__field_ca_address.field_ca_address_administrative_area AS node__field_ca_address_field_ca_address_administrative_area, node_field_data.nid AS nid, users_field_data_node_field_data.uid AS users_field_data_node_field_data_uid
          FROM
          {node_field_data} node_field_data
          INNER JOIN {users_field_data} users_field_data_node_field_data ON node_field_data.uid = users_field_data_node_field_data.uid
          INNER JOIN {user__roles} users_field_data_node_field_data__user__roles ON users_field_data_node_field_data.uid = users_field_data_node_field_data__user__roles.entity_id AND users_field_data_node_field_data__user__roles.deleted = \'0\'
          LEFT JOIN {content_moderation_state_field_revision} content_moderation_state ON node_field_data.vid = content_moderation_state.content_entity_revision_id AND (content_moderation_state.content_entity_type_id = \'node\' AND content_moderation_state.langcode = node_field_data.langcode)
          LEFT JOIN {node__field_ca_address} node__field_ca_address ON node_field_data.nid = node__field_ca_address.entity_id AND node__field_ca_address.deleted = \'0\'
          LEFT JOIN {content_moderation_state_field_revision} content_moderation_state_1 ON node_field_data.vid = content_moderation_state_1.content_entity_revision_id AND (content_moderation_state_1.content_entity_type_id = \'node\' AND content_moderation_state_1.langcode = node_field_data.langcode)
          WHERE ((users_field_data_node_field_data__user__roles.roles_target_id = \'consultant_applicant\')) AND ((node_field_data.type IN (\'consultant_application\')) AND (node_field_data.type IN (\'consultant_application\')) AND (((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'in_process\')) OR ((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'denied\')) OR ((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'approved\'))))
          ORDER BY content_moderation_state_1.moderation_state '.$sort.'';
        if ($sort=='ASC') $status_sort="DESC";
        if ($sort=='DESC') $status_sort="ASC";
        break;
      case 'active';
          $sql = 'SELECT node__field_ca_address.field_ca_address_locality AS node__field_ca_address_field_ca_address_locality, node__field_ca_address.field_ca_address_administrative_area AS node__field_ca_address_field_ca_address_administrative_area, node_field_data.nid AS nid, users_field_data_node_field_data.uid AS users_field_data_node_field_data_uid
          FROM
          {node_field_data} node_field_data
          INNER JOIN {users_field_data} users_field_data_node_field_data ON node_field_data.uid = users_field_data_node_field_data.uid
          INNER JOIN {user__roles} users_field_data_node_field_data__user__roles ON users_field_data_node_field_data.uid = users_field_data_node_field_data__user__roles.entity_id AND users_field_data_node_field_data__user__roles.deleted = \'0\'
          LEFT JOIN {content_moderation_state_field_revision} content_moderation_state ON node_field_data.vid = content_moderation_state.content_entity_revision_id AND (content_moderation_state.content_entity_type_id = \'node\' AND content_moderation_state.langcode = node_field_data.langcode)
          LEFT JOIN {node__field_ca_address} node__field_ca_address ON node_field_data.nid = node__field_ca_address.entity_id AND node__field_ca_address.deleted = \'0\'
          LEFT JOIN {node__field_consultant_active} node__field_consultant_active ON node_field_data.nid = node__field_consultant_active.entity_id AND node__field_consultant_active.deleted = \'0\'
          WHERE ((users_field_data_node_field_data__user__roles.roles_target_id = \'consultant_applicant\')) AND ((node_field_data.type IN (\'consultant_application\')) AND (node_field_data.type IN (\'consultant_application\')) AND (((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'in_process\')) OR ((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'denied\')) OR ((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'approved\'))))
          ORDER BY node__field_consultant_active.field_consultant_active_value '.$sort.'';
        if ($sort=='ASC') $active_sort="DESC";
        if ($sort=='DESC') $active_sort="ASC";
        break;
      case 'title';
          $sql = '
          SELECT node__field_ca_address.field_ca_address_locality AS node__field_ca_address_field_ca_address_locality, node__field_ca_address.field_ca_address_administrative_area AS node__field_ca_address_field_ca_address_administrative_area, node_field_data.nid AS nid, users_field_data_node_field_data.uid AS users_field_data_node_field_data_uid
          FROM
          {node_field_data} node_field_data
          INNER JOIN {users_field_data} users_field_data_node_field_data ON node_field_data.uid = users_field_data_node_field_data.uid
          INNER JOIN {user__roles} users_field_data_node_field_data__user__roles ON users_field_data_node_field_data.uid = users_field_data_node_field_data__user__roles.entity_id AND users_field_data_node_field_data__user__roles.deleted = \'0\'
          LEFT JOIN {content_moderation_state_field_revision} content_moderation_state ON node_field_data.vid = content_moderation_state.content_entity_revision_id AND (content_moderation_state.content_entity_type_id = \'node\' AND content_moderation_state.langcode = node_field_data.langcode)
          LEFT JOIN {node__field_ca_address} node__field_ca_address ON node_field_data.nid = node__field_ca_address.entity_id AND node__field_ca_address.deleted = \'0\'
          WHERE ((users_field_data_node_field_data__user__roles.roles_target_id = \'consultant_applicant\')) AND ((node_field_data.type IN (\'consultant_application\')) AND (node_field_data.type IN (\'consultant_application\')) AND (((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'in_process\')) OR ((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'denied\')) OR ((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'approved\'))))
          ORDER BY node_field_data.title '.$sort.'';
        $order = 'ORDER BY node_field_data.title ';
        if ($sort=='ASC') $title_sort="DESC";
        if ($sort=='DESC') $title_sort="ASC";
        break;
      case 'location';
            $sql = 'SELECT node__field_ca_address.field_ca_address_locality AS node__field_ca_address_field_ca_address_locality, node__field_ca_address.field_ca_address_administrative_area AS node__field_ca_address_field_ca_address_administrative_area, node_field_data.nid AS nid, users_field_data_node_field_data.uid AS users_field_data_node_field_data_uid
            FROM
            {node_field_data} node_field_data
            INNER JOIN {users_field_data} users_field_data_node_field_data ON node_field_data.uid = users_field_data_node_field_data.uid
            INNER JOIN {user__roles} users_field_data_node_field_data__user__roles ON users_field_data_node_field_data.uid = users_field_data_node_field_data__user__roles.entity_id AND users_field_data_node_field_data__user__roles.deleted = \'0\'
            LEFT JOIN {content_moderation_state_field_revision} content_moderation_state ON node_field_data.vid = content_moderation_state.content_entity_revision_id AND (content_moderation_state.content_entity_type_id = \'node\' AND content_moderation_state.langcode = node_field_data.langcode)
            LEFT JOIN {node__field_ca_address} node__field_ca_address ON node_field_data.nid = node__field_ca_address.entity_id AND node__field_ca_address.deleted = \'0\'
            WHERE ((users_field_data_node_field_data__user__roles.roles_target_id = \'consultant_applicant\')) AND ((node_field_data.type IN (\'consultant_application\')) AND (node_field_data.type IN (\'consultant_application\')) AND (((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'in_process\')) OR ((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'denied\')) OR ((content_moderation_state.workflow = \'consultant_application_moderation\') AND (content_moderation_state.moderation_state = \'approved\'))))
            ORDER BY node__field_ca_address_field_ca_address_administrative_area '.$sort.', node__field_ca_address_field_ca_address_locality '.$sort.'';
        if ($sort=='ASC') $location_sort="DESC";
        if ($sort=='DESC') $location_sort="ASC";
        break;
    }



    $connection = Database::getConnection();

    $results = $connection->query($sql); //execute query

    // Iterate results
    foreach ($results as $result) {
      $nids[] .= $result->nid.",".$result->node__field_ca_address_field_ca_address_locality.",".$result->node__field_ca_address_field_ca_address_administrative_area.",".$result->users_field_data_node_field_data_uid;
    }



    $nids[] = $status_sort.','.$active_sort.','.$title_sort.','.$location_sort.','.$query.','.$sort;

    return $nids;

  }



}
?>