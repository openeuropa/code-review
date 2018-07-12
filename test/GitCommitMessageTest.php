<?php

namespace OpenEuropa\CodeReview\Test;

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
        $task = $this->getTask('git_commit_message');
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

    /**
     * Returns the task with the given name.
     *
     * @param string $name
     *   The name of the task to return.
     *
     * @return \GrumPHP\Task\TaskInterface
     *
     * @throws \Exception
     *   Thrown when the task with the given name does not exist, or if the task runner service is not registered.
     */
    protected function getTask($name)
    {
        $container = $this->getContainer($this->getDistPath().'/base-conventions.yml');
        /** @var \GrumPHP\Runner\TaskRunner $taskrunner */
        $taskrunner = $container->get('task_runner');
        foreach ($taskrunner->getTasks() as $task) {
            if ($task->getName() === $name) {
                return $task;
            }
        }

        throw new \InvalidArgumentException("Task with name $name is not registered.");
    }
}
