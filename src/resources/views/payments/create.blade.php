<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Pembayaran — {{ $booking->kode_booking }} — Bus Parwis</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">🚌 Bus Parwis</a>
                <a href="{{ route('booking.show', $booking->kode_booking) }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm">← Kembali ke Booking</a>
            </div>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">💳 Upload Pembayaran</h1>
        <p class="text-gray-500 mb-6">Booking: <strong>{{ $booking->kode_booking }}</strong> — Total: <strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Info Rekening --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 mb-6">
            <h3 class="font-semibold text-blue-900 mb-2">🏦 Info Pembayaran</h3>
            <p class="text-sm text-blue-700">Silakan transfer ke rekening berikut:</p>
            <div class="mt-3 bg-white rounded-lg p-3">
                <p class="font-mono font-bold text-gray-900 whitespace-pre-line">{{ $websiteSettings->rekening_bank ?? 'BCA 1234567890' }}</p>
                @if($websiteSettings && $websiteSettings->nomor_whatsapp)
                <p class="text-sm text-gray-500 mt-1">WhatsApp: {{ $websiteSettings->nomor_whatsapp }}</p>
                @endif
            </div>
            <p class="text-xs text-blue-600 mt-3">Setelah transfer, upload bukti transfer di form bawah.</p>
        </div>

        <form method="POST" action="{{ route('payment.store', $booking->kode_booking) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            @csrf

            {{-- Jenis Pembayaran --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pembayaran *</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:border-indigo-400 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                        <input type="radio" name="jenis_pembayaran" value="DP" {{ old('jenis_pembayaran') === 'DP' ? 'checked' : '' }} class="sr-only" required>
                        <div>
                            <p class="font-semibold text-gray-900">DP</p>
                            <p class="text-xs text-gray-500">Uang Muka</p>
                        </div>
                    </label>
                    <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:border-indigo-400 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                        <input type="radio" name="jenis_pembayaran" value="Pelunasan" {{ old('jenis_pembayaran') === 'Pelunasan' ? 'checked' : '' }} class="sr-only" required>
                        <div>
                            <p class="font-semibold text-gray-900">Pelunasan</p>
                            <p class="text-xs text-gray-500">Lunas</p>
                        </div>
                    </label>
                </div>
                @error('jenis_pembayaran')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Nominal --}}
            <div class="mb-5">
                <label for="nominal" class="block text-sm font-medium text-gray-700 mb-1">Nominal Transfer *</label>
                <input type="number" name="nominal" id="nominal"
                       value="{{ old('nominal') }}"
                       placeholder="Masukkan jumlah yang ditransfer"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <p class="text-xs text-gray-400 mt-1">Total booking: Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                @error('nominal')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Tanggal Bayar --}}
            <div class="mb-5">
                <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transfer *</label>
                <input type="date" name="tanggal_bayar" id="tanggal_bayar"
                       value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                       max="{{ date('Y-m-d') }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('tanggal_bayar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Bukti Transfer --}}
            <div class="mb-5">
                <label for="bukti_transfer" class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Transfer *</label>
                <input type="file" name="bukti_transfer" id="bukti_transfer"
                       accept="image/jpeg,image/jpg,image/png"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="text-xs text-gray-400 mt-1">Format: JPG/PNG, maks. 2MB</p>
                @error('bukti_transfer')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Catatan --}}
            <div class="mb-5">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                <textarea name="catatan" id="catatan" rows="2"
                          placeholder="Info tambahan untuk admin..."
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('catatan') }}</textarea>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl hover:bg-indigo-700 font-semibold text-lg transition shadow-md">
                Submit Pembayaran
            </button>
        </form>
    </div>
</body>
</html>
