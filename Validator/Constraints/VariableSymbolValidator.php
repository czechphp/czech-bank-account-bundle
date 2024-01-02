<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\ValidatorInterface;
use Czechphp\CzechBankAccount\Validator\VariableSymbolValidator as BaseVariableSymbolValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class VariableSymbolValidator extends ConstraintValidator
{
    private ValidatorInterface $variableSymbolValidator;

    public function __construct(ValidatorInterface $variableSymbolValidator)
    {
        $this->variableSymbolValidator = $variableSymbolValidator;
    }

    /**
     * {@inheritDoc}
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof VariableSymbol) {
            throw new UnexpectedTypeException($constraint, VariableSymbol::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        switch ($this->variableSymbolValidator->validate($value)) {
            case BaseVariableSymbolValidator::ERROR_FORMAT:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(VariableSymbol::FORMAT_ERROR);
                $builder->addViolation();

                return;
            case BaseVariableSymbolValidator::ERROR_NONE:
            default:
                break;
        }
    }
}
