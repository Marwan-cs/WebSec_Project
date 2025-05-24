@component('mail::message')
# Order Confirmation

Dear {{ $order->user->name }},

Thank you for your order! We're pleased to confirm that we've received your order #{{ $order->id }}.

## Order Summary

@component('mail::table')
| Product | Quantity | Price |
|:--------|:---------|:------|
@foreach($order->items as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | ${{ number_format($item->price * $item->quantity, 2) }} |
@endforeach
@endcomponent

**Total Amount:** ${{ number_format($order->total_amount, 2) }}

## Shipping Information
{{ $order->shipping_address }}
{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}
{{ $order->shipping_country }}

@component('mail::button', ['url' => route('orders.show', $order)])
View Order Details
@endcomponent

If you have any questions about your order, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent 