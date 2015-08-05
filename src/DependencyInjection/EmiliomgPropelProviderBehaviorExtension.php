<?php

namespace Emiliomg\Propel\ProviderBehaviorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class EmiliomgPropelProviderBehaviorExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

//        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
//        $loader->load('services.yml');

//        Check if provider cache exists.
//        If it does, use it to set the appropriate service definitions
        $file = $container->getParameter('kernel.root_dir').'/../vendor/emiliomg/propel-provider-behavior/cache/providerCache.json';
        if (file_exists($file)) {
            $providers = json_decode(file_get_contents($file), true);
            if (JSON_ERROR_NONE == json_last_error()) {
                if (is_array($providers)) {
                    foreach ($providers as $provider) {
                        $providerId = strtolower(str_replace('\\', '_', $provider['namespace'])).
                            '.provider.'.
                            strtolower($provider['modelName']);
                        $definition = new Definition($provider['providerNamespace']);
                        $container->setDefinition($providerId, $definition);
                    }
                }
            }
        }
    }
}
