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
     * @param string $fixture
     *   Name of the fixture.
     * @param int    $expected
     *   Expected result after the test.
     *
     * @dataProvider dataProvider
     */
    public function testPhpCodeMessage($fixture, $expected)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new RunContext($collection);
        $task = $this->getTask('phpmd', 'base-conventions');
        $result = $task->run($context);
        $this->assertEquals($expected, $result->getResultCode());
    }

    /**
     * Test case provider function.
     *
     * @return array
     *      Test data.
     */
    public function dataProvider()
    {
        return [
            ['phpmd/correct-code.php', TaskResult::PASSED],
            ['phpmd/incorrect-code.php', TaskResult::FAILED],
        ];
    }
}
