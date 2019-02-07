<?php

declare(strict_types = 1);

namespace OpenEuropa\CodeReview\Tests\Unit\PhpCsFixer\Config;

use OpenEuropa\CodeReview\PhpCsFixer\Config\Drupal8;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Drupal8Test.
 *
 * @internal
 * @coversNothing
 */
final class Drupal8Test extends TestCase
{
    /**
     * Test the config inheritance in configs.
     */
    public function testConfigRulesInheritance()
    {
        $configs = [
            'resources/php-cs-fixer/configs/phpcsfixer.rules.php.yml',
            'resources/php-cs-fixer/configs/phpcsfixer.rules.drupal.yml',
            'resources/php-cs-fixer/configs/phpcsfixer.rules.drupal8.yml',
        ];

        $rules = [];
        foreach (array_reverse($configs) as $config) {
            $yaml = Yaml::parseFile(__DIR__ . '/../../../../' . $config);
            $rules = array_merge($rules, (array) $yaml['parameters']['rules']);
        }
        ksort($rules);

        $this->assertSame($rules, (new Drupal8())->getRules());
    }
}
