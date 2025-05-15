<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class Cart
{
    public static function count()
    {
        $cart = Session::get('cart', []);
        return count($cart);
    }

    public static function content()
    {
        return Session::get('cart', []);
    }

    public static function add($product, $quantity = 1)
    {
        $cart = Session::get('cart', []);
        
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image_url
            ];
        }
        
        Session::put('cart', $cart);
    }

    public static function update($id, $quantity)
    {
        $cart = Session::get('cart', []);
        
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }
    }

    public static function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
    }

    public static function clear()
    {
        Session::forget('cart');
    }

    public static function total()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }
} 