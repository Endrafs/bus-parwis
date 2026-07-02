<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Form pemesanan — pilih bus, tanggal, tujuan.
     */
    public function create(Request $request): View
    {
        $bus = Bus::with('facilities')
            ->where('status', true)
            ->findOrFail($request->query('bus_id'));

        return view('bookings.create', compact('bus'));
    }

    /**
     * Simpan booking baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bus_id'             => ['required', 'exists:buses,id'],
            'tanggal_berangkat'  => ['required', 'date', 'after_or_equal:today'],
            'tanggal_kembali'    => ['required', 'date', 'after:tanggal_berangkat'],
            'tujuan'             => ['required', 'string', 'max:255'],
            'catatan'            => ['nullable', 'string', 'max:1000'],
        ], [
            'tanggal_berangkat.after_or_equal' => 'Tanggal berangkat minimal hari ini.',
            'tanggal_kembali.after'            => 'Tanggal kembali harus setelah tanggal berangkat.',
        ]);

        $bus = Bus::findOrFail($validated['bus_id']);

        // Pastikan bus aktif
        if (! $bus->status) {
            return back()->withErrors(['bus_id' => 'Bus ini sedang tidak tersedia.'])->withInput();
        }

        // Cek ketersediaan (double-booking prevention)
        if (! $bus->isAvailable($validated['tanggal_berangkat'], $validated['tanggal_kembali'])) {
            return back()->withErrors([
                'tanggal_berangkat' => 'Bus tidak tersedia pada tanggal yang dipilih. Silakan pilih tanggal lain.',
            ])->withInput();
        }

        // Hitung jumlah hari dan total harga
        $tanggalBerangkat = \Carbon\Carbon::parse($validated['tanggal_berangkat']);
        $tanggalKembali   = \Carbon\Carbon::parse($validated['tanggal_kembali']);
        $jumlahHari       = (int) $tanggalBerangkat->diffInDays($tanggalKembali) ?: 1;
        $totalHarga       = $jumlahHari * $bus->harga_sewa;

        $booking = Booking::create([
            'user_id'            => Auth::id(),
            'bus_id'             => $bus->id,
            'tanggal_berangkat'  => $validated['tanggal_berangkat'],
            'tanggal_kembali'    => $validated['tanggal_kembali'],
            'tujuan'             => $validated['tujuan'],
            'jumlah_hari'        => $jumlahHari,
            'total_harga'        => $totalHarga,
            'status'             => 'Pending',
            'catatan'            => $validated['catatan'] ?? null,
        ]);

        return redirect()->route('booking.show', $booking->kode_booking)
            ->with('success', 'Booking berhasil! Silakan lakukan pembayaran untuk konfirmasi.');
    }

    /**
     * Daftar booking milik pelanggan yang login.
     */
    public function index(): View
    {
        $bookings = Booking::with('bus')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Detail booking berdasarkan kode_booking.
     */
    public function show(string $kodeBooking): View
    {
        $booking = Booking::with(['bus.facilities', 'payments'])
            ->where('kode_booking', $kodeBooking)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('bookings.show', compact('booking'));
    }
}
