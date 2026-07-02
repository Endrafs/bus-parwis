<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $websiteSettings->nama_website ?? config('app.name', 'Bus Parwis') }} — Sewa Bus Pariwisata</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">
                        🚌 {{ $websiteSettings->nama_website ?? 'Bus Parwis' }}
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 font-medium">
                        Beranda
                    </a>
                    @auth
                        <a href="{{ route('booking.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium">
                            Booking Saya
                        </a>
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 font-medium">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-600 font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium transition">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <h1 class="text-3xl sm:text-5xl font-bold mb-4">
                Sewa Bus Pariwisata Nyaman & Terpercaya
            </h1>
            <p class="text-lg sm:text-xl text-indigo-100 mb-8 max-w-2xl">
                {{ $websiteSettings->deskripsi ?? 'Tersedia Big Bus & Medium Bus dengan berbagai fasilitas modern. Booking mudah, harga transparan!' }}
            </p>
            <a href="#bus-list"
               class="inline-block bg-white text-indigo-600 font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 transition shadow-lg">
                Lihat Armada Bus →
            </a>
        </div>
    </div>

    <!-- Bus List Section -->
    <div id="bus-list" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-8 text-center">
            Armada Bus Kami
        </h2>

        @if($buses->isEmpty())
            <div class="text-center py-16">
                <p class="text-gray-500 text-lg">Belum ada armada bus yang tersedia.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($buses as $bus)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden border border-gray-100">
                        <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            @if($bus->foto)
                                <img src="{{ asset('storage/' . $bus->foto) }}" alt="{{ $bus->nama_bus }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center text-white">
                                    <svg class="w-20 h-20 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8M8 11h8M8 15h5M4 19h16a1 1 0 001-1V6a1 1 0 00-1-1H4a1 1 0 00-1 1v12a1 1 0 001 1z" /></svg>
                                    <span class="text-sm opacity-75">Foto belum tersedia</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-900">{{ $bus->nama_bus }}</h3>
                            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bus->kategori_bus === 'Big Bus' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $bus->kategori_bus }}
                            </span>
                            <div class="space-y-2 text-sm text-gray-600 mt-3">
                                <div>🪑 Kapasitas: <strong>{{ $bus->kapasitas }} orang</strong></div>
                                <div>🏷️ Tipe: {{ $bus->tipe_bus }}</div>
                                @if($bus->facilities->isNotEmpty())
                                    <div>✨ 
                                        @foreach($bus->facilities->take(3) as $f)
                                            <span class="inline-block bg-gray-100 px-2 py-0.5 rounded text-xs mr-1">{{ $f->nama_fasilitas }}</span>
                                        @endforeach
                                        @if($bus->facilities->count() > 3)
                                            <span class="text-gray-400 text-xs">+{{ $bus->facilities->count() - 3 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="border-t mt-4 pt-4 flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-gray-500">Harga sewa / hari</span>
                                    <div class="text-xl font-bold text-indigo-600">Rp {{ number_format($bus->harga_sewa, 0, ',', '.') }}</div>
                                </div>
                                <a href="{{ route('bus.show', $bus) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium text-sm transition">
                                    Detail →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} {{ $websiteSettings->nama_website ?? 'Bus Parwis' }}. All rights reserved.
        </div>
    </footer>
</body>
</html>
