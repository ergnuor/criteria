<?php
declare(strict_types=1);

namespace Ergnuor\Criteria\Config\Field;

use Ergnuor\Criteria\ValueSource\ValueSourceInterface;

class Sorting
{
    private ValueSourceInterface $valueSource;

    public function __construct(
        ValueSourceInterface $valueSource,
    ) {
        $this->valueSource = $valueSource;
    }

    public function getValueSource(): ValueSourceInterface
    {
        return $this->valueSource;
    }
}