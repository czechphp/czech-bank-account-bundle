<?php

namespace Czechphp\CzechBankAccountBundle\Tests\Form\Type;

use Czechphp\CzechBankAccount\ConstantSymbol\Filter\FilterInterface;
use Czechphp\CzechBankAccount\ConstantSymbol\Loader\LoaderInterface;
use Czechphp\CzechBankAccountBundle\Form\Type\ConstantSymbolType;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class ConstantSymbolTypeTest extends TypeTestCase
{
    /**
     * @var MockObject|FilterInterface
     */
    private $constantSymbolFilter;

    protected function setUp(): void
    {
        $this->constantSymbolFilter = $this->createMock(FilterInterface::class);

        parent::setUp();
    }

    protected function getExtensions()
    {
        $constantSymbolType = new ConstantSymbolType($this->constantSymbolFilter);

        return [
            new PreloadedExtension([$constantSymbolType], []),
        ];
    }

    public function testChoiceView()
    {
        $this->constantSymbolFilter->method('filter')->willReturn([
            [
                LoaderInterface::CODE => '0001',
                LoaderInterface::GROUPS => ['all', 'group1'],
                LoaderInterface::DESCRIPTION => 'foo',
            ],
            [
                LoaderInterface::CODE => '0002',
                LoaderInterface::GROUPS => ['all', 'group1', 'group2'],
                LoaderInterface::DESCRIPTION => 'bar',
            ],
        ]);

        $form = $this->factory->create(ConstantSymbolType::class);
        $choices = $form->createView()->vars['choices'];

        $this->assertContains(new ChoiceView('0001', '0001', '0001 - foo'), $choices, '', false, false);
        $this->assertContains(new ChoiceView('0002', '0002', '0002 - bar'), $choices, '', false, false);
    }
}
