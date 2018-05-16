@extends('layouts.app')

@section('content')
<div class="container">
	All authors
	@foreach($authors as $author)
		{{ $author['name'] }}<br/>
	@endforeach

</div>
@endsection
