<?php

namespace Nietonfir\Google\ReCaptchaBundle\DependencyInjection\ReCaptcha;

interface ReCaptchaFactoryInterface
{
    /**
     * Create and return an object implementing the ReCaptchaInterface.
     *
     * @return Nietonfir\Google\ReCaptcha\ReCaptchaInterface
     */
    public function create();
}
