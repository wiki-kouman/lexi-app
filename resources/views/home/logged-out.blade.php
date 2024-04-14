@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <h1 class="mt-5">{{__('Welcome to')}} <span class="highlight">{{ config('app.APP_NAME') }}!</span></h1>
        <p class="lead">{{ __(config('app.APP_DESCRIPTION')) }}</p>
        <p class="lead">
            <a class="btn btn-success btn-lg btn-login md-opjjpmhoiojifppkkcdabiobhakljdgm_doc" href="{{ '/login' }}"
               role="button"><i class="fa fa-sign-in"></i> {{__('Login')}}</a>
        </p>
        <p class="tou-description">{{__('By logging in, you agree to the')}} <a href="https://wikitech.wikimedia.org/wiki/Wikitech:Cloud_Services_Terms_of_use">{{__('Wikimedia Cloud Services Terms of Use')}}.</a></p>
        <br>
        <br>
    </section>
</section>
@include('footer')
