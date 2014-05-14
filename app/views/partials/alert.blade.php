@if(Session::has('message'))

<div class="row-fluid">
	<div class="alert alert-{{ Session::get('message.class', 'warning') }}">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		{{{ Session::get('message.content') }}}
	</div>
</div>

@endif

@if(isset($errors) && $errors instanceof Illuminate\Support\MessageBag)

@foreach($errors->all() as $message)

<div class="row-fluid">
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		{{{ ucfirst($message) }}}
	</div>
</div>

@endforeach

@endif
