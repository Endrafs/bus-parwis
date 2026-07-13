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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300..700&family=JetBrains+Mono:wght@400..600&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <div class="particle-container" aria-hidden="true">
    <div class="particle"></div><div class="particle"></div><div class="particle"></div>
    <div class="particle"></div><div class="particle"></div><div class="particle"></div>
    <div class="particle"></div><div class="particle"></div><div class="particle"></div>
    <div class="particle"></div><div class="particle"></div><div class="particle"></div>
  </div>
  @include('partials.public-header')

  <main id="main">
    <!-- Hero -->
    <section class="hero animate-on-scroll">
      <div class="container container--wide">
        <div class="hero-grid">
          @php $hero = $pageSections['hero'] ?? null; @endphp
          <div class="hero-text">
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>{{ $hero->subtitle ?? 'Respon dalam 24 jam kerja' }}</span>
            <h1 class="hero-headline">{!! $hero->title ?? 'Kirim pesan,<br/> <span class="purple">dapatkan</span><br/> jawaban.' !!}</h1>
            <p class="hero-sub">
              @if($hero && $hero->description)
                {!! $hero->description !!}
              @else
                Setiap pertanyaan dibaca dan dijawab oleh tim customer service kami. Kami berusaha membalas dalam 24 jam kerja dengan informasi yang jelas dan membantu.
              @endif
            </p>
            <div class="hero-cta-row">
              <a class="btn btn--primary btn--lg" href="#intake">Kirim Pesan</a>
              <a class="btn btn--ghost btn--lg" href="#channels">Kontak Lain</a>
            </div>
            <div class="hero-meta">
              @php $heroMeta = $hero->metadata ?? null; @endphp
              @if($heroMeta && is_array($heroMeta))
                @foreach($heroMeta as $meta)
                  <span><strong>{{ $meta['value'] ?? '' }}</strong> · {{ $meta['label'] ?? '' }}</span>
                @endforeach
              @else
                <span><strong>24 jam</strong> · target respon</span>
                <span><strong>Senin—Sabtu</strong> · 08:00–20:00</span>
              @endif
            </div>
          </div>
          <div class="hero-media">
            @php $mType = $hero->media_type ?? 'none'; @endphp
            @if($mType === 'image' && $hero->media_path)
              <img src="{{ asset('storage/' . $hero->media_path) }}" alt="{{ $hero->title }}" style="width:100%;height:100%;object-fit:cover;" />
            @elseif($mType === 'youtube' && $hero->media_url)
              <iframe src="{{ $hero->getYoutubeEmbedUrl() }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width:100%;height:100%;border:none;"></iframe>
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);display:flex;align-items:center;justify-content:center;"><span style="font-size:6rem;opacity:0.3;">📞</span></div>
            @endif
          </div>
        </div>
      </div>
    </section>

    <!-- Info + Contact Channels -->
    @php $channels = $pageSections['channels'] ?? null; @endphp
    @if($channels)
      <section id="channels" class="animate-on-scroll">
        <div class="container container--wide">
          <div class="section-head">
            <h2>{!! $channels->title ?? 'Hubungi <span class="purple">Kami</span>' !!}</h2>
            <p class="lede">{{ $channels->subtitle ?? 'Tiga cara mudah untuk terhubung dengan tim PHD Trans.' }}</p>
          </div>
          <div class="channel-grid">
            @php $chMeta = $channels->metadata ?? []; @endphp
            @foreach($chMeta as $ch)
              @php $icon = $ch['icon'] ?? '💬'; $channelType = $ch['channel'] ?? ''; @endphp
              <div class="channel-card animate-on-scroll">
                <h3>{{ $icon }} {{ $ch['value'] ?? $channelType }}</h3>
                <p>{{ $ch['desc'] ?? '' }}</p>
                @if($channelType === 'wa')
                  <a class="channel-line" href="https://wa.me/{{ $websiteSettings->nomor_whatsapp ?? '6281234567890' }}" target="_blank">{{ $websiteSettings->nomor_whatsapp ?? '+62 813-5334-3110' }}</a>
                @elseif($channelType === 'email')
                  <a class="channel-line" href="mailto:{{ $websiteSettings->email ?? 'cs@phdtrans.com' }}">{{ $websiteSettings->email ?? 'cs@phdtrans.com' }}</a>
                @endif
                <span class="mono" style="color: var(--fg-mute);">{{ $ch['label'] ?? '' }}</span>
              </div>
            @endforeach
          </div>
        </div>
      </section>
    @endif

    <!-- Intake Form -->
    <section id="intake" class="tile-section animate-on-scroll">
      <div class="container container--narrow">
        <div class="section-head">
          <h2>Kirim <span class="purple">Pesan</span></h2>
          <p class="lede">Isi form di bawah ini, tim kami akan segera merespons.</p>
        </div>

        @if(session('success'))
          <div style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);border-radius:var(--radius);padding:var(--space-4);margin-bottom:var(--space-5);">
            <p style="color:#34D399;font-weight:500;">✅ {{ session('success') }}</p>
          </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}" class="form-card glass" style="padding:var(--space-6);">
          @csrf
          <div class="form-row">
            <div class="form-field">
              <label for="nama">Nama *</label>
              <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required />
              @error('nama')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" value="{{ old('email') }}" />
              @error('email')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
          </div>
          <div class="form-row">
            <div class="form-field">
              <label for="no_wa">No WhatsApp *</label>
              <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa') }}" required />
              @error('no_wa')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
          </div>
          <div class="form-row form-row--full">
            <div class="form-field">
              <label for="pesan">Pesan *</label>
              <textarea name="pesan" id="pesan" rows="4" required>{{ old('pesan') }}</textarea>
              @error('pesan')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
          </div>
          <div class="form-actions" style="border-top:none;padding-top:0;">
            <small>Kami akan membalas dalam 1×24 jam kerja</small>
            <button type="submit" class="btn btn--primary btn--lg">Kirim Pesan
              <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
          </div>
        </form>
      </div>
    </section>

    <!-- Contact Info -->
    @php $contactInfo = $pageSections['contact_info'] ?? null; @endphp
    @if($contactInfo)
      <section class="snug animate-on-scroll">
        <div class="container container--wide">
          <div class="contact-info-grid">
            <div class="contact-info-card">
              <h4>{{ $contactInfo->title ?? '📍 Kantor Pusat' }}</h4>
              <p>{!! $contactInfo->description ?? ($websiteSettings->alamat ?? 'Jl. Raya Transportasi No. 123, Jakarta Pusat') !!}</p>
            </div>
            <div class="contact-info-card">
              <h4>🕐 Jam Operasional</h4>
              <p>Senin — Sabtu: 08:00 – 20:00<br/>Minggu & Hari Libur: 09:00 – 17:00</p>
            </div>
          </div>
        </div>
      </section>
    @endif

    <!-- Closing -->
    @php $closing = $pageSections['closing_cta'] ?? null; @endphp
    <section class="closing-cta animate-on-scroll">
      <div class="container container--narrow">
        <span class="label" style="color: rgba(244,244,240,0.6);">{{ $closing->subtitle ?? 'Siap memesan?' }}</span>
        <h2>{!! $closing->title ?? 'Kirim pesan,<br/>kami akan<br/>membalas.' !!}</h2>
        <p class="lede">
          @if($closing && $closing->description)
            {!! $closing->description !!}
          @else
            Tidak suka form? Hubungi kami langsung via WhatsApp atau email. Setiap pesan dibaca oleh manusia, bukan bot.
          @endif
        </p>
        <div class="cta-row">
          <a class="btn btn--primary btn--lg" href="https://wa.me/{{ $websiteSettings->nomor_whatsapp ?? '6281353343110' }}" target="_blank">Whatsapp Kami
            <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <a class="btn btn--ghost btn--lg" href="mailto:cs@phdtrans.com">Atau kirim email</a>
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
