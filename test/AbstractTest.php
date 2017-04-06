<?php

namespace Europa\CodeReview\Test;

use GrumPHP\Configuration\ContainerFactory;

/**
 * Abstract test class.
 */
abstract class AbstractTest extends \PHPUnit_Framework_TestCase {

  /**
   * Getter function to return a container.
   *
   * @param string $filepath
   *   Real path of the conventions file.
   *
   * @return \Symfony\Component\DependencyInjection\ContainerBuilder
   *   Returns a container.
   */
  protected function getContainer($filepath) {
    return ContainerFactory::buildFromConfiguration($filepath);
  }

  /**
   * Getter function to return the dist folder path.
   *
   * @return string
   *   Returns the real path of the dist folder
   */
  protected function getDistPath() {
    return realpath(__DIR__ . '/../dist');
  }

}
