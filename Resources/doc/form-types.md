# BankCodeType Field

The `BankCodeType` is subset of `ChoiceType` that displays directory of payment system codes.

The "value" for each bank is four digit bank code.

## Basic usage

```php
<?php

// src/Form/Type/BankAccountType.php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Czechphp\CzechBankAccountBundle\Form\Type\BankCodeType;

class BankAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('bankCode', BankCodeType::class);
    }
}
```

## Overridden options

### choice_loader

**default**: `Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader`

Loads bank code choices.

### choice_label

**default**: `{code} - {name}`

Transforms choice labels into more user friendly format.

### choice_translation_domain

**default**: `false`

There is no need to translate choices.

# ConstantSymbolType Field

The `ConstantSymbolType` is subset of `ChoiceType` that displays list of known constant symbols.

The "value" for each constant symbol is one to four digits.

## Basic usage

```php
<?php

// src/Form/Type/BankAccountType.php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Czechphp\CzechBankAccountBundle\Form\Type\ConstantSymbolType;

class BankAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('constantSymbol', ConstantSymbolType::class, [
            'criteria' => ['include' => ['public']], // use only constant symbols for public use
        ]);
    }
}
```

## Field options

### criteria

**default**: `['include' => ['all']`

Load all known constant symbol choices.

## Overridden options

### choice_loader

**default**: `Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader`

Loads constant symbol choices.

### choice_label

**default**: `{code} - {description}`

Transforms choice labels into more user friendly format.

### choice_translation_domain

**default**: `false`

There is no need to translate choices.
