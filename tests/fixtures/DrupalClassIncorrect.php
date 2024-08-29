<?php

namespace Drupal\testmodule;

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
      \Drupal::service('transliteration');
    return true;
  }

    /**
     * Tests method with docblock and PHP attribute.
     */
    #[\ReturnTypeWillChange]
    public function aMethodWithDocblockAndPhpAttribute(): void {
    }

}
