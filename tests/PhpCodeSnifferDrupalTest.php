<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\RunContext;

/**
 * Tests the PHP_CodeSniffer task using the Drupal conventions.
 */
class PhpCodeSnifferDrupalTest extends PhpCodeSnifferTestBase
{
    /**
     * Tests Drupal code to make sure CodeSniffer triggers the appropriate errors.
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
    public function testDrupalPhpCodeSnifferDetector(string $file, string $configuration, array $expectedFailures): void
    {
        $collection = new FilesCollection([$this->getFixture($file)]);
        $context = new RunContext($collection);

        $result = $this->runTask($configuration, 'phpcs', $context);
        $this->assertEquals($expectedFailures, $this->getFailures($result->first()));
    }

    /**
     * Provides test cases for testing the PHP_CodeSniffer task for Drupal.
     *
     * @return array
     *      Test data.
     */
    public function dataProvider()
    {
        return [
            [
                'phpcs/DrupalClass.php',
                'drupal-conventions',
                [
                    'error' => [
                        18 => 1,
                    ],
                ],
            ],
        ];
    }
}
