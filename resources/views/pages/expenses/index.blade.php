@extends('layouts.app')

@section('title', 'Pengeluaran')

@section('content')

    <div class="expense-page">

        {{-- =========================================================
        HEADER
    ========================================================== --}}
        <div class="expense-header">

            <div class="expense-header-info">

                <span class="expense-eyebrow">
                    MARIMOI CAFE • KEUANGAN
                </span>

                <h1>
                    Pengeluaran
                </h1>

                <p>
                    Kelola dan pantau seluruh pengeluaran operasional cafe.
                </p>

            </div>

            <button type="button" class="btn-primary" id="openCreateExpense">
                <i data-lucide="plus"></i>

                <span>
                    Tambah Pengeluaran
                </span>
            </button>

        </div>


        {{-- =========================================================
        FILTER
    ========================================================== --}}
        <div class="expense-filter-card">

            <form method="GET" action="{{ route('expenses.index') }}" class="expense-filter">

                <div class="filter-item">

                    <label for="start_date">
                        Dari
                    </label>

                    <div class="input-wrapper">

                        <i data-lucide="calendar"></i>

                        <input type="date" id="start_date" name="start_date" value="{{ $start_date }}">

                    </div>

                </div>


                <div class="filter-item">

                    <label for="end_date">
                        Sampai
                    </label>

                    <div class="input-wrapper">

                        <i data-lucide="calendar"></i>

                        <input type="date" id="end_date" name="end_date" value="{{ $end_date }}">

                    </div>

                </div>


                <div class="filter-item">

                    <label for="category">
                        Kategori
                    </label>

                    <div class="input-wrapper">

                        <i data-lucide="layers"></i>

                        <select id="category" name="category">

                            <option value="">
                                Semua Kategori
                            </option>

                            @foreach (['Gaji', 'Pengeluaran Dapur', 'Listrik', 'Tak Terduga'] as $item)
                                <option value="{{ $item }}" {{ $category === $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>


                <button type="submit" class="btn-filter">

                    <i data-lucide="filter"></i>

                    Terapkan

                </button>


                <a href="{{ route('expenses.index') }}" class="btn-reset" title="Reset filter">

                    <i data-lucide="rotate-ccw"></i>

                </a>

            </form>

        </div>


        {{-- =========================================================
        SUMMARY
    ========================================================== --}}
        <div class="expense-summary">

            {{-- TOTAL --}}
            <div class="summary-card summary-total">

                <div class="summary-icon">

                    <i data-lucide="wallet"></i>

                </div>

                <div class="summary-content">

                    <span>
                        Total Pengeluaran
                    </span>

                    <strong>
                        Rp
                        {{ number_format($totalExpense, 0, ',', '.') }}
                    </strong>

                    <small>
                        Seluruh pengeluaran
                    </small>

                </div>

            </div>


            {{-- GAJI --}}
            <div class="summary-card">

                <div class="summary-icon salary">

                    <i data-lucide="users"></i>

                </div>

                <div class="summary-content">

                    <span>
                        Gaji
                    </span>

                    <strong>
                        Rp
                        {{ number_format($expenseSummary['Gaji'] ?? 0, 0, ',', '.') }}
                    </strong>

                    <small>
                        Pengeluaran karyawan
                    </small>

                </div>

            </div>


            {{-- DAPUR --}}
            <div class="summary-card">

                <div class="summary-icon kitchen">

                    <i data-lucide="utensils"></i>

                </div>

                <div class="summary-content">

                    <span>
                        Pengeluaran Dapur
                    </span>

                    <strong>
                        Rp
                        {{ number_format($expenseSummary['Pengeluaran Dapur'] ?? 0, 0, ',', '.') }}
                    </strong>

                    <small>
                        Bahan dan kebutuhan dapur
                    </small>

                </div>

            </div>


            {{-- LISTRIK --}}
            <div class="summary-card">

                <div class="summary-icon electric">

                    <i data-lucide="zap"></i>

                </div>

                <div class="summary-content">

                    <span>
                        Listrik
                    </span>

                    <strong>
                        Rp
                        {{ number_format($expenseSummary['Listrik'] ?? 0, 0, ',', '.') }}
                    </strong>

                    <small>
                        Tagihan listrik
                    </small>

                </div>

            </div>


            {{-- TAK TERDUGA --}}
            <div class="summary-card">

                <div class="summary-icon unexpected">

                    <i data-lucide="triangle-alert"></i>

                </div>

                <div class="summary-content">

                    <span>
                        Tak Terduga
                    </span>

                    <strong>
                        Rp
                        {{ number_format($expenseSummary['Tak Terduga'] ?? 0, 0, ',', '.') }}
                    </strong>

                    <small>
                        Pengeluaran lainnya
                    </small>

                </div>

            </div>

        </div>


        {{-- =========================================================
        TABLE CARD
    ========================================================== --}}
        <div class="expense-table-card">

            <div class="table-header">

                <div>

                    <span class="section-label">
                        RIWAYAT
                    </span>

                    <h2>
                        Daftar Pengeluaran
                    </h2>

                    <p>
                        {{ $expenses->total() }}
                        data pengeluaran ditemukan.
                    </p>

                </div>

                <div class="period-badge">

                    <i data-lucide="calendar-days"></i>

                    {{ \Carbon\Carbon::parse($start_date)->format('d M Y') }}

                    <span>
                        —
                    </span>

                    {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}

                </div>

            </div>


            {{-- =====================================================
            TABLE
        ====================================================== --}}
            <div class="table-scroll">

                <table class="expense-table">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Kategori
                            </th>

                            <th>
                                Keterangan
                            </th>

                            <th>
                                Nominal
                            </th>

                            <th>
                                Dicatat Oleh
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($expenses as $expense)
                            <tr>

                                {{-- NUMBER --}}

                                <td>

                                    <span class="row-number">
                                        {{ $expenses->firstItem() + $loop->index }}
                                    </span>

                                </td>


                                {{-- DATE --}}

                                <td>

                                    <div class="date-cell">

                                        <strong>
                                            {{ $expense->expense_date->format('d M Y') }}
                                        </strong>

                                        <small>
                                            {{ $expense->created_at?->format('H:i') }}
                                        </small>

                                    </div>

                                </td>


                                {{-- CATEGORY --}}

                                <td>

                                    @php

                                        $categoryClass = match ($expense->category) {
                                            'Gaji' => 'salary',

                                            'Pengeluaran Dapur' => 'kitchen',

                                            'Listrik' => 'electric',

                                            'Tak Terduga' => 'unexpected',

                                            default => 'other',
                                        };

                                    @endphp


                                    <span class="category-badge {{ $categoryClass }}">

                                        <span class="category-dot"></span>

                                        {{ $expense->category }}

                                    </span>

                                </td>


                                {{-- DESCRIPTION --}}

                                <td>

                                    <div class="description-cell">

                                        <strong>
                                            {{ $expense->description }}
                                        </strong>

                                        @if ($expense->notes)
                                            <small>
                                                {{ $expense->notes }}
                                            </small>
                                        @endif

                                    </div>

                                </td>


                                {{-- AMOUNT --}}

                                <td>

                                    <strong class="amount-cell">

                                        Rp
                                        {{ number_format($expense->amount, 0, ',', '.') }}

                                    </strong>

                                </td>


                                {{-- USER --}}

                                <td>

                                    @if ($expense->user)
                                        <div class="user-cell">

                                            <div class="user-avatar">

                                                {{ strtoupper(substr($expense->user->name, 0, 1)) }}

                                            </div>

                                            <div>

                                                <strong>
                                                    {{ $expense->user->name }}
                                                </strong>

                                                <small>
                                                    {{ ucfirst($expense->user->role ?? 'User') }}
                                                </small>

                                            </div>

                                        </div>
                                    @else
                                        <span class="muted">
                                            -
                                        </span>
                                    @endif

                                </td>


                                {{-- ACTION --}}

                                <td>

                                    <div class="action-buttons">

                                        {{-- EDIT --}}

                                        <button type="button" class="action-button edit" data-edit-expense
                                            data-id="{{ $expense->id }}" data-category="{{ $expense->category }}"
                                            data-description="{{ $expense->description }}"
                                            data-amount="{{ $expense->amount }}"
                                            data-date="{{ $expense->expense_date->format('Y-m-d') }}"
                                            data-notes="{{ $expense->notes }}" title="Edit">

                                            <i data-lucide="pencil"></i>

                                        </button>


                                        {{-- DELETE --}}

                                        <form method="POST" action="{{ route('expenses.destroy', $expense) }}"
                                            onsubmit="
                                            return confirm(
                                                'Yakin ingin menghapus pengeluaran ini?'
                                            )
                                        ">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit" class="action-button delete" title="Hapus">

                                                <i data-lucide="trash-2"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="empty-state">

                                    <div>

                                        <div class="empty-icon">

                                            <i data-lucide="wallet"></i>

                                        </div>

                                        <strong>
                                            Belum ada pengeluaran
                                        </strong>

                                        <p>
                                            Belum ada data pengeluaran
                                            pada periode yang dipilih.
                                        </p>

                                        <button type="button" class="empty-button" id="openCreateExpenseEmpty">
                                            Tambah Pengeluaran
                                        </button>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =====================================================
            PAGINATION
        ====================================================== --}}

            @if ($expenses->hasPages())
                <div class="pagination-area">

                    <div class="pagination-info">

                        Menampilkan

                        <strong>
                            {{ $expenses->firstItem() }}
                        </strong>

                        sampai

                        <strong>
                            {{ $expenses->lastItem() }}
                        </strong>

                        dari

                        <strong>
                            {{ $expenses->total() }}
                        </strong>

                        pengeluaran

                    </div>

                    <div class="pagination">

                        {{ $expenses->links() }}

                    </div>

                </div>
            @endif

        </div>

    </div>


    {{-- =============================================================
    CREATE / EDIT MODAL
============================================================= --}}

    <div class="expense-modal" id="expenseModal" aria-hidden="true">

        <div class="expense-modal-overlay"></div>


        <div class="expense-modal-container">

            {{-- HEADER --}}

            <div class="modal-header">

                <div>

                    <span>
                        MARIMOI CAFE
                    </span>

                    <h2 id="expenseModalTitle">
                        Tambah Pengeluaran
                    </h2>

                    <p id="expenseModalSubtitle">
                        Catat pengeluaran operasional cafe.
                    </p>

                </div>


                <button type="button" class="modal-close" id="closeExpenseModal">

                    <i data-lucide="x"></i>

                </button>

            </div>


            {{-- FORM --}}

            <form method="POST" action="{{ route('expenses.store') }}" id="expenseForm">

                @csrf

                <input type="hidden" name="_method" id="expenseMethod" value="POST">


                <div class="modal-body">

                    {{-- CATEGORY --}}

                    <div class="form-group">

                        <label for="expenseCategory">
                            Kategori
                            <span>*</span>
                        </label>

                        <select name="category" id="expenseCategory" required>

                            <option value="">
                                Pilih kategori
                            </option>

                            @foreach (['Gaji', 'Pengeluaran Dapur', 'Listrik', 'Tak Terduga'] as $item)
                                <option value="{{ $item }}">
                                    {{ $item }}
                                </option>
                            @endforeach

                        </select>

                        @error('category')
                            <small class="form-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- DESCRIPTION --}}

                    <div class="form-group">

                        <label for="expenseDescription">
                            Keterangan
                            <span>*</span>
                        </label>

                        <input type="text" name="description" id="expenseDescription"
                            placeholder="Contoh: Belanja bahan baku" maxlength="255" required>

                        @error('description')
                            <small class="form-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- AMOUNT + DATE --}}

                    <div class="form-row">

                        <div class="form-group">

                            <label for="expenseAmount">
                                Nominal
                                <span>*</span>
                            </label>

                            <div class="money-input">

                                <span>
                                    Rp
                                </span>

                                <input type="number" name="amount" id="expenseAmount" min="0" step="0.01"
                                    placeholder="0" required>

                            </div>

                            @error('amount')
                                <small class="form-error">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        <div class="form-group">

                            <label for="expenseDate">
                                Tanggal
                                <span>*</span>
                            </label>

                            <input type="date" name="expense_date" id="expenseDate"
                                value="{{ now()->toDateString() }}" required>

                            @error('expense_date')
                                <small class="form-error">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>


                    {{-- NOTES --}}

                    <div class="form-group">

                        <label for="expenseNotes">
                            Catatan
                        </label>

                        <textarea name="notes" id="expenseNotes" rows="4" placeholder="Catatan tambahan..."></textarea>

                        @error('notes')
                            <small class="form-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>


                {{-- FOOTER --}}

                <div class="modal-footer">

                    <button type="button" class="btn-cancel" id="cancelExpenseModal">
                        Batal
                    </button>

                    <button type="submit" class="btn-save">

                        <i data-lucide="save"></i>

                        <span id="expenseSubmitText">
                            Simpan Pengeluaran
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection


