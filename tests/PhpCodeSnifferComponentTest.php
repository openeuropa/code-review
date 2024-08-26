<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResult;

/**
 * Tests the PHP_CodeSniffer task using the OE component conventions.
 */
class PhpCodeSnifferComponentTest extends PhpCodeSnifferTestBase
{
    /**
     * Provides test cases for testing the PHP_CodeSniffer task for OE Component.
     *
     * @return array
     *      Test data.
     */
    public function dataProvider()
    {
        return [
            [
                'phpcs/DrupalClassIncorrect.php',
                'oe-component-conventions',
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
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.inc',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.module',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.theme',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.install',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.yml',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.xxx',
                'oe-component-conventions',
                TaskResult::SKIPPED,
                [],
            ],
        ];
    }
}
