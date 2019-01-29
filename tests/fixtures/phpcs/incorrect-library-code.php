<?php

namespace OpenEuropa\CodeReview\Tests\Fixtures\PhpCs;

class IncorrectLibraryCode
{

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
}
