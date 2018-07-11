<?php

namespace OpenEuropa\CodeReview\Test;

use GrumPHP\Configuration\ContainerFactory;

/**
 * Test extra tasks extension.
 */
class ExtraTasksExtensionTest extends AbstractTest
{
    /**
     * Test extra task.
     */
    public function testExtraTask()
    {
        $path = $this->getFixture('extra-tasks/grumphp.yml.dist')->getRealPath();
        $container = ContainerFactory::buildFromConfiguration($path);
        $tasks = $container->getParameter('tasks');

        $this->assertEquals([
            'phpcs' => null,
            'phpmd' => null,
            'git_commit_message' => null,
        ], $tasks);
    }
}
