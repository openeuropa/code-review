<?php

declare(strict_types = 1);

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
