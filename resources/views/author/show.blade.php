@extends('layouts.app')

@section('content')
<div class="container">
	<a href="{{URL::to('author/create')}}" >Create New Author</a>
	All authors<br/>
	@foreach($authors as $author)
		{{ $author['name'] }} &nbsp; 
		<a href="{{ URL::to('author/edit/'.$author['id']) }}" >Edit </a>
		&nbsp;
		<a href="{{ URL::to('author/delete/'.$author['id']) }}" >Delete </a>
		<br/>

	@endforeach

</div>
@endsection
