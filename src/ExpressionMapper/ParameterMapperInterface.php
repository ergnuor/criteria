<?php

declare(strict_types=1);

namespace Ergnuor\Criteria\ExpressionMapper;

use Doctrine\Common\Collections\ArrayCollection;
use Ergnuor\Criteria\Parameter;

/**
 * @template TMappedParameters
 */
interface ParameterMapperInterface
{
    /**
     * @param ArrayCollection<int, Parameter> $parameters
     * @return TMappedParameters
     */
    public function mapParameters(ArrayCollection $parameters);
}