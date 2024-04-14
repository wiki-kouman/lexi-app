@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <div class="list-group">
            <p class="lead">Word: <span class="badge badge-light">{{ $term }}</span></p>
        </div>
    </section>
    @foreach (array_keys($langCategories) as $language)
        <h2 class="text-success">{{ $language }}</h2>
        @foreach ($langCategories[$language] as $category)
            <strong>{{ $category }}</strong>
                @foreach ($definitions[$language.$category] as $definition)
                    <p>{{ $definition->label }}</p>
                    @foreach ($definition->examples as $example)
                        <span class="badge badge-primary">Example </span>
                        <span>{{ $example }}</span><br/>
                    @endforeach
                @endforeach
            <br/>
        @endforeach
    @endforeach
</section>
@include('footer')
