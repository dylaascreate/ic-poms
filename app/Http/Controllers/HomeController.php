<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\Team;

class HomeController extends Controller
{
    public function index()
    {
        $promotions = Promotion::all();
        $products = Product::all();
        $teams = Team::all();

        return view('welcome', compact('promotions', 'products', 'teams'));
    }
}

