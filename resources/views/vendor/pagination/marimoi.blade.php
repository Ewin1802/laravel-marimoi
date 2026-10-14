{{--
    Pagination global Marimoi (dipakai otomatis oleh semua ->links()
    lewat Paginator::defaultView() di AppServiceProvider).

    Berisi ringkasan "Menampilkan X-Y dari Z data" + tombol halaman.
    Tidak butuh Tailwind/Bootstrap, style ada di css/components/pagination.css.
--}}

@if ($paginator->total() > 0)
    <div class="mpg">

        <div class="mpg-info">
            Menampilkan
            <strong>{{ $paginator->firstItem() }}</strong>
            &ndash;
            <strong>{{ $paginator->lastItem() }}</strong>
            dari
            <strong>{{ $paginator->total() }}</strong>
            data
        </div>

        @if ($paginator->hasPages())
            <nav class="mpg-nav" role="navigation" aria-label="Navigasi halaman">

                <ul class="mpg-list">

                    {{-- SEBELUMNYA --}}
                    @if ($paginator->onFirstPage())
                        <li class="mpg-item disabled" aria-disabled="true">
                            <span class="mpg-link" aria-label="Sebelumnya">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                            </span>
                        </li>
                    @else
                        <li class="mpg-item">
                            <a class="mpg-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                            </a>
                        </li>
                    @endif

                    {{-- NOMOR HALAMAN --}}
                    @foreach ($elements as $element)

                        @if (is_string($element))
                            <li class="mpg-item dots" aria-disabled="true">
                                <span class="mpg-link">{{ $element }}</span>
                            </li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="mpg-item active" aria-current="page">
                                        <span class="mpg-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="mpg-item">
                                        <a class="mpg-link" href="{{ $url }}" aria-label="Halaman {{ $page }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif

                    @endforeach

                    {{-- BERIKUTNYA --}}
                    @if ($paginator->hasMorePages())
                        <li class="mpg-item">
                            <a class="mpg-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                            </a>
                        </li>
                    @else
                        <li class="mpg-item disabled" aria-disabled="true">
                            <span class="mpg-link" aria-label="Berikutnya">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                            </span>
                        </li>
                    @endif

                </ul>

            </nav>
        @endif

    </div>
@endif
