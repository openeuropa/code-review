<?php

namespace OpenEuropa\CodeReview\Tests\Fixtures\PhpCs;

class IncorrectLibraryCode
{

    /**
     * A correctly indented docblock.
     */
    public function aMethodWithCorrectDocblockIndentation()
    {
    }

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
}
