<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f1e9">
    <title>Buku Tamu | {{ config('app.name', 'GalangUprak') }}</title>
    <link rel="stylesheet" href="{{ asset('guestbook.css') }}">
    <link rel="stylesheet" href="{{ asset('guestbook-access.css') }}">
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <a class="brand" href="{{ route('guestbook.index') }}" aria-label="Buku Tamu, beranda">
                <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 32 32" fill="none"><path d="M5.5 7.5c4.2-.8 7.7.1 10.5 2.7v15c-2.8-2.6-6.3-3.5-10.5-2.7v-15Zm21 0c-4.2-.8-7.7.1-10.5 2.7v15c2.8-2.6 6.3-3.5 10.5-2.7v-15Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 12c2 .1 3.8.7 5.2 1.8M9 16c2 .1 3.8.7 5.2 1.8m8.8-5.8c-2 .1-3.8.7-5.2 1.8m5.2 2.2c-2 .1-3.8.7-5.2 1.8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg></span>
                <span class="brand-name">lembar<span>tamu</span></span>
            </a>
            <div class="topbar-actions">
                <div class="topbar-note"><span class="live-dot"></span> Buku kunjungan digital</div>
                <a class="public-admin-link" href="{{ route('login') }}">Masuk admin <span aria-hidden="true">→</span></a>
            </div>
        </header>

        <main>
            <section class="intro" aria-labelledby="page-title">
                <div>
                    <p class="eyebrow"><span>CATATAN KUNJUNGAN</span><span class="eyebrow-rule"></span><span>NO. 001</span></p>
                    <h1 id="page-title">Setiap kunjungan<br><em>punya cerita.</em></h1>
                    <p class="intro-text">Catatan kunjungan tamu, perusahaan, dan rekan yang ditemui.</p>
                </div>
                <div class="intro-stamp" aria-label="Jumlah tamu">
                    <span class="stamp-number">{{ str_pad((string) $totalGuests, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="stamp-label">TAMU<br>TERCATAT</span>
                    <svg class="stamp-spark" viewBox="0 0 32 32" aria-hidden="true"><path d="M16 1.8 18.6 12l9.1-5.2-5.2 9.1 10.2 2.6-10.2 2.6 5.2 9.1-9.1-5.2L16 35.2l-2.6-10.2-9.1 5.2 5.2-9.1L-.7 18.5l10.2-2.6-5.2-9.1 9.1 5.2L16 1.8Z" fill="currentColor"/></svg>
                </div>
            </section>

            @if (session('success'))
                <div class="notice notice-success" role="status"><span class="notice-check" aria-hidden="true">✓</span>{{ session('success') }}</div>
            @endif

            <section class="public-layout">
                <section class="entries-panel" aria-labelledby="entries-title">
                    <div class="entries-heading">
                        <div><p class="section-kicker">DARI BUKU KAMI</p><h2 id="entries-title">Catatan tamu <span class="entry-count">{{ $entries->total() }}</span></h2></div>
                        <form class="search-form" action="{{ route('guestbook.index') }}" method="GET" role="search">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.6"/><path d="m16 16 4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                            <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama atau pesan" aria-label="Cari catatan tamu">
                            @if ($search !== '')<a class="clear-search" href="{{ route('guestbook.index') }}" aria-label="Hapus pencarian">×</a>@endif
                        </form>
                    </div>

                    @if ($entries->count())
                        <div class="entry-list">
                            @foreach ($entries as $entry)
                                <article class="entry-item">
                                    <div class="entry-avatar avatar-{{ $entry->id % 4 }}" aria-hidden="true">{{ strtoupper(substr($entry->name, 0, 1)) }}</div>
                                    <div class="entry-content">
                                        <div class="entry-topline"><h3>{{ $entry->name }}</h3><time datetime="{{ $entry->created_at->toIso8601String() }}">{{ $entry->created_at->format('d.m.Y') }} <span>·</span> {{ $entry->created_at->format('H:i') }}</time></div>
                                        <p class="entry-meta">{{ $entry->organization ?: 'Tamu' }} <span class="meta-dot">/</span> Bertemu dengan {{ $entry->met_with ?: 'belum dicatat' }}</p>
                                        <p class="entry-purpose">{{ $entry->purpose }}</p>
                                        @if ($entry->message)<p class="entry-message">{{ $entry->message }}</p>@endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        @if ($entries->hasPages())
                            <nav class="pagination" aria-label="Navigasi halaman catatan">
                                <span>Halaman {{ $entries->currentPage() }} dari {{ $entries->lastPage() }}</span>
                                <div class="pagination-actions">
                                    @if ($entries->previousPageUrl())<a href="{{ $entries->previousPageUrl() }}" aria-label="Halaman sebelumnya">←</a>@else<span class="disabled" aria-hidden="true">←</span>@endif
                                    @if ($entries->nextPageUrl())<a href="{{ $entries->nextPageUrl() }}" aria-label="Halaman berikutnya">→</a>@else<span class="disabled" aria-hidden="true">→</span>@endif
                                </div>
                            </nav>
                        @endif
                    @else
                        <div class="empty-state">
                            <span class="empty-icon" aria-hidden="true"><svg viewBox="0 0 48 48" fill="none"><path d="M9 11c6-1.4 11-.1 15 3.4v24c-4-3.5-9-4.8-15-3.4V11Zm30 0c-6-1.4-11-.1-15 3.4v24c4-3.5 9-4.8 15-3.4V11Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M14 18c2 .1 4 .7 5.5 1.8M14 23c2 .1 4 .7 5.5 1.8m14-6.8c-2 .1-4 .7-5.5 1.8m5.5 3.2c-2 .1-4 .7-5.5 1.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></span>
                            <h3>{{ $search !== '' ? 'Belum ada yang cocok' : 'Halaman ini masih kosong' }}</h3>
                            <p>{{ $search !== '' ? 'Coba kata kunci lain, atau tulis catatan pertama.' : 'Jadilah yang pertama meninggalkan cerita di sini.' }}</p>
                            @if ($search !== '')<a href="{{ route('guestbook.index') }}">Lihat semua catatan <span aria-hidden="true">→</span></a>@endif
                        </div>
                    @endif
                </section>
            </section>
        </main>
        <footer class="footer"><span>LEMBAR TAMU <span class="footer-star">✳</span> DIBUAT UNTUK MENYAMBUT</span><span>{{ now()->format('Y') }}</span></footer>
    </div>
</body>
</html>