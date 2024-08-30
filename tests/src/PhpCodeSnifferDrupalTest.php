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
    public function dataProvider()
    {
        return [
            [
                'phpcs/DrupalClassIncorrect.php',
                'drupal-conventions',
                TaskResult::FAILED,
                [
                    'error' => [
                        18 => 1,
                        21 => 1,
                        24 => 1,
                    ],
                ],
            ],
            [
                'phpcs/DrupalClassCorrect.php',
                'drupal-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.inc',
                'drupal-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.module',
                'drupal-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.theme',
                'drupal-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.install',
                'drupal-conventions',
                TaskResult::SKIPPED,
                [],
            ],
            [
                'phpcs/correct-code.yml',
                'drupal-conventions',
                TaskResult::SKIPPED,
                [],
            ],
            [
                'phpcs/correct-code.xxx',
                'drupal-conventions',
                TaskResult::SKIPPED,
                [],
            ],
        ];
    }
}
