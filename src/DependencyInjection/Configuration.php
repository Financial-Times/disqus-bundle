<?php

namespace Inviqa\DisqusBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Returns the config tree builder.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('inviqa_disqus')
            ->children()
                ->scalarNode('public_key')->isRequired()->end()
                ->scalarNode('secret_key')->isRequired()->end()
                ->scalarNode('forum_name')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
