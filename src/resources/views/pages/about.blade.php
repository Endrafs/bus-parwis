<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>PHD Trans · Tentang Kami</title>
  <meta name="description" content="Tentang PHD Trans — Penyedia layanan penyewaan bus pariwisata terpercaya sejak 2015." />
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
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>Perusahaan · est. 2015</span>
            <h1 class="hero-headline">
              Satu tim,<br/>
              <span class="purple">satu visi</span>,<br/>
              melayani Anda.
            </h1>
            <p class="hero-sub">
              PHD Trans adalah perusahaan penyewaan bus pariwisata yang berdiri sejak 2015. Berawal dari 3 unit bus, kini kami memiliki lebih dari 50 armada yang siap melayani perjalanan Anda.
            </p>
            <div class="hero-cta-row">
              <a class="btn btn--primary btn--lg" href="#team">Tim Kami</a>
              <a class="btn btn--ghost btn--lg" href="{{ route('contact') }}">Hubungi Kami</a>
            </div>
            <div class="hero-meta">
              <span><strong>2015</strong> · Tahun berdiri</span>
              <span><strong>50+</strong> · Armada</span>
              <span><strong>25</strong> · Karyawan</span>
            </div>
          </div>
          <div class="hero-media">
            <div style="width:100%;height:100%;background:linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);display:flex;align-items:center;justify-content:center;">
              <span style="font-size:6rem;opacity:0.3;">🏢</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section id="about">
      <div class="container container--wide">
        <div class="split">
          <div class="split-text">
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>Cerita Kami</span>
            <h2>Perjalanan<br/>PHD <span class="purple">Trans</span></h2>
            <p class="lede">
              Berawal dari kecintaan terhadap dunia transportasi, PHD Trans hadir untuk memberikan solusi perjalanan yang nyaman, aman, dan terjangkau bagi masyarakat Indonesia.
            </p>
            <p style="color:var(--fg-soft);">
              Selama 15 tahun, kami telah melayani ribuan pelanggan — mulai dari study tour sekolah, corporate gathering, family trip, hingga transportasi acara besar. Setiap perjalanan adalah kepercayaan yang kami jaga dengan layanan profesional.
            </p>
            <div class="hero-cta-row" style="margin-top:var(--space-5);">
              <a class="btn btn--primary" href="{{ route('services') }}">Lihat Layanan</a>
            </div>
          </div>
          <div class="split-media">
            <div style="width:100%;height:100%;background:var(--bg-card);display:flex;align-items:center;justify-content:center;border-radius:var(--radius-lg);">
              <span style="font-size:5rem;opacity:0.3;">🚌</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Values -->
    <section class="tile-section">
      <div class="container container--wide">
        <div class="section-head">
          <h2>Nilai <span style="color:var(--purple);">Kami</span></h2>
          <p class="lede">Prinsip yang menjadi fondasi setiap layanan yang kami berikan.</p>
        </div>
        <div class="process-grid">
          <div class="process-card" style="background:var(--paper-tile);border-color:rgba(10,10,12,0.1);">
            <div class="step-num" style="color:var(--purple);">A</div>
            <h3 style="color:var(--ink-000);">Keselamatan</h3>
            <p style="color:#2A2A28;">Keselamatan adalah prioritas utama. Setiap bus dilengkapi dengan perlengkapan keselamatan dan menjalani pemeriksaan rutin.</p>
          </div>
          <div class="process-card" style="background:var(--paper-tile);border-color:rgba(10,10,12,0.1);">
            <div class="step-num" style="color:var(--purple);">B</div>
            <h3 style="color:var(--ink-000);">Kenyamanan</h3>
            <p style="color:#2A2A28;">Armada kami dilengkapi fasilitas modern seperti AC, reclining seat, hiburan, dan toilet untuk kenyamanan maksimal.</p>
          </div>
          <div class="process-card" style="background:var(--paper-tile);border-color:rgba(10,10,12,0.1);">
            <div class="step-num" style="color:var(--purple);">C</div>
            <h3 style="color:var(--ink-000);">Profesionalisme</h3>
            <p style="color:#2A2A28;">Sopir berpengalaman dan ramah, serta tim customer service yang siap membantu Anda 24/7.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats -->
    <section class="compact">
      <div class="container container--wide">
        <div class="stat-strip">
          <div class="stat-cell">
            <span class="stat-num"><span class="purple">15</span></span>
            <span class="stat-label">Tahun Pengalaman</span>
          </div>
          <div class="stat-cell">
            <span class="stat-num"><span class="purple">50</span>+</span>
            <span class="stat-label">Armada Bus</span>
          </div>
          <div class="stat-cell">
            <span class="stat-num"><span class="purple">1K</span>+</span>
            <span class="stat-label">Pelanggan Puas</span>
          </div>
          <div class="stat-cell">
            <span class="stat-num"><span class="purple">25</span></span>
            <span class="stat-label">Tim Profesional</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Closing -->
    <section class="closing-cta">
      <div class="container container--narrow">
        <span class="label" style="color: rgba(244,244,240,0.6);">Bersama PHD Trans</span>
        <h2>Siap memulai<br/>perjalanan<br/>bersama kami?</h2>
        <p class="lede">
          Hubungi kami untuk konsultasi dan pemesanan. Tim kami siap membantu Anda memilih armada yang tepat.
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
