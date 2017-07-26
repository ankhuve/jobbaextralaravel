@extends('app')

@section('content')
    <center>
        <div class="searchBar">
            <div id="orangeBG">
                {!! Form::open(array('url' => action('SearchController@index'), 'method' => 'get')) !!}
                {!! Form::text('q', null, array('class'=>'jobSearchForm', 'placeholder'=>'Hitta ett jobb', 'autofocus'=>'autofocus')) !!}
                {!! Form::submit('SÖK', array('class'=>'searchButton')) !!}
                {!! Form::close() !!}
            </div>
            <span id="searchBarIcon"></span>
        </div>

        <div class="col-xs-12">
            <job-counter></job-counter>
        </div>

        <div id="splash">
            <h2 id="splashText">Vi letar efter dig</h2>
        </div>
    </center>

    <div class="container m-t-2">
        <div class="col-xs-12">
            <div class="row">
                @if (!$profiledJobs->isEmpty())
                    @include('pages.partials.profiled-jobs')
                @endif
            </div>
        </div>
    </div>

    <div class="container m-t-2 m-b-2">
        <div class="row m-t-2 m-b-2">
            @if(!is_null($content))
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
                                    <a href="{{ $key === 0 ? URL::action('RegisterController@index') : URL::action('CompanyController@index')  }}"><button class="registerButton" >Skapa din profil</button></a>
                                    <br/>
                                    <div class="alreadyJoined">Redan medlem? <a class="loginLink" href="auth/login">Logga in!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

@endsection
