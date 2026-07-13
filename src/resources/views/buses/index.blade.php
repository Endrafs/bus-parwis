<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $websiteSettings->nama_website ?? 'PHD Trans' }} — Sewa Bus Pariwisata Premium</title>
  <meta name="description" content="{{ $websiteSettings->deskripsi ?? 'PHD Trans — Penyewaan bus pariwisata terpercaya dengan armada Big Bus & Medium Bus berkualitas.' }}" />
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
  <a class="skip-link" href="#main">Skip to content</a>

  @include('partials.public-header')

  <main id="main">

    <!-- Hero -->
    <section class="hero animate-on-scroll">
      <div class="container container--wide">
        <div class="hero-grid">
          <div class="hero-text">
            @php
              $hero = $pageSections['hero'] ?? null;
            @endphp
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>{{ $websiteSettings->nama_website ?? 'PHD Trans' }} · est. 2015</span>
            <h1 class="hero-headline">
              {!! $hero->title ?? 'Sewa Bus<br><span class="purple">Pariwisata</span> Nyaman<br>&amp; Terpercaya' !!}
            </h1>
            <p class="hero-sub">
              @if($hero && $hero->description)
                {!! $hero->description !!}
              @else
                {{ $websiteSettings->deskripsi ?? 'PHD Trans menyediakan armada Big Bus & Medium Bus berkualitas dengan fasilitas modern. Booking mudah, harga transparan, dan pengalaman perjalanan yang tak terlupakan.' }}
              @endif
            </p>
            <div class="hero-cta-row">
              <a class="btn btn--primary btn--lg" href="#bus-list">Lihat Armada
                <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </a>
              <a class="btn btn--ghost btn--lg" href="{{ route('services') }}">Cara Sewa</a>
            </div>
            <div class="hero-meta">
              @php
                $heroMeta = $hero->metadata ?? null;
              @endphp
              @if($heroMeta && is_array($heroMeta))
                @foreach($heroMeta as $meta)
                  <span><strong>{{ $meta['value'] ?? '' }}</strong> · {{ $meta['label'] ?? '' }}</span>
                @endforeach
              @else
                <span><strong>50+</strong> · Armada Tersedia</span>
                <span><strong>1000+</strong> · Pelanggan Puas</span>
                <span><strong>15</strong> · Tahun Pengalaman</span>
              @endif
            </div>
          </div>
          <div class="hero-media">
            @php
              $heroSection = $pageSections['hero'] ?? null;
              $mediaType = $heroSection->media_type ?? 'none';
            @endphp
            @if($mediaType === 'image' && $heroSection->media_path)
              <img src="{{ asset('storage/' . $heroSection->media_path) }}" alt="{{ $heroSection->title ?? 'Hero' }}" style="width:100%;height:100%;object-fit:cover;" />
            @elseif($mediaType === 'video' && $heroSection->media_path)
              <video autoplay muted loop playsinline style="width:100%;height:100%;object-fit:cover;">
                <source src="{{ asset('storage/' . $heroSection->media_path) }}" type="video/mp4">
              </video>
            @elseif($mediaType === 'youtube' && $heroSection->media_url)
              <iframe src="{{ $heroSection->getYoutubeEmbedUrl() ?? $heroSection->media_url }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width:100%;height:100%;border:none;"></iframe>
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);display:flex;align-items:center;justify-content:center;">
                <span style="font-size:6rem;opacity:0.3;">🚌</span>
              </div>
            @endif
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
    <section class="compact animate-on-scroll">
      <div class="container container--wide">
        <div class="stat-strip">
          @php
            $statsSection = $pageSections['stats'] ?? null;
            $stats = $statsSection->metadata ?? [
              ['value' => '50', 'label' => 'Armada Bus'],
              ['value' => '15', 'label' => 'Tahun Pengalaman'],
              ['value' => '1000', 'label' => 'Pelanggan Puas'],
              ['value' => '99%', 'label' => 'Tepat Waktu'],
            ];
          @endphp
          @foreach($stats as $stat)
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

    <!-- Bus List -->
    <section id="bus-list" class="animate-on-scroll">
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
    <section class="tile-section animate-on-scroll">
      <div class="container container--wide">
        <div class="section-head">
          <h2>Mengapa <span style="color:var(--purple);">PHD Trans?</span></h2>
          <p class="lede">Kami berkomitmen memberikan layanan penyewaan bus terbaik untuk perjalanan Anda.</p>
        </div>
        @php
          $valuesSection = $pageSections['values'] ?? null;
          $values = $valuesSection->metadata ?? null;
        @endphp
        @if($values && is_array($values))
          <div class="process-grid">
            @foreach($values as $i => $val)
              <div class="process-card animate-on-scroll" style="background:var(--paper-tile);border-color:rgba(10,10,12,0.1);animation-delay:{{ $i * 100 }}ms;">
                <div class="step-num" style="color:var(--purple);">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                <h3 style="color:var(--ink-000);">{{ $val['value'] ?? '' }}</h3>
                <p style="color:#2A2A28;">{{ $val['desc'] ?? '' }}</p>
              </div>
            @endforeach
          </div>
        @else
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
        @endif
      </div>
    </section>

    <!-- Closing CTA -->
    <section class="closing-cta animate-on-scroll">
      <div class="container container--narrow">
        @php
          $closing = $pageSections['closing_cta'] ?? null;
        @endphp
        <span class="label" style="color: rgba(244,244,240,0.6);">{{ $closing->subtitle ?? 'Booking · ' . date('Y') }}</span>
        <h2>{!! $closing->title ?? 'Siap untuk<br/>perjalanan yang<br/>nyaman?' !!}</h2>
        <p class="lede">
          @if($closing && $closing->description)
            {!! $closing->description !!}
          @else
            Pesan armada bus sekarang dan nikmati pengalaman perjalanan bersama PHD Trans. Kami siap melayani Anda dengan armada terbaik.
          @endif
        </p>
        <div class="cta-row">
          <a class="btn btn--primary btn--lg" href="{{ route('register') }}">Mulai Pesan
            <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <a class="btn btn--ghost btn--lg" href="{{ route('contact') }}">Hubungi Kami</a>
        </div>
      </div>
    </section>

    <!-- Gallery Section (if any page section has gallery type) -->
    @php
      $gallerySection = $pageSections['gallery'] ?? $pageSections['media_feature'] ?? null;
    @endphp
    @if($gallerySection && $gallerySection->media_type === 'gallery' && $gallerySection->is_active)
      <section class="tile-section animate-on-scroll">
        <div class="container container--wide">
          <div class="section-head">
            <h2>{!! $gallerySection->title ?? 'Galeri <span class="purple">Armada</span>' !!}</h2>
            @if($gallerySection->description)
              <p class="lede">{!! $gallerySection->description !!}</p>
            @endif
          </div>
          @include('partials.section-gallery', ['section' => $gallerySection, 'animate' => false])
        </div>
      </section>
    @elseif($gallerySection && $gallerySection->media_type !== 'none' && $gallerySection->is_active)
      <section class="tile-section animate-on-scroll">
        <div class="container container--wide">
          <div class="section-head">
            <h2>{!! $gallerySection->title ?? 'Lihat <span class="purple">Armada</span> Kami' !!}</h2>
            @if($gallerySection->description)
              <p class="lede">{!! $gallerySection->description !!}</p>
            @endif
          </div>
          <div class="split">
            <div class="split-media" style="aspect-ratio:16/9;">
              @if($gallerySection->media_type === 'image' && $gallerySection->media_path)
                <img src="{{ asset('storage/' . $gallerySection->media_path) }}" alt="{{ $gallerySection->title }}" style="width:100%;height:100%;object-fit:cover;" />
              @elseif($gallerySection->media_type === 'video' && $gallerySection->media_path)
                <video controls style="width:100%;height:100%;object-fit:cover;">
                  <source src="{{ asset('storage/' . $gallerySection->media_path) }}" type="video/mp4">
                </video>
              @elseif($gallerySection->media_type === 'youtube' && $gallerySection->media_url)
                <iframe src="{{ $gallerySection->getYoutubeEmbedUrl() }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width:100%;height:100%;border:none;"></iframe>
              @endif
            </div>
          </div>
        </div>
      </section>
    @endif

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
