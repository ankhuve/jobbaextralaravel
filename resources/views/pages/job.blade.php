@extends('app')

@section('content')
    <div class="singleJob">
        <center>
            {{--<div ng-show="loading" class="loadingAnimation">--}}
                {{--<div class="spinner job">--}}
                    {{--<div class="spinner-container job container1">--}}
                        {{--<div class="circle1 lightBlue"></div>--}}
                        {{--<div class="circle2 lightBlue"></div>--}}
                        {{--<div class="circle3 lightBlue"></div>--}}
                        {{--<div class="circle4 lightBlue"></div>--}}
                    {{--</div>--}}
                    {{--<div class="spinner-container job container2">--}}
                        {{--<div class="circle1 lightBlue"></div>--}}
                        {{--<div class="circle2 lightBlue"></div>--}}
                        {{--<div class="circle3 lightBlue"></div>--}}
                        {{--<div class="circle4 lightBlue"></div>--}}
                    {{--</div>--}}
                    {{--<div class="spinner-container job container3">--}}
                        {{--<div class="circle1 lightBlue"></div>--}}
                        {{--<div class="circle2 lightBlue"></div>--}}
                        {{--<div class="circle3 lightBlue"></div>--}}
                        {{--<div class="circle4 lightBlue"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="jobButtons">
                <a href="/search"><button class="singleJobButton">Tillbaka till sök</button></a>
                {{--<span ng-show="loggedIn()">--}}
                    {{--<button class="singleJobButton save" ng-click="saveJob(jobMatch.annons.annonsid, jobMatch.annons.annonsrubrik)" ng-hide="jobSaved(jobMatch.annons.annonsid)">Spara annons</button>--}}
                    {{--<button class="singleJobButton removeSaved" ng-show="jobSaved(jobMatch.annons.annonsid)" ng-click="removeSaved(jobMatch.annons.annonsid)"> Ta bort från sparade jobb </button>--}}
                {{--</span>--}}
            </div>
        </center>

        <div class="jobInfo">
           <h2>{{ $jobMatch->annons->annonsrubrik }}</h2>
            <p style="white-space: pre-line">{{ $jobMatch->annons->annonstext }}</p>
        </div>
        <div class="moreInfo">
            <p class="extraJobInfo"> Varaktighet: {{ $jobMatch->villkor->varaktighet }} </p>
            <p class="extraJobInfo"> Kommun:  {{ $jobMatch->annons->kommunnamn }}</p>
            <p class="extraJobInfo"> Publicerad: {{ date('d-m-Y', strtotime($jobMatch->annons->publiceraddatum)) }} </p>
            <p class="extraJobInfo"> Dagar sedan publicering: {{ $daysSincePublished }} </p>
            <p class="extraJobInfo"><a href="{{ $jobMatch->annons->platsannonsUrl }}">Länk till arbetsförmedlingen</a></p>
    {{--        <div>{{ jobMatch.ansokan.epostadress }}</div>--}}
    {{--        <div class="extraJobInfo">Sista ansökningsdag {{ jobMatch.ansokan.sista_ansokningsdag | date:'yyyy-MM-dd' }}</div>--}}
        </div>
    </div>
@endsection