<?php

namespace App\Http\Requests\Tenant;

use App\Http\Requests\ApiRequest;

class ChangeTableCountRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'new_table_count' => 'required|integer|min:1',
        ];
    }
}