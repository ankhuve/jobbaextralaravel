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
                            @if(property_exists($jobMatch, 'work_place'))
                                {{ $jobMatch->work_place }}
                            @endif
                        </i>
                    </h2>


            </div>
            <div class="panel-body">
                <p style="white-space: pre-line">{{ $jobMatch->description }}</p>
            </div>
            <div class="moreInfo">
                {{--<p class="extraJobInfo"> Varaktighet: {{ $jobMatch->villkor->varaktighet }} </p>--}}
                <p class="extraJobInfo"> Kommun:  {{ $jobMatch->municipality }}</p>
                <p class="extraJobInfo"> Publicerad: {{ date('d-m-Y', strtotime($jobMatch->published_at)) }} </p>
                <p class="extraJobInfo"> Dagar sedan publicering: {{ $daysSincePublished }} </p>
                {{--<p class="extraJobInfo"><a href="{{ $jobMatch->annons->platsannonsUrl }}">Länk till arbetsförmedlingen</a></p>--}}
                <hr>
                @if(isset($jobMatch->contact_email))
                    <div><a href="mailto:{{ $jobMatch->contact_email }}">{{ $jobMatch->contact_email }}</a></div>
                @endif
                @if(isset($jobMatch->latest_application_date))
                        <div class="extraJobInfo">Sista ansökningsdag {{ $jobMatch->latest_application_date }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection