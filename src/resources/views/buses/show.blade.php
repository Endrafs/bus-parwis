<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $bus->nama_bus }} — Bus Parwis</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600">← Kembali</a>
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">🚌 Bus Parwis</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-600 font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Bus Detail -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
            <div class="h-64 sm:h-80 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                @if($bus->foto)
                    <img src="{{ asset('storage/' . $bus->foto) }}" alt="{{ $bus->nama_bus }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center text-white">
                        <svg class="w-24 h-24 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8M8 11h8M8 15h5M4 19h16a1 1 0 001-1V6a1 1 0 00-1-1H4a1 1 0 00-1 1v12a1 1 0 001 1z" /></svg>
                        <span>Foto belum tersedia</span>
                    </div>
                @endif
            </div>

            <div class="p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $bus->nama_bus }}</h1>
                        <div class="flex gap-2 mt-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $bus->kategori_bus === 'Big Bus' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $bus->kategori_bus }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                {{ $bus->tipe_bus }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $bus->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $bus->status ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm text-gray-500">Harga sewa per hari</span>
                        <div class="text-3xl font-bold text-indigo-600">Rp {{ number_format($bus->harga_sewa, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Spesifikasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-xl p-5">
                        <h3 class="font-semibold text-gray-900 mb-3">📋 Spesifikasi</h3>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Kategori</dt>
                                <dd class="font-medium text-gray-900">{{ $bus->kategori_bus }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Tipe</dt>
                                <dd class="font-medium text-gray-900">{{ $bus->tipe_bus }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Kapasitas</dt>
                                <dd class="font-medium text-gray-900">{{ $bus->kapasitas }} orang</dd>
                            </div>
                        </dl>
                    </div>

                    @if($bus->facilities->isNotEmpty())
                    <div class="bg-gray-50 rounded-xl p-5">
                        <h3 class="font-semibold text-gray-900 mb-3">✨ Fasilitas</h3>
                        <ul class="space-y-1.5 text-sm">
                            @foreach($bus->facilities as $facility)
                                <li class="flex items-center gap-2 text-gray-700">
                                    <span class="text-green-500">✓</span>
                                    {{ $facility->nama_fasilitas }}
                                    @if($facility->deskripsi)
                                        <span class="text-gray-400 text-xs">— {{ $facility->deskripsi }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <!-- CTA -->
                <div class="border-t pt-6 flex flex-col sm:flex-row items-center gap-4">
                    @auth
                        <a href="{{ route('booking.create', ['bus_id' => $bus->id]) }}" class="w-full sm:w-auto text-center bg-indigo-600 text-white px-8 py-3.5 rounded-xl hover:bg-indigo-700 font-semibold text-lg transition shadow-md">
                            Pesan Sekarang
                        </a>
                    @else
                        <div class="w-full text-center bg-gray-100 rounded-xl p-4">
                            <p class="text-gray-600">Silakan <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Login</a> atau <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Daftar</a> untuk memesan bus ini.</p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Bus Parwis. All rights reserved.
        </div>
    </footer>
</body>
</html>
