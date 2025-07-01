<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // simpan & kirim real-time
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Order #' . $this->order->order_number . ' status updated',
            'message' => 'Your order status has been updated to "' . ucfirst($this->order->status->value) . '".',
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Order #' . $this->order->order_number . ' status updated',
            'message' => 'Your order status has been updated to "' . ucfirst($this->order->status->value) . '".',
            'order_id' => $this->order->id,
        ]);
    }
}
