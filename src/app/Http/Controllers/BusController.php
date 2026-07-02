<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BusController extends Controller
{
    /**
     * Landing Page — menampilkan daftar semua bus yang tersedia (status aktif).
     */
    public function index(): View
    {
        $buses = Bus::with('facilities')
            ->where('status', true)
            ->latest()
            ->get();

        return view('buses.index', compact('buses'));
    }

    /**
     * Halaman Detail Bus — menampilkan detail satu bus beserta fasilitasnya.
     */
    public function show(Bus $bus): View
    {
        $bus->load('facilities');

        return view('buses.show', compact('bus'));
    }
}
