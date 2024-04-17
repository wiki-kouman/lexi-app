@include('header')
<section class="container boxed">
    <section class="jumbotron alert-warning" role="alert">
        <h4 class="alert-heading">{{__('Error')}}!</h4>
        <hr>
        <p>{{__($message)}}</p>
    </section>
    <div class="input-group">
        <a href="javascript:history.back()" class="btn btn-primary btn btn-cancel"><i class="fa fa-chevron-left"></i> {{__('Back')}}</a>
    </div>
    <br>
</section>
@include('footer')
