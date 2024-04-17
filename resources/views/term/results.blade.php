@include('header')
<section class="container boxed">
    <div class="list-group">
        <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
            {{__('Results found')}}
        </button>
        @foreach ($results as $result)
            <a href="{{ url('/wiki/update', $result->pageid) }}" class="list-group-item list-group-item-action">{{ $result->title }}</a>
        @endforeach
        @if(!$isExistent)
            <a href="{{ url('/wiki/add', $term) }}" class="list-group-item list-group-item-action red-link">{{ $term }} ({{__('missing')}})</a>
        @endif
    </div>
    <br>
    <div class="input-group">
        <a href="javascript:history.back()" class="btn btn-warning btn btn-cancel"><i class="fa fa-chevron-left"></i> {{__('Back')}}</a>
    </div>
</section>
@include('footer')
