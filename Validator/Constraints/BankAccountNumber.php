<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\BankAccountNumberValidator as BaseBankAccountNumberValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class BankAccountNumber extends Constraint
{
    public const ERROR_SECOND_PART_CHECKSUM = '163b471f-81a1-44fc-88e4-8e6c3025d177';
    public const ERROR_AMOUNT_OF_NON_ZERO_DIGITS = '7b051e7a-6a47-4380-a443-84fde4c8e3b6';
    public const ERROR_FIRST_PART_CHECKSUM = '383b43c1-0146-4396-bada-9cda1d75202a';
    public const ERROR_FORMAT_CONSTANT = '511d6ff8-5d86-4d21-aa4b-68333b2f2ae2';
    public const ERROR_FORMAT_VARIABLE = '58a131c9-5546-48af-ad95-d2a78617c32a';

    protected static $errorNames = [
        self::ERROR_SECOND_PART_CHECKSUM => 'ERROR_SECOND_PART_CHECKSUM',
        self::ERROR_AMOUNT_OF_NON_ZERO_DIGITS => 'ERROR_AMOUNT_OF_NON_ZERO_DIGITS',
        self::ERROR_FIRST_PART_CHECKSUM => 'ERROR_FIRST_PART_CHECKSUM',
        self::ERROR_FORMAT_CONSTANT => 'ERROR_FORMAT_CONSTANT',
        self::ERROR_FORMAT_VARIABLE => 'ERROR_FORMAT_VARIABLE',
    ];

    protected static array $types = [
        BaseBankAccountNumberValidator::OPTION_TYPE_VARIABLE,
        BaseBankAccountNumberValidator::OPTION_TYPE_CONSTANT,
    ];

    public string $type = BaseBankAccountNumberValidator::OPTION_TYPE_VARIABLE;

    public string $message = 'This is not valid bank account number.';

    public function __construct(mixed $options = null)
    {
        parent::__construct($options);

        if (!in_array($this->type, self::$types)) {
            throw new ConstraintDefinitionException(sprintf('The option "type" must be one of "%s".', implode('", "', self::$types)));
        }
    }

    public function getDefaultOption(): ?string
    {
        return 'type';
    }
}
