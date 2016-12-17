<?php

namespace Nietonfir\Google\ReCaptchaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ReCaptchaResponse extends Constraint
{
    public $message                = 'The user response could not be validated.';
    public $secretMissingMessage   = 'The secret parameter is missing.';
    public $secretInvalidMessage   = 'The secret parameter is invalid or malformed.';
    public $responseMissingMessage = 'The response parameter is missing.';
    public $responseInvalidMessage = 'The response parameter is invalid or malformed.';

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }

    /**
     * Translates the google recaptcha error codes to the public properties
     * defined in this class.
     * Currently the following four error codes are in use:
     *  - missing-input-secret    The secret parameter is missing.
     *  - invalid-input-secret    The secret parameter is invalid or malformed.
     *  - missing-input-response  The response parameter is missing.
     *  - invalid-input-response  The response parameter is invalid or malformed.
     *
     * @param  string $response The upstream error code
     * @return string           The property name for the corresponding error message
     */
    public static function translateUpstreamResponse($response)
    {
        switch ($response) {
            case 'missing-input-secret':
                return 'secretMissingMessage';
                break;
            case 'invalid-input-secret':
                return 'secretInvalidMessage';
                break;
            case 'missing-input-response':
                return 'responseMissingMessage';
                break;
            case 'invalid-input-response':
                return 'responseInvalidMessage';
                break;
            default:
                return 'message';
                break;
        }
    }
}
