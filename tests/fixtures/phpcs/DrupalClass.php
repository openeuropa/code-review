<?php

namespace Drupal\testmodule;

use Drupal\BlockBase;

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

  /**
   * Tests method with docblock and PHP attribute.
   */
  #[\ReturnTypeWillChange]
  public function aMethodWithDocblockAndPhpAttribute(): void {
  }

}
