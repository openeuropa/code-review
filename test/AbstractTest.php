<?php
/**
 * Created by PhpStorm.
 * User: local-dev
 * Date: 06.04.17
 * Time: 14:15
 */

namespace EuropaCodeReview;

use GrumPHP\Configuration\ContainerFactory;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase{

  /**
   * @param $filepath
   * @return \Symfony\Component\DependencyInjection\ContainerBuilder
   */
  protected function getContainer($filepath)
  {
    return ContainerFactory::buildFromConfiguration($filepath);
  }

  /**
   * @return string
   */
  protected function getDistPath() {
    return realpath(__DIR__ . '/../dist');
  }

}