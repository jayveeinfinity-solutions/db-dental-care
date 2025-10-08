<?php

namespace App\Http\Controllers;

use App\Models\Service;

class HomeController extends Controller
{
    public function index() {
        $services = Service::featured()
            ->get();

        return view('pages.home', compact('services'));
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
