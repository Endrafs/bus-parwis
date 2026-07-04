<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>PHD Trans · Kontak</title>
  <meta name="description" content="Hubungi PHD Trans untuk pemesanan dan informasi penyewaan bus pariwisata." />
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
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>Respon dalam 24 jam kerja</span>
            <h1 class="hero-headline">
              Kirim pesan,<br/>
              <span class="purple">dapatkan</span><br/>
              jawaban.
            </h1>
            <p class="hero-sub">
              Setiap pertanyaan dibaca dan dijawab oleh tim customer service kami. Kami berusaha membalas dalam 24 jam kerja dengan informasi yang jelas dan membantu.
            </p>
            <div class="hero-cta-row">
              <a class="btn btn--primary btn--lg" href="#intake">Kirim Pesan</a>
              <a class="btn btn--ghost btn--lg" href="#channels">Kontak Lain</a>
            </div>
            <div class="hero-meta">
              <span><strong>24 jam</strong> · target respon</span>
              <span><strong>Senin—Sabtu</strong> · 08:00–20:00</span>
            </div>
          </div>
          <div class="hero-media">
            <div style="width:100%;height:100%;background:linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);display:flex;align-items:center;justify-content:center;">
              <span style="font-size:6rem;opacity:0.3;">📞</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Info + Contact Channels -->
    <section id="channels">
      <div class="container container--wide">
        <div class="section-head">
          <h2>Hubungi <span class="purple">Kami</span></h2>
          <p class="lede">Tiga cara mudah untuk terhubung dengan tim PHD Trans.</p>
        </div>
        <div class="channel-grid">
          <div class="channel-card">
            <h3>💬 WhatsApp</h3>
            <p>Respon cepat via WhatsApp. Chat kami untuk konsultasi dan pemesanan.</p>
            <a class="channel-line" href="https://wa.me/{{ $websiteSettings->nomor_whatsapp ?? '6281234567890' }}" target="_blank">{{ $websiteSettings->nomor_whatsapp ?? '+62 812-3456-7890' }}</a>
            <span class="mono" style="color: var(--fg-mute);">Customer Service · Respon &lt; 24 jam</span>
          </div>
          <div class="channel-card">
            <h3>📧 Email</h3>
            <p>Kirim email untuk pertanyaan detail, kerjasama, atau dokumen.</p>
            <a class="channel-line" href="mailto:cs@phdtrans.com">cs@phdtrans.com</a>
            <span class="mono" style="color: var(--fg-mute);">Tim Admin · Respon 1×24 jam</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Intake Form -->
    <section id="intake" class="tile-section">
      <div class="container container--narrow">
        <div style="text-align:center;margin-bottom:var(--space-7);">
          <span class="eyebrow" style="display:inline-flex;"><span class="dot" aria-hidden="true"></span>Mulai pemesanan</span>
          <h2 style="color:var(--ink-000);margin-top:var(--space-3);">Kirim <span style="color:var(--purple);">Pesan</span></h2>
        </div>

        @if(session('success'))
          <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);border-radius:var(--radius);padding:var(--space-5);margin-bottom:var(--space-5);text-align:center;">
            <p style="color:#2A2A28;font-weight:500;">✅ {{ session('success') }}</p>
          </div>
        @endif

        <form method="POST" action="{{ route('contact') }}" class="form-card" style="background:var(--paper-tile);border-color:rgba(10,10,12,0.1);">
          @csrf
          <div class="form-row">
            <div class="form-field">
              <label for="nama">Nama Lengkap</label>
              <input type="text" name="nama" id="nama" placeholder="Nama Anda" required />
            </div>
            <div class="form-field">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" placeholder="email@anda.com" />
            </div>
          </div>
          <div class="form-row form-row--full">
            <div class="form-field">
              <label for="no_wa">No. WhatsApp</label>
              <input type="text" name="no_wa" id="no_wa" placeholder="+62 812-3456-7890" required />
            </div>
          </div>
          <div class="form-row form-row--full">
            <div class="form-field">
              <label for="pesan">Pesan</label>
              <textarea name="pesan" id="pesan" placeholder="Tulis pesan Anda di sini..." required></textarea>
            </div>
          </div>
          <div class="form-actions">
            <small>Kami akan membalas dalam 1×24 jam kerja</small>
            <button type="submit" class="btn btn--primary btn--lg">Kirim Pesan
              <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
          </div>
        </form>
      </div>
    </section>

    <!-- Contact Info -->
    <section class="snug">
      <div class="container container--wide">
        <div class="contact-info-grid">
          <div class="contact-info-card">
            <h4>📍 Kantor Pusat</h4>
            <p>{{ $websiteSettings->alamat ?? 'Jl. Raya Transportasi No. 123, Jakarta Pusat' }}</p>
          </div>
          <div class="contact-info-card">
            <h4>🕐 Jam Operasional</h4>
            <p>Senin — Sabtu: 08:00 – 20:00<br/>Minggu & Hari Libur: 09:00 – 17:00</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Closing -->
    <section class="closing-cta">
      <div class="container container--narrow">
        <span class="label" style="color: rgba(244,244,240,0.6);">Siap memesan?</span>
        <h2>Kirim pesan,<br/>kami akan<br/>membalas.</h2>
        <p class="lede">
          Tidak suka form? Hubungi kami langsung via WhatsApp atau email. Setiap pesan dibaca oleh manusia, bukan bot.
        </p>
        <div class="cta-row">
          <a class="btn btn--primary btn--lg" href="https://wa.me/{{ $websiteSettings->nomor_whatsapp ?? '6281234567890' }}" target="_blank">Whatsapp Kami
            <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <a class="btn btn--ghost btn--lg" href="mailto:cs@phdtrans.com">Atau kirim email</a>
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
