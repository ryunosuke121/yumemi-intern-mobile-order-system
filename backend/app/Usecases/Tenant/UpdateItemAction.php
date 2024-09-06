<?php

namespace App\Usecases\Tenant;

use App\Constants\MessageConst;
use App\Models\Item;
use App\Models\Tenant;
use App\Usecases\Tenant\Exceptions\UploadFileFailedException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateItemAction
{
    public function __invoke(Tenant $tenant, int $itemID, Item $newItem, ?UploadedFile $newImage): Item
    {
        $item = Item::find($itemID);

        if($newImage) {
            // 古い画像を削除
            if($item->s3_key) {
                Storage::disk('s3')->delete($item->s3_key);
            }

            $filePath = $this->uploadImage($tenant, $newItem, $newImage);
            $newItem->s3_key = $filePath;
        }

        $item->update($newItem->toArray());

        return $item;
    }

    public function uploadImage(Tenant $tenant, Item $item, UploadedFile $image): string
    {
        $path = 'tenants/' . $tenant->id . '/items';
        $uniqueId = Str::uuid();
        $extension = $image->extension();
        $fileName = $uniqueId . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        $result = Storage::disk('s3')->put($filePath, file_get_contents($image), 'public');
        if($result === false) {
            throw new UploadFileFailedException(MessageConst::UPLOAD_FILE_FAILED);
        }

        return $filePath;
    }
}
