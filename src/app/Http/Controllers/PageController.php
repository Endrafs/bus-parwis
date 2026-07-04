<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $websiteSettings = WebsiteSetting::first();
        return view('pages.about', compact('websiteSettings'));
    }

    public function services()
    {
        $websiteSettings = WebsiteSetting::first();
        return view('pages.services', compact('websiteSettings'));
    }

    public function contact()
    {
        $websiteSettings = WebsiteSetting::first();
        return view('pages.contact', compact('websiteSettings'));
    }

    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'no_wa' => 'required|string|max:20',
            'pesan' => 'required|string|max:1000',
        ]);

        // Simpan ke database atau kirim notifikasi
        // Untuk saat ini, hanya redirect dengan session success

        return redirect()->route('contact')->with('success', 'Pesan Anda telah terkirim! Tim kami akan membalas dalam 1×24 jam kerja.');
    }
}
