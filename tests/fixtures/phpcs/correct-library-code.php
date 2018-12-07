<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\Tests\Fixtures\PhpCs;

class IncorrectLibraryCode
{
    public function aMethodContainingCorrectArrayIndentation()
    {
        $tasks = [
            'task' => 'append',
        ];
    }

    public function aMethodContainingCorrectMultilineStatementIndentation()
    {
        $this
            ->userManager
            ->getUser()
            ->delete();
    }

    /**
     * A correctly indented docblock.
     */
    public function aMethodWithCorrectDocblockIndentation()
    {
    }
}
