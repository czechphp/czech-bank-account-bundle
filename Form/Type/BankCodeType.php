<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Form\Type;

use Czechphp\CzechBankAccount\Loader\BankCode\LoaderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BankCodeType extends AbstractType
{
    /**
     * @var LoaderInterface
     */
    private $bankCodeLoader;

    public function __construct(LoaderInterface $bankCodeLoader)
    {
        $this->bankCodeLoader = $bankCodeLoader;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choice_loader' => new CallbackChoiceLoader(function () {
                $items = $this->bankCodeLoader->load();

                $choices = [];

                foreach ($items as $item) {
                    $choices[$item[LoaderInterface::NAME]] = $item[LoaderInterface::CODE];
                }

                return $choices;
            }),
            'choice_label' => function ($code, $name) {
                return $code . ' - ' . $name;
            },
            'choice_translation_domain' => false,
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
