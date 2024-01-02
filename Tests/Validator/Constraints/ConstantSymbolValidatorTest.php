<?php

namespace Czechphp\CzechBankAccountBundle\Tests\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\ConstantSymbolValidator as BaseConstantSymbolValidator;
use Czechphp\CzechBankAccount\Validator\ValidatorInterface;
use Czechphp\CzechBankAccountBundle\Validator\Constraints\ConstantSymbol;
use Czechphp\CzechBankAccountBundle\Validator\Constraints\ConstantSymbolValidator;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ConstantSymbolValidatorTest extends ConstraintValidatorTestCase
{
    /**
     * @var MockObject|ValidatorInterface
     */
    private $baseValidator;

    protected function createValidator(): ConstraintValidatorInterface
    {
        $this->baseValidator = $this->createMock(ValidatorInterface::class);

        return new ConstantSymbolValidator($this->baseValidator);
    }

    public function testNull()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->validator->validate(null, new ConstantSymbol());

        $this->assertNoViolation();
    }

    public function testEmpty()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->validator->validate('', new ConstantSymbol());

        $this->assertNoViolation();
    }

    public function testInteger()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(1, new ConstantSymbol());
    }

    public function testFloat()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(1.0, new ConstantSymbol());
    }

    public function testArray()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate([], new ConstantSymbol());
    }

    public function testObject()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate((object) [], new ConstantSymbol());
    }

    public function testToStringObject()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseConstantSymbolValidator::ERROR_NONE);

        $this->validator->validate(new ToStringObject('25596641'), new ConstantSymbol());

        $this->assertNoViolation();
    }

    public function testInvalidConstraint()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        /** @var MockObject|Constraint $constraint */
        $constraint = $this->createMock(Constraint::class);

        $this->validator->validate('25596641', $constraint);
    }

    public function testInvalidFilterOption()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(ConstraintDefinitionException::class);

        new ConstantSymbol('foo');
    }

    public function testValid()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseConstantSymbolValidator::ERROR_NONE);

        $this->validator->validate('25596641', new ConstantSymbol());

        $this->assertNoViolation();
    }

    public function testFormat()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseConstantSymbolValidator::ERROR_FORMAT);

        $value = '000001';
        $constraint = new ConstantSymbol();

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(ConstantSymbol::FORMAT_ERROR);
        $builder->assertRaised();
    }

    public function testInvalidCode()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseConstantSymbolValidator::ERROR_INVALID_CODE);

        $value = '000001';
        $constraint = new ConstantSymbol();

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(ConstantSymbol::INVALID_CODE_ERROR);
        $builder->assertRaised();
    }
}
