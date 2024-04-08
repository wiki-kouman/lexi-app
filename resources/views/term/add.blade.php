@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <p class="lead">{{__('Create word')}}: <span class="badge badge-light">{{ $term }}</span></p>
    </section>
    <section class="card spacious-card">
            @include('sections/add-form')
    </section>

</section>
@include('footer')

