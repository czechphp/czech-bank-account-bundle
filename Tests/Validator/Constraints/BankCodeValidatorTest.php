<?php

namespace Czechphp\CzechBankAccountBundle\Tests\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\BankCodeValidator as BaseBankCodeValidator;
use Czechphp\CzechBankAccount\Validator\ValidatorInterface;
use Czechphp\CzechBankAccountBundle\Validator\Constraints\BankCode;
use Czechphp\CzechBankAccountBundle\Validator\Constraints\BankCodeValidator;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class BankCodeValidatorTest extends ConstraintValidatorTestCase
{
    /**
     * @var MockObject|ValidatorInterface
     */
    private $baseValidator;

    protected function createValidator()
    {
        $this->baseValidator = $this->createMock(ValidatorInterface::class);

        return new BankCodeValidator($this->baseValidator);
    }

    public function testNull()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->validator->validate(null, new BankCode());

        $this->assertNoViolation();
    }

    public function testEmpty()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->validator->validate('', new BankCode());

        $this->assertNoViolation();
    }

    public function testInteger()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(1, new BankCode());
    }

    public function testFloat()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(1.0, new BankCode());
    }

    public function testArray()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate([], new BankCode());
    }

    public function testObject()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate((object) [], new BankCode());
    }

    public function testToStringObject()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankCodeValidator::ERROR_NONE);

        $this->validator->validate(new ToStringObject('0300'), new BankCode());

        $this->assertNoViolation();
    }

    public function testInvalidConstraint()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        /** @var MockObject|Constraint $constraint */
        $constraint = $this->createMock(Constraint::class);

        $this->validator->validate('0300', $constraint);
    }

    public function testValid()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankCodeValidator::ERROR_NONE);

        $this->validator->validate('0300', new BankCode());

        $this->assertNoViolation();
    }

    public function testNotFound()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankCodeValidator::ERROR_INVALID_CODE);

        $value = '9999';
        $constraint = new BankCode();

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(BankCode::NOT_FOUND_ERROR);
        $builder->assertRaised();
    }

    public function testFormat()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseBankCodeValidator::ERROR_FORMAT);

        $value = '000001';
        $constraint = new BankCode();

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(BankCode::FORMAT_ERROR);
        $builder->assertRaised();
    }
}
