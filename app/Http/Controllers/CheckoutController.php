<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $countries = [
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'AU' => 'Australia',
            'DE' => 'Germany',
            'FR' => 'France',
            'IN' => 'India',
            'CN' => 'China',
            'JP' => 'Japan',
            'BR' => 'Brazil',
            // Add more as needed
        ];
        return view('checkout.index', compact('cart', 'total', 'countries'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_zipcode' => 'required|string',
            'shipping_country' => 'required|string',
            'payment_method' => 'required|in:credit_card,paypal',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $this->calculateTotal($cart),
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zipcode' => $request->shipping_zipcode,
                'shipping_country' => $request->shipping_country,
                'payment_method' => $request->payment_method,
                'status' => 'pending'
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            DB::commit();
            Session::forget('cart');

            // Send order confirmation email
            Mail::to(auth()->user()->email)->send(new OrderConfirmation($order));

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
} 