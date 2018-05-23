@section('css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
<link href="{{ asset('css/custom_style.css') }}" rel="stylesheet"> 
@endsection

@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">
		<form method="post" action="#" id="#">

			<div class="form-group">
				<label>Name</label>
				<input type="text" name="name" placeholder="Enter Book Name" class="form-control">
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea name="description" class="form-control" wrap="true"></textarea>
			</div>
			<div class="form-group">
				<label>Price</label>
				<input type="text" name="price" placeholder="Enter Book Price" class="form-control">
			</div>
			<div class="form-group">
				<label>Published Date</label>
				<input type="date" name="date" placeholder="Enter Book Name" class="form-control">
			</div>

			<div class="form-group files">
				<label>Upload Your Image </label>
				<input type="file" class="form-control" name="image" accept="images/*">
			</div>
			<div class="form-group files">
				<label>Upload Your Pdf </label>
				<input type="file" class="form-control" name="pdf" accept="Application/pdf">
			</div>


		</form>


	</div>
</div>
@endsection
