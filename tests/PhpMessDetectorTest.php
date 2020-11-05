<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\RunContext;

/**
 * Tests for git commit message conventions.
 */
class PhpMessDetectorTest extends AbstractTest
{
    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $file
     *   Name of the fixture.
     * @param int $expectedResultCode
     *   Expected result after the test.
     *
     * @dataProvider dataProvider
     */
    public function testPhpCodeMessage(string $file, int $expectedResultCode): void
    {
        $application = $this->getApplication('library-conventions');

        $collection = new FilesCollection([$this->getFixture($file)]);
        $context = new RunContext($collection);

        $result = $this->runTask($application, 'phpmd', $context);
        $this->assertEquals($expectedResultCode, $result->getResultCode());
    }

    /**
     * Test case provider function.
     *
     * @return array
     *      Test data.
     */
    public function dataProvider(): array
    {
        return [
            ['phpmd/correct-code.php', TaskResult::PASSED],
            ['phpmd/incorrect-code.php', TaskResult::FAILED],
        ];
    }
}
