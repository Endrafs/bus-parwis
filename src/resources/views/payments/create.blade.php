<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Upload Pembayaran — {{ $booking->kode_booking }} — PHD Trans</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Boldonse&family=Inter+Tight:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @include('partials.public-header')

  <main id="main">
    <section class="snug">
      <div class="container container--narrow">
        <a href="{{ route('booking.show', $booking->kode_booking) }}" style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-sm);display:inline-flex;align-items:center;gap:var(--space-2);margin-bottom:var(--space-6);">
          <svg width="14" height="10" viewBox="0 0 14 10" fill="none" style="transform:rotate(180deg);"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Kembali
        </a>

        <div style="text-align:center;margin-bottom:var(--space-7);">
          <span class="eyebrow" style="display:inline-flex;"><span class="dot" aria-hidden="true"></span>Pembayaran</span>
          <h2 style="margin-top:var(--space-3);">Upload <span class="purple">Pembayaran</span></h2>
          <p style="color:var(--fg-soft);">Booking: <strong>{{ $booking->kode_booking }}</strong> — Total: <strong style="color:var(--purple);">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></p>
        </div>

        @if ($errors->any())
          <div style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);border-radius:var(--radius);padding:var(--space-4);margin-bottom:var(--space-5);">
            <ul style="color:#F87171;font-size:var(--text-sm);margin:0;padding-left:var(--space-5);">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- Bank Info -->
        <div class="glass-purple liquid-glow" style="padding:var(--space-5);margin-bottom:var(--space-6);">
          <h4 style="font-size:var(--text-base);margin-bottom:var(--space-2);">🏦 Info Pembayaran</h4>
          <p style="color:var(--fg-soft);font-size:var(--text-sm);margin-bottom:var(--space-3);">Silakan transfer ke rekening berikut:</p>
          <div style="background:var(--ink-000);border-radius:var(--radius);padding:var(--space-4);">
            <p style="font-family:var(--font-mono);font-weight:700;font-size:var(--text-lg);color:var(--purple);white-space:pre-line;">{{ $websiteSettings->rekening_bank ?? 'BCA 1234567890 a.n. PHD Trans' }}</p>
            @if($websiteSettings && $websiteSettings->nomor_whatsapp)
              <p style="color:var(--fg-mute);font-size:var(--text-sm);margin-top:var(--space-2);">WhatsApp: {{ $websiteSettings->nomor_whatsapp }}</p>
            @endif
          </div>
          <p style="color:var(--fg-mute);font-size:var(--text-xs);margin-top:var(--space-2);">Setelah transfer, upload bukti transfer di form bawah.</p>
        </div>

        <!-- Upload Form -->
        <form method="POST" action="{{ route('payment.store', $booking->kode_booking) }}" enctype="multipart/form-data" class="form-card glass" style="padding:var(--space-6);">
          @csrf

          <div class="form-row form-row--full">
            <div class="form-field">
              <label>Jenis Pembayaran *</label>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-3);">
                <label style="display:flex;align-items:center;gap:var(--space-3);padding:var(--space-4);border:2px solid var(--rule);border-radius:var(--radius);cursor:pointer;transition:border-color var(--dur-fast);" class="{{ $booking->dp_sudah_dibayar ? 'opacity-50' : '' }}">
                  <input type="radio" name="jenis_pembayaran" value="DP" {{ $booking->dp_sudah_dibayar ? 'disabled' : (old('jenis_pembayaran', $booking->dp_sudah_dibayar ? 'Pelunasan' : 'DP') === 'DP' ? 'checked' : '') }} style="accent-color:var(--purple);" required>
                  <div>
                    <p style="font-weight:600;">DP</p>
                    <p style="color:var(--fg-mute);font-size:var(--text-xs);">Uang Muka</p>
                  </div>
                </label>
                <label style="display:flex;align-items:center;gap:var(--space-3);padding:var(--space-4);border:2px solid var(--rule);border-radius:var(--radius);cursor:pointer;transition:border-color var(--dur-fast);{{ $booking->dp_sudah_dibayar ? 'border-color:var(--purple);background:rgba(124,58,237,0.08);' : '' }}">
                  <input type="radio" name="jenis_pembayaran" value="Pelunasan" {{ old('jenis_pembayaran', $booking->dp_sudah_dibayar ? 'Pelunasan' : '') === 'Pelunasan' ? 'checked' : '' }} style="accent-color:var(--purple);" required>
                  <div>
                    <p style="font-weight:600;">Pelunasan</p>
                    <p style="color:var(--fg-mute);font-size:var(--text-xs);">Lunas</p>
                  </div>
                </label>
              </div>
              @error('jenis_pembayaran')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Info sisa bayar jika DP sudah dibayar -->
          @if($booking->dp_sudah_dibayar)
          <div style="background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);border-radius:var(--radius);padding:var(--space-4);margin-bottom:var(--space-5);">
            <div style="display:flex;justify-content:space-between;font-size:var(--text-sm);margin-bottom:var(--space-1);">
              <span style="color:var(--fg-soft);">Total Harga</span>
              <span style="font-weight:600;">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:var(--text-sm);margin-bottom:var(--space-1);">
              <span style="color:var(--fg-soft);">Sudah Dibayar (DP)</span>
              <span style="font-weight:600;color:var(--purple);">Rp {{ number_format($booking->total_dibayar, 0, ',', '.') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:var(--text-sm);border-top:1px solid var(--rule);padding-top:var(--space-2);margin-top:var(--space-2);">
              <span style="color:var(--fg-soft);font-weight:500;">Sisa yang Harus Dibayar</span>
              <span style="font-weight:700;color:#F87171;font-size:var(--text-base);">Rp {{ number_format($booking->sisa_pembayaran, 0, ',', '.') }}</span>
            </div>
          </div>
          @endif

          <div class="form-row">
            <div class="form-field">
              <label for="nominal">Nominal Transfer *</label>
              <input type="number" name="nominal" id="nominal"
                     value="{{ old('nominal', $booking->dp_sudah_dibayar ? $booking->sisa_pembayaran : '') }}"
                     placeholder="Masukkan jumlah"
                     required />
              @if($booking->dp_sudah_dibayar)
                <small style="color:var(--fg-soft);font-weight:500;">Sisa pelunasan: <strong style="color:#F87171;">Rp {{ number_format($booking->sisa_pembayaran, 0, ',', '.') }}</strong></small>
              @else
                <small style="color:var(--fg-mute);">Total booking: Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</small>
              @endif
              @error('nominal')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
              <label for="tanggal_bayar">Tanggal Transfer *</label>
              <input type="date" name="tanggal_bayar" id="tanggal_bayar"
                     value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                     max="{{ date('Y-m-d') }}"
                     required />
              @error('tanggal_bayar')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="form-row form-row--full">
            <div class="form-field">
              <label for="bukti_transfer">Upload Bukti Transfer *</label>
              <input type="file" name="bukti_transfer" id="bukti_transfer"
                     accept="image/jpeg,image/jpg,image/png"
                     required />
              <small style="color:var(--fg-mute);">Format: JPG/PNG, maks. 2MB</small>
              @error('bukti_transfer')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="form-row form-row--full">
            <div class="form-field">
              <label for="catatan">Catatan (opsional)</label>
              <textarea name="catatan" id="catatan" rows="2" placeholder="Info tambahan untuk admin...">{{ old('catatan') }}</textarea>
            </div>
          </div>

          <div class="form-actions" style="border-top:none;padding-top:0;">
            <small>Pastikan data yang diisi sudah benar</small>
            <button type="submit" class="btn btn--primary btn--lg">
              Submit Pembayaran
              <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
          </div>
        </form>
      </div>
    </section>
  </main>

  @include('partials.floating-contact')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
