<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Saya — Bus Parwis</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">🚌 Bus Parwis</a>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('booking.index') }}" class="text-indigo-600 font-medium">Booking Saya</a>
                    <span class="text-gray-500">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 font-medium">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">📋 Booking Saya</h1>
            <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium">
                + Pesan Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($bookings->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="text-5xl mb-4">📭</div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada booking</h3>
                <p class="text-gray-500 mb-6">Anda belum melakukan pemesanan bus.</p>
                <a href="{{ route('home') }}" class="inline-block bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 font-medium">
                    Lihat Armada Bus
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    <a href="{{ route('booking.show', $booking->kode_booking) }}"
                       class="block bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:border-indigo-200 transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-xl flex-shrink-0">🚌</div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $booking->bus->nama_bus ?? 'Bus (dihapus)' }}</h3>
                                    <p class="text-sm text-gray-500">{{ $booking->kode_booking }}</p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        📍 {{ $booking->tujuan }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        📅 {{ $booking->tanggal_berangkat->format('d M Y') }} — {{ $booking->tanggal_kembali->format('d M Y') }}
                                        ({{ $booking->jumlah_hari }} hari)
                                    </p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    @switch($booking->status)
                                        @case('Pending') bg-yellow-100 text-yellow-800 @break
                                        @case('Menunggu Verifikasi') bg-blue-100 text-blue-800 @break
                                        @case('Dikonfirmasi') bg-green-100 text-green-800 @break
                                        @case('Berjalan') bg-indigo-100 text-indigo-800 @break
                                        @case('Selesai') bg-gray-100 text-gray-800 @break
                                        @case('Dibatalkan') bg-red-100 text-red-800 @break
                                        @default bg-gray-100 text-gray-800
                                    @endswitch">
                                    {{ $booking->status }}
                                </span>
                                <p class="text-lg font-bold text-indigo-600 mt-2">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
