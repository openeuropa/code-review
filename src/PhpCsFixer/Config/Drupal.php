<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\PhpCsFixer\Config;

use OpenEuropa\CodeReview\PhpCsFixer\Fixer\UppercaseConstantsFixer;

/**
 * Class Drupal.
 */
abstract class Drupal extends PHP
{
    /**
     * @var string
     */
    public static $filename = 'resources/php-cs-fixer/configs/phpcsfixer.rules.drupal.yml';

    /**
     * {@inheritdoc}
     */
    public function alterCustomFixers(array &$fixers): void
    {
        $fixers[] = new UppercaseConstantsFixer();
    }

    /**
     * {@inheritdoc}
     */
    public function alterRules(array &$rules): void
    {
    }
}
