@extends('layouts.app')
@section('css')

@endsection

@section('content')
 {{ Breadcrumbs::render('home') }}
<div class="row" id="home">
    <!-- left side bar -->
    <div class="col-md-3">
        <div class="row">
            <div class="list-group col mt-2 ml-3">
                <a class="list-group-item list-group-item-action active  ii-title">
                    Top Author(s)
                </a>
                <a :href="'{{URL::to('/')}}/author/'+author.name.split(' ').join('_').toLowerCase()" class="list-group-item list-group-item-action" v-for="author in authors">@{{ author.name }} </a>
                 <a :href="'{{URL::to('/')}}/author/all'" class="list-group-item list-group-item-action" v-if="authors.length == 5">See all..</a>
            </div>
             <div class="w-100"></div>
            <div class="list-group col mt-2 ml-3">
                <a  class="list-group-item list-group-item-action active ii-title">
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
            New Release Book(s)
          </div>
          <div class="card-body">
            <div class="row ml-2">
                <a :href="'{{URL::to('/')}}/book/detail/'+book.name.split(' ').join('_').toLowerCase()"  v-for="book in books" class="disable-link-color">
                    <div class="card mr-3  ml-1 mb-3" style="width: 14rem;">
                      <img class="card-img-top" :src="`{{ URL::to('') }}/`+ book.image_name.replace('images','images/thumbnail')" alt="@{{ book.name }}">
                      <div class="card-body">
                        <h5 class="card-title"> @{{ book.name }}</h5>
                        <h5 class="card-title">By @{{ book.authors.name }}</h5>
                        <label>USD - $@{{ book.price }}</label><br/>
                        <label>Downloads - @{{ book.download }} </label>                
                       </div>
                    </div>
                </a>
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
            getLatestBook(){
                axios.get(app_url+`/api/book/latest`)
                .then((response) =>{
                    this.books = response.data;
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
                Echo.channel('book.new')
                .listen('NewBook',()=>{
                    this.getLatestBook();
                });
            }
        },
        mounted (){
            this.getLatestBook();
            this.getGenres();
            this.getAuthors();
            this.listen();
        }
    })
</script>
@endsection
