<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\GitPreCommitContext;

/**
 * Tests for git commit message conventions.
 *
 * @internal
 * @coversNothing
 */
final class PhpMessDetectorTest extends AbstractTest
{
    /**
     * Test case provider function.
     *
     * @return array
     *      Test data
     */
    public function commitMessageProvider()
    {
        return [
            ['phpmd/correct-code.php', TaskResult::PASSED],
            ['phpmd/incorrect-code.php', TaskResult::FAILED],
        ];
    }

    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $fixture
     *   Name of the fixture
     * @param int $expected
     *   Expected result after the test
     *
     * @dataProvider commitMessageProvider
     */
    public function testPhpCodeMessage($fixture, $expected)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new GitPreCommitContext($collection);
        $task = $this->getTask('phpmd', 'base-conventions');
        $result = $task->run($context);
        static::assertEquals($expected, $result->getResultCode());
    }
}
