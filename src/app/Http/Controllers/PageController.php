<?php

namespace App\Http\Controllers;

use App\Models\PageSection;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $pageSections = PageSection::forPage('about')
            ->get()
            ->keyBy('section_key');

        $websiteSettings = WebsiteSetting::first();

        return view('pages.about', compact('pageSections', 'websiteSettings'));
    }

    public function services()
    {
        $pageSections = PageSection::forPage('services')
            ->get()
            ->keyBy('section_key');

        $websiteSettings = WebsiteSetting::first();

        return view('pages.services', compact('pageSections', 'websiteSettings'));
    }

    public function contact()
    {
        $pageSections = PageSection::forPage('contact')
            ->get()
            ->keyBy('section_key');

        $websiteSettings = WebsiteSetting::first();

        return view('pages.contact', compact('pageSections', 'websiteSettings'));
    }

    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'no_wa' => 'required|string|max:20',
            'pesan' => 'required|string|max:1000',
        ]);

        return redirect()->route('contact')->with('success', 'Pesan Anda telah terkirim! Tim kami akan membalas dalam 1×24 jam kerja.');
    }
}
