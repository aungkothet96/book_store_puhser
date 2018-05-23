@extends('layouts.app')

@section('content')
<div class="container" id="genre">
	All genres<br/>
	<a href="{{URL::to('genre/create')}}" >Create New Genre</a>
	All Genres<br/>
	<div v-for="genre in genres">
		@{{genre.name}} &nbsp;
		<a :href="'{{URL::to('/')}}/genre/edit/'+genre.id" >Edit </a>
       &nbsp;
       <a :href="'{{URL::to('/')}}/genre/delete/'+genre.id" >Delete </a>
       &nbsp;
       <br/>
		<br/>
	</div>

</div>
@endsection

@section('scripts')
	<script>
        const app = new Vue({
            el:'#genre',
            data:{
                genres : {}
            },
            methods: {
                getGenres(){
                    axios.get(app_url+`/api/genre/all`)
                        .then((response) =>{
                            this.genres = response.data;

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                listen(){
                    
                    Echo.channel('genre.refresh')
                    .listen('RefershGenre',()=>{
                        this.getGenres();
                    });
                }
            },
            mounted (){
              
                this.getGenres();
                this.listen();
            }
        })
	</script>
@endsection
