<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocalAttraction;

class LocalAttractionsController extends Controller
{
    /**
     * Show Local Attractions page
     */
    public function index()
    {
        $attractions = LocalAttraction::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('pages.local_attractions.index', [
            'attractions' => $attractions,
        ]);
    }
}
