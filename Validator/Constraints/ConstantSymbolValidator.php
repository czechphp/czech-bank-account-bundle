<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\ConstantSymbolValidator as BaseConstantSymbolValidator;
use Czechphp\CzechBankAccount\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class ConstantSymbolValidator extends ConstraintValidator
{
    private ValidatorInterface $constantSymbolValidator;

    public function __construct(ValidatorInterface $constantSymbolValidator)
    {
        $this->constantSymbolValidator = $constantSymbolValidator;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ConstantSymbol) {
            throw new UnexpectedTypeException($constraint, ConstantSymbol::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        $options = [
            'filter' => $constraint->filter,
        ];

        switch ($this->constantSymbolValidator->validate($value, $options)) {
            case BaseConstantSymbolValidator::ERROR_INVALID_CODE:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(ConstantSymbol::INVALID_CODE_ERROR);
                $builder->addViolation();

                return;
            case BaseConstantSymbolValidator::ERROR_FORMAT:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(ConstantSymbol::FORMAT_ERROR);
                $builder->addViolation();

                return;
            case BaseConstantSymbolValidator::ERROR_NONE:
            default:
                break;
        }
    }
}
