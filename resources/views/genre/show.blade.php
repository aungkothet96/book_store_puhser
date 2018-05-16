@extends('layouts.app')

@section('content')
<div class="container">
	All genres<br/>
	@foreach($genres as $genre)
		{{ $genre['name'] }} &nbsp; <a href="{{ URL::to('genre/edit/'.$genre['id']) }}" >Edit </a><br/>

	@endforeach

</div>
@endsection
