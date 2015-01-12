<?php

namespace Nietonfir\Google\ReCaptchaBundle\Api;

use Nietonfir\Google\ReCaptcha\Api\RequestData;

class RequestDataWrapper extends RequestData implements RequestDataWrapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct($secret, $userResponse = '', $remoteIP = '')
    {
        // Override the parent constructor and allow empty defaults
        parent::__construct($secret, $userResponse, $remoteIP);
    }

    /**
     * {@inheritdoc}
     */
    public function setUserResponse($userResponse)
    {
        $this->userResponse = $userResponse;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRemoteIP($remoteIP)
    {
        $this->remoteIP = $remoteIP;

        return $this;
    }
}
