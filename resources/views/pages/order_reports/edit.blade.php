@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
@endpush

@section('title', 'Edit Transaksi')

@section('content')

    <div class="order-page">

        <div class="expense-header">
            <div class="expense-header-info">
                <span class="expense-eyebrow">MARIMOI • TRANSAKSI • EDIT ORDER</span>
                <p>Koreksi transaksi #{{ $order->id }}. Stok dan stamp member akan otomatis disesuaikan.</p>
            </div>
        </div>

        <div class="filter-card" style="margin-bottom: 20px;">
            <div class="filter-header">
                <div>
                    <span class="section-eyebrow">PERINGATAN</span>
                    <h3 style="color:#B85C4A;">Perubahan ini otomatis mengoreksi stok & stamp</h3>
                </div>
            </div>
            <p style="color:#7A6F68; font-size:13px; line-height:1.6;">
                Stok produk lama akan dikembalikan, stok produk baru akan dipotong.
                Kalau order ini sebelumnya memberi stamp ke member, stamp itu akan
                ditarik dulu lalu dievaluasi ulang dari awal berdasarkan data yang
                baru (minimal Rp 22.000 &amp; belum dapat stamp di hari yang sama).
            </p>
        </div>

        <form method="POST" action="{{ route('orders.update', $order->id) }}" id="editOrderForm">
            @csrf
            @method('PUT')

            <div class="filter-card" style="margin-bottom: 20px;">

                <div class="filter-header">
                    <div>
                        <span class="section-eyebrow">INFO TRANSAKSI</span>
                        <h3>Detail Order</h3>
                    </div>
                </div>

                <div class="filter-grid" style="grid-template-columns: repeat(3, minmax(0,1fr));">

                    <div class="form-group">
                        <label>Kode Member (opsional)</label>
                        <input type="text" name="member_code" value="{{ old('member_code', $order->member_code) }}"
                            placeholder="MM-XXXXXXXXXX">
                    </div>

                    <div class="form-group">
                        <label>Metode Pembayaran</label>
                        <select name="payment_method">
                            <option value="Cash" @selected(old('payment_method', $order->payment_method) == 'Cash')>Cash</option>
                            <option value="Transfer" @selected(old('payment_method', $order->payment_method) == 'Transfer')>Transfer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Waktu Transaksi</label>
                        <input type="datetime-local" name="transaction_time"
                            value="{{ \Carbon\Carbon::parse(old('transaction_time', $order->transaction_time))->format('Y-m-d\TH:i') }}">
                    </div>

                    <div class="form-group">
                        <label>Nomor Meja (opsional)</label>
                        <input type="number" name="table_number" value="{{ old('table_number', $order->table_number) }}">
                    </div>

                    <div class="form-group">
                        <label>Nama Customer (opsional)</label>
                        <input type="text" name="customer_name"
                            value="{{ old('customer_name', $order->customer_name) }}">
                    </div>

                </div>
            </div>

            <div class="table-card order-items-card" style="margin-bottom: 20px;">

                <div class="table-header order-items-header">

                    <div class="order-items-title">

                        <div class="order-items-icon">
                            <i data-lucide="shopping-bag"></i>
                        </div>

                        <div>
                            <span class="section-label">ITEM</span>
                            <h3>Rincian Produk</h3>
                            <p>Atur produk, jumlah, dan harga transaksi.</p>
                        </div>

                    </div>

                    <button type="button" class="btn-primary add-item-btn" id="addItemBtn">
                        <i data-lucide="plus"></i>
                        <span>Tambah Item</span>
                    </button>

                </div>


                <div class="order-items-wrapper">

                    <table class="expense-table order-items-table" id="itemsTable">

                        <thead>
                            <tr>

                                <th class="product-column">
                                    <span>Produk</span>
                                </th>

                                <th class="qty-column">
                                    <span>Qty</span>
                                </th>

                                <th class="price-column">
                                    <span>Harga Satuan</span>
                                </th>

                                <th class="subtotal-column">
                                    <span>Subtotal</span>
                                </th>

                                <th class="action-column">
                                </th>

                            </tr>
                        </thead>

                        <tbody id="itemsBody">

                            @foreach ($order->orderItems as $i => $item)
                                <tr class="item-row">

                                    {{-- PRODUK --}}
                                    <td class="product-cell">

                                        <div class="item-product-wrapper">

                                            <div class="item-product-icon">
                                                <i data-lucide="coffee"></i>
                                            </div>

                                            <select name="items[{{ $i }}][product_id]" class="item-product"
                                                required>

                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                        @selected($product->id == $item->product_id)>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                        </div>

                                    </td>


                                    {{-- QTY --}}
                                    <td class="qty-cell">

                                        <div class="number-input-wrapper">

                                            <input type="number" name="items[{{ $i }}][quantity]"
                                                class="item-qty" value="{{ $item->quantity }}" min="1"
                                                step="1" required>

                                        </div>

                                    </td>


                                    {{-- HARGA --}}
                                    <td class="price-cell">

                                        <div class="price-input-wrapper">

                                            <span class="currency-prefix">Rp</span>

                                            <input type="number" name="items[{{ $i }}][price]"
                                                class="item-price" value="{{ (int) $item->price }}" min="0"
                                                step="1" required>

                                        </div>

                                    </td>


                                    {{-- SUBTOTAL --}}
                                    <td class="subtotal-cell">

                                        <div class="subtotal-content">

                                            <span class="subtotal-label">
                                                Subtotal
                                            </span>

                                            <strong class="item-subtotal">
                                                Rp
                                                {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                            </strong>

                                        </div>

                                    </td>


                                    {{-- ACTION --}}
                                    <td class="action-cell">

                                        <button type="button" class="action-button delete remove-item-btn"
                                            title="Hapus item">
                                            <i data-lucide="trash-2"></i>
                                        </button>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- FOOTER TOTAL ITEM --}}
                <div class="items-footer">

                    <div class="items-count">

                        <div class="items-count-icon">
                            <i data-lucide="layers-3"></i>
                        </div>

                        <div>
                            <span>Total item</span>

                            <strong id="totalItemDisplay">
                                {{ $order->total_item ?? $order->orderItems->sum('quantity') }}
                            </strong>
                        </div>

                    </div>

                    <div class="items-footer-note">
                        <i data-lucide="info"></i>
                        <span>Subtotal dihitung otomatis dari qty × harga satuan.</span>
                    </div>

                </div>

            </div>

            <div class="filter-card" style="margin-bottom: 20px;">

                <div class="filter-header">
                    <div>
                        <span class="section-eyebrow">RINCIAN BIAYA</span>
                        <h3>Diskon, Pajak &amp; Service Charge</h3>
                    </div>
                </div>

                <div class="filter-grid" style="grid-template-columns: repeat(4, minmax(0,1fr));">

                    <div class="form-group">
                        <label>Subtotal (otomatis)</label>
                        <input type="text" id="subTotalDisplay"
                            value="Rp {{ number_format($order->sub_total, 0, ',', '.') }}" disabled>
                    </div>

                    <div class="form-group">
                        <label>Diskon (Rp)</label>
                        <input type="number" name="discount_amount" id="discountAmount"
                            value="{{ old('discount_amount', (int) $order->discount_amount) }}" min="0"
                            step="1">
                    </div>

                    {{-- <div class="form-group">
                        <label>Pajak (Rp)</label>
                        <input type="number" name="tax" id="taxAmount" value="{{ old('tax', (int) $order->tax) }}"
                            min="0" step="1">
                    </div> --}}
                    <div class="form-group">
                        <label>
                            Pajak
                            <span style="color:#A9714F;">(10%)</span>
                        </label>

                        <input type="number" name="tax" id="taxAmount" value="{{ old('tax', (int) $order->tax) }}"
                            min="0" step="1" readonly
                            style="
                                font-weight:700;
                                color:#6F4936;
                                background:#FCF9F6;
                                cursor:not-allowed;
                            ">
                    </div>

                    <div class="form-group">
                        <label>
                            Service Charge
                            <span style="color:#A9714F;">(5%)</span>
                        </label>

                        <input type="number" name="service_charge" id="serviceChargeAmount"
                            value="{{ old('service_charge', (int) $order->service_charge) }}" min="0"
                            step="1" readonly
                            style="
                                font-weight:700;
                                color:#6F4936;
                                background:#FCF9F6;
                                cursor:not-allowed;
                            ">
                    </div>

                    <div class="form-group">
                        <label>Total Akhir (otomatis)</label>
                        <input type="text" id="totalDisplay"
                            value="Rp {{ number_format($order->total, 0, ',', '.') }}" disabled
                            style="font-weight:800; color:#2B1710;">
                    </div>

                    <div class="form-group">
                        <label>Nominal Dibayar (Rp)</label>
                        <input type="number" name="payment_amount" id="paymentAmountInput"
                            value="{{ old('payment_amount', (int) $order->payment_amount) }}" min="0"
                            step="1">
                    </div>

                </div>

            </div>

            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <a href="{{ route('orders.index') }}" class="btn-reset"
                    style="width:auto; padding:0 20px; display:inline-flex; align-items:center;">Batal</a>
                <button type="submit" class="btn-primary">
                    <i data-lucide="save"></i>
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const itemsBody = document.getElementById('itemsBody');
            const addItemBtn = document.getElementById('addItemBtn');

            const discountInput = document.getElementById('discountAmount');
            const taxInput = document.getElementById('taxAmount');
            const serviceInput = document.getElementById('serviceChargeAmount');
            const subTotalDisplay = document.getElementById('subTotalDisplay');
            const totalDisplay = document.getElementById('totalDisplay');
            const paymentAmountInput = document.getElementById('paymentAmountInput');

            const productOptionsHtml = document.querySelector('.item-product')?.innerHTML || '';

            function formatRupiah(value) {
                return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
            }

            function recalcAll() {

                let subTotal = 0;
                let totalItem = 0;

                /*
                |--------------------------------------------------------------------------
                | HITUNG ITEM
                |--------------------------------------------------------------------------
                */

                document.querySelectorAll('.item-row').forEach(function(row) {

                    const qtyInput =
                        row.querySelector('.item-qty');

                    const priceInput =
                        row.querySelector('.item-price');

                    const subtotalElement =
                        row.querySelector('.item-subtotal');

                    const qty =
                        parseFloat(qtyInput.value) || 0;

                    const price =
                        parseFloat(priceInput.value) || 0;

                    const rowSubtotal =
                        qty * price;

                    subtotalElement.textContent =
                        formatRupiah(rowSubtotal);

                    subTotal += rowSubtotal;

                    totalItem += qty;
                });


                /*
                |--------------------------------------------------------------------------
                | DISKON
                |--------------------------------------------------------------------------
                */

                const discount =
                    parseFloat(discountInput.value) || 0;


                /*
                |--------------------------------------------------------------------------
                | PAJAK 10%
                |--------------------------------------------------------------------------
                |
                | Pajak otomatis = 10% dari subtotal setelah diskon.
                |
                */

                const taxableAmount =
                    Math.max(0, subTotal - discount);

                const tax =
                    Math.round(taxableAmount * 0.10);


                /*
                |--------------------------------------------------------------------------
                | UPDATE INPUT PAJAK
                |--------------------------------------------------------------------------
                */

                taxInput.value = tax;


                /*
                |--------------------------------------------------------------------------
                | SERVICE CHARGE
                |--------------------------------------------------------------------------
                */

                const service =
                    Math.round(subTotal * 0.05);

                serviceInput.value = service;


                /*
                |--------------------------------------------------------------------------
                | TOTAL AKHIR
                |--------------------------------------------------------------------------
                */

                const total =
                    taxableAmount +
                    tax +
                    service;


                /*
                |--------------------------------------------------------------------------
                | UPDATE DISPLAY
                |--------------------------------------------------------------------------
                */

                subTotalDisplay.value =
                    formatRupiah(subTotal);

                totalDisplay.value =
                    formatRupiah(total);


                /*
                |--------------------------------------------------------------------------
                | TOTAL ITEM
                |--------------------------------------------------------------------------
                */

                const totalItemDisplay =
                    document.getElementById('totalItemDisplay');

                if (totalItemDisplay) {

                    totalItemDisplay.textContent =
                        Number.isInteger(totalItem) ?
                        totalItem :
                        totalItem.toFixed(1);
                }


                /*
                |--------------------------------------------------------------------------
                | NOMINAL DIBAYAR
                |--------------------------------------------------------------------------
                */

                if (!paymentAmountInput.dataset.touched) {

                    paymentAmountInput.value =
                        Math.max(
                            0,
                            Math.round(total)
                        );
                }
            }

            paymentAmountInput.addEventListener('input', function() {
                paymentAmountInput.dataset.touched = 'true';
            });

            function reindexRows() {
                document.querySelectorAll('.item-row').forEach(function(row, index) {
                    row.querySelector('.item-product').setAttribute('name', `items[${index}][product_id]`);
                    row.querySelector('.item-qty').setAttribute('name', `items[${index}][quantity]`);
                    row.querySelector('.item-price').setAttribute('name', `items[${index}][price]`);
                });
            }

            function bindRowEvents(row) {
                row.querySelector('.item-qty').addEventListener('input', recalcAll);
                row.querySelector('.item-price').addEventListener('input', recalcAll);

                row.querySelector('.item-product').addEventListener('change', function(e) {
                    const selected = e.target.selectedOptions[0];
                    const price = selected ? selected.dataset.price : 0;
                    row.querySelector('.item-price').value = price;
                    recalcAll();
                });

                row.querySelector('.remove-item-btn').addEventListener('click', function() {
                    if (document.querySelectorAll('.item-row').length <= 1) {
                        alert('Order harus punya minimal 1 item.');
                        return;
                    }
                    row.remove();
                    reindexRows();
                    recalcAll();
                });
            }

            document.querySelectorAll('.item-row').forEach(bindRowEvents);

            addItemBtn.addEventListener('click', function() {
                const index = document.querySelectorAll('.item-row').length;

                const row = document.createElement('tr');
                row.className = 'item-row';
                row.innerHTML = `
            <td>
                <select name="items[${index}][product_id]" class="item-product" required>
                    ${productOptionsHtml}
                </select>
            </td>
            <td>
                <input type="number" name="items[${index}][quantity]" class="item-qty" value="1" min="1" step="1" required>
            </td>
            <td>
                <input type="number" name="items[${index}][price]" class="item-price" value="0" min="0" step="1" required>
            </td>
            <td class="item-subtotal">Rp 0</td>
            <td>
                <button type="button" class="action-button delete remove-item-btn" title="Hapus item">
                    <i data-lucide="trash-2"></i>
                </button>
            </td>
        `;

                itemsBody.appendChild(row);
                bindRowEvents(row);

                const firstOption = row.querySelector('.item-product').selectedOptions[0];
                if (firstOption) {
                    row.querySelector('.item-price').value = firstOption.dataset.price || 0;
                }

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

                recalcAll();
            });

            [discountInput, taxInput, serviceInput].forEach(function(el) {
                el.addEventListener('input', recalcAll);
            });

            recalcAll();
        });
    </script>
@endpush
