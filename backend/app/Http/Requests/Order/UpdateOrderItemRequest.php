<?php

namespace App\Http\Requests\Order;

use App\Models\OrderItem;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderItemRequest extends FormRequest
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
            'quantity' => ['sometimes', 'integer', 'min:1'],
            'status' => ['sometimes', 'string', 'in:pending,completed,cancelled']
        ];
    }

    public function makeOrderItem(): OrderItem
    {
        $attributes = array_filter([
            'quantity' => $this->quantity,
            'status' => $this->status,
        ]);

        return new OrderItem($attributes);
    }
}
