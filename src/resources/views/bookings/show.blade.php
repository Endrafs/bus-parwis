<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking {{ $booking->kode_booking }} — Bus Parwis</title>
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
                    <a href="{{ route('booking.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Booking Saya</a>
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
        <a href="{{ route('booking.index') }}" class="text-indigo-600 hover:underline text-sm mb-4 inline-block">← Kembali ke daftar booking</a>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6">
                🎉 {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Booking</h1>
                    <p class="text-sm text-gray-500 mt-1">Kode: <span class="font-mono font-semibold text-indigo-600">{{ $booking->kode_booking }}</span></p>
                </div>
                <span class="self-start px-4 py-1.5 rounded-full text-sm font-semibold
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
            </div>

            {{-- Status Progress --}}
            <div class="mt-6">
                @php
                    $statuses = ['Pending', 'Menunggu Verifikasi', 'Dikonfirmasi', 'Berjalan', 'Selesai'];
                    $currentIdx = array_search($booking->status, $statuses);
                    if ($booking->status === 'Dibatalkan') $currentIdx = -1;
                    $currentIdx = $currentIdx !== false ? $currentIdx : 0;
                @endphp
                <div class="flex items-center gap-1">
                    @foreach($statuses as $i => $s)
                        <div class="flex-1 flex items-center">
                            <div class="flex flex-col items-center flex-1">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                                    {{ $i <= $currentIdx && $booking->status !== 'Dibatalkan' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                                    {{ $i + 1 }}
                                </div>
                                <span class="text-xs mt-1 text-center {{ $i <= $currentIdx && $booking->status !== 'Dibatalkan' ? 'text-indigo-600 font-medium' : 'text-gray-400' }}">
                                    {{ $s }}
                                </span>
                            </div>
                            @if($i < count($statuses) - 1)
                                <div class="h-0.5 flex-1 {{ $i < $currentIdx && $booking->status !== 'Dibatalkan' ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @if($booking->status === 'Dibatalkan')
                    <p class="text-center text-red-600 font-medium mt-3">❌ Booking ini telah dibatalkan</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Detail Pemesanan --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="font-semibold text-gray-900 mb-4">📝 Detail Pemesanan</h2>
                    <dl class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Tanggal Berangkat</dt>
                            <dd class="font-medium text-gray-900">{{ $booking->tanggal_berangkat->format('d M Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Tanggal Kembali</dt>
                            <dd class="font-medium text-gray-900">{{ $booking->tanggal_kembali->format('d M Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Tujuan</dt>
                            <dd class="font-medium text-gray-900">{{ $booking->tujuan }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Jumlah Hari</dt>
                            <dd class="font-medium text-gray-900">{{ $booking->jumlah_hari }} hari</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Total Harga</dt>
                            <dd class="font-bold text-indigo-600 text-lg">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Dibuat Pada</dt>
                            <dd class="font-medium text-gray-900">{{ $booking->created_at->format('d M Y H:i') }}</dd>
                        </div>
                    </dl>
                    @if($booking->catatan)
                        <div class="mt-4 pt-4 border-t">
                            <dt class="text-gray-500 text-sm">Catatan</dt>
                            <dd class="text-gray-700 mt-1">{{ $booking->catatan }}</dd>
                        </div>
                    @endif
                </div>

                {{-- Info Bus --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="font-semibold text-gray-900 mb-4">🚌 Bus yang Dipesan</h2>
                    @if($booking->bus)
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 bg-indigo-100 rounded-lg flex items-center justify-center text-2xl flex-shrink-0">🚌</div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $booking->bus->nama_bus }}</h3>
                                <p class="text-sm text-gray-500">{{ $booking->bus->kategori_bus }} · {{ $booking->bus->tipe_bus }} · {{ $booking->bus->kapasitas }} orang</p>
                                @if($booking->bus->facilities->isNotEmpty())
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach($booking->bus->facilities as $f)
                                            <span class="text-xs bg-gray-100 px-2 py-0.5 rounded">{{ $f->nama_fasilitas }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <p class="text-gray-400">Bus telah dihapus.</p>
                    @endif
                </div>
            </div>

            {{-- Sidebar: Pembayaran --}}
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="font-semibold text-gray-900 mb-4">💳 Pembayaran</h2>
                    @if($booking->payments->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($booking->payments as $payment)
                                <div class="border border-gray-200 rounded-lg p-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                            {{ $payment->jenis_pembayaran === 'DP' ? 'bg-orange-100 text-orange-700' : 'bg-purple-100 text-purple-700' }}">
                                            {{ $payment->jenis_pembayaran }}
                                        </span>
                                        <span class="text-xs px-2 py-0.5 rounded-full
                                            @switch($payment->status_verifikasi)
                                                @case('Disetujui') bg-green-100 text-green-700 @break
                                                @case('Ditolak') bg-red-100 text-red-700 @break
                                                @default bg-gray-100 text-gray-700
                                            @endswitch">
                                            {{ $payment->status_verifikasi }}
                                        </span>
                                    </div>
                                    <p class="font-semibold text-gray-900">Rp {{ number_format($payment->nominal, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $payment->tanggal_bayar->format('d M Y') }}</p>
                                    @if($payment->catatan)
                                        <p class="text-xs text-gray-500 mt-1">{{ $payment->catatan }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-400 text-sm">Belum ada pembayaran.</p>
                        </div>
                    @endif

                    {{-- Upload / Lihat Bukti Transfer --}}
                    @if($booking->status === 'Pending' || $booking->status === 'Menunggu Verifikasi')
                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ route('payment.create', $booking->kode_booking) }}"
                               class="block w-full text-center bg-indigo-600 text-white py-2.5 rounded-lg hover:bg-indigo-700 font-medium transition">
                                💳 Upload Pembayaran
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
