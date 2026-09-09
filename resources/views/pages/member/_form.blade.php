{{--
    Partial form dipakai bersama oleh create.blade.php dan edit.blade.php.
    $member bernilai null saat create, dan berisi instance MemberBarcode saat edit.
--}}

<div class="form-group">

    <label class="form-label">Pengguna</label>

    <select
        name="user_id"
        class="form-control @error('user_id') is-invalid @enderror">

        <option value="">-- Pilih Pengguna --</option>

        @foreach($users as $user)

            <option
                value="{{ $user->id }}"
                {{ old('user_id', $member->user_id ?? null) == $user->id ? 'selected' : '' }}>

                {{ $user->name }} ({{ $user->email }})

            </option>

        @endforeach

    </select>

    @error('user_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="form-group">

    <label class="form-label">Tanggal Lahir</label>

    <input
        type="date"
        name="birth_date"
        value="{{ old('birth_date', optional($member?->birth_date)->format('Y-m-d')) }}"
        class="form-control @error('birth_date') is-invalid @enderror">

    @error('birth_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="form-group">

    <label class="form-label">Kode Barcode</label>

    <div class="input-group">

        <input
            type="text"
            id="code"
            name="code"
            value="{{ old('code', $member->code ?? '') }}"
            class="form-control @error('code') is-invalid @enderror"
            placeholder="Contoh: MRM-AB12CD34">

        <button
            type="button"
            id="generateCodeBtn"
            class="btn btn-secondary">

            Generate

        </button>

    </div>

    @error('code')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="form-row">

    <div class="form-group">

        <label class="form-label">Tipe Diskon</label>

        <select
            name="discount_type"
            class="form-control @error('discount_type') is-invalid @enderror">

            <option
                value="percentage"
                {{ old('discount_type', $member->discount_type ?? 'percentage') == 'percentage' ? 'selected' : '' }}>

                Persentase (%)

            </option>

            <option
                value="fixed"
                {{ old('discount_type', $member->discount_type ?? 'percentage') == 'fixed' ? 'selected' : '' }}>

                Nominal (Rp)

            </option>

        </select>

        @error('discount_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="form-group">

        <label class="form-label">Nilai Diskon</label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="discount_value"
            value="{{ old('discount_value', $member->discount_value ?? 0) }}"
            class="form-control @error('discount_value') is-invalid @enderror">

        @error('discount_value')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

</div>

@isset($member)

    <div class="form-group">

        <label class="form-label">Jumlah Stamp Terkumpul</label>

        <input
            type="number"
            min="0"
            name="stamp_count"
            value="{{ old('stamp_count', $member->stamp_count) }}"
            class="form-control @error('stamp_count') is-invalid @enderror">

        @error('stamp_count')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

@endisset

<div class="form-group">

    <label class="form-label">Target Stamp</label>

    <input
        type="number"
        min="1"
        name="stamp_target"
        value="{{ old('stamp_target', $member->stamp_target ?? 10) }}"
        class="form-control @error('stamp_target') is-invalid @enderror">

    @error('stamp_target')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="form-row">

    <div class="form-group">

        <label class="form-label">Berlaku Dari</label>

        <input
            type="datetime-local"
            name="valid_from"
            value="{{ old('valid_from', optional($member?->valid_from)->format('Y-m-d\TH:i')) }}"
            class="form-control @error('valid_from') is-invalid @enderror">

        @error('valid_from')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="form-group">

        <label class="form-label">Berlaku Sampai</label>

        <input
            type="datetime-local"
            name="valid_until"
            value="{{ old('valid_until', optional($member?->valid_until)->format('Y-m-d\TH:i')) }}"
            class="form-control @error('valid_until') is-invalid @enderror">

        @error('valid_until')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

</div>

<div class="form-group form-check">

    <input
        type="checkbox"
        name="is_active"
        value="1"
        id="is_active"
        class="form-check-input"
        {{ old('is_active', $member->is_active ?? true) ? 'checked' : '' }}>

    <label
        for="is_active"
        class="form-check-label">

        Barcode Aktif

    </label>

</div>
