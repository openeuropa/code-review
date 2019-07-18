<?php

namespace Drupal\testmodule;

/**
 * Some service.
 */
class DrupalClass extends BlockBase {

  /**
   * Using \Drupal here but it should be injected instead.
   *
   * @deprecated Test.
   */
  public function test() {
    return true;
  }

}
