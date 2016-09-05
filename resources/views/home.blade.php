@extends('app')

@section('content')
    <center>
        <div class="searchBar">
            <div id="orangeBG">
                {!! Form::open(array('url' => 'search', 'method' => 'get')) !!}
                {!! Form::text('q', null, array('class'=>'jobSearchForm', 'placeholder'=>'Hitta ett jobb', 'autofocus'=>'autofocus')) !!}
                {!! Form::submit('SÖK', array('class'=>'searchButton')) !!}
                {!! Form::close() !!}
            </div>
            <span id="searchBarIcon"></span>
        </div>

        <div class="col-xs-12">
            <div class="job-counter">
                <div>
                    <h3>Aktiva jobbannonser </h3>
                </div>
                @foreach(str_split($numJobs) as $number)<span>
                        {{ $number }}
                    </span>@endforeach
            </div>
        </div>

        <div id="splash">
            <h2 id="splashText">Vi letar efter dig</h2>
        </div>
    </center>

    <div class="container m-t-2">
        <div class="row m-t-2">

            @foreach($content as $key => $block)
                <div class="col-md-5 col-lg-4 {{ $key === 0 ? 'col-md-offset-1 col-lg-offset-2' : '' }}">
                    <div class="boxAndButton" id="userInfo">
                        <div class="infoBox" >
                            <div id="infoBoxTitle">
                                <h3 class="infoTitle"><span class="underlined">{{ $block->title }}</span>?</h3>
                            </div>
                            <p style="white-space: pre-line">
                                {{ $block->content }}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="{{ URL::action('RegisterController@index') }}"><button class="registerButton" >Skapa din profil</button></a>
                                <br/>
                                <div class="alreadyJoined">Redan medlem? <a class="loginLink" href="auth/login">Logga in!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="latestJobs">
                    <div id="jobsTitle">
                        <h3 class="infoTitle underlined">Våra senaste jobb</h3>
                    </div>
                    @foreach($newJobs as $job)
                        @include('pages.partials.jobbaextrapuff')
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
