<?php

namespace Nietonfir\Google\ReCaptchaBundle\DependencyInjection\ReCaptcha;

use Nietonfir\Google\ReCaptchaBundle\Api\RequestDataWrapperInterface;
use Nietonfir\Google\ReCaptcha\ReCaptchaInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Perform the verification of the provided user response
 *
 * @author nietonfir <nietonfir@gmail.com>
 */
class Revisor
{
    /**
     * @var ReCaptchaInterface
     */
    private $reCaptcha;

    /**
     * @var RequestDataWrapperInterface
     */
    private $requestData;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        RequestStack $requestStack,
        ReCaptchaInterface $reCaptcha,
        RequestDataWrapperInterface $requestData
    ) {
        $this->requestStack = $requestStack;
        $this->reCaptcha = $reCaptcha;
        $this->requestData = $requestData;
    }

    public function verify($value)
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request) {
            $this->requestData
                ->setUserResponse($value)
                ->setRemoteIP($request->getClientIp())
            ;

            $this->reCaptcha->processRequest($this->requestData);
            return $this->reCaptcha->getResponse();
        }
        // TODO or TODO nothing? - that is the question
    }
}
