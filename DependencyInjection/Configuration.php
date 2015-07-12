<?php

/**
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Sg\DatatablesBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sg_datatables');

        $this->addLayoutSection($rootNode);
        $this->addRoutesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Add layout section.
     *
     * @param ArrayNodeDefinition $rootNode
     */
    private function addLayoutSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('default_layout')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('templates')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('base')->defaultValue('SgDatatablesBundle:Datatable:datatable.html.twig')->end()
                                ->scalarNode('html')->defaultValue('SgDatatablesBundle:Datatable:datatable_html.html.twig')->end()
                                ->scalarNode('js')->defaultValue('SgDatatablesBundle:Datatable:datatable_js.html.twig')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Add routes section.
     *
     * @param ArrayNodeDefinition $rootNode
     */
    private function addRoutesSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('routes')
                    ->requiresAtLeastOneElement()
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('fields')
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('route')
                                ->isRequired()
                            ->end()
                            ->arrayNode('show')
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('new')
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('edit')
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('roles')
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('route')
                                ->isRequired()
                            ->end()
                            ->scalarNode('index')->end()
                            ->scalarNode('show')->end()
                            ->scalarNode('new')->end()
                            ->scalarNode('edit')->end()
                            ->scalarNode('delete')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
