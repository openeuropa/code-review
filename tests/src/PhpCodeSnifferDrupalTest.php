<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResult;

/**
 * Tests the PHP_CodeSniffer task using the Drupal conventions.
 */
class PhpCodeSnifferDrupalTest extends PhpCodeSnifferTestBase
{
    /**
     * Provides test cases for testing the PHP_CodeSniffer task for Drupal.
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
                [
                    'error' => [
                        16 => 1,
                        17 => 1,
                        20 => 1,
                        23 => 1,
                    ],
                ],
            ],
            [
                'DrupalClassCorrect.php',
                'drupal-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'correct-code.inc',
                'drupal-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'correct-code.module',
                'drupal-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'correct-code.theme',
                'drupal-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'correct-code.install',
                'drupal-conventions',
                TaskResult::SKIPPED,
                [],
            ],
            [
                'correct-code.yml',
                'drupal-conventions',
                TaskResult::SKIPPED,
                [],
            ],
            [
                'correct-code.xxx',
                'drupal-conventions',
                TaskResult::SKIPPED,
                [],
            ],
        ];
    }
}
