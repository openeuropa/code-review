<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Configuration\ContainerBuilder;
use GrumPHP\Configuration\ContainerFactory;
use Symfony\Component\Console\Input\ArgvInput;
use OpenEuropa\CodeReview\DummyOutput;
use PHPUnit\Framework\TestCase;

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
     * Build container from target "./dist" configuration file.
     *
     * @param string $configuration
     *   Configuration file name from which to build the container from.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected function getContainer($configuration)
    {
        // Create a GrumPHP configuration file to use in the test. Check if a configuration specific file exists, or
        // fall back to a generic template file.
        $filename = file_exists(__DIR__."/$configuration.yml.dist") ? __DIR__."/$configuration.yml.dist" : __DIR__.'/grumphp.yml.dist';
        $content = file_get_contents($filename);
        $content = str_replace("{configuration}", $configuration, $content);
        file_put_contents(__DIR__."/grumphp.yml", $content);

        $container = ContainerBuilder::buildFromConfiguration(__DIR__.'/grumphp.yml');
        $container->set('console.input', new ArgvInput());
        $container->set('console.output', new DummyOutput());

        return $container;
    }

    /**
     * Getter function to return the dist folder path.
     *
     * @return string
     *   Returns the real path of the dist folder
     */
    protected function getDistPath()
    {
        return realpath(__DIR__.'/../dist');
    }

    /**
     * Returns the task with the given name.
     *
     * @param string $name
     *   The name of the task to return.
     * @param string $configuration
     *   Configuration file name from which to build the container from.
     *
     * @return \GrumPHP\Task\TaskInterface
     *
     * @throws \Exception
     *   Thrown when the task with the given name does not exist, or if the task runner service is not registered.
     */
    protected function getTask($name, $configuration)
    {
        $container = $this->getContainer($configuration);
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
