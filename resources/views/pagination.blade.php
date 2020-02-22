@if ($paginator->hasPages())
    <nav class="flex flex-wrap justify-between">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <div class="px-4 py-1 mr-1 mb-1 rounded-md border text-gray-500 text-xs font-medium">Prev</div>
        @else
            <a class="px-4 py-1 mr-1 mb-1 rounded-md border text-gray-500 text-xs font-medium hover:bg-white" href="{{ $paginator->previousPageUrl() }}">Prev</a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <div class="py-1 mr-1 mb-1 rounded-md text-gray-400 text-xs font-medium">~</div>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <div class="px-3 py-1 mr-1 mb-1 rounded-md border border-green-400 bg-green-400 text-white text-xs font-medium">{{ $page }}</div>
                        @else
                            <a class="px-3 py-1 mr-1 mb-1 rounded-md border text-gray-500 text-xs font-medium hover:bg-white" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="px-4 py-1 mr-1 mb-1 rounded-md border text-gray-500 text-xs font-medium hover:bg-white" href="{{ $paginator->nextPageUrl() }}">Next</a>
        @else
            <div class="px-4 py-1 mr-1 mb-1 rounded-md border text-gray-500 text-xs font-medium">Next</div>
        @endif
    </nav>
@endif
