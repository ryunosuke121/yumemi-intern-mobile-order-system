<?php

use App\Models\OrderItem;
use App\Models\Staff;
use App\Models\Tenant;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tenants.{tenantID}', function (Staff $staff, int $tenantID) {
    return $staff->tenant_id === $tenantID;
});
