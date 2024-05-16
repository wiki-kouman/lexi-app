@include('header')
<section class="container boxed">
	<section class="jumbotron" role="alert">
		<h4 class="alert-heading">{{__($heading)}}</h4>
		<hr>
		<p>{{__($message)}}</p>
		<div class="form-group">
			<a href="{{ url('/') }}" class="btn btn-warning btn-sm btn-cancel"><i class="fa fa-times"></i> {{__('Cancel')}}</a>
			<form action="{{$operation}}" method="post" style="display: inline-block">
				@csrf <!-- {{ csrf_field() }} -->
				<button type="submit" class="btn btn-primary btn-sm btn-save"><i class="fa fa-check"></i> {{__('Confirm')}}</button>
			</form>

		</div>
	</section>
</section>
@include('footer')
