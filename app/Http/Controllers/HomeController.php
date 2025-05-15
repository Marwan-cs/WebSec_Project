<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products (you can modify this query based on your needs)
        $featuredProducts = Product::where('is_featured', true)
                                 ->orWhere('is_sale', true)
                                 ->take(8)
                                 ->get();

        return view('webfront.home', compact('featuredProducts'));
    }
} 