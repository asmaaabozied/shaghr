<?php

namespace App\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class CustomPriceSearchSort implements Sort
{

    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $query->whereHas('prices', function (Builder $query) use ($property,$descending) {
            $query->orderBy($property, 'asc');
        });

    }
}
