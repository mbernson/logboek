@extends('layouts.application')

@section('content')

<h1>Bewijzen</h1>

<script>
$(function () {
	$('#myTab a:last').tab('show')
})
</script>

<ul class="nav nav-tabs" role="tablist" id="myTab">
	<li class="active"><a href="#evidence" role="tab" data-toggle="tab">Bewijzen <span class="badge">{{ $evidencesCount }}</span></a></li>
	<li><a href="#custody" role="tab" data-toggle="tab">Chain of Custody <span class="badge">{{ $custodyCount }}</span></a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="evidence">
		<p style="padding-top:10px;">
			<a class="btn btn-primary btn-lg" href="{{ action('evidences.create') }}">Nieuw bewijs</a>
		</p>

		@if($evidencesCount == 0)
			<p>Er zijn <b>geen</b> bewijzen gevonden!</p>
		@else

			<table class="table table-hover">
				<tr>
					<th>ID</th>
					<th>Titel</th>
					<th>Hash</th>
					<th>Datum verzending</th>
					<th>Verzender</th>
				</tr>

				 @foreach($evidences as $evidence)
				<tr>
					<td>{{ $evidence->id }}</td>
					<td>{{ link_to_action('evidences.show', $evidence->title, [$evidence->id]) }}</td>
					<td>{{ $evidence->hash }}</td>
					<td>{{ $evidence->date_received }}</td>
					<td>{{ $evidence->sender }}</td>
				</tr>
				@endforeach
			</table>

			@endif

		{{ $evidences->links() }}
	</div>
	<div class="tab-pane" id="custody">
		<p style="padding-top:10px;">
			<a class="btn btn-primary btn-lg" href="{{ action('custody.create') }}">Nieuw Chain of Custody</a>
		</p>

		@if($custodyCount == 0)
			<p>Er zijn <b>geen</b> Chain of Evidences gevonden!</p>
		@else

			<table class="table table-hover">
				<tr>
					<th>ID</th>
					<th>Naam</th>
					<th>Beheer</th>
				</tr>

				 @foreach($custody as $key)
				<tr>
					<td>{{ $key->id }}</td>
					<td>{{ link_to_action('custody.edit', $key->name, [$key->id]) }}</td>
					<td>
						{{ link_to_action('custody.show', 'Beheren', [$key->id], ['class' => 'btn btn-xs btn-success']) }}
					</td>
				</tr>
				@endforeach
			</table>

			@endif

		{{ $custody->links() }}

	</div>
</div>

@stop
