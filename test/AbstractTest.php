<?php

namespace OpenEuropa\CodeReview\Test;

use GrumPHP\Configuration\ContainerFactory;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Tests\Fixtures\DummyOutput;

/**
 * Abstract test class.
 */
abstract class AbstractTest extends \PHPUnit_Framework_TestCase
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
        $file = new \SplFileInfo(__DIR__.'/fixtures/phpmd/'.$fixture);
        if (!$file->isReadable()) {
            throw new \RuntimeException(sprintf('The fixture %s could not be loaded!', $fixture));
        }

        return $file;
    }

    /**
     * Getter function to return a container.
     *
     * @param string $filepath
     *   Real path of the conventions file.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     *   Returns a container.
     */
    protected function getContainer($filepath)
    {
        $container = ContainerFactory::buildFromConfiguration($filepath);
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
}
