<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\PhpCsFixer\Config;

/**
 * Class Libraries.
 */
class Libraries extends PHP7
{
    /**
     * @var string
     */
    public static $filename = 'resources/php-cs-fixer/configs/phpcsfixer.rules.libraries.yml';

    /**
     * {@inheritdoc}
     */
    public function alterCustomFixers(array &$fixers): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function alterRules(array &$rules): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getFinder()
    {
        $finder = parent::getFinder();

        $finder
            ->exclude(['node_modules', 'vendor', 'build', 'web', 'tests/fixtures'])
            ->name('*.php')
            ->in($_SERVER['PWD']);

        return $finder;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'drupol/drupal-conventions/drupal8';
    }
}
