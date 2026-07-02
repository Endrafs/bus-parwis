<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesan {{ $bus->nama_bus }} — Bus Parwis</title>
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

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ route('bus.show', $bus) }}" class="text-indigo-600 hover:underline text-sm mb-4 inline-block">← Kembali ke detail bus</a>

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Form Pemesanan</h1>
        <p class="text-gray-500 mb-8">Isi form berikut untuk memesan <strong>{{ $bus->nama_bus }}</strong></p>

        {{-- Bus Summary --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-indigo-100 rounded-lg flex items-center justify-center text-2xl">🚌</div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $bus->nama_bus }}</h3>
                    <p class="text-sm text-gray-500">{{ $bus->kategori_bus }} · {{ $bus->tipe_bus }} · {{ $bus->kapasitas }} orang</p>
                    <p class="text-sm font-semibold text-indigo-600 mt-0.5">Rp {{ number_format($bus->harga_sewa, 0, ',', '.') }} / hari</p>
                </div>
            </div>
        </div>

        {{-- Booking Form --}}
        <form method="POST" action="{{ route('booking.store') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-data="bookingForm({{ $bus->harga_sewa }})">
            @csrf
            <input type="hidden" name="bus_id" value="{{ $bus->id }}">

            {{-- Tanggal Berangkat --}}
            <div class="mb-5">
                <label for="tanggal_berangkat" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berangkat *</label>
                <input type="date" name="tanggal_berangkat" id="tanggal_berangkat"
                       x-model="tanggalBerangkat" @change="hitung"
                       min="{{ date('Y-m-d') }}"
                       value="{{ old('tanggal_berangkat') }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('tanggal_berangkat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Kembali --}}
            <div class="mb-5">
                <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali *</label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                       x-model="tanggalKembali" @change="hitung"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       value="{{ old('tanggal_kembali') }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('tanggal_kembali')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tujuan --}}
            <div class="mb-5">
                <label for="tujuan" class="block text-sm font-medium text-gray-700 mb-1">Tujuan *</label>
                <input type="text" name="tujuan" id="tujuan"
                       placeholder="Contoh: Bandung, Bali, Yogyakarta"
                       value="{{ old('tujuan') }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('tujuan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Catatan --}}
            <div class="mb-5">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                <textarea name="catatan" id="catatan" rows="3"
                          placeholder="Tambahan informasi untuk admin..."
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Ringkasan Harga --}}
            <div class="bg-indigo-50 rounded-xl p-5 mb-6" x-show="jumlahHari > 0" x-cloak>
                <h3 class="font-semibold text-gray-900 mb-3">💵 Ringkasan Biaya</h3>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Harga sewa per hari</span>
                    <span>Rp {{ number_format($bus->harga_sewa, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Jumlah hari</span>
                    <span x-text="jumlahHari + ' hari'"></span>
                </div>
                <div class="flex justify-between font-bold text-lg border-t border-indigo-200 pt-2 mt-2">
                    <span>Total</span>
                    <span class="text-indigo-700" x-text="formatRupiah(totalHarga)"></span>
                </div>
            </div>

            {{-- Error bus_id --}}
            @error('bus_id')
                <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
            @enderror

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-xl hover:bg-indigo-700 font-semibold text-lg transition shadow-md">
                Buat Pesanan
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('bookingForm', (hargaPerHari) => ({
                tanggalBerangkat: '{{ old('tanggal_berangkat') }}',
                tanggalKembali: '{{ old('tanggal_kembali') }}',
                jumlahHari: 0,
                totalHarga: 0,
                hitung() {
                    if (this.tanggalBerangkat && this.tanggalKembali) {
                        const start = new Date(this.tanggalBerangkat);
                        const end = new Date(this.tanggalKembali);
                        const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                        this.jumlahHari = diff > 0 ? diff : 0;
                        this.totalHarga = this.jumlahHari * hargaPerHari;
                    } else {
                        this.jumlahHari = 0;
                        this.totalHarga = 0;
                    }
                },
                formatRupiah(num) {
                    return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
            }));
        });
    </script>
</body>
</html>
