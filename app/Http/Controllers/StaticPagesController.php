<?php

namespace App\Http\Controllers;

class StaticPagesController extends Controller
{
    public function generalDentistry() {
        return view('pages/static/general-dentistry');
    }

    public function cosmeticDentistry() { 
        return view('pages/static/cosmetic-dentistry');
    }

    public function restorativeDentistry() { 
        return view('pages/static/restorative-dentistry');
    }

    public function preventiveDentistry() {
        return view('pages/static/preventive-dentistry');
    }

    public function orthodontics() {
        return view('pages/static/orthodontics');
    }
}
