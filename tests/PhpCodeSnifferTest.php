<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\GitPreCommitContext;

/**
 * Tests the PHP_CodeSniffer task using the library conventions.
 */
class PhpCodeSnifferTest extends PhpCodeSnifferTestBase
{
    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $fixture
     *   Name of the fixture to use in the test.
     * @param string $configuration
     *   The name of the configuration to use in the task.
     * @param array $expected_failures
     *   An array of failures that are expected to be thrown when testing the fixture for coding standards violations.
     *
     * @dataProvider phpCodeSnifferTaskProvider
     */
    public function testPhpCodeSnifferTask($fixture, $configuration, array $expected_failures)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new GitPreCommitContext($collection);
        $task = $this->getTask('phpcs', $configuration);
        $result = $task->run($context);
        $this->assertFailures($expected_failures, $this->getFailures($result));
    }

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
    public function phpCodeSnifferTaskProvider()
    {
        return [
            [
                'phpcs/incorrect-library-code.php',
                'library-conventions',
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
                [],
            ],
        ];
    }
}
