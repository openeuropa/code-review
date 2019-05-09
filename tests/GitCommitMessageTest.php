<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\GitCommitMsgContext;

/**
 * Tests for git commit message conventions.
 *
 * @internal
 * @coversNothing
 */
final class GitCommitMessageTest extends AbstractTest
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
            ['Issue #3: Nice GitHub commit message.', TaskResult::PASSED],
            ['#3: Not nice GitHub commit message.', TaskResult::FAILED],
            ['NEPT-123: Nice Jira commit message.', TaskResult::PASSED],
            ['Failed message', TaskResult::FAILED],
        ];
    }

    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $message
     *   Commit message to test
     * @param int $expected
     *   Expected result after the test
     *
     * @dataProvider commitMessageProvider
     */
    public function testCommitMessage($message, $expected)
    {
        $collection = new FilesCollection();
        $context = new GitCommitMsgContext($collection, $message, '', '');
        $task = $this->getTask('git_commit_message', 'base-conventions');
        $result = $task->run($context);
        static::assertEquals($expected, $result->getResultCode());
    }
}
