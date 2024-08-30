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
     * @return array
     *   Test data.
     */
    public function dataProvider(): array
    {
        return [
            [
                'DrupalClassIncorrect.php',
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
