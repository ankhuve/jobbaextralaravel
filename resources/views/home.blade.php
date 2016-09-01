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
                    <h3>Just nu kan du söka bland</h3>
                </div>
                @foreach(str_split($numJobs) as $number)<span>
                        {{ $number }}
                    </span>@endforeach
                <div>
                    <h3>aktiva jobbannonser</h3>
                </div>
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

            {{--<div class="col-md-5 col-lg-4 col-md-offset-1 col-lg-offset-2">--}}
                {{--<div class="boxAndButton" id="userInfo">--}}
                    {{--<div class="infoBox" >--}}
                        {{--<div id="infoBoxTitle">--}}
                            {{--<h3 class="infoTitle"><span class="underlined">Jobbsökande</span>?</h3>--}}
                        {{--</div>--}}
                        {{--<p class="infoDescription">--}}
                            {{--Här kan du söka bland tusentals jobb!--}}
                            {{--<br><br>--}}
                            {{--Oavsett om du är nyutexaminerad eller helt enkelt vill vidare i karriären kan vi hjälpa dig att hitta rätt. Vi jobbar rikstäckande och hjälper allt i från enskilda firmor till stora koncerner, kommuner och myndigheter med att hitta rätt personal.--}}
                            {{--<br><br>--}}
                            {{--Registrera dig nedan. Låt oss se vad du gör idag, vad du vill göra i morgon och hur vi kan hjälpa dig med nästa steg i din karriär.--}}
                        {{--</p>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-xs-12">--}}
                            {{--<a href="{{ URL::action('RegisterController@index') }}"><button class="registerButton" >Skapa din profil</button></a>--}}
                            {{--<br/>--}}
                            {{--<div class="alreadyJoined">Redan medlem? <a class="loginLink" href="auth/login">Logga in!</a></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-md-5 col-lg-4">--}}
                {{--<div class="boxAndButton" id="userInfo">--}}
                    {{--<div class="infoBox" >--}}
                        {{--<div id="infoBoxTitle">--}}
                            {{--<h3 class="infoTitle"><span class="underlined">Jobbsökande</span>?</h3>--}}
                        {{--</div>--}}
                        {{--<p class="infoDescription">--}}
                            {{--Här kan du söka bland tusentals jobb!--}}
                            {{--<br><br>--}}
                            {{--Oavsett om du är nyutexaminerad eller helt enkelt vill vidare i karriären kan vi hjälpa dig att hitta rätt. Vi jobbar rikstäckande och hjälper allt i från enskilda firmor till stora koncerner, kommuner och myndigheter med att hitta rätt personal.--}}
                            {{--<br><br>--}}
                            {{--Registrera dig nedan. Låt oss se vad du gör idag, vad du vill göra i morgon och hur vi kan hjälpa dig med nästa steg i din karriär.--}}
                        {{--</p>--}}
                    {{--</div>--}}
                    {{--<div id="registerUser">--}}
                        {{--<a href="{{ URL::action('RegisterController@index') }}"><button class="registerButton" >Skapa din profil</button></a>--}}
                        {{--<br/>--}}
                        {{--<span class="alreadyJoined">Redan medlem? <a class="loginLink" href="auth/login">Logga in!</a></span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>

    </div>
    {{--<div class="infoBoxes row">--}}
    {{--<div class="boxAndButton" id="userInfo">--}}
    {{--<div class="infoBox" >--}}
    {{--<div id="infoBoxTitle">--}}
    {{--<h3 class="infoTitle"><span class="underlined">Jobbsökande</span>?</h3>--}}
    {{--</div>--}}
    {{--<p class="infoDescription">--}}
    {{--Här kan du söka bland tusentals jobb!--}}
    {{--<br><br>--}}
    {{--Oavsett om du är nyutexaminerad eller helt enkelt vill vidare i karriären kan vi hjälpa dig att hitta rätt. Vi jobbar rikstäckande och hjälper allt i från enskilda firmor till stora koncerner, kommuner och myndigheter med att hitta rätt personal.--}}
    {{--<br><br>--}}
    {{--Registrera dig nedan. Låt oss se vad du gör idag, vad du vill göra i morgon och hur vi kan hjälpa dig med nästa steg i din karriär.--}}
    {{--</p>--}}
    {{--</div>--}}
    {{--<div id="registerUser">--}}
    {{--<a href="{{ URL::action('RegisterController@index') }}"><button class="registerButton" >Skapa din profil</button></a>--}}
    {{--<br/>--}}
    {{--<span class="alreadyJoined">Redan medlem? <a class="loginLink" href="auth/login">Logga in!</a></span>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="boxAndButton" id="companyInfo">--}}
    {{--<div class="infoBox" >--}}
    {{--<div id="infoBoxTitle">--}}
    {{--<h3 class="infoTitle"><span class="underlined">Arbetsgivare</span>?</h3>--}}
    {{--</div>--}}
    {{--<p class="infoDescription">--}}
    {{--Är det viktigt för er med en smidig och lyckad rekrytering?--}}
    {{--<br><br>--}}
    {{--Någon att bolla med och som har 20 års erfarenhet av branschen?--}}
    {{--<br><br>--}}
    {{--Då är ni hjärtligt välkomna att registrera er under fliken Registrera ditt företag eller kontakta oss för personlig service så kan vi prata vidare om just ert behov, era förväntningar och hur vi tillsammans kan nå det bästa resultatet av er rekrytering.--}}
    {{--</p>--}}
    {{--</div>--}}
    {{--<div class="registerCompany" id="registerCompany">--}}
    {{--<a href="{{ URL::action('RegisterController@index') }}"><button class="registerButton">Registrera ditt företag</button></a>--}}
    {{--<br/>--}}
    {{--<span class="alreadyJoined">Redan kund? <a class="loginLink" href="auth/login">Logga in!</a></span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    <div class="latestJobs">
        <div id="jobsTitle">
            <h3 class="infoTitle underlined">Våra senaste jobb</h3>
        </div>
        @foreach($newJobs as $job)
            @include('pages.partials.jobbaextrapuff')
        @endforeach
    </div>
    </div>

@endsection
