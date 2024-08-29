<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResult;

/**
 * Tests for PHPStan conventions.
 */
class PhpStanLibraryTest extends PhpStanTestBase
{
    /**
     * Provides test cases for testing the PHPStan task for library.
     *
     * @return array
     *   Test data.
     */
    public function dataProvider(): array
    {
        return [
            [
                'LibraryClassIncorrect.php',
                'library-conventions',
                TaskResult::FAILED,
            ],
            [
                'LibraryClassCorrect.php',
                'library-conventions',
                TaskResult::PASSED,
            ],
            [
                'correct-code.xxx',
                'library-conventions',
                TaskResult::SKIPPED,
            ],
        ];
    }
}
