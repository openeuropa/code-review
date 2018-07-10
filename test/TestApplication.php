<?php

namespace OpenEuropa\CodeReview\Test;

use GrumPHP\Configuration\ContainerFactory;
use GrumPHP\Console\Application;

/**
 * GrumPHP test application.
 */
class TestApplication extends Application
{

    /**
     * TestApplication constructor.
     *
     * @param string $path
     *      Test configuration path.
     */
    public function __construct($path)
    {
        $this->configDefaultPath = $path;
        parent::__construct();
    }

    /**
     * Get container parameter for test assertions.
     *
     * @param string $name
     *      Parameter name.
     *
     * @return mixed
     *      Parameter value.
     */
    public function getParameter($name)
    {
        return $this->container->getParameter($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainer()
    {
        if ($this->container) {
            return $this->container;
        }

        // Build the service container:
        $this->container = ContainerFactory::buildFromConfiguration($this->configDefaultPath);

        return $this->container;
    }
}
