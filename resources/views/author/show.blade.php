@extends('layouts.app')

@section('content')
<div class="container" id="author_app">
	<a href="{{URL::to('author/create')}}" >Create New Author</a>
	All authors<br/>
	{{--@foreach($authors as $author)--}}
		{{--{{ $author['name'] }} &nbsp;--}}
		{{--<a href="{{ URL::to('author/edit/'.$author['id']) }}" >Edit </a>--}}
		{{--&nbsp;--}}
		{{--<a href="{{ URL::to('author/delete/'.$author['id']) }}" >Delete </a>--}}
		{{--<br/>--}}

	{{--@endforeach--}}
	<div v-for="author in authors">
		@{{author.name}} &nbsp;
		<a href="`author/edit/@{{author.id}}`" >Edit </a>
		&nbsp;
		<a href="`author/delete/@{{author.id}}`" >Delete </a>
		<br/>
	</div>

</div>
@endsection
@section('scripts')
	<script>
        console.log({!! $authors->toJson() !!});
		const app_url = "{{URL::to('/')}}";
		console.log(app_url);
        const app = new Vue({
            el:'#app',
            data:{
                authors : {}
            },
            methods: {
                getAuthors(){
                    axios.get(`${this.app_url}/api/author/all`)
                        .then((response) =>{
                            console.log(response.data);
                            this.authors = response.data;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                listen(){
                    Echo.channel('author.all')
                        .listen('NewAuthor',(author)=>{
                            this.authors.unshift(author);
                        });
                }
            },
            mounted (){
                console.log("mounted");
                this.getAuthors();
                this.listen();
            }
        })

	</script>
@endsection
