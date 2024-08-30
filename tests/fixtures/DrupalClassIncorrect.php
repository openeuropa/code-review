<?php

namespace OpenEuropa\CodeReview\Tests\Fixtures;

/**
 * Some Drupal class.
 */
class DrupalClassIncorrect {

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
