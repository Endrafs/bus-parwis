<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $bus->nama_bus }} — PHD Trans</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Boldonse&family=Inter+Tight:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @include('partials.public-header')

  <main id="main">
    <section class="snug">
      <div class="container container--wide">
        <a href="{{ route('home') }}" style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-sm);display:inline-flex;align-items:center;gap:var(--space-2);margin-bottom:var(--space-6);">
          <svg width="14" height="10" viewBox="0 0 14 10" fill="none" style="transform:rotate(180deg);"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Kembali ke Armada
        </a>

        <div class="split">
          <div class="split-media" style="aspect-ratio:4/3;">
            @if($bus->foto)
              <img src="{{ asset('storage/' . $bus->foto) }}" alt="{{ $bus->nama_bus }}" />
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);display:flex;align-items:center;justify-content:center;">
                <span style="font-size:6rem;opacity:0.3;">🚌</span>
              </div>
            @endif
          </div>
          <div class="split-text">
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>{{ $bus->kategori_bus }}</span>
            <h1 style="margin-top:var(--space-3);">{{ $bus->nama_bus }}</h1>
            <div style="display:flex;gap:var(--space-3);margin-block:var(--space-4);">
              <span class="badge badge--confirmed">🪑 {{ $bus->kapasitas }} Kursi</span>
              <span class="badge badge--waiting">🏷️ {{ $bus->tipe_bus }}</span>
            </div>
            <p class="lede" style="margin-block:var(--space-4);">
              @if($bus->deskripsi)
                {{ $bus->deskripsi }}
              @else
                Bus {{ $bus->kategori_bus }} dengan kapasitas {{ $bus->kapasitas }} orang, tipe {{ $bus->tipe_bus }}. Cocok untuk perjalanan wisata, study tour, dan acara keluarga.
              @endif
            </p>

            @if($bus->facilities->isNotEmpty())
              <div style="margin-top:var(--space-4);">
                <span class="label">Fasilitas</span>
                <div style="display:flex;flex-wrap:wrap;gap:var(--space-2);margin-top:var(--space-3);">
                  @foreach($bus->facilities as $facility)
                    <span style="background:var(--bg-card);border:1px solid var(--rule);border-radius:var(--radius-full);padding:4px 14px;font-family:var(--font-mono);font-size:var(--text-xs);letter-spacing:0.06em;color:var(--fg-soft);">
                      {{ $facility->nama_fasilitas }}
                    </span>
                  @endforeach
                </div>
              </div>
            @endif

            <hr class="divider" style="margin-block:var(--space-5);" />

            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:var(--space-4);">
              <div>
                <span class="label">Harga sewa / hari</span>
                <div style="font-family:var(--font-display);font-size:var(--text-3xl);color:var(--purple);">Rp {{ number_format($bus->harga_sewa, 0, ',', '.') }}</div>
              </div>
              @auth
                <a href="{{ route('booking.create', ['bus_id' => $bus->id]) }}" class="btn btn--primary btn--lg">
                  Pesan Sekarang
                  <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
              @else
                <div style="background:var(--bg-card);border:1px solid var(--rule);border-radius:var(--radius);padding:var(--space-4) var(--space-5);">
                  <p style="color:var(--fg-soft);font-size:var(--text-sm);">
                    Silakan <a href="{{ route('login') }}" style="color:var(--purple);font-weight:500;">Login</a> atau <a href="{{ route('register') }}" style="color:var(--purple);font-weight:500;">Daftar</a> untuk memesan bus ini.
                  </p>
                </div>
              @endauth
            </div>
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
