<?php

namespace App\Usecases\Tenant;

use App\Models\MSubscriptionPlan;
use App\Models\Tenant;
use App\Usecases\Tenant\Exceptions\PlanLimitExceededException;

class ChangeTableCountAction
{
    public function __invoke(Tenant $tenant, int $newTableCount): void
    {
        assert($tenant->exists);
        if($tenant->currentSubscriptionPlan() === null) {
            throw new PlanLimitExceededException('Cannot change table count without subscription');
        }

        // プランごとのテーブル数上限を超えていないかチェック
        if($newTableCount > $tenant->currentSubscriptionPlan()->max_table_count) {
            throw new PlanLimitExceededException('Cannot set table count higher than ' . $tenant->currentSubscriptionPlan()->max_table_count);
        }

        $tenant->table_count = $newTableCount;
        $tenant->save();
    }
}