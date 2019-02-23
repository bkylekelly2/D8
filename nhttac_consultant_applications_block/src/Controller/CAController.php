<?php
namespace Drupal\nhttac_consultant_applications_block\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Database;
use Drupal\nhttac_consultant_applications_block\Service\CAService;

class CAController extends ControllerBase {

  protected $CAService;

  /**
   * @var CAService
   */
  public function __construct(CAService $CAService) {
    $this->CAService = $CAService;
  }

  public static function create(ContainerInterface $container) {
    $CAService = $container->get('nhttac_consultant_applications_block.nhttac_service');
    return new static($CAService);
  }

  public function getApplications() {
    $nids = $this->CAService->getResults();

    $last = (count($nids)-1);

    $sortCSV = $nids[$last];

    $connection = Database::getConnection();


    $array2 = explode(",", $sortCSV);
      $status_sort = $array2[0];
      $active_sort = $array2[1];
      $title_sort = $array2[2];
      $location_sort = $array2[3];
      $query = $array2[4];
      $sort = $array2[5];
      $status_caret = '';
      $active_caret = '';
      $title_caret = '';
      $location_caret = '';

    unset($nids[$last]);

    $caret_up = '<span class="icon glyphicon glyphicon-chevron-up icon-after" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Sort descending"></span>';
    $caret_down = '<span class="icon glyphicon glyphicon-chevron-down icon-after" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Sort ascending"></span>';


    switch($query){
      case 'status';
        if ($sort=='ASC')  $status_caret=$caret_up;
        if ($sort=='DESC') $status_caret=$caret_down;
        break;
      case 'active';
        if ($sort=='ASC')  $active_caret=$caret_up;
        if ($sort=='DESC') $active_caret=$caret_down;
        break;
      case 'title';
        if ($sort=='ASC')  $title_caret=$caret_up;
        if ($sort=='DESC') $title_caret=$caret_down;
        break;
      case 'location';
        if ($sort=='ASC')  $location_caret=$caret_up;
        if ($sort=='DESC') $location_caret=$caret_down;
        break;
    }



    $output='
      <section class="col-lg-12 col-sm-9">
  
  
  <a id="main-content"></a>
  <div class="region region-content">
  
  <div class="row bs-1col-stacked">
  
  
  
  <div class="col-lg-12 bs-region bs-region--main"
  <div class="block-region-main"><section class="views-element-container contextual-region block block-views block-views-blockmyotip-block-3 clearfix">
  
  <h2 class="block-title">All Consultant Applications</h2>
  <div data-contextual-id="entity.view.edit_form:view=myotip:location=block&amp;name=myotip&amp;display_id=block_3&amp;langcode=en" data-contextual-token="VWLXlX7gaDZUtrDXuRLPyFGMyRaqdYXDbXi2nfFX3c4"></div>
  
  <div class="form-group"><div class="contextual-region view view-myotip view-id-myotip view-display-id-block_3 js-view-dom-id-c0102191ec60eb038a89ed20f8c0150bc3923ca02c1537a36db7b826410091f0">
  
  <div data-contextual-id="entity.view.edit_form:view=myotip:location=block&amp;name=myotip&amp;display_id=block_3&amp;langcode=en" data-contextual-token="VWLXlX7gaDZUtrDXuRLPyFGMyRaqdYXDbXi2nfFX3c4"></div>
  
  <div class="pager-top">
  
  </div>
  
  <div class="view-content">
  <div class="table-responsive">
  <table class="table table-hover table-striped">
  <thead>
  <tr>
  <th id="view-moderation-state-table-column" class="views-field views-field-moderation-state" scope="col"><div id="status" class="'.$status_sort.'" style="cursor:pointer;">Status '.$status_caret.'</div></th>
  <th id="view-field-consultant-active-table-column" class="views-field views-field-field-consultant-active" scope="col"><div id="active" class="'.$active_sort.'" style="cursor:pointer;">Active '.$active_caret.'</div></th>
  <th id="view-title-table-column" class="views-field views-field-title" scope="col"><div id="title" class="'.$title_sort.'" style="cursor:pointer;">Name '.$title_caret.'</div></th>
  <th class="priority-low views-field views-field-field-ca-address-administrative-area" id="view-field-ca-address-administrative-area-table-column" scope="col"><div id="location" class="'.$location_sort.'" style="cursor:pointer;">Location '.$location_caret.'</div></th>
  <th id="view-field-phone-table-column" class="views-field views-field-field-phone" scope="col">Preferred Phone </th>
  <th id="view-field-ca-home-email-table-column" class="views-field views-field-field-ca-home-email" scope="col">Preferred Email</th>
  <th id="view-field-ca-top-area-con-app-tta-table-column" class="views-field views-field-field-ca-top-area-con-app-tta" scope="col">Approved areas of expertise</th>
  <th id="view-field-ca-approved-audience-table-column" class="views-field views-field-field-ca-approved-audience" scope="col">Approved Audience</th>
  </tr>
  </thead>
  <tbody>';

    foreach ($nids as $result) {


      $parts = explode(",",$result);
      $nid = $parts[0];
      $address_city = $parts[1];
      $address_state = $parts[2];
      $uid = $parts[3];


      $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);

      $title = $node->getTitle();

      if ( !$node->moderation_state == null ){
        $moderation_state = $node->moderation_state->getValue()[0]['value'];
      }



      if ( !$node->field_consultant_active == null ){
        $active = $node->field_consultant_active->getValue()[0]['value'];
      }




      if ( !$node->field_ca_preferred_phone == null ){
        $preferred_phone = $node->field_ca_preferred_phone->getValue()[0]['value'];
      }


      if ( !$node->field_ca_preferred_email == null ){
        $preferred_email = $node->field_ca_preferred_email->getValue()[0]['value'];
      }


      if ( !$node->field_ca_top_area_con_app_tta == null ){

        $aoe_count = count($node->field_ca_top_area_con_app_tta->getValue());

        for ($x = 0; $x <= ($aoe_count-1); $x++) {
          $ID = $node->field_ca_top_area_con_app_tta->getValue()[$x]['target_id'];
          $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($ID);
          $term = $term->getName();
          $aoe .= $term.",";
        }
        $aoe = rtrim($aoe,",");
      }


      if ( !$node->field_ca_approved_audience == null ){

        $audience_count = count($node->field_ca_approved_audience->getValue());

        for ($x = 0; $x <= ($audience_count-1); $x++) {
          $ID = $node->field_ca_approved_audience->getValue()[$x]['target_id'];
          $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($ID);
          $term = $term->getName();
          $audience .= $term.",";
        }
        $audience = rtrim($audience,",");
      }



      $city = $address_city;
      $state = $address_state;


      $location = $city.",".$state;


       if ($active==='0'){ $active = 'No'; }
       if ($active==='1'){ $active = 'Yes'; }

       $sql = 'SELECT `field_phone_value` as phone FROM `user__field_phone` WHERE `entity_id` = '.$uid.' ';

      $thephone = $connection->query($sql); //execute query

      $phone = '';
      // Iterate results
      foreach ($thephone as $thephone) {
        $phone = $thephone->phone;
      }





     if ( !$node->field_ca_home_email == null ){
       $email = $node->field_ca_home_email->getValue()[0]['value'];
     } else {

       if ( !$node->field_ca_business_email == null ){
         $email = $node->field_ca_business_email->getValue()[0]['value'];
       }
     }



      if ( $phone <> '' ) {
        $preferred_phone = 'Phone';
      } else {

      switch ($preferred_phone) {
    case 'Home';
      if ( !$node->field_ca_home_phone == null ){
        $phone = $node->field_ca_home_phone->getValue()[0]['value'];
      }
      break;
    case 'Cell';
      if ( !$node->field_ca_cell_phone == null ){
        $phone = $node->field_ca_cell_phone->getValue()[0]['value'];
      }
      break;
    case 'Business';
      if ( !$node->field_ca_business_phone == null ){
        $phone = $node->field_ca_business_phone->getValue()[0]['value'];
      }
      break;
  }

}

switch($moderation_state){
  case 'denied';
    $moderation_state = 'Denied';
    break;
  case 'in_process';
    $moderation_state = 'In Progress';
    break;
  case 'approved';
    $moderation_state = 'Approved';
    break;
}



      $output .= '
  <tr>
  <td headers="view-moderation-state-table-column" class="views-field views-field-moderation-state">'.$moderation_state.'</td>
  <td headers="view-field-consultant-active-table-column" class="views-field views-field-field-consultant-active">'.$active.'</td>
  <td headers="view-title-table-column" class="views-field views-field-title"><a href="/node/547" hreflang="en">'.$title.'</a> </td>
  <td class="priority-low views-field views-field-field-ca-address-administrative-area" headers="view-field-ca-address-administrative-area-table-column">'.$location.'</td>
  <td headers="view-field-phone-table-column" class="views-field views-field-field-phone">'.$preferred_phone.' : '.$phone.' </td>
  <td headers="view-field-ca-home-email-table-column" class="views-field views-field-field-ca-home-email">'.$preferred_email.' : <a href="mailto:'.$email.'">'.$email.'</a>  </td>
  <td headers="view-field-ca-top-area-con-app-tta-table-column" class="views-field views-field-field-ca-top-area-con-app-tta">'.$aoe.' </td>
  <td headers="view-field-ca-approved-audience-table-column" class="views-field views-field-field-ca-approved-audience">'.$audience.'</td>
  </tr>
';
      $active = '';
      $preferred = '';
      $moderation_state= '';
      $aoe= '';
      $audience= '';
      $phone= '';
      $email= '';
      $preferred_phone= '';
      $preferred_email= '';
    }

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



    return new Response(($output));
    //return new Response($last);
  }

}
