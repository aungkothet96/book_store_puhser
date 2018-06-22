@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="row mt-2 mb-2 justify-content-md-center" id="book">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title"> @{{ book.name }}</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="mr-md-3  ml-2 mb-3 col-sm-12 col-lg-auto col-md-3" style="width: 14rem;" >
					<img class="card-img" :src="`{{ URL::to('') }}/`+ book.image_name" alt="Card image cap">
				</div>
				<div class="card-body col-sm-12 col-md-8">
					<table class="table table-hover">
						<tr>
							<th>Category</th>
							<td>: <a  :href="'{{URL::to('/')}}/genre/'+book.genres.name.split(' ').join('_').toLowerCase()" target="_blank"> @{{ book.genres.name}} </a> </td>
						</tr>
						<tr>
							<th>Author Name</th>
							<td>:  <a  :href="'{{URL::to('/')}}/author/'+book.authors.name.split(' ').join('_').toLowerCase()" target="_blank">  @{{ book.authors.name}} </a></td>
						</tr>
						<tr>
							<th>Price</th>
							<td>: $@{{ book.price}} </td>
						</tr>
						<tr>
							<th>Description</th>
							<td>: <p>@{{ book.description}}</p> </td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="card-footer d-flex justify-content-center">
			@if(Auth::user())
			<form :action="`{{URL::to('book/download')}}/`+book.id" method="POST">
				{{ csrf_field() }}
				<input type="submit" value="Download Now" class="btn btn-primary">
			</form>	
			@else
			<div>
			<h5> You need sign in to <button class="btn btn-warning" disabled>Download</button></h5>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection
@section('scripts')
	<script>
        const app = new Vue({
            el:'#book',
            data:{
               book : {!! $book !!},
              
            },
            methods: {
                getBook(){
                    axios.get(app_url+`/api/book/`+this.book.id)
                        .then((response) =>{
                            this.book = response.data;

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                listen(){
                 
                }
            },
            mounted (){
                this.listen();
            }
        })
	</script>
@endsection