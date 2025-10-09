<?php

namespace App\Http\Controllers;

use App\Models\Service;

class HomeController extends Controller
{
    public function index() {
        $featuredServices = Service::featured()
            ->get();

        $services = Service::with('category')
            ->active()
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        return view('pages.home', compact('featuredServices', 'services'));
    }

    public function services() {
        $services = Service::active()
            ->get();

        return view('pages.services', compact('services'));
    }

    public function about() {
        return view('pages.about');
    }
}
