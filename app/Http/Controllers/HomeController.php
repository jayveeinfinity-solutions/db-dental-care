<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        
    ) {}

    public function index() {
        $featuredServices = Service::featured()
            ->get()
            ->transform(function($item) {
                $item->price_min = number_format($item->price_min, 2);
                $item->price_max = number_format($item->price_max, 2);
                
                return $item;
            });

        return view('pages.home', compact('featuredServices'));
    }

    public function services(Request $request) {
        $category = request()->query('category', '');

        $services = Service::active()
            ->when($category !== '', function($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->get()
            ->transform(function($item) {
                $item->price_min = number_format($item->price_min, 2);
                $item->price_max = number_format($item->price_max, 2);
                
                return $item;
            });

        $categories = Category::all();

        return view('pages.services', compact('services', 'categories'));
    }

    public function about() {        
        return view('pages.about');
    }
}
