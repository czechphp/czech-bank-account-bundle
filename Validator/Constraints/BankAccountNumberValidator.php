<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\BankAccountNumberValidator as BaseBankAccountNumberValidator;
use Czechphp\CzechBankAccount\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use function is_object;
use function is_string;
use function method_exists;

final class BankAccountNumberValidator extends ConstraintValidator
{
    /**
     * @var ValidatorInterface
     */
    private $bankAccountNumberValidator;

    public function __construct(ValidatorInterface $bankAccountNumberValidator)
    {
        $this->bankAccountNumberValidator = $bankAccountNumberValidator;
    }

    /**
     * @param mixed $value
     * @param Constraint|BankAccountNumber $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof BankAccountNumber) {
            throw new UnexpectedTypeException($constraint, BankAccountNumber::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        $options = [
            BaseBankAccountNumberValidator::OPTION_TYPE => $constraint->type,
        ];

        switch ($this->bankAccountNumberValidator->validate($value, $options)) {
            case BaseBankAccountNumberValidator::ERROR_SECOND_PART_CHECKSUM:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(BankAccountNumber::ERROR_SECOND_PART_CHECKSUM);
                $builder->addViolation();

                return;
            case BaseBankAccountNumberValidator::ERROR_AMOUNT_OF_NON_ZERO_DIGITS:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(BankAccountNumber::ERROR_AMOUNT_OF_NON_ZERO_DIGITS);
                $builder->addViolation();

                return;
            case BaseBankAccountNumberValidator::ERROR_FIRST_PART_CHECKSUM:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(BankAccountNumber::ERROR_FIRST_PART_CHECKSUM);
                $builder->addViolation();

                return;
            case BaseBankAccountNumberValidator::ERROR_FORMAT_CONSTANT:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(BankAccountNumber::ERROR_FORMAT_CONSTANT);
                $builder->addViolation();

                return;
            case BaseBankAccountNumberValidator::ERROR_FORMAT_VARIABLE:
                $builder = $this->context->buildViolation($constraint->message);
                $builder->setParameter('{{ value }}', $value);
                $builder->setCode(BankAccountNumber::ERROR_FORMAT_VARIABLE);
                $builder->addViolation();

                return;
            case BaseBankAccountNumberValidator::ERROR_NONE:
            default:
                break;
        }
    }
}
