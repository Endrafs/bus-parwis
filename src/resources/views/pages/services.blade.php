<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $websiteSettings->nama_website ?? 'PHD Trans' }} · Layanan &amp; Harga</title>
  <meta name="description" content="{{ $websiteSettings->deskripsi ?? 'Layanan penyewaan bus PHD Trans — Big Bus, Medium Bus, dengan sopir profesional. Harga transparan.' }}" />
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
            <span class="eyebrow"><span class="dot" aria-hidden="true"></span>{{ $hero->subtitle ?? 'Dua tipe · Satu layanan' }}</span>
            <h1 class="hero-headline">{!! $hero->title ?? 'Dua pilihan<br/><span class="purple">armada,</span> satu<br/> standar kualitas.' !!}</h1>
            <p class="hero-sub">
              @if($hero && $hero->description)
                {!! $hero->description !!}
              @else
                Kami menawarkan Big Bus dan Medium Bus dengan harga yang transparan. Yang perlu Anda lakukan adalah pilih armada, tentukan tanggal, dan nikmati perjalanan.
              @endif
            </p>
            <div class="hero-cta-row">
              <a class="btn btn--primary btn--lg" href="#harga">Lihat Harga</a>
              <a class="btn btn--ghost btn--lg" href="#proses">Cara Sewa</a>
            </div>
            <div class="hero-meta">
              @php $heroMeta = $hero->metadata ?? null; @endphp
              @if($heroMeta && is_array($heroMeta))
                @foreach($heroMeta as $meta)
                  <span><strong>{{ $meta['value'] ?? '' }}</strong> {{ $meta['label'] ?? '' }}</span>
                @endforeach
              @else
                <span><strong>2</strong> Tipe Armada</span>
                <span><strong>50+</strong> Unit Tersedia</span>
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
              <div style="width:100%;height:100%;background:linear-gradient(135deg, #7C3AED 0%, #5B21B6 100%);display:flex;align-items:center;justify-content:center;"><span style="font-size:6rem;opacity:0.3;">🚌</span></div>
            @endif
          </div>
        </div>
      </div>
    </section>

    <!-- Process -->
    @php $process = $pageSections['process'] ?? null; @endphp
    @if($process)
      <section id="proses" class="animate-on-scroll">
        <div class="container container--wide">
          <div class="section-head">
            <h2>{!! $process->title ?? 'Cara <span class="purple">Sewa</span>' !!}</h2>
            <p class="lede">{{ $process->subtitle ?? 'Proses penyewaan bus di PHD Trans mudah dan cepat.' }}</p>
          </div>
          @php $steps = $process->metadata ?? []; @endphp
          @if($steps && is_array($steps))
            <div class="process-grid">
              @foreach($steps as $i => $step)
                <div class="process-card animate-on-scroll" style="animation-delay:{{ $i * 100 }}ms;">
                  <div class="step-num">{{ $step['step'] ?? str_pad($i+1,2,'0',STR_PAD_LEFT) }}</div>
                  <h3>{{ $step['value'] ?? '' }}</h3>
                  <p>{{ $step['desc'] ?? '' }}</p>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </section>
    @endif

    <!-- FAQ -->
    @php $faq = $pageSections['faq'] ?? null; @endphp
    @if($faq && $faq->metadata)
      <section id="faq" class="animate-on-scroll">
        <div class="container container--wide">
          <div class="section-head">
            <h2>{!! $faq->title ?? 'Pertanyaan <span class="purple">Umum</span>' !!}</h2>
            <p class="lede">{{ $faq->subtitle ?? 'Jawaban cepat untuk pertanyaan yang sering diajukan.' }}</p>
          </div>
          <div class="faq-grid">
            @foreach($faq->metadata as $item)
              <div class="faq-card">
                <h3>{{ $item['q'] ?? '' }}</h3>
                <p>{{ $item['a'] ?? '' }}</p>
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
        <span class="label" style="color: rgba(244,244,240,0.6);">{{ $closing->subtitle ?? 'Booking · ' . date('Y') }}</span>
        <h2>{!! $closing->title ?? 'Ada pertanyaan<br/>lain? Tanya<br/>kami saja.' !!}</h2>
        <p class="lede">
          @if($closing && $closing->description)
            {!! $closing->description !!}
          @else
            Tim kami siap membantu Anda memilih armada yang tepat dan menjawab semua pertanyaan Anda.
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
