<?php

namespace Nietonfir\Google\ReCaptchaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ReCaptchaResponse extends Constraint
{
    public $message = 'The user response could not be validated.';

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}
