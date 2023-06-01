<?php
declare(strict_types=1);

namespace Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Ergnuor\Criteria\ExpressionMapper\ExpressionMapper;
use Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine\DoctrineDBALExpressionMapper\DoctrineDBALParameterMapper;
use Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine\DoctrineDBALExpressionMapper\DoctrineDBALBasicExpressionMapper;
use Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine\DoctrineDBALExpressionMapper\DoctrineDBALLogicalExpressionMapper;
use Psr\Container\ContainerInterface;

/**
 * @extends ExpressionMapper<CompositeExpression|string, array<string, array{0: mixed, 1: int|string}>>
 */
class DoctrineDBALExpressionMapper extends ExpressionMapper
{
    public function __construct(Connection $connection, ContainerInterface $expressionMapperContainer = null)
    {
        parent::__construct(
            new DoctrineDBALParameterMapper(),
            new DoctrineDBALBasicExpressionMapper($connection),
            new DoctrineDBALLogicalExpressionMapper($connection),
            $expressionMapperContainer,
        );
    }
}