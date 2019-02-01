<?php

namespace Drupal\nhttac_consultant_applications_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\DependencyInjection\ClassResolverInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'Example: kyle' block.
 *
 * @Block(
 *   id = "example_empty",
 *   admin_label = @Translation("kyle block")
 * )
 */
class ExampleEmptyBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Class Resolver service.
   *
   * @var \Drupal\Core\DependencyInjection\ClassResolverInterface
   */
  protected $classResolver;

  /**
   * Constructs a new ControllerBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\DependencyInjection\ClassResolverInterface $class_resolver
   *   The class resolver service.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    ClassResolverInterface $class_resolver
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->classResolver = $class_resolver;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('class_resolver')
    );
  }


  /**
   * {@inheritdoc}
   *
   * The return value of the build() method is a renderable array. Returning an
   * empty array will result in empty block contents. The front end will not
   * display empty blocks.
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


public function getResults(){
  $controller = $this->classResolver->getInstanceFromDefinition('\Drupal\nhttac_consultant_applications_block\Controller\NHTTACController');
  return $controller->getApplications();
}

public function returnApplications(){
$output = '
<div id="clickme"><a href="#">clickme</a></div>
';
return $output;
}


}
