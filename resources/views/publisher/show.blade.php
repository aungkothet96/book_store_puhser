@extends('layouts.app')

@section('content')
<div class="container" id="publisher">
	<a href="{{URL::to('publisher/create')}}" >Create New Genre</a>
	All Publishers<br/>
	<div v-for="publisher in publishers">
		@{{publisher.name}} &nbsp;
		<a :href="'{{URL::to('/')}}/publisher/edit/'+publisher.id" >Edit </a>
       &nbsp;
       <a :href="'{{URL::to('/')}}/publisher/delete/'+publisher.id" >Delete </a>
       &nbsp;
       <br/>
		<br/>
	</div>

</div>
@endsection

@section('scripts')
	<script>
        const app = new Vue({
            el:'#publisher',
            data:{
                publishers : {}
            },
            methods: {
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
                    
                    Echo.channel('publisher.refresh')
                    .listen('RefershPublisher',()=>{
                        this.getPublishers();
                    });
                }
            },
            mounted (){
              
                this.getPublishers();
                this.listen();
            }
        })
	</script>
@endsection
