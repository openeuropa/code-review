<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;

/**
 * Tests the PHP_CodeSniffer task using the library conventions.
 */
class PhpCodeSnifferTest extends PhpCodeSnifferTestBase
{
    /**
     * Tests PHP code to make sure CodeSniffer triggers the appropriate errors.
     *
     * @param string $file
     *   Name of the fixture to use in the test.
     * @param string $configuration
     *   The name of the configuration to use in the task.
     * @param array $expectedFailures
     *   An array of failures that are expected to be thrown when testing the fixture for coding standards violations.
     *
     * @dataProvider phpCodeSnifferTaskProvider
     */
    public function testPhpCodeSnifferTask(string $file, string $configuration, array $expectedFailures): void
    {
        $application = $this->getApplication($configuration);

        $collection = new FilesCollection([$this->getFixture($file)]);
        $context = new RunContext($collection);

        $result = $this->runTask($application, 'phpcs', $context);
        $this->assertEquals($expectedFailures, $this->getFailures($result->first()));
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
