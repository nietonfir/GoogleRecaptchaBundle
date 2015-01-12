<?php

namespace Nietonfir\Google\ReCaptchaBundle\DependencyInjection\ReCaptcha;

use GuzzleHttp\Client;
use Nietonfir\Google\ReCaptcha\ReCaptcha;
use Nietonfir\Google\ReCaptcha\Api\Response;

class ReCaptchaFactory implements ReCaptchaFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new ReCaptcha(
            new Client(array('defaults' => array('verify' => false))),
            new Response()
        );
    }
}
