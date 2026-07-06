@if ($paginator->hasPages())
<nav role="navigation" aria-label="Sayfalama" class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-10">

    {{-- Sonuç bilgisi --}}
    <p class="text-sm text-gray-500 order-2 sm:order-1">
        <span class="font-medium" style="color: var(--color-navy);">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</span>
        arası,
        toplam <span class="font-medium" style="color: var(--color-navy);">{{ $paginator->total() }}</span> sonuç
    </p>

    {{-- Sayfa butonları --}}
    <div class="flex items-center gap-1 order-1 sm:order-2">

        {{-- Önceki --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-sm border border-gray-200 text-gray-300 cursor-not-allowed" aria-disabled="true">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="inline-flex items-center justify-center w-9 h-9 rounded-sm border border-gray-200 text-gray-500 hover:border-navy hover:text-navy transition-colors"
               aria-label="Önceki sayfa">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </a>
        @endif

        {{-- Sayfa numaraları --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="inline-flex items-center justify-center w-9 h-9 text-sm text-gray-400 cursor-default">
                    {{ $element }}
                </span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page"
                              class="inline-flex items-center justify-center w-9 h-9 rounded-sm text-sm font-semibold text-white"
                              style="background-color: var(--color-navy);">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="inline-flex items-center justify-center w-9 h-9 rounded-sm border border-gray-200 text-sm text-gray-600 hover:border-navy hover:text-navy transition-colors"
                           aria-label="{{ $page }}. sayfaya git">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Sonraki --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="inline-flex items-center justify-center w-9 h-9 rounded-sm border border-gray-200 text-gray-500 hover:border-navy hover:text-navy transition-colors"
               aria-label="Sonraki sayfa">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </a>
        @else
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-sm border border-gray-200 text-gray-300 cursor-not-allowed" aria-disabled="true">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </span>
        @endif

    </div>
</nav>
@endif
