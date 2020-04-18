@if ($paginator->hasPages())
    <ul class="pagination pagination mb-0 mt-3">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span  class="page-link">«</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev, nofollow">«</a></li>
        @endif

        @if($paginator->currentPage() > 3)
            <li class="hidden-xs page-item"><a class="page-link" href="{{ $paginator->url(1) }}" rel="nofollow">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="page-item"><span class="page-link">...</span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="active page-item"><span  class="page-link">{{ $i }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}" rel="nofollow">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item"><span class="page-link">...</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="hidden-xs page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" rel="nofollow">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next, nofollow">»</a></li>
        @else
            <li class="disabled page-item"><span class="page-link">»</span></li>
        @endif
    </ul>
@endif

