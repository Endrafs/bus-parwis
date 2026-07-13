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
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>{{ $hero->subtitle ?? 'Perusahaan · est. 2015' }}</span>
            <h1 class="hero-headline">{!! $hero->title ?? 'Satu tim,<br/><span class="purple">satu visi</span>,<br/> melayani Anda.' !!}</h1>
            <p class="hero-sub">
              @if($hero && $hero->description)
                {!! $hero->description !!}
              @else
                PHD Trans adalah perusahaan penyewaan bus pariwisata yang berdiri sejak 2015. Berawal dari 3 unit bus, kini kami memiliki lebih dari 50 armada yang siap melayani perjalanan Anda.
              @endif
            </p>
            <div class="hero-cta-row">
              <a class="btn btn--primary btn--lg" href="#team">Tim Kami</a>
              <a class="btn btn--ghost btn--lg" href="{{ route('contact') }}">Hubungi Kami</a>
            </div>
            <div class="hero-meta">
              @php $heroMeta = $hero->metadata ?? null; @endphp
              @if($heroMeta && is_array($heroMeta))
                @foreach($heroMeta as $meta)
                  <span><strong>{{ $meta['value'] ?? '' }}</strong> · {{ $meta['label'] ?? '' }}</span>
                @endforeach
              @else
                <span><strong>2015</strong> · Tahun berdiri</span>
                <span><strong>50+</strong> · Armada</span>
                <span><strong>25</strong> · Karyawan</span>
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
              <div style="width:100%;height:100%;background:linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);display:flex;align-items:center;justify-content:center;"><span style="font-size:6rem;opacity:0.3;">🏢</span></div>
            @endif
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    @php $aboutContent = $pageSections['about_content'] ?? null; @endphp
    <section id="about" class="animate-on-scroll">
      <div class="container container--wide">
        <div class="split">
          <div class="split-text">
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>{{ $aboutContent->subtitle ?? 'Cerita Kami' }}</span>
            <h2>{!! $aboutContent->title ?? 'Perjalanan<br/>PHD <span class="purple">Trans</span>' !!}</h2>
            <p class="lede">
              @if($aboutContent && $aboutContent->description)
                {!! $aboutContent->description !!}
              @else
                Berawal dari kecintaan terhadap dunia transportasi, PHD Trans hadir untuk memberikan solusi perjalanan yang nyaman, aman, dan terjangkau bagi masyarakat Indonesia.
              @endif
            </p>
            <div class="hero-cta-row" style="margin-top:var(--space-5);">
              <a class="btn btn--primary" href="{{ route('services') }}">Lihat Layanan</a>
            </div>
          </div>
          <div class="split-media" style="aspect-ratio:4/3;">
            @if($aboutContent && $aboutContent->media_type === 'image' && $aboutContent->media_path)
              <img src="{{ asset('storage/' . $aboutContent->media_path) }}" alt="" style="width:100%;height:100%;object-fit:cover;" />
            @elseif($aboutContent && $aboutContent->media_type === 'video' && $aboutContent->media_path)
              <video controls style="width:100%;height:100%;object-fit:cover;"><source src="{{ asset('storage/' . $aboutContent->media_path) }}" type="video/mp4"></video>
            @elseif($aboutContent && $aboutContent->media_type === 'youtube' && $aboutContent->media_url)
              <iframe src="{{ $aboutContent->getYoutubeEmbedUrl() }}" frameborder="0" allowfullscreen style="width:100%;height:100%;border:none;"></iframe>
            @else
              <div style="width:100%;height:100%;background:var(--bg-card);display:flex;align-items:center;justify-content:center;border-radius:var(--radius);"><span style="font-size:4rem;opacity:0.4;">🚌</span></div>
            @endif
          </div>
        </div>
      </div>
    </section>

    <!-- Values -->
    @php $valuesSection = $pageSections['values'] ?? null; @endphp
    @if($valuesSection && $valuesSection->metadata)
      <section id="team" class="animate-on-scroll">
        <div class="container container--wide">
          <div class="section-head">
            <h2>{!! $valuesSection->title ?? 'Nilai <span class="purple">Kami</span>' !!}</h2>
            <p class="lede">{{ $valuesSection->subtitle ?? 'Tiga pilar yang menjaga kualitas' }}</p>
          </div>
          <div class="process-grid">
            @foreach($valuesSection->metadata as $i => $val)
              <div class="process-card animate-on-scroll" style="background:var(--paper-tile);border-color:rgba(10,10,12,0.1);animation-delay:{{ $i * 100 }}ms;">
                <div class="step-num" style="color:var(--purple);">{{ $val['icon'] ?? str_pad($i+1,2,'0',STR_PAD_LEFT) }}</div>
                <h3 style="color:var(--ink-000);">{{ $val['value'] ?? '' }}</h3>
                <p style="color:#2A2A28;">{{ $val['desc'] ?? '' }}</p>
              </div>
            @endforeach
          </div>
        </div>
      </section>
    @endif

    <!-- Stats -->
    @php $stats = $pageSections['stats'] ?? null; @endphp
    @if($stats && $stats->metadata)
      <section class="compact animate-on-scroll">
        <div class="container container--wide">
          <div class="stat-strip">
            @foreach($stats->metadata as $stat)
              <div class="stat-cell">
                @php
                  $statValue = $stat['value'] ?? '';
                  preg_match('/^([0-9]+)([^0-9]*)$/', $statValue, $m);
                  $statNum  = $m[1] ?? $statValue;
                  $statSuffix = $m[2] ?? '';
                @endphp
                <span class="stat-num"><span class="purple">{{ $statNum }}</span>{{ $statSuffix }}</span>
                <span class="stat-label">{{ $stat['label'] ?? '' }}</span>
              </div>
            @endforeach
          </div>
        </div>
      </section>
    @endif

    <!-- Closing -->
    @php $closing = $pageSections['closing_cta'] ?? null; @endphp
    <section class="closing-cta animate-on-scroll">
      <div class="container container--narrow">
        <span class="label" style="color: rgba(244,244,240,0.6);">{{ $closing->subtitle ?? 'Bersama PHD Trans' }}</span>
        <h2>{!! $closing->title ?? 'Siap memulai<br/>perjalanan<br/>bersama kami?' !!}</h2>
        <p class="lede">
          @if($closing && $closing->description)
            {!! $closing->description !!}
          @else
            Hubungi kami untuk konsultasi dan pemesanan. Tim kami siap membantu Anda memilih armada yang tepat.
          @endif
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
