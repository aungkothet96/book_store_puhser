@extends('layouts.app')

@section('content')
<div class="container" id="author_app">
	<a href="{{URL::to('author/create')}}" >Create New Author</a>
	All authors<br/>
	<div v-for="author in authors">
		@{{author.name}} &nbsp;
		<a :href="'{{URL::to('/')}}/author/edit/'+author.id" >Edit </a>
       &nbsp;
       <a :href="'{{URL::to('/')}}/author/delete/'+author.id" >Delete </a>
       &nbsp;
       <br/>
		<br/>
	</div>
</div>
@endsection
@section('scripts')
	<script>
        const app = new Vue({
            el:'#author_app',
            data:{
                authors : {}
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
                listen(){
                    
                    Echo.channel('author.new')
                        .listen('NewAuthor',(author)=>{
                            this.authors.unshift(author);
                        });
                    Echo.channel('author.edit')
                    .listen('EditAuthor',()=>{
                        this.getAuthors();
                    });
                }
            },
            mounted (){
              
                this.getAuthors();
                this.listen();
            }
        })
	</script>
@endsection
