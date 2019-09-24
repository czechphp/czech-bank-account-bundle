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
