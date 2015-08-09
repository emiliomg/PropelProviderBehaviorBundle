<?php

namespace EmilioMg\Propel\ProviderBehaviorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('emilio_mg_propel_provider_behavior');

        $rootNode
            ->children()
                ->booleanNode('auto_generate_services')
                    ->defaultTrue()
                ->end()
                ->scalarNode('prefix')
                    ->defaultValue('')
                ->end()
                ->scalarNode('suffix')
                    ->defaultValue('')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
