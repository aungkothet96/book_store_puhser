@extends('layouts.app')

@section('content')
<div class="container">
	@if(empty($genre))
	<form action="{{URL::to('genre/store')}}" method="post">
		{{ csrf_field() }}
		<input type="text" name="name" placeholder="Enter Name">
		@if($errors->has('name'))
			<span class="invalid-feedback">
	            <strong>{{ $errors->first('name') }}</strong>
	        </span>
		@endif
		<input type="submit" value="Save">
	</form>
	@else
	<form action="{{URL::to('genre/update/'.$genre['id'])}}" method="post">
		{{ csrf_field() }}
		<input type="text" name="name" placeholder="Enter Name" value="{{$genre['name']}}">
		@if($errors->has('name'))
			<span class="invalid-feedback">
	            <strong>{{ $errors->first('name') }}</strong>
	        </span>
		@endif
		<input type="submit" value="Save">
	</form>
	@endif

</div>
@endsection
