<?php

namespace Czechphp\CzechBankAccountBundle\Tests\Validator\Constraints;

use Czechphp\CzechBankAccount\Validator\SpecificSymbolValidator as BaseSpecificSymbolValidator;
use Czechphp\CzechBankAccount\Validator\ValidatorInterface;
use Czechphp\CzechBankAccountBundle\Validator\Constraints\SpecificSymbol;
use Czechphp\CzechBankAccountBundle\Validator\Constraints\SpecificSymbolValidator;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class SpecificSymbolValidatorTest extends ConstraintValidatorTestCase
{
    /**
     * @var MockObject|ValidatorInterface
     */
    private $baseValidator;

    protected function createValidator()
    {
        $this->baseValidator = $this->createMock(ValidatorInterface::class);

        return new SpecificSymbolValidator($this->baseValidator);
    }

    public function testNull()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->validator->validate(null, new SpecificSymbol());

        $this->assertNoViolation();
    }

    public function testEmpty()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->validator->validate('', new SpecificSymbol());

        $this->assertNoViolation();
    }

    public function testInteger()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(1, new SpecificSymbol());
    }

    public function testFloat()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate(1.0, new SpecificSymbol());
    }

    public function testArray()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate([], new SpecificSymbol());
    }

    public function testObject()
    {
        $this->baseValidator->expects($this->never())->method('validate');

        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate((object) [], new SpecificSymbol());
    }

    public function testToStringObject()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseSpecificSymbolValidator::ERROR_NONE);

        $this->validator->validate(new ToStringObject('25596641'), new SpecificSymbol());

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
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseSpecificSymbolValidator::ERROR_NONE);

        $this->validator->validate('25596641', new SpecificSymbol());

        $this->assertNoViolation();
    }

    public function testFormat()
    {
        $this->baseValidator->expects($this->once())->method('validate')->willReturn(BaseSpecificSymbolValidator::ERROR_FORMAT);

        $value = '000001';
        $constraint = new SpecificSymbol();

        $this->validator->validate($value, $constraint);

        $builder = $this->buildViolation($constraint->message);
        $builder->setParameter('{{ value }}', $value);
        $builder->setCode(SpecificSymbol::FORMAT_ERROR);
        $builder->assertRaised();
    }
}
