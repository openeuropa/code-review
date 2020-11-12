<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\GitCommitMsgContext;
use GrumPHP\Task\Context\RunContext;

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
     * @param int $expectedResultCode
     *   Expected result after the test.
     *
     * @dataProvider commitMessageProvider
     */
    public function testCommitMessage(string $message, int $expectedResultCode): void
    {
        $collection = new FilesCollection();
        $context = new GitCommitMsgContext($collection, $message, 'test_user', 'test_user@example.org');

        $result = $this->runTask('library-conventions', 'git_commit_message', $context);
        $this->assertEquals($expectedResultCode, $result->getResultCode());
    }

    /**
     * Test case provider function.
     *
     * @return array
     *      Test data.
     */
    public function commitMessageProvider(): array
    {
        return [
            ['Issue #3: Nice GitHub commit message.', TaskResult::PASSED],
            ['#3: Not nice GitHub commit message.', TaskResult::FAILED],
            ['NEPT-123: Nice Jira commit message.', TaskResult::PASSED],
            ['NEPT2-123: Jira with number in project.', TaskResult::PASSED],
            ['Failed message', TaskResult::FAILED],
        ];
    }
}
