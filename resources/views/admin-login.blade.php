<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f1e9">
    <title>Masuk Admin | Buku Tamu</title>
    <link rel="stylesheet" href="{{ asset('guestbook.css') }}">
    <link rel="stylesheet" href="{{ asset('guestbook-access.css') }}">
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <a class="brand" href="{{ route('guestbook.index') }}" aria-label="Buku Tamu, beranda">
                <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 32 32" fill="none"><path d="M5.5 7.5c4.2-.8 7.7.1 10.5 2.7v15c-2.8-2.6-6.3-3.5-10.5-2.7v-15Zm21 0c-4.2-.8-7.7.1-10.5 2.7v15c2.8-2.6 6.3-3.5 10.5-2.7v-15Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></span>
                <span class="brand-name">lembar<span>tamu</span></span>
            </a>
            <a class="public-admin-link" href="{{ route('guestbook.index') }}">Lihat buku tamu <span aria-hidden="true">→</span></a>
        </header>

        <main class="auth-layout">
            <div class="auth-copy">
                <p class="eyebrow"><span>AKSES PETUGAS</span><span class="eyebrow-rule"></span><span>ADMIN</span></p>
                <h1>Selamat<br><em>datang kembali.</em></h1>
                <p class="intro-text">Masuk untuk mencatat kunjungan tamu dan mengelola buku kunjungan.</p>
            </div>
            <section class="auth-panel" aria-labelledby="login-title">
                <p class="section-kicker">AREA ADMIN</p>
                <h2 id="login-title">Masuk ke akun</h2>
                <p class="panel-description">Gunakan email dan kata sandi admin Anda.</p>
                @if ($errors->any())
                    <div class="notice notice-error" role="alert">{{ $errors->first() }}</div>
                @endif
                <form action="{{ route('login.store') }}" method="POST" class="guest-form">
                    @csrf
                    <div class="field">
                        <label for="email">Email admin <span>*</span></label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    </div>
                    <div class="field">
                        <label for="password">Kata sandi <span>*</span></label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required>
                    </div>
                    <label class="remember-field" for="remember"><input id="remember" name="remember" type="checkbox" value="1"> Tetap masuk di perangkat ini</label>
                    <button class="submit-button" type="submit"><span>Masuk sebagai admin</span><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4.5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                </form>
            </section>
        </main>
        <footer class="footer"><span>AKSES TERBATAS UNTUK ADMIN</span><span>{{ now()->format('Y') }}</span></footer>
    </div>
</body>
</html>