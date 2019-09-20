<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
final class BankCode extends Constraint
{
    public const NOT_FOUND_ERROR = 'c8a1dbdf-9295-4498-ac52-9b1d719a13ef';
    public const FORMAT_ERROR = 'c4ce288c-5af4-4196-9403-afcc771f19d0';

    protected static $errorNames = [
        self::NOT_FOUND_ERROR => 'NOT_FOUND_ERROR',
        self::FORMAT_ERROR => 'FORMAT_ERROR',
    ];

    public $message = 'This is not valid payment system code.';
}
