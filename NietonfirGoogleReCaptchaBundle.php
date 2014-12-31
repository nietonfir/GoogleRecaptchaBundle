<?php

namespace Nietonfir\Google\ReCaptchaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Nietonfir\Google\ReCaptchaBundle\DependencyInjection\NietonfirGoogleReCaptchaExtension;

class NietonfirGoogleReCaptchaBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new NietonfirGoogleReCaptchaExtension();
    }
}
