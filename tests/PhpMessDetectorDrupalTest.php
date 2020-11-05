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
     * @param string $file
     *   Name of the fixture.
     * @param int    $expectedResultCode
     *   Expected result after the test.
     *
     * @dataProvider dataProvider
     */
    public function testPhpMessDetector(string $file, int $expectedResultCode): void
    {
        $application = $this->getApplication('drupal-conventions');

        $collection = new FilesCollection([$this->getFixture($file)]);
        $context = new RunContext($collection);

        $result = $this->runTask($application, 'phpmd', $context);
        $this->assertEquals($expectedResultCode, $result->getResultCode());
    }

    /**
     * Test case provider function.
     *
     * Test file extensions.
     *
     * @return array
     *      Test data.
     */
    public function dataProvider(): array
    {
        return [
            ['phpmd/correct-code.inc', TaskResult::PASSED],
            ['phpmd/correct-code.module', TaskResult::PASSED],
            ['phpmd/correct-code.theme', TaskResult::PASSED],
            ['phpmd/ignored-code.xxx', TaskResult::SKIPPED],
        ];
    }
}
