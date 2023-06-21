@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <div class="list-group">
            <p class="lead">Word: <span class="badge badge-light">{{ $term['title'] }}</span></p>
        </div>
    </section>
    @foreach ($languages as $language)
        <h3>{{ $language['code'] }}</h3>
        @foreach ($language['types'] as $type)
            <p>{{ $type['code'] }}</p>
                @foreach ($type['definitions'] as $definition)
                    @foreach ($definition as $part)
                        <span>{{ $part }}</span><br/>
                    @endforeach
                @endforeach
            <br/>
        @endforeach
    @endforeach
</section>
@include('footer')
