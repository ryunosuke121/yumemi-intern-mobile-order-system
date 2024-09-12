<?php

declare(strict_types=1);

use App\Models\Staff;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tenants.{tenantID}', static function (Staff $staff, int $tenantID) {
    return $staff->tenant_id === $tenantID;
});
