@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <h1>Akwaba, <span class="highlight">{{ $user->name }}</span>.</h1>
        <p class="lead">{{ __( env('APP_DESCRIPTION') ) }}</p>
        @include('forms/search-form')
    </section>
</section>
@include('footer')
