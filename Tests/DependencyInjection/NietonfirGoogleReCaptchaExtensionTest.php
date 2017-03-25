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

    public function testLoadSimpleConfig()
    {
        $key       = '1234567';
        $secret    = 's3cr3T';
        $formName  = 'example_form_name';
        $fieldName = 'recaptcha'; // default value

        $configs = array(
            array(
                'sitekey'    => $key,
                'secret'     => $secret,
                'validation' => $formName
            )
        );
        $container = $this->getContainer();

        $this->extension->load($configs, $container);

        $this->assertRecaptchaConfig($container, $key, $secret);

        $this->assertTrue($container->hasParameter($this->root . '.validations'));

        $forms = $container->getParameter($this->root . '.validations');
        $this->assertInternalType('array', $forms);
        $this->assertNotEmpty($forms);
        $this->assertCount(1, $forms);
        $this->assertArrayHasKey($formName, $forms);
        $this->assertEquals($fieldName, $forms[$formName]);
    }

    public function testLoadSimpleConfigWithMultipleForms()
    {
        $key       = '1234567';
        $secret    = 's3cr3T';
        $formName0 = 'form_A';
        $formName1 = 'form_B';
        $formName2 = 'form_C';
        $fieldName = 'recaptcha'; // default value

        $configs = array(
            array(
                'sitekey'    => $key,
                'secret'     => $secret,
                'validation' => array($formName0, $formName1, $formName2)
            )
        );
        $container = $this->getContainer();

        $this->extension->load($configs, $container);

        $this->assertRecaptchaConfig($container, $key, $secret);

        $this->assertTrue($container->hasParameter($this->root . '.validations'));

        $forms = $container->getParameter($this->root . '.validations');
        $this->assertInternalType('array', $forms);
        $this->assertNotEmpty($forms);
        $this->assertCount(3, $forms);
        $this->assertArrayHasKey($formName0, $forms);
        $this->assertEquals($fieldName, $forms[$formName0]);
        $this->assertArrayHasKey($formName1, $forms);
        $this->assertEquals($fieldName, $forms[$formName1]);
        $this->assertArrayHasKey($formName2, $forms);
        $this->assertEquals($fieldName, $forms[$formName2]);
    }

    public function testLoadConfig()
    {
        $key       = '1234567';
        $secret    = 's3cr3T';
        $formName  = 'an_example_name';
        $fieldName = 'recaptcha'; // default value

        $configs = array(
            array(
                'sitekey'    => $key,
                'secret'     => $secret,
                'validation' => array(
                    'forms' => array(
                        array('form_name' => $formName)
                    )
                )
            )
        );
        $container = $this->getContainer();

        $this->extension->load($configs, $container);

        $this->extension->load($configs, $container);

        $this->assertRecaptchaConfig($container, $key, $secret);

        $this->assertTrue($container->hasParameter($this->root . '.validations'));

        $forms = $container->getParameter($this->root . '.validations');
        $this->assertInternalType('array', $forms);
        $this->assertNotEmpty($forms);
        $this->assertCount(1, $forms);
        $this->assertArrayHasKey($formName, $forms);
        $this->assertEquals($fieldName, $forms[$formName]);
    }

    public function testLoadConfigWithMultipleForms()
    {
        $key       = '1234567';
        $secret    = 's3cr3T';
        $formName0 = 'form_A';
        $formName1 = 'form_B';
        $formName2 = 'form_C';
        $fieldName = 'recaptcha'; // default value

        $configs = array(
            array(
                'sitekey'    => $key,
                'secret'     => $secret,
                'validation' => array(
                    'forms' => array(
                        array('form_name' => $formName0),
                        array('form_name' => $formName1),
                        array('form_name' => $formName2)
                    )
                )
            )
        );
        $container = $this->getContainer();

        $this->extension->load($configs, $container);

        $this->assertRecaptchaConfig($container, $key, $secret);

        $this->assertTrue($container->hasParameter($this->root . '.validations'));

        $forms = $container->getParameter($this->root . '.validations');
        $this->assertInternalType('array', $forms);
        $this->assertNotEmpty($forms);
        $this->assertCount(3, $forms);
        $this->assertArrayHasKey($formName0, $forms);
        $this->assertEquals($fieldName, $forms[$formName0]);
        $this->assertArrayHasKey($formName1, $forms);
        $this->assertEquals($fieldName, $forms[$formName1]);
        $this->assertArrayHasKey($formName2, $forms);
        $this->assertEquals($fieldName, $forms[$formName2]);
    }

    public function testLoadConfigWithMultipleFormsAndDifferentFields()
    {
        $key        = '1234567';
        $secret     = 's3cr3T';
        $formName0  = 'form_A';
        $formName1  = 'form_B';
        $formName2  = 'form_C';
        $fieldName0 = 'recaptcha';
        $fieldName1 = 'recaptcha_Foo';
        $fieldName2 = 'recaptcha_Bar';

        $configs = array(
            array(
                'sitekey'    => $key,
                'secret'     => $secret,
                'validation' => array(
                    'forms' => array(
                        array('form_name' => $formName0, 'field_name' => $fieldName0),
                        array('form_name' => $formName1, 'field_name' => $fieldName1),
                        array('form_name' => $formName2, 'field_name' => $fieldName2)
                    )
                )
            )
        );
        $container = $this->getContainer();

        $this->extension->load($configs, $container);

        $this->assertRecaptchaConfig($container, $key, $secret);

        $this->assertTrue($container->hasParameter($this->root . '.validations'));

        $forms = $container->getParameter($this->root . '.validations');
        $this->assertInternalType('array', $forms);
        $this->assertNotEmpty($forms);
        $this->assertCount(3, $forms);
        $this->assertArrayHasKey($formName0, $forms);
        $this->assertEquals($fieldName0, $forms[$formName0]);
        $this->assertArrayHasKey($formName1, $forms);
        $this->assertEquals($fieldName1, $forms[$formName1]);
        $this->assertArrayHasKey($formName2, $forms);
        $this->assertEquals($fieldName2, $forms[$formName2]);
    }

    public function testLoadLegacyConfig()
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

        $this->assertRecaptchaConfig($container, $key, $secret);

        $this->assertTrue($container->hasParameter($this->root . '.validations'));

        $forms = $container->getParameter($this->root . '.validations');
        $this->assertInternalType('array', $forms);
        $this->assertNotEmpty($forms);
        $this->assertCount(1, $forms);
        $this->assertArrayHasKey($formName, $forms);
        $this->assertEquals($fieldName, $forms[$formName]);
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
                    'forms' => array(
                        array('form_name'  => '', 'field_name' => '')
                    )
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

    private function assertRecaptchaConfig(ContainerBuilder $container, $key, $secret)
    {
        $this->assertTrue($container->hasParameter($this->root . '.sitekey'));
        $this->assertEquals($key, $container->getParameter($this->root . '.sitekey'));

        $this->assertTrue($container->hasParameter($this->root . '.secret'));
        $this->assertEquals($secret, $container->getParameter($this->root . '.secret'));
    }
}
