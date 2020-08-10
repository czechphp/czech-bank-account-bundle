<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\BankCodeValidator as BaseBankCodeValidator;
use Czechphp\CzechBankAccount\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class BankCodeValidator extends ConstraintValidator
{
    /**
     * @var ValidatorInterface
     */
    private $bankCodeValidator;

    public function __construct(ValidatorInterface $bankCodeValidator)
    {
        $this->bankCodeValidator = $bankCodeValidator;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof BankCode) {
            throw new UnexpectedTypeException($constraint, BankCode::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        switch ($this->bankCodeValidator->validate($value)) {
            case BaseBankCodeValidator::ERROR_FORMAT:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(BankCode::FORMAT_ERROR);
                $builder->addViolation();

                return;
            case BaseBankCodeValidator::ERROR_INVALID_CODE:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(BankCode::NOT_FOUND_ERROR);
                $builder->addViolation();

                return;
            case BaseBankCodeValidator::ERROR_NONE:
            default:
                break;
        }
    }
}
