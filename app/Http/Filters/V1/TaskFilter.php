<?php

namespace App\Http\Filters\V1;

use Illuminate\Support\Facades\Auth;

class TaskFilter extends QueryFilter
{
    public function status($value)
    {
        return $this->builder->where('user_id', Auth::user()->id)->where('status', $value);
    }
}
