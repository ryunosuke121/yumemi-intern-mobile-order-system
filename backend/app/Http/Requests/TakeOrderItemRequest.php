<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\OrderItem;
use Illuminate\Foundation\Http\FormRequest;

final class TakeOrderItemRequest extends FormRequest
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
            'items' => ['required', 'array'],
            'items.*.id' => ['integer', 'exists:items,id'],
            'items.*.quantity' => ['integer', 'min:1'],
        ];
    }

    public function makeOrderItems(): array
    {
        $orderItems = [];
        foreach ($this->items as $item) {
            $orderItems[] = new OrderItem([
                'item_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return $orderItems;
    }
}
