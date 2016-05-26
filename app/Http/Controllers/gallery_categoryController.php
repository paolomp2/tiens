<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Console;
use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;

use Flash;
use Auth;
use Validator;

use tiens\Gallery_category;
use Session;
use Redirect;
use File;
class gallery_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Categories = Gallery_category::withTrashed()->where('id','>',1)->get();
        foreach ($Categories as $categoy) {
            $Created_by=$categoy->Created_by->get()->first();
            $categoy['Created_by']=$Created_by;
        }
        return view('gallery_category.index',compact('Categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gallery_category.create');
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
            return redirect('gallery_category/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $gallery_category = new Gallery_category;
        $gallery_category->name = $request->category_name;
        $gallery_category->created_by = Auth::user()->id;
        $gallery_category->save();

        return Redirect::to('/gallery_category');
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
        $category = Gallery_category::find($id);        

        return view('gallery_category.update',compact('category'));
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
            return redirect('gallery_category/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $gallery_category = Gallery_category::find($id);
        $gallery_category->name = $request->category_name;
        $gallery_category->created_by = Auth::user()->id;
        $gallery_category->save();

        return Redirect::to('/gallery_category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery_category = Gallery_category::find($id)->delete();
        return Redirect::to('/gallery_category');
    }

    public function inactive($id)
    {
        $gallery_category = Gallery_category::find($id)->delete();
        return Redirect::to('/gallery_category');
    }
    
    public function untrashed($id)
    {
        $gallery_category = Gallery_category::onlyTrashed()->find($id)->restore();
        return Redirect::to('/gallery_category');
    }
}
