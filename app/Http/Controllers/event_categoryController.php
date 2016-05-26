<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Console;
use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;

use Flash;
use Auth;
use Validator;

use tiens\Notification;
use tiens\Event_category;
use Session;
use Redirect;
use File;
class event_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Categories = Event_category::withTrashed()->get();
        foreach ($Categories as $categoy) {
            $Created_by=$categoy->User;
            $categoy['Created_by']=$Created_by;
        }
        
        //echo dd($banners);
        return view('event_category.index',compact('Categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*Validator section*/
         $validator = Validator::make($request->all(), [
            'category_name' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return redirect('event_category/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $event_category = new Event_category;
        $event_category->name = $request->category_name;
        $event_category->created_by = Auth::user()->id;
        $event_category->save();

        $not = new Notification;
        $not->message = "Categoría de evento creado: ".$event_category->name;                    
        $not->save();

        return Redirect::to('/event_category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Event_category::find($id);

        $not = new Notification;
        $not->message = "Categoría de evento editado: ".$category->name;                    
        $not->save();

        return view('event_category.update',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*Validator section*/
         $validator = Validator::make($request->all(), [
            'category_name' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return redirect('event_category/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $event_category = Event_category::find($id);
        $event_category->name = $request->category_name;
        $event_category->created_by = Auth::user()->id;
        $event_category->save();

        return Redirect::to('/event_category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event_category = Event_category::find($id)->delete();
        return Redirect::to('/event_category');
    }

    public function inactive($id)
    {
        $event_category = Event_category::find($id)->delete();
        return Redirect::to('/event_category');
    }
    
    public function untrashed($id)
    {
        $event_category = Event_category::onlyTrashed()->find($id)->restore();
        return Redirect::to('/event_category');
    }
}
