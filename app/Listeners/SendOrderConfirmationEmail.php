<?php

namespace App\Listeners;
use Illuminate\Support\Facades\Log;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class SendOrderConfirmationEmail
{
    public function handle(OrderPlaced $event)
    {
        Log::info('OrderPlaced event fired for Order ID: ' . $event->order->id);
        $order = $event->order;
        if($order->customer_email) {
            Mail::to($order->customer_email)
                ->send(new OrderConfirmation($order));
        }
    }
}
