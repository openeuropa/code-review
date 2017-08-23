<?php

namespace EC\OpenEuropa\CodeReview\Test;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\GitPreCommitContext;

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
     * @dataProvider commitMessageProvider
     */
    public function testPhpCodeMessage($fixture, $expected)
    {
        $container = $this->getContainer($this->getDistPath().'/base-conventions.yml');
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new GitPreCommitContext($collection);
        /** @var \GrumPHP\Task\TaskInterface $task */
        $task = $container->get('task.phpmd');
        $result = $task->run($context);
        $this->assertEquals($result->getResultCode(), $expected);
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
          ['correct-code.php', TaskResult::PASSED],
          ['incorrect-code.php', TaskResult::FAILED],
        ];
    }

    /**
     * Get fixture file object.
     *
     * @param string $fixture
     *   Fixture file name.
     *
     * @return \SplFileInfo
     *   Return fixture file object.
     */
    private function getFixture($fixture)
    {
        $file = new \SplFileInfo(__DIR__.'/fixtures/phpmd/'.$fixture);
        if (!$file->isReadable()) {
            throw new \RuntimeException(sprintf('The fixture %s could not be loaded!', $fixture));
        }

        return $file;
    }
}
