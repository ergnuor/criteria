<?php

declare(strict_types=1);

namespace Ergnuor\Criteria\ExpressionMapper;

use Doctrine\Common\Collections\ArrayCollection;
use Ergnuor\Criteria\Exception\UnsupportedFieldOperatorException;
use Ergnuor\Criteria\Expression\Expression;
use Ergnuor\Criteria\Expression\CompositeExpression;
use Ergnuor\Criteria\Expression\ExpressionInterface;
use Ergnuor\Criteria\Expression\NegationExpression;
use Ergnuor\Criteria\FieldMapper\FieldExpressionMapperInterface;
use Ergnuor\Criteria\Parameter;
use Ergnuor\Criteria\Type\TypeInferer;
use Ergnuor\Criteria\ValueSource\ValueSourceBuilder;
use Ergnuor\Criteria\ValueSource\ValueSourceInterface;
use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * @template TExpression
 * @template TParameters
 */
class ExpressionMapper implements ExpressionMapperInterface
{
    /** @var array<string, Field> */
    private array $fields;

    /** @var ArrayCollection<int, Parameter> */
    private ArrayCollection $parameters;
    private ParameterMapperInterface $parameterMapper;
    private FieldExpressionMapperInterface $basicFieldExpressionMapper;
    private Identifiers $identifiers;
    private LogicalExpressionMapperInterface $logicalExpressionMapper;
    private ValueSourceBuilder $valueSourceBuilder;
    private ?ContainerInterface $expressionMapperContainer;

    public function __construct(
        ParameterMapperInterface $parameterMapper,
        FieldExpressionMapperInterface $basicFieldExpressionMapper,
        LogicalExpressionMapperInterface $logicalExpressionMapper,
        ContainerInterface $expressionMapperContainer = null
    ) {
        $this->parameterMapper = $parameterMapper;
        $this->basicFieldExpressionMapper = $basicFieldExpressionMapper;
        $this->logicalExpressionMapper = $logicalExpressionMapper;
        $this->expressionMapperContainer = $expressionMapperContainer;

        $this->valueSourceBuilder = new ValueSourceBuilder();
        $this->fields = [];

        $this->reset();
    }

    private function reset(): void
    {
        $this->parameters = new ArrayCollection();
        $this->identifiers = new Identifiers();
    }

    public function addField(
        string $fieldName,
        ?ValueSourceInterface $valueSource,
        null|string|FieldExpressionMapperInterface $fieldExpressionMapper = null
    ): void {
        $valueSource = $valueSource ?? $this->valueSourceBuilder->field($fieldName);

        $this->fields[$fieldName] = new Field(
            $valueSource,
            $fieldExpressionMapper ?? $this->basicFieldExpressionMapper
        );
    }

    private function mapParameters(): mixed
    {
        return $this->parameterMapper->mapParameters($this->parameters);
    }

    private function mapCompositeExpression(CompositeExpression $compositeExpression): mixed
    {
        $expressionList = [];

        foreach ($compositeExpression->getExpressionList() as $child) {
            $expressionList[] = $this->doMap($child);
        }

        $type = $compositeExpression->getType();
        return match ($type) {
            CompositeExpression::TYPE_AND => $this->logicalExpressionMapper->andX(...$expressionList),
            CompositeExpression::TYPE_OR => $this->logicalExpressionMapper->orX(...$expressionList),
            default => throw new RuntimeException(
                sprintf(
                    "Unknown composite type '%s'",
                    $type
                )
            ),
        };
    }

    /**
     * @param ExpressionInterface $expr
     * @return ExpressionMapResult<TExpression, TParameters>
     */
    public function map(ExpressionInterface $expr): ExpressionMapResult
    {
        $this->reset();

        return new ExpressionMapResult(
            $this->doMap($expr),
            $this->mapParameters()
        );
    }

    private function doMap(ExpressionInterface $expr): mixed
    {
        return match (true) {
            $expr instanceof CompositeExpression => $this->mapCompositeExpression($expr),
            $expr instanceof Expression => $this->mapExpression($expr),
            $expr instanceof NegationExpression => $this->mapNegationExpression($expr),

            default => throw new RuntimeException('Unknown Expression ' . get_class($expr)),
        };
    }

    private function mapExpression(Expression $expression): mixed
    {
        $value = $expression->getValue()->getValue();

        $mapResult = $this->doMapExpression($expression, $value);

        if ($mapResult === null) {
            throw UnsupportedFieldOperatorException::fromExpression($expression);
        }

        foreach ($mapResult->getParameters() as $parameter) {
            $this->addParameter($parameter);
        }

        return $mapResult->getMappedExpression();
    }

    private function doMapExpression(Expression $expression, mixed $value): ?FieldMapResult
    {
        $field = $this->getField($expression->getFieldName());

        $expressionContext = new ExpressionContext(
            $value,
            TypeInferer::inferType($value),
            $expression->getFieldName(),
            $expression->getOperator(),
            $field->getValueSource(),
        );

        $fieldExpressionMapper = $this->getFieldExpressionMapper($field);

        return $fieldExpressionMapper->mapExpression($expressionContext, $this->identifiers);
    }

    private function getField(string $fieldName): Field
    {
        $field = $this->fields[$fieldName] ?? null;

        if ($field === null) {
            throw new \RuntimeException(
                sprintf(
                    "Unknown field '%s'",
                    $fieldName
                )
            );
        }

        return $field;
    }

    private function getFieldExpressionMapper(Field $field): FieldExpressionMapperInterface
    {
        $fieldExpressionMapper = $field->getFieldExpressionMapper();

        if (is_string($fieldExpressionMapper)) {
            if ($this->expressionMapperContainer === null) {
                throw new \RuntimeException(
                    sprintf(
                        "Unable to get field expression mapper with service name '%s': expression mapper service container is not defined",
                        $fieldExpressionMapper
                    )
                );
            }

            $fieldExpressionMapper = $this->expressionMapperContainer->get($fieldExpressionMapper);
        }

        return $fieldExpressionMapper;
    }

    private function addParameter(Parameter $parameter): void
    {
        $this->parameters->add($parameter);
    }

    private function mapNegationExpression(NegationExpression $negation): mixed
    {
        return $this->logicalExpressionMapper->not($this->doMap($negation->getExpression()));
    }
}
