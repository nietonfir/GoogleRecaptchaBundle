<?php

namespace Nietonfir\Google\ReCaptchaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Nietonfir\Google\ReCaptchaBundle\Validator\Constraints\ReCaptchaResponse;

class ReCaptchaType extends AbstractType
{
    private $sitekey;

    public function __construct($sitekey)
    {
        $this->sitekey = $sitekey;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('g-recaptcha-response', null, array(
            'error_bubbling' => true,
            'constraints' => array(
                new ReCaptchaResponse(),
                new NotBlank()
            )
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'mapped' => false,
            'attr' => array(
                'data-sitekey' => $this->sitekey,
                'class' => 'g-recaptcha'
            )
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'recaptcha';
    }
}
