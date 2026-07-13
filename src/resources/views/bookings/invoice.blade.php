<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Invoice {{ $booking->kode_booking }} — PHD Trans</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter+Tight:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @include('partials.public-header')
  @include('partials.floating-contact')

  <main id="main">
    <section class="snug">
      <div class="container container--narrow">

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:var(--space-6);">
          <a href="{{ route('booking.show', $booking->kode_booking) }}" style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-sm);display:inline-flex;align-items:center;gap:var(--space-2);">
            <svg width="14" height="10" viewBox="0 0 14 10" fill="none" style="transform:rotate(180deg);"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Kembali
          </a>
          <button onclick="window.print()" class="btn btn--primary btn--sm" style="font-size:var(--text-sm);">
            🖨️ Cetak Invoice
          </button>
        </div>

        <!-- Invoice Card -->
        <div class="invoice-page glass" style="padding:var(--space-7);">



          <!-- Invoice Header -->
          <div class="invoice-header" style="display:flex;justify-content:space-between;align-items:flex-start;border-bottom:2px solid var(--rule);padding-bottom:var(--space-5);margin-bottom:var(--space-6);">
            <div>
              <span class="brand" style="font-size:var(--text-xl);"><img src="{{ asset('images/logo_phd1.png') }}" alt="PHD Trans" class="brand-logo" style="height:1.5rem;" /></span>
              <p style="color:var(--fg-soft);font-size:var(--text-sm);margin-top:var(--space-1);">Invoice Pembayaran Sewa Bus</p>
            </div>
            <div style="text-align:right;">
              <div class="invoice-title" style="font-family:var(--font-display);font-size:var(--text-2xl);font-weight:700;color:var(--purple);">INVOICE</div>
              <p style="font-family:var(--font-mono);font-size:var(--text-sm);color:var(--fg-soft);">#{{ $booking->kode_booking }}</p>
              <p style="font-size:var(--text-xs);color:var(--fg-mute);">Tanggal: {{ now()->format('d/m/Y') }}</p>
            </div>
          </div>

          <!-- Customer & Booking Info -->
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-6);margin-bottom:var(--space-6);">
            <div>
              <span class="label">Pelanggan</span>
              <p style="font-weight:600;margin-top:var(--space-1);">{{ $booking->user->name ?? '—' }}</p>
              <p style="color:var(--fg-soft);font-size:var(--text-sm);">{{ $booking->user->email ?? '—' }}</p>
            </div>
            <div>
              <span class="label">Detail Booking</span>
              <p style="margin-top:var(--space-1);">
                <span style="font-family:var(--font-mono);font-size:var(--text-sm);">
                  {{ $booking->bus->nama_bus ?? 'Bus telah dihapus' }}
                </span>
                @if($booking->bus)
                  <span style="color:var(--fg-mute);font-size:var(--text-xs);display:block;">{{ $booking->bus->nopol ?? '' }}</span>
                @endif
              </p>
              <p style="color:var(--fg-soft);font-size:var(--text-sm);">
                {{ \Carbon\Carbon::parse($booking->tanggal_berangkat)->format('d M Y') }}
                →
                {{ \Carbon\Carbon::parse($booking->tanggal_kembali)->format('d M Y') }}
                ({{ $booking->jumlah_hari }} hari)
              </p>
              <p style="color:var(--fg-soft);font-size:var(--text-sm);">Tujuan: <strong>{{ $booking->tujuan }}</strong></p>
            </div>
          </div>

          <!-- Price Breakdown -->
          <div style="margin-bottom:var(--space-6);">
            <span class="label">Rincian Biaya</span>
            <table style="width:100%;margin-top:var(--space-3);border-collapse:collapse;">
              <thead>
                <tr style="border-bottom:1px solid var(--rule);">
                  <th style="text-align:left;padding:var(--space-2) 0;font-family:var(--font-mono);font-size:var(--text-xs);letter-spacing:0.06em;color:var(--fg-mute);">Item</th>
                  <th style="text-align:right;padding:var(--space-2) 0;font-family:var(--font-mono);font-size:var(--text-xs);letter-spacing:0.06em;color:var(--fg-mute);">Jumlah</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $breakdown = [
                    'Sewa Unit (' . $booking->jumlah_hari . ' hari)' => ($booking->harga_sewa_unit ?? 0) * $booking->jumlah_hari,
                  ];
                  if (($booking->biaya_tol ?? 0) > 0) $breakdown['Biaya Tol'] = $booking->biaya_tol;
                  if (($booking->biaya_solar ?? 0) > 0) $breakdown['Biaya Solar'] = $booking->biaya_solar;
                  if (($booking->tips_crew ?? 0) > 0) $breakdown['Tips Crew Bus'] = $booking->tips_crew;
                  if (($booking->biaya_parkir ?? 0) > 0) $breakdown['Biaya Parkir'] = $booking->biaya_parkir;
                  if (($booking->biaya_tujuan ?? 0) > 0) $breakdown['Biaya Tujuan (' . $booking->tujuan . ')'] = $booking->biaya_tujuan;
                @endphp
                @foreach($breakdown as $item => $amount)
                <tr style="border-bottom:1px solid var(--rule);">
                  <td style="padding:var(--space-2) 0;font-size:var(--text-sm);">{{ $item }}</td>
                  <td style="text-align:right;padding:var(--space-2) 0;font-family:var(--font-mono);font-size:var(--text-sm);">Rp {{ number_format($amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr style="border-top:2px solid var(--fg);">
                  <td style="padding:var(--space-3) 0;font-weight:700;font-size:var(--text-base);">Total</td>
                  <td style="text-align:right;padding:var(--space-3) 0;font-family:var(--font-display);font-weight:700;color:var(--purple);font-size:var(--text-lg);">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                </tr>
              </tbody>
            </table>
          <!-- Payment History -->
          <div style="margin-bottom:var(--space-6);">
            <span class="label">Riwayat Pembayaran</span>
            <div style="margin-top:var(--space-3);">
              @forelse($booking->payments->where('status_verifikasi', 'Disetujui') as $payment)
              <div style="display:flex;justify-content:space-between;align-items:center;padding:var(--space-3) 0;border-bottom:1px solid var(--rule);">
                <div>
                  <p style="font-weight:600;font-size:var(--text-sm);">
                    {{ $payment->jenis_pembayaran === 'DP' ? 'Pembayaran DP' : 'Pembayaran Pelunasan' }}
                    <span class="badge badge--confirmed" style="font-size:var(--text-xs);margin-left:var(--space-2);">LUNAS</span>
                  </p>
                  <p style="color:var(--fg-mute);font-size:var(--text-xs);">
                    {{ $payment->tanggal_bayar ? \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d M Y') : '-' }}
                    · {{ $payment->catatan ?: 'Tidak ada catatan' }}
                  </p>
                </div>
                <div style="text-align:right;">
                  <span style="font-family:var(--font-mono);font-weight:600;color:#34D399;">Rp {{ number_format($payment->nominal, 0, ',', '.') }}</span>
                </div>
              </div>
              @empty
              <p style="color:var(--fg-mute);font-size:var(--text-sm);">Belum ada pembayaran tervalidasi.</p>
              @endforelse
            </div>
          </div>

          <!-- Total Dibayar & Status -->
          <div style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.3);border-radius:var(--radius);padding:var(--space-4);display:flex;justify-content:space-between;align-items:center;">
            <div>
              <span class="label" style="color:#34D399;">Status Pembayaran</span>
              <p style="font-weight:700;color:#34D399;font-size:var(--text-lg);">✅ LUNAS</p>
            </div>
            <div style="text-align:right;">
              <span class="label">Total Dibayar</span>
              <p style="font-family:var(--font-display);font-weight:700;color:#34D399;font-size:var(--text-xl);">Rp {{ number_format($booking->total_dibayar, 0, ',', '.') }}</p>
            </div>
          </div>

          <!-- Footer Note -->
          <div style="margin-top:var(--space-7);padding-top:var(--space-4);border-top:1px solid var(--rule);text-align:center;">
            <p style="color:var(--fg-mute);font-size:var(--text-xs);">
              Terima kasih telah menggunakan layanan PHD Trans.<br>
              Untuk pertanyaan lebih lanjut, hubungi kami via WhatsApp.
            </p>
          </div>

        </div> <!-- /invoice-page -->

      </div>
    </section>
  </main>

  @include('partials.public-footer')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggle = document.querySelector('.nav-toggle');
      const drawer = document.getElementById('mobile-drawer');
      const closeBtn = document.querySelector('.drawer-close');
      if (toggle && drawer) {
        toggle.addEventListener('click', function() {
          const expanded = toggle.getAttribute('aria-expanded') === 'true';
          toggle.setAttribute('aria-expanded', !expanded);
          drawer.setAttribute('aria-hidden', expanded);
          document.body.style.overflow = expanded ? '' : 'hidden';
        });
        if (closeBtn) {
          closeBtn.addEventListener('click', function() {
            toggle.setAttribute('aria-expanded', 'false');
            drawer.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
          });
        }
        document.addEventListener('keydown', function(e) {
          if (e.key === 'Escape' && drawer.getAttribute('aria-hidden') === 'false') {
            toggle.setAttribute('aria-expanded', 'false');
            drawer.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
          }
        });
      }
    });
  </script>
</body>
</html>
          </div>
