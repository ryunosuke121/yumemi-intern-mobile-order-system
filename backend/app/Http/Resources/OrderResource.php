<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class InitOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'token' => $this->token,
            'order' => $this->order,
            'pageURL' => $this->pageURL,
        ];
    }
}