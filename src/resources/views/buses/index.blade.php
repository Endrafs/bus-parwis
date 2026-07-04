<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $websiteSettings->nama_website ?? 'PHD Trans' }} — Sewa Bus Pariwisata Premium</title>
  <meta name="description" content="PHD Trans — Penyewaan bus pariwisata terpercaya dengan armada Big Bus & Medium Bus berkualitas." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Boldonse&family=Inter+Tight:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <a class="skip-link" href="#main">Skip to content</a>

  <header class="site-header">
    <div class="container container--wide">
      <nav class="nav" aria-label="Primary">
        <a class="brand" href="{{ route('home') }}"><span class="brand-mark" aria-hidden="true"></span> {{ $websiteSettings->nama_website ?? 'PHD Trans' }}</a>
        <div class="nav-links" role="navigation">
          <a href="{{ route('home') }}" aria-current="page">Armada</a>
          <a href="{{ route('about') }}">Tentang</a>
          <a href="{{ route('services') }}">Layanan</a>
          <a href="{{ route('contact') }}">Kontak</a>
        </div>
        <div class="nav-cta-row">
          @auth
            <a href="{{ route('booking.index') }}" class="btn btn--primary btn--sm">Booking Saya
              <svg class="arrow" width="14" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
          @else
            <a href="{{ route('register') }}" class="btn btn--primary btn--sm">Daftar
              <svg class="arrow" width="14" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
          @endauth
          <button class="nav-toggle" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-drawer"><span aria-hidden="true"></span></button>
        </div>
      </nav>
    </div>
  </header>

  <div class="mobile-drawer" id="mobile-drawer" aria-hidden="true">
    <button class="drawer-close" aria-label="Close menu">Close</button>
    <a href="{{ route('home') }}">Armada</a>
    <a href="{{ route('about') }}">Tentang</a>
    <a href="{{ route('services') }}">Layanan</a>
    <a href="{{ route('contact') }}">Kontak</a>
    <hr class="divider" style="margin-block: var(--space-4);">
    @auth
      <a href="{{ route('booking.index') }}">Booking Saya</a>
      <a href="{{ route('dashboard') }}">Dashboard</a>
      <form method="POST" action="{{ route('logout') }}" style="margin-top:auto;">
        @csrf
        <button type="submit" class="btn btn--ghost btn--sm" style="width:100%;">Logout</button>
      </form>
    @else
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}">Daftar</a>
    @endauth
  </div>

  <main id="main">

    <!-- Hero -->
    <section class="hero">
      <div class="container container--wide">
        <div class="hero-grid">
          <div class="hero-text">
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>{{ $websiteSettings->nama_website ?? 'PHD Trans' }} · est. 2015</span>
            <h1 class="hero-headline">
              Sewa Bus<br/>
              <span class="purple">Pariwisata</span> Nyaman<br/>
              & Terpercaya
            </h1>
            <p class="hero-sub">
              {{ $websiteSettings->deskripsi ?? 'PHD Trans menyediakan armada Big Bus & Medium Bus berkualitas dengan fasilitas modern. Booking mudah, harga transparan, dan pengalaman perjalanan yang tak terlupakan.' }}
            </p>
            <div class="hero-cta-row">
              <a class="btn btn--primary btn--lg" href="#bus-list">Lihat Armada
                <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </a>
              <a class="btn btn--ghost btn--lg" href="{{ route('services') }}">Cara Sewa</a>
            </div>
            <div class="hero-meta">
              <span><strong>50+</strong> · Armada Tersedia</span>
              <span><strong>1000+</strong> · Pelanggan Puas</span>
              <span><strong>15</strong> · Tahun Pengalaman</span>
            </div>
          </div>
          <div class="hero-media">
            <div style="width:100%;height:100%;background:linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);display:flex;align-items:center;justify-content:center;">
              <span style="font-size:6rem;opacity:0.3;">🚌</span>
            </div>
            <div class="floating-tag ft-top">
              <span class="pill">Mulai</span>
              <span>Rp 2.5jt/hari</span>
            </div>
            <div class="floating-tag ft-bottom">
              <span>⭐ 4.9 Rating</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Fleet Stats -->
    <section class="compact">
      <div class="container container--wide">
        <div class="stat-strip">
          <div class="stat-cell">
            <span class="stat-num"><span class="purple">50</span>+</span>
            <span class="stat-label">Armada Bus</span>
          </div>
          <div class="stat-cell">
            <span class="stat-num"><span class="purple">15</span></span>
            <span class="stat-label">Tahun Pengalaman</span>
          </div>
          <div class="stat-cell">
            <span class="stat-num"><span class="purple">1K</span>+</span>
            <span class="stat-label">Pelanggan Puas</span>
          </div>
          <div class="stat-cell">
            <span class="stat-num"><span class="purple">99</span>%</span>
            <span class="stat-label">Tepat Waktu</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Bus List -->
    <section id="bus-list">
      <div class="container container--wide">
        <div class="section-head">
          <h2>Armada <span class="purple">Kami</span></h2>
          <p class="lede">Pilih armada bus yang sesuai dengan kebutuhan perjalanan Anda. Semua unit dalam kondisi prima dan siap menemani perjalanan Anda.</p>
        </div>

        @if($buses->isEmpty())
          <div style="text-align:center;padding:var(--space-9) 0;">
            <div style="font-size:4rem;margin-bottom:var(--space-5);">🚌</div>
            <h3>Belum Ada Armada</h3>
            <p style="color:var(--fg-soft);">Saat ini belum ada armada bus yang tersedia. Silakan cek kembali nanti.</p>
          </div>
        @else
          <div class="fleet-grid">
            @foreach($buses as $bus)
              <a href="{{ route('bus.show', $bus) }}" class="fleet-item fleet-item--sm">
                <div class="fm">
                  @if($bus->foto)
                    <img src="{{ asset('storage/' . $bus->foto) }}" alt="{{ $bus->nama_bus }}" />
                  @else
                    <div style="width:100%;height:100%;background:linear-gradient(135deg, var(--purple-deep), var(--ink-card));display:flex;align-items:center;justify-content:center;">
                      <span style="font-size:4rem;opacity:0.3;">🚌</span>
                    </div>
                  @endif
                  <span class="fm-pill">{{ $bus->kategori_bus }}</span>
                  <span class="fm-arrow">
                    <svg width="18" height="14" viewBox="0 0 14 10" fill="none"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  </span>
                </div>
                <div class="fleet-meta">
                  <div>
                    <div class="fm-title">{{ $bus->nama_bus }}</div>
                    <div class="fm-cap">{{ $bus->kapasitas }} org · {{ $bus->tipe_bus }}</div>
                  </div>
                  <div style="text-align:right;">
                    <div class="fm-cap">Mulai</div>
                    <div style="font-family:var(--font-display);font-size:var(--text-base);color:var(--purple);">Rp{{ number_format($bus->harga_sewa, 0, ',', '.') }}</div>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </section>

    <!-- Why Choose Us -->
    <section class="tile-section">
      <div class="container container--wide">
        <div class="section-head">
          <h2>Mengapa <span style="color:var(--purple);">PHD Trans?</span></h2>
          <p class="lede">Kami berkomitmen memberikan layanan penyewaan bus terbaik untuk perjalanan Anda.</p>
        </div>
        <div class="process-grid">
          <div class="process-card" style="background:var(--paper-tile);border-color:rgba(10,10,12,0.1);">
            <div class="step-num" style="color:var(--purple);">01</div>
            <h3 style="color:var(--ink-000);">Armada Terawat</h3>
            <p style="color:#2A2A28;">Setiap unit bus menjalani pemeriksaan rutin untuk memastikan keamanan dan kenyamanan perjalanan Anda.</p>
          </div>
          <div class="process-card" style="background:var(--paper-tile);border-color:rgba(10,10,12,0.1);">
            <div class="step-num" style="color:var(--purple);">02</div>
            <h3 style="color:var(--ink-000);">Harga Transparan</h3>
            <p style="color:#2A2A28;">Tidak ada biaya tersembunyi. Harga yang tertera adalah harga yang Anda bayar.</p>
          </div>
          <div class="process-card" style="background:var(--paper-tile);border-color:rgba(10,10,12,0.1);">
            <div class="step-num" style="color:var(--purple);">03</div>
            <h3 style="color:var(--ink-000);">Booking Mudah</h3>
            <p style="color:#2A2A28;">Sistem booking online yang cepat dan praktis. Pesan bus favorit Anda kapan saja.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Closing CTA -->
    <section class="closing-cta">
      <div class="container container--narrow">
        <span class="label" style="color: rgba(244,244,240,0.6);">Booking · {{ date('Y') }}</span>
        <h2>Siap untuk<br/>perjalanan yang<br/>nyaman?</h2>
        <p class="lede">
          Pesan armada bus sekarang dan nikmati pengalaman perjalanan bersama PHD Trans. Kami siap melayani Anda dengan armada terbaik.
        </p>
        <div class="cta-row">
          <a class="btn btn--primary btn--lg" href="{{ route('register') }}">Mulai Pesan
            <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <a class="btn btn--ghost btn--lg" href="{{ route('contact') }}">Hubungi Kami</a>
        </div>
      </div>
    </section>

  </main>

  <footer class="site-footer">
    <div class="container container--wide">
      <div class="footer-top">
        <div class="footer-brand">
          <span class="brand"><span class="brand-mark" aria-hidden="true"></span> {{ $websiteSettings->nama_website ?? 'PHD Trans' }}</span>
          <p>Penyedia layanan penyewaan bus pariwisata terpercaya sejak 2015. Armada lengkap, harga transparan, pelayanan profesional.</p>
          @if($websiteSettings && $websiteSettings->nomor_whatsapp)
            <span class="label">{{ $websiteSettings->nomor_whatsapp }}</span>
          @endif
        </div>
        <div>
          <h4>Layanan</h4>
          <ul>
            <li><a href="{{ route('home') }}">Armada</a></li>
            <li><a href="{{ route('services') }}">Cara Sewa</a></li>
            <li><a href="{{ route('services') }}#harga">Harga</a></li>
            <li><a href="{{ route('services') }}#faq">FAQ</a></li>
          </ul>
        </div>
        <div>
          <h4>Perusahaan</h4>
          <ul>
            <li><a href="{{ route('about') }}">Tentang</a></li>
            <li><a href="{{ route('contact') }}">Kontak</a></li>
            <li><a href="#">Syarat & Ketentuan</a></li>
            <li><a href="#">Kebijakan Privasi</a></li>
          </ul>
        </div>
        <div>
          <h4>Pelanggan</h4>
          <ul>
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Daftar</a></li>
            <li><a href="{{ route('contact') }}">Bantuan</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <span>© {{ date('Y') }} {{ $websiteSettings->nama_website ?? 'PHD Trans' }} · All rights reserved.</span>
        <div class="footer-meta-links">
          <a href="#">Privacy</a>
          <a href="#">Terms</a>
        </div>
      </div>
    </div>
  </footer>

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
