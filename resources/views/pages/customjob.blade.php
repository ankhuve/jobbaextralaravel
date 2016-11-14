@extends('app')

@section('content')
    <div class="container">

        @if(Session::has('contactError'))
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div class="alert alert-custom">
                        {!! Session::get('contactError') !!}
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-10 col-md-offset-1 newJobContainer">
            <div class="messageBoxHeading">
                <a href="{{ URL::previous() }}">
                    <button class="singleJobButton">
                        <span class="glyphicon glyphicon-triangle-left"></span>
                    </button>
                </a>
                {{ $jobMatch->title }}

                <h2 class="text-right workplace">
                    <i>
                        {{ $jobMatch->work_place }}
                    </i>
                </h2>


            </div>
            <div class="panel-body">
                @if($jobMatch->user->logo_path)
                    <div class="row">
                        <div class="logo col-xs-12" >
                            <div class="logo logo-img logo-job" style="background-image: url('{{ env("UPLOADS_URL") }}/{{ $jobMatch->user->logo_path }}')"></div>
                        </div>
                    </div>
                @endif
                <p style="white-space: pre-line">{!! $jobMatch->description !!}</p>
            </div>
            <div class="moreInfo">
                <p class="extraJobInfo"> Kommun:  {{ $jobMatch->municipality }}</p>
                <p class="extraJobInfo"> Publicerad: {{ date('d-m-Y', strtotime($jobMatch->published_at)) }} </p>
                <p class="extraJobInfo"> Dagar sedan publicering: {{ $daysSincePublished }} </p>
                <hr>
                @if(isset($jobMatch->latest_application_date))
                    <div class="extraJobInfo">Sista ansökningsdag {{ $jobMatch->latest_application_date }}</div>
                @endif
                <div class="row">
                    @if(empty($jobMatch->external_link))
                        @include('pages.partials.applicationform')
                    @endif
                    <div class="col-sm-4 col-sm-offset-4">
                        @if(empty($jobMatch->external_link))
                            <button class="btn btn-confirm" data-action="contactForm">Ansök</button>
                        @else
                            <a target="_blank" href="{{ $jobMatch->external_link }}">
                                <button class="btn btn-confirm">Ansök</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection