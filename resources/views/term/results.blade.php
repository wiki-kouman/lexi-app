@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <div class="list-group">
            <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
                Found <strong>{{ count($results) }}</strong> results
            </button>
            @foreach ($results as $result)
                <a href="{{ url('/wiki/view', $result->pageid) }}" class="list-group-item list-group-item-action">{{ $result->title }}</a>
            @endforeach
        </div>
    </section>
</section>
@include('footer')
