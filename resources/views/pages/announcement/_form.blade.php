<div class="form-group">

    <label class="form-label">Judul</label>

    <input
        type="text"
        name="title"
        value="{{ old('title', $announcement->title ?? '') }}"
        class="form-control @error('title') is-invalid @enderror"
        placeholder="Contoh: Promo Akhir Pekan!">

    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="form-group">

    <label class="form-label">Pesan</label>

    <textarea
        name="message"
        rows="4"
        class="form-control @error('message') is-invalid @enderror"
        placeholder="Isi informasi/promo yang mau disampaikan ke member.">{{ old('message', $announcement->message ?? '') }}</textarea>

    <small class="form-hint">
        Hanya 120 karakter pertama yang muncul di notifikasi push, sisanya tetap tampil penuh di kartu dalam app.
    </small>

    @error('message')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="form-group">

    <label class="form-label">Gambar (opsional)</label>

    @if(!empty($announcement) && $announcement->image)

        <div class="image-preview">
            <img src="{{ $announcement->image_url }}" alt="Gambar saat ini">
        </div>

    @endif

    <input
        type="file"
        name="image"
        accept="image/*"
        class="form-control @error('image') is-invalid @enderror">

    <small class="form-hint">Format PNG/JPG, maksimal 2MB.</small>

    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="form-group form-check">

    <input
        type="checkbox"
        name="is_active"
        value="1"
        id="is_active"
        class="form-check-input"
        {{ old('is_active', $announcement->is_active ?? true) ? 'checked' : '' }}>

    <label for="is_active" class="form-check-label">
        Aktifkan & Kirim Notifikasi ke Member
    </label>

    <small class="form-hint">
        @isset($announcement)
            Kalau sebelumnya nonaktif lalu dicentang di sini, notifikasi BARU akan dikirim. Kalau sudah aktif dari awal, mencentang ulang tidak mengirim notifikasi lagi.
        @else
            Kalau dicentang, notifikasi langsung terkirim ke semua member begitu disimpan.
        @endisset
    </small>

</div>
