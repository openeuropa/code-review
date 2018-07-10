<?php

namespace OpenEuropa\CodeReview;

use GrumPHP\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Extension that allows to define extra tasks on local grumphp.yml.dist.
 */
class ExtraTasksExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container)
    {
        if ($container->hasParameter('extra_tasks')) {
            $tasks = $container->getParameter('tasks');
            foreach ($container->getParameter('extra_tasks') as $name => $value) {
                $tasks[$name] = $value;
            }
            $container->setParameter('tasks', $tasks);
        }
    }
}
