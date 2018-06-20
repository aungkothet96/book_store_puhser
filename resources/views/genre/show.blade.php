@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div id="genre_app">
    <div class="row mt-2 mb-2 justify-content-md-center" >
        <div class="col-md-auto">
            @if(empty($genre))
            <div class="form-inline">
                <div class="form-group mb-2">
                    <label for="staticEmail2" >Name</label>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" v-model="name_box" placeholder="Enter Name" class="form-control ">
                    @if($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <button type="button" class="btn btn-primary mb-2" @click.prevent="postGenre">Save</button>
            </div>
            @else
            <form action="{{URL::to('admin/genre/update/'.$genre['id'])}}" class="form-inline" method="post">
                {{ csrf_field() }}
                 <div class="form-group mb-2">
                    <label for="staticEmail2" >Name</label>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="name" placeholder="Enter Name" class="form-control" value="{{$genre['name']}}">
                    @if($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <input type="submit" value="Save" class="btn btn-primary mb-2">
            </form>
            @endif
        </div>
    </div>
    <div class="row mt-2 mb-2 justify-content-md-center">
        <div class="col-auto">
            <table class="table table-hover table-responsive">
                <thead>
                    <th>Name</th>
                    <th>Options</th>
                </thead>
                <tr v-for="genre in genres">
                    <td> @{{genre.name}}</td>
                    <td>
                        <a :href="'{{URL::to('/')}}/admin/genre/edit/'+genre.id" >Edit </a>
                         &nbsp;
                        <a :href="'{{URL::to('/')}}/admin/genre/delete/'+genre.id" >Delete </a>
                    </td>
                </tr>
            </table>
        </div>  
    </div>
</div>
@endsection

@section('scripts')
<script>
    const app = new Vue({
        el:'#genre_app',
        data:{
            genres : {},
            name_box:''
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
            postGenre(){
                axios.post(app_url+`/api/genre/store`, {

                  name: this.name_box ,

              })
                .then((response) =>{
                  this.genres.unshift(response.data);
                  this.name_box = '';
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
