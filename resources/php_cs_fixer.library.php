<?php

declare(strict_types = 1);

$finder = PhpCsFixer\Finder::create()
    ->exclude(['node_modules', 'vendor', 'build', 'web', 'tests/fixtures'])
    ->name('*.php')
    ->in($_SERVER['PWD']);

return PhpCsFixer\Config::create()
    ->registerCustomFixers([
        new OpenEuropa\CodeReview\PhpCsFixer\Fixer\UppercaseConstantsFixer(),
    ])
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setFinder($finder);
