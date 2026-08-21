<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Marimoi Cafe')
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ======================================================
         FONT
    ======================================================= --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">


    {{-- ======================================================
         ICON
    ======================================================= --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    {{-- ======================================================
         GLOBAL APP CSS
    ======================================================= --}}

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


    {{-- ======================================================
         PAGE CSS
    ======================================================= --}}

    @stack('css')

</head>


<body>

    <div class="wrapper">


        {{-- ==================================================
             SIDEBAR
        =================================================== --}}

        @include('components.sidebar')


        {{-- ==================================================
             MAIN
        =================================================== --}}

        <main class="main">

            <div class="page">


                {{-- ==========================================
                     NAVBAR
                =========================================== --}}

                @include('components.navbar')


                {{-- ==========================================
                     CONTENT
                =========================================== --}}

                <div class="content">

                    @yield('content')

                </div>


            </div>

        </main>


    </div>


    {{-- ======================================================
         TOAST
    ======================================================= --}}

    <div class="toast-container"></div>


    {{-- ======================================================
         GLOBAL LOADING
    ======================================================= --}}

    <div class="loading">

        <div class="loading-content">

            <div class="spinner"></div>

            <div>
                Sedang memproses...
            </div>

        </div>

    </div>


    {{-- ======================================================
         LUCIDE
    ======================================================= --}}

    <script src="https://unpkg.com/lucide@latest"></script>


    {{-- ======================================================
         APEX CHART
    ======================================================= --}}

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    {{-- ======================================================
         PROJECT JAVASCRIPT
    ======================================================= --}}

    <script src="{{ asset('js/sidebar.js') }}"></script>

    <script src="{{ asset('js/dropdown.js') }}"></script>

    <script src="{{ asset('js/modal.js') }}"></script>

    <script src="{{ asset('js/toast.js') }}"></script>

    <script src="{{ asset('js/loading.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>


    {{-- ======================================================
         LUCIDE INIT
    ======================================================= --}}

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                if (
                    typeof lucide !== 'undefined'
                ) {

                    lucide.createIcons();

                }

            }
        );
    </script>


    {{-- ======================================================
         FLASH SUCCESS
    ======================================================= --}}

    @if (session('success'))
        <script>
            document.addEventListener(
                'DOMContentLoaded',
                function() {

                    if (
                        typeof showToast === 'function'
                    ) {

                        showToast(
                            'success',
                            'Berhasil',
                            @json(session('success'))
                        );

                    }

                }
            );
        </script>
    @endif


    {{-- ======================================================
         FLASH ERROR
    ======================================================= --}}

    @if (session('error'))
        <script>
            document.addEventListener(
                'DOMContentLoaded',
                function() {

                    if (
                        typeof showToast === 'function'
                    ) {

                        showToast(
                            'danger',
                            'Gagal',
                            @json(session('error'))
                        );

                    }

                }
            );
        </script>
    @endif


    {{-- ======================================================
         FLASH WARNING
    ======================================================= --}}

    @if (session('warning'))
        <script>
            document.addEventListener(
                'DOMContentLoaded',
                function() {

                    if (
                        typeof showToast === 'function'
                    ) {

                        showToast(
                            'warning',
                            'Peringatan',
                            @json(session('warning'))
                        );

                    }

                }
            );
        </script>
    @endif


    {{-- ======================================================
         FLASH INFO
    ======================================================= --}}

    @if (session('info'))
        <script>
            document.addEventListener(
                'DOMContentLoaded',
                function() {

                    if (
                        typeof showToast === 'function'
                    ) {

                        showToast(
                            'info',
                            'Informasi',
                            @json(session('info'))
                        );

                    }

                }
            );
        </script>
    @endif


    {{-- ======================================================
         PAGE SPECIFIC SCRIPTS
    ======================================================= --}}

    @stack('scripts')


</body>

</html>
