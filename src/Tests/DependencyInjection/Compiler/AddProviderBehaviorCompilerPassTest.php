<?php

namespace EmilioMg\Propel\ProviderBehaviorBundle\Tests\DependencyInjection\Compiler;

use EmilioMg\Propel\ProviderBehaviorBundle\DependencyInjection\Compiler\AddProviderBehaviorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class AddProviderBehaviorCompilerPassTest
 *
 * @author  Emilio Markgraf <emilio.markgraf@krankikom.de>
 * @package EmilioMg\Propel\ProviderBehaviorBundle\Tests\DependencyInjection\Compiler
 */
class AddProviderBehaviorCompilerPassTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $container = new ContainerBuilder();

        $propelDefinition = new Definition();
        $propelDefinition->addArgument([]);

        $container->setDefinition('propel.build_properties', $propelDefinition);
        $container->setParameter('kernel.root_dir', '.');

        $compilerPass = new AddProviderBehaviorCompilerPass();
        $compilerPass->process($container);

        $argument = $propelDefinition->getArgument(0);
        $this->assertArrayHasKey('propel.behavior.providerBase.behavior', $argument, 'Build properties should include the provider base behavior');
        $this->assertArrayHasKey('propel.behavior.providerFassade.behavior', $argument, 'Build properties should include the provider fassade behavior');
        $this->assertArrayHasKey('propel.behavior.default', $argument, 'Build properties should include the behavior default run list');

        $runList = array_map(function($key) { return trim($key); }, explode(',', $argument['propel.behavior.default']));
        $this->assertContains('providerBase', $runList, 'Build property default run list should include provider base behavior');
        $this->assertContains('providerFassade', $runList, 'Build property default run list should include provider fassade behavior');
    }
}