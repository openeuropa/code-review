<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResultInterface;

/**
 * Base class for testing the PHP_CodeSniffer task.
 */
abstract class PhpCodeSnifferTestBase extends AbstractTest
{
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
}
