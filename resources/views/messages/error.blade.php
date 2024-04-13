@include('header')
<section class="container boxed">
    <section class="jumbotron">
        <div class="list-group">
            <h5>{{__('Error')}}! <span class="badge badge-warning">{{__($message)}}</span></h5>
        </div>
    </section>
    <div class="input-group">
        <a href="javascript:history.go(-2,)" class="btn btn-primary btn btn-cancel"><i class="fa fa-chevron-left"></i> {{__('Back')}}</a>
    </div>
    <br>
</section>
@include('footer')
