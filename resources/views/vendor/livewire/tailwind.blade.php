<div class="flex items-center mt-6">
    @if ($paginator->hasPages())
        <!-- Pagination Controls -->
        <div class="flex items-center space-x-2">
            <!-- Previous Button -->
            @if ($paginator->onFirstPage())
                <button type="button"
                    class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-500 bg-white border border-gray-300 cursor-default focus:outline-none dark:text-white dark:bg-neutral-700 dark:border-neutral-600 dark:hover:bg-neutral-600 dark:focus:bg-neutral-600"
                    disabled>
                    <span aria-hidden="true">«</span>
                    <span class="sr-only">Previous</span>
                </button>
            @else
                <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                    class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-600">
                    <span aria-hidden="true">«</span>
                    <span class="sr-only">Previous</span>
                </button>
            @endif

            <!-- Pagination Numbers -->
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <button type="button"
                            wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                            class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-600
                                @if ($page == $paginator->currentPage()) bg-gray-200 dark:bg-neutral-600 @endif">
                            {{ $page }}
                        </button>
                    @endforeach
                @endif
            @endforeach

            <!-- Next Button -->
            @if ($paginator->hasMorePages())
                <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                    wire:loading.attr="disabled"
                    class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-600">
                    <span aria-hidden="true">»</span>
                    <span class="sr-only">Next</span>
                </button>
            @else
                <button type="button"
                    class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-500 bg-white border border-gray-300 cursor-default focus:outline-none dark:text-white dark:bg-neutral-700 dark:border-neutral-600 dark:hover:bg-neutral-600 dark:focus:bg-neutral-600"
                    disabled>
                    <span aria-hidden="true">»</span>
                    <span class="sr-only">Next</span>
                </button>
            @endif
        </div>

        <!-- Pagination Info -->
        {{-- <div class="ml-auto text-xs text-gray-500 dark:text-neutral-400">
            Showing <span>{{ $paginator->firstItem() }}</span> to <span>{{ $paginator->lastItem() }}</span> of
            <span>{{ $paginator->total() }}</span> entries
        </div> --}}
        <div class="ml-auto text-xs text-gray-500 dark:text-neutral-400">
            <p class="text-sm text-gray-700 leading-5">
                <span>{!! __('Showing') !!}</span>
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                <span>{!! __('to') !!}</span>
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                <span>{!! __('of') !!}</span>
                <span class="font-medium">{{ $paginator->total() }}</span>
                <span>{!! __('results') !!}</span>
            </p>
        </div>
    @endif
</div>
