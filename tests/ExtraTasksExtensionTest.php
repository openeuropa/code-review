<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Configuration\ContainerBuilder;
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
        $container = ContainerBuilder::buildFromConfiguration($path);
        $tasks = $container->getParameter('tasks');

        $this->assertEquals([
            'phpcs' => null,
            'phpmd' => null,
            'git_commit_message' => null,
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
        ContainerBuilder::buildFromConfiguration($path);
    }
}
