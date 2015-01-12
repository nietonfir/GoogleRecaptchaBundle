<?php

namespace Nietonfir\Google\ReCaptchaBundle\Api;

use Nietonfir\Google\ReCaptcha\Api\RequestDataInterface;

/**
 * Extend the original interface for request data by setters for the
 * additional parameters required for a valid request. By defining those
 * objects expecting this interface can set those parameters during runtime.
 *
 * @author nietonfir <nietonfir@gmail.com>
 */
interface RequestDataWrapperInterface extends RequestDataInterface
{
    /**
     * The user response token provided by the reCAPTCHA to the user.
     *
     * @param string $userResponse
     */
    public function setUserResponse($userResponse);

    /**
     * The user's IP address.
     *
     * @param string $remoteIP
     */
    public function setRemoteIP($remoteIP);
}
