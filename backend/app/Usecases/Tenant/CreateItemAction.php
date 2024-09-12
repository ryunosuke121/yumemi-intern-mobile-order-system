<?php

declare(strict_types=1);

namespace App\Usecases\Tenant;

use App\Constants\MessageConst;
use App\Models\Item;
use App\Models\Tenant;
use App\Usecases\Tenant\Exceptions\UploadFileFailedException;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class CreateItemAction
{
    public function __invoke(Tenant $tenant, Item $item, UploadedFile $image): Item
    {
        $item->tenant_id = $tenant->id;

        try{
            $path = 'tenants/' . $tenant->id . '/items';
            $uniqueId = Str::uuid();
            $extension = $image->extension();
            $fileName = $uniqueId . '.' . $extension;
            $filePath = $path . '/' . $fileName;

            $result = Storage::disk('s3')->put($filePath, $image->getContent());
            if($result === false) {
                throw new UploadFileFailedException(MessageConst::UPLOAD_FILE_FAILED);
            }

            $item->s3_key = $filePath;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new UploadFileFailedException(MessageConst::UPLOAD_FILE_FAILED);
        }
        $item->save();
        return $item;
    }
}