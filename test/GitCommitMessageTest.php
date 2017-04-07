<?php

namespace Europa\CodeReview\Test;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\GitCommitMsgContext;
use GrumPHP\Collection\FilesCollection;

/**
 * Tests for git commit message conventions.
 */
class GitCommitMessageTest extends AbstractTest {

  /**
   * Tests different git messages against the predefined conventions.
   *
   * @param string $message
   *   Commit message to test.
   * @param int $expected_result
   *   Expected result after the test.
   *
   * @dataProvider commitMessageProvider
   */
  public function testCommitMessage($message, $expected_result) {
    $container = $this->getContainer($this->getDistPath() . '/conventions.yml');
    $collection = new FilesCollection();
    $context = new GitCommitMsgContext($collection, $message, '', '');
    /** @var \GrumPHP\Task\TaskInterface $task */
    $task = $container->get('task.git.commitmessage');
    $result = $task->run($context);
    $this->assertEquals($result->getResultCode(), $expected_result);
  }

  /**
   * Test case provider function.
   */
  public function commitMessageProvider() {
    return [
      ['#3: Nice GitHub commit message.', TaskResult::PASSED],
      ['NEPT-123: Nice Jira commit message.', TaskResult::PASSED],
      ['Failed message', TaskResult::FAILED],
    ];
  }

}
