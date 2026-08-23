<div class="dashboard-chart-grid">

    {{-- =====================================================
         PENDAPATAN VS PENGELUARAN
    ====================================================== --}}

    <div class="chart-card">

        <div class="chart-header">

            <div>

                <div class="chart-title">

                    Pendapatan vs Pengeluaran

                </div>

                <p>

                    Perbandingan keuangan 30 hari terakhir.

                </p>

            </div>

            <span class="chart-badge">

                30 Hari

            </span>

        </div>

        <div id="financialChart"></div>

    </div>


    {{-- =====================================================
         METODE PEMBAYARAN
    ====================================================== --}}

    <div class="chart-card payment-card">

        <div class="chart-header">

            <div>

                <div class="chart-title">

                    Metode Pembayaran

                </div>

                <p>

                    Persentase transaksi bulan ini.

                </p>

            </div>

        </div>


        <div id="paymentChart"></div>


        <div class="payment-info">

            <div class="payment-row">

                <span class="dot green"></span>

                Cash

                <strong>
                    {{ $cashPercent }}%
                </strong>

            </div>


            <div class="payment-row">

                <span class="dot blue"></span>

                Transfer

                <strong>
                    {{ $transferPercent }}%
                </strong>

            </div>

        </div>

    </div>

</div>


@push('scripts')

<script>

document.addEventListener(
    "DOMContentLoaded",
    function() {


        /* =====================================================
           FINANCIAL CHART
        ====================================================== */

        const financialElement =
            document.querySelector(
                "#financialChart"
            );


        if (financialElement) {

            new ApexCharts(
                financialElement,
                {

                    chart: {

                        type: 'area',

                        height: 350,

                        toolbar: {

                            show: false

                        },

                        zoom: {

                            enabled: false

                        }

                    },


                    series: [

                        {

                            name: 'Pendapatan',

                            data:
                                @json($chartSeries)

                        },

                        {

                            name: 'Pengeluaran',

                            data:
                                @json($expenseChartSeries)

                        }

                    ],


                    xaxis: {

                        categories:
                            @json($chartLabels)

                    },


                    colors: [

                        '#79513B',

                        '#B85C4A'

                    ],


                    stroke: {

                        width: 3,

                        curve: 'smooth'

                    },


                    fill: {

                        type: 'gradient',

                        gradient: {

                            shadeIntensity: 1,

                            opacityFrom: .30,

                            opacityTo: .04

                        }

                    },


                    dataLabels: {

                        enabled: false

                    },


                    legend: {

                        position: 'top',

                        horizontalAlign: 'right'

                    },


                    tooltip: {

                        y: {

                            formatter:
                                function(val) {

                                    return 'Rp ' +
                                        Number(val)
                                            .toLocaleString(
                                                'id-ID'
                                            );

                                }

                        }

                    },


                    grid: {

                        borderColor:
                            '#EADFD6'

                    }

                }

            ).render();

        }


        /* =====================================================
           PAYMENT CHART
        ====================================================== */

        const paymentElement =
            document.querySelector(
                "#paymentChart"
            );


        if (paymentElement) {

            new ApexCharts(
                paymentElement,
                {

                    chart: {

                        type: 'donut',

                        height: 320

                    },


                    series: [

                        {{ $cashPercent }},

                        {{ $transferPercent }}

                    ],


                    labels: [

                        'Cash',

                        'Transfer'

                    ],


                    colors: [

                        '#79513B',

                        '#7894A8'

                    ],


                    legend: {

                        show: false

                    },


                    dataLabels: {

                        enabled: true

                    },


                    stroke: {

                        width: 0

                    }

                }

            ).render();

        }

    }

);

</script>

@endpush
