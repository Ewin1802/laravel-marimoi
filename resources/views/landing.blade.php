<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1d120d">

    <title>{{ $setting->store_name ?? 'Kopi Senja' }}</title>

    <meta name="description"
        content="{{ $setting->store_description ?? 'Kopi pilihan, makanan hangat, dan suasana nyaman untuk menemani setiap cerita.' }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>

<body data-whatsapp="{{ $setting->whatsapp ?? '' }}">

    <div class="ambient ambient-one"></div>
    <div class="ambient ambient-two"></div>

    {{-- TOP INFO --}}
    <div class="topbar">
        <div class="container topbar-inner">
            <div class="topbar-left">
                <span>
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $setting->address ?? 'Lokasi cafe' }}
                </span>
                <span class="topbar-separator"></span>
                <span>
                    <i class="fa-regular fa-clock"></i>
                    Senin - Minggu • 08:00 - 22:00
                </span>
            </div>

            @if ($setting->phone)
                <a class="topbar-phone" href="tel:{{ $setting->phone }}">
                    <i class="fa-solid fa-phone"></i>
                    {{ $setting->phone }}
                </a>
            @endif
        </div>
    </div>

    {{-- NAVBAR --}}

    <header class="navbar" id="navbar">

        <div class="container nav-inner">


            {{-- BRAND --}}

            <a href="#home" class="brand" aria-label="{{ $setting->store_name ?? 'Marimoi Cafe' }}">

                <span class="brand-icon">

                    <i class="fa-solid fa-mug-hot"></i>

                </span>


                <span class="brand-copy">

                    <strong>
                        {{ $setting->store_name ?? 'Marimoi Cafe' }}
                    </strong>

                    <small>
                        {{ $setting->store_tagline ?? 'Coffee • Eat • Gather' }}
                    </small>

                </span>

            </a>


            {{-- DESKTOP NAVIGATION --}}

            <nav class="desktop-nav" aria-label="Navigasi utama">

                <a href="#home" class="active">
                    Beranda
                </a>

                <a href="#categories">
                    Kategori
                </a>

                <a href="#products">
                    Menu
                </a>

                <a href="#experience">
                    Tentang Kami
                </a>

                <a href="#contact">
                    Kontak
                </a>

            </nav>


            {{-- ACTIONS --}}

            <div class="nav-actions">


                {{-- WhatsApp / Pesan --}}

                @if ($setting->whatsapp)
                    <a href="https://wa.me/{{ $setting->whatsapp }}" target="_blank" rel="noopener noreferrer"
                        class="nav-order">

                        <i class="fa-brands fa-whatsapp"></i>

                        <span>
                            Pesan
                        </span>

                    </a>
                @endif


                {{-- Login --}}

                <a href="{{ route('login') }}" class="nav-login">

                    <i class="fa-solid fa-right-to-bracket"></i>

                    <span>
                        Login
                    </span>

                </a>


                {{-- Mobile Button --}}

                <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Buka menu"
                    aria-expanded="false">

                    <span></span>
                    <span></span>
                    <span></span>

                </button>

            </div>

        </div>


        {{-- MOBILE MENU --}}

        <div class="mobile-menu" id="mobileMenu">

            <div class="container mobile-menu-inner">


                <a href="#home">

                    <i class="fa-solid fa-house"></i>

                    <span>
                        Beranda
                    </span>

                </a>


                <a href="#categories">

                    <i class="fa-solid fa-layer-group"></i>

                    <span>
                        Kategori
                    </span>

                </a>


                <a href="#products">

                    <i class="fa-solid fa-mug-hot"></i>

                    <span>
                        Menu
                    </span>

                </a>


                <a href="#experience">

                    <i class="fa-solid fa-heart"></i>

                    <span>
                        Tentang Kami
                    </span>

                </a>


                <a href="#contact">

                    <i class="fa-solid fa-location-dot"></i>

                    <span>
                        Kontak
                    </span>

                </a>


                {{-- Login Mobile --}}

                <a href="{{ route('login') }}" class="mobile-login">

                    <i class="fa-solid fa-right-to-bracket"></i>

                    <span>
                        Login
                    </span>

                </a>


                {{-- WhatsApp Mobile --}}

                @if ($setting->whatsapp)
                    <a href="https://wa.me/{{ $setting->whatsapp }}" target="_blank" rel="noopener noreferrer"
                        class="mobile-order">

                        <i class="fa-brands fa-whatsapp"></i>

                        <span>
                            Pesan via WhatsApp
                        </span>

                    </a>
                @endif

            </div>

        </div>

    </header>

    <main>

        {{-- HERO --}}
        <section class="hero" id="home">
            <div class="hero-image"></div>
            <div class="hero-overlay"></div>

            <div class="container hero-inner">
                <div class="hero-content">

                    <div class="eyebrow">
                        <span></span>
                        COFFEE • FOOD • GOOD MOMENTS
                    </div>

                    <h1>
                        {{ $setting->hero_title ?? 'Secangkir Kopi, Sepiring Cerita.' }}
                    </h1>

                    <p>
                        {{ $setting->hero_subtitle ?? 'Nikmati kopi pilihan, makanan hangat, dan suasana nyaman untuk sarapan, makan siang, nongkrong, atau menghabiskan malam bersama orang tersayang.' }}
                    </p>

                    <div class="hero-actions">
                        <a href="#products" class="btn btn-primary">
                            {{ $setting->hero_button ?? 'Lihat Menu' }}
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                        @if ($setting->whatsapp)
                            <a href="https://wa.me/{{ $setting->whatsapp }}?text={{ urlencode('Halo, saya ingin pesan menu di ' . ($setting->store_name ?? 'cafe')) }}"
                                target="_blank" rel="noopener" class="btn btn-light">
                                <i class="fa-brands fa-whatsapp"></i>
                                Pesan Sekarang
                            </a>
                        @else
                            <a href="#contact" class="btn btn-light">
                                <i class="fa-solid fa-location-dot"></i>
                                Kunjungi Kami
                            </a>
                        @endif
                    </div>

                    <div class="hero-note">
                        <div class="avatar-stack">
                            <span><i class="fa-solid fa-mug-hot"></i></span>
                            <span><i class="fa-solid fa-utensils"></i></span>
                            <span><i class="fa-solid fa-heart"></i></span>
                        </div>
                        <div>
                            <strong>Freshly served every day</strong>
                            <small>Kopi dan makanan disiapkan dengan perhatian.</small>
                        </div>
                    </div>
                </div>

                <div class="hero-side">
                    <div class="hero-card hero-card-main">
                        <span class="hero-card-label">
                            <i class="fa-solid fa-star"></i>
                            FAVORIT HARI INI
                        </span>
                        <strong>Ngopi santai.<br> Makan puas.</strong>
                        <p>Tempat yang pas untuk rehat dari rutinitas.</p>
                    </div>

                    <div class="hero-mini-card">
                        <span class="mini-icon"><i class="fa-solid fa-fire"></i></span>
                        <div>
                            <strong>Menu hangat</strong>
                            <small>Siap menemani kopimu</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container hero-stats">
                <div>
                    <strong>{{ $menuProducts->count() }}</strong>
                    <span>Pilihan Menu</span>
                </div>
                <div>
                    <strong>{{ $categories->count() }}</strong>
                    <span>Kategori</span>
                </div>
                <div>
                    <strong>08:00</strong>
                    <span>Mulai Buka</span>
                </div>
                <div class="status">
                    <span class="status-dot"></span>
                    <span>Siap Melayani</span>
                </div>
            </div>
        </section>

        {{-- CATEGORIES --}}
        <section class="section categories-section" id="categories">
            <div class="container">

                <div class="section-head">
                    <div>
                        <span class="section-kicker">PILIHAN UNTUKMU</span>
                        <h2>Mau <em>ngopi</em> atau <em>makan?</em></h2>
                    </div>
                    <p>Mulai dari kopi klasik sampai makanan berat yang bikin kenyang.</p>
                </div>

                <div class="category-grid">
                    @forelse ($categories as $category)
                        <a href="#products" class="category-card" data-category-link="{{ $category->id }}">
                            <span class="category-icon">
                                <i class="fa-solid fa-mug-saucer"></i>
                            </span>
                            <div>
                                <h3>{{ $category->name }}</h3>
                                <span>Lihat menu <i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </a>
                    @empty
                        <div class="empty-state">
                            <i class="fa-solid fa-bowl-food"></i>
                            <h3>Menu sedang disiapkan</h3>
                            <p>Kategori menu belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- MENU --}}
        <section class="section menu-section" id="products">
            <div class="container">

                <div class="section-head menu-head">
                    <div>
                        <span class="section-kicker">OUR MENU</span>
                        <h2>Yang enak-enak <em>ada di sini.</em></h2>
                        <p class="section-description">
                            Pilih kopi, minuman, snack, atau makanan berat favoritmu.
                        </p>
                    </div>

                    <div class="menu-count">
                        <strong id="productCount">{{ $menuProducts->count() }}</strong>
                        <span>menu ditemukan</span>
                    </div>
                </div>

                <div class="menu-toolbar">
                    <label class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" id="productSearch"
                            placeholder="Cari kopi, makanan, atau menu favorit..." autocomplete="off">
                        <button type="button" id="clearProductSearch" aria-label="Hapus pencarian">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </label>

                    <div class="filter-scroll">
                        <button type="button" class="menu-filter active" data-category="all">
                            Semua
                        </button>

                        @foreach ($categories as $category)
                            <button type="button" class="menu-filter" data-category="{{ $category->id }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="menu-grid" id="sparepartGrid">
                    @forelse ($menuProducts as $product)
                        <article class="menu-card" data-name="{{ strtolower($product->name) }}"
                            data-category="{{ $product->category_id }}"
                            data-category-name="{{ strtolower($product->category->name ?? '') }}"
                            data-description="{{ strtolower($product->description ?? '') }}">

                            <div class="menu-image">
                                @if ($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        loading="lazy">
                                @else
                                    <img src="https://placehold.co/900x700/2a1b15/f5c58a?text=MENU"
                                        alt="{{ $product->name }}" loading="lazy">
                                @endif

                                <div class="menu-image-shade"></div>

                                @if ($product->is_favorite)
                                    <span class="favorite-badge">
                                        <i class="fa-solid fa-star"></i> Favorit
                                    </span>
                                @endif

                                <span class="availability {{ $product->status ? 'available' : 'sold-out' }}">
                                    <span></span>
                                    {{ $product->status ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>

                            <div class="menu-body">
                                <div class="menu-meta">
                                    <span>{{ $product->category->name ?? 'Menu' }}</span>
                                    <i class="fa-solid fa-leaf"></i>
                                </div>

                                <h3>{{ $product->name }}</h3>

                                <p>
                                    {{ \Illuminate\Support\Str::limit($product->description ?? 'Menu pilihan yang disiapkan untuk menemani waktu santaimu.', 90) }}
                                </p>

                                <div class="menu-bottom">
                                    <div class="price">
                                        <small>Mulai dari</small>
                                        <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                                    </div>

                                    <button type="button" class="menu-detail-btn" data-name="{{ $product->name }}"
                                        data-price="{{ number_format($product->price, 0, ',', '.') }}"
                                        data-category="{{ $product->category->name ?? 'Menu' }}"
                                        data-stock="{{ $product->stock }}"
                                        data-status="{{ $product->status ? 'Tersedia' : 'Habis' }}"
                                        data-description="{{ $product->description ?? 'Tidak ada deskripsi menu.' }}"
                                        data-image="{{ $product->image ? asset($product->image) : 'https://placehold.co/900x700/2a1b15/f5c58a?text=MENU' }}">
                                        <i class="fa-solid fa-plus"></i>
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="empty-state menu-empty">
                            <i class="fa-solid fa-bowl-food"></i>
                            <h3>Belum ada menu</h3>
                            <p>Menu cafe belum tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="search-empty" id="sparepartSearchEmpty">
                    <div class="empty-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <h3>Menu tidak ditemukan</h3>
                    <p>Coba kata kunci atau kategori lainnya.</p>
                    <button type="button" id="resetProductFilter">Tampilkan Semua Menu</button>
                </div>
            </div>
        </section>

        {{-- EXPERIENCE --}}
        <section class="experience-section" id="experience">
            <div class="container experience-grid">

                <div class="experience-photo">
                    <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=1200&q=85"
                        alt="Suasana cafe" loading="lazy">
                    <div class="photo-caption">
                        <span><i class="fa-solid fa-location-dot"></i>
                            {{ $setting->address ?? 'Cafe kami' }}</span>
                        <strong>Datang untuk kopi,<br>tinggal untuk suasana.</strong>
                    </div>
                </div>

                <div class="experience-content">
                    <span class="section-kicker">OUR STORY</span>
                    <h2>Tempat sederhana untuk <em>cerita yang berarti.</em></h2>

                    <p>
                        {{ $setting->store_description ?? 'Kami percaya cafe bukan hanya tempat membeli kopi. Ini adalah tempat bertemu, bekerja, berbincang, merayakan, dan menikmati waktu tanpa terburu-buru.' }}
                    </p>

                    <div class="feature-list">
                        <div>
                            <span><i class="fa-solid fa-seedling"></i></span>
                            <div>
                                <strong>Bahan pilihan</strong>
                                <small>Kopi dan bahan makanan dipilih untuk rasa yang konsisten.</small>
                            </div>
                        </div>

                        <div>
                            <span><i class="fa-solid fa-fire-burner"></i></span>
                            <div>
                                <strong>Dimasak saat dipesan</strong>
                                <small>Makanan hangat disiapkan agar lebih nikmat saat sampai di meja.</small>
                            </div>
                        </div>

                        <div>
                            <span><i class="fa-solid fa-couch"></i></span>
                            <div>
                                <strong>Suasana nyaman</strong>
                                <small>Cocok untuk santai, bekerja, bertemu teman, atau keluarga.</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- CTA --}}
        <section class="cta-section" id="contact">
            <div class="container">
                <div class="cta-box">
                    <div>
                        <span class="section-kicker">READY FOR A GOOD MOMENT?</span>
                        <h2>Sudah tahu mau <em>pesan apa?</em></h2>
                        <p>Datang dan nikmati kopi serta makanan favoritmu hari ini.</p>
                    </div>

                    <div class="cta-actions">
                        @if ($setting->whatsapp)
                            <a href="https://wa.me/{{ $setting->whatsapp }}?text={{ urlencode('Halo, saya ingin pesan menu di ' . ($setting->store_name ?? 'cafe')) }}"
                                target="_blank" rel="noopener" class="btn btn-primary">
                                <i class="fa-brands fa-whatsapp"></i>
                                Pesan via WhatsApp
                            </a>
                        @endif

                        @if ($setting->phone)
                            <a href="tel:{{ $setting->phone }}" class="btn btn-outline-light">
                                <i class="fa-solid fa-phone"></i>
                                Hubungi Kami
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-brand">
                <a href="#home" class="brand footer-logo">
                    <span class="brand-icon"><i class="fa-solid fa-mug-hot"></i></span>
                    <span class="brand-copy">
                        <strong>{{ $setting->store_name ?? 'KOPI SENJA' }}</strong>
                        <small>{{ $setting->store_tagline ?? 'Coffee • Eat • Gather' }}</small>
                    </span>
                </a>

                <p>
                    {{ $setting->store_description ?? 'Kopi pilihan, makanan hangat, dan suasana nyaman untuk setiap cerita.' }}
                </p>
            </div>

            <div class="footer-column">
                <h3>Jelajahi</h3>
                <a href="#home">Beranda</a>
                <a href="#categories">Kategori</a>
                <a href="#products">Menu</a>
                <a href="#experience">Tentang</a>
            </div>

            <div class="footer-column">
                <h3>Jam Buka</h3>
                <span>Senin - Minggu</span>
                <strong>08:00 - 22:00</strong>
                <small>Last order 21:30</small>
            </div>

            <div class="footer-column">
                <h3>Kontak</h3>
                <span>{{ $setting->address ?? 'Alamat cafe' }}</span>

                @if ($setting->phone)
                    <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                @endif

                @if ($setting->whatsapp)
                    <a href="https://wa.me/{{ $setting->whatsapp }}" target="_blank" rel="noopener">
                        WhatsApp
                    </a>
                @endif
            </div>
        </div>

        <div class="container footer-bottom">
            <span>© {{ date('Y') }} {{ $setting->store_name ?? 'Cafe' }}. All rights reserved.</span>
            <span>Made for good coffee & good food.</span>
        </div>
    </footer>

    {{-- MENU DETAIL MODAL --}}
    <div class="menu-modal" id="sparepartModal" aria-hidden="true">
        <div class="menu-modal-overlay"></div>

        <div class="menu-modal-content" role="dialog" aria-modal="true" aria-labelledby="modalProductName">
            <button type="button" class="menu-modal-close" id="closeSparepartModal" aria-label="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="menu-modal-image">
                <img id="modalProductImage" src="" alt="">
                <span><i class="fa-solid fa-mug-hot"></i> Menu</span>
            </div>

            <div class="menu-modal-info">
                <span class="modal-category" id="modalProductCategory">Menu</span>

                <h2 id="modalProductName">Nama Menu</h2>

                <div class="modal-price">
                    <small>Harga</small>
                    <strong id="modalProductPrice">Rp 0</strong>
                </div>

                <div class="modal-status">
                    <span><i class="fa-solid fa-circle-check"></i></span>
                    <div>
                        <small>Ketersediaan</small>
                        <strong id="modalProductStock">Tersedia</strong>
                    </div>
                </div>

                <div class="modal-description">
                    <strong><i class="fa-solid fa-circle-info"></i> Tentang menu</strong>
                    <p id="modalProductDescription">-</p>
                </div>

                <div class="modal-benefits">
                    <span><i class="fa-solid fa-check"></i> Fresh</span>
                    <span><i class="fa-solid fa-check"></i> Freshly served</span>
                    <span><i class="fa-solid fa-check"></i> Siap dipesan</span>
                </div>

                @if ($setting->whatsapp)
                    <a href="#" target="_blank" rel="noopener" id="modalProductWhatsapp"
                        class="modal-order-btn">
                        <i class="fa-brands fa-whatsapp"></i>
                        Tanya & Pesan Menu
                    </a>
                @else
                    <a href="#contact" id="modalProductWhatsapp" class="modal-order-btn">
                        <i class="fa-solid fa-phone"></i>
                        Hubungi Kami
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if ($setting->whatsapp)
        <a href="https://wa.me/{{ $setting->whatsapp }}" target="_blank" rel="noopener" class="floating-whatsapp"
            aria-label="Chat WhatsApp">
            <i class="fa-brands fa-whatsapp"></i>
            <span>Pesan</span>
        </a>
    @endif

    <button type="button" class="back-top" id="backTop" aria-label="Kembali ke atas">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', () => {



            const body =
                document.body;

            const navbar =
                document.getElementById('navbar');

            const menuButton =
                document.getElementById('mobileMenuBtn');

            const mobileMenu =
                document.getElementById('mobileMenu');




            const closeMobileMenu = () => {

                menuButton?.classList.remove('active');

                mobileMenu?.classList.remove('show');

                menuButton?.setAttribute(
                    'aria-expanded',
                    'false'
                );

                body.classList.remove(
                    'menu-open'
                );

            };


            menuButton?.addEventListener(
                'click',
                () => {

                    const open =
                        mobileMenu?.classList.toggle(
                            'show'
                        );

                    menuButton.classList.toggle(
                        'active',
                        open
                    );

                    menuButton.setAttribute(
                        'aria-expanded',
                        String(open)
                    );

                    body.classList.toggle(
                        'menu-open',
                        open
                    );

                }
            );




            mobileMenu
                ?.querySelectorAll('a')
                .forEach(link => {

                    link.addEventListener(
                        'click',
                        closeMobileMenu
                    );

                });




            const search =
                document.getElementById(
                    'productSearch'
                );

            const clearSearch =
                document.getElementById(
                    'clearProductSearch'
                );

            const count =
                document.getElementById(
                    'productCount'
                );

            const empty =
                document.getElementById(
                    'menuSearchEmpty'
                ) ||
                document.getElementById(
                    'sparepartSearchEmpty'
                );

            const reset =
                document.getElementById(
                    'resetProductFilter'
                );

            const cards = [
                ...document.querySelectorAll(
                    '.menu-card'
                )
            ];

            const filters = [
                ...document.querySelectorAll(
                    '.menu-filter'
                )
            ];


            let activeCategory = 'all';




            const filterMenu = () => {

                const keyword =
                    (
                        search?.value || ''
                    )
                    .toLowerCase()
                    .trim();

                let visible = 0;


                cards.forEach(card => {

                    const name =
                        card.dataset.name || '';

                    const category =
                        card.dataset.category || '';

                    const categoryName =
                        card.dataset.categoryName || '';

                    const description =
                        card.dataset.description || '';


                    const searchMatch = !keyword ||
                        name.includes(keyword) ||
                        categoryName.includes(keyword) ||
                        description.includes(keyword);


                    const categoryMatch =
                        activeCategory === 'all' ||
                        category === activeCategory;


                    const show =
                        searchMatch &&
                        categoryMatch;


                    card.hidden = !show;


                    if (show) {

                        visible++;

                    }

                });


                if (count) {

                    count.textContent =
                        visible;

                }


                if (empty) {

                    empty.classList.toggle(
                        'show',
                        visible === 0
                    );

                }


                if (clearSearch) {

                    clearSearch.classList.toggle(
                        'show',
                        Boolean(keyword)
                    );

                }

            };




            search?.addEventListener(
                'input',
                filterMenu
            );




            clearSearch?.addEventListener(
                'click',
                () => {

                    if (!search) return;

                    search.value = '';

                    filterMenu();

                    search.focus();

                }
            );




            filters.forEach(button => {

                button.addEventListener(
                    'click',
                    () => {

                        filters.forEach(item => {

                            item.classList.remove(
                                'active'
                            );

                        });


                        button.classList.add(
                            'active'
                        );


                        activeCategory =
                            button.dataset.category ||
                            'all';


                        filterMenu();

                    }
                );

            });




            reset?.addEventListener(
                'click',
                () => {

                    activeCategory =
                        'all';


                    if (search) {

                        search.value = '';

                    }


                    filters.forEach(item => {

                        item.classList.remove(
                            'active'
                        );

                    });


                    document
                        .querySelector(
                            '.menu-filter[data-category="all"]'
                        )
                        ?.classList.add(
                            'active'
                        );


                    filterMenu();

                }
            );




            document
                .querySelectorAll(
                    '[data-category-link]'
                )
                .forEach(link => {

                    link.addEventListener(
                        'click',
                        () => {

                            const category =
                                link.dataset.categoryLink;


                            setTimeout(
                                () => {

                                    const filter =
                                        document.querySelector(
                                            `.menu-filter[data-category="${category}"]`
                                        );


                                    if (filter) {

                                        filter.click();

                                    }

                                },
                                150
                            );

                        }
                    );

                });




            const modal =
                document.getElementById(
                    'sparepartModal'
                );

            const closeModalButton =
                document.getElementById(
                    'closeSparepartModal'
                );

            const modalImage =
                document.getElementById(
                    'modalProductImage'
                );

            const modalName =
                document.getElementById(
                    'modalProductName'
                );

            const modalPrice =
                document.getElementById(
                    'modalProductPrice'
                );

            const modalCategory =
                document.getElementById(
                    'modalProductCategory'
                );

            const modalStock =
                document.getElementById(
                    'modalProductStock'
                );

            const modalDescription =
                document.getElementById(
                    'modalProductDescription'
                );

            const modalWhatsapp =
                document.getElementById(
                    'modalProductWhatsapp'
                );




            const closeModal = () => {

                modal?.classList.remove(
                    'show'
                );

                modal?.setAttribute(
                    'aria-hidden',
                    'true'
                );

                body.classList.remove(
                    'menu-open'
                );

            };




            document
                .querySelectorAll(
                    '.menu-detail-btn'
                )
                .forEach(button => {

                    button.addEventListener(
                        'click',
                        () => {

                            const {
                                name,
                                price,
                                category,
                                stock,
                                status,
                                description,
                                image
                            } = button.dataset;


                            if (modalName) {

                                modalName.textContent =
                                    name || 'Menu';

                            }


                            if (modalPrice) {

                                modalPrice.textContent =
                                    `Rp ${price || '0'}`;

                            }


                            if (modalCategory) {

                                modalCategory.textContent =
                                    category || 'Menu';

                            }


                            if (modalStock) {

                                modalStock.textContent =
                                    `${status || 'Tersedia'} • ${stock || '0'} tersedia`;

                            }


                            if (modalDescription) {

                                modalDescription.textContent =
                                    description ||
                                    'Tidak ada deskripsi menu.';

                            }


                            if (modalImage) {

                                modalImage.src =
                                    image || '';

                                modalImage.alt =
                                    name || 'Menu';

                            }




                            if (modalWhatsapp) {

                                const phone = body.dataset.whatsapp || '';


                                if (phone) {

                                    const message =
                                        `Halo, saya ingin pesan "${name}". Apakah masih tersedia?`;


                                    modalWhatsapp.href =
                                        `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;

                                }

                            }


                            modal?.classList.add(
                                'show'
                            );

                            modal?.setAttribute(
                                'aria-hidden',
                                'false'
                            );

                            body.classList.add(
                                'menu-open'
                            );

                        }
                    );

                });




            closeModalButton?.addEventListener(
                'click',
                closeModal
            );




            modal?.addEventListener(
                'click',
                event => {

                    if (

                        event.target === modal ||

                        event.target.classList.contains(
                            'menu-modal-overlay'
                        )

                    ) {

                        closeModal();

                    }

                }
            );




            document.addEventListener(
                'keydown',
                event => {

                    if (
                        event.key === 'Escape'
                    ) {

                        closeModal();

                        closeMobileMenu();

                    }

                }
            );




            const backTop =
                document.getElementById(
                    'backTop'
                );


            const updateScroll = () => {

                navbar?.classList.toggle(
                    'scrolled',
                    window.scrollY > 20
                );


                backTop?.classList.toggle(
                    'show',
                    window.scrollY > 500
                );

            };


            window.addEventListener(
                'scroll',
                updateScroll, {
                    passive: true
                }
            );


            updateScroll();




            backTop?.addEventListener(
                'click',
                () => {

                    window.scrollTo({

                        top: 0,

                        behavior: 'smooth'

                    });

                }
            );




            const sections = [
                ...document.querySelectorAll(
                    'main section[id]'
                )
            ];


            const navLinks = [
                ...document.querySelectorAll(
                    '.desktop-nav a'
                )
            ];


            if (
                sections.length &&
                navLinks.length &&
                'IntersectionObserver' in window
            ) {

                const activeSection =
                    new IntersectionObserver(
                        entries => {

                            entries.forEach(
                                entry => {

                                    if (
                                        !entry.isIntersecting
                                    ) {

                                        return;

                                    }


                                    navLinks.forEach(
                                        link => {

                                            link.classList.toggle(

                                                'active',

                                                link.getAttribute(
                                                    'href'
                                                ) ===
                                                `#${entry.target.id}`

                                            );

                                        }
                                    );

                                }
                            );

                        }, {
                            rootMargin: '-35% 0px -55% 0px'
                        }
                    );


                sections.forEach(
                    section => {

                        activeSection.observe(
                            section
                        );

                    }
                );

            }




            const revealItems =
                document.querySelectorAll(
                    '.category-card, .menu-card, .experience-content, .experience-photo, .cta-box'
                );


            if (
                'IntersectionObserver' in window
            ) {

                const revealObserver =
                    new IntersectionObserver(
                        entries => {

                            entries.forEach(
                                entry => {

                                    if (
                                        entry.isIntersecting
                                    ) {

                                        entry.target.classList.add(
                                            'revealed'
                                        );


                                        revealObserver.unobserve(
                                            entry.target
                                        );

                                    }

                                }
                            );

                        }, {
                            threshold: .08
                        }
                    );


                revealItems.forEach(
                    item => {

                        revealObserver.observe(
                            item
                        );

                    }
                );

            } else {

                revealItems.forEach(
                    item => {

                        item.classList.add(
                            'revealed'
                        );

                    }
                );

            }




            window.addEventListener(
                'resize',
                () => {

                    if (
                        window.innerWidth > 820
                    ) {

                        closeMobileMenu();

                    }

                }
            );

        });
    </script>

</body>

</html>
