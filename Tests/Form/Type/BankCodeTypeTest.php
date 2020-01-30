<?php

namespace Czechphp\BankCodeBundle\Tests\Form\Type;

use Czechphp\CzechBankAccount\Loader\BankCode\LoaderInterface;
use Czechphp\CzechBankAccountBundle\Form\Type\BankCodeType;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class BankCodeTypeTest extends TypeTestCase
{
    /**
     * @var MockObject|LoaderInterface
     */
    private $bankCodeLoader;

    protected function setUp(): void
    {
        $this->bankCodeLoader = $this->createMock(LoaderInterface::class);

        parent::setUp();
    }

    protected function getExtensions()
    {
        $bankCodeType = new BankCodeType($this->bankCodeLoader);

        return [
            new PreloadedExtension([$bankCodeType], []),
        ];
    }

    public function testChoiceView()
    {
        $this->bankCodeLoader->method('load')->willReturn([
            [
                LoaderInterface::CODE => '0100',
                LoaderInterface::NAME => 'Komerční banka, a.s.',
                LoaderInterface::BIC => 'KOMBCZPP',
                LoaderInterface::CERTIS => true,
            ],
            [
                LoaderInterface::CODE => '0300',
                LoaderInterface::NAME => 'Československá obchodní banka, a. s.',
                LoaderInterface::BIC => 'CEKOCZPP',
                LoaderInterface::CERTIS => true,
            ],
        ]);

        $form = $this->factory->create(BankCodeType::class);
        $choices = $form->createView()->vars['choices'];

        $this->assertContains(new ChoiceView('0100', '0100', '0100 - Komerční banka, a.s.'), $choices, '', false, false);
        $this->assertContains(new ChoiceView('0300', '0300', '0300 - Československá obchodní banka, a. s.'), $choices, '', false, false);
    }
}
