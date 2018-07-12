<?php

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\GitPreCommitContext;

/**
 * Tests for git commit message conventions.
 */
class PhpMessDetectorTest extends AbstractTest
{

    /**
     * {@inheritdoc}
     */
    protected $convention = 'base-conventions';

    /**
     * Tests different git messages against the predefined conventions.
     *
     * @param string $fixture
     *   Name of the fixture.
     * @param int    $expected
     *   Expected result after the test.
     *
     * @dataProvider commitMessageProvider
     */
    public function testPhpCodeMessage($fixture, $expected)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new GitPreCommitContext($collection);
        $task = $this->getTask('phpmd');
        $result = $task->run($context);
        $this->assertEquals($expected, $result->getResultCode());
    }

    /**
     * Test case provider function.
     *
     * @return array
     *      Test data.
     */
    public function commitMessageProvider()
    {
        return [
          ['phpmd/correct-code.php', TaskResult::PASSED],
          ['phpmd/incorrect-code.php', TaskResult::FAILED],
        ];
    }
}
