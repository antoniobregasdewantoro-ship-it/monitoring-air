<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- Bootstrap & Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- Theme & Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-DqME6eCz.css') }}">

    {{-- Font Override for Landing Page --}}
    @stack('head')

    <title>Aqua Monitor</title>

    {{-- JS Libraries --}}
    <script src="{{ asset('build/assets/app-D4nMHFhB.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <style>
    /* Style untuk animasi indikator navbar */
    .nav-indicator {
        position: absolute;
        background-color: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 0.25rem;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        pointer-events: none;
        z-index: 1;
    }

    .nav-item-link {
        position: relative;
        z-index: 2;
        transition: color 0.2s ease;
    }
    </style>
</head>

<body class="@yield('body-class')">

    {{-- Navbar atas (desktop) --}}
    <nav class="navbar navbar-expand-lg d-none d-md-flex py-3" style="background-color: #1558A8;">
        <div class="container px-4">
            <!-- Bagian Kiri: Logo & Brand -->
            <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="{{ url('/dashboard') }}"
                style="font-size: 1.25rem;">

                <!-- Kotak putih pembungkus dengan sudut melengkung -->
                <div class="me-2 d-flex justify-content-center align-items-center"
                    style="width: 44px; height: 44px; background-color: #ffffff; border-radius: 12px; padding: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                    <img src="{{ asset('assets/icon.png') }}" alt="Aquator Logo"
                        style="width: 100%; height: 100%; object-fit: contain; transform: scale(1.9);">
                </div>

                AQUATOR
            </a>

            <!-- Bagian Kanan: Menu Navigasi & Theme Switch -->
            <div class="ms-auto d-flex align-items-center">
                <!-- Wrapper Menu Links (Navigasi dengan animasi) -->
                <div class="position-relative d-flex align-items-center me-3" id="navMenuWrapper">
                    <!-- Indikator Bergerak -->
                    <div id="navIndicator" class="nav-indicator"></div>

                    <a class="nav-link text-white mx-1 px-3 py-1 nav-item-link {{ request()->is('tentang-tambak') ? 'active' : '' }}"
                        href="{{ url('/tentang-tambak') }}">
                        Home
                    </a>

                    <a class="nav-link text-white mx-1 px-3 py-1 nav-item-link {{ request()->is('dashboard') ? 'active' : '' }}"
                        href="{{ url('/dashboard') }}">
                        Dashboard
                    </a>

                    <a class="nav-link text-white mx-1 px-3 py-1 nav-item-link {{ request()->is('history') ? 'active' : '' }}"
                        href="{{ url('/history') }}">
                        Laporan
                    </a>
                </div>

                <!-- Theme Switcher (Toggle) -->
                <div class="d-flex align-items-center"
                    style="background-color: rgba(255, 255, 255, 0.2); padding: 4px 6px; border-radius: 20px;">
                    <div class="form-check form-switch m-0 d-flex align-items-center">
                        <input class="form-check-input shadow-none" type="checkbox" id="themeSwitch"
                            style="width: 2.5rem; height: 1.2rem; cursor: pointer;">
                        <i class="fas fa-sun text-warning ms-2" style="font-size: 0.9rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Navbar bawah (mobile) --}}
    <div class="navbar fixed-bottom bg-primary border-top d-md-none py-1 px-3 d-flex justify-content-around">
        <a href="/dashboard" class="d-flex flex-column align-items-center text-white">
            <i class="fas fa-home"></i>
            <span class="small">Home</span>
        </a>
        <a href="/history" class="d-flex flex-column align-items-center text-white">
            <i class="fas fa-clock-rotate-left"></i>
            <span class="small">History</span>
        </a>
        <a href="/tentang-tambak" class="d-flex flex-column align-items-center text-white">
            <i class="fas fa-info-circle"></i>
            <span class="small">About</span>
        </a>
        <a href="#" id="mobileThemeSwitch" class="d-flex flex-column align-items-center text-white">
            <i class="fas fa-circle-half-stroke"></i>
            <span class="small">Theme</span>
        </a>
    </div>

    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Script Animasi Navbar --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('navMenuWrapper');
        const indicator = document.getElementById('navIndicator');
        const links = wrapper ? wrapper.querySelectorAll('.nav-item-link') : [];
        const activeLink = wrapper ? wrapper.querySelector('.nav-item-link.active') : null;

        function moveIndicator(element) {
            if (!element || !indicator) return;
            indicator.style.left = element.offsetLeft + 'px';
            indicator.style.width = element.offsetWidth + 'px';
            indicator.style.top = element.offsetTop + 'px';
            indicator.style.height = element.offsetHeight + 'px';
            indicator.style.opacity = '1';
        }

        // Posisi awal indikator pada menu aktif
        if (activeLink) {
            moveIndicator(activeLink);
        } else if (indicator) {
            indicator.style.opacity = '0';
        }

        // Pindahkan indikator saat hover
        links.forEach(link => {
            link.addEventListener('mouseenter', function() {
                moveIndicator(this);
            });
        });

        // Kembalikan ke menu aktif saat kursor keluar dari area navbar
        if (wrapper) {
            wrapper.addEventListener('mouseleave', function() {
                if (activeLink) {
                    moveIndicator(activeLink);
                } else if (indicator) {
                    indicator.style.opacity = '0';
                }
            });
        }
    });
    </script>

    @stack('styles')
</body>

</html>