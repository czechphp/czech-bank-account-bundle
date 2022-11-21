<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Form\Type;

use Czechphp\CzechBankAccount\ConstantSymbol\Filter\FilterInterface;
use Czechphp\CzechBankAccount\ConstantSymbol\Loader\LoaderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ConstantSymbolType extends AbstractType
{
    private FilterInterface $filter;

    public function __construct(FilterInterface $filter)
    {
        $this->filter = $filter;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $choiceLoader = function (Options $options) {
            $criteria = $options['criteria'];

            return new CallbackChoiceLoader(function () use ($criteria) {
                $items = $this->filter->filter($criteria);

                $choices = [];

                foreach ($items as $item) {
                    $choices[$item[LoaderInterface::DESCRIPTION]] = $item[LoaderInterface::CODE];
                }

                return $choices;
            });
        };

        $resolver->setDefaults([
            'choice_loader' => $choiceLoader,
            'choice_label' => function ($code, $description) {
                return $code . ' - ' . $description;
            },
            'choice_translation_domain' => false,
            'criteria' => ['include' => ['all']],
        ]);

        $resolver->setRequired('criteria');
        $resolver->setAllowedTypes('criteria', 'array');
    }

    public function getParent(): ?string
    {
        return ChoiceType::class;
    }
}
