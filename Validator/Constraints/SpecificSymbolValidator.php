<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\SpecificSymbolValidator as BaseSpecificSymbolValidator;
use Czechphp\CzechBankAccount\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class SpecificSymbolValidator extends ConstraintValidator
{
    /**
     * @var ValidatorInterface
     */
    private $specificSymbolValidator;

    public function __construct(ValidatorInterface $specificSymbolValidator)
    {
        $this->specificSymbolValidator = $specificSymbolValidator;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof SpecificSymbol) {
            throw new UnexpectedTypeException($constraint, SpecificSymbol::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        switch ($this->specificSymbolValidator->validate($value)) {
            case BaseSpecificSymbolValidator::ERROR_FORMAT:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(SpecificSymbol::FORMAT_ERROR);
                $builder->addViolation();

                return;
            case BaseSpecificSymbolValidator::ERROR_NONE:
            default:
                return;
        }
    }
}
