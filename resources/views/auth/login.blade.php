<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'Tel-U Control') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            display: flex;
        }

        /* Left Side - Branding */
        .brand-side {
            flex: 1;
            background: linear-gradient(135deg, #E4002B 0%, #B80024 50%, #8B001C 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .brand-side::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            max-width: 400px;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .brand-logo svg {
            width: 48px;
            height: 48px;
            color: #E4002B;
        }

        .brand-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .brand-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .brand-features {
            margin-top: 3rem;
            text-align: left;
        }

        .brand-feature {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .brand-feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Right Side - Form */
        .form-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            background: #f9fafb;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #6b7280;
        }

        .form-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: #E4002B;
            box-shadow: 0 0 0 3px rgba(228, 0, 43, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #E4002B;
            cursor: pointer;
        }

        .form-checkbox label {
            font-size: 0.875rem;
            color: #6b7280;
            cursor: pointer;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }

        .forgot-link {
            font-size: 0.875rem;
            color: #E4002B;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-login {
            background: #E4002B;
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: #B80024;
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .form-footer {
            text-align: center;
            margin-top: 2rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .form-footer a {
            color: #E4002B;
            text-decoration: none;
            font-weight: 500;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .status-message {
            background: #dcfce7;
            color: #166534;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 900px) {
            body {
                flex-direction: column;
            }

            .brand-side {
                padding: 2rem;
                min-height: auto;
            }

            .brand-content h1 {
                font-size: 1.75rem;
            }

            .brand-content p,
            .brand-features {
                display: none;
            }

            .form-side {
                flex: none;
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Left Side - Branding -->
    <div class="brand-side">
        <div class="brand-content">
            <div class="brand-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h1>Tel-U Control</h1>
            <p>Sistem Pelaporan Terintegrasi untuk Kampus Telkom University</p>

            <div class="brand-features">
                <div class="brand-feature">
                    <div class="brand-feature-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span>Laporkan Kerusakan Fasilitas</span>
                </div>
                <div class="brand-feature">
                    <div class="brand-feature-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <span>Cari Barang Hilang & Temuan</span>
                </div>
                <div class="brand-feature">
                    <div class="brand-feature-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <span>Pantau Status Gate & Lalu Lintas</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="form-side">
        <div class="form-container">
            <div class="form-header">
                <h2>Selamat Datang!</h2>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <div class="form-card">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="status-message">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input"
                            placeholder="nama@telkomuniversity.ac.id" value="{{ old('email') }}" required autofocus
                            autocomplete="username">
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Masukkan password" required autocomplete="current-password">
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-checkbox">
                        <input type="checkbox" id="remember_me" name="remember">
                        <label for="remember_me">Ingat saya</label>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Lupa password?
                            </a>
                        @endif
                        <button type="submit" class="btn-login">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>

            @if (Route::has('register'))
                <div style="margin-top: 1.5rem; text-align: center;">
                    <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                        <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
                        <span style="padding: 0 1rem; color: #9ca3af; font-size: 0.875rem;">atau</span>
                        <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
                    </div>
                    <a href="{{ route('register') }}"
                        style="display: block; width: 100%; padding: 0.875rem; background: white; border: 2px solid #E4002B; color: #E4002B; border-radius: 10px; font-size: 1rem; font-weight: 600; text-decoration: none; text-align: center; transition: all 0.2s;">
                        Daftar Akun Baru
                    </a>
                </div>
                <div class="form-footer">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                </div>
            @endif
        </div>
    </div>
</body>

</html>