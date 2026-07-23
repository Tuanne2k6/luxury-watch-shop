{{-- resources/views/vendor/pagination/custom.blade.php --}}
{{-- Dùng: $products->links('vendor.pagination.custom') --}}

@if($paginator->hasPages())
<div class="my-pagination">

    {{-- Nút Previous --}}
    @if($paginator->onFirstPage())
        <span class="page-item disabled">« Trước</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="page-item">« Trước</a>
    @endif

    {{-- Số trang --}}
    @foreach($elements as $element)
        @if(is_string($element))
            <span class="page-item disabled">{{ $element }}</span>
        @endif

        @if(is_array($element))
            @foreach($element as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="page-item active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-item">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Nút Next --}}
    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-item">Sau »</a>
    @else
        <span class="page-item disabled">Sau »</span>
    @endif

</div>
@endif
