<?php

namespace OpenEuropa\CodeReview\Tests;

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
     * @param int $expectedExitCode
     *   Expected result after the test.
     *
     * @dataProvider commitMessageProvider
     */
    public function testCommitMessage(string $message, int $expectedExitCode): void
    {
        $application = $this->getApplication('library-conventions');


        // Prepare the commit message in a file to be read.
        file_put_contents($this->filesDirectory . '/COMMIT_MSG', $message);

        $exitCode = $this->runApplicationCommand($application, 'git:commit-msg', [
            'commit-msg-file' => $this->filesDirectory . '/COMMIT_MSG',
        ]);

        $this->assertEquals($expectedExitCode, $exitCode);
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
            ['Issue #3: Nice GitHub commit message.', 0],
            ['#3: Not nice GitHub commit message.', 1],
            ['NEPT-123: Nice Jira commit message.', 0],
            ['NEPT2-123: Jira with number in project.', 0],
            ['Failed message', 1],
        ];
    }
}
