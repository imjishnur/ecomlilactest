@component('mail::message')
# Thank you for your order!

Order #{{ $order->id }} placed successfully.

**Customer:** {{ $order->customer_name }}  
**Total:** ${{ number_format($order->total, 2) }}

@component('mail::button', ['url' => url('/')])
Continue Shopping
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
