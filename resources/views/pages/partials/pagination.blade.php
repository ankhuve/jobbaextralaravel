<div class="col-xs-12 pageSelector">
{{--    @if($currentPage > 1)--}}
    {{--<button class="pageSelectorButton prevButton" {{ $currentPage <= 1 ? 'disabled' : '' }}>--}}
        {{--<span class="glyphicon glyphicon-backward"></span>--}}
    {{--</button>--}}

    @if($currentPage > 1)
        <a href="{{ action('SearchController@index', ['q' => Request::get('q'), 'lan' => Request::get('lan'), 'yrkesomraden' => Request::get('yrkesomraden'), 'sida' => ($currentPage - 1)]) }}">
    @endif
    <button class="pageSelectorButton prevButton" {{ $currentPage <= 1 ? 'disabled' : '' }}>
        <span class="glyphicon glyphicon-chevron-left"></span>
    </button>
    @if($currentPage > 1)
        </a>
    @endif
    {{--@endiuf--}}

    <span class="viewingPageNumber">Sida {{ $currentPage }}</span>
    {{--{{ var_dump(Request::query()) }}--}}

    <a href="{{ action('SearchController@index', ['q' => Request::get('q'), 'lan' => Request::get('lan'), 'yrkesomraden' => Request::get('yrkesomraden'), 'sida' => ($currentPage + 1)]) }}">
        <button class="pageSelectorButton nextButton">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </button>
    </a>

    <button class="pageSelectorButton nextButton">
        <span class="glyphicon glyphicon-forward"></span>
    </button>
</div>