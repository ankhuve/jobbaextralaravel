<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" minimal-ui>
        <meta name="description" content="Utvecklingssite för Jobbaextra.com" />
        <meta name="keywords" content="extrajobb, sommarjobb, jobb, extra, jobbaextra, deltid, deltidsjobb" />
        <meta name="_token" content="{!! csrf_token() !!}"/>

        <title>Under utveckling</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="/css/style.css"/>
        <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,700|Raleway:400' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <nav>
            <a class="headerLogo" href="/"><img src="/img/jobbaextra_logo.png"/></a>
            <img id="hamburgerIcon" src="/img/thin_burger.png">
            <div class="navLinks">
                <ul class="nav">
                    <li>
                        <a href="/">Start</a>
                    </li><li>
                        <a href="{{ URL::action('SearchController@index') }}">Leta jobb</a>
                    </li><li>
                        <a href="{{ URL::action('CompanyController@index') }}">Hitta arbetskraft</a>
                    </li><li>
                        <a href="{{ URL::action('AboutController@index') }}">Om oss</a>
                    </li>@if(Auth::check())<li>
                            <a href="{{ URL::action('Auth\AuthController@getLogout') }}">Logga ut</a>
                        </li>
                    @else<li>
                            <a href="{{ URL::action('Auth\AuthController@getLogin') }}">Logga in</a>
                        </li><li>
                            <a href="{{ URL::action('RegisterController@index') }}">Registrera</a>
                        </li>
                    @endif
                </ul>
            </div>

        </nav>
        <div class="view">
            @yield('content')
        </div>
    </body>
</html>