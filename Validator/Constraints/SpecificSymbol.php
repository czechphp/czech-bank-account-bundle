<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class SpecificSymbol extends Constraint
{
    public const FORMAT_ERROR = '78c937a5-aa3d-460b-984e-3fdf40928ce8';

    protected static $errorNames = [
        self::FORMAT_ERROR => 'FORMAT_ERROR',
    ];

    public string $message = 'This is not valid specific symbol.';

    public function __construct(
        mixed $options = null,
        string $message = null,
        array $groups = null,
        mixed $payload = null
    )
    {
        parent::__construct($options, $groups, $payload);

        $this->message = $message ?? $this->message;
    }
}
