<?php

namespace Europa\CodeReview\Test;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Collection\FilesCollection;
use GrumPHP\Task\Context\GitPreCommitContext;
use RuntimeException;
use SplFileInfo;

/**
 * Tests for git commit message conventions.
 */
class PhpMessDetectorTest extends AbstractTest {

  /**
   * @param string $fixture
   *
   * @return SplFileInfo
   */
  private function getFixture($fixture) {
    $file = new SplFileInfo(__DIR__ . '/fixtures/phpmd/' . $fixture);
    if (!$file->isReadable()) {
      throw new RuntimeException(sprintf('The fixture %s could not be loaded!', $fixture));
    }

    return $file;
  }

  /**
   * Tests different git messages against the predefined conventions.
   *
   * @param string $fixture
   *   Name of the fixture.
   * @param int $expected_result
   *   Expected result after the test.
   *
   * @dataProvider commitMessageProvider
   */
  public function testPhpCodeMessage($fixture, $expected_result) {
    $container = $this->getContainer($this->getDistPath() . '/conventions.yml');
    $collection = new FilesCollection(array($this->getFixture($fixture)));
    $context = new GitPreCommitContext($collection);
    /** @var \GrumPHP\Task\TaskInterface $task */
    $task = $container->get('task.phpmd');
    $result = $task->run($context);
    $this->assertEquals($result->getResultCode(), $expected_result);
  }

  /**
   * Test case provider function.
   */
  public function commitMessageProvider() {
    return [
      ['correct-code.php', TaskResult::PASSED],
      ['incorrect-code.php', TaskResult::FAILED],
    ];
  }

}
