@extends('layouts.app')

@section('content')
<div class="container">
	@if(empty($author))
	<form action="{{URL::to('author/store')}}" method="post">
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
	<form action="{{URL::to('author/update/'.$author['id'])}}" method="post">
		{{ csrf_field() }}
		<input type="text" name="name" placeholder="Enter Name" value="{{$author['name']}}">
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
