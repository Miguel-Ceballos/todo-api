<?php

namespace App\Http\Filters\V1;

use App\Http\Filters\V1\QueryFilter;

class CategoryFilter extends QueryFilter
{
    public function include($value)
    {
        return $this->builder->with($value);
    }
}
