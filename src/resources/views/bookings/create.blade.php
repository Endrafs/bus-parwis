<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Pesan {{ $bus->nama_bus }} — PHD Trans</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter+Tight:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @include('partials.public-header')

  <main id="main">
    <section class="snug">
      <div class="container container--narrow">
        <a href="{{ route('bus.show', $bus) }}" style="color:var(--fg-mute);font-family:var(--font-mono);font-size:var(--text-sm);display:inline-flex;align-items:center;gap:var(--space-2);margin-bottom:var(--space-6);">
          <svg width="14" height="10" viewBox="0 0 14 10" fill="none" style="transform:rotate(180deg);"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Kembali
        </a>

        <div style="text-align:center;margin-bottom:var(--space-7);">
          <span class="eyebrow" style="display:inline-flex;"><span class="dot" aria-hidden="true"></span>Form Pemesanan</span>
          <h2 style="margin-top:var(--space-3);">Pesan <span class="purple">{{ $bus->nama_bus }}</span></h2>
        </div>

        <!-- Bus Summary -->
        <div class="glass liquid-glow summary-card" style="margin-bottom:var(--space-6);">
          <div class="summary-icon">🚌</div>
          <div class="summary-text">
            <h3>{{ $bus->nama_bus }}</h3>
            <p>{{ $bus->kategori_bus }} · {{ $bus->tipe_bus }} · {{ $bus->kapasitas }} orang</p>
            <p style="font-weight:500;color:var(--purple);">Rp {{ number_format($bus->harga_sewa, 0, ',', '.') }} / hari</p>
          </div>
        </div>

        <!-- Flash Messages -->
        @if(session('error'))
          <div style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);border-radius:var(--radius);padding:var(--space-4);margin-bottom:var(--space-5);">
            <p style="color:#F87171;">{{ session('error') }}</p>
          </div>
        @endif

        <!-- Booking Form -->
        <form method="POST" action="{{ route('booking.store') }}" class="form-card glass" style="padding:var(--space-6);" x-data="bookingForm({{ $bus->harga_sewa }}, {{ json_encode([
            'biayaTol' => (float) ($websiteSettings?->biaya_tol_default ?? 0),
            'biayaSolar' => (float) ($websiteSettings?->biaya_solar_default ?? 0),
            'tipsCrew' => (float) ($websiteSettings?->tips_crew_default ?? 0),
            'biayaParkir' => (float) ($websiteSettings?->biaya_parkir_default ?? 0),
        ]) }})">
          @csrf
          <input type="hidden" name="bus_id" value="{{ $bus->id }}">

          <div class="form-row">
            <div class="form-field">
              <label for="tanggal_berangkat">Tanggal Berangkat *</label>
              <input type="date" name="tanggal_berangkat" id="tanggal_berangkat"
                     x-model="tanggalBerangkat" @change="hitung"
                     min="{{ date('Y-m-d') }}"
                     value="{{ old('tanggal_berangkat') }}"
                     required />
              @error('tanggal_berangkat')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
            <div class="form-field">
              <label for="tanggal_kembali">Tanggal Kembali *</label>
              <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                     x-model="tanggalKembali" @change="hitung"
                     min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                     value="{{ old('tanggal_kembali') }}"
                     required />
              @error('tanggal_kembali')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="form-row form-row--full">
            <div class="form-field">
              <label for="tujuan">Tujuan *</label>
              <select name="tujuan" id="tujuan"
                      x-model="selectedTujuan"
                      @change="onTujuanChange"
                      required>
                <option value="">— Pilih Tujuan —</option>
                @foreach($destinationPrices as $dp)
                  <option value="{{ $dp->nama_tujuan }}" data-harga="{{ $dp->harga }}"
                    {{ old('tujuan') == $dp->nama_tujuan ? 'selected' : '' }}>
                    {{ $dp->nama_tujuan }} — Rp {{ number_format($dp->harga, 0, ',', '.') }}
                  </option>
                @endforeach
                @if($destinationPrices->isEmpty())
                  <option value="" disabled>Belum ada data tujuan. Hubungi admin.</option>
                @endif
              </select>
              @error('tujuan')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="form-row form-row--full">
            <div class="form-field">
              <label for="catatan">Catatan (opsional)</label>
              <textarea name="catatan" id="catatan" rows="3"
                        placeholder="Tambahan informasi untuk admin...">{{ old('catatan') }}</textarea>
              @error('catatan')<span style="color:#F87171;font-size:var(--text-xs);">{{ $message }}</span>@enderror
            </div>
          </div>

          <!-- Price Summary -->
          <div class="price-summary" x-show="jumlahHari > 0" x-cloak>
            <div class="price-row">
              <span>Harga sewa unit (<span x-text="jumlahHari"></span> hari)</span>
              <span x-text="'Rp ' + formatRupiah(hargaPerHari * jumlahHari)"></span>
            </div>
            <div class="price-row" x-show="biayaTol > 0">
              <span>Biaya Tol</span>
              <span x-text="'Rp ' + formatRupiah(biayaTol)"></span>
            </div>
            <div class="price-row" x-show="biayaSolar > 0">
              <span>Biaya Solar</span>
              <span x-text="'Rp ' + formatRupiah(biayaSolar)"></span>
            </div>
            <div class="price-row" x-show="tipsCrew > 0">
              <span>Tips Crew Bus</span>
              <span x-text="'Rp ' + formatRupiah(tipsCrew)"></span>
            </div>
            <div class="price-row" x-show="biayaParkir > 0">
              <span>Biaya Parkir</span>
              <span x-text="'Rp ' + formatRupiah(biayaParkir)"></span>
            </div>
            <div class="price-row" x-show="biayaTujuan > 0">
              <span>Biaya Tujuan</span>
              <span x-text="'Rp ' + formatRupiah(biayaTujuan)"></span>
            </div>
            <div class="price-row price-row--total">
              <span>Total Estimasi</span>
              <span x-text="'Rp ' + formatRupiah(totalHarga)"></span>
            </div>
          </div>

          @error('bus_id')
            <span style="color:#F87171;font-size:var(--text-sm);">{{ $message }}</span>
          @enderror

          <div class="form-actions" style="border-top:none;padding-top:0;">
            <small>Dengan klik tombol, Anda setuju dengan syarat & ketentuan</small>
            <button type="submit" class="btn btn--primary btn--lg">
              Buat Pesanan
              <svg class="arrow" width="16" height="10" viewBox="0 0 14 10" fill="none" aria-hidden="true"><path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
          </div>
        </form>
      </div>
    </section>
  </main>

  @include('partials.public-footer')

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('bookingForm', (hargaPerHari, biayaTambahan = {}) => ({
        tanggalBerangkat: '{{ old('tanggal_berangkat') }}',
        tanggalKembali: '{{ old('tanggal_kembali') }}',
        jumlahHari: 0,
        totalHarga: 0,
        selectedTujuan: '{{ old('tujuan') }}',
        biayaTol: biayaTambahan.biayaTol || 0,
        biayaSolar: biayaTambahan.biayaSolar || 0,
        tipsCrew: biayaTambahan.tipsCrew || 0,
        biayaParkir: biayaTambahan.biayaParkir || 0,
        biayaTujuan: 0,
        hitung() {
          if (this.tanggalBerangkat && this.tanggalKembali) {
            const start = new Date(this.tanggalBerangkat);
            const end = new Date(this.tanggalKembali);
            const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            this.jumlahHari = diff > 0 ? diff : 0;
            this.totalHarga = (this.jumlahHari * hargaPerHari) + this.biayaTol + this.biayaSolar + this.tipsCrew + this.biayaParkir + this.biayaTujuan;
          } else {
            this.jumlahHari = 0;
            this.totalHarga = 0;
          }
        },
        onTujuanChange() {
          const select = document.getElementById('tujuan');
          const selectedOption = select.options[select.selectedIndex];
          const harga = selectedOption ? parseFloat(selectedOption.getAttribute('data-harga') || '0') : 0;
          this.biayaTujuan = isNaN(harga) ? 0 : harga;
          this.hitung();
        },
        formatRupiah(num) {
          return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
      }));
    });

    // On page load, set initial biayaTujuan if there's a pre-selected destination
    document.addEventListener('DOMContentLoaded', function() {
      const select = document.getElementById('tujuan');
      if (select && select.value) {
        const selectedOption = select.options[select.selectedIndex];
        const harga = selectedOption ? parseFloat(selectedOption.getAttribute('data-harga') || '0') : 0;
        // We need to set this on the Alpine component after it initializes
        setTimeout(() => {
          const event = new Event('change');
          select.dispatchEvent(event);
        }, 100);
      }
    });
  </script>

  <script>
    // Mobile drawer
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

</body>
</html>
