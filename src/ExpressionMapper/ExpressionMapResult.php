<?php
declare(strict_types=1);

namespace Ergnuor\Criteria\ExpressionMapper;

/**
 * @template TExpression
 * @template TParameters
 */
class ExpressionMapResult
{
    /** @var TExpression */
    private $mappedExpression;
    /** @var TParameters */
    private $mappedParameters;

    /**
     * @param TExpression $mappedExpression
     * @param TParameters $mappedParameters
     */
    public function __construct($mappedExpression, $mappedParameters)
    {
        $this->mappedExpression = $mappedExpression;
        $this->mappedParameters = $mappedParameters;
    }

    /**
     * @return TExpression
     */
    public function getMappedExpression()
    {
        return $this->mappedExpression;
    }

    /**
     * @return TParameters
     */
    public function getMappedParameters()
    {
        return $this->mappedParameters;
    }
}