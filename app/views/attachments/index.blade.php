@extends('layouts.application')

@section('content')

<h1>Bestanden</h1>

<script>
$(function () {
	$('#myTab a:last').tab('show')
})
</script>

<ul class="nav nav-tabs" role="tablist" id="myTab">
	<li class="active"><a href="#attachments" role="tab" data-toggle="tab">Bestanden <span class="badge">{{ $attachmentsCount }}</span></a></li>
	<li><a href="#upload" role="tab" data-toggle="tab">Upload</a></li>
	<li><a href="#uploads" role="tab" data-toggle="tab">Uploads <span class="badge">{{ $uploadsCount }}</span></a></li>
	<li><a href="#alluploads" role="tab" data-toggle="tab">Alle uploads <span class="badge">{{ $alluploadsCount }}</span></a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="attachments">
		<p style="padding-top:10px;">
			<a class="btn btn-primary btn-lg" href="{{ action('attachments.create') }}">Nieuw bestand</a>
		</p>

			@if($attachments->count() == 0)
				<p>Er zijn <b>geen</b> bestanden gevonden!</p>
			@else

			<table class="table table-hover">
				<tr>
					<th>ID</th>
					<th>Naam</th>
					<th>Eigenaar</th>
					<th>Grootte</th>
					<th>Geupload op</th>
				</tr>

				@foreach($attachments as $attachment)
				<tr>
					<td>{{ $attachment->id }}</td>
					<td>{{ link_to_action('attachments.show', empty($attachment->title) ? $attachment->filename : $attachment->title, [$attachment->id]) }}</td>
					<td>{{ link_to_action('users.show', $attachment->user->username, [$attachment->user->id]) }}</td>
					<td>{{ format_bytes($attachment->filesize) }}</td>
					<td>{{ $attachment->created_at }}</td>
				</tr>
				@endforeach

			</table>

			{{ $attachments->links() }}

			@endif
	</div>
	<div class="tab-pane" id="upload">
		<p style="padding-top:10px;">
			<form class="dropzone dz-clickable" method="POST" action="/attachment/upload">
				<div class="dz-message">
					<h4>Sleep bestanden om te uploaden</h4>
					<span>Of klik om te selecteren</span>
				</div>
			</form>
		</p>
	</div>
	<div class="tab-pane" id="uploads">
		<p style="padding-top:10px;">
			@if($uploads->count() != 0)

			<table class="table table-hover">
				<tr>
					<th>Naam</th>
					<th>Eigenaar</th>
					<th>Link</th>
				</tr>

					@foreach($uploads as $upload)
						<tr id="popuploads" data-md5="{{ $upload->md5 }}" data-sha1="{{ $upload->sha1 }}">
							<td>{{ $upload->name }}</td>
							<td>{{ $upload->owner }}</td>
							<td><?php echo '<a href="'.Attachment::getUploadUrl($upload->name).'" target="_NEW">'.Attachment::getUploadUrl($upload->name).'</a>'; ?></td>
						</tr>
					@endforeach
			</table>

			{{ $uploads->links() }}

			@else
				<p>Er zijn <b>geen</b> uploads van de gebruiker <b>{{ Auth::user()->username }}</b> gevonden!</p>
			@endif
		</p>
	</div>
	<div class="tab-pane" id="alluploads">
		<p style="padding-top:10px;">

			@if($alluploads->count() != 0)
			<table class="table table-hover">
				<tr>
					<th>Naam</th>
					<th>Eigenaar</th>
					<th>Link</th>
				</tr>

				@foreach($alluploads as $allupload)
				<tr>
					<td>{{ $allupload->name }}</td>
					<td>{{ $allupload->owner }}</td>
					<td><?php echo '<a href="'.Attachment::getUploadUrl($allupload->name).'" target="_NEW">'.Attachment::getUploadUrl($allupload->name).'</a>'; ?></td>
				</tr>
				@endforeach
			</table>

			{{ $alluploads->links() }}

			@else
				<p>Er zijn <b>geen</b> uploads gevonden!</p>
			@endif
		</p>
	</div>
</div>

@stop
