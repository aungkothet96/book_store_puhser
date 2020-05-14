<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Book;
use Illuminate\Http\Request;
use App\Events\RefershGenre;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genre::latest()->get();
        $books = Book::paginate(9);
        return view('genre.all_genre',['genres' => $genres, 'books' => $books, 'title' => "Total"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_all()
    {
        $genres = Genre::latest()->get();
        return view('genre.show',['genres' => $genres]);       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'name' => 'required',
          ]);
        $genre = Genre::create(['name'=>$request['name']]);
        /*Event boradcast need*/
        broadcast(new RefershGenre())->toOthers();
        return $genre->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
   public function show($name)
    {
        $name = str_replace("_", " ", $name);
        $genre = $this->find_by_name($name);
        if ($genre) {
            $genres = Genre::latest()->get();
            $books = Book::with('authors','genres')->where('genre_id',$genre->id)->paginate(9);
            return view('genre.all_genre',['genres' => $genres, 'books' => $books, 'title' => $genre->name]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $genre)
    {
        return view('genre.show',['genre'=>$genre->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        $this->validate($request, [
        'name' => 'required',
          ]);
        $genre = $genre->update(['name'=>$request['name']]);
       /*Event boradcast need*/
        broadcast(new RefershGenre())->toOthers();

        return redirect('admin\genre\all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        /*Event boradcast need*/
        broadcast(new RefershGenre())->toOthers();
        return redirect('admin\genre\all');
    }
    
    public function find_by_name($name)
    {
       $id = Genre::where('name','like', "%{$name}%")->first();
       return $id;
    }

    /*for api */
    public function api_genre_get_all()
    {
        return response()->json(Genre::latest()->get());
    }

    public function api_genre_take_5()
    {
        return response()->json(Genre::latest()->take(5)->get());
    }
}
