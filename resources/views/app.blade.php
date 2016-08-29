<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" minimal-ui>
        <meta name="description" content="Jobbrek.se | Lediga jobb inom skola, sjukvård, IT, m.m." />
        <meta name="keywords" content="Lediga jobb, jobb, skola, sjukvård, IT, jobbrek, extrajobb, deltidsjobb, jobba extra" />
        <meta name="_token" content="{!! csrf_token() !!}"/>

        <title>Jobbrek</title>
        {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">--}}
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="{{ elixir('css/app.css') }}"/>
        {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,700|Raleway:400' rel='stylesheet' type='text/css'>

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-83188287-1', 'auto');
            ga('send', 'pageview');

        </script>
    </head>
    <body>
        <nav>
            <a class="headerLogo" href="/"><img src="{{ asset('build/img/jobbrek.png') }}"/></a>
            <img id="hamburgerIcon" src="{{ asset('build/img/thin_burger.png') }}">
            <div class="navLinks">
                <ul class="nav">
                    <li>
                        <a href="/">Start</a>
                    </li><li>
                        <a href="{{ URL::action('SearchController@index') }}">Leta jobb</a>
                    </li><li>
                        <a href="{{ URL::action('CompanyController@index') }}">Hitta arbetskraft</a>
                    </li><li>
                        <a href="{{ URL::action('FeaturedController@index') }}">Attraktiva arbetsgivare</a>
                    </li><li>
                        <a href="{{ URL::action('AboutController@index') }}">Om oss</a>
                    </li><li>
                        <a href="{{ URL::action('ContactController@create') }}">Kontakt</a>
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

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.min.js"></script>
    <script src="{{ asset('js/summernote/lang/summernote-sv-SE.js') }}"></script>
    <script src="{{ elixir('js/search.js') }}"></script>
</html>