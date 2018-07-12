<?php

namespace OpenEuropa\CodeReview\Test;

use GrumPHP\Configuration\ContainerFactory;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Tests\Fixtures\DummyOutput;
use PHPUnit\Framework\TestCase;

/**
 * Abstract test class.
 */
abstract class AbstractTest extends TestCase
{

    /**
     * The convention being tested.
     *
     * This maps to the convention YAML file, without the `.yml` extension.
     *
     * @var string
     */
    protected $convention;

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
        $file = new \SplFileInfo(__DIR__.'/fixtures/phpmd/'.$fixture);
        if (!$file->isReadable()) {
            throw new \RuntimeException(sprintf('The fixture %s could not be loaded!', $fixture));
        }

        return $file;
    }

    /**
     * Getter function to return a container.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     *   Returns a container.
     */
    protected function getContainer()
    {
        $container = ContainerFactory::buildFromConfiguration($this->getConventionPath());
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
     * Returns the absolute path to the YAML file containing the convention being tested.
     *
     * @return string
     */
    protected function getConventionPath()
    {
        return $this->getDistPath().'/'.$this->convention.'.yml';
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
