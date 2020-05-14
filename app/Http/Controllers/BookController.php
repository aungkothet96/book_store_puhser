<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\Genre;
use App\Publisher;
use Storage;
use Session;
use Image;
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
        return view('book.show_all', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
       //making thumbnail
        $img = Image::make($_FILES['image']['tmp_name']);
        $img->resize(300, 300);
        $thumbnail_path= str_replace("storage/images", "storage/images/thumbnail", $image_path);
        $img->save(public_path($thumbnail_path),100);

        $pdf_path = Storage::putFile('public/pdfs', $request->file('pdf'));

        $book = Book::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => number_format($request['price'], 2, '.', ''),
            'image_name' =>  $image_path,
            'pdf_name' => $pdf_path,
            'published_date' => $request['date'],
            'author_id' => $request['author'],
            'genre_id' => $request['genre'],
            'publisher_id' => $request['publisher']
        ]);
        broadcast(new NewBook($book))->toOthers();
        // $books = Book::with('authors','genres')->get()->toJson();
        // return view('book.show_all',['books'=>$books]);
        return redirect('admin/book/all');
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
            $book = Book::with('authors','genres','publishers')->where('id',$id[0])->first()->toJson();
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

        $authors = Author::orderBy('name')->get()->toJson();
        $genres = Genre::orderBy('name')->get()->toJson();
        $publishers = Publisher::orderBy('name')->get()->toJson();
        return view('book.edit',['authors' => $authors,'genres' => $genres, 'publishers' => $publishers, 'book' => $book]);
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'date' => 'required|date',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'pdf' => 'nullable|mimes:pdf',
            'author' => 'required',
            'genre' => 'required',
            'publisher' => 'required'
        ]);
        if ($request->file('image')) { 
            $image_path = Storage::putFile('public/images', $request->file('image'));
            $image_path = str_replace("public", "storage", $image_path);
            //making thumbnail
            $img = Image::make($_FILES['image']['tmp_name']);
            $img->resize(300, 300);
            $thumbnail_path= str_replace("storage/images", "storage/images/thumbnail", $image_path);
            $img->save(public_path($thumbnail_path),100);
        } else {
            $image_path = $book->image_name;
        }
        if($request->file('pdf')) {
            $pdf_path = Storage::putFile('public/pdfs', $request->file('pdf'));
        } else {
            $pdf_path = $book->pdf_name;
        }
       

        $book = $book->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => number_format($request['price'], 2, '.', ''),
            'image_name' =>  $image_path,
            'pdf_name' => $pdf_path,
            'published_date' => $request['date'],
            'author_id' => $request['author'],
            'genre_id' => $request['genre'],
            'publisher_id' => $request['publisher']
        ]);
        // broadcast(new NewBook($book))->toOthers();
        Session::flash('success','Book Edited Successfully!.');
        return redirect('admin/book/all');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        /*Event boradcast need*/
        // broadcast(new EditAuthor())->toOthers();
       Session::flash('success','Book Deleted Successfully!.');
        return redirect('admin/book/all');
    }

    public function download(Request $request,$id)
    {
        $book = Book::find($id);
        $book->download += 1;
        $book->save();
        return Storage::download($book->pdf_name,$book->name.'.pdf');
    }
/* out of date search method
    public function search(Request $request)
    {
        $booksByAuthor = Author::with('books')->where('name','like','%'.$request['query']."%")->get()->toArray();
        $booksByGenre = Genre::with('books')->where('name','like','%'.$request['query']."%")->get()->toArray();
        $booksByPublisher = Publisher::with('books')->where('name','like','%'.$request['query']."%")->get()->toArray();
        $booksByTitle = Book::where('name','like','%'.$request['query']."%")->get()->toArray();

        $resultBooks = array();
        if(!empty($booksByAuthor)) {
            foreach ($booksByAuthor as $key => $byAuthor) {
                if(!empty($byAuthor['books'])) {
                    foreach ($byAuthor['books'] as $value) {
                        $resultBooks[] = $value;
                    }
                }
            }
        }

        if(!empty($booksByGenre)) {
            foreach ($booksByGenre as $key => $byGenre) {
                 if(!empty($byGenre['books'])) {
                    foreach ($byGenre['books'] as $value) {
                        $resultBooks[] = $value;
                    }
                }
            }
        }

        if(!empty($booksByPublisher)) {
            foreach ($booksByPublisher as $key => $byPublisher) {
                 if(!empty($byPublisher['books'])) {
                    foreach ($byPublisher['books'] as $value) {
                        $resultBooks[] = $value;
                    }
                }
            }
        }

        if(!empty($booksByTitle)) { 
            foreach ($booksByTitle as $key => $value) {
                $resultBooks[] = $value;
            }   
        }

        $resultBooks = array_map("unserialize", array_unique(array_map("serialize", $resultBooks)));

        if(!empty($resultBooks)) {
            foreach ($resultBooks as $key => $book) {
                $resultBooks[$key]['authors'] = Author::find($book['author_id'])->toArray();
                $resultBooks[$key]['genres'] = Genre::find($book['genre_id'])->toArray();
            }
        }

        return view('book.search_result', ['books' => $resultBooks]);

    }
*/
    public function searchByScout(Request $request)
    {
        $result = Book::search($request['query'])->paginate(15);
        return view('book.search_result', ['books' => $result]);
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
        return response()->json(Book::with('authors','genres')->latest()->take(10)->get());
    }
}
