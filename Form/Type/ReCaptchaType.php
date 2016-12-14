<?php

namespace Nietonfir\Google\ReCaptchaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Nietonfir\Google\ReCaptchaBundle\Validator\Constraints\ReCaptchaResponse;

class ReCaptchaType extends AbstractType
{
    private $sitekey;

    public function __construct($sitekey)
    {
        $this->sitekey = $sitekey;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'mapped'      => false,
            'compound'    => false,
            'constraints' => array(
                new ReCaptchaResponse()
            ),
            'attr' => array(
                'data-sitekey' => $this->sitekey,
                'class'        => 'g-recaptcha'
            )
        ));
    }

    public function getBlockPrefix()
    {
        return 'recaptcha';
    }
}
