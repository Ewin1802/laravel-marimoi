@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
@endpush

@section('title', 'Laporan Transaksi')

@section('content')

    <div class="order-page">

        {{-- =========================================================
        HEADER
    ========================================================== --}}

        <div class="page-header">

            <div class="page-title">

                <div class="title-icon">
                    <i data-lucide="receipt-text"></i>
                </div>

                <div>

                    <h1>Laporan Transaksi</h1>

                    <p>
                        Kelola dan pantau seluruh transaksi Marimoi Cafe.
                    </p>

                </div>

            </div>

            <div class="page-actions">

                <button type="button" class="btn-secondary" onclick="window.print()">

                    <i data-lucide="printer"></i>

                    <span>Cetak</span>

                </button>

            </div>

        </div>


        {{-- =========================================================
        FILTER
    ========================================================== --}}

        <form method="GET" class="filter-card">

            <div class="filter-header">

                <div>

                    <span class="section-eyebrow">
                        FILTER
                    </span>

                    <h3>
                        Periode Transaksi
                    </h3>

                </div>

                <i data-lucide="calendar-days"></i>

            </div>


            <div class="filter-grid">

                <div class="form-group">

                    <label for="range">
                        Periode
                    </label>

                    <select id="range" name="range">

                        <option value="1" {{ $range == 1 ? 'selected' : '' }}>
                            Hari Ini
                        </option>

                        <option value="2" {{ $range == 2 ? 'selected' : '' }}>
                            2 Hari
                        </option>

                        <option value="7" {{ $range == 7 ? 'selected' : '' }}>
                            7 Hari
                        </option>

                        <option value="14" {{ $range == 14 ? 'selected' : '' }}>
                            14 Hari
                        </option>

                        <option value="30" {{ $range == 30 ? 'selected' : '' }}>
                            30 Hari
                        </option>

                        <option value="90" {{ $range == 90 ? 'selected' : '' }}>
                            90 Hari
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="start_date">
                        Dari
                    </label>

                    <input type="date" id="start_date" name="start_date" value="{{ $start_date }}">

                </div>


                <div class="form-group">

                    <label for="end_date">
                        Sampai
                    </label>

                    <input type="date" id="end_date" name="end_date" value="{{ $end_date }}">

                </div>


                <div class="filter-action">

                    <button type="submit" class="btn-primary">

                        <i data-lucide="filter"></i>

                        Terapkan

                    </button>

                </div>

            </div>

        </form>


        {{-- =========================================================
        SUMMARY
    ========================================================== --}}

        <div class="summary-grid">

            <div class="summary-card">

                <div class="summary-icon brown">
                    <i data-lucide="wallet"></i>
                </div>

                <div class="summary-content">

                    <small>Total Pendapatan</small>

                    <h3>
                        Rp
                        {{ number_format($summary['total_revenue'], 0, ',', '.') }}
                    </h3>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon green">
                    <i data-lucide="banknote"></i>
                </div>

                <div class="summary-content">

                    <small>Cash</small>

                    <h3>
                        Rp
                        {{ number_format($summary['total_cash'], 0, ',', '.') }}
                    </h3>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon blue">
                    <i data-lucide="landmark"></i>
                </div>

                <div class="summary-content">

                    <small>Transfer</small>

                    <h3>
                        Rp
                        {{ number_format($summary['total_transfer'], 0, ',', '.') }}
                    </h3>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon orange">
                    <i data-lucide="receipt"></i>
                </div>

                <div class="summary-content">

                    <small>Transaksi</small>

                    <h3>
                        {{ number_format($summary['total_order']) }}
                    </h3>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon purple">
                    <i data-lucide="shopping-bag"></i>
                </div>

                <div class="summary-content">

                    <small>Item Terjual</small>

                    <h3>
                        {{ number_format($summary['total_item']) }}
                    </h3>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon red">
                    <i data-lucide="chart-column"></i>
                </div>

                <div class="summary-content">

                    <small>Rata-rata Transaksi</small>

                    <h3>
                        Rp
                        {{ number_format($summary['average_order'], 0, ',', '.') }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- =========================================================
        CHART
    ========================================================== --}}

        <div class="report-grid">

            <div class="report-card">

                <div class="card-header">

                    <div>

                        <span class="section-eyebrow">
                            PERFORMANCE
                        </span>

                        <h3>
                            Grafik Pendapatan
                        </h3>

                        <small>
                            {{ $range }} hari terakhir
                        </small>

                    </div>

                    <div class="card-header-icon">
                        <i data-lucide="chart-no-axes-column"></i>
                    </div>

                </div>

                <div class="chart-container">

                    <canvas id="salesChart"></canvas>

                </div>

            </div>


            <div class="report-card payment-report">

                <div class="card-header">

                    <div>

                        <span class="section-eyebrow">
                            PAYMENT
                        </span>

                        <h3>
                            Metode Pembayaran
                        </h3>

                        <small>
                            Cash vs Transfer
                        </small>

                    </div>

                    <div class="card-header-icon">
                        <i data-lucide="wallet-cards"></i>
                    </div>

                </div>

                <div class="payment-chart-container">

                    <canvas id="paymentChart"></canvas>

                </div>

            </div>

        </div>


        {{-- =========================================================
        TRANSACTION TABLE
    ========================================================== --}}

        <div class="table-card">

            <div class="table-header">

                <div>

                    <span class="section-eyebrow">
                        TRANSACTIONS
                    </span>

                    <h3>
                        Riwayat Transaksi
                    </h3>

                </div>

                <div class="transaction-count">

                    <strong>
                        {{ $orders->total() }}
                    </strong>

                    transaksi

                </div>

            </div>


            <div class="table-responsive">

                <table class="table">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Invoice</th>

                            <th>Tanggal</th>

                            <th>Kasir</th>

                            <th>Customer</th>

                            <th>Pembayaran</th>

                            <th>Item</th>

                            <th>Total</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($orders as $order)
                            <tr>

                                <td class="row-number">

                                    {{ $orders->firstItem() + $loop->index }}

                                </td>


                                <td>

                                    <span class="invoice-number">

                                        INV{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}

                                    </span>

                                </td>


                                <td>

                                    <div class="date-cell">

                                        <strong>

                                            {{ \Carbon\Carbon::parse($order->transaction_time)->format('d M Y') }}

                                        </strong>

                                        <small>

                                            {{ \Carbon\Carbon::parse($order->transaction_time)->format('H:i') }}

                                        </small>

                                    </div>

                                </td>


                                <td>

                                    {{ $order->nama_kasir ?: '-' }}

                                </td>


                                <td>

                                    <span class="customer-name">

                                        {{ $order->customer_name ?: 'Umum' }}

                                    </span>

                                </td>


                                <td>

                                    @if (strtolower($order->payment_method) === 'cash')
                                        <span class="badge badge-cash">

                                            <i data-lucide="banknote"></i>

                                            Cash

                                        </span>
                                    @else
                                        <span class="badge badge-transfer">

                                            <i data-lucide="landmark"></i>

                                            Transfer

                                        </span>
                                    @endif

                                </td>


                                <td>

                                    <span class="item-count">

                                        {{ $order->total_item }}

                                    </span>

                                </td>


                                <td>

                                    <strong class="table-total">

                                        Rp
                                        {{ number_format($order->payment_amount, 0, ',', '.') }}

                                    </strong>

                                </td>


                                <td>

                                    <button type="button" class="btn-icon btn-view-order" data-id="{{ $order->id }}"
                                        title="Lihat detail" aria-label="Lihat detail transaksi">

                                        <i data-lucide="eye"></i>

                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9" class="empty-table">

                                    <div class="empty-state">

                                        <div class="empty-icon">

                                            <i data-lucide="receipt"></i>

                                        </div>

                                        <h4>
                                            Belum ada transaksi
                                        </h4>

                                        <p>
                                            Tidak ada transaksi pada periode yang dipilih.
                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}

            @if ($orders->hasPages())
                <div class="table-footer">

                    <div class="pagination-info">

                        Menampilkan

                        <strong>
                            {{ $orders->firstItem() }}
                        </strong>

                        -

                        <strong>
                            {{ $orders->lastItem() }}
                        </strong>

                        dari

                        <strong>
                            {{ $orders->total() }}
                        </strong>

                        transaksi

                    </div>

                    <div class="pagination-wrapper">

                        {{ $orders->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>


    {{-- =============================================================
    DETAIL MODAL
============================================================== --}}

    <div class="order-modal" id="orderDetailModal" aria-hidden="true">

        <div class="modal-backdrop" data-close-modal></div>


        <div class="order-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="orderModalTitle">

            {{-- HEADER --}}

            <div class="order-modal-header">

                <div>

                    <span class="section-eyebrow">
                        DETAIL TRANSAKSI
                    </span>

                    <h2 id="orderModalTitle">
                        Detail Pesanan
                    </h2>

                    <p id="modalInvoice">
                        -
                    </p>

                </div>


                <button type="button" class="modal-close" data-close-modal aria-label="Tutup">

                    <i data-lucide="x"></i>

                </button>

            </div>


            {{-- LOADING --}}

            <div class="modal-loading" id="modalLoading">

                <div class="modal-spinner"></div>

                <span>
                    Memuat detail pesanan...
                </span>

            </div>


            {{-- CONTENT --}}

            <div class="order-modal-content" id="modalContent">

                {{-- ORDER INFO --}}

                <div class="order-info-grid">

                    <div class="order-info-item">

                        <span>Customer</span>

                        <strong id="modalCustomer">
                            -
                        </strong>

                    </div>


                    <div class="order-info-item">

                        <span>Nomor Meja</span>

                        <strong id="modalTable">
                            -
                        </strong>

                    </div>


                    <div class="order-info-item">

                        <span>Kasir</span>

                        <strong id="modalCashier">
                            -
                        </strong>

                    </div>


                    <div class="order-info-item">

                        <span>Waktu</span>

                        <strong id="modalDate">
                            -
                        </strong>

                    </div>

                </div>


                {{-- PAYMENT --}}

                <div class="modal-payment-box">

                    <div>

                        <span>Metode Pembayaran</span>

                        <strong id="modalPayment">
                            -
                        </strong>

                    </div>

                    <div class="modal-status">

                        <span>Status</span>

                        <strong id="modalStatus">
                            Selesai
                        </strong>

                    </div>

                </div>


                {{-- ITEMS --}}

                <div class="modal-section">

                    <div class="modal-section-header">

                        <h3>
                            Rincian Pesanan
                        </h3>

                        <span id="modalTotalItem">
                            0 item
                        </span>

                    </div>


                    <div class="modal-items">

                        <table>

                            <thead>

                                <tr>

                                    <th>Produk</th>

                                    <th>Qty</th>

                                    <th>Harga</th>

                                    <th>Total</th>

                                </tr>

                            </thead>

                            <tbody id="modalItemsBody">

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- TOTAL --}}

                <div class="modal-total-box">

                    <div class="total-row">

                        <span>
                            Subtotal
                        </span>

                        <strong id="modalSubtotal">
                            Rp 0
                        </strong>

                    </div>


                    <div class="total-row">

                        <span>
                            Pajak
                        </span>

                        <strong id="modalTax">
                            Rp 0
                        </strong>

                    </div>


                    <div class="total-row">

                        <span>
                            Service Charge
                        </span>

                        <strong id="modalService">
                            Rp 0
                        </strong>

                    </div>


                    <div class="total-row">

                        <span>
                            Diskon
                        </span>

                        <strong id="modalDiscount">
                            Rp 0
                        </strong>

                    </div>


                    <div class="total-divider"></div>


                    <div class="total-row total-final">

                        <span>
                            Total
                        </span>

                        <strong id="modalTotal">
                            Rp 0
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                /*
                |--------------------------------------------------------------------------
                | FORMAT RUPIAH
                |--------------------------------------------------------------------------
                */

                function formatRupiah(value) {

                    value = Number(value || 0);

                    return 'Rp ' + value.toLocaleString(
                        'id-ID'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | FORMAT TANGGAL
                |--------------------------------------------------------------------------
                */

                function formatDate(value) {

                    if (!value) {
                        return '-';
                    }

                    const date = new Date(
                        value.replace('T', ' ')
                    );

                    if (isNaN(date.getTime())) {
                        return value;
                    }

                    return date.toLocaleDateString(
                        'id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | MODAL
                |--------------------------------------------------------------------------
                */

                const modal =
                    document.getElementById(
                        'orderDetailModal'
                    );

                const modalLoading =
                    document.getElementById(
                        'modalLoading'
                    );

                const modalContent =
                    document.getElementById(
                        'modalContent'
                    );


                function openModal() {

                    modal.classList.add('show');

                    modal.setAttribute(
                        'aria-hidden',
                        'false'
                    );

                    document.body.classList.add(
                        'modal-open'
                    );

                }


                function closeModal() {

                    modal.classList.remove('show');

                    modal.setAttribute(
                        'aria-hidden',
                        'true'
                    );

                    document.body.classList.remove(
                        'modal-open'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | RESET MODAL
                |--------------------------------------------------------------------------
                */

                function resetModal() {

                    modalLoading.style.display =
                        'flex';

                    modalContent.style.display =
                        'none';

                    document.getElementById(
                        'modalInvoice'
                    ).textContent = '-';

                    document.getElementById(
                        'modalCustomer'
                    ).textContent = '-';

                    document.getElementById(
                        'modalTable'
                    ).textContent = '-';

                    document.getElementById(
                        'modalCashier'
                    ).textContent = '-';

                    document.getElementById(
                        'modalDate'
                    ).textContent = '-';

                    document.getElementById(
                        'modalPayment'
                    ).textContent = '-';

                    document.getElementById(
                        'modalStatus'
                    ).textContent = 'Selesai';

                    document.getElementById(
                        'modalItemsBody'
                    ).innerHTML = '';

                    document.getElementById(
                        'modalSubtotal'
                    ).textContent = 'Rp 0';

                    document.getElementById(
                        'modalTax'
                    ).textContent = 'Rp 0';

                    document.getElementById(
                        'modalService'
                    ).textContent = 'Rp 0';

                    document.getElementById(
                        'modalDiscount'
                    ).textContent = 'Rp 0';

                    document.getElementById(
                        'modalTotal'
                    ).textContent = 'Rp 0';

                    document.getElementById(
                        'modalTotalItem'
                    ).textContent = '0 item';

                }


                /*
                |--------------------------------------------------------------------------
                | LOAD ORDER
                |--------------------------------------------------------------------------
                */

                async function loadOrder(orderId) {

                    resetModal();

                    openModal();


                    try {

                        const response =
                            await fetch(
                                "{{ url('/orders') }}/" +
                                orderId, {
                                    method: 'GET',

                                    headers: {

                                        'Accept': 'application/json',

                                        'X-Requested-With': 'XMLHttpRequest'

                                    }

                                }
                            );


                        if (!response.ok) {

                            throw new Error(
                                'Gagal mengambil detail transaksi.'
                            );

                        }


                        const result =
                            await response.json();


                        if (
                            result.status !==
                            'success'
                        ) {

                            throw new Error(
                                'Data transaksi tidak valid.'
                            );

                        }


                        const order =
                            result.order;


                        const items =
                            result.items || [];


                        /*
                        |--------------------------------------------------------------------------
                        | INFO
                        |--------------------------------------------------------------------------
                        */

                        document.getElementById(
                                'modalInvoice'
                            ).textContent =
                            order.invoice;

                        document.getElementById(
                                'modalCustomer'
                            ).textContent =
                            order.customer_name;

                        document.getElementById(
                                'modalTable'
                            ).textContent =
                            order.table_number;

                        document.getElementById(
                                'modalCashier'
                            ).textContent =
                            order.nama_kasir;

                        document.getElementById(
                                'modalDate'
                            ).textContent =
                            formatDate(
                                order.transaction_time
                            );

                        document.getElementById(
                                'modalPayment'
                            ).textContent =
                            order.payment_method;

                        document.getElementById(
                                'modalStatus'
                            ).textContent =
                            order.status;


                        /*
                        |--------------------------------------------------------------------------
                        | ITEMS
                        |--------------------------------------------------------------------------
                        */

                        const itemsBody =
                            document.getElementById(
                                'modalItemsBody'
                            );


                        if (!items.length) {

                            itemsBody.innerHTML = `

                    <tr>

                        <td
                            colspan="4"
                            class="modal-empty-items"
                        >

                            Tidak ada rincian item.

                        </td>

                    </tr>

                `;

                        } else {

                            itemsBody.innerHTML =
                                items.map(
                                    item => `

                            <tr>

                                <td>

                                    <div class="modal-product">

                                        <strong>
                                            ${escapeHtml(
                                                item.product_name
                                            )}
                                        </strong>

                                    </div>

                                </td>

                                <td>
                                    ${item.quantity}
                                </td>

                                <td>
                                    ${formatRupiah(
                                        item.price
                                    )}
                                </td>

                                <td>

                                    <strong>

                                        ${formatRupiah(
                                            item.total
                                        )}

                                    </strong>

                                </td>

                            </tr>

                        `
                                ).join('');

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | TOTAL ITEM
                        |--------------------------------------------------------------------------
                        */

                        const totalQuantity =
                            items.reduce(
                                (
                                    total,
                                    item
                                ) =>
                                total +
                                Number(
                                    item.quantity
                                ),
                                0
                            );


                        document.getElementById(
                                'modalTotalItem'
                            ).textContent =
                            totalQuantity +
                            ' item';


                        /*
                        |--------------------------------------------------------------------------
                        | TOTAL
                        |--------------------------------------------------------------------------
                        */

                        document.getElementById(
                                'modalSubtotal'
                            ).textContent =
                            formatRupiah(
                                order.sub_total
                            );

                        document.getElementById(
                                'modalTax'
                            ).textContent =
                            formatRupiah(
                                order.tax
                            );

                        document.getElementById(
                                'modalService'
                            ).textContent =
                            formatRupiah(
                                order.service_charge
                            );

                        document.getElementById(
                                'modalDiscount'
                            ).textContent =
                            '-' +
                            formatRupiah(
                                order.discount_amount
                            );

                        document.getElementById(
                                'modalTotal'
                            ).textContent =
                            formatRupiah(
                                order.total
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | SHOW CONTENT
                        |--------------------------------------------------------------------------
                        */

                        modalLoading.style.display =
                            'none';

                        modalContent.style.display =
                            'block';

                        lucide.createIcons();

                    } catch (error) {

                        modalLoading.innerHTML = `

                <div class="modal-error">

                    <div class="modal-error-icon">

                        <i data-lucide="circle-alert"></i>

                    </div>

                    <h3>
                        Gagal memuat transaksi
                    </h3>

                    <p>
                        ${escapeHtml(
                            error.message
                        )}
                    </p>

                    <button
                        type="button"
                        class="btn-primary"
                        onclick="closeOrderModal()"
                    >
                        Tutup
                    </button>

                </div>

            `;

                        lucide.createIcons();

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | ESCAPE HTML
                |--------------------------------------------------------------------------
                */

                function escapeHtml(value) {

                    return String(value ?? '')
                        .replace(
                            /&/g,
                            '&amp;'
                        )
                        .replace(
                            /</g,
                            '&lt;'
                        )
                        .replace(
                            />/g,
                            '&gt;'
                        )
                        .replace(
                            /"/g,
                            '&quot;'
                        )
                        .replace(
                            /'/g,
                            '&#039;'
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | BUTTON DETAIL
                |--------------------------------------------------------------------------
                */

                document
                    .querySelectorAll(
                        '.btn-view-order'
                    )
                    .forEach(
                        button => {

                            button.addEventListener(
                                'click',
                                function() {

                                    const orderId =
                                        this.dataset.id;

                                    if (!orderId) {
                                        return;
                                    }

                                    loadOrder(
                                        orderId
                                    );

                                }
                            );

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | CLOSE
                |--------------------------------------------------------------------------
                */

                document
                    .querySelectorAll(
                        '[data-close-modal]'
                    )
                    .forEach(
                        element => {

                            element.addEventListener(
                                'click',
                                closeModal
                            );

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | ESC
                |--------------------------------------------------------------------------
                */

                document.addEventListener(
                    'keydown',
                    function(event) {

                        if (
                            event.key === 'Escape' &&
                            modal.classList.contains(
                                'show'
                            )
                        ) {

                            closeModal();

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | GLOBAL CLOSE
                |--------------------------------------------------------------------------
                */

                window.closeOrderModal =
                    closeModal;


                /*
                |--------------------------------------------------------------------------
                | CHART PAYMENT
                |--------------------------------------------------------------------------
                */

                const paymentCanvas =
                    document.getElementById(
                        'paymentChart'
                    );


                if (paymentCanvas) {

                    new Chart(
                        paymentCanvas, {

                            type: 'doughnut',

                            data: {

                                labels: [
                                    'Cash',
                                    'Transfer'
                                ],

                                datasets: [

                                    {

                                        data: [

                                            {{ $summary['total_cash'] }},

                                            {{ $summary['total_transfer'] }}

                                        ],

                                        backgroundColor: [

                                            '#76513d',
                                            '#8ea6b7'

                                        ],

                                        borderWidth: 0,

                                        hoverOffset: 6

                                    }

                                ]

                            },

                            options: {

                                responsive: true,

                                maintainAspectRatio: false,

                                cutout: '72%',

                                plugins: {

                                    legend: {

                                        position: 'bottom',

                                        labels: {

                                            usePointStyle: true,

                                            padding: 20,

                                            font: {

                                                family: 'Poppins'

                                            }

                                        }

                                    }

                                }

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | CHART SALES
                |--------------------------------------------------------------------------
                */

                const salesCanvas =
                    document.getElementById(
                        'salesChart'
                    );


                if (salesCanvas) {

                    new Chart(
                        salesCanvas, {

                            type: 'bar',

                            data: {

                                labels: @json($chartData->pluck('trx_date')),

                                datasets: [

                                    {

                                        data: @json($chartData->pluck('total')),

                                        backgroundColor: '#76513d',

                                        borderRadius: 8,

                                        borderSkipped: false

                                    }

                                ]

                            },

                            options: {

                                responsive: true,

                                maintainAspectRatio: false,

                                plugins: {

                                    legend: {

                                        display: false

                                    }

                                },

                                scales: {

                                    x: {

                                        grid: {

                                            display: false

                                        }

                                    },

                                    y: {

                                        beginAtZero: true,

                                        grid: {

                                            color: 'rgba(118,81,61,.08)'

                                        },

                                        ticks: {

                                            callback: function(value) {

                                                return 'Rp ' +
                                                    Number(
                                                        value
                                                    )
                                                    .toLocaleString(
                                                        'id-ID'
                                                    );

                                            }

                                        }

                                    }

                                }

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | LUCIDE
                |--------------------------------------------------------------------------
                */

                lucide.createIcons();

            });
        </script>
    @endpush

@endsection
