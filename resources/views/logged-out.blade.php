@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <h1 class="mt-5">{{ env('APP_NAME') }}</h1>
        <p class="lead">{{ __(env('APP_DESCRIPTION')) }}</p>
        <p class="lead">
            <a class="btn btn-success btn-lg btn-login md-opjjpmhoiojifppkkcdabiobhakljdgm_doc" href="{{ '/login' }}"
               role="button"><i class="fa fa-sign-in"></i> Login with Wikimedia</a>
        </p>
        <p class="tou-description">By logging in, you agree to the <a href="https://wikitech.wikimedia.org/wiki/Wikitech:Cloud_Services_Terms_of_use">Wikimedia Cloud Services Terms of Use</a></p>
        <br>
        <br>
    </section>
</section>
@include('footer')
