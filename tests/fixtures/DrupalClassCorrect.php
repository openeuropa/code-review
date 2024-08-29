<?php

namespace Drupal\testmodule;

/**
 * Some Drupal class.
 */
class DrupalClassCorrect {

  /**
   * Test method.
   */
  public function test(): bool {
    return TRUE;
  }

  /**
   * Tests method with docblock and PHP attribute.
   */
  #[\ReturnTypeWillChange]
  public function aMethodWithDocblockAndPhpAttribute(): void {
  }

}
