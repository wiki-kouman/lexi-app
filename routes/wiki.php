<?php

use App\OAuthClient\Token;
use Illuminate\Support\Facades\Route;


Route::get('/wiki/add', function () {
    session_start();
    $requestToken = new Token( $_SESSION['request_key'], $_SESSION['request_secret'] );
    print_r($_GET);
});
