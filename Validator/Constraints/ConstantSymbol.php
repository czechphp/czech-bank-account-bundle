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
final class ConstantSymbol extends Constraint
{
    public const FORMAT_ERROR = '7f3de56d-935f-4d69-b556-534627c666ee';

    protected static $errorNames = [
        self::FORMAT_ERROR => 'FORMAT_ERROR',
    ];

    public string $message = 'This is not valid constant symbol.';

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

    public function getDefaultOption(): ?string
    {
        return 'filter';
    }
}
