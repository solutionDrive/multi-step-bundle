<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('multi_step');

        $rootNode
            ->children()
                ->arrayNode('flows')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('slug')->end()
                            ->arrayNode('steps')
                                ->arrayPrototype()
                                    ->children()
                                        ->scalarNode('alias')->defaultValue('')->end()
                                        ->scalarNode('slug')->end()
                                        ->scalarNode('template')->defaultValue('')->end()
                                        ->scalarNode('controller')
                                            ->defaultValue(
                                                'solutionDrive\MultiStepBundle\Controller\DefaultStepController::renderAction'
                                            )
                                        ->end()
                                        ->booleanNode('skippable')->defaultFalse()->end()
                                        ->scalarNode('stepRequiredChecker')
                                            ->defaultValue('sd.multistep.step_checker.default')
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
