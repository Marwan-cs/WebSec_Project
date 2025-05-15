@component('mail::message')
# Your Order Has Been Shipped!

Dear {{ $order->user->name }},

Great news! Your order #{{ $order->id }} has been shipped.

## Tracking Information
**Tracking Number:** {{ $order->tracking_number }}

You can track your package using the tracking number above.

## Shipping Address
{{ $order->shipping_address }}
{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}
{{ $order->shipping_country }}

@component('mail::button', ['url' => route('orders.show', $order)])
View Order Details
@endcomponent

If you have any questions about your shipment, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent 