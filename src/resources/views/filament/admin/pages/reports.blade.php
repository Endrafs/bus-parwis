<x-filament::page>
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-2xl">💰</div>
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-xl font-bold text-gray-900">Rp {{ $totalPendapatan }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-2xl">📋</div>
                <div>
                    <p class="text-sm text-gray-500">Total Booking</p>
                    <p class="text-xl font-bold text-gray-900">{{ $totalBooking }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-2xl">🚌</div>
                <div>
                    <p class="text-sm text-gray-500">Armada Aktif</p>
                    <p class="text-xl font-bold text-gray-900">{{ $totalBus }} Bus</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Pendapatan per Bulan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">📅 Pendapatan Bulanan — {{ date('Y') }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Transaksi</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php $grandTotal = 0; @endphp
                    @foreach($revenueData as $row)
                        @php $grandTotal += $row['total']; @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $row['bulan'] }}</td>
                            <td class="px-6 py-3 text-right text-gray-700">{{ $row['jumlah'] }}</td>
                            <td class="px-6 py-3 text-right font-semibold {{ $row['total'] > 0 ? 'text-green-700' : 'text-gray-400' }}">
                                Rp {{ number_format($row['total'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-indigo-50">
                    <tr>
                        <td class="px-6 py-3 font-bold text-gray-900">TOTAL</td>
                        <td class="px-6 py-3 text-right font-bold text-gray-900">
                            {{ collect($revenueData)->sum('jumlah') }}
                        </td>
                        <td class="px-6 py-3 text-right font-bold text-indigo-700">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Statistik Armada --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">🚌 Statistik Armada Bus</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Bus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Kapasitas</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total Booking</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pendapatan</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($busStats as $bus)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $bus['nama'] }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $bus['kategori'] }}</td>
                            <td class="px-6 py-3 text-center text-gray-700">{{ $bus['kapasitas'] }}</td>
                            <td class="px-6 py-3 text-center">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $bus['total_booking'] > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $bus['total_booking'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-right font-semibold {{ $bus['total_pendapatan'] !== '0' ? 'text-green-700' : 'text-gray-400' }}">
                                Rp {{ $bus['total_pendapatan'] }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $bus['status'] === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $bus['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-filament::page>
