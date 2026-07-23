<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::where('is_featured', true)
                           ->where('is_active', true)
                           ->orderByDesc('created_at')
                           ->take(8)
                           ->get();

        return view('pages.home', compact('featured'));
    }

    public function about()
    {
        return view('pages.about');
    }
}
