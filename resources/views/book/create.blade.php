@section('css')
<link href="{{ asset('css/custom_style.css') }}" rel="stylesheet"> 
@endsection

@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('book-create') }}
<div id="book">
	<div class="row align-items-center justify-content-center ">
		<div class="col-md-6 card mt-2 mb-2">
			<form method="post" action="{{ URL::to('admin/book/store') }}" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="form-group">
					<label>Name</label>
					<input type="text" name="name" placeholder="Enter Book Name" class="form-control">
				    @if($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
				
				<div class="form-group">
					<label>Description</label>
					<textarea name="description" class="form-control" wrap="true"></textarea>
                    @if($errors->has('description'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
				</div>
				<div class="form-group">
					<label>Price</label>
					<input type="text" name="price" placeholder="Enter Book Price" class="form-control">
                    @if($errors->has('price'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
                @endif
				</div>
				<div class="form-group">
					<label>Published Date</label>
					<input type="date" name="date" placeholder="Enter Book Name" class="form-control">
                    @if($errors->has('date'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('date') }}</strong>
                </span>
                @endif
				</div>
				<div class="form-group">
					<label>Choose Author</label>
					<select class="form-control" name="author" v-model="selectedA">
						<option disabled value="">Please select one</option>
						<option v-for="author in authors" v-bind:value="author.id">@{{author.name}}</option>
					</select>
                    @if($errors->has('author'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('author') }}</strong>
                </span>
                @endif
					
				</div>
				<div class="form-group">
					<label>Choose Genre</label>
					<select class="form-control" name="genre" v-model="selectedG">
						<option disabled value="">Please select one</option>
						<option v-for="genre in genres"  v-bind:value="genre.id">@{{genre.name}}</option>
					</select>
                    @if($errors->has('genre'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('genre') }}</strong>
                </span>
                @endif
				</div>
				<div class="form-group">
					<label>Choose Publisher</label>
					<select class="form-control" name="publisher" v-model="selectedP">
						<option disabled value="">Please select one</option>
						<option v-for="publisher in publishers"  v-bind:value="publisher.id">@{{publisher.name}}</option>
					</select>
                    @if($errors->has('publisher'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('publisher') }}</strong>
                </span>
                @endif
				</div>

				<div class="form-group files">
					<label>Upload Your Image </label>
					<input type="file" class="form-control" name="image" accept="image/*">
                    @if($errors->has('image'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('image') }}</strong>
                </span>
                @endif
				</div>
                
				<div class="form-group files">
					<label>Upload Your Pdf </label>
					<input type="file" class="form-control" name="pdf" accept="Application/pdf">
                    @if($errors->has('pdf'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('pdf') }}</strong>
                </span>
                @endif
				</div>

				<div class="form-group">
					<input type="reset" value="Cancel" class="col-md-3 offset-3 btn">
					<input type="submit" value="Save" class="col-md-3 btn">
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('scripts')
	<script>
        const app = new Vue({
            el:'#book',
            data:{
                authors : {!! $authors !!},
                genres :{!! $genres !!},
                publishers : {!! $publishers !!},
                 selectedA: '',
                 selectedG: '',
                 selectedP: ''
            },
            methods: {
                getAuthors(){
                    axios.get(app_url+`/api/author/all`)
                        .then((response) =>{
                            this.authors = response.data;

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                 getGenres(){
                    axios.get(app_url+`/api/genre/all`)
                        .then((response) =>{
                            this.genres = response.data;

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                 getPublishers(){
                    axios.get(app_url+`/api/publisher/all`)
                        .then((response) =>{
                            this.publishers = response.data;

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                listen(){
                    
                    Echo.channel('author.new')
                        .listen('NewAuthor',(author)=>{
                            this.authors.unshift(author);
                        });
                    Echo.channel('author.edit')
                    .listen('EditAuthor',()=>{
                        this.getAuthors();
                    });
                    Echo.channel('genre.refresh')
                    .listen('RefershGenre',()=>{
                        this.getGenres();
                    });
                    Echo.channel('publisher.refresh')
                    .listen('RefershPublisher',()=>{
                        this.getPublishers();
                    });
                }
            },
            mounted (){
                this.listen();
            }
        })
	</script>
@endsection
