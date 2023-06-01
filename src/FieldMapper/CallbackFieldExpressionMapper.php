<?php
declare(strict_types=1);

namespace Ergnuor\Criteria\FieldMapper;

use Ergnuor\Criteria\ExpressionMapper\ExpressionContext;
use Ergnuor\Criteria\ExpressionMapper\FieldMapResult;
use Ergnuor\Criteria\ExpressionMapper\Identifiers;

class CallbackFieldExpressionMapper implements FieldExpressionMapperInterface
{
    /** @var callable */
    private $getExpression;

    public function __construct(callable $getExpression)
    {
        $this->getExpression = $getExpression;
    }

    public function mapExpression(
        ExpressionContext $expressionContext,
        Identifiers $identifiers
    ): ?FieldMapResult {
        return call_user_func_array($this->getExpression, [$expressionContext, $identifiers]);
    }
}