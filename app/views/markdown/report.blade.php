# {{ $title }}

## Project forensisch onderzoek

@foreach($users as $user)
{{{ $user->username || 'Niemand' }}}
@endforeach

{{ $logbooks->first()->title }}
