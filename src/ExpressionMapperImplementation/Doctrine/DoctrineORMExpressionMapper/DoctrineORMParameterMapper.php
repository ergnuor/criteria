<?php

declare(strict_types=1);

namespace Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine\DoctrineORMExpressionMapper;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter as DoctrineORMParameter;
use Ergnuor\Criteria\Parameter;
use Ergnuor\Criteria\ExpressionMapper\ParameterMapperInterface;
use Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine\DoctrineParameterTypeMap;

/**
 * @implements ParameterMapperInterface<ArrayCollection<int, DoctrineORMParameter>>
 */
class DoctrineORMParameterMapper implements ParameterMapperInterface
{
    /**
     * @inheritDoc
     */
    public function mapParameters(ArrayCollection $parameters)
    {
        return $parameters->map(
            fn(Parameter $parameter) => new DoctrineORMParameter(
                $parameter->getName(),
                $parameter->getValue(),
                DoctrineParameterTypeMap::getMappedType($parameter->getType())
            )
        );
    }
}