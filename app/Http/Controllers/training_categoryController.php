<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Console;
use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;

use Flash;
use Auth;
use Validator;

use tiens\Training_category;
use Session;
use Redirect;
use File;
class training_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Categories = Training_category::withTrashed()->get();
        foreach ($Categories as $categoy) {
            $Created_by=$categoy->User;
            $categoy['Created_by']=$Created_by;
        }
        
        //echo dd($banners);
        return view('training_category.index',compact('Categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('training_category.create');
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
            return redirect('training_category/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $training_category = new Training_category;
        $training_category->name = $request->category_name;
        $training_category->created_by = Auth::user()->id;
        $training_category->save();

        return Redirect::to('/training_category');
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
        $category = Training_category::find($id);        

        return view('training_category.update',compact('category'));
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
            return redirect('training_category/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $training_category = Training_category::find($id);
        $training_category->name = $request->category_name;
        $training_category->created_by = Auth::user()->id;
        $training_category->save();

        return Redirect::to('/training_category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $training_category = Training_category::find($id)->delete();
        return Redirect::to('/training_category');
    }

    public function inactive($id)
    {
        $training_category = Training_category::find($id)->delete();
        return Redirect::to('/training_category');
    }
    
    public function untrashed($id)
    {
        $training_category = Training_category::onlyTrashed()->find($id)->restore();
        return Redirect::to('/training_category');
    }
}
