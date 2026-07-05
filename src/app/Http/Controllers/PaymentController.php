<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\WebsiteSetting;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Form upload bukti pembayaran.
     */
    public function create(string $kodeBooking): View
    {
        $booking = $this->findBookingSafely($kodeBooking);

        // Hanya bisa upload jika status Pending atau Menunggu Verifikasi
        // Atau jika DP sudah dibayar tapi belum lunas, tetap bisa upload pelunasan
        $canPay = in_array($booking->status, ['Pending', 'Menunggu Verifikasi'])
            || ($booking->dp_sudah_dibayar && !$booking->is_lunas && $booking->status !== 'Dibatalkan');

        if (! $canPay) {
            abort(403, 'Pembayaran tidak dapat dilakukan pada status booking saat ini.');
        }

        $websiteSettings = WebsiteSetting::first();

        return view('payments.create', compact('booking', 'websiteSettings'));
    }

    private function findBookingSafely(string $kodeBooking): Booking
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

        return Booking::select($columns)
            ->where('kode_booking', $kodeBooking)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    /**
     * Simpan pembayaran baru.
     */
    public function store(Request $request, string $kodeBooking): RedirectResponse
    {
        $booking = $this->findBookingSafely($kodeBooking);

        $canPay = in_array($booking->status, ['Pending', 'Menunggu Verifikasi'])
            || ($booking->dp_sudah_dibayar && !$booking->is_lunas && $booking->status !== 'Dibatalkan');

        if (! $canPay) {
            abort(403, 'Pembayaran tidak dapat dilakukan pada status booking saat ini.');
        }

        $validated = $request->validate([
            'jenis_pembayaran'  => ['required', 'in:DP,Pelunasan'],
            'nominal'           => ['required', 'numeric', 'min:1'],
            'bukti_transfer'    => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'tanggal_bayar'     => ['required', 'date', 'before_or_equal:today'],
            'catatan'           => ['nullable', 'string', 'max:500'],
        ], [
            'bukti_transfer.required' => 'Bukti transfer wajib diupload.',
            'bukti_transfer.image'    => 'File harus berupa gambar (JPG/PNG).',
            'bukti_transfer.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        // Validasi: nominal pelunasan tidak boleh melebihi sisa pembayaran
        if ($validated['jenis_pembayaran'] === 'Pelunasan') {
            $sisa = $booking->sisa_pembayaran;
            if ($validated['nominal'] > $sisa) {
                return back()
                    ->withErrors(['nominal' => "Nominal pelunasan tidak boleh melebihi sisa pembayaran (Rp " . number_format($sisa, 0, ',', '.') . ")."])
                    ->withInput();
            }
        }

        // Upload bukti transfer
        $path = $request->file('bukti_transfer')->store('bukti-transfer', 'public');

        // Simpan payment
        Payment::create([
            'booking_id'         => $booking->id,
            'jenis_pembayaran'   => $validated['jenis_pembayaran'],
            'nominal'            => $validated['nominal'],
            'bukti_transfer'     => $path,
            'status_verifikasi'  => 'Menunggu',
            'tanggal_bayar'      => $validated['tanggal_bayar'],
            'catatan'            => $validated['catatan'] ?? null,
        ]);

        // Update status booking ke "Menunggu Verifikasi" jika masih Pending
        if ($booking->status === 'Pending') {
            $booking->update(['status' => 'Menunggu Verifikasi']);
        }

        return redirect()->route('booking.show', $booking->kode_booking)
            ->with('success', 'Pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }
}
