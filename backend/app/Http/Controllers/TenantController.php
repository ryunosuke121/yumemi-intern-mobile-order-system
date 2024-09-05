<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tenant\ChangeTableCountRequest;
use App\Usecases\Tenant\ChangeTableCountAction;
use App\Usecases\Tenant\Exceptions\PlanLimitExceededException;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function changeTableCount(ChangeTableCountRequest $request, ChangeTableCountAction $action): void {
        $tenant = $request->user()->tenant;
        $action($tenant, $request->new_table_count);
    }
}
