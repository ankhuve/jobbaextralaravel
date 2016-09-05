<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" minimal-ui>
        <meta name="description" content="Jobbrek.se | Lediga jobb inom skola, sjukvård, IT, m.m." />
        <meta name="keywords" content="Lediga jobb, jobb, skola, sjukvård, IT, jobbrek, extrajobb, deltidsjobb, jobba extra" />
        <meta name="_token" content="{!! csrf_token() !!}"/>

        <title>Jobbrek | Lediga jobb i Sverige och Norge</title>
        {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">--}}
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="{{ elixir('css/app.css') }}"/>
        {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,700|Raleway:400' rel='stylesheet' type='text/css'>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

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

        <header class="container-fluid">
            <a href="{{ action('HomeController@index') }}">
                <div class="navbar-brand">
                    <img src="{{ asset('build/img/jobbrek.png') }}"/>
                </div>
            </a>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
        </header>

        <nav class="navbar navbar-custom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{ action('HomeController@index') }}">
                                Start
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::action('SearchController@index') }}">
                                Leta jobb
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::action('CompanyController@index') }}">
                                Hitta arbetskraft
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::action('FeaturedController@index') }}">
                                Attraktiva arbetsgivare
                            </a>
                        </li>
                        <li class="visible-xs">
                            <a href="{{ URL::action('AboutController@index') }}">
                                Om oss
                            </a>
                        </li>
                        <li class="visible-xs">
                            <a href="{{ URL::action('ContactController@create') }}">Kontakt</a>
                        </li>
                        <li class="dropdown hidden-xs">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Om oss <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ URL::action('AboutController@index') }}">
                                        Om oss
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ URL::action('ContactController@create') }}">Kontakt</a>
                                </li>
                            </ul>
                        </li>
                        @if(Auth::check())
                            <li>
                                <a href="{{ URL::action('Auth\AuthController@getLogout') }}">Logga ut</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ URL::action('Auth\AuthController@getLogin') }}">Logga in</a>
                            </li>
                            <li>
                                <a href="{{ URL::action('RegisterController@index') }}">Registrera</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @if (isset($afApiError))
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="alert alert-custom alert-top">
                        <p>
                            <strong>Ajdå!</strong>
                            Just nu verkar vi har lite problem med vår sökfunktion. Prova igen om ett litet tag!
                        </p>
                        <div class="hidden">
                            <ul>
                                @foreach($afApiError as $key => $value)
                                    <li>{{ $key }} : {{ $value }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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