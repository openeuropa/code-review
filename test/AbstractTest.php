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
}
