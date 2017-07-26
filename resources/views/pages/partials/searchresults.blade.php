@if (!empty($jobs))
    <div id="numSearchResults">
        <h4>Antal annonser: <span id="numberOfJobMatches">{{ $searchMeta['all'] }}</span></h4>
    </div>
@endif

@if (!empty($jobs))
    <div class="searchResults row">

        @foreach($jobs as $job)
            @if(key_exists('annonsid', $job))
                @include('pages.partials.jobbpuff')
            @else
{{--                @if((\Carbon\Carbon::now()->lte(Carbon\Carbon::parse($job->latest_application_date))))--}}
                    @include('pages.partials.jobbaextrapuff')
                {{--@endif--}}
            @endif

        @endforeach

    </div>
@else
    <div class="searchResults row">

        <div id="numSearchResults">
            <h4>Inga fler jobb hittades!</h4>
        </div>

    </div>
@endif

{{--{!! $paginator->render() !!}--}}
