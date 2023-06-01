<?php
declare(strict_types=1);

namespace Ergnuor\Criteria\OrderMapper;

use Ergnuor\Criteria\ValueSource\ValueSourceInterface;

interface OrderMapperInterface
{
    const ASC = 'asc';
    const DESC = 'desc';

    /**
     * @param array<string, string> $sort
     * @return mixed
     */
    public function map(array $sort): mixed;

    public function addField(string $fieldName, ?ValueSourceInterface $valueSource): void;
}