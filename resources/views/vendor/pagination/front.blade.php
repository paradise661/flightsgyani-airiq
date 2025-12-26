@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-center mt-8">
        <ul class="inline-flex items-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-red-400 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-300  hover:bg-green-500 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-white border text-red-500">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                {{-- Array of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="w-10 h-10 flex items-center justify-center rounded-full bg-green-500 text-white font-bold">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-300  hover:bg-green-500 hover:text-white transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-300  hover:bg-green-500 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
            @else
                <li>
                    <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-red-400 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
