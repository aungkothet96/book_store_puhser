<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use Illuminate\Http\Request;
use App\Events\NewAuthor;
use App\Events\EditAuthor;


class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::latest()->get();
        $books = Book::with('authors','genres')->paginate(9);
        return view('author.all_author',['authors' => $authors, 'books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_all()
    {
        $authors = Author::latest()->get();
        return view('author.show');
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
        $author = Author::create(['name'=>$request['name']]);
        /*Event boradcast need*/
        broadcast(new NewAuthor($author))->toOthers();
        return $author->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $name = str_replace("_", " ", $name);
        $id = $this->find_by_name($name);
        if (!empty($id)) {
            $authors = Author::latest()->get();
            $books = Book::with('authors','genres')->where('author_id',$id[0])->paginate(9);
            return view('author.all_author',['authors' => $authors, 'books' => $books]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return view('author.show',['author'=>$author->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $this->validate($request, [
        'name' => 'required',
          ]);
        $author = $author->update(['name'=>$request['name']]);
       /*Event boradcast need*/
        broadcast(new EditAuthor())->toOthers();

        return redirect('author\all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        //
        $author->delete();
        /*Event boradcast need*/
        broadcast(new EditAuthor())->toOthers();
        return redirect('author\all');
    }

    public function find_by_name($name)
    {
       $id = Author::where('name','like', "%{$name}%")->pluck('id')->toArray();
       return $id;
    }
    /*for api */
    public function api_author_get_all()
    {
        return response()->json(Author::latest()->get());
    }

    public function api_auhtor_take_5()
    {
        // dd(Author::latest()->take(5)->get());
        return response()->json(Author::latest()->take(5)->get());
    }
}
