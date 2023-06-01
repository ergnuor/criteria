<?php

declare(strict_types=1);

namespace Ergnuor\Criteria\ExpressionMapper;

use Ergnuor\Criteria\Expression\ExpressionInterface;
use Ergnuor\Criteria\FieldMapper\FieldExpressionMapperInterface;
use Ergnuor\Criteria\ValueSource\ValueSourceInterface;

interface ExpressionMapperInterface
{
    public function map(ExpressionInterface $expr): mixed;

    public function addField(
        string $fieldName,
        ?ValueSourceInterface $valueSource,
        null|string|FieldExpressionMapperInterface $fieldExpressionMapper = null
    ): void;
}
