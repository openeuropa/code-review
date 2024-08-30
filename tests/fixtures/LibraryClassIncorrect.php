<?php

namespace OpenEuropa\CodeReview\Tests\Fixtures;

class LibraryClassIncorrect
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
      $this->unknownMethod();
    }

    public function aMethodContainingAnIncorrectlyIndentedArray()
    {
        $tasks = [
          'task' => 'append',
        ];
    }

    public function aMethodContainingAnIncorrectlyIndentedMultilineStatement()
    {
        $this
          ->userManager
          ->delete();
    }
}
