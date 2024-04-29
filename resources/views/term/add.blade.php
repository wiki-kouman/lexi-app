@include('header')

<section class="container boxed">
    <section class="jumbotron">
        <p class="lead">{{__('Create word')}}: <span class="badge badge-success">{{ $term }}</span></p>
        <p class="tou-description">{{__('This word does not contain any definition or examples yet. Please use the fields of the form below to create')}} <strong>{{$term}}</strong>.</p>
    </section>
    <section class="card spacious-card">
		@include('forms/add-form', ['operation' => '/wiki/add'])
    </section>

</section>
<link rel="stylesheet" href="/css/keyboard.css">
<script src="/js/keyboard.js"></script>
<script src="/js/repeatable.js"></script>
@include('footer')

