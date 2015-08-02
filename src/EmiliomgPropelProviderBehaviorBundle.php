<?php

namespace Emiliomg\Propel\ProviderBehaviorBundle;

use Emiliomg\Propel\ProviderBehaviorBundle\DependencyInjection\EmiliomgPropelProviderBehaviorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Emiliomg\Propel\ProviderBehaviorBundle\DependencyInjection\Compiler\AddProviderBehaviorCompilerPass;

class EmiliomgPropelProviderBehaviorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddProviderBehaviorCompilerPass());
    }
}
