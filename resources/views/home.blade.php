<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQUATOR - Budidaya Tambak Tradisional & Modern</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-blue: #0284c7;
            --dark-blue: #0369a1;
            --accent-cyan: #06b6d4;
            --bg-light: #f0fdf4; /* Aksen hijau lembut sesuai figma */
            --bg-page: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 8%;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 1px;
        }

        .brand img {
            width: 28px;
            height: 28px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .nav-menu a {
            color: #e2e8f0;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-menu a:hover {
            color: #38bdf8;
        }

        .nav-btn {
            background: #2563eb;
            color: #fff !important;
            padding: 8px 20px;
            border-radius: 6px;
        }

        /* SECTION HERO */
        .hero {
            min-height: 100vh;
            background: linear-gradient(rgba(10, 25, 40, 0.7), rgba(10, 25, 40, 0.75)), 
                        url("{{ asset('images/tambak-hero.jpg') }}") center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 120px 20px 60px;
            color: #fff;
        }

        .hero-tag {
            color: #38bdf8;
            font-size: 12px;
            letter-spacing: 2px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(36px, 5vw, 56px);
            font-weight: 700;
            margin-bottom: 16px;
        }

        .hero-subtitle {
            font-size: 18px;
            font-weight: 400;
            color: #e2e8f0;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .hero-desc {
            max-width: 580px;
            color: #94a3b8;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .btn-wrap {
            display: flex;
            gap: 16px;
        }

        .btn-fill {
            background: #0284c7;
            color: #fff;
            padding: 12px 26px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-fill:hover {
            background: #0369a1;
        }

        .btn-line {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 12px 26px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            backdrop-filter: blur(4px);
            transition: 0.2s;
        }

        .btn-line:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: #fff;
        }

        /* LAYOUT UMUM SECTION */
        .section-container {
            max-width: 1160px;
            margin: auto;
            padding: 90px 24px;
        }

        .badge-sub {
            color: #0d9488;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 12px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 20px;
            line-height: 1.25;
        }

        /* 1. TENTANG KAMI */
        .grid-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .split-text p {
            color: #475569;
            font-size: 14.5px;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .split-img-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .split-img-card img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            display: block;
        }

        .floating-pill {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: #0284c7;
            color: #fff;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* 2. KEUNGGULAN KAMI */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-top: 40px;
        }

        .feat-card {
            background: #fff;
            border-radius: 16px;
            padding: 28px;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: 1px solid #f1f5f9;
        }

        .feat-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #e0f2fe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #0284c7;
            flex-shrink: 0;
        }

        .feat-info h4 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #0f172a;
        }

        .feat-info p {
            font-size: 13.5px;
            color: #64748b;
            line-height: 1.5;
        }

        .feat-num {
            position: absolute;
            right: 24px;
            top: 16px;
            font-size: 34px;
            font-weight: 800;
            color: #e2e8f0;
        }

        /* 3. DARI TAMBAK KAMI (GALERI) */
        .gallery-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }

        .gal-big {
            height: 380px;
            position: relative;
            border-radius: 14px;
            overflow: hidden;
        }

        .gal-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .gal-small {
            height: 180px;
            position: relative;
            border-radius: 14px;
            overflow: hidden;
        }

        .gal-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gal-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 16px 20px;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: #fff;
        }

        .gal-tag {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #cbd5e1;
        }

        .gal-title {
            font-size: 16px;
            font-weight: 600;
        }

        /* 4. STATISTIK BUDIDAYA */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            text-align: center;
            gap: 30px;
            margin: 50px 0 25px;
        }

        .stat-val {
            font-size: 44px;
            font-weight: 800;
            color: #0284c7;
            font-family: 'Playfair Display', serif;
        }

        .stat-label {
            font-size: 13.5px;
            color: #64748b;
            margin-top: 6px;
        }

        /* 5. PROSES DENGAN INDIKATOR NOMOR BULAT */
        .process-list {
            display: flex;
            flex-direction: column;
            gap: 24px;
            margin-top: 24px;
        }

        .process-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .num-circle {
            width: 36px;
            height: 36px;
            background: #0284c7;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .num-circle.orange {
            background: #f97316;
        }

        .process-text h5 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #0f172a;
        }

        .process-text p {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
        }

        /* 6. LOKASI & MAPS */
        .location-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }

        .map-wrapper {
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            height: 360px;
            border: 1px solid #e2e8f0;
        }

        .map-wrapper iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .loc-cards {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .loc-card {
            background: #fff;
            padding: 24px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
        }

        .loc-head {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .btn-wa {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #22c55e;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-top: 14px;
        }

        /* 7. BANNER PEMANCINGAN */
        .fish-banner {
            border-radius: 16px;
            overflow: hidden;
            background: linear-gradient(rgba(10, 20, 30, 0.75), rgba(10, 20, 30, 0.75)), 
                        url("{{ asset('images/ikan.jpg') }}") center/cover no-repeat;
            color: #fff;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 50px;
        }

        .price-tag {
            text-align: right;
        }

        .price-num {
            font-size: 40px;
            font-weight: 800;
        }

        /* FOOTER */
        footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 70px 8% 30px;
            margin-top: 60px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-col h5 {
            color: #fff;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-col a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 13.5px;
            transition: 0.2s;
        }

        .footer-col a:hover {
            color: #38bdf8;
        }

        .copyright {
            text-align: center;
            font-size: 12.5px;
            border-top: 1px solid #1e293b;
            padding-top: 24px;
            color: #64748b;
        }

        @media (max-width: 900px) {
            .grid-split, .gallery-grid, .location-grid, .footer-grid {
                grid-template-columns: 1fr;
            }
            .feature-grid, .stats-grid {
                grid-template-columns: 1fr;
            }
            .fish-banner {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
            .price-tag {
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="Aquator">
            <span>AQUATOR</span>
        </div>
        <ul class="nav-menu">
            <li><a href="{{ url('/home') }}">Dashboard</a></li>
            <li><a href="#laporan">Laporan</a></li>
            <li><a href="#" class="nav-btn">Home</a></li>
        </ul>
    </nav>

    <!-- HERO SECTION -->
    <header class="hero">
        <span class="hero-tag">Tentang Tambak Kami</span>
        <h1 class="hero-title">Tambak Tradisional Kami</h1>
        <p class="hero-subtitle">Budidaya Udang Vaname & Ikan Mujaer<br>dengan Perawatan Alami</p>
        <p class="hero-desc">Memadukan pengalaman budidaya tradisional dengan pemantauan kualitas air berbasis digital.</p>
        <div class="btn-wrap">
            <a href="#budidaya" class="btn-fill">Lihat Budidaya Kami</a>
            <a href="#kontak" class="btn-line">Hubungi Kami</a>
        </div>
    </header>

    <!-- SECTION 1: TENTANG KAMI -->
    <section class="section-container">
        <div class="grid-split">
            <div class="split-text">
                <span class="badge-sub">Tentang Kami</span>
                <h2 class="section-title">Tradisional dalam Cara,<br>Modern dalam Pemantauan.</h2>
                <p>Kami membudidayakan udang Vaname dan ikan mujaer secara tradisional di tambak air tawar Sidoarjo dengan sistem pengelolaan manual namun terpantau digital.</p>
                <p>Kami tetap mengandalkan pengalaman lokal dan metode alami dalam perawatan tambak, sementara teknologi digunakan untuk membantu memastikan kondisi air tetap terpantau secara berkala.</p>
            </div>
            <div class="split-img-card">
                <img src="{{ asset('images/tentang-tambak.jpg') }}" alt="Tambak Sidoarjo">
                <span class="floating-pill">TRADISIONAL × DIGITAL</span>
            </div>
        </div>
    </section>

    <!-- SECTION 2: KEUNGGULAN KAMI -->
    <section class="section-container" style="padding-top: 0;">
        <div style="text-align: center; max-width: 600px; margin: auto;">
            <span class="badge-sub">Tambak Bangunsari</span>
            <h2 class="section-title">Keunggulan Kami</h2>
        </div>
        
        <div class="feature-grid">
            <div class="feat-card">
                <div class="feat-icon-box"><i class="bi bi-flower1"></i></div>
                <div class="feat-info">
                    <h4>Sistem Tradisional</h4>
                    <p>Budidaya udang dan ikan dengan metode alami yang menjaga keseimbangan ekosistem tambak.</p>
                </div>
                <span class="feat-num">01</span>
            </div>

            <div class="feat-card">
                <div class="feat-icon-box"><i class="bi bi-display"></i></div>
                <div class="feat-info">
                    <h4>Monitoring Kualitas Air</h4>
                    <p>Memantau nilai pH, suhu, TDS dan kekeruhan air secara real-time melalui website.</p>
                </div>
                <span class="feat-num">02</span>
            </div>

            <div class="feat-card">
                <div class="feat-icon-box"><i class="bi bi-bell"></i></div>
                <div class="feat-info">
                    <h4>Pemantauan Lebih Teratur</h4>
                    <p>Analisis AI membantu mendeteksi pola perubahan air dan memberikan rekomendasi tindakan yang tepat.</p>
                </div>
                <span class="feat-num">03</span>
            </div>

            <div class="feat-card">
                <div class="feat-icon-box"><i class="bi bi-water"></i></div>
                <div class="feat-info">
                    <h4>Siap Panen Berkala</h4>
                    <p>Kualitas air yang terjaga membantu mendukung pertumbuhan udang dan ikan hingga masa panen.</p>
                </div>
                <span class="feat-num">04</span>
            </div>
        </div>
    </section>

    <!-- SECTION 3: DARI TAMBAK KAMI (GALERI) -->
    <section class="section-container" style="padding-top: 0;">
        <h2 class="section-title" style="margin-bottom: 4px;">Dari Tambak Kami</h2>
        <p style="color: #64748b; font-size: 14px;">Bagian dari proses budidaya yang kami jalankan setiap hari.</p>

        <div class="gallery-grid">
            <div class="gal-big">
                <img src="{{ asset('images/ikan.jpg') }}" alt="Budidaya Ikan Mujaer" class="gal-img">
                <div class="gal-overlay">
                    <span class="gal-tag">Mujaer</span>
                    <div class="gal-title">Budidaya Ikan Mujaer</div>
                </div>
            </div>
            <div class="gal-right">
                <div class="gal-small">
                    <img src="{{ asset('images/ikan.jpg') }}" alt="Udang Vaname" class="gal-img">
                    <div class="gal-overlay">
                        <span class="gal-tag">Udang</span>
                        <div class="gal-title">Udang Vaname</div>
                    </div>
                </div>
                <div class="gal-small">
                    <img src="{{ asset('images/ikan.jpg') }}" alt="Peralatan Tambak" class="gal-img">
                    <div class="gal-overlay">
                        <span class="gal-tag">Jala</span>
                        <div class="gal-title">Peralatan Tambak</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: BUDIDAYA KAMI (STATISTIK) -->
    <section id="budidaya" class="section-container" style="text-align: center; padding-top: 20px;">
        <h2 class="section-title">Budidaya Kami</h2>
        <p style="color: #64748b; font-size: 14px; max-width: 550px; margin: auto;">Kami membudidayakan udang Vaname dan ikan mujaer secara tradisional di tambak air tawar Sidoarjo.</p>

        <div class="stats-grid">
            <div>
                <div class="stat-val">350 KG</div>
                <div class="stat-label">Rata-rata panen udang per siklus</div>
            </div>
            <div>
                <div class="stat-val">±250 KG</div>
                <div class="stat-label">Mujaer siap konsumsi lokal per panen</div>
            </div>
            <div>
                <div class="stat-val">24/7</div>
                <div class="stat-label">Pemantauan kualitas air otomatis</div>
            </div>
        </div>
        <p style="color: #94a3b8; font-size: 13px;">Kualitas air dipantau otomatis melalui dashboard untuk membantu menjaga kondisi budidaya.</p>
    </section>

    <!-- SECTION 5: PROSES & KUALITAS PANEN -->
    <section class="section-container">
        <div class="grid-split">
            <div class="split-img-card">
                <img src="{{ asset('images/ikan.jpg') }}" alt="Kualitas Panen" style="height: 480px;">
            </div>
            <div>
                <span class="badge-sub">Proses</span>
                <h2 class="section-title">Kualitas Panen Unggul,<br>Terjamin oleh Data.</h2>
                
                <div class="process-list">
                    <div class="process-item">
                        <div class="num-circle">01</div>
                        <div class="process-text">
                            <h5>Air Tambak</h5>
                            <p>Kondisi air menjadi bagian penting dalam proses budidaya.</p>
                        </div>
                    </div>
                    <div class="process-item">
                        <div class="num-circle">02</div>
                        <div class="process-text">
                            <h5>Sensor Monitoring</h5>
                            <p>Parameter pH, suhu, dan kekeruhan dipantau secara digital.</p>
                        </div>
                    </div>
                    <div class="process-item">
                        <div class="num-circle">03</div>
                        <div class="process-text">
                            <h5>Dashboard AQUATOR</h5>
                            <p>Data monitoring dapat dilihat melalui dashboard terpadu.</p>
                        </div>
                    </div>
                    <div class="process-item">
                        <div class="num-circle orange">04</div>
                        <div class="process-text">
                            <h5>Keputusan Budidaya</h5>
                            <p>Data membantu proses pemantauan kondisi tambak secara lebih teratur.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 6: KUNJUNGI KAMI & LOKASI -->
    <section id="kontak" class="section-container" style="padding-top: 0;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 class="section-title" style="margin-bottom: 6px;">Kunjungi Kami</h2>
            <p style="color: #64748b; font-size: 14px;">Temukan tambak dan lokasi pemancingan kami di Sidoarjo.</p>
        </div>

        <div class="location-grid">
            <div class="map-wrapper">
                <!-- Ganti src dengan embed link Google Maps lokasi asli kamu -->
                <iframe src="https://maps.google.com/maps?q=Jabon%20Sidoarjo&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
            </div>

            <div class="loc-cards">
                <div class="loc-card">
                    <div class="loc-head"><i class="bi bi-geo-alt-fill text-danger" style="color: #ef4444;"></i> Lokasi Tambak</div>
                    <p style="color: #64748b; font-size: 13.5px; line-height: 1.6;">Dusun Bangunsari, Kecamatan Jabon,<br>Kabupaten Sidoarjo, Jawa Timur, Indonesia.</p>
                    <a href="https://maps.google.com" target="_blank" style="color: #0284c7; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-block; margin-top: 10px;">Lihat di Google Maps &rarr;</a>
                </div>

                <div class="loc-card">
                    <div class="loc-head"><i class="bi bi-telephone-fill text-danger" style="color: #ef4444;"></i> Kontak Kami</div>
                    <div style="font-size: 22px; font-weight: 800; color: #0f172a; margin-top: 4px;">0857-0717-8918</div>
                    <p style="color: #64748b; font-size: 12.5px;">WhatsApp Available</p>
                    <a href="https://wa.me/6285707178918" target="_blank" class="btn-wa">
                        <i class="bi bi-whatsapp"></i> Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- BANNER PEMANCINGAN -->
        <div class="fish-banner">
            <div>
                <h3 style="font-family: 'Playfair Display', serif; font-size: 26px; margin-bottom: 8px;">Pemancingan Harian Bangunsari</h3>
                <p style="color: #cbd5e1; font-size: 14px; margin-bottom: 14px;">Nikmati serunya memancing ikan segar langsung dari tambak kami.<br>Datang kapan saja, bawa pulang hasilnya.</p>
                <div style="display: flex; gap: 18px; font-size: 13px; color: #94a3b8; flex-wrap: wrap; margin-bottom: 20px;">
                    <span><i class="bi bi-clock"></i> Buka setiap hari</span>
                    <span><i class="bi bi-geo-alt"></i> Dusun Bangunsari, Jabon, Sidoarjo</span>
                    <span><i class="bi bi-telephone"></i> 0857-0717-8918</span>
                </div>
                <div style="display: flex; gap: 12px;">
                    <a href="#kontak" class="btn-line" style="padding: 9px 20px;">Lihat Lokasi</a>
                    <a href="https://wa.me/6285707178918" target="_blank" class="btn-fill" style="background: #22c55e; padding: 9px 20px;">Hubungi WhatsApp</a>
                </div>
            </div>
            <div class="price-tag">
                <div class="price-num">Rp25.000</div>
                <div style="color: #94a3b8; font-size: 13px;">per kilogram</div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-grid">
            <div>
                <div class="brand" style="margin-bottom: 12px;">
                    <img src="{{ asset('images/logo.png') }}" alt="Aquator">
                    <span>AQUATOR</span>
                </div>
                <p style="font-size: 13.5px; line-height: 1.6; max-width: 320px; margin-bottom: 14px;">Budidaya Udang & Ikan Mujaer di Sidoarjo secara tradisional & digital.</p>
                <i style="font-size: 12px; color: #64748b;">"Kualitas air terpantau, budidaya lebih terarah."</i>
            </div>
            <div class="footer-col">
                <h5>Jelajahi</h5>
                <ul>
                    <li><a href="{{ url('/home') }}">Dashboard</a></li>
                    <li><a href="#laporan">Laporan</a></li>
                    <li><a href="#">Home</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>Kunjungi Kami</h5>
                <ul>
                    <li><a href="#kontak">Lokasi Tambak</a></li>
                    <li><a href="#kontak">Pemancingan Harian</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>Kontak</h5>
                <ul>
                    <li><a href="tel:085707178918">0857-0717-8918</a></li>
                    <li><a href="https://wa.me/6285707178918">WhatsApp</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; 2026 AQUATOR / TambakKita. All rights reserved.
        </div>
    </footer>

</body>
</html>