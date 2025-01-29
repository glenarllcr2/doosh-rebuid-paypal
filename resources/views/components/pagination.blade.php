<div class="d-flex justify-content-between align-items-center">
    <span>
        {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} of {{ $paginator->total() }}
    </span>
    <ul class="pagination mb-0">
        <!-- Show previous button only if not on the first page -->
        @if (!$paginator->onFirstPage())
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        @endif

        <!-- Show next button only if more pages are available -->
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        @endif
    </ul>
</div>
