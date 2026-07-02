<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Selamat datang, {{ Auth::user()->name }}!</h3>
                    <p class="mb-6 text-gray-600">Kelola pemesanan bus pariwisata Anda di sini.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('home') }}" class="block p-6 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition border border-indigo-200">
                            <div class="text-3xl mb-2">🚌</div>
                            <h4 class="font-semibold text-indigo-900">Lihat Armada Bus</h4>
                            <p class="text-sm text-indigo-600 mt-1">Jelajahi armada bus yang tersedia untuk disewa.</p>
                        </a>
                        
                        <a href="{{ route('booking.index') }}" class="block p-6 bg-green-50 rounded-xl hover:bg-green-100 transition border border-green-200">
                            <div class="text-3xl mb-2">📋</div>
                            <h4 class="font-semibold text-green-900">Booking Saya</h4>
                            <p class="text-sm text-green-600 mt-1">Lihat riwayat dan status pemesanan Anda.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
