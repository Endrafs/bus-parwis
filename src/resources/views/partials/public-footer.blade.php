<footer class="site-footer">
  <div class="container container--wide">
    <div class="footer-top">
      <div class="footer-brand">
        <span class="brand"><span class="brand-mark" aria-hidden="true"></span> PHD Trans</span>
        <p>Penyedia layanan penyewaan bus pariwisata terpercaya sejak 2015. Armada lengkap, harga transparan, pelayanan profesional.</p>
        <span class="label">Senin — Sabtu · 08:00 – 20:00</span>
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
      <span>© {{ date('Y') }} PHD Trans · All rights reserved.</span>
      <div class="footer-meta-links">
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
      </div>
    </div>
  </div>
</footer>
