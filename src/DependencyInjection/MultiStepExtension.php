<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class MultiStepExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        // parse flows
        $this->parseFlows($config['flows'], $container);
    }

    /**
     * @param string[][]       $flowsArray The raw flow configuration
     * @param ContainerBuilder $container  The container the flows should be added
     */
    private function parseFlows(array $flowsArray, ContainerBuilder $container): void
    {
        $registryDefinition = $container->getDefinition('sd.multistep.flow_registry');
        foreach ($flowsArray as $id => $stepConfig) {
            $stepConfig = $this->getStepOptions($stepConfig);
            $registryDefinition->addMethodCall('addByConfig', [$id, $stepConfig]);
        }
    }

    /**
     * @param string[] $stepConfig
     *
     * @return string[]
     */
    private function getStepOptions(array $stepConfig): array
    {
        $options = $stepConfig;
        if (isset($options['stepRequiredChecker'])) {
            $options['stepRequiredChecker'] = new Reference($options['stepRequiredChecker']);
            unset($options['stepRequiredChecker']);
        }
        return $options;
    }
}
