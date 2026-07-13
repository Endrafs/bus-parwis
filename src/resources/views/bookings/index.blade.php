<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Booking Saya — PHD Trans</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter+Tight:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @include('partials.public-header')

  <main id="main">
    <section class="snug">
      <div class="container container--narrow">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:var(--space-7);">
          <div>
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>Pemesanan</span>
            <h2 style="margin-top:var(--space-2);">Booking <span class="purple">Saya</span></h2>
          </div>
          <a href="{{ route('home') }}" class="btn btn--primary btn--sm">+ Pesan Baru</a>
        </div>

        @if(session('success'))
          <div style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);border-radius:var(--radius);padding:var(--space-4);margin-bottom:var(--space-5);">
            <p style="color:#34D399;font-weight:500;">✅ {{ session('success') }}</p>
          </div>
        @endif

        @if($bookings->isEmpty())
          <div style="text-align:center;padding:var(--space-9) 0;">
            <div style="font-size:4rem;margin-bottom:var(--space-5);">📭</div>
            <h3>Belum Ada Booking</h3>
            <p style="color:var(--fg-soft);margin-bottom:var(--space-5);">Anda belum melakukan pemesanan bus.</p>
            <a href="{{ route('home') }}" class="btn btn--primary">Lihat Armada Bus</a>
          </div>
        @else
          <div style="display:flex;flex-direction:column;gap:var(--space-4);">
            @foreach($bookings as $booking)
              <a href="{{ route('booking.show', $booking->kode_booking) }}"
                 style="display:block;background:var(--bg-card);border:1px solid var(--rule);border-radius:var(--radius-lg);padding:var(--space-5);transition:border-color var(--dur-fast);">
                <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:var(--space-4);">
                  <div style="display:flex;align-items:flex-start;gap:var(--space-4);">
                    <div style="width:48px;height:48px;background:rgba(124,58,237,0.15);border-radius:var(--radius);display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0;">🚌</div>
                    <div>
                      <h3 style="font-size:var(--text-lg);">{{ $booking->bus->nama_bus ?? 'Bus (dihapus)' }}</h3>
                      <p style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-xs);">{{ $booking->kode_booking }}</p>
                      <p style="color:var(--fg-soft);font-size:var(--text-sm);margin-top:var(--space-1);">📍 {{ $booking->tujuan }}</p>
                      <p style="color:var(--fg-soft);font-size:var(--text-sm);">📅 {{ $booking->tanggal_berangkat->format('d M Y') }} — {{ $booking->tanggal_kembali->format('d M Y') }} ({{ $booking->jumlah_hari }} hari)</p>
                    </div>
                  </div>
                  <div style="text-align:right;flex-shrink:0;">
                    <span class="badge
                      @switch($booking->status)
                        @case('Pending') badge--pending @break
                        @case('Menunggu Verifikasi') badge--waiting @break
                        @case('Dikonfirmasi') badge--confirmed @break
                        @case('Berjalan') badge--ongoing @break
                        @case('Selesai') badge--completed @break
                        @case('Dibatalkan') badge--cancelled @break
                        @default badge--pending
                      @endswitch">{{ $booking->status }}</span>
                    <div style="font-family:var(--font-display);font-size:var(--text-lg);color:var(--purple);margin-top:var(--space-2);">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </section>
  </main>

  @include('partials.public-footer')

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
  @include('partials.floating-contact')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
