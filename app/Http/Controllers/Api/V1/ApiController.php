<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class ApiController extends Controller
{

    use ApiResponses;

    protected $policyClass;

    public function isAble($ability, $targetModel)
    {
        try {
            Gate::authorize($ability, [ $targetModel, $this->policyClass ]);
            return true;
        } catch (AuthorizationException $exception) {
            return false;
        }
    }

}
