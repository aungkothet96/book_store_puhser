@extends('layouts.app')

@section('content')
<div class="container">
	<form action="{{URL::to('author/store')}}" method="post">
		 {{ csrf_field() }}
		<input type="text" name="name" placeholder="Enter Name">
		<input type="submit" value="Save">
	</form>

</div>
@endsection
