<?php

namespace Czechphp\CzechBankAccountBundle\Tests\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\VariableSymbolValidator as BaseVariableSymbolValidator;
use Czechphp\CzechBankAccount\Validator\ValidatorInterface;
use Czechphp\CzechBankAccountBundle\Validator\Constraints\VariableSymbol;
use Czechphp\CzechBankAccountBundle\Validator\Constraints\VariableSymbolValidator;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class VariableSymbolValidatorTest extends ConstraintValidatorTestCase
{
    /**
     * @var MockObject|ValidatorInterface
     */
    private $baseValidator;

    protected function createValidator(): ConstraintValidatorInterface
    {
        $this->baseValidator = $this->createMock(ValidatorInterface::class);

        return new VariableSymbolValidator($this->baseValidator);
    }

    public function testNull()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->validator->validate(null, new VariableSymbol());

        $this->assertNoViolation();
    }

    public function testEmpty()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->validator->validate('', new VariableSymbol());

        $this->assertNoViolation();
    }

    public function testInteger()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(1, new VariableSymbol());
    }

    public function testFloat()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(1.0, new VariableSymbol());
    }

    public function testArray()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate([], new VariableSymbol());
    }

    public function testObject()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate((object) [], new VariableSymbol());
    }

    public function testToStringObject()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseVariableSymbolValidator::ERROR_NONE);

        $this->validator->validate(new ToStringObject('25596641'), new VariableSymbol());

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

    public function testValid()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseVariableSymbolValidator::ERROR_NONE);

        $this->validator->validate('25596641', new VariableSymbol());

        $this->assertNoViolation();
    }

    public function testFormat()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseVariableSymbolValidator::ERROR_FORMAT);

        $value = '000001';
        $constraint = new VariableSymbol();

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(VariableSymbol::FORMAT_ERROR);
        $builder->assertRaised();
    }
}
