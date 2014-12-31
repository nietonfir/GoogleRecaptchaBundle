<?php

namespace Nietonfir\Google\ReCaptchaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ReCaptchaResponseValidator extends ConstraintValidator
{
    private $reCaptcha;

    public function __construct($reCaptcha)
    {
        $this->reCaptcha = $reCaptcha;
    }

    public function validate($value, Constraint $constraint)
    {
        /*
        // FIXME - noop
        if (!preg_match('/^[a-zA-Za0-9]+$/', $value, $matches)) {
            // If you're using the new 2.5 validation API (you probably are!)
            $this->context->buildViolation($constraint->message)
                ->addViolation();

            // If you're using the old 2.4 validation API
            $this->context->addViolation(
                $constraint->message,
                array('%string%' => $value)
            );
        }
        */
    }
}
