@if (!empty($jobs))
    {{--<div id="numSearchResults">--}}
        {{--{{ dd($searchMeta) }}--}}
        {{--<h4>Antal sökträffar: <span id="numberOfJobMatches">{{ $searchMeta['antal_platsannonser'] }} + {{ count($customJobs) }}</span></h4>--}}
    {{--</div>--}}
@endif

@if (!empty($jobs))
    <div class="searchResults row">

        @foreach($jobs as $job)
            @if(key_exists('annonsid', $job))
                @include('pages.partials.jobbpuff')
            @else
                {{--{{ dd(\Carbon\Carbon::today()) }}--}}
                @if((\Carbon\Carbon::now()->lte(Carbon\Carbon::parse($job->latest_application_date))))
                    @include('pages.partials.jobbaextrapuff')
                @endif
            @endif

        @endforeach

    </div>


    {{--@if($jobs->matchningslista->antal_sidor > 1)--}}
        {{--@include('pages.partials.pagination')--}}
    {{--@endif--}}
@else
    <div class="searchResults row">

        <div id="numSearchResults">
            <h4>Inga fler jobb hittades!</h4>
        </div>

        {{--<div class="col-md-12 message text-center">--}}
            {{--<h4>Nu var det slut på jobb!</h4>--}}
        {{--</div>--}}

    </div>
@endif

{{--@if (array_key_exists('matchningdata', $jobs->matchningslista))--}}
    {{--<div class="searchResults row">--}}
        {{--@foreach($jobs->matchningslista->matchningdata as $job)--}}
            {{--@include('pages.partials.jobbpuff')--}}
        {{--@endforeach--}}

    {{--</div>--}}
    {{--@if($jobs->matchningslista->antal_sidor > 1)--}}
        @include('pages.partials.pagination')
    {{--@endif--}}
{{--@endif--}}