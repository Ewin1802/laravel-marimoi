@php
    $editing = isset($payment);
    $currentPeriod = old('period', $editing ? $payment->period : ($selected ?? now()->format('Y-m')));
@endphp

<div class="tp-form">

    {{-- KIRI: DATA SETORAN --}}
    <div class="tp-box">
        <h3>Data Setoran</h3>
        <p>Pajak yang disetor tidak mengubah order maupun item order.</p>

        <div class="tp-field">
            <label for="period">Masa Pajak</label>
            <select name="period" id="period">
                @foreach ($periods as $key => $info)
                    <option value="{{ $key }}" @selected($currentPeriod === $key)>{{ $info['label'] }}</option>
                @endforeach
            </select>
            @error('period') <span class="err">{{ $message }}</span> @enderror
        </div>

        <div class="tp-info" id="tpInfo">
            <div><span>Pajak terkumpul</span><span id="infoCollected">-</span></div>
            <div><span>Sudah disetor</span><span id="infoPaid">-</span></div>
            <div class="total"><span>Sisa yang bisa disetor</span><span id="infoRemaining">-</span></div>
        </div>

        <div class="tp-row">
            <div class="tp-field">
                <label for="payment_date">Tanggal Setor</label>
                <input type="date" name="payment_date" id="payment_date"
                    value="{{ old('payment_date', $editing ? $payment->payment_date->toDateString() : now()->toDateString()) }}">
                @error('payment_date') <span class="err">{{ $message }}</span> @enderror
            </div>

            <div class="tp-field">
                <label for="amount">Nominal Setor (Rp)</label>
                <input type="number" name="amount" id="amount" min="1" step="1" placeholder="0"
                    value="{{ old('amount', $editing ? $payment->amount : '') }}">
                @error('amount') <span class="err">{{ $message }}</span> @enderror
                <div class="tp-quick">
                    <button type="button" id="btnAll">Setor semua sisa</button>
                    <button type="button" id="btnHalf">Setengah</button>
                </div>
            </div>
        </div>

        <div class="tp-field">
            <label for="reference">No. Referensi <span style="font-weight:400;color:#8a7b70">(kode billing / NTPN, opsional)</span></label>
            <input type="text" name="reference" id="reference" maxlength="255"
                value="{{ old('reference', $editing ? $payment->reference : '') }}">
            @error('reference') <span class="err">{{ $message }}</span> @enderror
        </div>

        <div class="tp-field">
            <label for="notes">Catatan <span style="font-weight:400;color:#8a7b70">(opsional)</span></label>
            <textarea name="notes" id="notes" maxlength="1000">{{ old('notes', $editing ? $payment->notes : '') }}</textarea>
            @error('notes') <span class="err">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- KANAN: BUKTI --}}
    <div class="tp-box">
        <h3>Bukti Setor</h3>
        <p>Unggah foto atau screenshot bukti pembayaran (JPG / PNG, maks. 4 MB).</p>

        @if ($editing)
            <div class="tp-current">
                <img src="{{ $payment->proof_url }}" alt="Bukti saat ini">
                <small style="color:#8a7b70">Bukti saat ini. Pilih file baru hanya jika ingin menggantinya.</small>
            </div>
        @endif

        <label class="tp-drop">
            <input type="file" name="proof" id="proof" accept="image/png,image/jpeg">
            <i data-lucide="upload-cloud"></i>
            <strong>{{ $editing ? 'Ganti bukti setor' : 'Pilih gambar bukti setor' }}</strong>
            <small>Klik di sini untuk memilih file</small>
        </label>
        @error('proof') <span class="err" style="color:#b03a24;font-size:12.5px">{{ $message }}</span> @enderror

        <div class="tp-preview" id="tpPreview">
            <img src="" alt="Pratinjau bukti" id="tpPreviewImg">
        </div>

        <div class="tp-submit">
            <button class="btn btn-primary" type="submit">
                <i data-lucide="check"></i> {{ $editing ? 'Simpan Perubahan' : 'Simpan Setoran' }}
            </button>
            <a href="{{ route('tax-payments.index') }}" class="btn btn-light">Batal</a>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        (function () {
            const periods = @json($periods);
            const editingAmount = {{ $editing ? (int) $payment->amount : 0 }};
            const editingPeriod = @json($editing ? $payment->period : null);

            const sel = document.getElementById('period');
            const amount = document.getElementById('amount');
            const fmt = n => 'Rp ' + Number(n).toLocaleString('id-ID');

            // Saat edit, nominal setoran ini dianggap belum terpakai
            // supaya "sisa" yang tampil sesuai batas validasi server.
            function remainingFor(key) {
                const p = periods[key];
                if (!p) return 0;
                let paid = p.paid;
                if (editingPeriod === key) paid -= editingAmount;
                return Math.max(p.collected - paid, 0);
            }

            function refresh() {
                const p = periods[sel.value];
                if (!p) return;
                let paid = p.paid;
                if (editingPeriod === sel.value) paid -= editingAmount;
                document.getElementById('infoCollected').textContent = fmt(p.collected);
                document.getElementById('infoPaid').textContent = fmt(paid);
                document.getElementById('infoRemaining').textContent = fmt(remainingFor(sel.value));
            }

            sel.addEventListener('change', refresh);
            document.getElementById('btnAll').addEventListener('click', () => {
                amount.value = remainingFor(sel.value);
            });
            document.getElementById('btnHalf').addEventListener('click', () => {
                amount.value = Math.floor(remainingFor(sel.value) / 2);
            });

            document.getElementById('proof').addEventListener('change', function () {
                const f = this.files[0];
                const box = document.getElementById('tpPreview');
                if (!f) { box.classList.remove('show'); return; }
                document.getElementById('tpPreviewImg').src = URL.createObjectURL(f);
                box.classList.add('show');
            });

            refresh();
        })();
    </script>
@endpush
