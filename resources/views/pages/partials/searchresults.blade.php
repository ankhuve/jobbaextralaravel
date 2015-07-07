@if (!empty($jobs))
    <div id="numSearchResults">
        <h4>Antal sökträffar: <span id="numberOfJobMatches">{{ $jobs->matchningslista->antal_platsannonser }}</span></h4>
    </div>
@endif

@if (array_key_exists('matchningdata', $jobs->matchningslista))
    <div class="searchResults row">
        @foreach($jobs->matchningslista->matchningdata as $job)
            @include('pages.partials.jobbpuff')
        @endforeach

    </div>
    @if($jobs->matchningslista->antal_sidor > 1)
        @include('pages.partials.pagination')
    @endif
@endif