@if($paginator->hasPages())
    <ul class="pager">
    <li>
        @if($paginator->onFirstPage())
            <span><<span>
        @else
            <a href="{{$paginator->url(1)}}" rel="first"><</a>
        @endif

        @if($paginator->onFirstPage())
            <span><</span>
        @else
            <a href="{{$paginator->previousPageUrl()}}" rel="prev"><</a>
        @endif

        @foreach($elements as $element)
            @if(is_string($element))
                <span>&nbsp{{$element}}&nbsp</span>
            @endif

            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <span>&nbsp<b><u>{{$page}}</u></b>&nbsp</span>
                    @else
                        <a href="{{$url}}">&nbsp{{$page}}&nbsp</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if($paginator->hasMorePages())
            <a href="{{$paginator->nextPageUrl()}}" rel="next">></a>
        @else
            <span>></span>
        @endif

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->url( $paginator->lastPage() ) }}" rel="last">></a>
        @else
            <span>></span>
        @endif
    
    </li></ul>
@endif
