<?php

namespace OpenEuropa\CodeReview\Test;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\GitPreCommitContext;

/**
 * Tests for git commit message conventions.
 */
class PhpMessDetectorTest extends AbstractTest
{
    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $fixture
     *   Name of the fixture.
     * @param int    $expected
     *   Expected result after the test.
     *
     * @dataProvider commitMessageProvider
     */
    public function testPhpCodeMessage($fixture, $expected)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new GitPreCommitContext($collection);
        $task = $this->getTask('phpmd');
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
          ['correct-code.php', TaskResult::PASSED],
          ['incorrect-code.php', TaskResult::FAILED],
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
