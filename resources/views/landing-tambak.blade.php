@extends('layouts.app')

@section('body-class', 'landing-page')

@push('head')
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
@endpush

@push('styles')
<style>
  body.landing-page main.py-4 {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
  }

  body.landing-page {
    font-family: 'Poppins', sans-serif !important;
    overflow-x: hidden;
  }

  .hero-section {
    background-image: url('/assets/image-hero.png');
    background-size: cover;
    background-position: center;
    min-height: 95vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    margin-bottom: 0;
  }

  .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
  }

  .hero-content {
    position: relative;
    z-index: 2;
    padding: 2rem;
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
    color: white;
  }

  .ratio iframe {
    border-radius: 8px;
  }

  .card-info {
    transition: background-color 0.3s ease;
  }

  .card-info:hover {
    background-color: rgba(0, 0, 0, 0.03);
  }

  /* Dark mode adjustments */
  body.dark-mode .landing-wrapper section:not(.hero-section):not(.section-footer) {
    background-color: #1f1f1f !important;
    color: #f1f1f1;
  }

  body.dark-mode .landing-wrapper h1,
  body.dark-mode .landing-wrapper h2,
  body.dark-mode .landing-wrapper h3,
  body.dark-mode .landing-wrapper h4,
  body.dark-mode .landing-wrapper p,
  body.dark-mode .landing-wrapper li {
    color: #f1f1f1 !important;
  }

  body.dark-mode .btn-light {
    background-color: #f1f1f1;
    color: #111;
  }

  body.dark-mode .bg-success-subtle {
    background-color: #043d2b !important;
    color: #e0f8ee;
  }

  .section-footer {
    background-color: var(--bs-primary);
    margin-bottom: 0;
  }

  body.dark-mode .section-footer {
    background-color: var(--bs-primary) !important;
    color: #fff;
  }

  body.dark-mode .section-footer a.btn-light {
    background-color: #f1f1f1 !important;
    color: #111 !important;
  }

  /* Kartu interaktif (light & dark mode) */
.card-interaktif {
  background: #ffffff;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 0.75rem;
}

.card-interaktif:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
}

/* Versi dark mode */
body.dark-mode .card-interaktif {
  background: linear-gradient(145deg, #1e1e1e, #2a2a2a) !important;
  color: #f1f1f1 !important;
}

body.dark-mode .card-interaktif:hover {
  background: linear-gradient(145deg, #2a2a2a, #1e1e1e) !important;
  box-shadow: 0 12px 25px rgba(255, 255, 255, 0.05) !important;
}


.card-interaktif {
  transition: background 0.5s ease, color 0.5s ease;
}


.image-combo-wrapper {
  position: relative;
  width: 100%;
  aspect-ratio: 6 / 3; /* Gambar tetap proporsional */
  overflow: hidden;
}

.img-combo {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: opacity 0.6s ease-in-out, transform 0.3s ease;
  border-radius: 10px;
}

.first-img {
  z-index: 1;
  opacity: 1;
}

.second-img {
  z-index: 2;
  opacity: 0;
}

/* Saat hover, tampilkan gambar kedua */
.image-combo-wrapper:hover .first-img {
  opacity: 0;
}

.image-combo-wrapper:hover .second-img {
  opacity: 1;
  transform: scale(1.05);
  z-index: 3;
}

.fade-in {
  animation: fadeInUp 1s ease-out forwards;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}


.fade-section {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.8s ease, transform 0.8s ease;
  will-change: opacity, transform;
}

.fade-section.in-view {
  opacity: 1;
  transform: translateY(0);
}

.fade-section.out-view {
  opacity: 0;
  transform: translateY(-20px);
}

@media (max-width: 768px) {
  .image-combo-wrapper {
    aspect-ratio: 4 / 3;
  }

  .hero-content h1 {
    font-size: 2rem;
  }

  .hero-content p {
    font-size: 1rem;
  }
}

/* Gaya gambar modern tanpa border radius besar */
.modern-image-wrapper {
  position: relative;
  width: 100%;
  aspect-ratio: 16 / 9;
  overflow: hidden;
}

.modern-image-wrapper .image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: opacity 0.5s ease-in-out, transform 0.3s ease;
  border-radius: 4px; /* Modern minimal rounding */
}

.modern-image-wrapper .main-img {
  opacity: 1;
  z-index: 1;
}

.modern-image-wrapper .hover-img {
  opacity: 0;
  z-index: 2;
}

/* Efek saat disorot */
.modern-image-wrapper:hover .main-img {
  opacity: 0;
}

.modern-image-wrapper:hover .hover-img {
  opacity: 1;
  transform: scale(1.05);
}

.auto-image-slider {
  position: relative;
  width: 100%;
  aspect-ratio: 16 / 9;
  overflow: hidden;
}

.slider-img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0;
  transition: opacity 1s ease-in-out;
  z-index: 1;
  border-radius: 4px;
}

