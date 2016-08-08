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
                {{ $jobMatch->title }}

                    <h2 class="text-right workplace">
                        <i>
                            {{ $jobMatch->work_place }}
                        </i>
                    </h2>


            </div>
            <div class="panel-body">
                <p style="white-space: pre-line">{{ $jobMatch->description }}</p>
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
                    <div class="col-sm-4 col-sm-offset-4">
                        @if($jobMatch->external_link != '')
                            <a target="_blank" href="{{ $jobMatch->external_link }}">
                        @else
                            <a target="_blank" href="mailto:{{ $jobMatch->contact_email }}">
                        @endif
                                <button class="btn btn-confirm">Ansök</button>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection