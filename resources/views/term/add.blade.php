@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <p class="lead">Create word: <span class="badge badge-light">{{ $term['title'] }}</span></p>
        @include('sections/add-form')
    </section>
</section>
@include('footer')
