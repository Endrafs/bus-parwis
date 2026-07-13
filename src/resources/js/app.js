import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// =============================================
// Scroll-Reveal Animation (Intersection Observer)
// =============================================
document.addEventListener('DOMContentLoaded', () => {
  // Mark html element for CSS to detect JS is running
  document.documentElement.classList.add('js');

  // Page fade-in transition
  document.body.classList.add('page-ready');

  // Skip if user prefers reduced motion
  const motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
  if (motionQuery.matches) return;

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          // Once visible, stop observing
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.15,
      rootMargin: '0px 0px -40px 0px',
    }
  );

  document.querySelectorAll('.animate-on-scroll, .stagger-children').forEach((el) => {
    observer.observe(el);
  });

  // Navbar glass effect on scroll
  const header = document.querySelector('.site-header');
  if (header) {
    const updateHeader = () => {
      if (window.scrollY > 20) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    };
    window.addEventListener('scroll', updateHeader, { passive: true });
    updateHeader();
  }

  // Button mouse position for ripple
  document.querySelectorAll('.btn').forEach((btn) => {
    btn.addEventListener('mousemove', (e) => {
      const rect = btn.getBoundingClientRect();
      const x = ((e.clientX - rect.left) / rect.width) * 100;
      const y = ((e.clientY - rect.top) / rect.height) * 100;
      btn.style.setProperty('--x', `${x}%`);
      btn.style.setProperty('--y', `${y}%`);
    });
  });

  // Video autoplay on hover (gallery items)
  document.querySelectorAll('.gallery-item video').forEach((video) => {
    video.addEventListener('mouseenter', () => {
      video.muted = true;
      video.play().catch(() => {});
    });
    video.addEventListener('mouseleave', () => {
      video.pause();
      video.currentTime = 0;
    });
  });

  // Smooth counter animation for stats
  document.querySelectorAll('.stat-num').forEach((el) => {
    const text = el.textContent.trim();
    const num = parseInt(text.replace(/[^0-9]/g, ''));
    if (!isNaN(num) && num > 0) {
      el.setAttribute('data-target', num);
      el.setAttribute('data-suffix', text.replace(/[0-9]/g, ''));
    }
  });
});
