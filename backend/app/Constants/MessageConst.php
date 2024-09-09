<?php

declare(strict_types=1);

namespace App\Constants;

final class MessageConst
{
    public const PLAN_NOT_SUBSCRIBED = 'ご契約中のプランが見つかりません';
    public const PLAN_LIMIT_TABLE_COUNT_EXCEEDED = 'ご契約のプランのテーブル数上限（:limit）を超えています';
    public const UPLOAD_FILE_FAILED = 'ファイルのアップロードに失敗しました';
    public const ITEM_NOT_FOUND = '商品が見つかりません';
    public const TABLE_NUMBER_INVALID = 'テーブル番号が無効です';
    public const ACTIVE_ORDER_ALREADY_EXIST = '既にオーダーが存在しています';
    public const CREATE_TOKEN_FAILED = 'トークンの生成に失敗しました';

    public static function generateMessage(string $message, array $params = []): string
    {
        foreach ($params as $key => $value) {
            $message = str_replace(":$key", (string)$value, $message);
        }
        return $message;
    }
}