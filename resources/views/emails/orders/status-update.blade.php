@component('mail::message')
# Order Status Update

Dear {{ $order->user->name }},

Your order #{{ $order->id }} status has been updated.

**Previous Status:** {{ ucfirst($oldStatus) }}
**New Status:** {{ ucfirst($newStatus) }}

@if($newStatus === 'processing')
Your order is now being processed. We'll notify you when it ships.
@elseif($newStatus === 'completed')
Your order has been completed. Thank you for shopping with us!
@elseif($newStatus === 'cancelled')
Your order has been cancelled. If you didn't request this cancellation, please contact us immediately.
@endif

@component('mail::button', ['url' => route('orders.show', $order)])
View Order Details
@endcomponent

If you have any questions about your order, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent 