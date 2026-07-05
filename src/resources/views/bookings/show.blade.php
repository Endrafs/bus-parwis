<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Booking {{ $booking->kode_booking }} — PHD Trans</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Boldonse&family=Inter+Tight:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @include('partials.public-header')

  <main id="main">
    <section class="snug">
      <div class="container container--narrow">
        <a href="{{ route('booking.index') }}" style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-sm);display:inline-flex;align-items:center;gap:var(--space-2);margin-bottom:var(--space-6);">
          <svg width="14" height="10" viewBox="0 0 14 10" fill="none" style="transform:rotate(180deg);"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Kembali
        </a>

        @if(session('success'))
          <div style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);border-radius:var(--radius);padding:var(--space-4);margin-bottom:var(--space-5);">🎉 {{ session('success') }}</div>
        @endif

        <!-- Header -->
        <div style="background:var(--bg-card);border:1px solid var(--rule);border-radius:var(--radius-lg);padding:var(--space-6);margin-bottom:var(--space-6);">
          <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:var(--space-4);">
            <div>
              <span class="eyebrow"><span class="dot" aria-hidden="true"></span>Detail Booking</span>
              <h2 style="margin-top:var(--space-2);">
                <span class="purple" style="font-family:var(--font-mono);font-size:var(--text-base);background:rgba(124,58,237,0.15);padding:2px 12px;border-radius:var(--radius-full);">{{ $booking->kode_booking }}</span>
              </h2>
            </div>
            <span class="badge
              @switch($booking->status)
                @case('Pending') badge--pending @break
                @case('Menunggu Verifikasi') badge--waiting @break
                @case('Dikonfirmasi') badge--confirmed @break
                @case('Berjalan') badge--ongoing @break
                @case('Selesai') badge--completed @break
                @case('Dibatalkan') badge--cancelled @break
                @default badge--pending
              @endswitch" style="font-size:var(--text-sm);">{{ $booking->status }}</span>
          </div>

          <!-- Progress -->
          @php
            $statuses = ['Pending', 'Menunggu Verifikasi', 'Dikonfirmasi', 'Berjalan', 'Selesai'];
            $currentIdx = array_search($booking->status, $statuses);
            if ($booking->status === 'Dibatalkan') $currentIdx = -1;
            $currentIdx = $currentIdx !== false ? $currentIdx : -1;
          @endphp
          @if($currentIdx >= 0)
            <div class="progress-track">
              @foreach($statuses as $i => $s)
                <div class="progress-step {{ $i < $currentIdx ? 'progress-step--done' : ($i === $currentIdx ? 'progress-step--active' : '') }}">
                  <span class="ps-dot"></span>
                  <span>{{ $s }}</span>
                </div>
                @if(!$loop->last)
                  <div class="progress-line {{ $i < $currentIdx ? 'progress-line--fill' : '' }}"></div>
                @endif
              @endforeach
            </div>
          @else
            <div style="margin-top:var(--space-4);">
              <span class="badge badge--cancelled">Booking Dibatalkan</span>
            </div>
          @endif
        </div>

        <!-- Content Grid -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-6);">
          <!-- Booking Details -->
          <div class="glass liquid-glow" style="padding:var(--space-6);">
            <h3 style="font-size:var(--text-lg);margin-bottom:var(--space-4);">📋 Detail Pemesanan</h3>
            <div style="display:flex;flex-direction:column;gap:var(--space-3);">
              <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-xs);">BUS</span>
                <span style="font-weight:500;">{{ $booking->bus->nama_bus ?? 'Bus telah dihapus' }}</span>
              </div>
              <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-xs);">TUJUAN</span>
                <span>{{ $booking->tujuan }}</span>
              </div>
              <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-xs);">BERANGKAT</span>
                <span>{{ $booking->tanggal_berangkat->format('d M Y') }}</span>
              </div>
              <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-xs);">KEMBALI</span>
                <span>{{ $booking->tanggal_kembali->format('d M Y') }}</span>
              </div>
              <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-xs);">DURASI</span>
                <span>{{ $booking->jumlah_hari }} hari</span>
              </div>

              <!-- Price Breakdown -->
              <div style="border-top:1px solid var(--rule);padding-top:var(--space-3);margin-top:var(--space-2);">
                <span style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-xs);display:block;margin-bottom:var(--space-2);">RINCIAN BIAYA</span>
                <div style="display:flex;flex-direction:column;gap:var(--space-1);font-size:var(--text-sm);">
                  <div style="display:flex;justify-content:space-between;">
                    <span style="color:var(--fg-soft);">Harga Sewa Unit ({{ $booking->jumlah_hari }} hari)</span>
                    <span>Rp {{ number_format(($booking->harga_sewa_unit ?? 0) * $booking->jumlah_hari, 0, ',', '.') }}</span>
                  </div>
                  @if(($booking->biaya_tol ?? 0) > 0)
                  <div style="display:flex;justify-content:space-between;">
                    <span style="color:var(--fg-soft);">Biaya Tol</span>
                    <span>Rp {{ number_format($booking->biaya_tol, 0, ',', '.') }}</span>
                  </div>
                  @endif
                  @if(($booking->biaya_solar ?? 0) > 0)
                  <div style="display:flex;justify-content:space-between;">
                    <span style="color:var(--fg-soft);">Biaya Solar</span>
                    <span>Rp {{ number_format($booking->biaya_solar, 0, ',', '.') }}</span>
                  </div>
                  @endif
                  @if(($booking->tips_crew ?? 0) > 0)
                  <div style="display:flex;justify-content:space-between;">
                    <span style="color:var(--fg-soft);">Tips Crew Bus</span>
                    <span>Rp {{ number_format($booking->tips_crew, 0, ',', '.') }}</span>
                  </div>
                  @endif
                  @if(($booking->biaya_parkir ?? 0) > 0)
                  <div style="display:flex;justify-content:space-between;">
                    <span style="color:var(--fg-soft);">Biaya Parkir</span>
                    <span>Rp {{ number_format($booking->biaya_parkir, 0, ',', '.') }}</span>
                  </div>
                  @endif
                  @if(($booking->biaya_tujuan ?? 0) > 0)
                  <div style="display:flex;justify-content:space-between;">
                    <span style="color:var(--fg-soft);">Biaya Tujuan ({{ $booking->tujuan }})</span>
                    <span>Rp {{ number_format($booking->biaya_tujuan, 0, ',', '.') }}</span>
                  </div>
                  @endif
                  <div style="display:flex;justify-content:space-between;border-top:1px solid var(--rule);padding-top:var(--space-2);font-weight:600;color:var(--purple);">
                    <span>Total</span>
                    <span>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                  </div>
                </div>
              </div>
              @if($booking->catatan)
                <div style="border-top:1px solid var(--rule);padding-top:var(--space-3);margin-top:var(--space-2);">
                  <span style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-xs);">CATATAN</span>
                  <p style="color:var(--fg-soft);font-size:var(--text-sm);margin-top:var(--space-1);">{{ $booking->catatan }}</p>
                </div>
              @endif
            </div>

            @if($booking->bus && $booking->bus->facilities->isNotEmpty())
              <div style="border-top:1px solid var(--rule);padding-top:var(--space-4);margin-top:var(--space-4);">
                <span class="label">Fasilitas Bus</span>
                <div style="display:flex;flex-wrap:wrap;gap:var(--space-2);margin-top:var(--space-2);">
                  @foreach($booking->bus->facilities as $f)
                    <span style="background:var(--ink-000);border:1px solid var(--rule);border-radius:var(--radius-full);padding:2px 10px;font-family:var(--font-mono);font-size:var(--text-xs);color:var(--fg-mute);">{{ $f->nama_fasilitas }}</span>
                  @endforeach
                </div>
              </div>
            @endif
          </div>

          <!-- Payment -->
          <div class="glass-purple liquid-glow" style="padding:var(--space-6);">
            <h3 style="font-size:var(--text-lg);margin-bottom:var(--space-4);">💳 Pembayaran</h3>

            @if($booking->payments->isNotEmpty())
              <div style="display:flex;flex-direction:column;gap:var(--space-3);margin-bottom:var(--space-4);">
                @foreach($booking->payments as $payment)
                  <div style="border:1px solid var(--rule);border-radius:var(--radius);padding:var(--space-3);">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:var(--space-1);">
                      <span class="badge {{ $payment->jenis_pembayaran === 'DP' ? 'badge--pending' : 'badge--waiting' }}">{{ $payment->jenis_pembayaran }}</span>
                      <span class="badge
                        @switch($payment->status_verifikasi)
                          @case('Disetujui') badge--confirmed @break
                          @case('Ditolak') badge--cancelled @break
                          @default badge--pending
                        @endswitch">{{ $payment->status_verifikasi ?? 'Menunggu' }}</span>
                    </div>
                    <p style="font-weight:600;">Rp {{ number_format($payment->nominal, 0, ',', '.') }}</p>
                    <p style="color:var(--fg-mute);font-size:var(--text-xs);">{{ $payment->tanggal_bayar->format('d M Y') }}</p>
                  </div>
                @endforeach
              </div>

              <!-- Payment Summary -->
              <div style="background:var(--ink-000);border-radius:var(--radius);padding:var(--space-3);margin-bottom:var(--space-4);">
                <div style="display:flex;justify-content:space-between;font-size:var(--text-sm);">
                  <span style="color:var(--fg-soft);">Total Dibayar (Disetujui)</span>
                  <span style="font-weight:600;color:var(--purple);">Rp {{ number_format($booking->total_dibayar, 0, ',', '.') }}</span>
                </div>
                @if(!$booking->is_lunas)
                  <div style="display:flex;justify-content:space-between;font-size:var(--text-sm);margin-top:var(--space-1);">
                    <span style="color:var(--fg-soft);">Sisa Pembayaran</span>
                    <span style="font-weight:600;color:#F87171;">Rp {{ number_format($booking->sisa_pembayaran, 0, ',', '.') }}</span>
                  </div>
                @else
                  <div style="display:flex;justify-content:space-between;font-size:var(--text-sm);margin-top:var(--space-1);">
                    <span style="color:var(--fg-soft);">Status</span>
                    <span style="font-weight:600;color:#34D399;">✅ LUNAS</span>
                  </div>
                @endif
              </div>
            @else
              <div style="text-align:center;padding:var(--space-5) 0;">
                <p style="color:var(--fg-mute);">Belum ada pembayaran.</p>
              </div>
            @endif

            @if($booking->is_lunas)
              <div style="margin-top:var(--space-4);padding-top:var(--space-4);border-top:1px solid var(--rule);">
                <a href="{{ route('booking.invoice', $booking->kode_booking) }}" class="btn btn--primary" style="width:100%;justify-content:center;">
                  📄 Lihat Invoice
                </a>
              </div>
            @elseif($booking->status === 'Pending' || $booking->status === 'Menunggu Verifikasi' || ($booking->dp_sudah_dibayar && !$booking->is_lunas))
              <div style="margin-top:var(--space-4);padding-top:var(--space-4);border-top:1px solid var(--rule);">
                <a href="{{ route('payment.create', $booking->kode_booking) }}" class="btn btn--primary" style="width:100%;justify-content:center;">
                  @if($booking->dp_sudah_dibayar && !$booking->is_lunas)
                    💳 Bayar Pelunasan (Rp {{ number_format($booking->sisa_pembayaran, 0, ',', '.') }})
                  @else
                    💳 Upload Pembayaran
                  @endif
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  </main>

  @include('partials.public-footer')
  @include('partials.floating-contact')
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
