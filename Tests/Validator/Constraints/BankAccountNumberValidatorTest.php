<?php

namespace Czechphp\CzechBankAccountBundle\Tests\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\BankAccountNumberValidator as BaseBankAccountNumberValidator;
use Czechphp\CzechBankAccount\Validator\ValidatorInterface;
use Czechphp\CzechBankAccountBundle\Validator\Constraints\BankAccountNumber;
use Czechphp\CzechBankAccountBundle\Validator\Constraints\BankAccountNumberValidator;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class BankAccountNumberValidatorTest extends ConstraintValidatorTestCase
{
    /**
     * @var MockObject|ValidatorInterface
     */
    private $baseValidator;

    /**
     * @return BankAccountNumberValidator
     */
    protected function createValidator(): ConstraintValidatorInterface
    {
        $this->baseValidator = $this->createMock(ValidatorInterface::class);

        return new BankAccountNumberValidator($this->baseValidator);
    }

    public function testNull()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->validator->validate(null, new BankAccountNumber());

        $this->assertNoViolation();
    }

    public function testEmpty()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->validator->validate('', new BankAccountNumber());

        $this->assertNoViolation();
    }

    public function testInteger()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(1, new BankAccountNumber());
    }

    public function testFloat()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(1.0, new BankAccountNumber());
    }

    public function testArray()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate([], new BankAccountNumber());
    }

    public function testObject()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate((object) [], new BankAccountNumber());
    }

    public function testToStringObject()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankAccountNumberValidator::ERROR_NONE);

        $this->validator->validate(new ToStringObject('19'), new BankAccountNumber());

        $this->assertNoViolation();
    }

    public function testInvalidConstraint()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        /** @var MockObject|Constraint $constraint */
        $constraint = $this->createMock(Constraint::class);

        $this->validator->validate('19', $constraint);
    }

    public function testInvalidTypeOption()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(ConstraintDefinitionException::class);

        new BankAccountNumber('foo');
    }

    public function testValid()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankAccountNumberValidator::ERROR_NONE);

        $this->validator->validate('19', new BankAccountNumber());

        $this->assertNoViolation();
    }

    public function testVariableTypeTooShortNumber()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankAccountNumberValidator::ERROR_FORMAT_VARIABLE);

        $value = '1';
        $constraint = new BankAccountNumber('variable');

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(BankAccountNumber::ERROR_FORMAT_VARIABLE);
        $builder->assertRaised();
    }

    public function testConstantTypeTooShortNumber()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankAccountNumberValidator::ERROR_FORMAT_CONSTANT);

        $value = '1';
        $constraint = new BankAccountNumber('constant');

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(BankAccountNumber::ERROR_FORMAT_CONSTANT);
        $builder->assertRaised();
    }

    public function testVariableTypeTooLongNumber()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankAccountNumberValidator::ERROR_FORMAT_VARIABLE);

        $value = '12345678901';
        $constraint = new BankAccountNumber('variable');

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(BankAccountNumber::ERROR_FORMAT_VARIABLE);
        $builder->assertRaised();
    }

    public function testConstantTypeTooLongNumber()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankAccountNumberValidator::ERROR_FORMAT_CONSTANT);

        $value = '12345678901234567';
        $constraint = new BankAccountNumber('constant');

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(BankAccountNumber::ERROR_FORMAT_CONSTANT);
        $builder->assertRaised();
    }

    public function testFirstPartInvalidChecksum()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankAccountNumberValidator::ERROR_FIRST_PART_CHECKSUM);

        $value = '11-19';
        $constraint = new BankAccountNumber();

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(BankAccountNumber::ERROR_FIRST_PART_CHECKSUM);
        $builder->assertRaised();
    }

    public function testSecondPartInvalidChecksum()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankAccountNumberValidator::ERROR_SECOND_PART_CHECKSUM);

        $value = '11';
        $constraint = new BankAccountNumber();

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(BankAccountNumber::ERROR_SECOND_PART_CHECKSUM);
        $builder->assertRaised();
    }

    public function testLessThanTwoNonZeroDigits()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankAccountNumberValidator::ERROR_AMOUNT_OF_NON_ZERO_DIGITS);

        $value = '10';
        $constraint = new BankAccountNumber();

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(BankAccountNumber::ERROR_AMOUNT_OF_NON_ZERO_DIGITS);
        $builder->assertRaised();
    }
}
