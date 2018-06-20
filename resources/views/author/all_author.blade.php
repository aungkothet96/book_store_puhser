@extends('layouts.app')
@section('css')

@endsection
@section('content')
<div class="row mt-2" id="author_app">
   <div class="col-md-3">
        <div class="list-group col ">
            <a href="#" class="list-group-item list-group-item-action active">
                Author(s)
            </a>
            <a :href="'{{URL::to('/')}}/author/'+author.name.split(' ').join('_').toLowerCase()" class="list-group-item list-group-item-action" v-for="author in authors">@{{ author.name }} </a>
        </div>
    </div>
    <div class="col-md-9"> 
        <div class="row">
            @if($books->total() != 0)
                @foreach($books as $book)
                <div class="card mr-4 mb-3" style="width: 14rem;">
                  <img class="card-img-top" src="{{ URL::to($book->image_name) }}" width="304" height="180" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">{{ $book->name }}</h5>
                    <h3> Price -${{ $book->price }}</h3>                
                    <a href="{{URL::to('book/detail')}}/{{str_replace(' ','_',strtolower($book->name))}}" class="btn btn-primary">View Detail</a>

                  </div>
                </div>
                @endforeach 
            @else
            <blockquote class="blockquote">
              <p class="mb-0">No book(s) for such author.</p>
            </blockquote>
            @endif
        </div>
        <div class="float-right">
            {{ $books->links() }}
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
            books : {}
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
