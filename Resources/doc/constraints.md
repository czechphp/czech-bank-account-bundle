# BankAccountNumber

> Czech: Číslo účtu

Validates that a value is valid bank account number string.

## Basic usage

```php
<?php

// src/Entity/BankAccount.php
namespace App\Entity;

use Czechphp\CzechBankAccountBundle\Validator\Constraints as CzechphpAssert;

class BankAccount
{
    /**
     * @CzechphpAssert\BankAccountNumber(
     *     message="The value '{{ value }}' is not valid bank account number.", 
     *     type="variable"
     * )
     */
    private $bankAccountNumber;
}
```
## Options

### type

**type**: `string` **default**: `variable`

This option is optional and defines the pattern the bank account number is validated against.
Valid values are:
* `variable`
* `constant`

#### variable

Variable length bank account number. Allows values that have it's two parts separated with `-` symbol. For example: `19-19`.

#### constant

Constant length bank account number. Allows values that have constant length of 16 digits with leading zeros. For example: `0000190000000019`.

### message

**type**: `string` **default**: `This is not valid bank account number.`

This message is shown if the underlying data is not a valid bank account number.

You can use the following parameters in this message:
* `{{ value }}` The current (invalid) value


# BankCode

> Czech: Kód banky

Validates that a value is valid payment system code string.

## Basic usage

```php
<?php

// src/Entity/BankAccount.php
namespace App\Entity;

use Czechphp\CzechBankAccountBundle\Validator\Constraints as CzechphpAssert;

class BankAccount
{
    /**
     * @CzechphpAssert\BankCode(
     *     message="The value '{{ value }}' is not valid payment system code."
     * )
     */
    private $bankCode;
}
```
## Options

### message

**type**: `string` **default**: `This is not valid payment system code.`

This message is shown if the underlying data is not a valid payment system code.

You can use the following parameters in this message:
* `{{ value }}` The current (invalid) value


# VariableSymbol

> Czech: Variabilní symbol

Validates that a value is valid variable symbol string.

## Basic usage

```php
<?php

// src/Entity/BankAccount.php
namespace App\Entity;

use Czechphp\CzechBankAccountBundle\Validator\Constraints as CzechphpAssert;

class BankAccount
{
    /**
     * @CzechphpAssert\VariableSymbol(
     *     message="The value '{{ value }}' is not valid variable symbol."
     * )
     */
    private $variableSymbol;
}
```
## Options

### message

**type**: `string` **default**: `This is not valid variable symbol.`

This message is shown if the underlying data is not a valid variable symbol.

You can use the following parameters in this message:
* `{{ value }}` The current (invalid) value


# ConstantSymbol

> Czech: Konstantní symbol

Validates that a value is valid constant symbol string.

## Basic usage

```php
<?php

// src/Entity/BankAccount.php
namespace App\Entity;

use Czechphp\CzechBankAccountBundle\Validator\Constraints as CzechphpAssert;

class BankAccount
{
    /**
     * @CzechphpAssert\ConstantSymbol(
     *     message="The value '{{ value }}' is not valid constant symbol."
     * )
     */
    private $constantSymbol;
}
```
## Options

### message

**type**: `string` **default**: `This is not valid constant symbol.`

This message is shown if the underlying data is not a valid constant symbol.

You can use the following parameters in this message:
* `{{ value }}` The current (invalid) value


# SpecificSymbol

> Czech: Specifický symbol

Validates that a value is valid specific symbol string.

## Basic usage

```php
<?php

// src/Entity/BankAccount.php
namespace App\Entity;

use Czechphp\CzechBankAccountBundle\Validator\Constraints as CzechphpAssert;

class BankAccount
{
    /**
     * @CzechphpAssert\VariableSymbol(
     *     message="The value '{{ value }}' is not valid specific symbol."
     * )
     */
    private $specificSymbol;
}
```
## Options

### message

**type**: `string` **default**: `This is not valid specific symbol.`

This message is shown if the underlying data is not a valid specific symbol.

You can use the following parameters in this message:
* `{{ value }}` The current (invalid) value
