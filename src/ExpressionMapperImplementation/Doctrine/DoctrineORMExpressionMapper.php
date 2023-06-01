<?php
declare(strict_types=1);

namespace Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\Query\Expr\Composite;
use Doctrine\ORM\Query\Parameter as DoctrineORMParameter;
use Ergnuor\Criteria\ExpressionMapper\ExpressionMapper;
use Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine\DoctrineORMExpressionMapper\DoctrineORMParameterMapper;
use Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine\DoctrineORMExpressionMapper\DoctrineORMBasicExpressionMapper;
use Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine\DoctrineORMExpressionMapper\DoctrineORMLogicalExpressionMapper;
use Psr\Container\ContainerInterface;

/**
 * @extends ExpressionMapper<Composite|Comparison|string ,ArrayCollection<int, DoctrineORMParameter>>
 */
class DoctrineORMExpressionMapper extends ExpressionMapper
{
    public function __construct(ContainerInterface $expressionMapperContainer = null)
    {
        parent::__construct(
            new DoctrineORMParameterMapper(),
            new DoctrineORMBasicExpressionMapper(),
            new DoctrineORMLogicalExpressionMapper(),
            $expressionMapperContainer,
        );
    }
}