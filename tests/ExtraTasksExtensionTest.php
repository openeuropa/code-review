<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Configuration\ContainerFactory;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * Test extra tasks extension.
 */
class ExtraTasksExtensionTest extends AbstractTest
{
    /**
     * Test adding an extra task.
     */
    public function testAddExtraTask()
    {
        $path = $this->getFixture('extra-tasks/success.yml')->getRealPath();
        $container = ContainerFactory::buildFromConfiguration($path);
        $tasks = $container->getParameter('tasks');

        $this->assertEquals([
            'phpcs' => null,
            'phpmd' => null,
            'git_commit_message' => null,
        ], $tasks);
    }

    /**
     * Test merge configuration with a task.
     */
    public function testMergeWithExistingTask()
    {
        $path = $this->getFixture('extra-tasks/merge.yml')->getRealPath();
        $container = ContainerFactory::buildFromConfiguration($path);
        $tasks = $container->getParameter('tasks');

        $this->assertEquals([
            'phpcs' => ['parameter' => 'parameter'],
            'phpmd' => null,
        ], $tasks);
    }

    /**
     * Test delete an existing task.
     */
    public function testDeleteAnExistingTask()
    {
        $path = $this->getFixture('extra-tasks/delete.yml')->getRealPath();
        $container = ContainerFactory::buildFromConfiguration($path);
        $tasks = $container->getParameter('tasks');

        $this->assertEquals([
            'phpmd' => null,
        ], $tasks);
    }

    /**
     * Test throwing an exception if trying to override already defined tasks.
     */
    public function testThrowExceptionForExistingTasks()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Cannot override already defined task 'phpcs' in 'extra_tasks'.");

        $path = $this->getFixture('extra-tasks/fail.yml')->getRealPath();
        ContainerFactory::buildFromConfiguration($path);
    }
}
