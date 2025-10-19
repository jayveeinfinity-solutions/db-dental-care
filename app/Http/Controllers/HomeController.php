<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Service;
use Carbon\CarbonInterval;

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

    public function services() {
        $services = Service::active()
            ->get();

        return view('pages.services', compact('services'));
    }

    public function about() {
        return view('pages.about');
    }
}
