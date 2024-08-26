<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResult;

/**
 * Tests the PHP_CodeSniffer task using the library conventions.
 */
class PhpCodeSnifferLibraryTest extends PhpCodeSnifferTestBase
{

    /**
     * Provides test cases for testing the PHP_CodeSniffer task.
     *
     * @return array
     *   An array of test data, with the following values:
     *   - A string containing the filename of the fixture that will be tested for coding standards violations, relative
     *     to the current directory.
     *   - A string representing the GrumPHP configuration to use, for example 'library-conventions'.
     *   - An array of line numbers on which coding standards violations are expected to be detected, keyed by failure
     *     type (either 'error', or 'warning'). Each value is an array with the line number as key and the number of
     *     failures that are expected to occur on this line as value.
     *
     * @see testPhpCodeSnifferTask()
     */
    public function dataProvider()
    {
        return [
            [
                'phpcs/incorrect-library-code.php',
                'library-conventions',
                TaskResult::FAILED,
                [
                    'error' => [
                        8 => 1,
                        15 => 1,
                        25 => 1,
                        32 => 1,
                    ],
                ],
            ],
            [
                'phpcs/correct-library-code.php',
                'library-conventions',
                TaskResult::PASSED,
                [],
            ],
            [
                'phpcs/correct-code.xxx',
                'library-conventions',
                TaskResult::SKIPPED,
                [],
            ],
        ];
    }
}
