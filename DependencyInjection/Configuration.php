<?php

namespace Oh\GoogleMapFormTypeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        
        $rootNode = $treeBuilder->root('oh_google_map_form_type');

        $rootNode
            ->children()
                ->scalarNode('api_key')->isRequired()->cannotBeEmpty()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
