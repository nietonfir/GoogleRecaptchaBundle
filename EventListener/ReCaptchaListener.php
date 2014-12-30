<?php

namespace Nietonfir\Google\ReCaptchaBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Nietonfir\Google\ReCaptchaBundle\Controller\ReCaptchaValidationInterface;

class ReCaptchaListener
{
    private $form = 'task';

    private $field = 'recaptcha';

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ReCaptchaValidationInterface) {
            $requestData = $event->getRequest()->request;

            $captchaResponse = $requestData->get('g-recaptcha-response', null);
            if ($captchaResponse) {
                $formData = $requestData->get($this->form);
                $formData[$this->field]['g-recaptcha-response'] = $captchaResponse;

                $requestData->set($this->form, $formData);
                $requestData->remove('g-recaptcha-response');
            }
        }
    }
}
