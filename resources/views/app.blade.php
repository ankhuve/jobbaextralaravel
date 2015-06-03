<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" minimal-ui>
        <meta name="description" content="Utvecklingssite för Jobbaextra.com" />
        <meta name="keywords" content="extrajobb, sommarjobb, jobb, extra" />

        <title>Under utveckling</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="css/style.css"/>
        <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,700|Raleway:400' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <nav>
            <a class="headerLogo" href="/"><img src="img/jobbaextra_logo.png"/></a>
            <img id="hamburgerIcon" src="img/thin_burger.png" ng-click="toggleMenu()">
            <div class="navLinks">
                <ul class="nav">
                    <li>
                        <a href="/">Start</a>
                    </li>
                    <li>
                        <a href="#">Leta jobb</a>
                    </li>
                    <li>
                        <a href="#">Leta arbetskraft</a>
                    </li>
                    <li>
                        <a href="#">Logga in</a>
                    </li>
                    <li>
                        <a href="about">Om oss</a>
                    </li>
                </ul>
            </div>

        </nav>

        @yield('content')

    </body>
</html>