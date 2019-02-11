<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\GitPreCommitContext;

/**
 * Tests the PHP_CodeSniffer task using the library conventions.
 *
 * @internal
 * @coversNothing
 */
final class PhpCodeSnifferDrupalTest extends PhpCodeSnifferTestBase
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
     * @see testPhpCodeSnifferDrupalTask()
     */
    public function phpCodeSnifferTaskProvider()
    {
        return [
            [
                'phpcs/ExampleServiceBad.php',
                'drupal-conventions',
                [
                    'warning' => [
                        16 => 1,
                        17 => 1,
                        24 => 1,
                        31 => 1,
                    ],
                ],
            ],
        ];
    }

    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $fixture
     *   Name of the fixture to use in the test
     * @param string $configuration
     *   The name of the configuration to use in the task
     * @param array $expected_failures
     *   An array of failures that are expected to be thrown when testing the fixture for coding standards violations
     *
     * @dataProvider phpCodeSnifferTaskProvider
     */
    public function testPhpCodeSnifferDrupalTask($fixture, $configuration, array $expected_failures)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new GitPreCommitContext($collection);
        $task = $this->getTask('phpcs', $configuration);
        $result = $task->run($context);
        $this->assertFailures($expected_failures, $this->getFailures($result));
    }
}