.slider-img.active {
  opacity: 1;
  z-index: 2;
}

/* Auto-slider (sudah ada sebelumnya, pastikan ini dimuat) */
.auto-image-slider {
  position: relative;
  width: 100%;
  aspect-ratio: 16 / 9;
  overflow: hidden;
  border-radius: 0.5rem;
}

.slider-img {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0;
  transition: opacity 1s ease-in-out;
}

.slider-img.active {
  opacity: 1;
  z-index: 1;
}

/* Mode light (default) */
.text-heading {
  color: #212529; /* warna gelap */
}

.text-body {
  color: #343a40; /* abu gelap */
}

/* Mode dark */
body.dark-mode .text-heading {
  color: #f1f1f1 !important;
}

body.dark-mode .text-body {
  color: #e0e0e0 !important;
}


.card-pemancingan {
  background-color: #2b2b2b;
  border-left: 5px solid #ffc107;
  border-radius: 0.75rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  color: #f8f9fa;
}

.card-pemancingan:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 25px rgba(255, 193, 7, 0.3);
}

/* Light mode fix */
body:not(.dark-mode) .card-pemancingan {
  background-color: #fff;
  color: #212529;
}


.card-pemancingan p {
  color: inherit; /* ikuti mode sekarang */
  font-weight: 500;
}


/* Versi light mode (default) */
.card-pemancingan {
  background-color: #f8f9fa;
  color: #212529;
  border-left: 5px solid #ffc107;
  border-radius: 0.5rem;
  transition: background-color 0.3s ease, color 0.3s ease;
}

/* Versi dark mode */
body.dark-mode .card-pemancingan {
  background-color: #2b2b2b !important;
  color: #f1f1f1 !important;
}


.interactive-image img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  transition: opacity 1s ease-in-out;
}

</style>
@endpush

@section('content')
<div class="landing-wrapper">

  <section class="hero-section py-5 fade-section">
    <div class="hero-overlay"></div>
    <div class="hero-content container">
      <h1 class="display-4 fw-bold">Tambak Tradisional Kami</h1>
      <p class="lead">Budidaya Udang Vaname & Ikan Mujaer dengan Perawatan Alami</p>
      <a href="#budidaya" class="btn btn-light mt-3">Lihat Detail Budidaya</a>
    </div>
  </section>

  <section class="py-5 fade-section">
  <div class="container text-center">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm card-interaktif">
          <div class="card-body">
            <h5 class="card-title text-primary">Sistem Tradisional</h5>
            <p class="card-text">Mengandalkan metode alami dan pengalaman lokal.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm card-interaktif">
          <div class="card-body">
            <h5 class="card-title text-success">Kualitas Terpantau</h5>
            <p class="card-text">Terintegrasi sistem pemantauan pH, suhu, dan kekeruhan.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm card-interaktif">
          <div class="card-body">
            <h5 class="card-title text-warning">Siap Panen Berkala</h5>
            <p class="card-text">Panen udang & mujaer secara berkala untuk suplai lokal.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <section id="budidaya" class="py-5 fade-section">
    <div class="container">
      <div class="row align-items-center g-4">
        <!-- Gambar -->
        <div class="col-md-6">
          <div class="auto-image-slider">
            <img  src="/assets/mujaer.png" alt="Mujaer" class="slider-img active">
            <img src="/assets/udang.jpg" alt="Udang" class="slider-img">
            <img src="/assets/jala.jpg" alt="jala" class="slider-img">
            <img src="/assets/pirik.png" alt="pirikan" class="slider-img">
          </div>
        </div>


        <!-- Deskripsi -->
        <div class="col-md-6">
          <h3 class="text-body">Tentang Budidaya Kami</h3>
          <p class="text-body">
            Kami membudidayakan <strong>udang Vaname</strong> dan <strong>ikan mujaer</strong> secara tradisional di tambak
            air tawar Sidoarjo dengan sistem pengelolaan manual namun terpantau digital.
          </p>
          <ul class="list-unstyled text-body">
            <li>✅ Panen udang rata-rata 350 kg per siklus</li>
            <li>✅ Mujaer siap konsumsi lokal ± 250 kg per panen</li>
            <li>✅ Kualitas air dipantau otomatis melalui dashboard</li>
          </ul>
        </div>
      </div>
    </div>
  </section>


  <section class="py-5 fade-section">
    <div class="container">
      <h3 class="text-center mb-4">Lokasi Tambak Kami</h3>
      <p class="text-center">Tambak terletak di Dusun Bangunsari, Kecamatan Jabon, Sidoarjo</p>
      <div class="ratio ratio-16x9">
        <iframe
          width="100%"
          height="350"
          frameborder="0"
          style="border:0"
          src="https://www.google.com/maps?q=-7.539056,112.789028&hl=id&z=18&output=embed"
          allowfullscreen>
        </iframe>
      </div>
    </div>
  </section>

  <section id="pemancingan" class="py-5 fade-section">
    <div class="container">
      <div class="row align-items-center g-4">
        
        <!-- Gambar Interaktif -->
        <div class="col-md-6">
          <div class="interactive-image rounded overflow-hidden">
            <img id="carouselImage" src="{{ asset('/assets/IMG1.jpg') }}" class="img-fluid" alt="Pemancingan">
          </div>
        </div>

        <!-- Deskripsi Pemancingan -->
        <div class="col-md-6">
          <div class="card-pemancingan p-4 shadow fade-section">
            <h2 class="text-warning mb-3">🎣 Pemancingan Harian Bangunsari</h2>
            <p class="mb-2">
              Nikmati serunya memancing ikan segar langsung dari tambak kami hanya dengan 
              <strong class="text-warning">Rp. 25.000/kg</strong>!
            </p>
            <p class="mb-2">🗓️ Buka Setiap Hari — Datang kapan saja, bawa pulang hasilnya!</p>
            <p class="mb-2">📍 Lokasi strategis: Dusun Bangunsari, Jabon, Sidoarjo</p>
            <p class="mb-2">📞 <strong>0857-0717-8918</strong> — Hubungi kami sekarang juga!</p>
            <a href="https://wa.me/6285707178918" target="_blank" class="btn btn-success mt-3">
              💬 Chat Sekarang via WhatsApp
            </a>

          </div>
        </div>
      </div>
    </div>
  </section>



  <section class="section-footer text-white py-5" style="background-color: #222;">
    <div class="container">
      <div class="row text-center text-md-start">
        <div class="col-md-4 mb-4">
          <h5 class="text-warning">🌿 TambakKita</h5>
          <p class="small">Budidaya Udang & Ikan Mujaer di Sidoarjo secara tradisional & digital.</p>
        </div>
        <div class="col-md-4 mb-4">
          <h6>Link Cepat</h6>
          <ul class="list-unstyled">
            <li><a href="#budidaya" class="text-light">Budidaya</a></li>
            <li><a href="#pemancingan" class="text-light">Pemancingan</a></li>
            <li><a href="https://wa.me/6285707178918" class="text-light">Hubungi Kami</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h6>Kontak</h6>
          <p class="small mb-1">📞 0857-0717-8918</p>
          <p class="small">📍 Jabon, Sidoarjo</p>
        </div>
      </div>
      <div class="text-center mt-4 small text-muted">
        &copy; 2025 TambakKita. All rights reserved.
      </div>
    </div>
  </section>


