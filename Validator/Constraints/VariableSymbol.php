<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
final class VariableSymbol extends Constraint
{
    public const FORMAT_ERROR = '7f3de56d-935f-4d69-b556-534627c666ee';

    protected static $errorNames = [
        self::FORMAT_ERROR => 'FORMAT_ERROR',
    ];

    public $message = 'This is not valid variable symbol.';
}
