<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Setoran Pajak - {{ $scopeLabel }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tax-report.css') }}">
</head>

<body>

    @php
        $rp = fn($n) => 'Rp ' . number_format($n, 0, ',', '.');
        $storeName = $setting->store_name ?? 'Marimoi Cafe';
        $printedAt = now()->locale('id')->translatedFormat('d F Y, H:i') . ' WITA';
    @endphp

    {{-- ===================== TOOLBAR (tidak tercetak) ===================== --}}
    <div class="toolbar">
        <form method="GET" action="{{ route('tax-payments.report') }}">
            <select name="year" onchange="this.form.submit()">
                @foreach ($years as $y)
                    <option value="{{ $y }}" @selected($y == $year)>Tahun {{ $y }}</option>
                @endforeach
            </select>

            <select name="month" onchange="this.form.submit()">
                <option value="">Setahun penuh</option>
                @foreach ($months as $key => $name)
                    <option value="{{ $key }}" @selected($key === $month)>{{ $name }}</option>
                @endforeach
            </select>
        </form>

        <div class="actions">
            <a href="{{ route('tax-payments.index', ['year' => $year]) }}" class="tb-btn ghost">&larr; Kembali</a>
            <button type="button" class="tb-btn primary" onclick="window.print()">Cetak / Simpan PDF</button>
        </div>
    </div>

    {{-- ===================== HALAMAN UTAMA ===================== --}}
    <section class="sheet">

        <header class="rp-head">
            <div class="rp-brand">
                <div class="rp-logo">
                    @if (!empty($setting->logo))
                        <img src="{{ $setting->logo_url }}" alt="Logo">
                    @else
                        <span>{{ strtoupper(substr($storeName, 0, 1)) }}</span>
                    @endif
                </div>
                <div>
                    <b>{{ $storeName }}</b>
                    <small>{{ $setting->store_tagline ?? 'Laporan Keuangan' }}</small>
                </div>
            </div>

            <div class="rp-title">
                <small>Laporan Resmi</small>
                <h1>Setoran Pajak</h1>

                <div class="rp-meta">
                    <span>Periode: <b>{{ $scopeLabel }}</b></span>
                    <span>Dicetak: <b>{{ $printedAt }}</b></span>
                    <span>Oleh: <b>{{ $admin->name }}</b></span>
                </div>
            </div>
        </header>

        <div class="rp-body">

            {{-- RINGKASAN --}}
            <div class="kpis">
                <div class="kpi">
                    <small>Pajak Terkumpul</small>
                    <h3>{{ $rp($totalCollected) }}</h3>
                </div>
                <div class="kpi paid">
                    <small>Sudah Disetor</small>
                    <h3>{{ $rp($totalPaid) }}</h3>
                </div>
                <div class="kpi rest">
                    <small>Sisa Belum Disetor</small>
                    <h3>{{ $rp($totalRemaining) }}</h3>
                </div>
            </div>

            <div class="progress">
                <div class="bar"><i style="width: {{ $percentPaid }}%"></i></div>
                <div class="lbl">
                    <span>{{ $percentPaid }}% dari pajak terkumpul sudah disetor</span>
                    <span>{{ $totalRemaining > 0 ? 'Masih ada sisa kewajiban' : 'Lunas' }}</span>
                </div>
            </div>

            {{-- REKAP PER MASA (hanya jika lebih dari satu masa pajak) --}}
            @if (count($recap) > 1)
                <div class="sec">
                    <div class="sec-title">
                        <h2>Rekap per Masa Pajak</h2>
                    </div>

                    <table class="rp">
                        <thead>
                            <tr>
                                <th>Masa Pajak</th>
                                <th class="num">Terkumpul</th>
                                <th class="num">Disetor</th>
                                <th class="num">Sisa</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recap as $row)
                                <tr>
                                    <td>{{ $row['label'] }}</td>
                                    <td class="num">{{ $rp($row['collected']) }}</td>
                                    <td class="num">{{ $rp($row['paid']) }}</td>
                                    <td class="num">{{ $rp($row['remaining']) }}</td>
                                    <td>
                                        @switch($row['status'])
                                            @case('paid')
                                                <span class="chip paid">Lunas</span>
                                            @break

                                            @case('partial')
                                                <span class="chip partial">Sebagian</span>
                                            @break

                                            @case('unpaid')
                                                <span class="chip unpaid">Belum disetor</span>
                                            @break

                                            @default
                                                <span class="chip none">-</span>
                                        @endswitch
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- DAFTAR SETORAN --}}
            <div class="sec">
                <div class="sec-title">
                    <h2>Rincian Setoran</h2>
                </div>

                <table class="rp">
                    <thead>
                        <tr>
                            <th class="no">No</th>
                            <th>Tanggal Setor</th>
                            <th>Masa Pajak</th>
                            <th>No. Referensi</th>
                            <th class="num">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $i => $p)
                            <tr>
                                <td class="no">{{ $i + 1 }}</td>
                                <td>
                                    {{ $p->payment_date->locale('id')->translatedFormat('d F Y') }}
                                    <span class="sub">oleh {{ $p->user->name ?? '-' }}</span>
                                </td>
                                <td>{{ $p->period_label }}</td>
                                <td>
                                    {{ $p->reference ?: '-' }}
                                    @if ($p->notes)
                                        <span class="sub">{{ \Illuminate\Support\Str::limit($p->notes, 60) }}</span>
                                    @endif
                                </td>
                                <td class="num"><strong>{{ $rp($p->amount) }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty">Belum ada setoran pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="keep">

                {{-- TOTAL: sudah disetor + sisa (tepat di bawah daftar) --}}
                <div class="totals">
                    <div>
                        <span>Pajak terkumpul</span>
                        <b>{{ $rp($totalCollected) }}</b>
                    </div>
                    <div class="ok">
                        <span>Total sudah disetor</span>
                        <b>{{ $rp($totalPaid) }}</b>
                    </div>
                    <div class="grand">
                        <span>Sisa belum disetor</span>
                        <span>{{ $rp($totalRemaining) }}</span>
                    </div>
                </div>

            {{-- TANDA TANGAN --}}
            <div class="sign">
                <div class="col">
                    <div class="place">&nbsp;</div>
                    <div class="role">Mengetahui,</div>
                    <div class="space"></div>
                    <div class="line">
                        <div class="name">&nbsp;</div>
                        <div class="sub">Owner</div>
                    </div>
                </div>

                <div class="col">
                    <div class="place">{{ now()->locale('id')->translatedFormat('d F Y') }}</div>
                    <div class="role">Dibuat oleh,</div>
                    <div class="space"></div>
                    <div class="line">
                        <div class="name">{{ $admin->name }}</div>
                        <div class="sub">Admin</div>
                    </div>
                </div>
            </div>

            </div>{{-- /keep --}}

        </div>

        <div class="rp-foot">
            <span>{{ $storeName }} &middot; Laporan Setoran Pajak {{ $scopeLabel }}</span>
            <span>Dicetak {{ $printedAt }}</span>
        </div>
    </section>

    {{-- ===================== LAMPIRAN BUKTI ===================== --}}
    @if ($payments->count() > 0)
        <section class="sheet">
            <header class="rp-head" style="padding-bottom: 9mm">
                <div class="rp-title" style="margin-top: 0">
                    <small>Lampiran</small>
                    <h1 style="font-size: 24px">Bukti Setoran Pajak</h1>
                    <div class="rp-meta">
                        <span>Periode: <b>{{ $scopeLabel }}</b></span>
                        <span>{{ $payments->count() }} bukti</span>
                    </div>
                </div>
            </header>

            <div class="rp-body">
                <div class="proofs">
                    @foreach ($payments as $i => $p)
                        <div class="proof">
                            <div class="img">
                                <img src="{{ $p->proof_url }}" alt="Bukti setor {{ $i + 1 }}">
                            </div>
                            <div class="cap">
                                <div>
                                    <b>#{{ $i + 1 }} &middot; {{ $rp($p->amount) }}</b>
                                    <span style="display:block">{{ $p->period_label }}</span>
                                </div>
                                <span style="text-align:right">{{ $p->payment_date->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rp-foot">
                <span>{{ $storeName }} &middot; Lampiran Bukti Setoran Pajak</span>
                <span>Dicetak {{ $printedAt }}</span>
            </div>
        </section>
    @endif

</body>

</html>
