<footer class="site-footer">
  <div class="container container--wide">
    <div class="footer-top">
      <div class="footer-brand">
        <span class="brand"><img src="{{ asset('images/logo_phd2.png') }}" alt="PHD Trans" class="brand-logo" /></span>
        <p>Penyedia layanan penyewaan bus pariwisata terpercaya sejak 2015. Armada lengkap, harga transparan, pelayanan profesional.</p>
        @if(isset($websiteSettings) && $websiteSettings->nomor_whatsapp)
          <span class="label">{{ $websiteSettings->nomor_whatsapp }}</span>
        @else
          <span class="label">Senin — Sabtu · 08:00 – 20:00</span>
        @endif
      </div>
      <div>
        <h4>Layanan</h4>
        <ul>
          <li><a href="{{ route('home') }}">Armada</a></li>
          <li><a href="{{ route('services') }}">Cara Sewa</a></li>
          <li><a href="{{ route('services') }}#harga">Harga</a></li>
          <li><a href="{{ route('services') }}#faq">FAQ</a></li>
        </ul>
      </div>
      <div>
        <h4>Perusahaan</h4>
        <ul>
          <li><a href="{{ route('about') }}">Tentang</a></li>
          <li><a href="{{ route('contact') }}">Kontak</a></li>
          <li><a href="#">Syarat & Ketentuan</a></li>
          <li><a href="#">Kebijakan Privasi</a></li>
        </ul>
      </div>
      <div>
        <h4>Pelanggan</h4>
        <ul>
          <li><a href="{{ route('login') }}">Login</a></li>
          <li><a href="{{ route('register') }}">Daftar</a></li>
          <li><a href="{{ route('contact') }}">Bantuan</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© {{ date('Y') }} <img src="{{ asset('images/logo_phd2.png') }}" alt="PHD Trans" class="brand-logo-inline" /> · All rights reserved.</span>
      <div class="footer-meta-links">
        <a href="https://wa.me/{{ isset($websiteSettings) && $websiteSettings->nomor_whatsapp ? $websiteSettings->nomor_whatsapp : '628133433110' }}" target="_blank" rel="noopener" title="WhatsApp">💬 WhatsApp</a>
        <a href="https://www.tiktok.com/@phdtrans" target="_blank" rel="noopener" title="TikTok">🎵 TikTok</a>
        <a href="https://www.instagram.com/phd_trans/?hl=en" target="_blank" rel="noopener" title="Instagram">📸 Instagram</a>
      </div>
    </div>
  </div>
</footer>
