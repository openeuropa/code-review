<?php

namespace Drupal\testmodule;

use Drupal\BlockBase;

/**
 * Some Drupal class.
 */
class DrupalClassIncorrect extends BlockBase {

  /**
   * Test method.
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
