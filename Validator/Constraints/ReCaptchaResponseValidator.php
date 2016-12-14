<?php

namespace Nietonfir\Google\ReCaptchaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ReCaptchaResponseValidator extends ConstraintValidator
{
    private $revisor;

    public function __construct($revisor)
    {
        $this->revisor = $revisor;
    }

    public function validate($value, Constraint $constraint)
    {
        $response = $this->revisor->verify($value);
        if (!$response->isValid()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
