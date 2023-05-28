<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://tools-static.wmflabs.org/cdnjs/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://tools-static.wmflabs.org/cdnjs/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Styles -->
    </head>
    <body class="antialiased">
    <!-- navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse container boxed" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="/"><i class="fa fa-home"></i> Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="/about"><i class="fa fa-cube"></i> About</a>
            </div>

        </div>
    </nav>
    <br>
    <section class="container boxed">
        <section class="jumbotron">
            <h1 class="mt-5">{{ env('APP_NAME') }}</h1>
            <p class="lead">{{ env('APP_DESCRIPTION') }}</p>
            <p class="lead">
                <a class="btn btn-success btn-lg btn-login md-opjjpmhoiojifppkkcdabiobhakljdgm_doc" href="{{ $oauthUrl }}"
                   role="button"><i class="fa fa-sign-in"></i> Login with Wikimedia</a>
            </p>
            <p class="tou-description">By logging in, you agree to the <a href="https://wikitech.wikimedia.org/wiki/Wikitech:Cloud_Services_Terms_of_use">Wikimedia Cloud Services Terms of Use</a></p>
            <br>
            <br>
        </section>

        <div id="footer">
            <div class="container boxed">
                <div class="row">
                    <div class="">
                        <a href="https://wikitech.wikimedia.org/wiki/Wikitech:Cloud_Services_Terms_of_use">Terms of Use</a> | Source code is available <a href="https://github.com/samuelguebo/light-message">on Github </a>.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
