@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div id="publisher_app">
    <div class="row mt-2 mb-2 justify-content-md-center" >
        <div class="col-md-auto">
            @if(empty($publisher))
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
                <button type="button" class="btn btn-primary mb-2" @click.prevent="postpublisher">Save</button>
            </div>
            @else
            <form action="{{URL::to('admin/publisher/update/'.$publisher['id'])}}" class="form-inline" method="post">
                {{ csrf_field() }}
                 <div class="form-group mb-2">
                    <label for="staticEmail2" >Name</label>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="name" placeholder="Enter Name" class="form-control" value="{{$publisher['name']}}">
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
                <tr v-for="publisher in publishers">
                    <td> @{{publisher.name}}</td>
                    <td>
                        <a :href="'{{URL::to('/')}}/admin/publisher/edit/'+publisher.id" >Edit </a>
                         &nbsp;
                        <a :href="'{{URL::to('/')}}/admin/publisher/delete/'+publisher.id" >Delete </a>
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
        el:'#publisher_app',
        data:{
            publishers : {},
            name_box:''
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
            postPublisher(){
                axios.post(app_url+`/api/publisher/store`, {

                  name: this.name_box ,

              })
                .then((response) =>{
                  this.publishers.unshift(response.data);
                  this.name_box = '';
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
