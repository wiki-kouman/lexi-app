@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <p class="lead">{{__('Preview changes')}} sur <span class="badge badge-light">{{ $label }}</span></p>
    </section>
    <section class="card spacious-card">
        <div class="actions form-group">
            <pre>{{$wikiText}}</pre>
        </div>
        <div class="actions form-group">
            <a href="javascript:history.back()" class="btn btn-warning btn-sm btn-cancel"><i class="fa fa-times"></i> {{__('Cancel')}}</a>
            <form action="/wiki/create" method="post" style="display: inline-block">
                @csrf <!-- {{ csrf_field() }} -->
                <input type="hidden" name="wikiText" value="{{$wikiText}}">
                <button type="submit" class="btn btn-primary btn-sm btn-save"><i class="fa fa-check"></i> {{__('Confirm')}}</button>
            </form>

        </div>
    </section>
</section>
@include('footer')
