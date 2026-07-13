<header class="site-header glass-nav">
  <div class="container container--wide">
    <nav class="nav" aria-label="Primary">
      <a class="brand" href="{{ route('home') }}"><img src="{{ asset('images/logo_phd1.png') }}" alt="PHD Trans" class="brand-logo" /></a>
      <div class="nav-links" role="navigation">
        <a href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Armada</a>
        <a href="{{ route('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif>Tentang</a>
        <a href="{{ route('services') }}" @if(request()->routeIs('services')) aria-current="page" @endif>Layanan</a>
        <a href="{{ route('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif>Kontak</a>
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
