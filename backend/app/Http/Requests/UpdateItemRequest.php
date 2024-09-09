<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateItemRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:30'],
            'description' => ['sometimes', 'string', 'max:255'],
            'image' => ['sometimes', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'cost_price' => ['sometimes', 'integer'],
            'tax_rate_id' => ['sometimes', 'integer', 'exists:m_tax_rates,id'],
        ];
    }

    public function makeItem(): Item
    {
        $attributes = array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'cost_price' => $this->cost_price,
            'tax_rate_id' => $this->tax_rate_id,
        ]);

        return new Item($attributes);
    }
}