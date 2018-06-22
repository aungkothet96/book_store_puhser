<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\Genre;
use App\Publisher;
use Storage;
use App\Events\NewBook;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('authors','genres')->get()->toJson();
        return view('book.show_all',['books'=>$books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
     $authors = Author::orderBy('name')->get()->toJson();
     $genres = Genre::orderBy('name')->get()->toJson();
     $publishers = Publisher::orderBy('name')->get()->toJson();
     return view('book.create',['authors' => $authors,'genres' => $genres, 'publishers' => $publishers]);
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
            'description' => 'required',
            'price' => 'required',
            'date' => 'required|date',
            'image' => 'required|mimes:jpg,png,jpeg',
            'pdf' => 'required|mimes:pdf',
            'author' => 'required',
            'genre' => 'required',
            'publisher' => 'required'
        ]);

        $image_path = Storage::putFile('public/images', $request->file('image'));
        $image_path = str_replace("public", "storage", $image_path);
        $pdf_path = Storage::putFile('public/pdfs', $request->file('pdf'));

        $book = Book::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'image_name' =>  $image_path,
            'pdf_name' => $pdf_path,
            'published_date' => $request['date'],
            'author_id' => $request['author'],
            'genre_id' => $request['genre'],
            'publisher_id' => $request['publisher']
        ]);
        broadcast(new NewBook($book))->toOthers();
        return $book->toJson();


        // $book = Book::create([]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $name = str_replace("_", " ", $name);
        $id = $this->find_by_name($name);
        if (!empty($id)) {
            $book = Book::with('authors','genres')->where('id',$id[0])->first()->toJson();
            return view('book.detail',[ 'book' => $book]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }

    public function download(Request $request,$id)
    {
        $book = Book::find($id);
        return Storage::download($book->pdf_name,$book->name.'.pdf');
    }
    public function find_by_name($name)
    {
       $id = Book::where('name','like', "%{$name}%")->pluck('id')->toArray();
       return $id;
    }

    /* For api */
    public function api_book_get_all()
    {
       return response()->json(Book::latest()->get());
    }

    public function api_book_get_latest()
    {
        return response()->json(Book::latest()->take(10)->get());
    }
}
