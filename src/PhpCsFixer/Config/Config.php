<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\PhpCsFixer\Config;

use PhpCsFixer\ConfigInterface;

interface Config extends ConfigInterface
{

    /**
     * This hook let you alter the fixers programmatically.
     *
     * @param array $fixers
     *   The custom fixers.
     */
    public function alterCustomFixers(array &$fixers): void;
    /**
     * This hook let you alter the rules programmatically.
     *
     * @param array $rules
     *   The rules.
     */
    public function alterRules(array &$rules): void;
}
