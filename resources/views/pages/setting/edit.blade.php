@extends('layouts.app')

@section('title','Pengaturan Website')

@section('content')

<div class="page-header">

    <div>

        <h2>Pengaturan Website</h2>

        <p>
            Kelola informasi toko, tampilan landing page, kontak, dan SEO.
        </p>

    </div>

</div>

@if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

@endif

<form
    method="POST"
    action="{{ route('settings.update') }}"
    enctype="multipart/form-data">

    @csrf
    @method('PUT')

    {{-- =====================================================
         INFORMASI TOKO
    ===================================================== --}}

    <div class="card">

        <div class="card-body">

            <h3 class="form-section-title">Informasi Toko</h3>

            <div class="form-group">

                <label class="form-label">Nama Toko</label>

                <input
                    type="text"
                    name="store_name"
                    value="{{ old('store_name', $setting->store_name) }}"
                    class="form-control @error('store_name') is-invalid @enderror">

                @error('store_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label class="form-label">Tagline</label>

                <input
                    type="text"
                    name="store_tagline"
                    value="{{ old('store_tagline', $setting->store_tagline) }}"
                    class="form-control @error('store_tagline') is-invalid @enderror"
                    placeholder="Contoh: Kopi, makan, dan cerita">

                @error('store_tagline')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label class="form-label">Deskripsi Toko</label>

                <textarea
                    name="store_description"
                    rows="3"
                    class="form-control @error('store_description') is-invalid @enderror"
                    placeholder="Deskripsi singkat tentang cafe, dipakai juga untuk SEO description default.">{{ old('store_description', $setting->store_description) }}</textarea>

                @error('store_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

        </div>

    </div>

    {{-- =====================================================
         LOGO & FAVICON
    ===================================================== --}}

    <div class="card">

        <div class="card-body">

            <h3 class="form-section-title">Logo & Favicon</h3>

            <div class="form-row">

                <div class="form-group">

                    <label class="form-label">Logo</label>

                    @if($setting->logo)

                        <div class="image-preview">

                            <img src="{{ $setting->logo_url }}" alt="Logo saat ini">

                        </div>

                    @endif

                    <input
                        type="file"
                        name="logo"
                        accept="image/*"
                        class="form-control @error('logo') is-invalid @enderror">

                    <small class="form-hint">Format PNG/JPG, maksimal 2MB.</small>

                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="form-group">

                    <label class="form-label">Favicon</label>

                    @if($setting->favicon)

                        <div class="image-preview image-preview-sm">

                            <img src="{{ $setting->favicon_url }}" alt="Favicon saat ini">

                        </div>

                    @endif

                    <input
                        type="file"
                        name="favicon"
                        accept="image/*"
                        class="form-control @error('favicon') is-invalid @enderror">

                    <small class="form-hint">Format PNG/ICO, maksimal 1MB.</small>

                    @error('favicon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

            </div>

        </div>

    </div>

    {{-- =====================================================
         HERO LANDING PAGE
    ===================================================== --}}

    <div class="card">

        <div class="card-body">

            <h3 class="form-section-title">Hero Landing Page</h3>

            <div class="form-group">

                <label class="form-label">Judul Hero</label>

                <input
                    type="text"
                    name="hero_title"
                    value="{{ old('hero_title', $setting->hero_title) }}"
                    class="form-control @error('hero_title') is-invalid @enderror"
                    placeholder="Contoh: Secangkir Kopi, Sepiring Cerita.">

                @error('hero_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label class="form-label">Subjudul Hero</label>

                <textarea
                    name="hero_subtitle"
                    rows="2"
                    class="form-control @error('hero_subtitle') is-invalid @enderror">{{ old('hero_subtitle', $setting->hero_subtitle) }}</textarea>

                @error('hero_subtitle')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label class="form-label">Teks Tombol Hero</label>

                <input
                    type="text"
                    name="hero_button"
                    value="{{ old('hero_button', $setting->hero_button) }}"
                    class="form-control @error('hero_button') is-invalid @enderror"
                    placeholder="Contoh: Lihat Menu">

                @error('hero_button')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

        </div>

    </div>

    {{-- =====================================================
         KONTAK
    ===================================================== --}}

    <div class="card">

        <div class="card-body">

            <h3 class="form-section-title">Kontak</h3>

            <div class="form-row">

                <div class="form-group">

                    <label class="form-label">Nomor Telepon</label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $setting->phone) }}"
                        class="form-control @error('phone') is-invalid @enderror"
                        placeholder="Contoh: 0431123456">

                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="form-group">

                    <label class="form-label">Nomor WhatsApp</label>

                    <input
                        type="text"
                        name="whatsapp"
                        value="{{ old('whatsapp', $setting->whatsapp) }}"
                        class="form-control @error('whatsapp') is-invalid @enderror"
                        placeholder="Contoh: 62812xxxxxxx (tanpa tanda +)">

                    @error('whatsapp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

            </div>

            <div class="form-group">

                <label class="form-label">Email</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $setting->email) }}"
                    class="form-control @error('email') is-invalid @enderror">

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label class="form-label">Alamat</label>

                <textarea
                    name="address"
                    rows="2"
                    class="form-control @error('address') is-invalid @enderror">{{ old('address', $setting->address) }}</textarea>

                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label class="form-label">Embed Google Maps</label>

                <textarea
                    name="google_maps"
                    rows="3"
                    class="form-control @error('google_maps') is-invalid @enderror"
                    placeholder="Tempel kode embed <iframe> dari Google Maps di sini">{{ old('google_maps', $setting->google_maps) }}</textarea>

                @error('google_maps')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

        </div>

    </div>

    {{-- =====================================================
         SOCIAL MEDIA
    ===================================================== --}}

    <div class="card">

        <div class="card-body">

            <h3 class="form-section-title">Social Media</h3>

            <div class="form-row">

                <div class="form-group">

                    <label class="form-label">Facebook</label>

                    <input
                        type="url"
                        name="facebook"
                        value="{{ old('facebook', $setting->facebook) }}"
                        class="form-control @error('facebook') is-invalid @enderror"
                        placeholder="https://facebook.com/...">

                    @error('facebook')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="form-group">

                    <label class="form-label">Instagram</label>

                    <input
                        type="url"
                        name="instagram"
                        value="{{ old('instagram', $setting->instagram) }}"
                        class="form-control @error('instagram') is-invalid @enderror"
                        placeholder="https://instagram.com/...">

                    @error('instagram')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

            </div>

            <div class="form-row">

                <div class="form-group">

                    <label class="form-label">YouTube</label>

                    <input
                        type="url"
                        name="youtube"
                        value="{{ old('youtube', $setting->youtube) }}"
                        class="form-control @error('youtube') is-invalid @enderror"
                        placeholder="https://youtube.com/...">

                    @error('youtube')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="form-group">

                    <label class="form-label">TikTok</label>

                    <input
                        type="url"
                        name="tiktok"
                        value="{{ old('tiktok', $setting->tiktok) }}"
                        class="form-control @error('tiktok') is-invalid @enderror"
                        placeholder="https://tiktok.com/@...">

                    @error('tiktok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

            </div>

        </div>

    </div>

    {{-- =====================================================
         SEO
    ===================================================== --}}

    <div class="card">

        <div class="card-body">

            <h3 class="form-section-title">SEO</h3>

            <div class="form-group">

                <label class="form-label">Meta Title</label>

                <input
                    type="text"
                    name="meta_title"
                    value="{{ old('meta_title', $setting->meta_title) }}"
                    class="form-control @error('meta_title') is-invalid @enderror">

                @error('meta_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label class="form-label">Meta Description</label>

                <textarea
                    name="meta_description"
                    rows="2"
                    class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $setting->meta_description) }}</textarea>

                @error('meta_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label class="form-label">Meta Keywords</label>

                <input
                    type="text"
                    name="meta_keywords"
                    value="{{ old('meta_keywords', $setting->meta_keywords) }}"
                    class="form-control @error('meta_keywords') is-invalid @enderror"
                    placeholder="Pisahkan dengan koma, contoh: cafe, kopi, kopi manado">

                @error('meta_keywords')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

        </div>

    </div>

    {{-- =====================================================
         FOOTER & STATUS WEBSITE
    ===================================================== --}}

    <div class="card">

        <div class="card-body">

            <h3 class="form-section-title">Footer & Status Website</h3>

            <div class="form-group">

                <label class="form-label">Teks Copyright</label>

                <input
                    type="text"
                    name="copyright"
                    value="{{ old('copyright', $setting->copyright) }}"
                    class="form-control @error('copyright') is-invalid @enderror"
                    placeholder="Contoh: © 2026 Marimoi Cafe. All rights reserved.">

                @error('copyright')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group form-check">

                <input
                    type="checkbox"
                    name="maintenance_mode"
                    value="1"
                    id="maintenance_mode"
                    class="form-check-input"
                    {{ old('maintenance_mode', $setting->maintenance_mode) ? 'checked' : '' }}>

                <label
                    for="maintenance_mode"
                    class="form-check-label">

                    Aktifkan Mode Maintenance

                </label>

                <small class="form-hint">
                    Kalau diaktifkan, landing page akan menampilkan halaman "sedang dalam perbaikan" ke pengunjung.
                </small>

            </div>

        </div>

    </div>

    <div class="form-actions">

        <button
            type="submit"
            class="btn btn-primary">

            Simpan Pengaturan

        </button>

    </div>

</form>

@endsection
