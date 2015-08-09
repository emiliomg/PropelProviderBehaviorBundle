<?php

namespace EmilioMg\Propel\ProviderBehaviorBundle\DependencyInjection\Compiler;

use EmilioMg\Propel\ProviderBehaviorBundle\Exception\MissingDefinitionException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class AddProviderBehaviorCompilerPass
 *
 * @author  Emilio Markgraf <emilio.markgraf@gmail.com>
 * @package EmilioMg\Propel\ProviderBehaviorBundle\DependencyInjection\Compiler
 */
class AddProviderBehaviorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

//        Reconfigure Propel Bundle to build all the models with a provider
        if (!$container->hasDefinition('propel.build_properties')) {
            throw new MissingDefinitionException('Propel build_properties container definition is missing. Is the PropelBundle loaded in the AppKernel?');
        }

        $definition = $container->getDefinition('propel.build_properties');
        $argument = $definition->getArgument(0);

//        Register BaseBehavior
        if (!isset($argument['propel.behavior.providerBase.behavior'])) {
            $argument['propel.behavior.providerBase.behavior'] = 'vendor.emiliomg.propel-provider-behavior.src.ProviderBaseBehavior.ProviderBaseBehavior';
        }
//        Register FassadeBehavior
        if (!isset($argument['propel.behavior.providerFassade.behavior'])) {
            $argument['propel.behavior.providerFassade.behavior'] = 'vendor.emiliomg.propel-provider-behavior.src.ProviderFassadeBehavior.ProviderFassadeBehavior';
        }
//        Register both behaviors as defaulf behaviors
        $argumentDefault = isset($argument['propel.behavior.default']) ? $argument['propel.behavior.default'].', ' : '';
        $argumentDefault .= 'providerBase, providerFassade';
        $argument['propel.behavior.default'] = $argumentDefault;

//        Enable cacheFile generation
        if (!isset($argument['propel.behavior.provider.cachefile'])) {
            $argument['propel.behavior.provider.cachefile'] = 'true';
        }

        $definition->replaceArgument(0, $argument);


//        Check if provider cache exists.
//        If it does, use it to set the appropriate service definitions
        $file = $container->getParameter('kernel.root_dir').'/propel/providerCache.json';
        if (file_exists($file)) {
            $providers = json_decode(file_get_contents($file), true);
            if (JSON_ERROR_NONE == json_last_error()) {
                if (is_array($providers)) {
                    foreach ($providers as $provider) {
                        $providerFullName = $provider['namespace'].'\\'.$provider['providerName'];
                        $providerId = strtolower(
                            $provider['package'].
                            '.provider.'.
                            strtolower($provider['modelName'])
                        );
                        if ('src.' === substr($providerId, 0, 4)) {
                            $providerId = substr($providerId, 4);
                        }

                        $definition = new Definition($providerFullName);
                        $container->setDefinition($providerId, $definition);
                    }
                }
            }
        }
    }
}