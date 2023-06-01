<?php

declare(strict_types=1);

namespace Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine\DoctrineDBALExpressionMapper;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Ergnuor\Criteria\ExpressionMapper\ParameterMapperInterface;
use Ergnuor\Criteria\ExpressionMapperImplementation\Doctrine\DoctrineParameterTypeMap;

/**
 * @implements ParameterMapperInterface<array<string, array{0: mixed, 1: int|string}>>
 */
class DoctrineDBALParameterMapper implements ParameterMapperInterface
{
    /**
     * @inheritDoc
     */
    public function mapParameters(ArrayCollection $parameters)
    {
        $mappedParameters = [
            [],
            [],
        ];

        foreach ($parameters as $parameter) {
            $mappedParameters[$parameter->getName()] = [
                $parameter->getValue(),
                DoctrineParameterTypeMap::getMappedType(
                    $parameter->getType(),
                    Types::STRING,
                )
            ];
        }

        return $mappedParameters;

//        return $parameters->map(
//            fn(Parameter $parameter) => new DoctrineDBALParameter(
//                $parameter->getName(),
//                $parameter->getValue(),
//                DoctrineParameterTypeMap::getMappedType($parameter->getType())
//            )
//        );
    }
}