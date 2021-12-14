<?php

namespace OpenEuropa\CodeReview\Tests;

use PHPUnit\Framework\TestCase;
use GrumPHP\Task\Context\ContextInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use GrumPHP\Collection\TaskResultCollection;
use GrumPHP\Configuration\ContainerFactory;
use GrumPHP\Runner\TaskRunnerContext;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\Container;

/**
 * Base class for testing conventions.
 */
abstract class AbstractTest extends TestCase
{
    /**
     * Get fixture file object.
     *
     * @param string $fixture
     *   Fixture file name.
     *
     * @return \SplFileInfo
     *   Return fixture file object.
     */
    public function getFixture($fixture)
    {
        $file = new \SplFileInfo(__DIR__.'/fixtures/'.$fixture);
        if (!$file->isReadable()) {
            throw new \RuntimeException(sprintf('The fixture %s could not be loaded!', $fixture));
        }

        return $file;
    }

    /**
     * Build a GrumPHP container from test configuration files.
     *
     * @param string $configuration
     *   Configuration file name from which to build the container from.
     *
     * @return Container
     *   The built container.
     */
    protected function getContainer(string $configuration): Container
    {
        // Create a GrumPHP configuration file to use in the test. Check if a configuration specific file exists, or
        // fall back to a generic template file.
        $filename = file_exists(__DIR__ . "/config/$configuration.yml.dist") ? __DIR__ . "/config/$configuration.yml.dist" : __DIR__ . '/config/grumphp.yml.dist';
        $content = file_get_contents($filename);
        $content = str_replace("{configuration}", $configuration, $content);
        file_put_contents(__DIR__ . '/config/grumphp.yml', $content);

        // Initialise the application with the provided config.
        $input = new ArrayInput([
            '--config' => __DIR__ . '/config/grumphp.yml',
        ]);
        // Mark the application as non-interactive, so turn off any request for input during task execution.
        $input->setInteractive(false);

        return ContainerFactory::build($input, new ConsoleOutput(ConsoleOutput::VERBOSITY_QUIET));
    }

    /**
     * Runs a specific GrumPHP task.
     *
     * @param string $configuration
     *   The configuration to use.
     * @param string $task
     *   The task name.
     * @param ContextInterface $context
     *   The task context. Contains the parameters necessaries for the context to run.
     * @return TaskResultCollection
     *   The results of the task execution.
     */
    protected function runTask(string $configuration, string $task, ContextInterface $context): TaskResultCollection
    {
        $container = $this->getContainer($configuration);

        // Create the task runner context with the provided parameters.
        $runnerContext = new TaskRunnerContext(
            $context,
            null,
            [$task]
        );

        $taskRunner = $container->get('task_runner');
        return $taskRunner->run($runnerContext);
    }
}
