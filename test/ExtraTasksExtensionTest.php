<?php

namespace OpenEuropa\CodeReview\Test;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

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
        $app = new TestApplication($path);
        $app->setAutoExit(false);

        $input = new StringInput('');
        $output = new NullOutput();
        $app->run($input, $output);
        $tasks = $app->getParameter('tasks');

        $this->assertEquals([
            'phpcs' => null,
            'phpmd' => null,
            'git_commit_message' => null,
        ], $tasks);
    }
}
