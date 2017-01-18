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
            ->fixXmlConfig('validation')
            ->children()
                ->scalarNode('sitekey')
                    ->info('The sitekey provided by reCAPTCHA.')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end() // sitekey
                ->scalarNode('secret')
                    ->info('The secret provided by reCAPTCHA.')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end() // secret
                ->arrayNode('validations')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return array(['form_name' => $v]); })
                    ->end()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('form_name')
                                ->info('The name of the form that should have a reCAPTCHA.')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('field_name')
                                ->info('The field name that will hold the reCAPTCHA.')
                                ->defaultValue('recaptcha')
                                ->treatNullLike('recaptcha')
                            ->end()
                        ->end()
                    ->end()
                ->end() // validations
            ->end()
        ;

        return $treeBuilder;
    }
}
