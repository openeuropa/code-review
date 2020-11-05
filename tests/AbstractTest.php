<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\TaskResultCollection;
use GrumPHP\Configuration\ContainerFactory;
use GrumPHP\Runner\TaskRunnerContext;
use GrumPHP\Task\Context\ContextInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Tester\TesterTrait as ConsoleTesterTrait;
use Symfony\Component\DependencyInjection\Container;

/**
 * Base class for testing conventions.
 */
abstract class AbstractTest extends TestCase
{
    use ConsoleTesterTrait;

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
        $filename = file_exists(__DIR__ . "/config/$configuration.yml.dist")
        ? __DIR__ . "/config/$configuration.yml.dist"
        : __DIR__ . '/config/grumphp.yml.dist';
        $content = file_get_contents($filename);
        $content = str_replace("{configuration}", $configuration, $content);
        file_put_contents(__DIR__ . '/config/grumphp.yml', $content);

        // Initialise the application with the provided config.
        $input = new ArrayInput([
            '--config' => __DIR__ . '/config/grumphp.yml',
        ]);

        // Capture the console output. Since GrumPHP requires an output that implements ConsoleOutputInterface,
        // we need to ask a separate stderr so the test trait will create the proper classes.
        // @see \Symfony\Component\Console\Output\ConsoleOutputInterface
        // @see \GrumPHP\IO\ConsoleIO::section()
        $this->initOutput(['capture_stderr_separately' => true]);

        return ContainerFactory::build($input, $this->output);
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
        $application = $container->get('GrumPHP\Console\Application');

        // Retrieve the run command from the application.
        $command = $application->find('run');
        // The run command has the GrumPHP task runner injected as dependency.
        // Since the task runner is not a public service, it cannot be accessed from the container.
        // We force the access to it by using reflections and extracting the property.
        $reflection = new \ReflectionClass($command);
        $property = $reflection->getProperty('taskRunner');
        $property->setAccessible(true);
        /** @var \GrumPHP\Runner\TaskRunner $taskRunner */
        $taskRunner = $property->getValue($command);

        // Create the task runner context with the provided parameters.
        $runnerContext = new TaskRunnerContext(
            $context,
            null,
            [$task]
        );

        return $taskRunner->run($runnerContext);
    }

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
}
