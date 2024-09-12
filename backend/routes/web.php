<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::get('/order/{tenant_id}', static function () {
    return view('order', ['tenant_id' => request()->route('tenant_id')]);
});