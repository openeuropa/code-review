<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\PhpCsFixer\Config;

use PhpCsFixer\Config as PhpCsFixerConfig;
use Symfony\Component\Yaml\Yaml;

/**
 * Class PHP.
 */
abstract class PHP extends PhpCsFixerConfig implements Config
{
    /**
     * @var string
     */
    public static $filename = 'resources/php-cs-fixer/phpcsfixer.rules.php.yml';

    /**
     * {@inheritdoc}
     */
    abstract public function alterCustomFixers(array &$fixers): void;

    /**
     * {@inheritdoc}
     */
    abstract public function alterRules(array &$rules): void;

    /**
     * {@inheritdoc}
     */
    final public function getCustomFixers(): array
    {
        $fixers = parent::getCustomFixers();

        // @todo: is this really required.
        $this->alterCustomFixers($fixers);

        return $fixers;
    }

    /**
     * {@inheritdoc}
     */
    final public function getRules()
    {
        $rules = parent::getRules();

        $classes = class_parents(static::class);
        array_unshift($classes, static::class);

        foreach (array_reverse(array_values($classes)) as $class) {
            if (!isset($class::$filename)) {
                continue;
            }

            $filename = __DIR__ . '/../../../' . $class::$filename;

            if (!file_exists($filename)) {
                continue;
            }

            $parsed = (array) Yaml::parseFile($filename);
            $parsed['parameters'] = (array) $parsed['parameters'] + ['rules' => []];

            $rules = array_merge($rules, $parsed['parameters']['rules']);
        }

        // @todo: is this really required.
        $this->alterRules($rules);

        ksort($rules);

        return $rules;
    }
}
