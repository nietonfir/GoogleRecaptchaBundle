<?php

/*
 * This file is part of the NietonfirGoogleReCaptchaBundle package.
 *
 * (c) nietonfir <nietonfir@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nietonfir\Google\ReCaptchaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class NietonfirGoogleReCaptchaExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * This is the object that loads and manages the bundle's configuration
     *
     * @var NietonfirGoogleReCaptchaExtension
     */
    private $extension;

    /**
     * Root name of the configuration
     *
     * @var string
     */
    private $root;

    public function setUp()
    {
        $this->extension = $this->getExtension();
        $this->root      = 'nietonfir_google_recaptcha';
    }

    public function testLoadConfigDefaults()
    {
        $key       = '1234567';
        $secret    = 's3cr3T';
        $formName  = 'example_form_name';
        $fieldName = 'recaptcha';

        $configs = array(
            array(
                'sitekey'    => $key,
                'secret'     => $secret,
                'validation' => array(
                    'form_name'  => $formName,
                    'field_name' => null
                )
            )
        );
        $container = $this->getContainer();

        $this->extension->load($configs, $container);

        $this->assertTrue($container->hasParameter($this->root . '.sitekey'));
        $this->assertEquals($key, $container->getParameter($this->root . '.sitekey'));

        $this->assertTrue($container->hasParameter($this->root . '.secret'));
        $this->assertEquals($secret, $container->getParameter($this->root . '.secret'));

        // validation by itself isn't exposed!
        $this->assertTrue($container->hasParameter($this->root . '.validation.form_name'));
        $this->assertEquals($formName, $container->getParameter($this->root . '.validation.form_name'));

        $this->assertTrue($container->hasParameter($this->root . '.validation.field_name'));
        $this->assertEquals($fieldName, $container->getParameter($this->root . '.validation.field_name'));
    }

    public function testLoadConfigCustom()
    {
        $key       = '1234567';
        $secret    = 's3cr3T';
        $formName  = 'example_form_name';
        $fieldName = 'my_field_name';

        $configs = array(
            array(
                'sitekey'    => $key,
                'secret'     => $secret,
                'validation' => array(
                    'form_name'  => $formName,
                    'field_name' => $fieldName
                )
            )
        );
        $container = $this->getContainer();

        $this->extension->load($configs, $container);

        $this->assertTrue($container->hasParameter($this->root . '.sitekey'));
        $this->assertEquals($key, $container->getParameter($this->root . '.sitekey'));

        $this->assertTrue($container->hasParameter($this->root . '.secret'));
        $this->assertEquals($secret, $container->getParameter($this->root . '.secret'));

        // validation by itself isn't exposed!
        $this->assertTrue($container->hasParameter($this->root . '.validation.form_name'));
        $this->assertEquals($formName, $container->getParameter($this->root . '.validation.form_name'));

        $this->assertTrue($container->hasParameter($this->root . '.validation.field_name'));
        $this->assertNotEquals('recaptcha', $container->getParameter($this->root . '.validation.field_name'));
        $this->assertEquals($fieldName, $container->getParameter($this->root . '.validation.field_name'));
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testInvalidConfig()
    {
        $configs = array(
            array() // since everything is required an empty config should trigger an excpetion
        );
        $container = $this->getContainer();

        $this->extension->load($configs, $container);
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testEmptyConfigValues()
    {
        $configs = array(
            array(
                'sitekey'    => '',
                'secret'     => '',
                'validation' => array(
                    'form_name'  => '',
                    'field_name' => ''
                )
            )
        );
        $container = $this->getContainer();

        $this->extension->load($configs, $container);
    }

    /**
     * @return NietonfirGoogleReCaptchaExtension
     */
    protected function getExtension()
    {
        return new NietonfirGoogleReCaptchaExtension();
    }

    /**
     * @return ContainerBuilder
     */
    private function getContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }
}
