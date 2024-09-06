<?php

namespace App\Http\Requests;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:30'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'cost_price' => ['required', 'integer'],
            'tax_rate_id' => ['required', 'integer', 'exists:m_tax_rates,id'],
        ];
    }

    public function makeItem(): Item
    {
        return new Item([
            'name' => $this->name,
            'description' => $this->description,
            'cost_price' => $this->cost_price,
            'tax_rate_id' => $this->tax_rate_id,
        ]);
    }
}
