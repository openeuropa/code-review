<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Runner\TaskResultInterface;
use GrumPHP\Task\Context\RunContext;

/**
 * Base class for testing the PHP_CodeSniffer task.
 */
abstract class PhpCodeSnifferTestBase extends AbstractTest
{
    /**
     * The different types of PHP_CodeSniffer failures.
     */
    const FAILURE_TYPES = ['error', 'warning'];

    /**
     * Checks that the actual PHP_CodeSniffer failures match the expected failures.
     *
     * @param array $expected_failures
     *   An array of expected failures, keyed by failure type. Each value is an array with the line number as key and
     *   the number of expected failures as value.
     * @param array $actual_failures
     *   An array of actual failures, keyed by failure type. Each value is an array with the line number as key and the
     *   number of expected failures as value.
     */
    protected function assertFailures(array $expected_failures, array $actual_failures)
    {
        // Provide default values for missing failure types.
        $defaults = array_fill_keys(static::FAILURE_TYPES, []);
        $expected_failures += $defaults;
        $actual_failures += $defaults;

        foreach (static::FAILURE_TYPES as $failure_type) {
            $this->assertEquals($expected_failures[$failure_type], $actual_failures[$failure_type]);
        }
    }

    /**
     * Returns the PHP_CodeSniffer failures that are reported in the given result.
     *
     * @param TaskResultInterface $result
     *   The result that has been returned by the PHP_CodeSniffer task executed by GrumPHP.
     *
     * @return array
     *   An array of failures, keyed by failure type. Each value is an array with the line number as key and the number
     *   of expected failures as value.
     */
    protected function getFailures(TaskResultInterface $result)
    {
        $failures = [];

        $output = $result->getMessage();
        foreach (explode("\n", $output) as $line) {
            // Skip the lines that do not correspond with an error or warning.
            if (preg_match('/\s+(\d+)\s+\|\s+(error|warning)\s+\|.*/i', $line, $matches) !== 1) {
                continue;
            }

            $line_number = (int) $matches[1];
            $failure_type = strtolower($matches[2]);

            if (!isset($failures[$failure_type][$line_number])) {
                $failures[$failure_type][$line_number] = 1;
            } else {
                $failures[$failure_type][$line_number]++;
            }
        }

        return $failures;
    }

    /**
     * Tests code to make sure CodeSniffer triggers the appropriate results.
     *
     * @param string $file
     *   Name of the fixture.
     * @param string $configuration
     *   The name of the configuration to use in the task
     * @param int $expectedFailures
     *   Expected result after the test.
     *
     * @dataProvider dataProvider
     */
    public function testPhpCodeSnifferDetector(string $file, string $configuration, int $expectedResultCode, array $expectedFailures): void
    {
        $collection = new FilesCollection([$this->getFixture($file)]);
        $context = new RunContext($collection);

        $result = $this->runTask($configuration, 'phpcs', $context);
        // Check the result code and possible errors.
        $this->assertEquals($expectedResultCode, $result->getResultCode());
        $this->assertEquals($expectedFailures, $this->getFailures($result->first()));
    }

    /**
     * Provides test cases for testing the PHP_CodeSniffer task.
     *
     * @return array
     *   Test data.
     */
    public function dataProvider(): array
    {
        return [];
    }
}
