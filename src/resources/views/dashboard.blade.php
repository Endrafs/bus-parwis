<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12" style="background:var(--ink-deep);min-height:100vh;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div style="background:var(--bg-card);border:1px solid var(--rule);border-radius:var(--radius-lg);padding:var(--space-6);">
        <div style="color:var(--fg);">
          <h3 style="font-size:var(--text-xl);margin-bottom:var(--space-4);">Selamat datang, {{ Auth::user()->name }}!</h3>
          <p style="color:var(--fg-soft);margin-bottom:var(--space-6);">Kelola pemesanan bus pariwisata Anda di sini.</p>

          <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:var(--space-5);">
            <a href="{{ route('home') }}" style="display:block;padding:var(--space-6);background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);border-radius:var(--radius-lg);transition:background var(--dur-fast);">
              <div style="font-size:3rem;margin-bottom:var(--space-2);">🚌</div>
              <h4 style="font-size:var(--text-lg);color:var(--fg);">Lihat Armada Bus</h4>
              <p style="color:var(--fg-soft);font-size:var(--text-sm);margin-top:var(--space-1);">Jelajahi armada bus yang tersedia untuk disewa.</p>
            </a>

            <a href="{{ route('booking.index') }}" style="display:block;padding:var(--space-6);background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.2);border-radius:var(--radius-lg);transition:background var(--dur-fast);">
              <div style="font-size:3rem;margin-bottom:var(--space-2);">📋</div>
              <h4 style="font-size:var(--text-lg);color:var(--fg);">Booking Saya</h4>
              <p style="color:var(--fg-soft);font-size:var(--text-sm);margin-top:var(--space-1);">Lihat riwayat dan status pemesanan Anda.</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
