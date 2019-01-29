<?php

declare(strict_types = 1);

$finder = PhpCsFixer\Finder::create()
    ->exclude(['node_modules', 'vendor', 'build', 'web', 'tests/fixtures'])
    ->name('*.inc')
    ->name('*.install')
    ->name('*.module')
    ->name('*.profile')
    ->name('*.php')
    ->in($_SERVER['PWD']);

return PhpCsFixer\Config::create()
    ->registerCustomFixers([
        new OpenEuropa\CodeReview\PhpCsFixer\Fixer\UppercaseConstantsFixer(),
    ])
    ->setFinder($finder);
