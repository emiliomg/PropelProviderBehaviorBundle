<?php

namespace Emiliomg\Propel\ProviderBehaviorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AddProviderBehaviorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('propel.build_properties');
        $argument = $definition->getArgument(0);

        if (!isset($argument['propel.behavior.providerBase.behavior'])) {
            $argument['propel.behavior.providerBase.behavior'] = 'vendor.emiliomg.propel-provider-behavior.src.ProviderBaseBehavior.ProviderBaseBehavior';
        }
        if (!isset($argument['propel.behavior.providerFassade.behavior'])) {
            $argument['propel.behavior.providerFassade.behavior'] = 'vendor.emiliomg.propel-provider-behavior.src.ProviderFassadeBehavior.ProviderFassadeBehavior';
        }
        $argumentDefault = isset($argument['propel.behavior.default']) ? $argument['propel.behavior.default'].', ' : '';
        $argumentDefault .= 'providerBase, providerFassade';
        $argument['propel.behavior.default'] = $argumentDefault;

        $definition->replaceArgument(0, $argument);
    }
}