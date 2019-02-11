<?php

namespace Drupal\testmodule;

use Drupal\node\Entity\Node;

/**
 * Some service.
 */
class ExampleServiceBad extends BlockBase {

  /**
   * Using \Drupal here but it should be injected instead.
   */
  public function test() {
    \Drupal::service('testte.test');
    return \Drupal::configFactory();
  }

  /**
   * Loading nodes should be done from an injected service.
   */
  public function test2() {
    return Node::load(1);
  }

  /**
   * T() should not be used, translation service should be injected.
   */
  public function test3() {
    return t('Test');
  }

}
