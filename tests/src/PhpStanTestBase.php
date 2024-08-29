<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\RunContext;

/**
 * Tests for PHPStan conventions.
 */
abstract class PhpStanTestBase extends AbstractTest
{
    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $file
     *   Name of the fixture.
     * @param string $configuration
     *   The name of the configuration to use in the task
     * @param int $expectedFailures
     *   Expected result after the test.
     *
     * @dataProvider dataProvider
     */
    public function testPhpCodeMessage(string $file, string $configuration, int $expectedResultCode): void
    {
        $collection = new FilesCollection([$this->getFixture($file)]);
        $context = new RunContext($collection);
        $result = $this->runTask($configuration, 'phpstan', $context);
        $this->assertEquals($expectedResultCode, $result->getResultCode(), "Failed on $file expected code $expectedResultCode");
    }

    /**
     * Test case provider function.
     *
     * @return array
     *   Test data.
     */
    public function dataProvider(): array
    {
        return [
        ];
    }
}
