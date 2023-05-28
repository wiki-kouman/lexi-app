@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <div class="list-group">
            <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
                Found <span class="highlight">{{ count($results) }}</span> results
            </button>
            @foreach ($results as $result)
                <button type="button" class="list-group-item list-group-item-action">{{ $result->title }}</button>
            @endforeach
        </div>
    </section>
</section>
@include('footer')
