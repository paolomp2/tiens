<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Console;
use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;

use Flash;
use Auth;
use Validator;

use tiens\Video_category;
use Session;
use Redirect;
use File;
class video_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Categories = Video_category::withTrashed()->get();
        foreach ($Categories as $categoy) {
            $Created_by=$categoy->Created_by->get()->first();
            $categoy['Created_by']=$Created_by;
        }
        
        //echo dd($banners);
        return view('video_category.index',compact('Categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('video_category.create');
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
            return redirect('video_category/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $video_category = new Video_category;
        $video_category->name = $request->category_name;
        $video_category->created_by = Auth::user()->id;
        $video_category->save();

        return Redirect::to('/video_category');
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
        $category = Video_category::find($id);        

        return view('video_category.update',compact('category'));
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
            return redirect('video_category/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $video_category = Video_category::find($id);
        $video_category->name = $request->category_name;
        $video_category->created_by = Auth::user()->id;
        $video_category->save();

        return Redirect::to('/video_category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video_category = Video_category::find($id)->delete();
        return Redirect::to('/video_category');
    }

    public function inactive($id)
    {
        $video_category = Video_category::find($id)->delete();
        return Redirect::to('/video_category');
    }
    
    public function untrashed($id)
    {
        $video_category = Video_category::onlyTrashed()->find($id)->restore();
        return Redirect::to('/video_category');
    }
}
