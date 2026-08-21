<div class="dashboard-chart-grid">

    {{-- Sales Chart --}}
    <div class="chart-card">

        <div class="chart-header">

            <div>

                <div class="chart-title">

                    Pendapatan 30 Hari Terakhir

                </div>

                <p>

                    Grafik berdasarkan transaksi penjualan.

                </p>

            </div>

            <span class="chart-badge">

                Live

            </span>

        </div>

        <div id="salesChart"></div>

    </div>

    {{-- Payment --}}
    <div class="chart-card payment-card">

        <div class="chart-header">

            <div>

                <div class="chart-title">

                    Metode Pembayaran

                </div>

                <p>

                    Persentase transaksi hari ini.

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
        document.addEventListener("DOMContentLoaded", function() {

            /*==========================================
                SALES CHART
            ==========================================*/

            new ApexCharts(

                document.querySelector("#salesChart"),

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

                    series: [{

                        name: 'Pendapatan',

                        data: @json($chartSeries)

                    }],

                    xaxis: {

                        categories: @json($chartLabels)

                    },

                    colors: ['#10B981'],

                    stroke: {

                        width: 4,

                        curve: 'smooth'

                    },

                    fill: {

                        type: 'gradient',

                        gradient: {

                            shadeIntensity: 1,

                            opacityFrom: .45,

                            opacityTo: .05

                        }

                    },

                    dataLabels: {

                        enabled: false

                    },

                    tooltip: {

                        y: {

                            formatter: function(val) {

                                return 'Rp ' + Number(val).toLocaleString('id-ID');

                            }

                        }

                    },

                    grid: {

                        borderColor: '#EEF2F7'

                    }

                }

            ).render();

            /*==========================================
                PAYMENT CHART
            ==========================================*/

            new ApexCharts(

                document.querySelector("#paymentChart"),

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

                        '#10B981',

                        '#3B82F6'

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

        });
    </script>
@endpush
