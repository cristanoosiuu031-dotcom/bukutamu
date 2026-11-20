<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f1e9">
    <title>Catat Kunjungan | Buku Tamu</title>
    <link rel="stylesheet" href="{{ asset('guestbook.css') }}">
    <link rel="stylesheet" href="{{ asset('guestbook-access.css') }}">
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <a class="brand" href="{{ route('admin.guestbook.create') }}" aria-label="Area admin buku tamu">
                <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 32 32" fill="none"><path d="M5.5 7.5c4.2-.8 7.7.1 10.5 2.7v15c-2.8-2.6-6.3-3.5-10.5-2.7v-15Zm21 0c-4.2-.8-7.7.1-10.5 2.7v15c2.8-2.6 6.3-3.5 10.5-2.7v-15Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></span>
                <span class="brand-name">lembar<span>tamu</span></span>
            </a>
            <div class="topbar-actions">
                <a class="public-admin-link" href="{{ route('guestbook.index') }}">Lihat buku tamu <span aria-hidden="true">→</span></a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="logout-button" type="submit">Keluar</button>
                </form>
            </div>
        </header>

        <main>
            <section class="intro admin-intro" aria-labelledby="page-title">
                <div>
                    <p class="eyebrow"><span>AREA ADMIN</span><span class="eyebrow-rule"></span><span>CATATAN BARU</span></p>
                    <h1 id="page-title">Catat kunjungan<br><em>hari ini.</em></h1>
                    <p class="intro-text">Lengkapi identitas tamu, perusahaan, dan rekan yang ditemui.</p>
                </div>
                <div class="intro-stamp" aria-label="Jumlah tamu tercatat">
                    <span class="stamp-number">{{ str_pad((string) $totalGuests, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="stamp-label">TAMU<br>TERCATAT</span>
                </div>
            </section>

            @if (session('success'))
                <div class="notice notice-success" role="status"><span class="notice-check" aria-hidden="true">✓</span>{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="notice notice-error" role="alert">Periksa kembali data yang bertanda merah.</div>
            @endif

            <section class="admin-layout" aria-labelledby="form-title">
                <div class="panel-heading">
                    <div><p class="section-kicker">FORMULIR KUNJUNGAN</p><h2 id="form-title">Informasi tamu</h2></div>
                    <span class="pen-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="m14.7 6.3 3 3M4 20l4.3-.9L19 7.4a2.1 2.1 0 0 0-3-3L5.3 15.1 4 20Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </div>
                <p class="panel-description">Tanda bintang menunjukkan data yang wajib diisi.</p>
                <form action="{{ route('admin.guestbook.store') }}" method="POST" class="guest-form admin-form">
                    @csrf
                    <div class="field-row">
                        <div class="field">
                            <label for="name">Nama tamu <span>*</span></label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" maxlength="100" autocomplete="name" required autofocus class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                            @error('name')<small class="field-error">{{ $message }}</small>@enderror
                        </div>
                        <div class="field">
                            <label for="organization">Perusahaan / asal <span>*</span></label>
                            <input id="organization" name="organization" type="text" value="{{ old('organization') }}" placeholder="Contoh: PT Telkom Indonesia" maxlength="120" required class="{{ $errors->has('organization') ? 'is-invalid' : '' }}">
                            @error('organization')<small class="field-error">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field">
                            <label for="met_with">Bertemu dengan <span>*</span></label>
                            <input id="met_with" name="met_with" type="text" value="{{ old('met_with') }}" placeholder="Nama orang yang ditemui" maxlength="120" required class="{{ $errors->has('met_with') ? 'is-invalid' : '' }}">
                            @error('met_with')<small class="field-error">{{ $message }}</small>@enderror
                        </div>
                        <div class="field">
                            <label for="purpose">Tujuan kunjungan <span>*</span></label>
                            <input id="purpose" name="purpose" type="text" value="{{ old('purpose') }}" placeholder="Contoh: Rapat koordinasi" maxlength="180" required class="{{ $errors->has('purpose') ? 'is-invalid' : '' }}">
                            @error('purpose')<small class="field-error">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field">
                            <label for="email">Email tamu <span class="optional">OPSIONAL</span></label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" autocomplete="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                            @error('email')<small class="field-error">{{ $message }}</small>@enderror
                        </div>
                        <div class="field">
                            <label for="phone">No. telepon <span class="optional">OPSIONAL</span></label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" maxlength="32" autocomplete="tel" class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                            @error('phone')<small class="field-error">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="field">
                        <div class="label-line"><label for="message">Catatan tambahan <span class="optional">OPSIONAL</span></label><span class="optional">MAKS. 500 KARAKTER</span></div>
                        <textarea id="message" name="message" rows="3" maxlength="500" placeholder="Informasi tambahan tentang kunjungan">{{ old('message') }}</textarea>
                        @error('message')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <button class="submit-button" type="submit"><span>Simpan kunjungan</span><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4.5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                </form>
            </section>
        </main>
        <footer class="footer"><span>FORMULIR KHUSUS ADMIN</span><span>{{ now()->format('Y') }}</span></footer>
    </div>
</body>
</html>