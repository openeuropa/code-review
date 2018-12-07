<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\Tests\Fixtures\PhpCs;

class IncorrectLibraryCode
{
    public function aMethodContainingAnIncorrectlyIndentedArray()
    {
        $tasks = [
            'task' => 'append',
        ];
    }

    public function aMethodContainingAnIncorrectlyIndentedMultilineStatement()
    {
        $this->userManager
            ->delete();
    }

    /**
     * An incorrectly indented docblock.
     */
    public function aMethodWithAnIncorrectlyIndentedDocblock()
    {
    }

    /**
     * An incorrectly indented docblock.
     */
    public function anotherMethodWithAnIncorrectlyIndentedDocblock()
    {
    }
}
