{{--
    Pagination custom — cuma tombol halaman, tanpa teks "Showing X to Y of Z results"
    karena teks ringkasan sudah ditampilkan manual lewat .pagination-info di blade halaman.

    Cara pakai:
    {{ $orders->links('vendor.pagination.custom') }}
--}}

@if ($paginator->hasPages())
    <nav class="pagination-nav" aria-label="Navigasi halaman">

        <ul class="pagination-list">

            {{-- PREVIOUS --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link"><i data-lucide="chevron-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">
                        <i data-lucide="chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- PAGE NUMBERS --}}
            @foreach ($elements as $element)

                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link page-dots">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif

            @endforeach

            {{-- NEXT --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">
                        <i data-lucide="chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link"><i data-lucide="chevron-right"></i></span>
                </li>
            @endif

        </ul>

    </nav>
@endif
