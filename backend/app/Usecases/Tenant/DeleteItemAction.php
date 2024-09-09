<?php

declare(strict_types=1);

namespace App\Usecases\Tenant;

use App\Constants\MessageConst;
use App\Models\Item;
use App\Models\Tenant;
use App\Usecases\Tenant\Exceptions\ItemNotFoundException;

final class DeleteItemAction
{
    public function __invoke(Tenant $tenant, int $itemID): void
    {
        $item = Item::where('tenant_id', $tenant->id)
            ->where('id', $itemID)
            ->first();
        
        if($item === null) {
            throw new ItemNotFoundException(MessageConst::ITEM_NOT_FOUND);
        }

        $item->delete();
    }
}