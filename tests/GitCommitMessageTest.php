<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\GitCommitMsgContext;
use GrumPHP\Collection\FilesCollection;

/**
 * Tests for git commit message conventions.
 */
class GitCommitMessageTest extends AbstractTest
{
    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $message
     *   Commit message to test.
     * @param int    $expected
     *   Expected result after the test.
     *
     * @dataProvider commitMessageProvider
     */
    public function testCommitMessage($message, $expected)
    {
        $collection = new FilesCollection();
        $context = new GitCommitMsgContext($collection, $message, '', '');
        $task = $this->getTask('git_commit_message', 'base-conventions');
        $result = $task->run($context);
        $this->assertEquals($expected, $result->getResultCode());
    }

    /**
     * Test case provider function.
     *
     * @return array
     *      Test data.
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
}
