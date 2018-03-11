@extends('app')

@section('title', env('APP_NAME', 'Jobbrek') . " | " . $jobMatch->annons->annonsrubrik)
@section('meta-description', $jobMatch->annons->annonsrubrik . " | " . $jobMatch->arbetsplats->arbetsplatsnamn)

@section('og-title', $jobMatch->annons->annonsrubrik)
@section('og-description', (strlen(strip_tags($jobMatch->annons->annonstext))<200) ? strip_tags($jobMatch->annons->annonstext) : substr(strip_tags($jobMatch->annons->annonstext), 0, 200)." ...")

@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1 newJobContainer">
            <div class="messageBoxHeading">
                <a href="{{ URL::previous() }}">
                    <button class="singleJobButton">
                        <span class="glyphicon glyphicon-triangle-left"/>
                    </button>
                </a>
                {{ $jobMatch->annons->annonsrubrik }}

                    <h2 class="text-right workplace">
                        <i>
                            @if(property_exists($jobMatch->arbetsplats, 'hemsida'))
                                <a href={{ $jobMatch->arbetsplats->hemsida }}>
                                    {{ $jobMatch->arbetsplats->arbetsplatsnamn }}
                                </a>
                            @else
                                {{ $jobMatch->arbetsplats->arbetsplatsnamn }}
                            @endif
                        </i>
                    </h2>


            </div>
            <div class="panel-body">
                <p style="white-space: pre-line">{{ $jobMatch->annons->annonstext }}</p>
            </div>
            <div class="share-buttons text-right">
                <h4>Dela jobbannons:
                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ env('APP_ENV') === "local" ? env('APP_URL') : URL::current() }}" target="_blank">
                        <img src="{{ asset('images/linkedin.png') }}" alt="LinkedIn" />
                    </a>
                    <a href="http://www.facebook.com/sharer.php?u={{ env('APP_ENV') === "local" ? env('APP_URL') : URL::current() }}" target="_blank">
                        <img src="{{ asset('images/facebook.png') }}" alt="Facebook" />
                    </a>
                </h4>
            </div>
            <div class="moreInfo">
                <p class="extraJobInfo"> Varaktighet: {{ $jobMatch->villkor->varaktighet }} </p>
                <p class="extraJobInfo"> Kommun:  {{ $jobMatch->annons->kommunnamn }}</p>
                <p class="extraJobInfo"> Publicerad: {{ date('d-m-Y', strtotime($jobMatch->annons->publiceraddatum)) }} </p>
                <p class="extraJobInfo"> Dagar sedan publicering: {{ $daysSincePublished }} </p>
                {{--@if(key_exists('platsannonsUrl', $jobMatch->annons))--}}
                    {{--<p class="extraJobInfo"><a target="_blank" href="{{ $jobMatch->annons->platsannonsUrl }}">Länk till arbetsförmedlingen</a></p>--}}
                {{--@endif--}}
                @if(isset($jobMatch->ansokan->sista_ansokningsdag))
                        <div class="extraJobInfo">Sista ansökningsdag {{ substr($jobMatch->ansokan->sista_ansokningsdag, 0, 10) }}</div>
                @endif

                {{-- Om vi skulle vilja ha kontaktformulär på AF-annonser också --}}
                {{--<div class="row">--}}
                    {{--@if(!isset($jobMatch->annons->platsannonsUrl))--}}
                        {{--@include('pages.partials.applicationform')--}}
                    {{--@endif--}}
                    {{--<div class="col-sm-4 col-sm-offset-4">--}}
                        {{--@if(!isset($jobMatch->annons->platsannonsUrl))--}}
                            {{--<button class="btn btn-confirm" data-action="contactForm">Ansök</button>--}}
                        {{--@else--}}
                            {{--<a target="_blank" href="{{ $jobMatch->annons->platsannonsUrl }}">--}}
                                {{--<button class="btn btn-confirm">Ansök</button>--}}
                            {{--</a>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}

                <h4 class="text-center m-v-2 text-secondary">Kom ihåg att ange {{ env('APP_NAME', 'Jobbrek') }} som referens vid ansökan!</h4>

                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        @if(isset($jobMatch->annons->platsannonsUrl))
                            <a target="_blank" href="{{ $jobMatch->annons->platsannonsUrl }}">
                                <button class="btn btn-confirm">Ansök</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection