<?php

namespace Nietonfir\Google\ReCaptchaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReCaptchaType extends AbstractType
{
    private $sitekey;

    public function __construct($sitekey)
    {
        $this->sitekey = $sitekey;
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
