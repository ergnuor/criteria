<?php
declare(strict_types=1);

namespace Ergnuor\Criteria\FieldMapper;

use Ergnuor\Criteria\ExpressionMapper\ExpressionContext;
use Ergnuor\Criteria\ExpressionMapper\FieldMapResult;
use Ergnuor\Criteria\ExpressionMapper\Identifiers;

/**
 * @template TExpression
 */
interface FieldExpressionMapperInterface
{
    /**
     * @param ExpressionContext $expressionContext
     * @param Identifiers $identifiers
     * @return FieldMapResult<TExpression>|null
     */
    public function mapExpression(ExpressionContext $expressionContext, Identifiers $identifiers): ?FieldMapResult;
}