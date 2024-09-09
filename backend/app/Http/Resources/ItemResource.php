<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

final class ItemResource extends JsonResource
{
    public function toArray($request): array
    {
        /**
         * @var \Illuminate\Filesystem\FilesystemAdapter $disk
         */
        $disk = Storage::disk('s3');
        $imageUrl = $disk->url($this->s3_key);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $imageUrl,
            'cost_price' => $this->cost_price,
            'tax_rate_id' => $this->tax_rate_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}