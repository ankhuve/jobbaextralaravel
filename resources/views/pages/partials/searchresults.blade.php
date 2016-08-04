@if (!empty($jobs))
    {{--<div id="numSearchResults">--}}
        {{--<h4>Antal sökträffar: <span id="numberOfJobMatches">{{ $searchMeta['antal_platsannonser'] }} + {{ count($customJobs) }}</span></h4>--}}
    {{--</div>--}}
@endif

@if (!empty($jobs))
    <div class="searchResults row">

        @foreach($jobs as $job)
            @if(key_exists('annonsid', $job))
                @include('pages.partials.jobbpuff')
            @else
                @include('pages.partials.jobbaextrapuff')
            @endif

        @endforeach

    </div>


    {{--@if($jobs->matchningslista->antal_sidor > 1)--}}
        {{--@include('pages.partials.pagination')--}}
    {{--@endif--}}
@endif

{{--@if (array_key_exists('matchningdata', $jobs->matchningslista))--}}
    {{--<div class="searchResults row">--}}
        {{--@foreach($jobs->matchningslista->matchningdata as $job)--}}
            {{--@include('pages.partials.jobbpuff')--}}
        {{--@endforeach--}}

    {{--</div>--}}
    {{--@if($jobs->matchningslista->antal_sidor > 1)--}}
        {{--@include('pages.partials.pagination')--}}
    {{--@endif--}}
{{--@endif--}}