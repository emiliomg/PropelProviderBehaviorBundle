<?php

namespace EmilioMg\Propel\ProviderBehaviorBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use EmilioMg\Propel\ProviderBehaviorBundle\DependencyInjection\Compiler\AddProviderBehaviorCompilerPass;

class EmilioMgPropelProviderBehaviorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddProviderBehaviorCompilerPass());
    }
}
