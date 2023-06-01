<?php

declare(strict_types=1);

namespace Ergnuor\Criteria\Expression;

class Value
{
    /** @var mixed */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
