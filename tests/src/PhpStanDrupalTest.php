<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResult;

/**
 * Tests for PHPStan conventions.
 */
class PhpStanDrupalTest extends PhpStanTestBase
{
    /**
     * Provides test cases for testing the PHPStan task for Drupal.
     *
     * PHP files are ignored by extension.neon in tests/fixtures path for Drupal
     * PHPStan, so we check incorrect code with .module file.
     *
     * @return array
     *   Test data.
     */
    public function dataProvider(): array
    {
        return [
            [
                'incorrect-code.module',
                'drupal-conventions',
                TaskResult::FAILED,
            ],
            [
                'DrupalClassCorrect.php',
                'drupal-conventions',
                TaskResult::PASSED,
            ],
            [
                'correct-code.inc',
                'drupal-conventions',
                TaskResult::PASSED,
            ],
            [
                'correct-code.module',
                'drupal-conventions',
                TaskResult::PASSED,
            ],
            [
                'correct-code.theme',
                'drupal-conventions',
                TaskResult::PASSED,
            ],
            [
                'correct-code.install',
                'drupal-conventions',
                TaskResult::SKIPPED,
            ],
            [
                'correct-code.yml',
                'drupal-conventions',
                TaskResult::SKIPPED,
            ],
            [
                'correct-code.xxx',
                'drupal-conventions',
                TaskResult::SKIPPED,
            ],
        ];
    }
}
