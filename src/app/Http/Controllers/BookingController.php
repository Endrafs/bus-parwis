<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\DestinationPrice;
use App\Models\WebsiteSetting;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $destinationPrices = DestinationPrice::orderBy('nama_tujuan')->get();

        return view('bookings.create', compact('bus', 'destinationPrices'));
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

        // Hitung jumlah hari dan total harga dengan komponen biaya
        $tanggalBerangkat = \Carbon\Carbon::parse($validated['tanggal_berangkat']);
        $tanggalKembali   = \Carbon\Carbon::parse($validated['tanggal_kembali']);
        $jumlahHari       = (int) $tanggalBerangkat->diffInDays($tanggalKembali) ?: 1;

        // Ambil default biaya dari WebsiteSettings
        $settings = WebsiteSetting::first();

        // Ambil biaya tujuan berdasarkan destinasi yang dipilih
        $destinationPrice = DestinationPrice::where('nama_tujuan', 'like', $validated['tujuan'])->first();
        $biayaTujuan = $destinationPrice ? (float) $destinationPrice->harga : 0;

        $hargaSewaUnit = (float) $bus->harga_sewa;
        $biayaTol      = $settings ? (float) $settings->biaya_tol_default : 0;
        $biayaSolar    = $settings ? (float) $settings->biaya_solar_default : 0;
        $tipsCrew      = $settings ? (float) $settings->tips_crew_default : 0;
        $biayaParkir   = $settings ? (float) $settings->biaya_parkir_default : 0;

        $totalHarga = Booking::hitungTotalHarga(
            $hargaSewaUnit,
            $jumlahHari,
            $biayaTol,
            $biayaSolar,
            $tipsCrew,
            $biayaParkir,
            $biayaTujuan
        );

        $booking = Booking::create([
            'user_id'            => Auth::id(),
            'bus_id'             => $bus->id,
            'tanggal_berangkat'  => $validated['tanggal_berangkat'],
            'tanggal_kembali'    => $validated['tanggal_kembali'],
            'tujuan'             => $validated['tujuan'],
            'jumlah_hari'        => $jumlahHari,
            'total_harga'        => $totalHarga,
            'harga_sewa_unit'    => $hargaSewaUnit,
            'biaya_tol'          => $biayaTol,
            'biaya_solar'        => $biayaSolar,
            'tips_crew'          => $tipsCrew,
            'biaya_parkir'       => $biayaParkir,
            'biaya_tujuan'       => $biayaTujuan,
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
        $basicColumns = [
            'id', 'user_id', 'bus_id', 'kode_booking',
            'tanggal_berangkat', 'tanggal_kembali', 'tujuan',
            'jumlah_hari', 'total_harga', 'status', 'catatan',
            'created_at', 'updated_at',
        ];

        // Cek apakah kolom biaya baru sudah ada di database
        try {
            DB::select('SELECT harga_sewa_unit FROM bookings LIMIT 1');
            $columns = array_merge($basicColumns, [
                'harga_sewa_unit', 'biaya_tol', 'biaya_solar',
                'tips_crew', 'biaya_parkir', 'biaya_tujuan',
            ]);
        } catch (QueryException $e) {
            // Kolom belum ada (migrasi belum dijalankan), gunakan kolom dasar saja
            $columns = $basicColumns;
        }

        try {
            $booking = Booking::select($columns)
                ->with(['bus.facilities', 'payments'])
                ->where('kode_booking', $kodeBooking)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        } catch (QueryException $e) {
            abort(404, 'Data booking tidak ditemukan atau struktur tabel belum diperbarui. Silakan jalankan migration terlebih dahulu.');
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Invoice booking yang sudah lunas.
     */
    public function invoice(string $kodeBooking): View
    {
        $basicColumns = [
            'id', 'user_id', 'bus_id', 'kode_booking',
            'tanggal_berangkat', 'tanggal_kembali', 'tujuan',
            'jumlah_hari', 'total_harga', 'status', 'catatan',
            'created_at', 'updated_at',
        ];

        try {
            DB::select('SELECT harga_sewa_unit FROM bookings LIMIT 1');
            $columns = array_merge($basicColumns, [
                'harga_sewa_unit', 'biaya_tol', 'biaya_solar',
                'tips_crew', 'biaya_parkir', 'biaya_tujuan',
            ]);
        } catch (QueryException $e) {
            $columns = $basicColumns;
        }

        $booking = Booking::select($columns)
            ->with(['bus.facilities', 'payments', 'user'])
            ->where('kode_booking', $kodeBooking)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (! $booking->is_lunas) {
            abort(403, 'Invoice hanya tersedia untuk booking yang sudah lunas.');
        }

        return view('bookings.invoice', compact('booking'));
    }

}
