<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" minimal-ui>
        <meta name="description" content="@yield('meta-description', 'Jobbrek.se | Lediga jobb inom skola, sjukvård, IT, m.m.')" />
        <meta name="keywords" content="Lediga jobb, jobb, skola, sjukvård, IT, jobbrek, extrajobb, deltidsjobb, jobba extra" />

        <!-- CSRF Token -->
        <meta name="_token" content="{!! csrf_token() !!}"/>

        <meta property="fb:app_id" content="{{ env('FACEBOOK_APP_ID') }}" />
        <meta property="og:title" content="@yield('og-title', 'Jobbrek.se | Lediga jobb inom skola, sjukvård, IT, m.m.')" />
        <meta property="og:description" content="@yield('og-description', 'Här kan du söka bland tusentals jobb! Oavsett om du är nyutexaminerad eller helt enkelt vill vidare i karriären kan vi hjälpa dig att hitta rätt. Vi jobbar rikstäckande och hjälper allt i från enskilda firmor till stora koncerner, kommuner och myndigheter med att hitta rätt personal. ')" />

        {{--Använd om man vill ha företagets logga för annons (kan bli konstiga proportioner)--}}
        <meta property="og:image" content="@yield('og-image', asset('images/jobbrek-og.png'))" />
        {{--<meta property="og:image" content={{ asset('images/jobbrek-og.png') }} />--}}

        <meta property="og:url" content={{ URL::current() }} />

        <title>@yield('title', env('APP_NAME', 'Jobbrek | Lediga jobb i Sverige och Norge'))</title>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('images/favicons/apple-touch-icon-57x57.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/favicons/apple-touch-icon-114x114.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/favicons/apple-touch-icon-72x72.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/favicons/apple-touch-icon-144x144.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{ asset('images/favicons/apple-touch-icon-60x60.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('images/favicons/apple-touch-icon-120x120.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ asset('images/favicons/apple-touch-icon-76x76.png') }}" />
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('images/favicons/apple-touch-icon-152x152.png') }}" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-196x196.png') }}" sizes="196x196" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-96x96.png') }}" sizes="96x96" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-32x32.png') }}" sizes="32x32" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-16x16.png') }}" sizes="16x16" />
        <link rel="icon" type="image/png" href="{{ asset('images/favicons/favicon-128.png') }}" sizes="128x128" />
        <meta name="application-name" content="{{ env('APP_NAME', 'Jobbrek.se') }}"/>
        <meta name="msapplication-TileColor" content="#FFFFFF" />
        <meta name="msapplication-TileImage" content="{{ asset('images/favicons/mstile-144x144.png') }}" />
        <meta name="msapplication-square70x70logo" content="{{ asset('images/favicons/mstile-70x70.png') }}" />
        <meta name="msapplication-square150x150logo" content="{{ asset('images/favicons/mstile-150x150.png') }}" />
        <meta name="msapplication-wide310x150logo" content="{{ asset('images/favicons/stile-310x150.png') }}" />
        <meta name="msapplication-square310x310logo" content="{{ asset('images/favicons/stile-310x310.png') }}" />


        <link rel="stylesheet" href="/css/app.css"/>
        <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,700|Raleway:400' rel='stylesheet' type='text/css'>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-83188287-1', 'auto');
            ga('send', 'pageview');

        </script>

        @yield('scripts')
    </head>
    <body>

        <header class="container-fluid">
            <a href="{{ action('HomeController@index') }}">
                <div class="navbar-brand">
                    <img src="{{ asset('images/jobbrek.png') }}"/>
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
                            {{--<li>--}}
                                {{--<a href="{{ URL::action('Auth\AuthController@getLogin') }}">Logga in</a>--}}
                            {{--</li>--}}
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
                            Just nu verkar vi ha lite problem med vår sökfunktion. Prova igen om ett litet tag!
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

        @if(Session::has('message'))
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-xs-12 m-t-2">
                    <div class="alert alert-success">
                        {!! Session::get('message') !!}
                    </div>
                </div>
            </div>
        @endif

        <div class="view" id="app">
            @yield('content')
        </div>

        @include('pages.partials.footer')
    </body>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</html>