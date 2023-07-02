@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <div class="list-group">
            <p class="lead">Word: <span class="badge badge-light">{{ $term['title'] }}</span></p>
        </div>
    </section>
    @foreach ($groups as $categories)
        <h2 class="text-success">{{ $categories[0]->language->code }}</h2>
        @foreach ($categories as $category)
            <strong>{{ $category->code }}</strong>
                @foreach ($category->definitions as $definition)
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
