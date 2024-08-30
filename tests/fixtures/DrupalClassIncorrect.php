<?php

namespace OpenEuropa\CodeReview\Tests\Fixtures;

/**
 * Some Drupal class.
 */
class DrupalClassIncorrect {

  /**
   * Test method using \Drupal call instead of dependency injection.
   *
   * @deprecated Test.
   */
  public function test() {
    \Drupal::service('test');
    return true;
  }

    /**
     * Tests method with docblock and PHP attribute.
     */
    #[\ReturnTypeWillChange]
    public function aMethodWithDocblockAndPhpAttribute(): void {
    }

}
