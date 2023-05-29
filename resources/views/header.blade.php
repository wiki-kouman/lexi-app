@inject('oauth', 'App\Services\OAuthService')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }} | {{ env('APP_DESCRIPTION') }}</title>

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
            @if ($oauth::isLoggedIn())
                <a class="nav-item nav-link" href="/logout"><i class="fa fa-sign-out"></i> Logout</a>
            @endif
        </div>

    </div>
</nav>
<br>
