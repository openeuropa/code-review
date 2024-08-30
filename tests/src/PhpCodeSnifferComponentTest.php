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
     *   Test data.
     */
    public function dataProvider(): array
    {
        return [
            [
                'DrupalClassIncorrect.php',
                'oe-component-conventions',
                TaskResult::FAILED,
                [
                    'error' => [
                        16 => 1,
                        19 => 1,
                        22 => 1,
                    ],
                ],
            ],
            [
                'DrupalClassCorrect.php',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'correct-code.inc',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'correct-code.module',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'correct-code.theme',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'correct-code.install',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'correct-code.yml',
                'oe-component-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'correct-code.xxx',
                'oe-component-conventions',
                TaskResult::SKIPPED,
                [],
            ],
        ];
    }
}
