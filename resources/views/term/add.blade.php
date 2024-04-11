@include('header')

<section class="container boxed">
    <section class="jumbotron">
        <p class="lead">{{__('Create word')}}: <span class="badge badge-light">{{ $term }}</span></p>
    </section>
    <section class="card spacious-card">
            @include('forms/add-form')
    </section>

</section>
<link rel="stylesheet" href="/css/keyboard.css">
<script src="/js/keyboard.js"></script>
<script src="/js/repeatable.js"></script>
@include('footer')

