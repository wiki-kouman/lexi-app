@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <div class="list-group">
            <h5>{{__('Well done')}}! <span class="badge badge-success">{{__($message)}}</span></h5>
        </div>
    </section>
    <div class="input-group gap-10">
        <a href="{{ $newURL }}" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-globe"></i> {{__('See changes')}}</a>
        <a href="{{ url('/') }}" class="btn btn-sm btn-secondary btn btn-cancel"><i class="fa fa-pencil"></i> {{__('Start a new edit')}}</a>
    </div>
    <br>
</section>
@include('footer')


