<?php

namespace Czechphp\CzechBankAccountBundle\Tests\Validator\Constraints;

class ToStringObject
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
