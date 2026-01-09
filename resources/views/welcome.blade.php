<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Tel-U Control') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-logo {
            width: 40px;
            height: 40px;
            background: #E4002B;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .navbar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }

        .navbar-links a {
            color: #4b5563;
            text-decoration: none;
            margin-left: 1rem;
            font-weight: 500;
        }

        .navbar-links a:hover {
            color: #E4002B;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #E4002B;
            color: white;
        }

        .btn-primary:hover {
            background: #B80024;
        }

        .btn-outline {
            border: 2px solid white;
            color: white;
            background: transparent;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-white {
            background: white;
            color: #E4002B;
        }

        .btn-white:hover {
            background: #f3f4f6;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #E4002B 0%, #B80024 100%);
            padding: 8rem 1.5rem 5rem;
            min-height: 500px;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .hero-content h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-content h1 span {
            color: #fecaca;
        }

        .hero-content p {
            color: #fecaca;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-image-card {
            background: white;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }

        .hero-image-card img {
            width: 100%;
            height: auto;
            border-radius: 12px;
            display: block;
        }

        .hero-image-caption {
            text-align: center;
            margin-top: 1rem;
            color: #6b7280;
        }

        .hero-image-caption strong {
            color: #374151;
            display: block;
        }

        /* Features Section */
        .features {
            background: white;
            padding: 5rem 1.5rem;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .features-header h2 {
            font-size: 2rem;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }

        .features-header p {
            color: #6b7280;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .feature-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon.orange {
            background: #ffedd5;
            color: #ea580c;
        }

        .feature-icon.blue {
            background: #dbeafe;
            color: #2563eb;
        }

        .feature-icon.green {
            background: #dcfce7;
            color: #16a34a;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: #6b7280;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            background: #f9fafb;
            padding: 4rem 1.5rem;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            color: #E4002B;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            color: #6b7280;
        }

        /* Footer */
        .footer {
            background: #111827;
            color: white;
            padding: 3rem 1.5rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .footer-logo {
            width: 40px;
            height: 40px;
            background: #E4002B;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-text {
            color: #9ca3af;
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-container {
                grid-template-columns: 1fr;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-image-card {
                display: none;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-brand">
            <div class="navbar-logo">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <span class="navbar-title">Tel-U Control</span>
        </div>

        <div class="navbar-links">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>
                    Sistem Pelaporan<br>
                    <span>Telkom University</span>
                </h1>
                <p>
                    Sistem terintegrasi untuk melaporkan fasilitas rusak, mencari barang hilang,
                    serta memantau kondisi lalu lintas di lingkungan kampus.
                </p>
                <div class="hero-buttons">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-white">Masuk ke Sistem</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline">Daftar Akun</a>
                        @endif
                    @else
                        <a href="{{ url('/dashboard') }}" class="btn btn-white">Buka Dashboard</a>
                    @endguest
                </div>
            </div>

            <div class="hero-image-card">
                <img src="{{ asset('images/Telkom.png') }}" alt="Telkom University Campus"
                    onerror="this.style.display='none'">
                <div class="hero-image-caption">
                    <strong>Kampus Telkom University</strong>
                    <span>Bandung, Indonesia</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="features">
        <div class="features-container">
            <div class="features-header">
                <h2>Fitur Utama</h2>
                <p>Platform terintegrasi untuk memudahkan pelaporan dan pemantauan di lingkungan kampus</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon orange">
                        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3>Laporan Kerusakan</h3>
                    <p>Laporkan kerusakan fasilitas kampus dengan mudah. Upload foto dan deskripsi untuk
                        ditindaklanjuti.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon blue">
                        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3>Barang Hilang & Temuan</h3>
                    <p>Cari barang hilang atau laporkan barang temuan. Sistem matching memudahkan pengembalian.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon green">
                        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <h3>Status Gate & Lalu Lintas</h3>
                    <p>Pantau status gerbang dan kondisi lalu lintas kampus secara real-time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS SECTION -->
    <section class="stats">
        <div class="stats-container">
            <div class="stat-item">
                <h3>24/7</h3>
                <p>Layanan Aktif</p>
            </div>
            <div class="stat-item">
                <h3>4</h3>
                <p>Gate Terpantau</p>
            </div>
            <div class="stat-item">
                <h3>Fast</h3>
                <p>Respon Cepat</p>
            </div>
            <div class="stat-item">
                <h3>100%</h3>
                <p>Transparan</p>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <div class="footer-logo">
                    <svg width="24" height="24" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <strong>Tel-U Control</strong>
                    <p class="footer-text" style="margin:0;">Sistem Pelaporan Telkom University</p>
                </div>
            </div>
            <div class="footer-text">
                &copy; {{ date('Y') }} Telkom University. All rights reserved.
            </div>
        </div>
    </footer>

</body>

</html>