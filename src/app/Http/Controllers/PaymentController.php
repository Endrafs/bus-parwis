<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\WebsiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Form upload bukti pembayaran.
     */
    public function create(string $kodeBooking): View
    {
        $booking = Booking::where('kode_booking', $kodeBooking)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Hanya bisa upload jika status Pending atau Menunggu Verifikasi
        if (! in_array($booking->status, ['Pending', 'Menunggu Verifikasi'])) {
            abort(403, 'Pembayaran tidak dapat dilakukan pada status booking saat ini.');
        }

        $websiteSettings = WebsiteSetting::first();

        return view('payments.create', compact('booking', 'websiteSettings'));
    }

    /**
     * Simpan pembayaran baru.
     */
    public function store(Request $request, string $kodeBooking): RedirectResponse
    {
        $booking = Booking::where('kode_booking', $kodeBooking)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (! in_array($booking->status, ['Pending', 'Menunggu Verifikasi'])) {
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

        // Update status booking ke "Menunggu Verifikasi"
        if ($booking->status === 'Pending') {
            $booking->update(['status' => 'Menunggu Verifikasi']);
        }

        return redirect()->route('booking.show', $booking->kode_booking)
            ->with('success', 'Pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }
}
