<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\PageSection;
use App\Models\WebsiteSetting;
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

        $websiteSettings = WebsiteSetting::first();

        $pageSections = PageSection::forPage('home')
            ->get()
            ->keyBy('section_key');

        return view('buses.index', compact('buses', 'websiteSettings', 'pageSections'));
    }

    /**
     * Halaman Detail Bus — menampilkan detail satu bus beserta fasilitasnya.
     */
    public function show(Bus $bus): View
    {
        $bus->load('facilities');
        $websiteSettings = WebsiteSetting::first();

        return view('buses.show', compact('bus', 'websiteSettings'));
    }
}
