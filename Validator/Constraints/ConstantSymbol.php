<?php

declare(strict_types = 1);

namespace Czechphp\CzechBankAccountBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use function is_array;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
final class ConstantSymbol extends Constraint
{
    public const FORMAT_ERROR = '7f3de56d-935f-4d69-b556-534627c666ee';
    public const INVALID_CODE_ERROR = 'f823baa6-d43b-4942-9cc3-6a8309731f6d';

    protected static $errorNames = [
        self::FORMAT_ERROR => 'FORMAT_ERROR',
        self::INVALID_CODE_ERROR => 'INVALID_CODE_ERROR',
    ];

    public $filter = null;

    public $message = 'This is not valid constant symbol.';

    public function __construct($options = null)
    {
        parent::__construct($options);

        if ($this->filter !== null && !is_array($this->filter)) {
            throw new ConstraintDefinitionException('The option "filter" must be of type "array" or "null".');
        }
    }

    public function getDefaultOption()
    {
        return 'filter';
    }
}
