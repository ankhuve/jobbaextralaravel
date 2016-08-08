@extends('app')

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
            <div class="moreInfo">
                <p class="extraJobInfo"> Varaktighet: {{ $jobMatch->villkor->varaktighet }} </p>
                <p class="extraJobInfo"> Kommun:  {{ $jobMatch->annons->kommunnamn }}</p>
                <p class="extraJobInfo"> Publicerad: {{ date('d-m-Y', strtotime($jobMatch->annons->publiceraddatum)) }} </p>
                <p class="extraJobInfo"> Dagar sedan publicering: {{ $daysSincePublished }} </p>
                @if($jobMatch->ansokan->epostadress != '')
                    <p class="extraJobInfo"><a target="_blank" href="{{ $jobMatch->annons->platsannonsUrl }}">Länk till arbetsförmedlingen</a></p>
                @endif
                @if(isset($jobMatch->ansokan->sista_ansokningsdag))
                        <div class="extraJobInfo">Sista ansökningsdag {{ substr($jobMatch->ansokan->sista_ansokningsdag, 0, 10) }}</div>
                @endif
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        @if($jobMatch->ansokan->epostadress != '')
                            <a target="_blank" href="mailto:{{ $jobMatch->ansokan->epostadress }}">
                        @else
                            <a target="_blank" href="{{ $jobMatch->annons->platsannonsUrl }}">
                        @endif
                                <button class="btn btn-confirm">Ansök</button>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection