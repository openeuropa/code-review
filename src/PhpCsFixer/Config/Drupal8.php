<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\PhpCsFixer\Config;

/**
 * Class Drupal8.
 */
class Drupal8 extends Drupal
{
    /**
     * @var string
     */
    public static $filename = 'resources/php-cs-fixer/phpcsfixer.rules.drupal8.yml';

    /**
     * {@inheritdoc}
     */
    public function getFinder()
    {
        $finder = parent::getFinder(); // TODO: Change the autogenerated stub

        $finder->exclude(['node_modules', 'vendor', 'build', 'web', 'tests/fixtures'])
            ->name('*.inc')
            ->name('*.install')
            ->name('*.module')
            ->name('*.profile')
            ->name('*.php')
            ->name('*.theme')
            ->in($_SERVER['PWD']);

        return $finder;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openeuropa/code-review/drupal8';
    }
}
