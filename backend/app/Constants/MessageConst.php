<?php
declare(strict_types=1);

namespace App\Constants;


class MessageConst
{
    public const PLAN_NOT_SUBSCRIBED = 'ご契約中のプランが見つかりません';
    public const PLAN_LIMIT_TABLE_COUNT_EXCEEDED = 'ご契約のプランのテーブル数上限（:limit）を超えています';
    public const UPLOAD_FILE_FAILED = 'ファイルのアップロードに失敗しました';

    public static function generateMessage(string $message, array $params = []): string
    {
        foreach ($params as $key => $value) {
            $message = str_replace(":$key", (string)$value, $message);
        }
        return $message;
    }
}