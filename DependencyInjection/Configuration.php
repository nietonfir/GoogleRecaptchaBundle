<?php

namespace Nietonfir\Google\ReCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nietonfir_google_recaptcha');

        $rootNode
            ->children()
                ->scalarNode('sitekey')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end() // sitekey
                ->arrayNode('validation')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->children()
                        ->scalarNode('form_name')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('field_name')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end() // validation
            ->end()
        ;

        return $treeBuilder;
    }
}
