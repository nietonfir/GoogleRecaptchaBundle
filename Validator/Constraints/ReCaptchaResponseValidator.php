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
            var_dump($response->getErrors());

            // If you're using the new 2.5 validation API (you probably are!)
            $this->context->buildViolation($constraint->message)->addViolation();

            // If you're using the old 2.4 validation API
            // $this->context->addViolation(
            //     $constraint->message,
            //     array('%string%' => $value)
            // );
        }
    }
}
