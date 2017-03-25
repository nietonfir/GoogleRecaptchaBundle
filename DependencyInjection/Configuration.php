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
                    ->info('The sitekey provided by reCAPTCHA.')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end() // sitekey
                ->scalarNode('secret')
                    ->info('The secret provided by reCAPTCHA.')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end() // secret
                ->arrayNode('validation')
                    ->fixXmlConfig('form')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return array('forms' => [['form_name' => $v]]); })
                    ->end()
                    ->beforeNormalization()
                        ->ifTrue(function ($v) { return is_array($v) && array_key_exists('form_name', $v); })
                        ->then(function ($v) {
                            @trigger_error('Specifying "validation.form_name" & "validation.field_name" will be removed in future versions. Use the "validation.forms" node for configuration.', E_USER_DEPRECATED);

                            return array('forms' => [$v]);
                        })
                    ->end()
                    ->beforeNormalization()
                        ->ifTrue(function ($v) { return is_array($v) && !array_key_exists('forms', $v) && !array_key_exists('form', $v); })
                        ->then(function ($v) {
                            return array('forms' => array_map(function($a) {
                                return ['form_name' => $a];
                            }, $v));
                        })
                    ->end()
                    ->children()
                        ->scalarNode('form_name')
                            ->info('The name of the form that should have a reCAPTCHA.')
                        ->end()
                        ->scalarNode('field_name')
                            ->info('The field name that will hold the reCAPTCHA.')
                            ->defaultValue('recaptcha')
                            ->treatNullLike('recaptcha')
                        ->end()
                        ->arrayNode('forms')
                            ->isRequired()
                            ->cannotBeEmpty()
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
                        ->end() // forms
                    ->end()
                ->end() // validation
            ->end()
        ;

        return $treeBuilder;
    }
}