</div>

<script>

  document.addEventListener("DOMContentLoaded", function () {
    const hero = document.querySelector(".hero-section");
    if (hero) {
      hero.classList.add("fade-in");
    }
  });



document.addEventListener("DOMContentLoaded", function () {
  // Fade section animation
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      const el = entry.target;
      if (entry.isIntersecting) {
        el.classList.add("in-view");
        el.classList.remove("out-view");
      } else {
        el.classList.add("out-view");
        el.classList.remove("in-view");
      }
    });
  }, { threshold: 0.15 });

  document.querySelectorAll(".fade-section").forEach((section) => {
    observer.observe(section);
  });

  // Dark mode toggle
  const themeSwitch = document.getElementById("themeSwitch");
  if (themeSwitch) {
    themeSwitch.addEventListener("change", function () {
      document.body.classList.toggle("dark-mode", this.checked);
      localStorage.setItem("dark-mode", this.checked ? "yes" : "no");
    });

    const savedTheme = localStorage.getItem("dark-mode");
    const isDark = savedTheme === "yes";
    document.body.classList.toggle("dark-mode", isDark);
    themeSwitch.checked = isDark;
  }

  // Carousel gambar pemancingan
  const imagePaths = [
    "{{ asset('/assets/IMG1.jpg') }}",
    "{{ asset('/assets/IMG2.jpg') }}",
    "{{ asset('/assets/IMG3.jpg') }}",
    "{{ asset('/assets/IMG4.jpg') }}"
  ];

  let currentImageIndex = 0;
  const imageElement = document.getElementById("carouselImage");

  if (imageElement) {
    setInterval(() => {
      currentImageIndex = (currentImageIndex + 1) % imagePaths.length;
      imageElement.style.opacity = 0;
      setTimeout(() => {
        imageElement.src = imagePaths[currentImageIndex];
        imageElement.style.opacity = 1;
      }, 500);
    }, 3000);
  }
});

document.addEventListener("DOMContentLoaded", function () {
  // Auto-slider untuk semua .auto-image-slider
  const sliders = document.querySelectorAll(".auto-image-slider");

  sliders.forEach(slider => {
    const images = slider.querySelectorAll(".slider-img");
    let current = 0;

    if (images.length > 1) {
      setInterval(() => {
        images[current].classList.remove("active");
        current = (current + 1) % images.length;
        images[current].classList.add("active");
      }, 4000);
    }
  });
});
</script>

@endsection
