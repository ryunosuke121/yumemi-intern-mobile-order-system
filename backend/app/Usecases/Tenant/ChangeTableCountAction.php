<?php

declare(strict_types=1);

namespace App\Usecases\Tenant;

use App\Constants\MessageConst;
use App\Models\Tenant;
use App\Usecases\Tenant\Exceptions\PlanLimitExceededException;

final class ChangeTableCountAction
{
    public function __invoke(Tenant $tenant, int $newTableCount): void
    {
        if($tenant->currentSubscriptionPlan() === null) {
            throw new PlanLimitExceededException(MessageConst::PLAN_NOT_SUBSCRIBED);
        }

        // プランごとのテーブル数上限を超えていないかチェック
        if($newTableCount > $tenant->currentSubscriptionPlan()->max_table_count) {
            throw new PlanLimitExceededException(
                MessageConst::generateMessage(
                    MessageConst::PLAN_LIMIT_TABLE_COUNT_EXCEEDED,
                    ['limit' => $tenant->currentSubscriptionPlan()->max_table_count]
                )
            );
        }

        $tenant->table_count = $newTableCount;
        $tenant->save();
    }
}