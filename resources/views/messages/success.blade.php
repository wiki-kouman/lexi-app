@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <div class="list-group">
            <h5>{{__('Success')}}! <span class="badge badge-success">{{__($message)}}</span></h5>
        </div>
    </section>
    <div class="input-group">
        <a href="{{ url('/') }}" class="btn btn-primary btn btn-cancel"><i class="fa fa-chevron-left"></i> {{__('Home')}}</a>
    </div>
    <br>
</section>
@include('footer')


