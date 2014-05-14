@if($message = Session::get('message'))

<div class="row-fluid">
	<div class="alert alert-{{ Session::get('message.class', 'warning') }}">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	{{{ Session::get('message.content') }}}
	</div>
</div>

@endif

@if(isset($errors) && !empty($errors))

@foreach($errors as $err)

<div class="row-fluid">
	<div class="alert alert-danger">
		{{{ $err }}}
	</div>
</div>

@endforeach

@endif
