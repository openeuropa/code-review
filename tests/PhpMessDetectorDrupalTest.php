<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\RunContext;

/**
 * Tests for Drupal conventions.
 */
class PhpMessDetectorDrupalTest extends AbstractTest
{

    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $fixture
     *   Name of the fixture.
     * @param int    $expected
     *   Expected result after the test.
     *
     * @dataProvider dataProvider
     */
    public function testPhpMessDetector(string $fixture, int $expected): void
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new RunContext($collection);
        $result = $this->runTask('drupal-conventions', 'phpmd', $context);
        $this->assertEquals($expected, $result->getResultCode());
    }

    /**
     * Test case provider function.
     *
     * Test file extensions.
     *
     * @return array
     *      Test data.
     */
    public function dataProvider()
    {
        return [
            ['phpmd/correct-code.inc', TaskResult::PASSED],
            ['phpmd/correct-code.module', TaskResult::PASSED],
            ['phpmd/correct-code.theme', TaskResult::PASSED],
            ['phpmd/ignored-code.xxx', TaskResult::SKIPPED],
        ];
    }
}
