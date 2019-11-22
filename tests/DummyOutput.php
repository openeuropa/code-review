<?php

namespace OpenEuropa\CodeReview\Tests;

use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Dummy output.
 */
class DummyOutput extends BufferedOutput
{
    public function getLogs(): array
    {
        $logs = [];
        foreach (explode(PHP_EOL, trim($this->fetch())) as $message) {
            preg_match('/^\[(.*)\] (.*)/', $message, $matches);
            $logs[] = sprintf('%s %s', $matches[1], $matches[2]);
        }
        return $logs;
    }
}
