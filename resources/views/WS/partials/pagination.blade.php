@if ($paginator->hasPages())
    <div class="container d-flex justify-content-center my-5">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                @if ($paginator->onFirstPage())
                    <li class="mx-2"><a class="page-link arrow-left" href="javascript:void(0)"><i class="fas fa-chevron-left"></i></a></li>
                @else
                    <li class="mx-2"><a class="page-link arrow-left" href="{{ $paginator->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
                @endif
                <li class="mx-2 d-flex align-items-center"><span class="font-inter font-bold600">@lang('ws.page')</span></li>
                <li class="mx-2"><a class="page-link font-inter font-bold600 number" href="javascript:void(0)">{{$paginator->currentPage()}}</a></li>
                <li class="mx-2 d-flex align-items-center"><span class="font-inter font-bold600">@lang('ws.of') {{$paginator->lastPage()}}</span></li>
                @if ($paginator->hasMorePages())
                    <li class="mx-2"><a class="page-link arrow-right" href="{{ $paginator->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
                @else
                    <li class="mx-2"><a class="page-link arrow-right" href="javascript:void(0)"><i class="fas fa-chevron-right"></i></a></li>
                @endif
            </ul>
        </nav>
    </div>
@endif
