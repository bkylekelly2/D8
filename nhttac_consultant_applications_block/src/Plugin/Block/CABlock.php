<?php

namespace Drupal\nhttac_consultant_applications_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'NHTTAC Consultant Applications Block.
 *
 * @Block(
 *   id = "consultant_applications_block",
 *   admin_label = @Translation("NHTTAC Consultant Applications Block")
 * )
 */
class CABlock extends BlockBase  {




  /**
   * {@inheritdoc}
   *
   * The return value of the build() method is a renderable array.
   */
  public function build() {

    return [
      '#markup' => $this->returnApplications(),
      '#attached' => array(
        'library' => array(
          'nhttac_consultant_applications_block/library1',
        ),
      ),
    ];
  }


public function returnApplications(){

$output = '<div id="results"></div>';

return $output;
}


}
