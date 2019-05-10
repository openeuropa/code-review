<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\GitPreCommitContext;

/**
 * Tests for git commit message conventions.
 *
 * @internal
 * @coversNothing
 */
final class JsonLintTest extends AbstractTest
{
    /**
     * Test case provider function.
     *
     * @return array
     *      Test data
     */
    public function jsonProvider()
    {
        return [
            ['lint/incorrect-json.json', TaskResult::FAILED],
            ['lint/correct-json.json', TaskResult::PASSED],
        ];
    }

    /**
     * Tests different json files against the predefined conventions.
     *
     * @param string $fixture
     *   Name of the fixture
     * @param int $expected
     *   Expected result after the test
     *
     * @dataProvider jsonProvider
     *
     * @throws \Exception
     */
    public function testJsonLint($fixture, $expected)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new GitPreCommitContext($collection);
        $task = $this->getTask('jsonlint', 'base-conventions');
        $result = $task->run($context);
        static::assertEquals($expected, $result->getResultCode());
    }
}
