<?php

namespace Nietonfir\Google\ReCaptchaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ReCaptchaResponseValidator extends ConstraintValidator
{
    private $revisor;

    public function __construct($revisor)
    {
        $this->revisor = $revisor;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ReCaptchaResponse) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\ReCaptchaResponse');
        }

        if (null === $value || '' === $value) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        $response = $this->revisor->verify($value);
        if (!$response->isValid()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
