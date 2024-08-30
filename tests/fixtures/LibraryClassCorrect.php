<?php

namespace OpenEuropa\CodeReview\Tests\Fixtures;

class LibraryClassCorrect
{
    private $userManager;

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
