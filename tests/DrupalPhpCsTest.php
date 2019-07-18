<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;

/**
 * Tests for Drupal conventions.
 */
class DrupalPhpCsTest extends PhpCodeSnifferTestBase
{

    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $fixture
     *   Name of the fixture.
     * @param string $configuration
     *   The name of the configuration to use in the task
     * @param int    $expected
     *   Expected result after the test.
     *
     * @dataProvider messageProvider
     */
    public function testDrupalPhpCodeSnifferDetector($fixture, $configuration, $expected)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new RunContext($collection);
        $task = $this->getTask('phpcs', $configuration);
        $result = $task->run($context);
        $this->assertFailures($expected, $this->getFailures($result));
    }

    /**
     * Test case provider function.
     *
     * Test file extensions.
     *
     * @return array
     *      Test data.
     */
    public function messageProvider()
    {
        return [
            [
                'phpcs/DrupalClass.php',
                'drupal-conventions',
                [
                    'error' => [
                        15 => 2,
                        18 => 1,
                    ],
                ],
            ],
            [
                'phpcs/DrupalClass.php',
                '../tests/fixtures/dist/drupal-conventions',
                [
                    'error' => [
                        18 => 1,
                    ],
                ],
            ],
        ];
    }
}
