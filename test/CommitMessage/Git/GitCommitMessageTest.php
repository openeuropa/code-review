<?php

namespace EuropaCodeReview\CommitMessage\Git;

use EuropaCodeReview\AbstractTest;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\GitCommitMsgContext;
use GrumPHP\Collection\FilesCollection;

class GitCommitMessageTest extends AbstractTest {

  /**
   * @param string $message
   * @param int $expected_result
   * @dataProvider commitMessageProvider
   */
  public function testCommitMessage($message, $expected_result)
  {
    $container = $this->getContainer($this->getDistPath() . '/conventions.yml');
    $collection = new FilesCollection();
    $context = new GitCommitMsgContext($collection, $message, '', '');
    /** @var \GrumPHP\Task\TaskInterface $task */
    $task = $container->get('task.git.commitmessage');
    $result = $task->run($context);
    $this->assertEquals($result->getResultCode(), $expected_result);
  }

  public function commitMessageProvider()
  {
    return [
      ['#3: Nice commit message.', TaskResult::PASSED],
      ['Failed message', TaskResult::FAILED],
    ];
  }

}