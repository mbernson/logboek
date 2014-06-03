@if(!$export->isNew())

{{ Form::open(['action' => ['ExportsController@destroy', $export->id], 'method' => 'delete']) }}

<button type="submit" class="btn btn-danger btn-sm pull-right">Verwijderen</button>

{{ Form::close() }}

@endif

