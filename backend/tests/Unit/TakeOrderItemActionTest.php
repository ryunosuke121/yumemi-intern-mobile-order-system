<?php

namespace Tests\Unit;

use App\Models\Item;
use App\Models\MTaxRate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tenant;
use App\Usecases\Order\TakeOrderItemAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TakeOrderItemActionTest extends TestCase
{
    use RefreshDatabase;

    public function testTakeOrderItemAction()
    {
        $tax_rate = MTaxRate::create([
            'tax_rate' => 0.1,
        ]);

        $tenant = Tenant::create([
            'name' => 'テスト店舗',
            'email' => 'testtenant@example.com',
            'table_count' => 10,
        ]);

        $order = Order::create([
            'tenant_id' => $tenant->id,
            'table_number' => 1,
            'status' => Order::STATUS_OPEN,
        ]);

        $item = Item::create([
            'tenant_id' => $tenant->id,
            'tax_rate_id' => $tax_rate->id,
            'name' => 'テスト商品A',
            'description' => 'テスト商品Aの説明',
            's3_key' => 'test.jpg',
            'cost_price' => 1000,
        ]);

        $orderItem = new OrderItem([
            'item_id' => $item->id,
            'quantity' => 2,
        ]);

        $action = new TakeOrderItemAction();
        $orderItems = $action($tenant->id, $order->id, [$orderItem]);

        $this->assertEquals(1, count($orderItems));
        $this->assertEquals($item->id, $orderItems[0]->item_id);
        $this->assertEquals(2, $orderItems[0]->quantity);
        $this->assertEquals($tax_rate->tax_rate, $orderItems[0]->tax_rate);
        $this->assertEquals($item->cost_price, $orderItems[0]->cost_price);
        $this->assertEquals(2000, $orderItems[0]->sub_total);
        $this->assertEquals(OrderItem::STATUS_PENDING, $orderItems[0]->status);
    }
}
