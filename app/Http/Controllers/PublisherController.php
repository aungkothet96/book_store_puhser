<?php

namespace App\Http\Controllers;

use App\Publisher;
use Illuminate\Http\Request;
use App\Events\RefershPublisher;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publishers = Publisher::latest()->get();
        return view('publisher.show',['publishers' => $publishers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function show_all()
    {
        $publishers = Publisher::latest()->get();
        return view('publisher.show',['publishers' => $publishers]);       
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
        $publisher = Publisher::create(['name'=>$request['name']]);
        /*Event boradcast need*/
        broadcast(new RefershPublisher())->toOthers();
        return $publisher->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        return view('publisher.show',['publisher'=>$publisher->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publisher $publisher)
    {
        $this->validate($request, [
        'name' => 'required',
          ]);
        $publisher = $publisher->update(['name'=>$request['name']]);
       /*Event boradcast need*/
        broadcast(new RefershPublisher())->toOthers();

        return redirect('publisher\all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        //
        $publisher->delete();
        /*Event boradcast need*/
        broadcast(new RefershPublisher())->toOthers();
        return redirect('publisher\all');
    }

    /*for api */
    public function api_publisher_get_all()
    {
        return response()->json(Publisher::latest()->get());
    }
}