{{-- =============================================================
    CSS
============================================================= --}}

@push('css')
    <style>
        /* =============================================================
                   ROOT
                ============================================================= */

        .expense-page {

            --coffee-950: #2B1710;
            --coffee-900: #351C13;
            --coffee-800: #4A2A1D;
            --coffee-700: #6F4936;
            --coffee-600: #8B5E43;
            --coffee-500: #A9714F;

            --cream: #FAF7F2;
            --cream-dark: #F3ECE4;

            --text: #30251F;
            --text-soft: #7A6F68;

            --border: #E9DED4;

            --green: #5E7D6A;
            --red: #B85C4A;

            width: 100%;
            max-width: 1500px;

            margin: 0 auto;

        }


        /* =============================================================
                   HEADER
                ============================================================= */

        .expense-header {

            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            gap: 25px;

            margin-bottom: 25px;

        }

        .expense-eyebrow {

            display: block;

            margin-bottom: 7px;

            color: var(--coffee-500);

            font-size: 11px;
            font-weight: 800;

            letter-spacing: 1.8px;

        }

        .expense-header h1 {

            margin: 0;

            color: var(--coffee-950);

            font-size: 34px;
            font-weight: 800;

        }

        .expense-header p {

            margin: 7px 0 0;

            color: var(--text-soft);

            font-size: 14px;

        }


        /* =============================================================
                   BUTTON
                ============================================================= */

        .btn-primary {

            display: flex;
            align-items: center;
            gap: 8px;

            height: 46px;

            padding: 0 17px;

            border: 0;

            border-radius: 13px;

            background:
                linear-gradient(135deg,
                    var(--coffee-900),
                    var(--coffee-700));

            color: white;

            font-size: 13px;
            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 8px 20px rgba(53, 28, 19, .16);

            transition: .25s ease;

        }

        .btn-primary:hover {

            transform: translateY(-2px);

            box-shadow:
                0 12px 28px rgba(53, 28, 19, .22);

        }

        .btn-primary svg {

            width: 18px;
            height: 18px;

        }

        /* =========================================================
               EXPENSE FORM - SUBMIT BUTTON
            ========================================================= */

        #expenseSubmitText {
            color: #ffffff !important;
            font-weight: 700;
            opacity: 1 !important;
            visibility: visible !important;
        }

        button[type="submit"] {
            background: linear-gradient(135deg,
                    #8b5e45,
                    #6f4633) !important;

            color: #ffffff !important;

            border: 1px solid #6f4633 !important;

            min-height: 48px;

            padding: 0 24px;

            border-radius: 14px;

            font-family: "DM Sans", sans-serif;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            transition:
                transform .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }

        button[type="submit"]:hover {
            background: linear-gradient(135deg,
                    #6f4633,
                    #583526) !important;

            color: #ffffff !important;

            transform: translateY(-1px);

            box-shadow:
                0 8px 20px rgba(111, 70, 51, .22);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        button[type="submit"]:disabled {
            opacity: .65;

            cursor: not-allowed;

            transform: none;

            box-shadow: none;
        }


        /* =============================================================
                   FILTER
                ============================================================= */

        .expense-filter-card {

            margin-bottom: 20px;

            padding: 17px;

            border: 1px solid var(--border);

            border-radius: 20px;

            background: white;

            box-shadow:
                0 8px 25px rgba(70, 40, 20, .035);

        }

        .expense-filter {

            display: flex;
            align-items: flex-end;

            gap: 12px;

        }

        .filter-item {

            display: flex;
            flex-direction: column;

            gap: 6px;

            min-width: 180px;

        }

        .filter-item label {

            color: var(--text-soft);

            font-size: 11px;
            font-weight: 700;

        }

        .input-wrapper {

            position: relative;

        }

        .input-wrapper>svg {

            position: absolute;

            left: 12px;
            top: 50%;

            width: 16px;
            height: 16px;

            transform: translateY(-50%);

            color: var(--coffee-600);

            pointer-events: none;

        }

        .input-wrapper input,
        .input-wrapper select {

            width: 100%;

            height: 43px;

            padding:
                0 12px 0 38px;

            border: 1px solid var(--border);

            border-radius: 11px;

            background: #FFFEFC;

            color: var(--text);

            outline: none;

            font-size: 12px;

        }

        .input-wrapper input:focus,
        .input-wrapper select:focus {

            border-color: var(--coffee-500);

            box-shadow:
                0 0 0 3px rgba(169, 113, 79, .10);

        }

        .btn-filter {

            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 0 17px;

            border: 0;

            border-radius: 11px;

            background: var(--coffee-900);

            color: white;

            font-size: 12px;
            font-weight: 700;

            cursor: pointer;

        }

        .btn-filter svg {

            width: 16px;
            height: 16px;

        }

        .btn-reset {

            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--border);

            border-radius: 11px;

            background: var(--cream);

            color: var(--coffee-800);

            text-decoration: none;

        }

        .btn-reset svg {

            width: 16px;
            height: 16px;

        }


        /* =============================================================
                   SUMMARY
                ============================================================= */

        .expense-summary {

            display: grid;

            grid-template-columns:
                repeat(5, minmax(0, 1fr));

            gap: 15px;

            margin-bottom: 22px;

        }

        .summary-card {

            position: relative;

            display: flex;
            align-items: flex-start;

            gap: 13px;

            min-height: 128px;

            padding: 19px;

            overflow: hidden;

            border: 1px solid var(--border);

            border-radius: 19px;

            background: white;

            box-shadow:
                0 8px 25px rgba(70, 40, 20, .035);

        }

        .summary-card::after {

            content: "";

            position: absolute;

            right: -35px;
            top: -35px;

            width: 90px;
            height: 90px;

            border-radius: 50%;

            background: #F8EFE8;

        }

        .summary-total {

            border-color: #DCC7B8;

            background:
                linear-gradient(135deg,
                    #FFFDFC,
                    #F8F0E9);

        }

        .summary-icon {

            position: relative;
            z-index: 2;

            width: 42px;
            height: 42px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background: #F2E4D9;

            color: var(--coffee-800);

        }

        .summary-icon.salary {

            background: #F2E6DC;
            color: #795039;

        }

        .summary-icon.kitchen {

            background: #F4E8D9;
            color: #A46C48;

        }

        .summary-icon.electric {

            background: #EDF0E8;
            color: #697D68;

        }

        .summary-icon.unexpected {

            background: #F6E7E3;
            color: #AA5D4E;

        }

        .summary-icon svg {

            width: 19px;
            height: 19px;

        }

        .summary-content {

            position: relative;
            z-index: 2;

            min-width: 0;

        }

        .summary-content span {

            display: block;

            color: var(--text-soft);

            font-size: 11px;
            font-weight: 600;

        }

        .summary-content strong {

            display: block;

            margin-top: 7px;

            color: var(--coffee-950);

            font-size: 18px;
            font-weight: 800;

            white-space: nowrap;

        }

        .summary-content small {

            display: block;

            margin-top: 6px;

            color: #A19790;

            font-size: 10px;

        }


        /* =============================================================
                   TABLE CARD
                ============================================================= */

        .expense-table-card {

            overflow: hidden;

            border: 1px solid var(--border);

            border-radius: 22px;

            background: white;

            box-shadow:
                0 10px 35px rgba(70, 40, 20, .035);

        }

        .table-header {

            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 20px;

            padding: 24px;

        }

        .section-label {

            display: block;

            margin-bottom: 5px;

            color: var(--coffee-500);

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1.5px;

        }

        .table-header h2 {

            margin: 0;

            color: var(--coffee-950);

            font-size: 20px;

        }

        .table-header p {

            margin: 5px 0 0;

            color: var(--text-soft);

            font-size: 12px;

        }

        .period-badge {

            display: flex;
            align-items: center;

            gap: 7px;

            padding: 9px 12px;

            border: 1px solid var(--border);

            border-radius: 10px;

            background: var(--cream);

            color: var(--coffee-700);

            font-size: 11px;
            font-weight: 600;

        }

        .period-badge svg {

            width: 15px;
            height: 15px;

        }


        /* =============================================================
                   TABLE
                ============================================================= */

        .table-scroll {

            width: 100%;

            overflow-x: auto;

        }

        .expense-table {

            width: 100%;

            min-width: 1000px;

            border-collapse: collapse;

        }

        .expense-table th {

            padding: 13px 18px;

            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);

            background: #FCF9F6;

            color: #847870;

            text-align: left;

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .7px;

        }

        .expense-table td {

            padding: 15px 18px;

            border-bottom: 1px solid #F1EAE5;

            color: var(--text);

            font-size: 12px;

        }

        .expense-table tbody tr {

            transition: .2s ease;

        }

        .expense-table tbody tr:hover {

            background: #FFFCF9;

        }

        .row-number {

            color: #A39790;

            font-size: 11px;
            font-weight: 700;

        }

        .date-cell {

            display: flex;
            flex-direction: column;

            gap: 3px;

        }

        .date-cell strong {

            color: var(--coffee-900);

            font-size: 12px;

        }

        .date-cell small {

            color: #A19790;

            font-size: 10px;

        }

        .category-badge {

            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 6px 9px;

            border-radius: 8px;

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;

        }

        .category-badge.salary {

            background: #F3E8DE;
            color: #795039;

        }

        .category-badge.kitchen {

            background: #F6EBDD;
            color: #A46C48;

        }

        .category-badge.electric {

            background: #EDF1E9;
            color: #63775F;

        }

        .category-badge.unexpected {

            background: #F7E8E5;
            color: #A95C4E;

        }

        .category-badge.other {

            background: #F0ECE9;
            color: #746A63;

        }

        .category-dot {

            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: currentColor;

        }

        .description-cell {

            display: flex;
            flex-direction: column;

            gap: 4px;

            max-width: 260px;

        }

        .description-cell strong {

            overflow: hidden;

            color: var(--text);

            font-size: 12px;

            text-overflow: ellipsis;
            white-space: nowrap;

        }

        .description-cell small {

            overflow: hidden;

            color: #9A918B;

            font-size: 10px;

            text-overflow: ellipsis;
            white-space: nowrap;

        }

        .amount-cell {

            color: var(--coffee-950);

            font-size: 13px;

            white-space: nowrap;

        }

        .user-cell {

            display: flex;
            align-items: center;

            gap: 9px;

        }

        .user-avatar {

            width: 31px;
            height: 31px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: #F1E5DA;

            color: var(--coffee-800);

            font-size: 12px;
            font-weight: 800;

        }

        .user-cell>div:last-child {

            display: flex;
            flex-direction: column;

            gap: 2px;

        }

        .user-cell strong {

            color: var(--text);

            font-size: 11px;

        }

        .user-cell small {

            color: #9A918B;

            font-size: 9px;

        }

        .muted {

            color: #AAA29C;

        }

        .action-buttons {

            display: flex;
            align-items: center;

            gap: 6px;

        }

        .action-buttons form {

            margin: 0;

        }

        /* =========================================================
       ACTION BUTTON
    ========================================================= */

        .action-button {

            width: 42px;
            height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0;

            border-radius: 12px;

            background: #ffffff;

            border: 1px solid #eadfd6;

            font-family: "DM Sans", sans-serif;

            cursor: pointer;

            transition:
                background .2s ease,
                border-color .2s ease,
                color .2s ease,
                transform .2s ease,
                box-shadow .2s ease;

        }


        /* =========================================================
       ICON
    ========================================================= */

        .action-button svg {

            width: 18px;
            height: 18px;

            flex-shrink: 0;

            stroke-width: 2;

            transition: .2s ease;

        }


        /* =========================================================
       EDIT
    ========================================================= */

        .action-button.edit {

            color: var(--coffee-700);

            background: #ffffff;

            border: 1px solid #eadfd6;

        }


        /* ICON EDIT */

        .action-button.edit svg {

            color: var(--coffee-700);

            stroke: var(--coffee-700);

        }


        /* HOVER EDIT */

        .action-button.edit:hover {

            background: var(--coffee-900);

            border-color: var(--coffee-900);

            color: #ffffff;

            transform: translateY(-2px);

            box-shadow:
                0 8px 18px rgba(53, 28, 19, .18);

        }


        /* ICON HOVER */

        .action-button.edit:hover svg {

            color: #ffffff;

            stroke: #ffffff;

        }


        /* ACTIVE EDIT */

        .action-button.edit:active {

            transform: translateY(0);

            box-shadow: none;

        }


        /* =========================================================
       DELETE
    ========================================================= */

        .action-button.delete {

            color: #b85c4a;

            background: #fff7f5;

            border: 1px solid #e8cec7;

        }


        /* ICON DELETE */

        .action-button.delete svg {

            width: 18px;
            height: 18px;

            color: #b85c4a;

            stroke: #b85c4a;

            stroke-width: 2;

        }


        /* HOVER DELETE */

        .action-button.delete:hover {

            background: #b85c4a;

            border-color: #b85c4a;

            color: #ffffff;

            transform: translateY(-2px);

            box-shadow:
                0 8px 18px rgba(184, 92, 74, .22);

        }


        /* ICON HOVER DELETE */

        .action-button.delete:hover svg {

            color: #ffffff;

            stroke: #ffffff;

        }


        /* ACTIVE DELETE */

        .action-button.delete:active {

            transform: translateY(0);

            box-shadow: none;

        }


        /* =========================================================
       DISABLED
    ========================================================= */

        .action-button:disabled {

            opacity: .5;

            cursor: not-allowed;

            transform: none;

            box-shadow: none;

        }


        /* =========================================================
       ACTION GROUP
    ========================================================= */

        .action-buttons {

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 8px;

        }


        /* =========================================================
       RESPONSIVE
    ========================================================= */

        @media (max-width: 576px) {

            .action-button {

                width: 40px;

                height: 40px;

                border-radius: 11px;

            }

            .action-button svg {

                width: 17px;

                height: 17px;

            }

        }


        /* =============================================================
                   EMPTY
                ============================================================= */

        .empty-state {

            height: 280px;

            text-align: center !important;

        }

        .empty-state>div {

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            height: 100%;

        }

        .empty-icon {

            width: 52px;
            height: 52px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 12px;

            border-radius: 16px;

            background: #F3E8DF;

            color: var(--coffee-600);

        }

        .empty-icon svg {

            width: 24px;
            height: 24px;

        }

        .empty-state strong {

            color: var(--coffee-950);

            font-size: 14px;

        }

        .empty-state p {

            margin: 5px 0 12px;

            color: var(--text-soft);

            font-size: 11px;

        }

        .empty-button {

            height: 36px;

            padding: 0 14px;

            border: 0;

            border-radius: 9px;

            background: var(--coffee-900);

            color: white;

            font-size: 11px;
            font-weight: 700;

            cursor: pointer;

        }


        /* =============================================================
                   PAGINATION
                ============================================================= */

        .pagination-area {

            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 20px;

            padding: 17px 24px;

        }

        .pagination-info {

            color: var(--text-soft);

            font-size: 11px;

        }

        .pagination-info strong {

            color: var(--coffee-900);

        }

        .pagination {

            display: flex;
            align-items: center;

        }

        .pagination nav {

            display: flex;

        }

        .pagination nav>div {

            display: flex;

            gap: 4px;

        }

        .pagination a,
        .pagination span {

            min-width: 34px;
            height: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--border);

            border-radius: 8px;

            background: white;

            color: var(--coffee-800);

            text-decoration: none;

            font-size: 11px;

        }

        .pagination a:hover {

            background: var(--cream);

        }

        .pagination span[aria-current="page"] {

            background: var(--coffee-900);

            border-color: var(--coffee-900);

            color: white;

        }


        /* =============================================================
                   MODAL
                ============================================================= */

        .expense-modal {

            position: fixed;

            inset: 0;

            z-index: 9999;

            display: none;

        }

        .expense-modal.active {

            display: block;

        }

        .expense-modal-overlay {

            position: absolute;

            inset: 0;

            background: rgba(38, 24, 17, .68);

            backdrop-filter: blur(7px);

        }

        .expense-modal-container {

            position: absolute;

            top: 50%;
            left: 50%;

            width:
                min(570px,
                    calc(100% - 30px));

            max-height:
                calc(100vh - 40px);

            transform:
                translate(-50%, -50%);

            overflow: hidden;

            border-radius: 24px;

            background: white;

            box-shadow:
                0 30px 90px rgba(0, 0, 0, .25);

        }


        /* =============================================================
                   MODAL HEADER
                ============================================================= */

        .modal-header {

            display: flex;

            justify-content: space-between;
            align-items: flex-start;

            gap: 20px;

            padding: 24px 25px 20px;

            border-bottom: 1px solid var(--border);

        }

        .modal-header>div {

            min-width: 0;

        }

        .modal-header span {

            display: block;

            color: var(--coffee-500);

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1.5px;

        }

        .modal-header h2 {

            margin: 6px 0 4px;

            color: var(--coffee-950);

            font-size: 21px;

        }

        .modal-header p {

            margin: 0;

            color: var(--text-soft);

            font-size: 11px;

        }

        .modal-close {

            width: 37px;
            height: 37px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border: 1px solid var(--border);

            border-radius: 10px;

            background: white;

            color: var(--coffee-800);

            cursor: pointer;

        }

        .modal-close:hover {

            background: var(--cream);

        }

        .modal-close svg {

            width: 17px;
            height: 17px;

        }


        /* =============================================================
                   MODAL BODY
                ============================================================= */

        .modal-body {

            max-height:
                calc(100vh - 210px);

            overflow-y: auto;

            padding: 22px 25px;

        }

        .form-group {

            display: flex;
            flex-direction: column;

            gap: 7px;

            margin-bottom: 17px;

        }

        .form-group label {

            color: var(--text);

            font-size: 12px;
            font-weight: 700;

        }

        .form-group label span {

            color: #B85C4A;

        }

        .form-group input,
        .form-group select,
        .form-group textarea {

            width: 100%;

            box-sizing: border-box;

            border: 1px solid var(--border);

            border-radius: 11px;

            background: #FFFEFC;

            color: var(--text);

            outline: none;

            font-family: inherit;

            font-size: 12px;

        }

        .form-group input,
        .form-group select {

            height: 43px;

            padding: 0 12px;

        }

        .form-group textarea {

            padding: 12px;

            resize: vertical;

            min-height: 90px;

        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {

            border-color: var(--coffee-500);

            box-shadow:
                0 0 0 3px rgba(169, 113, 79, .10);

        }

        .form-row {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 13px;

        }

        .money-input {

            position: relative;

        }

        .money-input span {

            position: absolute;

            left: 12px;
            top: 50%;

            transform: translateY(-50%);

            color: var(--coffee-700);

            font-size: 12px;
            font-weight: 700;

        }

        .money-input input {

            padding-left: 36px;

        }

        .form-error {

            color: #B85C4A;

            font-size: 10px;

        }


        /* =============================================================
                   MODAL FOOTER
                ============================================================= */

        .modal-footer {

            display: flex;

            justify-content: flex-end;

            gap: 9px;

            padding: 16px 25px;

            border-top: 1px solid var(--border);

            background: #FFFCFA;

        }

        .btn-cancel,
        .btn-save {

            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 0 17px;

            border-radius: 10px;

            font-size: 12px;
            font-weight: 700;

            cursor: pointer;

        }

        .btn-cancel {

            border: 1px solid var(--border);

            background: white;

            color: var(--coffee-800);

        }

        .btn-save {

            border: 0;

            background: var(--coffee-900);

            color: white;

        }

        .btn-save:hover {

            background: var(--coffee-700);

        }

        .btn-save svg {

            width: 16px;
            height: 16px;

        }


        /* =============================================================
                   RESPONSIVE TABLET
                ============================================================= */

        @media(max-width:1200px) {

            .expense-summary {

                grid-template-columns:
                    repeat(3, minmax(0, 1fr));

            }

        }

        @media(max-width:900px) {

            .expense-summary {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

            }

            .expense-filter {

                flex-wrap: wrap;

            }

            .filter-item {

                flex: 1 1 30%;

            }

        }


        /* =============================================================
                   RESPONSIVE MOBILE
                ============================================================= */

        @media(max-width:650px) {

            .expense-header {

                align-items: stretch;

                flex-direction: column;

            }

            .btn-primary {

                justify-content: center;

                width: 100%;

            }

            .expense-filter {

                display: grid;

                grid-template-columns: 1fr;

            }

            .filter-item {

                width: 100%;

                min-width: 0;

            }

            .btn-filter {

                width: 100%;

            }

            .btn-reset {

                width: 100%;

            }

            .expense-summary {

                grid-template-columns: 1fr;

            }

            .table-header {

                align-items: flex-start;

                flex-direction: column;

                padding: 19px;

            }

            .period-badge {

                width: 100%;

                justify-content: center;

                box-sizing: border-box;

            }

            .pagination-area {

                align-items: flex-start;

                flex-direction: column;

                padding: 16px;

            }

            .pagination {

                width: 100%;

                overflow-x: auto;

            }

            .form-row {

                grid-template-columns: 1fr;

                gap: 0;

            }

            .expense-modal-container {

                width: calc(100% - 18px);

                max-height: calc(100vh - 18px);

                border-radius: 19px;

            }

            .modal-header {

                padding: 19px;

            }

            .modal-body {

                padding: 19px;

            }

            .modal-footer {

                padding: 14px 19px;

            }

        }

        @media(max-width:420px) {

            .expense-header h1 {

                font-size: 27px;

            }

            .summary-card {

                min-height: 110px;

            }

            .summary-content strong {

                font-size: 16px;

            }

            .modal-footer {

                display: grid;

                grid-template-columns: 1fr 1fr;

            }

            .btn-cancel,
            .btn-save {

                width: 100%;

            }

        }
    </style>
@endpush


{{-- =============================================================
    JAVASCRIPT
============================================================= --}}

@push('scripts')
    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                /*
                |--------------------------------------------------------------------------
                | LUCIDE
                |--------------------------------------------------------------------------
                */

                if (
                    typeof lucide !== 'undefined'
                ) {

                    lucide.createIcons();

                }


                /*
                |--------------------------------------------------------------------------
                | ELEMENTS
                |--------------------------------------------------------------------------
                */

                const modal =
                    document.getElementById(
                        'expenseModal'
                    );

                const form =
                    document.getElementById(
                        'expenseForm'
                    );

                const method =
                    document.getElementById(
                        'expenseMethod'
                    );

                const title =
                    document.getElementById(
                        'expenseModalTitle'
                    );

                const subtitle =
                    document.getElementById(
                        'expenseModalSubtitle'
                    );

                const submitText =
                    document.getElementById(
                        'expenseSubmitText'
                    );

                const category =
                    document.getElementById(
                        'expenseCategory'
                    );

                const description =
                    document.getElementById(
                        'expenseDescription'
                    );

                const amount =
                    document.getElementById(
                        'expenseAmount'
                    );

                const date =
                    document.getElementById(
                        'expenseDate'
                    );

                const notes =
                    document.getElementById(
                        'expenseNotes'
                    );


                const openButton =
                    document.getElementById(
                        'openCreateExpense'
                    );

                const emptyButton =
                    document.getElementById(
                        'openCreateExpenseEmpty'
                    );

                const closeButton =
                    document.getElementById(
                        'closeExpenseModal'
                    );

                const cancelButton =
                    document.getElementById(
                        'cancelExpenseModal'
                    );

                const overlay =
                    modal?.querySelector(
                        '.expense-modal-overlay'
                    );


                /*
                |--------------------------------------------------------------------------
                | OPEN CREATE
                |--------------------------------------------------------------------------
                */

                function openCreateModal() {

                    if (!modal) {
                        return;
                    }

                    form.action =
                        @json(route('expenses.store'));

                    method.value = 'POST';

                    title.textContent =
                        'Tambah Pengeluaran';

                    subtitle.textContent =
                        'Catat pengeluaran operasional cafe.';

                    submitText.textContent =
                        'Simpan Pengeluaran';

                    category.value = '';

                    description.value = '';

                    amount.value = '';

                    date.value =
                        new Date()
                        .toISOString()
                        .split('T')[0];

                    notes.value = '';

                    modal.classList.add('active');

                    modal.setAttribute(
                        'aria-hidden',
                        'false'
                    );

                    document.body.style.overflow =
                        'hidden';

                }


                /*
                |--------------------------------------------------------------------------
                | OPEN EDIT
                |--------------------------------------------------------------------------
                */

                function openEditModal(button) {

                    if (!modal) {
                        return;
                    }

                    const id =
                        button.dataset.id;

                    const expenseCategory =
                        button.dataset.category || '';

                    const expenseDescription =
                        button.dataset.description || '';

                    const expenseAmount =
                        button.dataset.amount || '';

                    const expenseDate =
                        button.dataset.date || '';

                    const expenseNotes =
                        button.dataset.notes || '';


                    form.action =
                        `/expenses/${id}`;

                    method.value =
                        'PUT';


                    title.textContent =
                        'Edit Pengeluaran';

                    subtitle.textContent =
                        'Perbarui data pengeluaran.';

                    submitText.textContent =
                        'Simpan Perubahan';


                    category.value =
                        expenseCategory;

                    description.value =
                        expenseDescription;

                    amount.value =
                        expenseAmount;

                    date.value =
                        expenseDate;

                    notes.value =
                        expenseNotes;


                    modal.classList.add(
                        'active'
                    );

                    modal.setAttribute(
                        'aria-hidden',
                        'false'
                    );

                    document.body.style.overflow =
                        'hidden';

                }


                /*
                |--------------------------------------------------------------------------
                | CLOSE
                |--------------------------------------------------------------------------
                */

                function closeModal() {

                    if (!modal) {
                        return;
                    }

                    modal.classList.remove(
                        'active'
                    );

                    modal.setAttribute(
                        'aria-hidden',
                        'true'
                    );

                    document.body.style.overflow =
                        '';

                }


                /*
                |--------------------------------------------------------------------------
                | EVENTS
                |--------------------------------------------------------------------------
                */

                openButton?.addEventListener(
                    'click',
                    openCreateModal
                );

                emptyButton?.addEventListener(
                    'click',
                    openCreateModal
                );


                document
                    .querySelectorAll(
                        '[data-edit-expense]'
                    )
                    .forEach(
                        function(button) {

                            button.addEventListener(
                                'click',
                                function() {

                                    openEditModal(
                                        this
                                    );

                                }
                            );

                        }
                    );


                closeButton?.addEventListener(
                    'click',
                    closeModal
                );

                cancelButton?.addEventListener(
                    'click',
                    closeModal
                );

                overlay?.addEventListener(
                    'click',
                    closeModal
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
                            modal?.classList.contains(
                                'active'
                            )
                        ) {

                            closeModal();

                        }

                    }
                );

            }

        );
    </script>
@endpush
