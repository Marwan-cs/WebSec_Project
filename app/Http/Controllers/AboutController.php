<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
// Add your real models here (e.g., Client, Category, Country, etc.)

class AboutController extends Controller
{
    public function index()
    {
        // Example: Replace with your real models and logic
        $clientsCount = User::count(); // Replace with Client::count() if you have a Client model
        $categoriesCount = 10; // Replace with Category::count() if you have a Category model
        $countriesCount = 1; // Replace with Country::count() if you have a Country model
        $happyCustomersPercent = 98; // Replace with real calculation if needed

        return view('webfront.about', compact('clientsCount', 'categoriesCount', 'countriesCount', 'happyCustomersPercent'));
    }
} 