@section('css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
<link href="{{ asset('css/custom_style.css') }}" rel="stylesheet"> 
@endsection

@extends('layouts.app')

@section('content')
<div class="container" id="book">
	<div class="row align-items-center justify-content-center">
		<div class="col-md-6">
			<form method="post" action="{{ URL::to('/book/store') }}">
				{{ csrf_field() }}
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
				<div class="form-group">
					<label>Choose Author</label>
					<select class="form-control" name="" v-model="selectedA">
						<option disabled value="">Please select one</option>
						<option v-for="author in authors">@{{author.name}}</option>
					</select>
					
				</div>
				<div class="form-group">
					<label>Choose Genre</label>
					<select class="form-control" name="" v-model="selectedG">
						<option disabled value="">Please select one</option>
						<option v-for="genre in genres">@{{genre.name}}</option>
					</select>
				</div>
				<div class="form-group">
					<label>Choose Publisher</label>
					<select class="form-control" name="" v-model="selectedP">
						<option disabled value="">Please select one</option>
						<option v-for="publisher in publishers">@{{publisher.name}}</option>
					</select>
				</div>

				<div class="form-group files">
					<label>Upload Your Image </label>
					<input type="file" class="form-control" name="image" accept="image/*">
				</div>
				<div class="form-group files">
					<label>Upload Your Pdf </label>
					<input type="file" class="form-control" name="pdf" accept="Application/pdf">
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
