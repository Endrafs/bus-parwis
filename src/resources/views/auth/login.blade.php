<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login — PHD Trans</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Boldonse&family=Inter+Tight:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:var(--bg);min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:var(--space-5);">
  <div style="width:100%;max-width:440px;">
    <div style="text-align:center;margin-bottom:var(--space-7);">
      <a href="{{ route('home') }}" class="brand" style="display:inline-flex;font-size:var(--text-2xl);justify-content:center;"><span class="brand-mark" aria-hidden="true"></span> PHD Trans</a>
    </div>

    <div class="form-card">
      <div style="text-align:center;margin-bottom:var(--space-5);">
        <h3 style="font-size:var(--text-xl);">Masuk</h3>
        <p style="color:var(--fg-soft);font-size:var(--text-sm);margin-top:var(--space-1);">Masuk ke akun Anda untuk mulai memesan.</p>
      </div>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-field" style="margin-bottom:var(--space-4);">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" placeholder="email@anda.com" value="{{ old('email') }}" required autofocus />
          @error('email')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
        </div>

        <div class="form-field" style="margin-bottom:var(--space-4);">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="••••••••" required />
          @error('password')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
        </div>

        <div style="display:flex;align-items:center;gap:var(--space-3);margin-bottom:var(--space-5);">
          <input type="checkbox" name="remember" id="remember" style="accent-color:var(--purple);width:16px;height:16px;">
          <label for="remember" style="color:var(--fg-soft);font-size:var(--text-sm);">Ingat saya</label>
        </div>

        <div class="form-actions" style="flex-direction:column;border-top:none;padding-top:0;">
          <button type="submit" class="btn btn--primary btn--lg" style="width:100%;justify-content:center;">
            Masuk
            <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" style="color:var(--fg-mute);font-size:var(--text-sm);">Lupa password?</a>
          @endif
        </div>
      </form>

      <hr class="divider" />
      <p style="text-align:center;color:var(--fg-soft);font-size:var(--text-sm);">
        Belum punya akun? <a href="{{ route('register') }}" style="color:var(--purple);font-weight:500;">Daftar</a>
      </p>
    </div>
  </div>
</body>
</html>
