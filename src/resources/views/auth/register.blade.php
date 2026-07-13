<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Daftar — PHD Trans</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter+Tight:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:var(--bg);min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:var(--space-5);">
  <div style="width:100%;max-width:440px;">
    <div style="text-align:center;margin-bottom:var(--space-7);">
      <a href="{{ route('home') }}" class="brand" style="display:inline-flex;justify-content:center;"><img src="{{ asset('images/logo_phd1.png') }}" alt="PHD Trans" class="brand-logo" /></a>
    </div>

    <div class="form-card">
      <div style="text-align:center;margin-bottom:var(--space-5);">
        <h3 style="font-size:var(--text-xl);">Daftar Akun</h3>
        <p style="color:var(--fg-soft);font-size:var(--text-sm);margin-top:var(--space-1);">Buat akun untuk mulai memesan bus.</p>
      </div>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-field" style="margin-bottom:var(--space-4);">
          <label for="name">Nama Lengkap</label>
          <input type="text" name="name" id="name" placeholder="Nama Anda" value="{{ old('name') }}" required autofocus />
          @error('name')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
        </div>

        <div class="form-field" style="margin-bottom:var(--space-4);">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" placeholder="email@anda.com" value="{{ old('email') }}" required />
          @error('email')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
        </div>

        <div class="form-field" style="margin-bottom:var(--space-4);">
          <label for="nomor_whatsapp">No. WhatsApp</label>
          <input type="text" name="nomor_whatsapp" id="nomor_whatsapp" placeholder="+62 812-3456-7890" value="{{ old('nomor_whatsapp') }}" required />
          @error('nomor_whatsapp')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
        </div>

        <div class="form-field" style="margin-bottom:var(--space-4);">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Min. 8 karakter" required />
          @error('password')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
        </div>

        <div class="form-field" style="margin-bottom:var(--space-5);">
          <label for="password_confirmation">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password" required />
        </div>

        <div class="form-actions" style="flex-direction:column;border-top:none;padding-top:0;">
          <button type="submit" class="btn btn--primary btn--lg" style="width:100%;justify-content:center;">
            Daftar
            <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>
      </form>

      <hr class="divider" />
      <p style="text-align:center;color:var(--fg-soft);font-size:var(--text-sm);">
        Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--purple);font-weight:500;">Masuk</a>
      </p>
    </div>
  </div>
</body>
</html>
