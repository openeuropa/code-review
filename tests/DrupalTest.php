<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\GitPreCommitContext;

/**
 * Tests for Drupal conventions.
 *
 * @internal
 * @coversNothing
 */
final class DrupalTest extends AbstractTest
{
    /**
     * Test case provider function.
     *
     * Test file extensions.
     *
     * @return array
     *      Test data
     */
    public function commitMessageProvider()
    {
        return [
            ['phpmd/correct-code.inc', TaskResult::PASSED],
            ['phpmd/correct-code.module', TaskResult::PASSED],
            ['phpmd/correct-code.theme', TaskResult::PASSED],
            ['phpmd/ignored-code.xxx', TaskResult::SKIPPED],
        ];
    }

    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $fixture
     *   Name of the fixture
     * @param int    $expected
     *   Expected result after the test
     *
     * @dataProvider commitMessageProvider
     */
    public function testPhpMessDetector($fixture, $expected)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new GitPreCommitContext($collection);
        $task = $this->getTask('phpmd', 'drupal-conventions');
        $result = $task->run($context);
        static::assertEquals($expected, $result->getResultCode());
    }
}
