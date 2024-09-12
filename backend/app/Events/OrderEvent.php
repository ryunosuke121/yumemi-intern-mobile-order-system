<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\OrderItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class OrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public OrderItem $orderItem;

    /**
     * Create a new event instance.
     */
    public function __construct(OrderItem $orderItem)
    {
        $orderItem->load('item');
        $this->orderItem = $orderItem;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('tenants.' . $this->orderItem->order->tenant->id);
    }
}
