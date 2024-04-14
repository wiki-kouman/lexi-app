@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <p class="lead">{{__('Improve word')}}: <span class="badge badge-light">{{ $term }}</span></p>
        <a href="{{ $pageURL }}" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-globe"></i> {{__('View page on Wikitionary')}}</a>
        <p class="tou-description">{{__('Please use the fields of the form below to add new definition and some examples for improving')}} <strong>{{$term}}</strong>.</p>
    </section>

    <section class="card spacious-card">
        @include('forms/update-form')
    </section>

</section>
<link rel="stylesheet" href="/css/keyboard.css">
<script src="/js/keyboard.js"></script>
<script src="/js/repeatable.js"></script>
@include('footer')

