<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar - {{ config('app.name', 'Tel-U Control') }}</title>

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
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
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
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
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

        /* Right Side - Form */
        .form-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            background: #f9fafb;
            overflow-y: auto;
        }
        .form-container {
            width: 100%;
            max-width: 420px;
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
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .form-group {
            margin-bottom: 1.25rem;
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
            padding: 0.75rem 1rem;
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
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }
        .login-link {
            font-size: 0.875rem;
            color: #E4002B;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
        .btn-register {
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
        .btn-register:hover {
            background: #B80024;
            transform: translateY(-1px);
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
            .brand-content p {
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1>Tel-U Control</h1>
            <p>Bergabunglah dengan sistem pelaporan terintegrasi untuk Kampus Telkom University</p>
        </div>
    </div>

    <!-- Right Side - Register Form -->
    <div class="form-side">
        <div class="form-container">
            <div class="form-header">
                <h2>Buat Akun Baru</h2>
                <p>Daftarkan diri Anda untuk mulai menggunakan sistem</p>
            </div>

            <div class="form-card">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-input" 
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            autocomplete="name"
                        >
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="nama@telkomuniversity.ac.id"
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="username"
                        >
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Minimal 8 karakter"
                            required 
                            autocomplete="new-password"
                        >
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="form-input" 
                            placeholder="Ulangi password"
                            required 
                            autocomplete="new-password"
                        >
                        @error('password_confirmation')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                        <a href="{{ route('login') }}" class="login-link">
                            Sudah punya akun?
                        </a>
                        <button type="submit" class="btn-register">
                            Daftar
                        </button>
                    </div>
                </form>
            </div>

            <div class="form-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>
</html>
