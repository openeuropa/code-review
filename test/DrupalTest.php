<?php

namespace OpenEuropa\CodeReview\Test;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\GitPreCommitContext;

/**
 * Tests for Drupal conventions.
 */
class DrupalTest extends AbstractTest
{

    /**
     * {@inheritdoc}
     */
    protected $convention = 'drupal-conventions';

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
     * Test file extensions.
     *
     * @return array
     *      Test data.
     */
    public function commitMessageProvider()
    {
        return [
          ['correct-code.inc', TaskResult::PASSED],
          ['correct-code.module', TaskResult::PASSED],
          ['correct-code.theme', TaskResult::PASSED],
          ['ignored-code.xxx', TaskResult::SKIPPED],
        ];
    }
}
