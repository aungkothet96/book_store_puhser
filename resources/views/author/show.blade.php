@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div id="author_app">
    <div class="row mt-2 mb-2 justify-content-center" >
        <div class="col-md-auto">
            @if(empty($author))
            <div class="form-inline row justify-content-center">
                <div class="form-group mb-2 ml-2">
                    <label for="staticEmail2" >Name</label>
                </div>
                <div class="form-group mx-sm-3 mb-2 ml-2">
                    <input type="text" v-model="name_box" placeholder="Enter Name" class="form-control ">
                    @if($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <button type="button" class="btn btn-primary mb-2 ml-2" @click.prevent="postAuthor">Save</button>
            </div>
            @else
            <form action="{{URL::to('admin/author/update/'.$author['id'])}}" class="form-inline row justify-content-center" method="post">
                {{ csrf_field() }}
                 <div class="form-group mb-2 ml-2">
                    <label for="staticEmail2" >Name</label>
                </div>
                <div class="form-group mx-sm-3 mb-2 ml-2">
                    <input type="text" name="name" placeholder="Enter Name" class="form-control" value="{{$author['name']}}">
                    @if($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <input type="submit" value="Save" class="btn btn-primary mb-2 ml-2">
            </form>
            @endif
        </div>
    </div>
    <div class="row mt-2 mb-2 justify-content-center">
        <div class="col-auto">
            <table class="table table-hover table-responsive">
                <thead>
                    <th>Name</th>
                    <th>Options</th>
                </thead>
                <tr v-for="author in authors">
                    <td> @{{author.name}}</td>
                    <td>
                        <a :href="'{{URL::to('/')}}/admin/author/edit/'+author.id" >Edit </a>
                         &nbsp;
                        <a :href="'{{URL::to('/')}}/admin/author/delete/'+author.id" >Delete </a>
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
        el:'#author_app',
        data:{
            authors : {},
            name_box :''
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
            postAuthor(){
                axios.post(app_url+`/api/author/store`, {

                  name: this.name_box ,

              })
                .then((response) =>{
                  this.authors.unshift(response.data);
                  this.name_box = '';
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
