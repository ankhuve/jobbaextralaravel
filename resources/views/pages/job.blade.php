@extends('app')

@section('content')
    <div class="col-md-10 col-md-offset-1 newJobContainer">
        <div class="messageBoxHeading"><a href="{{ URL::previous() }}"><button class="singleJobButton"><span class="glyphicon glyphicon-triangle-left"/></span></button></a>{{ $jobMatch->annons->annonsrubrik }}</div>
        <div class="panel-body">
            <p style="white-space: pre-line">{{ $jobMatch->annons->annonstext }}</p>
        </div>
        <div class="moreInfo">
            <p class="extraJobInfo"> Varaktighet: {{ $jobMatch->villkor->varaktighet }} </p>
            <p class="extraJobInfo"> Kommun:  {{ $jobMatch->annons->kommunnamn }}</p>
            <p class="extraJobInfo"> Publicerad: {{ date('d-m-Y', strtotime($jobMatch->annons->publiceraddatum)) }} </p>
            <p class="extraJobInfo"> Dagar sedan publicering: {{ $daysSincePublished }} </p>
            <p class="extraJobInfo"><a href="{{ $jobMatch->annons->platsannonsUrl }}">Länk till arbetsförmedlingen</a></p>
                    <div>{{ $jobMatch->ansokan->epostadress }}</div>
            @if(isset($jobMatch->ansokan->sista_ansokningsdag))
                    <div class="extraJobInfo">Sista ansökningsdag {{ substr($jobMatch->ansokan->sista_ansokningsdag, 0, 10) }}</div>
            @endif
        </div>
    </div>
@endsection