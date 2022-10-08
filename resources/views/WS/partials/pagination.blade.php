@if($paginator->hasPages())
    <nav aria-label="Page navigation" class="coursesPagination diplomaProgramPagination">
        <ul class="pagination justify-content-left">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:;" tabindex="-1">@lang('ws.prev')</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1">@lang('ws.prev')</a>
                </li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('ws.next')</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">@lang('ws.next')</span></li>
            @endif
        </ul>
        <span class="Showing">@lang('ws.showing') <span>{{($paginator->currentPage()-1)*$paginator->perPage()+1}}-{{!$paginator->nextPageUrl() ? $paginator->total() : $paginator->currentPage()*$paginator->perPage()}} </span> @lang('ws.of') <span>{{$paginator->total()}} </span> @lang('ws.result')</span>
    </nav>
@endif
