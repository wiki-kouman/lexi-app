@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <p class="lead">{{__('Preview changes')}} sur <span class="badge badge-light">{{ $term->label }}</span></p>
    </section>
    <section class="card spacious-card">
        <div class="actions form-group">
            <pre class="col-md-6 wiki-text-box">{{$wikiText}}</pre>
            <div class="col-md-6 html-text-box">{!! $htmlText !!}</div>
        </div>
        <div class="preview actions form-group">
            <a href="javascript:window.history.back()" class="btn btn-warning btn-sm btn-cancel"><i class="fa fa-times"></i> {{__('Cancel')}}</a>
            <form action="{{$operation}}" method="post" style="display: inline-block">
                @csrf <!-- {{ csrf_field() }} -->
                <input type="hidden" name="wikiText" value="{{$wikiText}}">
                <input type="hidden" name="term" value="{{$term->label}}">
                <button type="submit" class="btn btn-primary btn-sm btn-save"><i class="fa fa-check"></i> {{__('Confirm')}}</button>
            </form>

        </div>
    </section>
</section>
@include('footer')
