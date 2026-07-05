<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>PHD Trans · Layanan & Harga</title>
  <meta name="description" content="Layanan penyewaan bus PHD Trans — Big Bus, Medium Bus, dengan sopir profesional. Harga transparan." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Boldonse&family=Inter+Tight:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @include('partials.public-header')

  <main id="main">

    <!-- Hero -->
    <section class="hero">
      <div class="container container--wide">
        <div class="hero-grid">
          <div class="hero-text">
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>Dua tipe · Satu layanan</span>
            <h1 class="hero-headline">
              Dua pilihan<br/>
              <span class="purple">armada,</span> satu<br/>
              standar kualitas.
            </h1>
            <p class="hero-sub">
              Kami menawarkan Big Bus dan Medium Bus dengan harga yang transparan. Yang perlu Anda lakukan adalah pilih armada, tentukan tanggal, dan nikmati perjalanan.
            </p>
            <div class="hero-cta-row">
              <a class="btn btn--primary btn--lg" href="#harga">Lihat Harga</a>
              <a class="btn btn--ghost btn--lg" href="#proses">Cara Sewa</a>
            </div>
            <div class="hero-meta">
              <span><strong>2</strong> Tipe Armada</span>
              <span><strong>50+</strong> Unit Tersedia</span>
            </div>
          </div>
          <div class="hero-media">
            <div style="width:100%;height:100%;background:linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);display:flex;align-items:center;justify-content:center;">
              <span style="font-size:6rem;opacity:0.3;">🚌</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Process -->
    <section id="proses">
      <div class="container container--wide">
        <div class="section-head">
          <h2>Cara <span class="purple">Sewa</span></h2>
          <p class="lede">Proses penyewaan bus di PHD Trans mudah dan cepat. Hanya 4 langkah sederhana.</p>
        </div>
        <div class="process-grid">
          <div class="process-card">
            <div class="step-num">01</div>
            <h3>Pilih Armada</h3>
            <p>Jelajahi koleksi armada Big Bus dan Medium Bus kami. Setiap unit dilengkapi informasi detail, fasilitas, dan harga sewa per hari.</p>
          </div>
          <div class="process-card">
            <div class="step-num">02</div>
            <h3>Pesan & Bayar</h3>
            <p>Isi form booking dengan tanggal, tujuan, dan detail perjalanan. Lakukan pembayaran DP atau pelunasan melalui transfer bank.</p>
          </div>
          <div class="process-card">
            <div class="step-num">03</div>
            <h3>Verifikasi</h3>
            <p>Tim admin kami akan memverifikasi pembayaran dan booking Anda. Status akan berubah menjadi "Dikonfirmasi" setelah disetujui.</p>
          </div>
          <div class="process-card">
            <div class="step-num">04</div>
            <h3>Nikmati Perjalanan</h3>
            <p>Bus siap digunakan sesuai jadwal. Sopir profesional kami akan memastikan perjalanan Anda aman dan nyaman.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Pricing -->
    <section id="harga" class="tile-section">
      <div class="container container--wide">
        <div class="section-head">
          <h2>Harga <span style="color:var(--purple);">Sewa</span></h2>
          <p class="lede">Harga sudah termasuk sopir, bahan bakar, dan fasilitas standar. Transparan tanpa biaya tersembunyi.</p>
        </div>
        <div class="tier-grid">
          <div class="tier-card" style="background:var(--paper-tile);">
            <span class="label">Mulai dari</span>
            <h3 style="color:var(--ink-000);">Medium Bus</h3>
            <div class="tier-meta" style="color:#2A2A28;">Kapasitas 20–30 orang</div>
            <hr class="tier-divider" />
            <ul class="tier-list">
              <li>AC Dingin & Non-Merokok</li>
              <li>Reclining Seat Nyaman</li>
              <li>Audio System & Mic</li>
              <li>Sopir Berpengalaman</li>
              <li>Bahan Bakar Termasuk</li>
            </ul>
            <hr class="tier-divider" />
            <div class="tier-meta" style="color:var(--ink-000);font-size:var(--text-xl);font-family:var(--font-display);">Mulai Rp 2.500.000</div>
            <div class="tier-meta" style="color:#2A2A28;">/ hari</div>
            <a href="{{ route('home') }}" class="btn btn--dark" style="width:100%;justify-content:center;margin-top:auto;">Lihat Armada</a>
          </div>

          <div class="tier-card featured" style="background:var(--paper-tile);border:2px solid var(--purple);">
            <span class="label" style="color:var(--purple);">⭐ Paling Populer</span>
            <h3 style="color:var(--ink-000);">Big Bus</h3>
            <div class="tier-meta" style="color:#2A2A28;">Kapasitas 40–59 orang</div>
            <hr class="tier-divider" />
            <ul class="tier-list">
              <li>AC Dingin & Non-Merokok</li>
              <li>Reclining Seat Legowo</li>
              <li>Toilet & Audio System</li>
              <li>TV & Karaoke</li>
              <li>Sopir & Kernet Profesional</li>
              <li>Bahan Bakar Termasuk</li>
            </ul>
            <hr class="tier-divider" />
            <div class="tier-meta" style="color:var(--ink-000);font-size:var(--text-xl);font-family:var(--font-display);">Mulai Rp 3.500.000</div>
            <div class="tier-meta" style="color:#2A2A28;">/ hari</div>
            <a href="{{ route('home') }}" class="btn btn--primary" style="width:100%;justify-content:center;margin-top:auto;">Lihat Armada</a>
          </div>

          <div class="tier-card" style="background:var(--paper-tile);">
            <span class="label">Paket Khusus</span>
            <h3 style="color:var(--ink-000);">Custom Trip</h3>
            <div class="tier-meta" style="color:#2A2A28;">Sesuai kebutuhan Anda</div>
            <hr class="tier-divider" />
            <ul class="tier-list">
              <li>Multi Hari / Drop Off</li>
              <li>Rute Luar Kota/Pulau</li>
              <li>Penginapan Sopir</li>
              <li>Request Jadwal Kustom</li>
              <li>Event & Wedding</li>
            </ul>
            <hr class="tier-divider" />
            <div class="tier-meta" style="color:var(--ink-000);font-size:var(--text-xl);font-family:var(--font-display);">Hubungi Kami</div>
            <div class="tier-meta" style="color:#2A2A28;">Negosiasi</div>
            <a href="{{ route('contact') }}" class="btn btn--dark" style="width:100%;justify-content:center;margin-top:auto;">Hubungi Kami</a>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="snug">
      <div class="container container--narrow">
        <div style="text-align:center;margin-bottom:var(--space-7);">
          <span class="eyebrow" style="display:inline-flex;"><span class="dot" aria-hidden="true"></span>FAQ</span>
          <h2 style="margin-top:var(--space-3);">Pertanyaan <span class="purple">Umum</span></h2>
        </div>
        <div class="faq-grid">
          <div class="faq-card">
            <h3>Bagaimana cara booking?</h3>
            <p>Daftar/login akun, pilih armada, isi form booking dengan tanggal dan tujuan, lalu lakukan pembayaran.</p>
          </div>
          <div class="faq-card">
            <h3>Apa saja yang termasuk harga sewa?</h3>
            <p>Harga sudah termasuk sopir, bahan bakar, dan fasilitas standar bus. Biaya tol dan parkir ditanggung penyewa.</p>
          </div>
          <div class="faq-card">
            <h3>Berapa deposit yang harus dibayar?</h3>
            <p>Minimal DP 50% dari total harga. Pelunasan dapat dilakukan H-1 atau di hari keberangkatan.</p>
          </div>
          <div class="faq-card">
            <h3>Apakah bisa booking untuk perjalanan multi-hari?</h3>
            <p>Tentu. Kami melayani perjalanan multi-hari. Harga dihitung per hari dengan paket khusus.</p>
          </div>
          <div class="faq-card">
            <h3>Apakah sopir sudah termasuk?</h3>
            <p>Ya, semua paket sudah termasuk sopir profesional dan ramah. Untuk Big Bus termasuk kernet.</p>
          </div>
          <div class="faq-card">
            <h3>Bagaimana jika booking dibatalkan?</h3>
            <p>Pembatalan H-7: DP dikembalikan 50%. H-3: tidak dapat refund. Hubungi admin untuk info detail.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Closing -->
    <section class="closing-cta">
      <div class="container container--narrow">
        <span class="label" style="color: rgba(244,244,240,0.6);">Booking · {{ date('Y') }}</span>
        <h2>Ada pertanyaan<br/>lain? Tanya<br/>kami saja.</h2>
        <p class="lede">
          Tim kami siap membantu Anda memilih armada yang tepat dan menjawab semua pertanyaan Anda.
        </p>
        <div class="cta-row">
          <a class="btn btn--primary btn--lg" href="{{ route('contact') }}">Hubungi Kami
            <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <a class="btn btn--ghost btn--lg" href="{{ route('home') }}">Lihat Armada</a>
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
