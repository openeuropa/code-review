<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\Tests;

use GrumPHP\Collection\FilesCollection;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\GitPreCommitContext;

/**
 * Tests for yaml lint conventions.
 *
 * @internal
 * @coversNothing
 */
final class YamlLintTest extends AbstractTest
{
    /**
     * Tests different yaml files against the predefined conventions.
     *
     * @param string $fixture
     *   Name of the fixture
     * @param int $expected
     *   Expected result after the test
     *
     * @dataProvider yamlProvider
     *
     * @throws \Exception
     */
    public function testYamlLint($fixture, $expected)
    {
        $collection = new FilesCollection([$this->getFixture($fixture)]);
        $context = new GitPreCommitContext($collection);
        $task = $this->getTask('yamllint', 'base-conventions');
        $result = $task->run($context);
        $this->assertEquals($expected, $result->getResultCode());
    }

    /**
     * Test case provider function.
     *
     * @return array
     *      Test data
     */
    public function yamlProvider()
    {
        return [
            ['lint/correct-yml.yml', TaskResult::PASSED],
            ['lint/incorrect-yml.yml', TaskResult::FAILED],
        ];
    }
}
