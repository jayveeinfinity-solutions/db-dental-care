<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Category;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $featuredServices = Service::featured()
            ->get()
            ->transform(function($item) {
                $item->price_min = number_format($item->price_min, 2);
                $item->price_max = number_format($item->price_max, 2);
                
                return $item;
            });

        $services = Service::with('category')
            ->active()
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        $userPendingAppointments = auth()->user()
            ?->appointments()
            ->where('status', 'pending')
            ->get() ?? collect();

        $start = Carbon::createFromTimeString('08:00');
        $end = Carbon::createFromTimeString('17:00');
        $interval = CarbonInterval::hour();
        $times = [];

        for ($time = $start->copy(); $time->lte($end); $time->add($interval)) {
            $times[] = [
                'value' => $time->format('H:i'),
                'text' => $time->format('g:i A'),
            ];
        }

        return view('pages.home', compact('featuredServices', 'services', 'userPendingAppointments', 'times'));
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
