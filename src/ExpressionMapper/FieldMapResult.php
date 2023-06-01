<?php
declare(strict_types=1);

namespace Ergnuor\Criteria\ExpressionMapper;

use Doctrine\Common\Collections\ArrayCollection;
use Ergnuor\Criteria\Parameter;

/**
 * @template TExpression
 */
class FieldMapResult
{
    /** @var mixed TExpression */
    private mixed $mappedExpression;

    /** @var ArrayCollection<Parameter> */
    private ArrayCollection $parameters;

    public function __construct(mixed $mappedExpression)
    {
        $this->mappedExpression = $mappedExpression;
        $this->parameters = new ArrayCollection();
    }

    public function addParameter(Parameter $parameter): void
    {
        $this->parameters->add($parameter);
    }

    /**
     * @return TExpression
     */
    public function getMappedExpression(): mixed
    {
        return $this->mappedExpression;
    }

    public function getParameters(): ArrayCollection
    {
        return $this->parameters;
    }
}