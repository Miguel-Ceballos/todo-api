<?php

namespace App\Http\Filters\V1;

use Illuminate\Support\Facades\Auth;

class TaskFilter extends QueryFilter
{

    public function include($value)
    {
        return $this->builder->with($value);
    }
    public function updatedAt($value)
    {
        $dates = explode(',', $value);
        if ( count($dates) > 1 ) {
            return $this->builder->whereBetween('updated_at', $dates);
        }
        return $this->builder->whereDate('updated_at', $value);
    }

    public function createdAt($value)
    {
        $dates = explode(',', $value);
        if ( count($dates) > 1 ) {
            return $this->builder->whereBetween('created_at', $dates);
        }
        return $this->builder->whereDate('created_at', $value);
    }

    public function description($value)
    {
        $like_str = str_replace('*', '%', $value);
        return $this->builder->where('user_id', Auth::user()->id)->where('description', 'like', $like_str);
    }

    public function title($value)
    {
        $like_str = str_replace('*', '%', $value);
        return $this->builder->where('user_id', Auth::user()->id)->where('title', 'like', $like_str);
    }

    public function status($value)
    {
        return $this->builder->where('user_id', Auth::user()->id)->whereIn('status', explode(',', $value));
    }
}
