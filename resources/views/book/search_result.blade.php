@extends('layouts.app')
@section('css')

@endsection

@section('content')
<div class="row" id="home">
    <!-- left side bar -->
    <div class="col-md-3">
        <div class="row">
            <div class="list-group col mt-2 ml-3">
                <a class="list-group-item list-group-item-action active">
                    Top Author(s)
                </a>
                <a :href="'{{URL::to('/')}}/author/'+author.name.split(' ').join('_').toLowerCase()" class="list-group-item list-group-item-action" v-for="author in authors">@{{ author.name }} </a>
                 <a :href="'{{URL::to('/')}}/author/all'" class="list-group-item list-group-item-action" v-if="authors.length == 5">See all..</a>
            </div>
             <div class="w-100"></div>
            <div class="list-group col mt-2 ml-3">
                <a  class="list-group-item list-group-item-action active">
                    Top Categorie(s)
                </a>
                <a :href="'{{URL::to('/')}}/genre/'+genre.name.split(' ').join('_').toLowerCase()" class="list-group-item list-group-item-action" v-for="genre in categories">@{{ genre.name }} </a>
                <a href="{{ url('genre/all') }}" class="list-group-item list-group-item-action" v-if="categories.length == 5">See all..</a>

            </div>
        </div>
    </div>
    <!-- left side bar end -->
    <!-- right data content -->
    <div class="col-md-9 mt-2 mb-2">
        <div class="card">
          <div class="card-header">
            Search Result(s)
          </div>
          <div class="card-body">
            <div class="row ml-2">
                @if(1 != 0)
                    @foreach($books as $book)
                    <div class="card mr-3 mb-3 ml-1" style="width: 14rem;">
                      <img class="card-img-top" src="{{ URL::to($book['image_name']) }}" width="304" height="180" alt="Card image cap">
                      <div class="card-body">
                        <h5 class="card-title">{{ $book['name'] }}</h5>
                        <h3> Price -${{ $book['price'] }}</h3>                
                        <a href="{{URL::to('book/detail')}}/{{str_replace(' ','_',strtolower($book['name']))}}" class="btn btn-primary">View Detail</a>

                      </div>
                    </div>
                    @endforeach 
                @else
                <blockquote class="blockquote">
                  <p class="mb-0">No such book(s) right now.</p>
                </blockquote>
                @endif
            </div>
          </div>
        </div>
    </div>
    <!-- right data content end -->
</div>
@endsection

@section('scripts')
<script>
    const app = new Vue({
        el:'#home',
        data:{
            categories : {},
            authors : {},
            books : {}
        },
        methods: {
            getGenres(){
                axios.get(app_url+`/api/genre/take_5`)
                .then((response) =>{
                    this.categories = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getAuthors(){
                axios.get(app_url+`/api/author/take_5`)
                .then((response) =>{
                    this.authors = response.data;
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
                Echo.channel('author.new')
                .listen('NewAuthor',()=>{
                    this.getAuthors();
                });
                Echo.channel('author.edit')
                .listen('EditAuthor',()=>{
                    this.getAuthors();
                });
            }
        },
        mounted (){
            this.getGenres();
            this.getAuthors();
            this.listen();
        }
    })
</script>
@endsection
