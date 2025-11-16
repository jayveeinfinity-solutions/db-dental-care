<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Search services by query for autocomplete
     */
    public function search(Request $request)
    {
        $q = $request->query('q');

        if (!$q) {
            return response()->json([]);
        }

        $services = Service::where('name', 'like', "%{$q}%")
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($services);
    }
}
